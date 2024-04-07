<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="offcanvas offcanvas-top" tabindex="-1" id="searchOffcanvas" data-bs-scroll="true" aria-labelledby="searchOffcanvasLabel">
	<div class="offcanvas-header pb-0">
		<h5 class="offcanvas-title" id="searchOffcanvasLabel">
			<span class="visually-hidden">전체 검색</span>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<div class="container h-100">
			<div class="row justify-content-center align-items-center h-100">
				<div class="col-md-10 col-xl-8 col-xxl-6">
					<?php if (IS_SHOP) { ?>

						<form name="fsearchbox" method="get" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return searchbox_submit(this);">
						<label for="sch_str" class="visually-hidden">검색어 필수</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control form-control-lg" name="q" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" maxlength="20" placeholder="검색어를 입력해주세요">
							<button class="btn btn-lg btn-primary" type="submit" id="sch_submit"><i class="bi bi-search"></i><span class="visually-hidden">검색</span></button>
						</div>
						</form>
						<script>
						function search_submit(f) {
							if (f.q.value.length < 2) {
								na_alert('검색어는 두글자 이상 입력하십시오.', function() {
									f.q.select();
									f.q.focus();
								});
								return false;
							}
							return true;
						}
						</script>
					
					<?php } else { ?>

						<form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
						<input type="hidden" name="sfl" value="wr_subject||wr_content">
						<input type="hidden" name="sop" value="and">
						<label for="sch_stx" class="visually-hidden">검색어 필수</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control form-control-lg" name="stx" value="<?php echo stripslashes($stx) ?>" id="sch_stx" maxlength="20" placeholder="검색어를 입력해주세요">
							<button class="btn btn-lg btn-primary" type="submit" id="sch_submit"><i class="bi bi-search"></i><span class="visually-hidden">검색</span></button>
						</div>
						</form>
						<script>
						function fsearchbox_submit(f) {
							var stx = f.stx.value.trim();
							if (stx.length < 2) {
								na_alert('검색어는 두글자 이상 입력하십시오.', function() {
									f.stx.select();
									f.stx.focus();
								});
								return false;
							}

							// 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
							var cnt = 0;
							for (var i = 0; i < stx.length; i++) {
								if (stx.charAt(i) == ' ')
									cnt++;
							}

							if (cnt > 1) {
								na_alert('빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.', function() {
									f.stx.select();
									f.stx.focus();
								});
								return false;
							}

							f.stx.value = stx;

							return true;
						}
						</script>

					<?php } // end IS_SHOP ?>
				</div>
			</div>
		</div>
	</div>
</div>
