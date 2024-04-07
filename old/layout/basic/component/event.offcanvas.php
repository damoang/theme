<?php 
if (!defined('_GNUBOARD_')) { 
	include_once('./_common.php');
	include_once(NA_PATH.'/shop.event.rows.php');
?>
	<ul class="list-group list-group-flush border-bottom">
		<li class="list-group-item line-bottom fw-bold">
			<i class="bi bi-gift"></i>
			이벤트 <span class="orangered"><?php echo number_format($total_count) ?></span> 개
		</li>
		<?php 
		for($i=0; $i < $list_cnt; $i++) {

			$row = $list[$i];

			$thumb = ($row['img']) ? na_thumb($row['img'], 400, 0) : '';
		?>
			<li class="list-group-item">
				<a href="<?php echo $row['href'] ?>">
					<?php if($thumb) { ?>
						<img src="<?php echo $thumb ?>" class="img-fluid" alt="<?php echo $row['name'] ?>">
					<?php } else { ?>
						<h3 class="fs-6 mb-0">
							<?php echo $row['name'] ?>
						</h3>
					<?php } ?>
				</a>
			<?php if($row['item']) { ?>
				<div class="clearfix small mt-<?php echo ($thumb) ? '2' : '1' ?>">
					관련 상품 <b class="orangered"><?php echo number_format($row['item']) ?></b> 개
					<a href="<?php echo $row['href'] ?>" class="float-end">
						더보기
					</a>
				</div>
			</li>
				<?php 
					for($j=0; $j < count($row['it']); $j++) { 
					
					$row1 = $list[$i]['it'][$j];

					$img = ($row1['img']) ? na_thumb($row1['img'], 60, 60) : G5_THEME_URL.'/img/no_image.gif';
				?>
					<li class="list-group-item">
						<div class="d-flex gap-2 align-items-center">
							<div>
								<img src="<?php echo $img ?>" class="object-fit-cover" alt="<?php echo $row1['name'] ?>" style="max-width:50px;">
							</div>
							<div>
								<a href="<?php echo $row1['href'] ?>" class="ellipsis-1 mb-1">
									<?php echo $row1['name'] ?>
								</a>
								<div class="small text-secondary">
									<?php echo $row1['price'] ?>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
			<?php } else { ?>
				</li>
			<?php } ?>
		<?php } ?>
		<?php if(!$list_cnt) { ?>
			<li class="list-group-item text-center py-5">
				이벤트가 없습니다.
			</li>
		<?php } ?>
	</ul>
<?php exit; } // end Ajax ?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="eventOffcanvas" aria-labelledby="eventOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="eventOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">
		<div id="event-list"></div>
	</div>
</div>

<script>
$(function () {
	const myEventOffcanvas = document.getElementById('eventOffcanvas');
	myEventOffcanvas.addEventListener('show.bs.offcanvas', event => {
		$('#event-list').load('<?php echo LAYOUT_URL ?>/component/event.offcanvas.php?item=3'); // 이벤트별 가져올 상품수
	});
});
</script>
