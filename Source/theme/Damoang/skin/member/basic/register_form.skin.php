<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

add_javascript('<script src="'.G5_JS_URL.'/jquery.register_form.js"></script>', 0);

if ($config['cf_cert_use'] && ($config['cf_cert_simple'] || $config['cf_cert_ipin'] || $config['cf_cert_hp'])) {
    add_javascript('<script src="'.G5_JS_URL.'/certify.js?v='.G5_JS_VER.'"></script>', 0);
}
?>

<div class="max-800 mx-auto py-md-5">

	<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="url" value="<?php echo $urlencode ?>">
	<input type="hidden" name="agree" value="<?php echo $agree ?>">
	<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
	<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
	<input type="hidden" name="cert_no" value="">
	<?php if (isset($member['mb_sex'])) {  ?>
		<input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>">
	<?php }  ?>
	<?php 
		// 닉네임수정일이 지나지 않았다면 
		if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { 
	?>
		<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
		<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
	<?php }  ?>

	<h3 class="px-3 py-2 mb-0 fs-4">
		<i class="bi bi-check2-square"></i>
		가입정보 입력
	</h3>		
	<ul class="list-group list-group-flush line-top mb-4">
		<?php 
		$desc_name = '';
		$desc_phone = '';
		if($config['cf_cert_use']) { 
		?>
		<li class="list-group-item bg-body-tertiary">
			<div class="row">
				<label class="col-sm-3 col-form-label">본인확인<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-9">
					<?php 
					$desc_name = '<span class="cert_desc"> 본인확인 시 자동입력</span>';
					$desc_phone = '<span class="cert_desc"> 본인확인 시 자동입력</span>';

					if (!$config['cf_cert_simple'] && !$config['cf_cert_hp'] && $config['cf_cert_ipin']) {
						$desc_phone = '';
					}

					if ($config['cf_cert_simple']) {
						echo '<button type="button" id="win_sa_kakao_cert" class="btn btn-basic win_sa_cert me-2" data-type="">간편인증</button>';
					}
					
					if($config['cf_cert_hp']) {
						echo '<button type="button" id="win_hp_cert" class="btn btn-basic me-2">휴대폰 본인확인</button>';
					}

					if ($config['cf_cert_ipin']) {
						echo '<button type="button" id="win_ipin_cert" class="btn btn-basic me-2">아이핀 본인확인</button>';
					}

					if (isset($member['mb_certify']) && $member['mb_certify']) {
						switch  ($member['mb_certify']) {
							case "simple": 
								$mb_cert = "간편인증";
								break;
							case "ipin": 
								$mb_cert = "아이핀";
								break;
							case "hp": 
								$mb_cert = "휴대폰";
								break;
						}
					?>
						<div id="msg_certify" class="form-text">
							<strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
						</div>
					<?php } ?>
					<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>
				</div>
			</div>
		</li>
		<?php } ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_id" class="col-sm-3 col-form-label">아이디<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-9">
					<input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="form-control <?php echo $required ?>" minlength="3" maxlength="20">
					<div class="form-text">
						영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력 가능
						<div id="msg_mb_id"></div>
					</div>
				</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row mb-2">
				<label for="reg_mb_password" class="col-sm-3 col-form-label">비밀번호<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-9">
					<input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="form-control <?php echo $required ?>" minlength="3" maxlength="20">
				</div>
			</div>
			<div class="row">
				<label for="reg_mb_password_re" class="col-sm-3 col-form-label">비밀번호 확인<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-9">
					<input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="form-control <?php echo $required ?>" minlength="3" maxlength="20">
				</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_name" class="col-sm-3 col-form-label">이름<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-9">
					<input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly ?> class="form-control <?php echo $required ?>">
				</div>
			</div>
		</li>
		<?php if ($req_nick) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_nick" class="col-sm-3 col-form-label">닉네임<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-9">
					<input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick']) ? get_text($member['mb_nick']) : ''; ?>">
					<input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick']) ? get_text($member['mb_nick']) : ''; ?>" id="reg_mb_nick" required class="form-control nospace required" maxlength="20">
					<div class="form-text">
						공백없이 한글,영문,숫자만 가능 (한글2자,영문4자 이상 가능)
						<?php if($config['cf_nick_modify']) { ?>
							<div id="msg_mb_nick"></div>
							닉네임을 변경하면 앞으로 <b><?php echo (int)$config['cf_nick_modify'] ?></b>일 이내에는 재변경을 할 수 없습니다.
						<?php } ?>
					</div>
				</div>
			</div>
		</li>
		<?php } ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_email" class="col-sm-3 col-form-label">E-mail<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-9">
					<input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
					<input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="form-control email required" size="70" maxlength="100">
					<?php if ($config['cf_use_email_certify']) { ?>
						<div class="form-text">
							<?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
							<?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</li>
		<?php if ($config['cf_use_homepage']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_homepage" class="col-sm-3 col-form-label">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong class="visually-hidden"> 필수</strong><?php } ?></label>
				<div class="col-sm-9">
					<input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage"<?php echo $config['cf_req_homepage'] ? " required" : ""; ?> class="form-control<?php echo $config['cf_req_homepage'] ? " required" : ""; ?>" maxlength="255">
				</div>
			</div>
		</li>
		<?php } ?>
		<?php if ($config['cf_use_tel']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_tel" class="col-sm-3 col-form-label">전화번호<?php if ($config['cf_req_tel']){ ?><strong class="visually-hidden"> 필수</strong><?php } ?></label>
				<div class="col-sm-9">
					<input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel"<?php echo $config['cf_req_tel'] ? " required" : ""; ?> class="form-control<?php echo $config['cf_req_tel'] ? " required" : ""; ?>" maxlength="20">
				</div>
			</div>
		</li>
		<?php } ?>
		<?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_hp" class="col-sm-3 col-form-label">휴대폰번호<?php if ($config['cf_req_hp']){ ?><strong class="visually-hidden"> 필수</strong><?php } ?></label>
				<div class="col-sm-9">
					<input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp"<?php echo ($config['cf_req_hp']) ? " required" : ""; ?> class="form-control<?php echo ($config['cf_req_hp']) ? " required" : ""; ?>" maxlength="20">
					<?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
						<input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
					<?php } ?>
				</div>
			</div>
		</li>
		<?php } ?>
		<?php if ($config['cf_use_addr']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label class="col-sm-3 col-form-label">주소<?php if ($config['cf_req_addr']){ ?><strong class="visually-hidden"> 필수</strong><?php } ?></label>
				<div class="col-sm-9">
					<div class="input-group mb-2">
						<span class="input-group-text">우편번호<?php echo $config['cf_req_addr']?'<strong class="visually-hidden"> 필수</strong>':''; ?></span>
						<input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2'] ?>" id="reg_mb_zip"<?php echo $config['cf_req_addr'] ? " required" : ""; ?> class="form-control<?php echo $config['cf_req_addr'] ? " required" : ""; ?>" maxlength="12">
						<button type="button" class="btn btn-basic win_zip_find" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');" title="주소검색">
							<i class="bi bi-search"></i>
							<span class="visually-hidden">주소검색</span>
						</button>
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text">기본주소</span>
						<input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1"<?php echo $config['cf_req_addr'] ? " required" : ""; ?> class="form-control<?php echo $config['cf_req_addr'] ? " required" : ""; ?>">
					</div>
					<div class="input-group mb-2">
						<span class="input-group-text">상세주소</span>
						<input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="form-control">
					</div>
					<div class="input-group">		
						<span class="input-group-text">참고항목</span>
						<input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']) ?>">
						<input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="form-control" readonly="readonly">
					</div>
				</div>
			</div>
		</li>
		<?php } ?>
		<?php if ($config['cf_use_signature']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_signature" class="col-sm-3 col-form-label">서명<?php if ($config['cf_req_signature']){ ?><strong class="visually-hidden"> 필수</strong><?php } ?></label>
				<div class="col-sm-9">
					<textarea name="mb_signature" rows="3" id="reg_mb_signature"<?php echo $config['cf_req_signature'] ? " required" : ""; ?> class="form-control<?php echo $config['cf_req_signature'] ? " required" : ""; ?>"><?php echo $member['mb_signature'] ?></textarea>
				</div>
			</div>
		</li>
		<?php } ?>
		<?php if ($config['cf_use_profile']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_profile" class="col-sm-3 col-form-label">자기소개<?php if ($config['cf_req_profile']){ ?><strong class="visually-hidden"> 필수</strong><?php } ?></label>
				<div class="col-sm-9">
					<textarea name="mb_profile" rows="3" id="reg_mb_profile"<?php echo $config['cf_req_profile'] ? " required" : ""; ?> class="form-control<?php echo $config['cf_req_profile'] ? " required" : ""; ?>"><?php echo $member['mb_profile'] ?></textarea>
				</div>
			</div>
		</li>
		<?php } ?>
		<?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_icon" class="col-sm-3 col-form-label">회원아이콘</label>
				<div class="col-sm-9">
					<div class="input-group">
						<span class="input-group-text"><i class="bi bi-emoji-smile"></i></span>
						<input type="file" name="mb_icon" class="form-control" id="reg_mb_icon">
						<?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
							<span class="input-group-text">
								<span class="form-check form-check-inline me-0">
									<input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon" class="form-check-input">
									<label class="form-check-label" for="del_mb_icon">삭제</label>
								</span>
							</span>
						<?php }  ?>
					</div>
					<div class="form-text">
						아이콘 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.
						<br>
						gif, jpg, png 파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size'] / 1024) ?>kb 이하만 등록됩니다.
					</div>
				</div>
			</div>
		</li>
		<?php } ?>

		<?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_img" class="col-sm-3 col-form-label">회원이미지</label>
				<div class="col-sm-9">
					<div class="input-group">
						<span class="input-group-text"><i class="bi bi-image"></i></span>
						<input type="file" name="mb_img" class="form-control" id="reg_mb_img">
						<?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
							<span class="input-group-text">
								<span class="form-check form-check-inline me-0">
									<input type="checkbox" name="del_mb_img" value="1" id="del_mb_img" class="form-check-input">
									<label class="form-check-label" for="del_mb_img">삭제</label>
								</span>
							</span>
						<?php }  ?>
					</div>
					<div class="form-text">
						이미지 크기는 가로 <?php echo $config['cf_member_img_width'] ?>픽셀, 세로 <?php echo $config['cf_member_img_height'] ?>픽셀 이하로 해주세요.
						<br>
						gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_img_size'] / 1024) ?>kb 이하만 등록됩니다.
					</div>
				</div>
			</div>
		</li>
		<?php } ?>
		<li class="list-group-item">
			<div class="row align-items-center">
				<label for="reg_mb_mailling" class="col-sm-3 col-form-label">메일링서비스</label>
				<div class="col-sm-9">
					<div class="form-check form-switch form-check-inline">
						<input class="form-check-input" type="checkbox" name="mb_mailling" value="1" role="switch" id="reg_mb_mailling"<?php echo ($w == '' || $member['mb_mailling']) ? ' checked' : ''; ?>>
						<label class="form-check-label" for="reg_mb_mailling">정보 메일을 받겠습니다.</label>
					</div>
				</div>
			</div>
		</li>
		<?php if ($config['cf_use_hp']) { ?>
		<li class="list-group-item">
			<div class="row align-items-center">
				<label for="reg_mb_sms" class="col-sm-3 col-form-label">SMS 수신여부</label>
				<div class="col-sm-9">
					<div class="form-check form-switch form-check-inline">
						<input class="form-check-input" type="checkbox" name="mb_sms" value="1" role="switch" id="reg_mb_sms"<?php echo ($w == '' || $member['mb_sms']) ? ' checked' : ''; ?>>
						<label class="form-check-label" for="reg_mb_sms">휴대폰 문자메세지를 받겠습니다.</label>
					</div>
				</div>
			</div>
		</li>
		<?php } ?>
		<li class="list-group-item">
			<div class="row align-items-center">
				<label class="col-sm-3 col-form-label">정보공개</label>
				<div class="col-sm-9">
					<?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정 가능  ?>
						<input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
						<div class="form-check form-switch form-check-inline">
							<input class="form-check-input" type="checkbox" name="mb_open" value="1" role="switch" id="reg_mb_open"<?php echo ($w == '' || $member['mb_open']) ? ' checked' : ''; ?>>
							<label class="form-check-label" for="reg_mb_open">다른 분들이 나의 정보를 볼 수 있도록 합니다.</label>
						</div>
						<?php if($config['cf_open_modify']) { ?>
							<div class="form-text">
								정보공개 수정 후 <b><?php echo (int)$config['cf_open_modify'] ?></b>일 이내에 재 수정은 안됩니다.
							</div>
						<?php } ?>
					<?php } else {  ?>
						<input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
						<div class="form-text mt-0 pt-0">
							정보공개는 수정 후 <b><?php echo (int)$config['cf_open_modify'] ?></b>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경이 안됩니다.<br>
							이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
						</div>
					<?php } ?>
				</div>
			</div>
		</li>
		<?php
		//회원정보 수정인 경우 소셜 계정 출력
		if($config['cf_social_login_use'] && $w == 'u' && function_exists('social_member_provider_manage') ){
			social_member_provider_manage();
		}
		?>
		<?php if ($w == "" && $config['cf_use_recommend']) { ?>
		<li class="list-group-item">
			<div class="row">
				<label for="reg_mb_recommend" class="col-sm-3 col-form-label">추천인 아이디</label>
				<div class="col-sm-9">
					<input type="text" name="mb_recommend" id="reg_mb_recommend" class="form-control">
				</div>
			</div>
		</li>
		<?php } ?>
		<li class="list-group-item">
			<div class="row">
				<label for="captcha_key" class="col-sm-3 col-form-label">자동등록방지</label>
				<div class="col-sm-9 small">
					<?php echo captcha_html(); ?>
				</div>
			</div>
		</li>
		<li class="list-group-item pt-3">
			<div class="row g-3 justify-content-center">
				<div class="col-6 col-sm-5 md-4 order-2">
					<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg w-100"><?php echo $w == '' ? '회원가입' : '정보수정'; ?></button>
				</div>
				<div class="col-6 col-sm-5 md-4 order-1">
					<a href="<?php echo G5_URL ?>" class="btn btn-basic btn-lg w-100">취소</a>
				</div>
			</div>
		</li>
	</ul>

	</form>
</div>

<script>
$(function() {

    $("#reg_zip_find").css("display", "inline-block");
    var pageTypeParam = "pageType=register";

	<?php if($config['cf_cert_use'] && $config['cf_cert_simple']) { ?>
	// 이니시스 간편인증
	var url = "<?php echo G5_INICERT_URL; ?>/ini_request.php";
	var type = "";    
    var params = "";
    var request_url = "";

	$(".win_sa_cert").click(function() {
		if(!cert_confirm()) return false;
		type = $(this).data("type");
        params = "?directAgency=" + type + "&" + pageTypeParam;
        request_url = url + params;
        call_sa(request_url);
	});
    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
    // 아이핀인증
    var params = "";
    $("#win_ipin_cert").click(function() {
		if(!cert_confirm()) return false;
        params = "?" + pageTypeParam;
        var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php"+params;
        certify_win_open('kcb-ipin', url);
        return;
    });

    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
    // 휴대폰인증
    var params = "";
    $("#win_hp_cert").click(function() {
		if(!cert_confirm()) return false;
        params = "?" + pageTypeParam;
        <?php     
        switch($config['cf_cert_hp']) {
            case 'kcb':                
                $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                $cert_type = 'kcb-hp';
                break;
            case 'kcp':
                $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                $cert_type = 'kcp-hp';
                break;
            case 'lg':
                $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                $cert_type = 'lg-hp';
                break;
            default:
				$cert_url = '';
                $cert_type = '';
                break;
        }

		if(!$cert_url) {
        ?>
			na_alert('기본환경설정에서 휴대폰 본인확인 설정을 해주십시오.');
			return false;
		<?php } ?>

        certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>"+params);
        return;
    });
    <?php } ?>
});

// submit 최종 폼체크
function fregisterform_submit(f) {

	// 회원아이디 검사
	if (f.w.value == "") {
		var msg = reg_mb_id_check();
		if (msg) {
			na_alert(msg, function(){
				f.mb_id.select();
			});
			return false;
		}
	}

	if (f.w.value == "") {
		if (f.mb_password.value.length < 3) {
			na_alert('비밀번호를 3글자 이상 입력하십시오.', function(){
				f.mb_password.focus();
			});
			return false;
		}
	}

	if (f.mb_password.value != f.mb_password_re.value) {
		na_alert('비밀번호가 같지 않습니다.', function(){
			f.mb_password_re.focus();
		});
		return false;
	}

	if (f.mb_password.value.length > 0) {
		if (f.mb_password_re.value.length < 3) {
			na_alert('비밀번호를 3글자 이상 입력하십시오.', function(){
				f.mb_password_re.focus();
			});
			return false;
		}
	}

	// 이름 검사
	if (f.w.value=="") {
		if (f.mb_name.value.length < 1) {
			na_alert('이름을 입력하십시오.', function(){
				f.mb_name.focus();
			});
			return false;
		}

		/*
		var pattern = /([^가-힣\x20])/i;
		if (pattern.test(f.mb_name.value)) {
			na_alert('이름은 한글로 입력하십시오.', function(){
				f.mb_name.select();
			});
			return false;
		}
		*/
	}

	<?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
	// 본인확인 체크
	if(f.cert_no.value=="") {
		na_alert('회원가입을 위해서는 본인확인을 해주셔야 합니다.');
		return false;
	}
	<?php } ?>

	// 닉네임 검사
	if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
		var msg = reg_mb_nick_check();
		if (msg) {
			na_alert(msg, function(){
				f.reg_mb_nick.select();
			});
			return false;
		}
	}

	// E-mail 검사
	if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
		var msg = reg_mb_email_check();
		if (msg) {
			na_alert(msg, function(){
				f.reg_mb_email.select();
			});
			return false;
		}
	}

	<?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
	// 휴대폰번호 체크
	var msg = reg_mb_hp_check();
	if (msg) {
		na_alert(msg, function(){
			f.reg_mb_hp.select();
		});
		return false;
	}
	<?php } ?>

	if (typeof f.mb_icon != "undefined") {
		if (f.mb_icon.value) {
			if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
				na_alert('회원아이콘이 이미지 파일이 아닙니다.', function(){
					f.mb_icon.focus();
				});
				return false;
			}
		}
	}

	if (typeof f.mb_img != "undefined") {
		if (f.mb_img.value) {
			if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
				na_alert('회원이미지가 이미지 파일이 아닙니다.', function(){
					f.mb_img.focus();
				});
				return false;
			}
		}
	}

	if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
		if (f.mb_id.value == f.mb_recommend.value) {
			na_alert('본인을 추천할 수 없습니다.', function(){
				f.mb_recommend.focus();
			});
			return false;
		}

		var msg = reg_mb_recommend_check();
		if (msg) {
			na_alert(msg, function(){
				f.mb_recommend.select();
			});
			return false;
		}
	}

	<?php echo chk_captcha_js();  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>
