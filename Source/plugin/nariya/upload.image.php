<?php
include_once('./_common.php');

// 첨부용량
$is_max_upload_size = (isset($board['bo_upload_size']) && $board['bo_upload_size']) ? $board['bo_upload_size'] : (1024 * 1024 * 2);

$error = $success = "";

function print_result($error, $success) {
	echo '{ "error": "'.$error.'", "success": "'.$success.'" }';
	exit;
}

if (!$is_member) {
	$error = '로그인한 회원만 가능합니다.';
	print_result($error, $success);
}

if(!isset($_FILES['na_file'])) {
	$error = '잘못된 접속입니다.';
	print_result($error, $success);
}

// 정리
$attach = $_FILES['na_file'];
$tmpfile = $attach['tmp_name'];
$filesize  = $attach['size'];
$filename  = $attach['name'];
$filename  = get_safe_filename($filename);

if(!$filename) {
	$error = '올바른 파일명이 아니거나 파일이 정상적으로 업로드 되지 않았습니다.';
	print_result($error, $success);
}

// 이미지 파일체크
if(!preg_match("/\.({$config['cf_image_extension']})$/i", $filename)) {
	$error = '이미지(JPG/GIF/PNG)파일만 업로드 할 수 있습니다.';
	print_result($error, $success);
}

if(!$filesize) {
	$error = '0 byte 파일은 업로드 할 수 없습니다.';
	print_result($error, $success);
}

// 오류 체크 - refer to error code : http://www.php.net/manual/en/features.file-upload.errors.php
if(isset($attach['error']) && $attach['error']) {
	switch($attach['error']) {
		case '1'	: $error = '파일의 용량이 서버 설정('.ini_get('upload_max_filesize').')을 초과하여 업로드 할 수 없습니다.'; break; 
		case '2'	: $error = '서버의 업로드 용량 제한에 걸렸습니다.'; break;
		case '3'	: $error = '파일의 일부분만 전송되었습니다.'; break;
		case '4'	: $error = '파일이 전송되지 않았습니다.'; break;
		case '6'	: $error = '임시 폴더가 없어 업로드 할 수 없습니다.'; break;
		case '7'	: $error = '파일 쓰기에 실패했습니다.'; break;
		case '8'	: $error = '[E100]오류가 발생하였습니다.'; break;
		default		: $error = '[E200]오류가 발생하였습니다.'; break;
	}
	print_result($error, $success);
}

if(!$is_admin && $filesize > $is_max_upload_size) {
	$error = get_filesize($is_max_upload_size).'이내 파일만 업로드 할 수 있습니다.';
	print_result($error, $success);
}

// 파일 업로드
if(is_uploaded_file($tmpfile)) {
	// 악성코드 체크
	$timg = @getimagesize($tmpfile);
	if ($timg['2'] < 1 || $timg['2'] > 18) {
		$error = '파일 자체에 오류가 있는 파일입니다.';
		print_result($error, $success);
	}

	$ym = date('ym', G5_SERVER_TIME);

	$data_dir = G5_DATA_PATH.'/editor/'.$ym;
	$data_url = G5_DATA_URL.'/editor/'.$ym;

	@mkdir($data_dir, G5_DIR_PERMISSION);
	@chmod($data_dir, G5_DIR_PERMISSION);

	$filename = basename($filename);

	$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
	shuffle($chars_array);
	$shuffle = implode('', $chars_array);
	$file_name = 'comment_'.abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);
	$save_dir = sprintf('%s/%s', $data_dir, $file_name);
	$save_url = sprintf('%s/%s', $data_url, $file_name);
	@move_uploaded_file($tmpfile, $save_dir);
	@chmod($save_dir, G5_FILE_PERMISSION);

	// 성공시 이미지 경로 넘김
	$success = $save_url;
	print_result($error, $success);
}

$error = '[E300]오류가 발생하였습니다.';
print_result($error, $success);