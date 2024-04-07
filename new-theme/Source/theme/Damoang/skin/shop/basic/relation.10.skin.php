<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 스킨
if(is_file(LAYOUT_PATH.'/shop/relation.10.skin.php')) {
	include_once(LAYOUT_PATH.'/shop/relation.10.skin.php');
	return;
}

$img_w = $this->img_width ? $this->img_width : 400;
$img_h = $this->img_height ? $this->img_height : 300;

$list = array();

$k = 0;
for ($i=1; $row=sql_fetch_array($result); $i++) {

	$row['it_id'] = stripslashes($row['it_id']);

	if(!$row['it_id'])
		continue;

	$row = na_it_data($row);
	$row['img'] = ($row['img']) ? na_thumb($row['img'], $img_w, $img_h) : G5_THEME_URL.'/img/no_image.gif';

	$list[$k] = $row;

	$k++;
}

if (!$k)
	return $list;

$list_cnt = count($list);

// owlCarousel
na_script('owl');

// 랜덤 아이디
$id = 'relation-'.na_rid();
?>
<style>
#<?php echo $id ?> .ratio { --bs-aspect-ratio: <?php echo na_img_ratio($img_w, $img_h, '75') ?>%; overflow:hidden; }
#<?php echo $id ?> .owl-carousel .owl-stage-outer {	padding-left:2px; }
#<?php echo $id ?> .owl-carousel .owl-stage { display: flex; }
#<?php echo $id ?> .owl-carousel .owl-nav { text-align:center; margin:0.5rem 0 0; font-size:40px; }
#<?php echo $id ?> .owl-carousel .owl-dots { display: none !important; }
</style>
<div id="<?php echo $id ?>">
	<div class="owl-carousel">
	<?php 
	for ($i=0; $i < $list_cnt; $i++) { 
		$row = $list[$i];
	?>
		<div class="item h-100">

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
						<h5 class="fs-6 ellipsis-2 lh-base m-0">
							<a href="<?php echo $row['href'] ?>">
								<?php echo $row['name'] ?>
							</a>
						</h5>
					</div>
					<?php if($row['content']) { ?>
						<div class="card-text small text-secondary ellipsis-2">
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
	<?php } ?>
	</div>
</div>
<script>
$(function(){
	$('#<?php echo $id ?> .owl-carousel').owlCarousel({
		loop:true,
		nav:true,
		navText:['<i class="bi bi-arrow-left-circle-fill mx-2 opacity-25"></i>', '<i class="bi bi-arrow-right-circle-fill mx-2 opacity-25"></i>'],
		margin: 20,
		responsive:{
			0:{ items:1, stagePadding: 60 },
			576:{ items: 2, stagePadding: 80 },
			768:{ items: 2, stagePadding: 100 }, 
			992:{ items: 3, stagePadding: 120 }
		}
	});
});
</script>