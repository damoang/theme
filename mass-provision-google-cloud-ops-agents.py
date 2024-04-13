#!/usr/bin/env python3
# TODO(b/184371597): Add automated test.
"""Agent provisioning script to install ops agents on a fleet of VMs.

Sample usage: python3 mass-provision-google-cloud-ops-agents.py --file vms.csv

vms.csv:
"projects/sophieyfang-test/zones/us-central1-a/instances/centos8-1","[{""type"":""logging"",""version"":""1.*.*""},{""type"":""metrics"",""version"":""6.*.*""}]"
"projects/sophieyfang-test/zones/us-central1-a/instances/centos8-2","[{""type"":""logging"",""version"":""1.*.*""},{""type"":""metrics"",""version"":""6.*.*""}]"
"projects/sophieyfang-test/zones/us-central1-a/instances/centos8-3","[{""type"":""logging"",""version"":""1.*.*""},{""type"":""metrics"",""version"":""6.*.*""}]"
"projects/sophieyfang-test/zones/us-central1-a/instances/centos8-4","[{""type"":""ops-agent"",""version"":""1.*.*""}]"
"projects/sophieyfang-test/zones/us-central1-a/instances/centos8-5","[{""type"":""ops-agent"",""version"":""1.*.*""}]"
"""
import argparse
import collections
import csv
import dataclasses
import datetime
import enum
import json
import logging
import os
import re
import subprocess
import sys
import time
from typing import Any, Dict, Iterable, List, Tuple


_logger = logging.getLogger(__name__)


class EntriesValidationError(Exception):
  """Base exception for entries validation exception."""


class InstanceFullNameInvalidError(Exception):
  """Base exception for instance full name is invalid."""


class InstanceEntriesDuplicateError(Exception):
  """Base exception for instance full name appears in more than one entry."""


class AgentRuleParseError(Exception):
  """Base exception for agent rule cannot be parsed."""


class AgentRuleInvalidError(Exception):
  """Base exception for agent rule is invalid."""


class AgentType(str, enum.Enum):
  LOGGING = "logging"
  METRICS = "metrics"
  OPS_AGENT = "ops-agent"


@dataclasses.dataclass(frozen=True)
class InstanceInfo:
  """InstanceInfo contains instance related information.

  Attributes:
    project: str, project name.
    zone: str, zone name.
    instance: str, instance name.
  """
  project: str
  zone: str
  instance: str

  def __str__(self) -> str:
    return f"projects/{self.project}/zones/{self.zone}/instances/{self.instance}"

  def AsFilename(self) -> str:
    return f"{self.project}_{self.zone}_{self.instance}"


@dataclasses.dataclass
class InstanceProcess:
  instance_info: InstanceInfo
  agent_types: List[str]
  process: Any
  agents_status: Dict[str, str] = dataclasses.field(default_factory=dict)
  log_file: str = None
  out_content: str = None

_AGENT_VERSION_LATEST = "latest"
_PINNED_MAJOR_VERSION_RE = re.compile(r"^\d+\.\*\.\*$")
_PINNED_VERSION_RE = re.compile(r"^\d+\.\d+\.\d+$")
_INSTALL_COMMAND = (
    "curl -sSO https://dl.google.com/cloudagents/{script_name}; "
    "sudo bash {script_name} --also-install {install_version} "
    "{additional_flags}; "
    "{start_agent}; "
    "for i in {{1..3}}; do if (ps aux | grep 'opt[/].*{agent}.*bin/'); "
    "then echo '{agent} runs successfully.'; break; fi; sleep 1s; done"
)


@dataclasses.dataclass(frozen=True)
class AgentDetail:
  name: str
  repo_script: str
  start_agent_script: str
  additional_install_flags: str

_AGENT_DETAILS = {
    AgentType.LOGGING: AgentDetail(
        name="google-fluentd",
        repo_script="add-logging-agent-repo.sh",
        start_agent_script="sudo service google-fluentd start",
        additional_install_flags=""),
    AgentType.METRICS: AgentDetail(
        name="stackdriver-agent",
        repo_script="add-monitoring-agent-repo.sh",
        start_agent_script="sudo service stackdriver-agent start",
        additional_install_flags=""),
    AgentType.OPS_AGENT: AgentDetail(
        name="google-cloud-ops-agent",
        repo_script="add-google-cloud-ops-agent-repo.sh",
        # The Ops Agent starts the services automatically.
        # The colon (:) is the bash no-op operator.
        start_agent_script=":",
        additional_install_flags="--uninstall-standalone-logging-agent --uninstall-standalone-monitoring-agent"),
}


def _ValidateInstancesDuplication(instances: Iterable[str]) -> None:
  duplicate_instances = sorted(
      k for k, v in collections.Counter(instances).items() if v > 1)
  if duplicate_instances:
    raise InstanceEntriesDuplicateError("\n".join([
        "Instance - %s has more than one record in the file. Please "
        "have at most one entry per instance." % instance
        for instance in duplicate_instances
    ]))


def _ValidateAgentTypes(agent_rules: Iterable[Dict[str, str]]) -> List[str]:
  """Validates types of agent rules."""
  agent_types = collections.Counter(r["type"] for r in agent_rules)
  duplicate_types = sorted(k for k, v in agent_types.items() if v > 1)
  errors = [
      "At most one agent with type [%s] is allowed." % t
      for t in duplicate_types
  ]
  # When agent type is ops agent, it has to be the only agent type.
  if agent_types[AgentType.OPS_AGENT] > 0 and sum(agent_types.values()) > 1:
    errors.append(
        "An agent with type [%s] is detected. No other agent type is allowed. "
        "The Ops Agent has both a logging module and a metrics module already."
        % AgentType.OPS_AGENT)
  return errors


def _ValidateAgentVersion(version: str) -> List[str]:
  """Validates agent version."""
  if version == _AGENT_VERSION_LATEST:
    return []

  valid_pin_res = {
      _PINNED_MAJOR_VERSION_RE,
      _PINNED_VERSION_RE,
  }
  if any(regex.search(version) for regex in valid_pin_res):
    return []
  return [
      "The agent version %s is not allowed. Expected values: [latest] or "
      "anything in the format of [MAJOR_VERSION.MINOR_VERSION.PATCH_VERSION] "
      "or [MAJOR_VERSION.*.*]." % version
  ]


def _ExtractAgentRules(instance: str, agent_rules: str) -> List[Dict[str, str]]:
  """Extracts agent rules from string blob.

  Args:
    instance: instance full name,
      e.g. projects/sample-project/zones/us-central1-a/instances/centos8-test.
    agent_rules: agent rules, e.g. [{"type":"logging","version":"6.1.0"}].

  Raises:
    AgentRuleParseError: agent rule cannot be parsed.

  Returns:
    A list of agent rule dict.
  """
  try:
    decoded_rules = json.loads(agent_rules)
  except ValueError as e:
    raise AgentRuleParseError("Instance - %s has invalid agent_rules %s -- %s."
                              % (instance, agent_rules, e))

  if not decoded_rules:
    raise AgentRuleParseError(
        "Instance - %s requires at least one agent rule." % instance)
  type_errors = []
  for agent_rule in decoded_rules:
    if "type" not in agent_rule:
      type_errors.append(
          "Instance - %s has agent rules that is missing required `type` field."
          % instance)
  if type_errors:
    raise AgentRuleParseError("\n".join(type_errors))
  return decoded_rules


def _ParseAndValidateAgentRules(instance: str,
                                agent_rules: str) -> List[Dict[str, str]]:
  """Parses and validates agent rules.

  Args:
    instance: instance full name.
    agent_rules: agent rules.

  Raises:
    AgentRuleInvalidError: agent rules are invalid.

  Returns:
    a list of parsed agent rules.
  """
  errors = []
  try:
    agent_rule_list = _ExtractAgentRules(instance, agent_rules)
  except AgentRuleParseError as e:
    raise AgentRuleInvalidError(str(e))
  errors.extend(_ValidateAgentTypes(agent_rule_list))
  for agent_rule in agent_rule_list:
    if "version" in agent_rule:
      errors.extend(_ValidateAgentVersion(agent_rule["version"]))
  if errors:
    raise AgentRuleInvalidError("Instance - %s: %s" % (instance, " | ".join(
        str(error) for error in errors)))
  return agent_rule_list


def _ParseAndValidateInstanceFullName(instance: str) -> InstanceInfo:
  instance_details = re.match(
      r"^projects\/([\w-]+)\/zones\/([\w-]+)\/instances\/([\w-]+)$", instance)
  if not instance_details:
    raise InstanceFullNameInvalidError("Instance - %s has invalid instance full"
                                       " name" % instance)
  project, zone, instance = instance_details.groups()
  return InstanceInfo(project, zone, instance)


def _StartProcess(parsed_instance_name: InstanceInfo,
                  agent_rules: Iterable[Dict[str, str]],
                  log_dir: str) -> InstanceProcess:
  """Starts process on executing commands on instance.

  Args:
    parsed_instance_name: instance full name, e.g.
      (sample-project,us-central1-a,centos8-test).
    agent_rules: agent rules, e.g.
      [{"type":"logging","version":"6.1.0"}].
    log_dir: directory for script logs, e.g.
      "./google_cloud_ops_agent_provisioning/".

  Returns:
    launched instance process.
  """
  commands = []
  commands.append('echo "$(date -Ins) Starting running commands."')
  for agent_rule in agent_rules:
    agent_details = _AGENT_DETAILS[agent_rule["type"]]
    command = _INSTALL_COMMAND.format(
        script_name=agent_details.repo_script,
        install_version=(f"--version={agent_rule['version']}"
                         if "version" in agent_rule else ""),
        start_agent=agent_details.start_agent_script,
        additional_flags=agent_details.additional_install_flags,
        agent=agent_details.name)
    commands.append(command)
  commands.append('echo "$(date -Ins) Finished running commands."')
  ssh_command = ("gcloud", "compute", "ssh", parsed_instance_name.instance,
                 "--project", parsed_instance_name.project,
                 "--zone", parsed_instance_name.zone,
                 # Default Cloudshell has no SSH keys, so use `quiet` flag to
                 # generate one with an empty passphrase.
                 "--quiet",
                 # Disable this check for the race condition in the gcloud
                 # KnownHosts check. We are using the key for short duration
                 # here.
                 "--strict-host-key-checking=no",
                 "--ssh-flag", "'-o ConnectTimeout=20'",
                 "--command", '"%s"' %
                 ";".join(commands).replace("\\", "\\\\").replace('"', r'\"'))
  final_command = " ".join(ssh_command)
  _logger.info("Instance: %s - Starting process to run command: %s.",
               parsed_instance_name.instance, final_command)
  instance_file = os.path.join(log_dir,
                               f"{parsed_instance_name.AsFilename()}.log")
  process = subprocess.Popen(
      args=final_command,
      shell=True,
      stderr=subprocess.STDOUT,
      stdout=subprocess.PIPE)
  return InstanceProcess(
      instance_info=parsed_instance_name,
      agent_types={agent_rule["type"] for agent_rule in agent_rules},
      process=process,
      log_file=instance_file)


def _Bold(content: str) -> str:
  return f"\033[1m{content}\033[0m"


def _DisplayProgressBar(iteration: int,
                        total: int,
                        prefix: str = "",
                        suffix: str = "",
                        decimals: int = 1,
                        length: int = 100) -> None:
  """Displays progress bar.

  Args:
    iteration: int, current task index.
    total: int, total counts.
    prefix: str, prefix of progress bar.
    suffix: str, suffix of progress bar.
    decimals: int, number of digits after decimals.
    length: int, progress bar length
  """
  percent_format = "{0:.%d%%}" % decimals
  percent = percent_format.format(iteration / total)
  filled_length = length * iteration // total
  bar = "=" * filled_length + "-" * (length - filled_length)
  con = "\r" + _Bold("%s |%s| %s %s" % (prefix, bar, percent, suffix))
  print(con, end="\r" if iteration != total else None)


def _WithRate(numerator: int, denominator: int) -> str:
  return "[{numerator}/{denominator}] ({rate:.1%})".format(
      numerator=numerator, denominator=denominator,
      rate=numerator/denominator)


def _WriteProcessOutputToFileAndPrintInstanceStatus(
    instance_processes: List[InstanceProcess]) -> None:
  """Writes instance process output into file and prints out instance status in console."""
  print("---------------------Getting output-------------------------")
  success = 0
  failure = 0
  total_processes = len(instance_processes)
  _DisplayProgressBar(
      0, total_processes, prefix="Progress:", suffix="Complete", length=50)
  for i, instance_process in enumerate(instance_processes):
    completed = i + 1
    # Set each instance process to timeout after 10 mins.
    try:
      outs, _ = instance_process.process.communicate(timeout=600)
    except subprocess.TimeoutExpired:
      instance_process.process.kill()
      outs, _ = instance_process.process.communicate()
    instance_process.out_content = outs.decode("utf-8")
    with open(instance_process.log_file, "w") as f:
      f.write("Installing %s\n" %
              ",".join(sorted(instance_process.agent_types)))
      f.write(instance_process.out_content)
    per_agent_success = {
        t: "\n%s runs successfully.\n" % _AGENT_DETAILS[t].name
           in instance_process.out_content
        for t in instance_process.agent_types
    }

    for agent_type, agent_success in per_agent_success.items():
      instance_process.agents_status[agent_type] = (
          "successfully runs" if agent_success else _Bold("fails to run"))
    if all(per_agent_success.values()):
      success += 1
    else:
      failure += 1

    _DisplayProgressBar(
        completed,
        total_processes,
        prefix="Progress:",
        suffix=f"{_WithRate(completed, total_processes)} completed; "
        f"{_WithRate(success, completed)} succeeded; "
        f"{_WithRate(failure, completed)} failed;",
        length=50)
  for instance_process in instance_processes:
    for agent_type, agent_status in instance_process.agents_status.items():
      print("Instance: %s %s %s. See log file in: %s" %
            (instance_process.instance_info, agent_status, agent_type,
             instance_process.log_file))
  print()
  print(_Bold(f"SUCCEEDED: {_WithRate(success, total_processes)}"))
  print(_Bold(f"FAILED: {_WithRate(failure, total_processes)}"))
  print(_Bold(f"COMPLETED: {_WithRate(completed, total_processes)}"))
  print()


def _ParseAndValidateEntries(
    entries: List[Tuple[str, str]]
) -> List[Tuple[InstanceInfo, List[Dict[str, str]]]]:
  """Parses and validates entries.

  Args:
    entries: list of tuple(instance name, agent rules)

  Raises:
    EntriesValidationError: entry doesn't pass validation.

  Returns:
    a list of parsed entries.
  """
  error_msgs = []
  parsed_entries = []
  for instance_full_name, agent_rules in entries:
    instance_error_msgs = []
    try:
      parsed_instance_name = _ParseAndValidateInstanceFullName(
          instance_full_name)
    except InstanceFullNameInvalidError as e:
      instance_error_msgs.append(str(e))
    try:
      parsed_agent_rules = _ParseAndValidateAgentRules(instance_full_name,
                                                       agent_rules)
    except AgentRuleInvalidError as e:
      instance_error_msgs.append(str(e))
    if not instance_error_msgs:
      parsed_entries.append((parsed_instance_name, parsed_agent_rules))
    error_msgs.extend(instance_error_msgs)
  try:
    _ValidateInstancesDuplication(
        instance_full_name for instance_full_name, _ in entries)
  except InstanceEntriesDuplicateError as e:
    error_msgs.append(str(e))
  if error_msgs:
    raise EntriesValidationError("\n".join(error_msgs))
  return parsed_entries


def _ReadEntriesFromFile(file_name: str) -> List[Tuple[str, str]]:
  """Reads row entries reading from file.

  Args:
    file_name: str, file name.

  Returns:
    entries in list.
  """
  entries = []
  with open(file_name, "r") as f:
    full_input = f.read()
    _logger.debug("Input file content:\n%s", full_input)
    entries_reader = csv.reader(full_input.split("\n"))
    for entry in entries_reader:
      if not entry:
        continue
      try:
        instance_full_name, agent_rules = entry
      except ValueError:
        raise Exception(
            "Incorrect entry %s. "
            'Expected format: `"instance_full_name","agent_rules"`.' % entry)
      entries.append((instance_full_name.strip(), agent_rules.strip()))
  return entries


def main():
  start_time = time.time()
  _logger.debug("Args passed to the script: %s", sys.argv[1:])
  parser = argparse.ArgumentParser()
  required = parser.add_argument_group("required arguments")
  required.add_argument(
      "--file",
      action="store",
      dest="vms_file",
      required=True,
      help="The path of the input CSV file that contains a list of VMs to "
      "provision the agent on.")
  args = parser.parse_args()

  _logger.setLevel(logging.INFO)
  log_dir = os.path.join(
      ".", "google_cloud_ops_agent_provisioning",
      f"{datetime.datetime.utcnow():%Y%m%d-%H%M%S_%f}")
  os.makedirs(log_dir, exist_ok=True)
  script_log_file = os.path.join(log_dir, "wrapper_script.log")
  fh = logging.FileHandler(script_log_file)
  formatter = logging.Formatter(
      fmt="%(asctime)s.%(msecs)03d %(levelname)s %(message)s",
      datefmt="%Y-%m-%dT%H:%M:%S")
  formatter.converter = time.gmtime
  fh.setFormatter(formatter)
  _logger.addHandler(fh)

  _logger.info("Starting to read entries from file %s.", args.vms_file)
  entries = _ReadEntriesFromFile(args.vms_file)
  _logger.info("Finished reading entried from file %s.", args.vms_file)
  try:
    _logger.info("Starting to parse and validate entries.")
    parsed_entries = _ParseAndValidateEntries(entries)
    _logger.info("Parsed and validated all entries successfully.")
  except EntriesValidationError as e:
    _logger.error("Some entries are invalid or malformed:\n%s", e)
    print("ERROR:\n%s" % e)
    return
  print(f"See log files in folder: {log_dir}")
  instance_processes = []
  _logger.info("Starting tasks on instances.")
  for parsed_instance_name, agent_rules in parsed_entries:
    _logger.info("Starting process on instance: %s.", parsed_instance_name)
    print(f"{datetime.datetime.utcnow():%Y-%m-%dT%H:%M:%S.%fZ} "
          f"Processing instance: {parsed_instance_name}.")
    instance_processes.append(
        _StartProcess(parsed_instance_name, agent_rules, log_dir))
  _WriteProcessOutputToFileAndPrintInstanceStatus(instance_processes)
  stop_time = time.time()
  _logger.info("Processed %d VMs in %s seconds.", len(parsed_entries),
               stop_time - start_time)


if __name__ == "__main__":
  main()
