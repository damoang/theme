<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 스킨
if(is_file(LAYOUT_PATH.'/shop/list.10.skin.php')) {
	include_once(LAYOUT_PATH.'/shop/list.10.skin.php');
	return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

// 썸네일 및 이미지 비율
$thumb_w = $this->img_width ? $this->img_width : 400;
$thumb_h = $this->img_height ? $this->img_height : 300;

// 랜덤 아이디
$id = 'itlist-'.na_rid();

?>
<style>
#<?php echo $id ?> .ratio { --bs-aspect-ratio: <?php echo na_img_ratio($thumb_w, $thumb_h, 75) ?>%; overflow:hidden; }
</style>
<section id="<?php echo $id ?>" class="px-3 px-sm-0">
	<div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-4">
	<?php
	$i = 0;
	foreach((array) $list as $row){

		if(empty($row)) 
			continue;

		$row = na_it_data($row);
		$row['img'] = ($row['img']) ? na_thumb($row['img'], $thumb_w, $thumb_h) : G5_THEME_URL.'/img/no_image.gif';
	?>

		<div class="col">

			<div class="card h-100">
				<a href="<?php echo $row['href'] ?>" class="position-relative overflow-hidden">
					<div class="ratio card-img-top">
						<img src="<?php echo $row['img'] ?>" class="object-fit-cover" alt="<?php echo $row['name'] ?>">
					</div>
					<?php if($row['icon']) { ?>
						<div class="position-absolute start-0 bottom-0 p-3">
							<?php echo $row['icon'] ?>
						</div>
					<?php } ?>
					<?php if($row['soldout']) { ?>
						<div class="label-band text-bg-danger">SOLD OUT</div>
					<?php } ?>
				</a>
				<div class="card-body d-flex flex-column">
					<div class="card-title">
						<h5 class="fs-6 lh-base m-0">
							<a href="<?php echo $row['href'] ?>">
								<?php echo $row['name'] ?>
							</a>
						</h5>
					</div>
					<?php if($row['content']) { ?>
						<div class="card-text form-text">
							<?php echo $row['content'] ?>
						</div>
					<?php } ?>
					<div class="mt-auto w-100 pt-4">
						<div class="d-flex align-items-end">
							<div>
								<?php if($row['star_score']) { ?>
									<div class="text-primary mb-1">
										<?php echo $row['star'] ?>
									</div>
								<?php } ?>
								<?php if($row['cur_price']) { ?>
									<div class="form-text text-decoration-line-through">
										<?php echo $row['cur_price'] ?>
									</div>
								<?php } ?>
							</div>
							<div class="ms-auto text-end">
								<strong class="fw-bold">
									<?php echo $row['price'] ?>
								</strong>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer d-flex justify-content-center gap-1">
					<button type="button" onclick="na_cart('<?php echo $row['it_id'] ?>');" class="btn btn-basic btn-sm" title="장바구니">
						<i class="bi bi-cart"></i>
						<span class="visually-hidden">장바구니</span>
					</button>
					<button type="button" onclick="na_wishlist('<?php echo $row['it_id'] ?>');" class="btn btn-basic btn-sm" title="위시리스트">
						<i class="bi bi-heart"></i>
						<span class="visually-hidden">위시리스트</span>
					</button>
					<button type="button" onclick="na_itemuse('<?php echo $row['it_id'] ?>');" class="btn btn-basic btn-sm" title="사용후기">
						<i class="bi bi-chat-square-text"></i>
						<span class="visually-hidden">사용후기</span>
					</button>
					<button type="button" onclick="na_itemqa('<?php echo $row['it_id'] ?>');" class="btn btn-basic btn-sm" title="상품문의">
						<i class="bi bi-question-circle"></i>
						<span class="visually-hidden">상품문의</span>
					</button>
					<button type="button" onclick="na_sns_share('<?php echo na_seo_text($row['name']) ?>', '<?php echo $row['href'] ?>', '<?php echo $row['img'] ?>');" class="btn btn-basic btn-sm" title="SNS 공유">
						<i class="bi bi-share-fill"></i>
						<span class="visually-hidden">SNS 공유</span>
					</button>
				</div>
			</div>

		</div>
	<?php $i++; } ?>
	</div>
	<?php if(!$i) { ?>
		<div class="text-center py-5">
			상품이 없습니다.
		</div>
	<?php } ?>
	<ul class="pagination pagination-sm justify-content-center">
	<?php 
		// 전체 페이지 계산
		global $config, $page, $qstr1;

		$items = $this->list_mod * $this->list_row;
		
		$total_page  = ceil($this->total_count / $items);
		
		echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&amp;page=') 
	?>
	</ul>
</section>