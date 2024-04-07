<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$kind = isset($kind) ? $kind : '';

include_once ($member_skin_path.'/memo_tab.skin.php');

?>

<form name="fmemoform" action="<?php echo $memo_action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">

	<ul class="list-group list-group-flush mb-4">
		<?php if ($config['cf_memo_send_point']) { ?>
			<li class="list-group-item bg-body-tertiary small">
				<i class="bi bi-database-dash"></i>
				쪽지 보낼때 회원당 <b><?php echo number_format($config['cf_memo_send_point']); ?></b> 포인트를 차감합니다.
			</li>
		<?php } ?>
		<li class="list-group-item">
			<div class="row">
				<label for="me_recv_mb_id" class="col-sm-2 col-form-label">받는 회원<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-10">
					<input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" required class="form-control">
					<div class="form-text">
						여러 회원에게 보낼때는 회원아이디를 컴마(,)로 구분해 주세요.
					</div>
				</div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<label for="me_memo" class="col-sm-2 col-form-label">쪽지 내용<strong class="visually-hidden"> 필수</strong></label>
				<div class="col-sm-10">
					<textarea name="me_memo" id="me_memo" rows="5" required class="form-control"><?php echo $content ?></textarea>
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
					<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg w-100">쪽지 보내기</button>
				</div>
				<div class="col-6 col-sm-5 md-4 col-xl-3 order-1">
					<button type="button" onclick="window.close();" class="btn btn-basic btn-lg w-100">취소</button>
				</div>
			</div>
		</li>
	</ul>
</form>

<script>
function fmemoform_submit(f) {

    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
