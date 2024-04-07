<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!IS_YC)
	die(NA_YC);

$it_id = (isset($_REQUEST['it_id']) && $_REQUEST['it_id']) ? safe_replace_regex($_REQUEST['it_id'], 'it_id') : '';

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

// 전체수에서는 신고 및 차단수 제외 안함
$row = sql_fetch(" select count(*) as cnt $sql_common ");
$total_count = isset($row['cnt']) ? (int)$row['cnt'] : 0;

// 썸네일
$thumb_w = (isset($thumb_w) && (int)$thumb_w > 0) ? $thumb_w : 400;

$list = array();
$result = sql_query(" select * $sql_common order by is_id desc limit $rows");
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$list[$i] = na_is_data($row, $thumb_w);
}

// 목록수
$list_cnt = $i;
