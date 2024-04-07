<?php
// 개별 페이지 접근 불가
if (!defined('_GNUBOARD_')) 
	exit;

// 버전
define('NA_VER', 'Nariya 0.1');

// 변수 초기화
$phref = ''; // 페이지 아이디 체크 차단용
$na_sql_where = ''; // 글목록 쿼리문 where 확장 변수
$na_sql_orderby = ''; // 글목록 쿼리문 order by 확장 변수
$na_sql_sst = ''; // 글목록 쿼리문 order by 필드

// DB 테이블 추가
$g5['na_noti'] = G5_TABLE_PREFIX.'na_noti';
$g5['na_tag_log'] = G5_TABLE_PREFIX.'na_tag_log';
$g5['na_tag'] = G5_TABLE_PREFIX.'na_tag';
$g5['na_singo'] = G5_TABLE_PREFIX.'na_singo';
$g5['na_xp'] = G5_TABLE_PREFIX.'na_xp';
$g5['na_menu'] = G5_TABLE_PREFIX.'na_menu';
$g5['na_file'] = G5_TABLE_PREFIX.'na_file';
$g5['na_history'] = G5_TABLE_PREFIX.'na_history';

// 영카트
define('NA_YC', '영카트 쇼핑몰이 설치되어 있어야 작동합니다.');

require_once NA_PATH.'/lib/core.lib.php';
require_once NA_PATH.'/lib/member.lib.php';

// 기본 설정
$nariya = na_config();

// 멤버쉽
$xp = array();
$xp['admin']	= na_explode(',', $nariya['lvl_admin']);
$xp['special']	= na_explode(',', $nariya['lvl_special']);
$xp['ext']		= $nariya['lvl_ext'];

// 관리자 확장
if($is_member)
	na_admin();

// 회원정보 재가공
$member = na_member($member);

// 쇼핑몰
(isset($nariya['is_yc']) && $nariya['is_yc']) ?	define('IS_YC', true) : define('IS_YC', false);

// 데모
(isset($nariya['is_demo']) && $nariya['is_demo']) ? define('IS_DEMO', true) : define('IS_DEMO', false);

// 확장
(isset($nariya['is_extend']) && $nariya['is_extend']) ? define('IS_EXTEND', true) : define('IS_EXTEND', false);

// 상수
$nariya['max_singo'] = (isset($nariya['max_singo']) && (int)$nariya['max_singo'] > 0) ? $nariya['max_singo'] : 50;
define('NA_MAX_SINGO', $nariya['max_singo']);

$nariya['max_chadan'] = (isset($nariya['max_chadan']) && (int)$nariya['max_chadan'] > 0) ? $nariya['max_chadan'] : 50;
define('NA_MAX_CHADNA', $nariya['max_chadan']);

// 함수 불러오기
include_once NA_PATH.'/lib/singo.lib.php';
require_once NA_PATH.'/lib/content.lib.php';
require_once NA_PATH.'/lib/count.lib.php';
require_once NA_PATH.'/lib/image.lib.php';
require_once NA_PATH.'/lib/video.lib.php';
require_once NA_PATH.'/lib/script.lib.php';
require_once NA_PATH.'/lib/widget.lib.php';
require_once NA_PATH.'/lib/tag.lib.php';
require_once NA_PATH.'/lib/noti.lib.php';
require_once NA_PATH.'/lib/theme.lib.php';
require_once NA_PATH.'/lib/hook.lib.php';
if(IS_EXTEND) {
	require_once NA_PATH.'/lib/extend.lib.php';
}
require_once G5_LIB_PATH.'/thumbnail.lib.php';

// 모바일 스킨 경로 조정
if (G5_IS_MOBILE) {

	if (isset($board['bo_mobile_skin']) && strpos($board['bo_mobile_skin'], 'theme/PC-Skin') !== false) {
		$board_skin_path    = na_skin_path('board', $board['bo_skin']);
		$board_skin_url     = na_skin_url('board', $board['bo_skin']);
	}

	if (strpos($config['cf_mobile_member_skin'], 'theme/PC-Skin') !== false) {
		$member_skin_path   = na_skin_path('member', $config['cf_member_skin']);
		$member_skin_url    = na_skin_url('member', $config['cf_member_skin']);
	}

	if (strpos($config['cf_mobile_new_skin'], 'theme/PC-Skin') !== false) {
		$new_skin_path      = na_skin_path('new', $config['cf_new_skin']);
		$new_skin_url       = na_skin_url('new', $config['cf_new_skin']);
	}

	if (strpos($config['cf_mobile_search_skin'], 'theme/PC-Skin') !== false) {
		$search_skin_path   = na_skin_path('search', $config['cf_search_skin']);
		$search_skin_url    = na_skin_url('search', $config['cf_search_skin']);
	}

	if (strpos($config['cf_mobile_connect_skin'], 'theme/PC-Skin') !== false) {
		$connect_skin_path  = na_skin_path('connect', $config['cf_connect_skin']);
		$connect_skin_url   = na_skin_url('connect', $config['cf_connect_skin']);
	}

	if (strpos($config['cf_mobile_faq_skin'], 'theme/PC-Skin') !== false) {
		$faq_skin_path      = na_skin_path('faq', $config['cf_faq_skin']);
		$faq_skin_url       = na_skin_url('faq', $config['cf_faq_skin']);
	}
}

// 회원 전용
if (isset($nariya['mb_only']) && $nariya['mb_only'])
	require_once NA_PATH.'/members.only.php';

// 로그인 경험치
if (isset($nariya['xp_login']) && $nariya['xp_login']) {
	if (isset($member['mb_today_login']) && $member['mb_today_login'] && substr($member['mb_today_login'], 0, 10) != G5_TIME_YMD)
		na_insert_xp($member['mb_id'], $nariya['xp_login'], G5_TIME_YMD.' 로그인', '@login', $member['mb_id'], G5_TIME_YMD);
}

// 게시판 설정
$boset = array();
if (isset($board['bo_table']) && $board['bo_table']) {

	$boset = na_skin_config('board', $board['bo_table']);

	if ($is_member && !$is_admin && isset($boset['bo_admin']) && $boset['bo_admin'])
		na_admin($boset['bo_admin'], 1);

	// 레이아웃
	if(isset($boset['bo_shop']) && $boset['bo_shop']) {
		if(IS_YC && (!defined('G5_COMMUNITY_USE') || G5_COMMUNITY_USE !== false))
			define('_SHOP_', true);
	}

	// 게시판 자체 Hooks
	@include_once $board_skin_path.'/_hooks.php';

	// board.php 에서만 실행
	if (basename($_SERVER['SCRIPT_FILENAME']) == 'board.php')
		@include_once $board_skin_path.'/_extend.php';
}

// 페이지 아이디 생성
if(IS_YC) {
	include_once(G5_LIB_PATH.'/shop.uri.lib.php');
}
$pset = na_pid();
$file_id = $pset['fid']; //파일 아이디
$page_id = $pset['pid']; //페이지 아이디

// 그누 원본 대체 페이지
$replace_bbs_file = array(
	G5_BBS_DIR.'-content', // 내용관리
	G5_BBS_DIR.'-board', // 게시판, 글쓰기
	G5_BBS_DIR.'-page-faq', // FAQ
);

// 영카트 원본 대체 파일
$replace_shop_file = array();
if(IS_YC) {
	$replace_shop_file = array(
		G5_SHOP_DIR.'-shop-list', // 상품목록 페이지(PC)
		G5_MOBILE_DIR.'-'.G5_SHOP_DIR.'-shop-list', // 상품목록 페이지(모바일)
		G5_SHOP_DIR.'-shop-item', // 상품상세페이지(PC)
		G5_MOBILE_DIR.'-'.G5_SHOP_DIR.'-shop-item', // 상품상세페이지(모바일)
		G5_SHOP_DIR.'-page-itemuse', // 상품상세 페이지의 상품후기
		G5_SHOP_DIR.'-page-itemuselist', // 상품후기(PC)
		G5_MOBILE_DIR.'-'.G5_SHOP_DIR.'-page-itemuselist', // 상품후기(모바일)
		G5_SHOP_DIR.'-page-itemqa', // 상품상세 페이지의 상품문의
		G5_SHOP_DIR.'-page-itemqalist', // 상품문의(PC)
		G5_MOBILE_DIR.'-'.G5_SHOP_DIR.'-page-itemqalist', // 상품문의(모바일)
		G5_SHOP_DIR.'-page-orderform', // 주문폼
		G5_SHOP_DIR.'-page-personalpayform', // 개인결제폼
	);
}

// 관리자 원본 대체 파일
if(IS_EXTEND) {
	$replace_adm_file = array(
		G5_ADMIN_DIR.'-page-menu_list', // 메뉴관리
		G5_ADMIN_DIR.'-page-menu_form', // 메뉴등록
		G5_ADMIN_DIR.'-page-menu_form_search', // 메뉴검색
		G5_ADMIN_DIR.'-page-contentlist', // 내용관리
		G5_ADMIN_DIR.'-shop_admin-page-itemlist', // 상품관리목록
		G5_ADMIN_DIR.'-shop_admin-page-orderformcartupdate', // 주문상태 업데이트
	);
} else {
	$replace_adm_file = array(
		G5_ADMIN_DIR.'-page-menu_list', // 메뉴관리
		G5_ADMIN_DIR.'-page-menu_form', // 메뉴등록
		G5_ADMIN_DIR.'-page-menu_form_search', // 메뉴검색
		G5_ADMIN_DIR.'-page-contentlist', // 내용관리
	);
}