<?php 
if (!defined('_GNUBOARD_')) { 
	include_once('./_common.php');
	include_once(NA_PATH.'/shop.todayview.rows.php');
?>
	<ul class="list-group list-group-flush">
		<li class="list-group-item line-bottom fw-bold">
			<i class="bi bi-bag-check"></i>
			오늘 본 상품 <span class="orangered"><?php echo number_format($total_count) ?></span> 개
		</li>
		<?php 
		for($i=0; $i < $list_cnt; $i++) { 

			$row = $list[$i];

			$thumb = ($row['img']) ? na_thumb($row['img'], 60, 60) : G5_THEME_URL.'/img/no_image.gif';
		?>
			<li class="list-group-item">
				<div class="d-flex gap-2 align-items-center">
					<div>
						<img src="<?php echo $thumb ?>" class="object-fit-cover" alt="<?php echo $row['name'] ?>" style="max-width:50px;">
					</div>
					<div>
						<a href="<?php echo $row['href'] ?>" class="ellipsis-1 mb-1">
							<?php echo $row['name'] ?>
						</a>
						<div class="small text-secondary">
							<?php echo $row['price'] ?>
						</div>
					</div>
				</div>
			</li>
		<?php } ?>
		<?php if(!$list_cnt) { ?>
			<li class="list-group-item text-center py-5">
				상품이 없습니다.
			</li>
		<?php } ?>
		<li class="list-group-item">
			<a href="#todayviewTrash" class="todayview-del small">
				<i class="bi bi-trash"></i>
				오늘 본 상품 비우기
			</a>		
		</li>
	</ul>
<?php exit; } // end Ajax ?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="todayviewOffcanvas" aria-labelledby="todayviewOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="todayviewOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">
		<div id="todayview-list"></div>
	</div>
</div>

<script>
$(function () {
	const myTodayViewOffcanvas = document.getElementById('todayviewOffcanvas');
	myTodayViewOffcanvas.addEventListener('show.bs.offcanvas', event => {
		$('#todayview-list').load('<?php echo LAYOUT_URL ?>/component/todayview.offcanvas.php');
	});

	$(document).on('click', '.todayview-del', function() {
		$('#todayview-list').load('<?php echo LAYOUT_URL ?>/component/todayview.offcanvas.php?del=1');
		return false;
	});
});
</script>
