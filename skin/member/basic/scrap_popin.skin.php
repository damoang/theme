<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<form name="f_scrap_popin" action="./scrap_popin_update.php" method="post">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">

<h3 class="px-3 py-2 mb-0 fs-5">
	<?php echo get_text(cut_str($write['wr_subject'], 255)) ?>
</h3>
<ul class="list-group list-group-flush line-top mb-4">
	<li class="list-group-item bg-body-tertiary py-3">
		<div class="form-floating">
			<textarea name="wr_content" id="wr_content" class="form-control" placeholder="Leave a comment here" style="height:140px;"></textarea>
			<label for="wr_content">감사 혹은 격려의 댓글을 남겨 주세요.</label>
		</div>
	</li>
	<li class="list-group-item text-center pt-3">
		<button type="button" class="btn btn-basic me-2" onclick="window.close();">창닫기</button>
		<button type="submit" class="btn btn-primary">스크랩 확인</button>	
	</li>
</ul>
</form>
