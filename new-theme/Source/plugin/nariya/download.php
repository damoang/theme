<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

if($is_guest)
	alert("회원만 다운로드를 할 수 있습니다.");

$it_id = (isset($_REQUEST['it_id']) && $_REQUEST['it_id']) ? safe_replace_regex($_REQUEST['it_id'], 'it_id') : '';

$it = get_shop_item($it_id);

if(!$it)
	alert('상품정보가 존재하지 않습니다.');

$no = isset($_REQUEST['no']) ? (int) $_REQUEST['no'] : 0;

// 쿠키에 저장된 ID값과 넘어온 ID값을 비교하여 같지 않을 경우 오류 발생
// 다른곳에서 링크 거는것을 방지하기 위한 코드
if (!$is_admin && !get_session('it_view_'.$it_id))
    alert('잘못된 접근입니다.');

$file = sql_fetch(" select * from {$g5['na_file']} where it_id = '$it_id' and sf_no = '$no' ");
if (!$file['sf_file'])
    alert('파일정보가 존재하지 않습니다.');

$nonce = isset($_REQUEST['nonce']) ? preg_replace('/[^0-9a-z\|]/i', '', $_REQUEST['nonce']) : '';

if (function_exists('download_file_nonce_is_valid') && !defined('G5_DOWNLOAD_NONCE_CHECK')){
    if(!download_file_nonce_is_valid($nonce, $it_id, 0)){
        alert('토큰 유효시간이 지났거나 토큰이 유효하지 않습니다.\\n브라우저를 새로고침 후 다시 시도해 주세요.', G5_SHOP_URL);
    }
}

$filepath = G5_DATA_PATH.'/item/'.$it_id.'/'.$file['sf_file'];
$filepath = addslashes($filepath);
$file_exist_check = (!is_file($filepath) || !file_exists($filepath)) ? false : true;

if (!$file_exist_check) {
    alert('파일이 존재하지 않습니다.');
}

if($is_admin || $file['sf_free']) {
	;
} else {
	// 유료
    $row = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and mb_id = '{$member['mb_id']}' and ct_status = '완료' ");
	$is_buy = isset($row['cnt']) ? (int)$row['cnt'] : 0;
	if(!$is_buy)
	    alert('구매한 회원만 다운로드를 할 수 있습니다.');
}

// 이미 다운로드 받은 파일인지를 검사한 후 다운로드 카운트 증가 ( SIR 그누위즈 님 코드 제안 )
$ss_name = 'it_down_'.$it_id.'_'.$no;
if (!get_session($ss_name)) {
    // 다운로드 카운트 증가
    sql_query(" update {$g5['na_file']} set sf_download = sf_download + 1 where it_id = '$it_id' and sf_no = '$no' ");
    // 다운로드 카운트를 증가시키고 세션을 생성
    $_SESSION[$ss_name] = true;
}

$g5['title'] = '다운로드';

//파일명에 한글이 있는 경우
/*
if(preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $file['bf_source'])){
    // 2015.09.02 날짜의 파이어폭스에서 인코딩된 문자 그대로 출력되는 문제가 발생됨, 2018.12.11 날짜의 파이어폭스에서는 해당 현상이 없으므로 해당 코드를 사용 안합니다.
    $original = iconv('utf-8', 'euc-kr', $file['bf_source']); // SIR 잉끼님 제안코드
} else {
    $original = urlencode($file['bf_source']);
}
*/

//$original = urlencode($file['bf_source']);
$original = rawurlencode($file['sf_source']);

if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize($filepath));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else if (preg_match("/Firefox/i", $_SERVER['HTTP_USER_AGENT'])){
    header("content-type: file/unknown");
    header("content-length: ".filesize($filepath));
    //header("content-disposition: attachment; filename=\"".basename($file['bf_source'])."\"");
    header("content-disposition: attachment; filename=\"".$original."\"");
    header("content-description: php generated data");
} else {
    header("content-type: file/unknown");
    header("content-length: ".filesize($filepath));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen($filepath, 'rb');

// 4.00 대체
// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
//if (!fpassthru($fp)) {
//    fclose($fp);
//}

$download_rate = 10;

while(!feof($fp)) {
    //echo fread($fp, 100*1024);
    /*
    echo fread($fp, 100*1024);
    flush();
    */

    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose ($fp);
flush();