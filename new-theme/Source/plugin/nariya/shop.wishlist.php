<?php
include_once('./_common.php');
include_once(NA_PATH.'/_shop.php');

$error = $success = "";

function print_result($error, $success) {
	echo '{ "error": "' . $error . '", "success": "' . $success . '" }';
	exit;
}

if (!IS_YC)
	print_result(NA_YC, $success);

if (!$is_member)
	print_result('회원만 가능합니다.', $success);

$it_id = isset($_REQUEST['it_id']) ? safe_replace_regex($_REQUEST['it_id'], 'it_id') : '';

if(!$it_id)
	print_result('상품 코드가 올바르지 않습니다.', $success);

// 상품정보 체크
$row = get_shop_item($it_id, true);

if(!$row['it_id'])
	print_result('상품정보가 존재하지 않습니다.', $success);

$row = sql_fetch(" select wi_id from {$g5['g5_shop_wish_table']} where mb_id = '{$member['mb_id']}' and it_id = '$it_id' ");
if (!(isset($row['wi_id']) && $row['wi_id'])) {
	$sql = " insert {$g5['g5_shop_wish_table']}
						set mb_id = '{$member['mb_id']}',
							it_id = '$it_id',
							wi_time = '".G5_TIME_YMDHIS."',
							wi_ip = '".$_SERVER['REMOTE_ADDR']."' ";
	sql_query($sql);

	print_result($error, '위시리스트에 등록하였습니다.');
} else {
	print_result('위시리스트에 이미 등록된 상품입니다.', $success);

}