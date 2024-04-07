<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');

include_once(LAYOUT_PATH.'/index.shop.php');

include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');