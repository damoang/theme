<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_COMMUNITY_USE === false) {
	include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
	return;
}

include_once(LAYOUT_PATH.'/tail.php');

// SEO 메타 출력
define('_SEOMETA_', true);
include_once(G5_THEME_PATH.'/tail.sub.php');