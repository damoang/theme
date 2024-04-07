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

	$iq_ajax = true;
} else {
	$iq_ajax = false;
}

$itemqa_list = G5_SHOP_URL."/itemqalist.php";
$itemqa_form = G5_SHOP_URL."/itemqaform.php?it_id=".$it_id;
$itemqa_formupdate = G5_SHOP_URL."/itemqaformupdate.php?it_id=".$it_id;

// 신고글 체크
$singo_write = na_singo_array('iqa', $it_id);
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
	$sql_where .= na_sql_find('iq_id', implode(',', $singo_write), 1);

$sql_common = " from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$it_id}' $sql_where ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 5;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select * $sql_common order by iq_id desc limit $from_record, $rows ";
$result = sql_query($sql);

$itemqa_skin = G5_SHOP_SKIN_PATH.'/itemqa.skin.php';

if(!file_exists($itemqa_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemqa_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemqa_skin);
}