<?php
if (!defined('_GNUBOARD_')) exit;

$mb_only_page = basename($_SERVER['SCRIPT_FILENAME']);

if($mb_only_page == 'logout.php')
	return;

if($is_guest) {
	$mb_only_arr = array('login.php'
						,'login_check.php'
						,'password_lost.php'
						,'password_lost_certify.php'
						,'password_lost2.php'
						,'register.php'
						,'register_email.php'
						,'register_email_update.php'
						,'register_form.php'
						,'register_form_update.php'
						,'register_result.php'
						,'kcaptcha_result.php'
						,'kcaptcha_image.php'
						,'kcaptcha_session.php'
						,'kcaptcha_mp3.php'
						,'kcpcert_form.php'
						,'kcpcert_result.php'
						,'AuthOnlyReq.php'
						,'AuthOnlyRes.php'
						,'hpcert1.php'
						,'hpcert2.php'
						,'ipin1.php'
						,'ipin2.php'
						,'email_certify.php'
						,'ajax.mb_email.php'
						,'ajax.mb_hp.php'
						,'ajax.mb_id.php'
						,'ajax.mb_nick.php'
						,'ajax.mb_recommend.php'
						,'alert.php'
						,'alert_close.php'
						,'sns_send.php'
						,'write_token.php'
						,'ping.php'
						,'popup.php'
						,'register_member.php'
						,'register_member_update.php'
						,'unlink.php'
				);

	// 로그인 페이지로 이동
	if(!in_array($mb_only_page, $mb_only_arr))
		goto_url(G5_BBS_URL.'/login.php?url='.$urlencode);

} else if($member['mb_level'] >= (int)$nariya['mb_only']) {
	;
} else {

	// extend 재실행
	if(!empty($extend_file) && is_array($extend_file)) {
		natsort($extend_file);

		foreach($extend_file as $file) {
			include_once(G5_EXTEND_PATH.'/'.$file);
		}
		unset($file);
	}
	unset($extend_file);

	ob_start();

	// 자바스크립트에서 go(-1) 함수를 쓰면 폼값이 사라질때 해당 폼의 상단에 사용하면
	// 캐쉬의 내용을 가져옴. 완전한지는 검증되지 않음
	header('Content-Type: text/html; charset=utf-8');
	$gmnow = gmdate('D, d M Y H:i:s') . ' GMT';
	header('Expires: 0'); // rfc2616 - Section 14.21
	header('Last-Modified: ' . $gmnow);
	header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
	header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
	header('Pragma: no-cache'); // HTTP/1.0

	run_event('common_header');

	$html_process = new html_process();

	alert('현재 회원님의 가입 승인 여부를 심사 중 입니다.', G5_BBS_URL.'/logout.php');
}