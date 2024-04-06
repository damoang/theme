<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품문의 쓰기 시작 { -->
<div id="sit_qa_write">

    <form name="fitemqa" method="post" action="<?php echo G5_SHOP_URL;?>/itemqaformupdate.php" onsubmit="return fitemqa_submit(this);" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id ?>">
    <input type="hidden" name="iq_id" value="<?php echo $iq_id ?>">

	<ul class="list-group list-group-flush mb-4">
		<li class="list-group-item p-3">
			<h1 id="win_title" class="fs-4 mb-0">상품문의 쓰기</h1>
		</li>
		<li class="list-group-item p-3">

			<div class="input-group">
				<span class="input-group-text"><i class="bi bi-at"></i></span>
				<label for="iq_email" class="visually-hidden">이메일</label>
				<input type="text" name="iq_email" id="iq_email" value="<?php echo get_text($qa['iq_email']); ?>" class="form-control" placeholder="이메일">
			</div>
			<div class="form-text mb-2">
				이메일을 입력하시면 답변 등록 시 답변이 이메일로 전송됩니다.
			</div>

			<div class="input-group">
				<span class="input-group-text"><i class="bi bi-phone-vibrate"></i></span>
				<label for="iq_hp" class="visually-hidden">휴대폰</label>
				<input type="text" name="iq_hp" id="iq_hp" value="<?php echo get_text($qa['iq_hp']); ?>" class="form-control" placeholder="휴대폰">
			</div>
			<div class="form-text mb-2">
				휴대폰번호를 입력하시면 답변 등록 시 답변등록 알림이 SMS로 전송됩니다.
			</div>

			<div class="input-group mb-2">
				<span class="input-group-text"><i class="bi bi-question-circle"></i></span>
				<label for="iq_subject" class="visually-hidden">제목<strong class="visually-hidden"> 필수</strong></label>
				<input type="text" name="iq_subject" value="<?php echo get_text($qa['iq_subject']) ?>" id="iq_subject" required class="form-control required " maxlength="255" placeholder="제목">
				<div class="input-group-text">
					<div class="form-check form-check-inline me-0">
						<input class="form-check-input" type="checkbox" name="iq_secret" id="iq_secret" value="1" <?php echo $chk_secret ?>>
						<label class="form-check-label" for="iq_secret">
						비밀글
						</label>

					</div>
				</div>
			</div>

			<div>
				<label for="iq_question" class="visually-hidden">질문 내용</label>
		        <?php echo $editor_html; ?>
			</div>

		</li>
		<li class="list-group-item p-3">
			<div class="row g-3 justify-content-center">
				<div class="col-6 col-sm-5 md-4 col-xl-3 order-2">
					<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg w-100">작성완료</button>
				</div>
				<div class="col-6 col-sm-5 md-4 col-xl-3 order-1">
					<button type="button" onclick="self.close();" class="btn btn-basic btn-lg w-100">닫기</button>
				</div>
			</div>
		</li>
	</ul>
    </form>
</div>

<script>
function fitemqa_submit(f) {

	<?php echo $editor_js; ?>

    return true;
}
</script>
<!-- } 상품문의 쓰기 끝 -->