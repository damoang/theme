<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!IS_YC)
	die(NA_YC);

// 지우기
if (isset($_REQUEST['del']) && $_REQUEST['del']) {
	$tv_idx = (int)get_session("ss_tv_idx");
	for ($k=1;$k<=$tv_idx;$k++) {
		$sid = "ss_tv[".$k."]";
		unset($_SESSION[$sid]);
	}
	unset($_SESSION['ss_tv_idx']);
}

$list = array();
$total_count = get_view_today_items_count();
$tv_datas = get_view_today_items(true);
$tv_datas = (is_array($tv_datas)) ? $tv_datas : array();

$i = 0;	
foreach($tv_datas as $row) { 

	if(!isset($row['it_id']) || !$row['it_id'])
		continue;

	$it = get_shop_item($row['it_id'], true);

	if(!isset($it['it_id']) || !$it['it_id'])
		continue;

	$list[$i] = na_it_data($it);
	$i++;
}

$list_cnt = $i;