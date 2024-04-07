<?php
$sub_menu = "800100";
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, 'w');

$na_db_set = na_db_set();

$is_check = false;

// 알림
if(!sql_query(" DESC {$g5['na_noti']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_noti']}` (
				  `ph_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `ph_to_case` varchar(50) NOT NULL DEFAULT '',
				  `ph_from_case` varchar(50) NOT NULL DEFAULT '',
				  `bo_table` varchar(20) NOT NULL DEFAULT '',
				  `rel_bo_table` varchar(20) NOT NULL DEFAULT '',
				  `wr_id` int(11) NOT NULL DEFAULT 0,
				  `rel_wr_id` int(11) NOT NULL DEFAULT 0,
				  `mb_id` varchar(255) NOT NULL DEFAULT '',
				  `rel_mb_id` varchar(255) NOT NULL DEFAULT '',
				  `rel_mb_nick` varchar(255) DEFAULT NULL,
				  `rel_msg` varchar(255) NOT NULL DEFAULT '',
				  `rel_url` varchar(200) NOT NULL DEFAULT '',
				  `ph_readed` char(1) NOT NULL DEFAULT 'N',
				  `ph_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				  `parent_subject` varchar(255) NOT NULL,
				  `wr_parent` int(11) DEFAULT 0,
				  PRIMARY KEY (`ph_id`)
			) ".$na_db_set."; ", true);

	$is_check = true;
}

//---------------------------------------------------------------------------------------------
// 게시판
// 태그
if(!sql_query(" DESC {$g5['na_tag']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_tag']}` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`type` tinyint(4) NOT NULL DEFAULT '0',
				`idx` varchar(10) NOT NULL DEFAULT '',
				`tag` varchar(255) NOT NULL DEFAULT '',
				`cnt` int(11) NOT NULL DEFAULT '0',
				`regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`lastdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (`id`),
				KEY tag (`tag`, `lastdate`)
			) ".$na_db_set."; ", true);

	$is_check = true;
}

// 태그로그
if(!sql_query(" DESC {$g5['na_tag_log']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_tag_log']}` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`bo_table` varchar(20) NOT NULL DEFAULT '',
				`wr_id` int(11) NOT NULL default '0',
				`tag_id` int(11) NOT NULL DEFAULT '0',
				`tag` varchar(255) NOT NULL DEFAULT '',
				`mb_id` varchar(255) NOT NULL DEFAULT '',
				`regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (`id`),
				KEY tag (`tag`)
			) ".$na_db_set."; ", true);

	$is_check = true;
}

// 신고
if(!sql_query(" DESC {$g5['na_singo']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_singo']}` (
				`id` int(11) NOT NULL auto_increment,
				`sg_flag` tinyint(4) NOT NULL default '0',
				`mb_id` varchar(20) NOT NULL default '',
				`sg_table` varchar(20) NOT NULL default '',
				`sg_id` int(11) NOT NULL default '0',
				`sg_parent` int(11) NOT NULL default '0',
				`sg_type` tinyint(4) NOT NULL default '0',
				`sg_desc` text NOT NULL,
				`wr_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`sg_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				PRIMARY KEY  (`id`),
				KEY `index1` (`sg_flag`,`mb_id`,`sg_table`,`sg_id`)
			) ".$na_db_set."; ", true);

	$is_check = true;
}

if(IS_YC) {

	// 내용관리에 쇼핑몰 레이아웃 사용 추가
	if (!sql_fetch(" SHOW COLUMNS FROM {$g5['content_table']} LIKE 'co_shop' ")) {
		sql_query(" ALTER TABLE `{$g5['content_table']}` ADD `co_shop` tinyint(4) NOT NULL DEFAULT '0' AFTER `co_html` ", true);

		$is_check = true;
	}

	if(IS_EXTEND || (isset($is_extend) && $is_extend)) {

		// 쇼핑몰 첨부파일
		if(!sql_query(" DESC {$g5['na_file']} ", false)) {
			sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_file']}` (
						`it_id` varchar(20) NOT NULL DEFAULT '',
						`mb_id` varchar(20) NOT NULL DEFAULT '',
						`sf_no` int(11) NOT NULL DEFAULT 0,
						`sf_source` varchar(255) NOT NULL DEFAULT '',
						`sf_file` varchar(255) NOT NULL DEFAULT '',
						`sf_download` int(11) NOT NULL DEFAULT 0,
						`sf_content` text NOT NULL,
						`sf_filesize` int(11) NOT NULL DEFAULT 0,
						`sf_free` tinyint(4) NOT NULL DEFAULT 0,
						`sf_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
						PRIMARY KEY (`it_id`, `sf_no`)
					) ".$na_db_set."; ", true);

			$is_check = true;
		}

		// 쇼핑몰 다운로드 히스토리
		if(!sql_query(" DESC {$g5['na_history']} ", false)) {
			sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_history']}` (
						`bo_table` varchar(20) NOT NULL default '',
						`wr_id` int(11) NOT NULL default '0',
						`it_id` varchar(20) NOT NULL DEFAULT '',
						`mb_id` varchar(20) NOT NULL DEFAULT '',
						`uh_no` int(11) NOT NULL default '0',
						`uh_flag` tinyint(4) NOT NULL DEFAULT 0,
						`uh_file` varchar(255) NOT NULL DEFAULT '',
						`uh_text` varchar(255) NOT NULL DEFAULT '',
						`uh_ip` varchar(255) NOT NULL,
						`uh_memo` text NOT NULL,
						`uh_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
						 PRIMARY KEY (`bo_table`, `wr_id`, `it_id`, `mb_id`)
					) ".$na_db_set."; ", true);

			$is_check = true;
		}

		// 장바구니에 무배송, 맴버십 추가
		if (!sql_fetch(" SHOW COLUMNS FROM {$g5['g5_shop_cart_table']} LIKE 'it_delivery' ")) {
			sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}` 
							ADD `it_delivery` tinyint(4) NOT NULL DEFAULT '0' AFTER `it_sc_qty`,
							ADD `it_mbs_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `it_delivery`,
							ADD `it_mbs` varchar(255) NOT NULL DEFAULT '' AFTER `it_mbs_use` ", true);

			$is_check = true;
		}

	}
}

// 새글
if(!sql_fetch(" SHOW COLUMNS FROM `{$g5['board_new_table']}` LIKE 'wr_hit' ")) {
	sql_query(" ALTER TABLE `{$g5['board_new_table']}` 
					ADD `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0' AFTER `mb_id`,
					ADD `wr_is_secret` tinyint(4) NOT NULL DEFAULT '0' AFTER `wr_is_comment`,
					ADD `wr_hit` int(11) NOT NULL DEFAULT '0' AFTER `wr_is_secret`,
					ADD `wr_comment` int(11) NOT NULL DEFAULT '0' AFTER `wr_hit`,
					ADD `wr_good` int(11) NOT NULL DEFAULT '0' AFTER `wr_comment`,
					ADD `wr_nogood` int(11) NOT NULL DEFAULT '0' AFTER `wr_good`,
					ADD `wr_singo` varchar(20) NOT NULL DEFAULT '' AFTER `wr_nogood`,
					ADD `wr_image` varchar(255) NOT NULL DEFAULT '' AFTER `wr_singo`,
					ADD `wr_video` varchar(255) NOT NULL DEFAULT '' AFTER `wr_image`
			", true);

	$is_check = true;
}

//---------------------------------------------------------------------------------------------

// 경험치 테이블
if(!sql_query(" DESC {$g5['na_xp']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_xp']}` (
				`xp_id` int(11) NOT NULL AUTO_INCREMENT,
				`mb_id` varchar(20) NOT NULL DEFAULT '',
				`xp_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`xp_content` varchar(255) NOT NULL DEFAULT '',
				`xp_point` int(11) NOT NULL DEFAULT '0',
				`xp_rel_table` varchar(20) NOT NULL DEFAULT '',
				`xp_rel_id` varchar(20) NOT NULL DEFAULT '',
				`xp_rel_action` varchar(100) NOT NULL DEFAULT '',
				PRIMARY KEY (`xp_id`),
				KEY `index1` (`mb_id`,`xp_rel_table`,`xp_rel_id`,`xp_rel_action`)
			) ".$na_db_set."; ", true);

	$is_check = true;
}

// 회원정보 테이블
if(!sql_fetch(" SHOW COLUMNS FROM `{$g5['member_table']}` LIKE 'as_noti' ")) {
	sql_query(" ALTER TABLE `{$g5['member_table']}`
					ADD `as_noti` int(11) NOT NULL DEFAULT '0' AFTER `mb_10` ", true);

	$is_check = true;
}

if(!sql_fetch(" SHOW COLUMNS FROM `{$g5['member_table']}` LIKE 'as_msg' ")) {
	sql_query(" ALTER TABLE `{$g5['member_table']}`
					ADD `as_msg` tinyint(4) NOT NULL DEFAULT '0' AFTER `as_noti`,
					ADD `as_exp` int(11) NOT NULL DEFAULT '0' AFTER `as_msg`,
					ADD `as_level` int(11) NOT NULL DEFAULT '1' AFTER `as_exp` ", true);

	$is_check = true;
}

if(!sql_fetch(" SHOW COLUMNS FROM `{$g5['member_table']}` LIKE 'as_max' ")) {
	sql_query(" ALTER TABLE `{$g5['member_table']}`
					ADD `as_max` int(11) NOT NULL DEFAULT '0' AFTER `as_level` ", true);

	$is_check = true;
}

if(!sql_fetch(" SHOW COLUMNS FROM `{$g5['member_table']}` LIKE 'as_chadan' ")) {
	sql_query(" ALTER TABLE `{$g5['member_table']}`
					ADD `as_chadan` text NOT NULL AFTER `as_max` ", true);

	$is_check = true;
}

if(!isset($_POST['post_action'])) {
	if($is_check) {
		if(isset($member['as_chadan'])) {
			die('DB 업그레이드가 완료되었습니다.');
		} else {
			die('나리야 설치가 완료되었습니다.');
		}
	} else {
		die('더 이상 업그레이드 할 내용이 없습니다.'.PHP_EOL.'현재 DB 업그레이드가 완료된 상태입니다.');
	}
}