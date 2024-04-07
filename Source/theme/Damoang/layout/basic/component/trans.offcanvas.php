<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="transOffcanvas" aria-labelledby="transOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="transOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">
		<!-- //Google 번역 -->
		<div id="google_translate_element" class="hd_lang"></div>
	</div>
</div>
