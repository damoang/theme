<?php
$sub_menu = "800100";
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, 'w');

// clean the output buffer
ob_end_clean();

function sql_query_union($sql, $error=G5_DISPLAY_SQL_ERROR, $link=null) {
    global $g5;

    if(!$link)
        $link = $g5['connect_db'];

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query') && G5_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }

    return $result;
}

// 자료가 많을 경우 대비 설정변경
@ini_set('memory_limit', '-1');

// 새글 DB 전체 지우기
sql_query(" delete from {$g5['board_new_table']} ");

// 최근글 삭제일 체크
$sql_where = "";
if(isset($config['cf_new_del']) && $config['cf_new_del'] > 0) {
	$new_date = date('Y-m-d H:i:s', (G5_SERVER_TIME - $config['cf_new_del'] * 86400));
	$sql_where = " where wr_datetime >= '".$new_date."'";
}

// 자료 칼럼
$fields = 'wr_id, wr_parent, mb_id, wr_option, wr_comment, wr_datetime, wr_hit, wr_good, wr_nogood, wr_7, wr_9, wr_10';

// 보드그룹
$sql = array();
$result = sql_query(" select bo_table from {$g5['board_table']} ");
if($result) {
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		if(!isset($row['bo_table']) || !$row['bo_table']) 
			continue;

		$tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

		$sql[] = " (select '{$row['bo_table']}' as bo_table, $fields from $tmp_write_table $sql_where) ";
	}
}

$i = 0;
if(count($sql) > 0) {
	$result = sql_query_union(" select * from (".implode("UNION ALL", $sql).") as a order by wr_datetime ");
	if($result) {
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			$wr_is_comment = ($row['wr_id'] == $row['wr_parent']) ? 0 : 1;
			$wr_is_secret = strstr($row['wr_option'], 'secret') ? 1 : 0;

			if($wr_is_comment) {
				$sql_post = "";
			} else {
				$sql_post = " wr_hit = '{$row['wr_hit']}',
							  wr_comment = '{$row['wr_comment']}',
							  wr_good = '{$row['wr_good']}',
							  wr_nogood = '{$row['wr_nogood']}',
							  wr_image = '".addslashes($row['wr_10'])."',
							  wr_video = '".addslashes($row['wr_9'])."', ";
			}			

			sql_query("insert into {$g5['board_new_table']} 
							set bo_table = '{$row['bo_table']}',
								wr_id = '{$row['wr_id']}',
								wr_parent = '{$row['wr_parent']}',
								mb_id = '{$row['mb_id']}',
								wr_is_comment = '{$wr_is_comment}',
								wr_is_secret = '{$wr_is_secret}',
								{$sql_post}
								wr_singo = '".addslashes($row['wr_7'])."',
								bn_datetime = '{$row['wr_datetime']}' ", 1);
		}
	}
}

die('총 '.$i.'건의 새글 DB 복구 완료');