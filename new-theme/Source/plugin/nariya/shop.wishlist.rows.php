<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!IS_YC)
	die(NA_YC);

if($is_guest)
	die('<i class="bi bi-person-circle"></i> 로그인한 회원만 가능합니다.');

$list = array();

$total_count = get_wishlist_datas_count();
$wishlist_datas = get_wishlist_datas($member['mb_id'], true);
$wishlist_datas = (is_array($wishlist_datas)) ? $wishlist_datas : array();

$i = 0;	
foreach($wishlist_datas as $row) {

	if(!isset($row['it_id']) || !$row['it_id'])
		continue;

	$it = get_shop_item($row['it_id'], true);

	if(!isset($it['it_id']) || !$it['it_id'])
		continue;

	$list[$i] = na_it_data($it);
	$i++;
}

$list_cnt = $i;