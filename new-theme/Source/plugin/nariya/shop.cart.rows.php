<?php 
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!IS_YC)
	die(NA_YC);

// 보관기간이 지난 상품 삭제
cart_item_clean();

$s_cart_id = preg_replace('/[^a-z0-9_\-]/i', '', get_session('ss_cart_id'));

// 삭제하기
if(isset($_REQUEST['it_id']) && $_REQUEST['it_id']) {

	$it_id = safe_replace_regex($_REQUEST['it_id'], 'it_id');

	// 장바구니 상품삭제
	sql_query(" delete from {$g5['g5_shop_cart_table']} where od_id = '{$s_cart_id}' and it_id = '{$it_id}' ");
}

// 선택필드 초기화
if ($s_cart_id)
	sql_query(" update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ");

$total_count = get_boxcart_datas_count();
$cart_datas = get_boxcart_datas(true);
$cart_datas = (is_array($cart_datas)) ? $cart_datas : array();

$i = 0;	
foreach($cart_datas as $row) {

	if(!isset($row['it_id']) || !$row['it_id'])
		continue;

	$it = get_shop_item($row['it_id'], true);

	if(!isset($it['it_id']) || !$it['it_id'])
		continue;

	$list[$i] = na_it_data($it);
	$i++;
}

$list_cnt = $i;