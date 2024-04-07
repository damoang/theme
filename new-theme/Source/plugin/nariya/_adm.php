<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
require_once G5_ADMIN_PATH . '/admin.lib.php';

if (isset($token)) {
	$token = @htmlspecialchars(strip_tags($token), ENT_QUOTES);
}

run_event('admin_common');