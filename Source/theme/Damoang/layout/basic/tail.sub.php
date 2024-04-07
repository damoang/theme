<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 다크모드 스크립트 오류 방지용
?>
<div class="d-none">
	<a href="javascript:;" id="bd-theme-trick" data-bs-toggle="dropdown" aria-expanded="false">
		<span class="theme-icon-active">
			<i class="bi bi-sun"></i>
		</span>
	</a>
	<div class="dropdown-menu dropdown-menu-end py-0 shadow-none border navbar-dropdown-caret theme-dropdown-menu" aria-labelledby="bd-theme-trick"  data-bs-popper="static">
		<div class="card position-relative border-0">
			<div class="card-body p-1">
				<button type="button" class="dropdown-item rounded-1" data-bs-theme-value="light">
					<span class="me-2 theme-icon">
						<i class="bi bi-sun"></i>
					</span>
					Light
				</button>
				<button type="button" class="dropdown-item rounded-1 my-1" data-bs-theme-value="dark">
					<span class="me-2 theme-icon">
						<i class="bi bi-moon-stars"></i>
					</span>
					Dark
				</button>
				<button type="button" class="dropdown-item rounded-1" data-bs-theme-value="auto">
					<span class="me-2 theme-icon">
						<i class="bi bi-circle-half"></i>
					</span>
					Auto
				</button>
			</div>	
		</div>
	</div>
</div>
<script>
	function googleTranslateElementInit() {
		new google.translate.TranslateElement({
			pageLanguage: 'ko',
			includedLanguages: 'ko,zh-CN,zh-TW,ru,en,fr,ja,ar',
			layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
			autoDisplay: false
		}, 'google_translate_element');
	}
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php run_event('tail_sub'); ?>
</body>
</html>