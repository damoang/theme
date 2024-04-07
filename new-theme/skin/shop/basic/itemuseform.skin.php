<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 사용후기 쓰기 시작 { -->
<div id="sit_use_write">

    <form name="fitemuse" method="post" action="<?php echo G5_SHOP_URL ?>/itemuseformupdate.php" onsubmit="return fitemuse_submit(this);" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id ?>">
    <input type="hidden" name="is_id" value="<?php echo $is_id ?>">

	<ul class="list-group list-group-flush mb-4">
		<li class="list-group-item p-3">
			<h1 id="win_title" class="fs-4 mb-0">사용후기 쓰기</h1>
		</li>
		<li class="list-group-item p-3">

			<div class="input-group mb-2">
				<span class="input-group-text"><i class="bi bi-pencil"></i></span>
				<label for="is_subject" class="visually-hidden">제목<strong class="visually-hidden"> 필수</strong></label>
				<input type="text" name="is_subject" value="<?php echo get_text($use['is_subject']) ?>" id="is_subject" required class="form-control required " maxlength="255" placeholder="제목">
			</div>

			<div class="mb-2">
				<label for="is_content" class="visually-hidden">후기 내용</label>
				<?php echo $editor_html ?>
			</div>

			<div class="d-flex justify-content-center">
				<div>
				<?php 
					$text = array('만족도', '<i class="bi bi-emoji-angry"></i> 매우불만', '<i class="bi bi-emoji-frown"></i> 불만', '<i class="bi bi-emoji-neutral"></i> 보통', '<i class="bi bi-emoji-smile"></i> 만족', '<i class="bi bi-emoji-laughing"></i> 매우만족');
					for ($i = 5; $i > 0; $i--) { 
				?>
					<div class="form-check <?php echo ($i > 1) ? 'mb-2' : 'mb-0'; ?>">
						<input class="form-check-input" type="radio" name="is_score" value="<?php echo $i ?>" id="is_score<?php echo $i ?>"<?php echo ($is_score == $i) ? ' checked="checked"' : ''; ?>>
						<label class="form-check-label" for="is_score<?php echo $i ?>">
							<span class="text-primary"><?php echo na_star($i) ?></span>
							<?php echo $text[$i] ?>
						</label>
					</div>
				<?php } ?>
				</div>
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
function fitemuse_submit(f) {

	<?php echo $editor_js; ?>

	return true;
}
</script>
<!-- } 사용후기 쓰기 끝 -->