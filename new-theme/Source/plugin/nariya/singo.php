<?php
include_once('./_common.php');

// 신고글 구분
// sg_flag = 0 : 게시물(글, 댓글)
// sg_flag = 1 : 상품후기
// sg_flag = 2 : 상품문의

$error = $success = "";

function print_result($error, $success) {
	echo '{ "error": "' . $error . '", "success": "' . $success . '" }';
	exit;
}

if (!$is_member)
	print_result('회원만 가능합니다.', $success);

if (isset($_REQUEST['sg_table']) && ! is_array($_REQUEST['sg_table'])) {
    $sg_table = preg_replace('/[^a-z0-9_]/i', '', trim($_REQUEST['sg_table']));
    $sg_table = substr($sg_table, 0, 20);
} else {
    $sg_table = '';
}

$sg_id = (isset($_REQUEST['sg_id'])) ? (int)$_REQUEST['sg_id'] : 0;

$sg_type = isset($_POST['sg_type']) ? (int)$_POST['sg_type'] : 0;
if (!$sg_type)
	print_result('신고 사유를 선택해 주세요.', $success);

$sg_desc = '';
if (isset($_POST['sg_desc'])) {
	$sg_desc = preg_replace("#[\\\]+$#", "", substr(trim($_POST['sg_desc']),0,65536));
	if (substr_count($sg_desc, '&#') > 50)
		print_result('추가 내용에 올바르지 않은 코드가 다수 포함되어 있습니다.', $success);
}

$sg_flag = isset($_POST['sg_flag']) ? (int)$_POST['sg_flag'] : 0;
switch($sg_flag) {
	case '1' : $text = '사용후기'; break;
	case '2' : $text = '상품문의'; break;
	default	 : $text = '해당 게시판의 게시물'; $sg_flag = 0; break;
}

$row = sql_fetch(" select id from {$g5['na_singo']} where mb_id = '{$member['mb_id']}' and sg_table = '$sg_table' and sg_id = '$sg_id' and sg_flag = '{$sg_flag}' ");
if(isset($row['id']) && $row['id'])
	print_result('이미 신고하신 '.$text.' 입니다.', $success);

$sg_parent = 0;
$sql_sg_table = '';
if($sg_flag == "1") { 
	
	// 상품후기
	$write = sql_fetch("select * from `{$g5['g5_shop_item_use_table']}` where it_id = '{$sg_table}' and is_id = '{$sg_id}' and is_confirm = '1' ");

	if (!isset($write['is_id']) || !$write['is_id'])
		print_result('존재하지 않는 '.$text.' 입니다.', $success);

	// 자료 정리
	$wr_time = $write['is_time'];

} else if($sg_flag == "2") { // 상품문의

	// 상품후기
	$write = sql_fetch("select * from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$sg_table}' and iq_id = '{$sg_id}' ");

	if (!isset($write['iq_id']) || !$write['iq_id'])
		print_result('존재하지 않는 '.$text.' 입니다.', $success);

	// 자료 정리
	$wr_time = $write['iq_time'];

} else {

	// 게시물
	$write_table = $g5['write_prefix'] . $sg_table; 
	$write = get_write($write_table, $sg_id);

	if (!isset($write['wr_id']) || !$write['wr_id'])
		print_result('존재하지 않는 '.$text.' 입니다.', $success);

    if (strstr($write['wr_option'], 'secret'))
		print_result('비밀글은 신고할 수 없습니다.', $success);

	// 자료 정리
	$sql_sg_table = "and sg_table = '{$sg_table}' ";
	$sg_parent = $write['wr_parent'];
	$wr_time = $write['wr_datetime'];
}

if ($write['mb_id'] && $write['mb_id'] == $member['mb_id'])
	print_result('자신의 글을 신고할 수는 없습니다.', $success);

if($write['mb_id']) {
	if ($config['cf_admin'] == $write['mb_id'])
		print_result('최고관리자 글은 신고할 수 없습니다.', $success);

	$gr = sql_fetch(" select gr_id {$g5['group_table']} where gr_admin = '{$write['mb_id']}' ");
	if(isset($gr['gr_id']) && $gr['gr_id'])
		print_result('그룹관리자 글은 신고할 수 없습니다.', $success);

	$bo = sql_fetch(" select bo_table {$g5['board_table']} where bo_admin = '{$write['mb_id']}' ");
	if(isset($bo['bo_table']) && $bo['bo_table'])
		print_result('게시판관리자 글은 신고할 수 없습니다.', $success);
}

$row = sql_fetch(" select count(*) as cnt from {$g5['na_singo']} where mb_id = '{$member['mb_id']}' and sg_flag = '{$sg_flag}' {$sql_sg_table}");
if(isset($row['cnt']) && $row['cnt'] >= NA_MAX_SINGO)
	print_result($text.' 신고 한도 '.NA_MAX_SINGO.'개를 초과하였습니다.<br><br>신고글 관리에서 '.$text.' 내역을 정리하신 후 다시 신고해 주세요.', $success);

// 신고 등록
sql_query(" insert into {$g5['na_singo']}
				set mb_id		= '{$member['mb_id']}',
					sg_flag		= '$sg_flag',
					sg_table	= '$sg_table',
					sg_id		= '{$sg_id}',
					sg_parent	= '{$sg_parent}',
					sg_type		= '$sg_type',
					sg_desc		= '$sg_desc',
					wr_time		= '{$wr_time}',
					sg_time		= '".G5_TIME_YMDHIS."' ");

// 게시물 잠금
$is_lock = isset($nariya['singo']) ? (int)$nariya['singo'] : 0;
if(!$sg_flag && $is_lock) {
	$row = sql_fetch(" select count(*) as cnt from {$g5['na_singo']} where sg_table = '$sg_table' and sg_id = '$sg_id' and sg_flag = '0' ");
	$wr_7 = isset($row['cnt']) ? (int)$row['cnt'] : 0;
	if($wr_7) {
		$wr_7 = ($wr_7 >= $is_lock) ? 'lock' : $wr_7;
		sql_query(" update $write_table set wr_7 = '$wr_7' where wr_id = '$sg_id' ");

		// 새글
		if($board['bo_use_search'] && !$write['wr_is_comment'] && na_check_new($write['wr_datetime'])) {
			sql_query(" update {$g5['board_new_table']} set wr_singo = '{$wr_7}' where bo_table = '{$sg_table}' and wr_id = '{$sg_id}' ");
		}
	}
}

print_result($error, $text.' 신고를 완료했습니다.');