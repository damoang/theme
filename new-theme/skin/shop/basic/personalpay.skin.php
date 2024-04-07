<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 스킨
if(is_file(LAYOUT_PATH.'/shop/personalpay.skin.php')) {
	include_once(LAYOUT_PATH.'/shop/personalpay.skin.php');
	return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<h2 class="fs-4 px-3 py-2 mb-0">
	개인결제
</h2>
<ul class="list-group list-group-flush line-top mb-4">
	<li class="list-group-item py-4">
		<div class="row g-4 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5">
		<?php
		for ($i=1; $row=sql_fetch_array($result); $i++) {
			$href = G5_SHOP_URL.'/personalpayform.php?pp_id='.$row['pp_id'].'&amp;page='.$page;
		?>
			<div class="col">

				<div class="card h-100">
					<div class="card-body text-center">
						<a href="<?php echo $href ?>">
							<img src="<?php echo G5_SHOP_SKIN_URL ?>/img/personal.jpg" alt="" class="img-fluid">
						</a>
						<div class="card-text">
							<a href="<?php echo $href ?>" class="d-block mb-1">
								<?php echo get_text($row['pp_name']) ?>님 개인결제
							</a>
							<?php echo display_price($row['pp_price']); ?>
						</div>
					</div>
				</div>

			</div>
		<?php } ?>
		</div>
		<?php if($i == 1) { ?>
			<div class="clearfix text-center py-5">
				등록된 개인결제가 없습니다.
			</div>
		<?php } ?>
	</li>
	<li class="list-group-item">
		<ul class="pagination pagination-sm justify-content-center mb-0">
			<?php echo na_ajax_paging('itemuse', (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, G5_SHOP_URL.'/itemuse.php?it_id='.$it_id.'&amp;page='); ?>
		</ul>
	</li>
</ul>
