<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="modal fade" id="singoModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<form name="fsingoForm" id="fsingoForm">
				<input type="hidden" id="sg_table" name="sg_table" value="">
				<input type="hidden" id="sg_id" name="sg_id" value="">
				<input type="hidden" id="sg_flag" name="sg_flag" value="">
				<input type="hidden" id="sg_hid" name="hid" value="">
					<div class="input-group mb-2">
						<span class="input-group-text" id="singo-text">신고 사유</span>
						<select id="sg_type" name="sg_type" class="form-select" aria-describedby="singo-text">
							<option value="">선택해 주세요.</option>
							<?php
								// 신고 항목
								for($i=0; $i<count($singo_type);$i++) {
									if(!isset($singo_type[$i]) || !$singo_type[$i])
										continue;
							?>
								<option value="<?php echo $i ?>"><?php echo $singo_type[$i] ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="form-text mb-2">
						<i class="bi bi-info-circle"></i>
						명예훼손/저작권침해/기타와 같이 추가 내용이 필요한 경우 입력해 주세요.
					</div>

					<textarea class="form-control" name="sg_desc" rows="3" id="sg_desc"></textarea>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-basic" data-bs-dismiss="modal">
					<i class="bi bi-x-lg"></i>
					<span class="visually-hidden">닫기</span>
				</button>
				<button type="button" class="btn btn-primary" onclick="na_singo_submit();">
					<i class="bi bi-eye-slash"></i>
					신고하기
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="snsIconModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center">
				
				<?php na_script('kakaotalk') ?>

				<div id="snsIconModalContent"></div>

				<div class="input-group mt-3">
					<input type="text" id="snsUrlModal" class="form-control nofocus" aria-describedby="copy-sns" value="" readonly>
					<button class="btn btn-primary sns-copy nofocus" type="button" id="copy-sns" data-clipboard-target="#snsUrlModal">
						복사
					</button>
					<button type="button" class="btn btn-basic nofocus" data-bs-dismiss="modal" aria-label="Close">
						<i class="bi bi-x-lg"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var singoModal = new bootstrap.Modal(document.getElementById('singoModal'));
var snsIconModal = new bootstrap.Modal(document.getElementById('snsIconModal'));
</script>

<?php 
// 영카트 설치시에 작동 
if(!IS_YC) 
	return; 

$action_url = (G5_HTTPS_DOMAIN) ? G5_HTTPS_DOMAIN.'/'.G5_SHOP_DIR.'/cartupdate.php' : G5_SHOP_URL.'/cartupdate.php';
?>

<script src="<?php echo G5_THEME_URL ?>/js/nariya.shop.js?ver=<?php echo G5_JS_VER; ?>"></script>

<div class="offcanvas offcanvas-end" tabindex="-1" id="cartFormOffcanvas" aria-labelledby="cartFormOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="cartFormOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">
		<form id="fcartForm" name="fcartForm" method="post" action="<?php echo $action_url; ?>" onsubmit="return fcartItem_submit(this);">
			<div id="cartFormOffcanvasContent"></div>
		</form>
		<?php if (isset($naverpay_button_js) && $naverpay_button_js) { //네이버 페이 ?>
			<div class="itemform-naverpay"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
		<?php } ?>
	</div>
</div>
<script>
// 바로구매, 장바구니 폼 전송
function fcartItem_submit(f) {

	f.action = "<?php echo $action_url ?>";
    f.target = "";

	var pressed = document.pressed;
	if(fcartItem_check(f, pressed)) {
		return true;
	}

	return false;
}
</script>