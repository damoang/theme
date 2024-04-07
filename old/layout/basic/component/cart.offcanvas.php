<?php 
if (!defined('_GNUBOARD_')) { 
	include_once('./_common.php');
	include_once(NA_PATH.'/shop.cart.rows.php');
?>
	<ul class="list-group list-group-flush">
		<li class="list-group-item line-bottom fw-bold">
			<i class="bi bi-basket"></i>
			장바구니 <span class="orangered"><?php echo number_format($total_count) ?></span> 개
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
					<div class="flex-grow-1">
						<a href="<?php echo $row['href'] ?>" class="ellipsis-1 mb-1">
							<?php echo $row['name'] ?>
						</a>
						<div class="small text-secondary">
							<?php echo $row['price'] ?>
						</div>
					</div>
					<div>
						<button type="button" class="btn btn-basic" onclick="naCartDel('<?php echo $row['it_id'] ?>');">
							<i class="bi bi-trash"></i>
							<span class="visually-hidden">삭제</span>
						</button>
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
			<a href="<?php echo G5_SHOP_URL ?>/cart.php" class="small">
				<i class="bi bi-check2-square"></i>
				장바구니에 담긴 상품 확인
			</a>
		</li>
	</ul>
<?php exit; } // end Ajax ?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="cartOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">
		<div id="cart-list"></div>
	</div>
</div>

<script>
function naCartDel(it_id) {
	$('#cart-list').load('<?php echo LAYOUT_URL ?>/component/cart.offcanvas.php?it_id='+it_id);
	return false;
}

$(function () {
	const myCartOffcanvas = document.getElementById('cartOffcanvas');
	myCartOffcanvas.addEventListener('show.bs.offcanvas', event => {
		$('#cart-list').load('<?php echo LAYOUT_URL ?>/component/cart.offcanvas.php');
	});
});
</script>
