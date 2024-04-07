<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!defined('G5_USE_SHOP') || !G5_USE_SHOP)
	die('<p>쇼핑몰 설치 후 이용해 주십시오.</p>');

include_once(G5_ADMIN_PATH.'/admin.lib.php');
include_once(G5_ADMIN_PATH.'/shop_admin/admin.shop.lib.php');

run_event('admin_common');

check_order_inicis_tmps();