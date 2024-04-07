<?php
include_once('./_common.php');
include_once(NA_PATH.'/_shop.php');

$it_id = isset($_POST['it_id']) ? get_search_string(trim($_POST['it_id'])) : '';

$pattern = '#[/\'\"%=*\#\(\)\|\+\&\!\$~\{\}\[\]`;:\?\^\,]#';
$it_id  = $it_id ? preg_replace($pattern, '', $it_id) : '';

$it = get_shop_item($it_id, true);

if(!isset($it['it_id']) || !$it['it_id'])
	die(json_encode(array('error' => '상품정보가 존재하지 않습니다.')));

// 상품품절체크
$is_soldout = G5_SOLDOUT_CHECK ? is_soldout($it['it_id']) : '';

// 주문가능체크
if(!$it['it_use'] || $it['it_tel_inq'] || $is_soldout)
	die(json_encode(array('error' => '상품을 구매할 수 없습니다.')));

// 본인인증, 성인인증체크
if(!$is_admin) {
    $msg = shop_member_cert_check($it_id, 'item');
    if($msg)
		die(json_encode(array('error' => $msg)));
}

// 오늘 본 상품 저장
$saved = false;
$tv_idx = (int)get_session("ss_tv_idx");
if ($tv_idx > 0) {
    for ($i=1; $i<=$tv_idx; $i++) {
        if (get_session("ss_tv[$i]") == $it_id) {
            $saved = true;
            break;
        }
    }
}

if (!$saved) {
    $tv_idx++;
    set_session("ss_tv_idx", $tv_idx);
    set_session("ss_tv[$tv_idx]", $it_id);
}

// 조회수 증가
if (get_cookie('ck_it_id') != $it_id) {
    sql_query(" update {$g5['g5_shop_item_table']} set it_hit = it_hit + 1 where it_id = '$it_id' "); // 1증가
    set_cookie("ck_it_id", $it_id, 3600); // 1시간동안 저장
}

if(defined('G5_THEME_USE_OPTIONS_TRTD') && G5_THEME_USE_OPTIONS_TRTD){
	$option_item = get_item_options($it['it_id'], $it['it_option_subject'], '');
	$supply_item = get_item_supply($it['it_id'], $it['it_supply_subject'], '');
} else {
	// 선택 옵션 ( 기존의 tr td 태그로 가져오려면 'div' 를 '' 로 바꾸거나 또는 지워주세요 )
	$option_item = get_item_options($it['it_id'], $it['it_option_subject'], 'div', 1);

	// 추가 옵션 ( 기존의 tr td 태그로 가져오려면 'div' 를 '' 로 바꾸거나 또는 지워주세요 )
	$supply_item = get_item_supply($it['it_id'], $it['it_supply_subject'], 'div', 1);
}

// 주소
$it_href = shop_item_url($it_id);

ob_start();
include_once G5_THEME_SHOP_PATH.'/cartbuy.php';
$content = ob_get_contents();
ob_end_clean();

$result = array(
	'error'  => '',
	'html'   => $content
);

die(json_encode($result));