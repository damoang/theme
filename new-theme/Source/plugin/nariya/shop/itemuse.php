<?php
if (!defined('_GNUBOARD_')) {
	include_once('./_common.php');
	include_once(NA_PATH.'/_shop.php');

	$it_id = isset($_REQUEST['it_id']) ? safe_replace_regex($_REQUEST['it_id'], 'it_id') : '';

	if( !isset($it) && !get_session("ss_tv_idx") ){
		if( !headers_sent() ){  //헤더를 보내기 전이면 검색엔진에서 제외합니다.
			echo '<meta name="robots" content="noindex, nofollow">';
	    }
	}

	$is_ajax = true;
} else {
	$is_ajax = false;
}

$itemuse_list = G5_SHOP_URL."/itemuselist.php";
$itemuse_form = G5_SHOP_URL."/itemuseform.php?it_id=".$it_id;
$itemuse_formupdate = G5_SHOP_URL."/itemuseformupdate.php?it_id=".$it_id;

// 신고글 체크
$singo_write = na_singo_array('iuse', $it_id);
$singo_count = count($singo_write);

// 차단회원 체크
$chadan_list = ($is_member && isset($member['as_chadan']) && trim($member['as_chadan'])) ? na_explode(',', $member['as_chadan']) : array();
$chadan_count = count($chadan_list);

// 차단회원글 제외
$sql_where = '';
if ($chadan_count)
	$sql_where .= na_sql_find('mb_id', trim($member['as_chadan']), 1);

// 신고글 제외
if ($singo_count)
	$sql_where .= na_sql_find('is_id', implode(',', $singo_write), 1);

$sql_common = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' $sql_where ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 5;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select * $sql_common order by is_id desc limit $from_record, $rows ";
$result = sql_query($sql);

$itemuse_skin = G5_SHOP_SKIN_PATH.'/itemuse.skin.php';

if(!file_exists($itemuse_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemuse_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemuse_skin);
}