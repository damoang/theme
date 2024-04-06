<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="fmail">
	<form name="fformmail" action="./formmail_send.php" onsubmit="return fformmail_submit(this);" method="post" enctype="multipart/form-data">
    <input type="hidden" name="to" value="<?php echo $email ?>">
    <input type="hidden" name="attach" value="2">
	<?php if ($is_member) { // 회원이면  ?>
		<input type="hidden" name="fnick" value="<?php echo get_text($member['mb_nick']) ?>">
		<input type="hidden" name="fmail" value="<?php echo $member['mb_email'] ?>">
	<?php }  ?>

	<h3 class="px-3 py-2 mb-0 fs-5">
		<i class="bi bi-envelope-at"></i>
		<?php echo ($name) ? $name.'님께 메일보내기' : '메일 보내기'; ?>
	</h3>
	<ul class="list-group list-group-flush line-top pb-3">
		<?php if (!$is_member) {  ?>
		<li class="list-group-item">
			<div class="row">
				<label for="fnick" class="col-sm-2 col-form-label">이름<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-10">
					<input type="text" name="fnick" id="fnick" required class="form-control required">
				</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<label for="fmail" class="col-sm-2 col-form-label">E-mail<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-10">
					<input type="text" name="fmail" id="fmain" required class="form-control required">
				</div>
			</div>
		</li>
		<?php }  ?>
		<li class="list-group-item">
			<div class="row">
				<label for="subject" class="col-sm-2 col-form-label">제목<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-10">
					<input type="text" name="subject" id="subject" required class="form-control required">
				</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<label for="content" class="col-sm-2 col-form-label">내용<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-10">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" id="type_text" name="type" value="0">
						<label class="form-check-label" for="type_text">TEXT</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" id="type_html" name="type" value="1">
						<label class="form-check-label" for="type_html">HTML</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" id="type_both" name="type" value="2">
						<label class="form-check-label" for="type_both">TEXT+HTML</label>
					</div>
					<textarea name="content" id="content" rows="5" required class="form-control required mt-2"></textarea>
				</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<label class="col-sm-2 col-form-label">첨부파일</label>
				<div class="col-sm-10">
					<input type="file" name="file1" class="form-control mb-2" id="file1">
					<input type="file" name="file2" class="form-control" id="file2">
					<div class="form-text">
						첨부파일은 누락될 수 있으므로 발송 후 반드시 첨부 여부를 확인해 주세요.
					</div>
				</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<label for="captcha_key" class="col-sm-2 col-form-label">자동 방지</label>
				<div class="col-sm-10 small">
					<?php echo captcha_html(); ?>
				</div>
			</div>
		</li>
		<li class="list-group-item pt-3">
			<div class="row g-3 justify-content-center">
				<div class="col-6 col-sm-5 md-4 col-xl-3 order-2">
					<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg w-100">메일 발송</button>
				</div>
				<div class="col-6 col-sm-5 md-4 col-xl-3 order-1">
					<button type="button" onclick="window.close();" class="btn btn-basic btn-lg w-100">취소</a>
				</div>
			</div>
		</li>
	</ul>	
	</form>
</div>

<script>
with (document.fformmail) {
    if (typeof fname != "undefined")
        fname.focus();
    else if (typeof subject != "undefined")
        subject.focus();
}

function fformmail_submit(f) {

	<?php echo chk_captcha_js();  ?>

    if (f.file1.value || f.file2.value) {
        // 4.00.11
        if (!confirm("첨부파일의 용량이 큰경우 전송시간이 오래 걸립니다.\n\n메일보내기가 완료되기 전에 창을 닫거나 새로고침 하지 마십시오."))
            return false;
    }

    document.getElementById('btn_submit').disabled = true;

    return true;
}
</script>
<!-- } 폼메일 끝 -->