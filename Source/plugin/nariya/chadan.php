<?php
include_once('./_common.php');

$error = $success = "";

function print_result($error, $success) {
	echo '{ "error": "' . $error . '", "success": "' . $success . '" }';
	exit;
}

if (!$is_member)
	print_result('회원만 가능합니다.', $success);


if (!isset($member['as_chadan']))
	print_result('[E1]오류가 발생했습니다.', $success);

$mb_id = (isset($_REQUEST['mb']) && $_REQUEST['mb']) ? trim($_REQUEST['mb']) : '';

if ($member['mb_id'] === $mb_id)
	print_result('자기 자신을 차단할 수는 없습니다.', $success);

// 회원정보
$info = get_member($mb_id);

if (!isset($info['mb_id']) || !$info['mb_id'])
	print_result('등록된 회원이 아닙니다.', $success);

// 기존 차단회원
$mbs = na_explode(',', $member['as_chadan']);

if(in_array($mb_id, $mbs))
	print_result('이미 차단한 회원입니다.', $success);

if(count($mbs) >= NA_MAX_CHADNA)
	print_result(NA_MAX_CHADNA.'명 까지만 차단 회원 등록이 가능합니다.', $success);

if ($config['cf_admin'] == $mb_id)
	print_result('최고관리자는 차단할 수 없습니다.', $success);

$gr = sql_fetch(" select gr_id {$g5['group_table']} where gr_admin = '{$mb_id}' ");
if(isset($gr['gr_id']) && $gr['gr_id'])
	print_result('그룹관리자는 차단할 수 없습니다.', $success);

$bo = sql_fetch(" select bo_table {$g5['board_table']} where bo_admin = '{$mb_id}' ");
if(isset($bo['bo_table']) && $bo['bo_table'])
	print_result('게시판관리자는 차단할 수 없습니다.', $success);

// 회원 추가
array_push($mbs, $mb_id);

// 문자열로 전환
$str_mbs = implode(',', $mbs);

// 내 정보 업데이트
$sql = " update {$g5['member_table']} set as_chadan = '".addslashes($str_mbs)."' where mb_id = '{$member['mb_id']}' ";
sql_query($sql);

print_result($error, '차단하였습니다.');