<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

// https://unitegallery.net/index.php?page=compact-right
na_script('unitegallery', 'compact');

// 썸네일 크기
$thumb_w = 80;
$thumb_h = 60;

$imgs = array();
for($i=1; $i<=10; $i++) {
	$file = G5_DATA_PATH.'/item/'.$it['it_img'.$i];

	if(!is_file($file) || !$it['it_img'.$i])
		continue;

	$size = @getimagesize($file);
	if(!isset($size[2]) || $size[2] < 1 || $size[2] > 3)
		continue;

	$imgs[] = G5_DATA_URL.'/item/'.$it['it_img'.$i];
}
?>

<section id="sit_ov_from">

	<div class="row g-3">
		<div class="col-lg-7">
			<div class="img-wrap" style="padding-bottom:<?php echo round(($thumb_h / $thumb_w) * 100, 3) ?>%;">
				<div class="img-item">
					<div id="item-gallery" style="display:none;">
						<?php for($i=1; $i <= 10; $i++) { 
								//유튜브 영상 출력
								$info = na_check_youtube($it['it_'.$i]);

								if(!isset($info['vid']) || !$info['vid'])
									continue;
						?>
							<img alt="Youtube Video <?php echo $i ?>"
								 data-type="youtube"
								 data-videoid="<?php echo $info['vid'] ?>">
						<?php } ?>
						<?php 
						for($i=0; $i < count($imgs); $i++) {
							$img = $imgs[$i];
							$thumb = na_thumb($img, $thumb_w, $thumb_h); // 썸네일
						?>
							<img alt="Item Image <?php echo $i+1; ?>"
								 src="<?php echo $thumb ?>"
								 data-image="<?php echo $img ?>">
						 <?php } ?>
					</div>
				</div>
			</div>
			<script>
				$(function(){
					$("#item-gallery").unitegallery({
						gallery_theme: "compact",
						gallery_skin:"default",
						theme_panel_position: "right", //top, bottom, left, right - thumbs panel position
						theme_hide_panel_under_width: 10000, //hide panel under certain browser width, if null, don't hide
						gallery_autoplay: true,
						gallery_play_interval: 3000,
						slider_enable_text_panel: false,
						gallery_width: <?php echo $thumb_w * 15; ?>,
						gallery_height: <?php echo $thumb_h * 15; ?>,
						gallery_min_width: <?php echo $thumb_w * 5; ?>,
						gallery_min_height: <?php echo $thumb_h * 5; ?>,
						thumb_width: <?php echo $thumb_w ?>,
						thumb_height: <?php echo $thumb_h ?>,
					});
				});
			</script>
		</div>
		<div class="col-lg-5">
			<ul class="list-group list-group-flush">
				<li class="list-group-item pt-0 divider-line">
			        <h2 id="sit_title" class="fs-3 mb-0">
						<?php echo stripslashes($it['it_name']); ?>
						<span class="visually-hidden">상품 요약정보 및 구매</span>
					</h2>
					<?php if($it['it_basic']) { ?>
						<div id="sit_desc" class="form-text mt-2">
							<?php echo $it['it_basic'] ?>
						</div>
					<?php } ?>
					<?php if($is_orderable) { ?>
						<div id="sit_opt_info" class="small mt-2">
							상품 선택옵션 <?php echo $option_count ?> 개, 추가옵션 <?php echo $supply_count ?> 개
						</div>
					<?php } ?>
				</li>
				<li class="list-group-item">
					<div class="d-flex gap-2 align-items-center">
						<div>
						<?php if ($star_score) { ?>
							<span class="visually-hidden">고객평점</span>
							<span class="text-primary fs-5"><?php echo na_star($star_score) ?></span>
							<span class="visually-hidden">별<?php echo $star_score ?>개</span> 
						<?php } else { ?>
							상품안내
						<?php } ?>
						</div>
						<div class="ms-auto">
							<a href="#sit_use" class="btn btn-basic btn-sm" title="사용후기" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="사용후기">
								<i class="bi bi-chat-square-text"></i>
								<span class="visually-hidden">사용후기</span>
								<?php echo $it['it_use_cnt'] ?>
							</a>
						</div>
						<div>
							<button type="button" class="btn btn-basic btn-sm" onclick="na_wishlist('<?php echo $it['it_id'] ?>');" title="위시리스트" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="위시리스트">
								<i class="bi bi-heart"></i>
								<span class="visually-hidden">위시리스트</span>
								<?php echo get_wishlist_count_by_item($it['it_id']) ?>
							</button>
						</div>
						<div>
							<button type="button" onclick="na_sns_share('<?php echo na_seo_text($it['it_name']) ?>', '<?php echo shop_item_url($it['it_id']) ?>', '<?php echo (isset($imgs[0]) && $imgs[0]) ? $imgs[0] : $nariya['seo_shop_img']; ?>');" class="btn btn-basic btn-sm" title="SNS 공유" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="SNS 공유">
								<i class="bi bi-share-fill"></i>
								<span class="visually-hidden">SNS 공유</span>
							</button>
						</div>
					</div>
				</li>
	            <?php if (!$it['it_use']) { // 판매가능이 아닐 경우 ?>
					<li class="list-group-item d-flex">
						<span>판매가격</span>
						<span class="ms-auto">판매중지</span>
					</li>
	            <?php } else if ($it['it_tel_inq']) { // 전화문의일 경우 ?>
					<li class="list-group-item d-flex">
						<span>판매가격</span>
						<span class="ms-auto">전화문의</span>
					</li>
	            <?php } else { // 전화문의가 아닐 경우?>
					<?php if ($it['it_cust_price']) { ?>
					<li class="list-group-item d-flex">
						<span>시중가격</span>
						<span class="ms-auto"><?php echo display_price($it['it_cust_price']) ?></span>
					</li>
					<?php } // 시중가격 끝 ?>
					<li class="list-group-item d-flex">
						<span>판매가격</span>
						<span class="ms-auto"><strong><?php echo display_price(get_price($it)) ?></strong></span>
					</li>
				<?php } ?>
	            <?php if ($it['it_maker']) { ?>
					<li class="list-group-item d-flex">
						<span>제조사</span>
						<span class="ms-auto"><?php echo $it['it_maker'] ?></span>
					</li>
	            <?php } ?>
	            <?php if ($it['it_origin']) { ?>
					<li class="list-group-item d-flex">
						<span>원산지</span>
						<span class="ms-auto"><?php echo $it['it_origin'] ?></span>
					</li>
	            <?php } ?>
	            <?php if ($it['it_brand']) { ?>
					<li class="list-group-item d-flex">
						<span>브랜드</span>
						<span class="ms-auto"><?php echo $it['it_brand'] ?></span>
					</li>
	            <?php } ?>
	            <?php if ($it['it_model']) { ?>
					<li class="list-group-item d-flex">
						<span>모델</span>
						<span class="ms-auto"><?php echo $it['it_model'] ?></span>
					</li>
	            <?php } ?>
	            <?php 
				/* 재고 표시하는 경우 주석 해제
				<li class="list-group-item d-flex">
					<span>재고수량</span>
					<span class="ms-auto"><?php echo number_format(get_it_stock_qty($it_id)) ?> 개</span>
				</li>
				*/
				?>
	            <?php if ($config['cf_use_point']) { // 포인트 사용한다면 ?>
					<li class="list-group-item d-flex">
						<span>포인트</span>
		                <span class="ms-auto">
							<?php echo ($it['it_point_type'] == 2) ? '구매금액(추가옵션 제외)의 '.$it['it_point'].'%' : number_format(get_item_point($it)).'점'; ?>
		                </span>
		            </li>
	            <?php } ?>
				<li class="list-group-item d-flex">
					<span>배송비</span>
					<span class="ms-auto">
						<?php
							if($it['it_sc_type'] == 1)
								$sc_method = '무료배송';
							else {
								if($it['it_sc_method'] == 1)
									$sc_method = '수령후 지불';
								else if($it['it_sc_method'] == 2)
									$sc_method = '주문시 지불방법 결정';
								else
									$sc_method = '주문시 결제';
							}
							echo $sc_method;
						?>
					</span>
	            </li>
	            <?php if($it['it_buy_min_qty']) { ?>
				<li class="list-group-item d-flex">
	                <span>최소구매수량</span>
	                <span class="ms-auto"><?php echo number_format($it['it_buy_min_qty']) ?> 개</span>
	            </li>
	            <?php } ?>
	            <?php if($it['it_buy_max_qty']) { ?>
				<li class="list-group-item d-flex">
	                <span>최대구매수량</span>
	                <span class="ms-auto"><?php echo number_format($it['it_buy_max_qty']) ?> 개</span>
	            </li>
	            <?php } ?>
		        <?php if($is_soldout) { ?>
					<li class="list-group-item bg-body-tertiary">
						상품의 재고가 부족하여 구매할 수 없습니다.
					</li>
				<?php } ?>
				<li id="btn-cart-buy" class="list-group-item py-3">
					<?php if ($is_orderable) { ?>
						<button type="button" onclick="na_cart('<?php echo $it['it_id'] ?>');" class="btn btn-primary btn-lg w-100 mb-2" title="주문/장바구니">
							<i class="bi bi-cart4"></i>
							주문/장바구니
						</button>
					<?php } else if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
						<button type="button" onclick="popup_stocksms('<?php echo $it['it_id'] ?>');" id="sit_btn_alm" class="btn btn-primary btn-lg w-100 mb-2" title="재입고알림">
							<i class="bi bi-phone-vibrate"></i>
							재입고알림
						</button>
					<?php } ?>

					<div class="row gx-2">
						<div class="col">
							<button type="button" onclick="na_wishlist('<?php echo $it['it_id'] ?>');" class="btn btn-basic w-100" title="위시리스트">
								<i class="bi bi-heart"></i>
								위시
							</button>
						</div>
						<div class="col">
							<button type="button" onclick="popup_item_recommend('<?php echo $it['it_id'] ?>');" id="sit_btn_rec" class="btn btn-basic  w-100">
								<i class="bi bi-envelope"></i>
								추천
							</button>
						</div>
						<?php if(isset($item_list_href) && $item_list_href) { ?>
							<div class="col">
								<a href="<?php echo $item_list_href ?>" class="btn btn-basic w-100">
									<i class="bi bi-grid"></i>
									목록
								</a>
							</div>
						<?php } ?>
					</div>
				</li>
			</ul>
			<script>
				// 추천메일
				function popup_item_recommend(it_id) {
					if (!g5_is_member) {
						na_confirm('회원만 추천하실 수 있습니다.', function(){
							document.location.href = "<?php echo G5_BBS_URL ?>/login.php?url=<?php echo urlencode(shop_item_url($it['it_id'])) ?>";
						});
						return false;
					} else {
						popup_window("<?php echo G5_SHOP_URL ?>/itemrecommend.php?it_id=" + it_id, "itemrecommend", "scrollbars=yes,width=616,height=420,top=10,left=10");
					}
				}
		
				// 재입고SMS 알림
				function popup_stocksms(it_id) {
					popup_window("<?php echo G5_SHOP_URL ?>/itemstocksms.php?it_id=" + it_id, "itemstocksms", "scrollbars=yes,width=616,height=420,top=10,left=10");
				}
			</script>
		</div>
	</div>

	<?php if ($prev_href || $next_href) { ?>
		<div id="sit_siblings" class="d-flex px-3 border-top pt-3">
			<div>
				<?php 
					$prev_href = str_replace('id="siblings_prev">', 'id="siblings_prev" class="btn btn-basic"><i class="bi bi-arrow-left-circle"></i> ', $prev_href);
					$prev_title = str_replace('sound_only', 'visually-hidden', $prev_title);
					echo $prev_href.$prev_title.$prev_href2; 
				?>
			</div>
			<div class="ms-auto">
				<?php 
					$next_href = str_replace('id="siblings_next">', 'id="siblings_next" class="btn btn-basic">', $next_href);
					$next_title = str_replace('sound_only', 'visually-hidden', $next_title);
					$next_href2 = str_replace('</a>', ' <i class="bi bi-arrow-right-circle"></i></a>', $next_href2);
					echo $next_href.$next_title.$next_href2; 
				?>
			</div>
		</div>
	<?php } ?>

</section>

<div id="buyCart" class="fixed-bottom p-3 border-top bg-body-tertiary" style="display:none; z-index:10;">
	<div class="d-flex gap-2 justify-content-center">
		<div>
		<?php if ($is_orderable) { ?>
			<button type="button" onclick="na_cart('<?php echo $it['it_id'] ?>');" class="btn btn-primary" title="주문/장바구니" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="주문/장바구니">
				<i class="bi bi-cart4"></i>
				<span class="visually-hidden">주문/장바구니</span>
			</button>
		<?php } ?>
		<?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
			<button type="button" onclick="popup_stocksms('<?php echo $it['it_id'] ?>');" id="sit_btn_alm" class="btn btn-primary" title="재입고알림" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="재입고알림">
				<i class="bi bi-phone-vibrate"></i>
				<span class="visually-hidden">재입고알림</span>
			</button>
		<?php } ?>
		</div>
		<div>
			<button type="button" onclick="na_wishlist('<?php echo $it['it_id'] ?>');" class="btn btn-basic" title="위시리스트" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="위시리스트">
				<i class="bi bi-heart"></i>
				<span class="visually-hidden">위시리스트</span>
			</button>
		</div>
		<div>
			<button type="button" onclick="na_sns_share('<?php echo na_seo_text($it['it_name']) ?>', '<?php echo shop_item_url($it['it_id']) ?>', '<?php echo (isset($imgs[0]) && $imgs[0]) ? $imgs[0] : $nariya['seo_shop_img']; ?>');" class="btn btn-basic" title="SNS 공유" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="SNS 공유">
				<i class="bi bi-share-fill"></i>
				<span class="visually-hidden">SNS 공유</span>
			</button>
		</div>

		<div>
			<a href="#sit_inf" class="btn btn-basic" title="상품정보" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="상품정보">
				<i class="bi bi-info-circle"></i>
				<span class="visually-hidden">상품정보</span>
			</a>
		</div>

		<div>
			<a href="#sit_use" class="btn btn-basic" title="사용후기" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="사용후기">
				<i class="bi bi-chat-square-text"></i>
				<span class="visually-hidden">사용후기</span>
			</a>
		</div>
		
		<div>
			<a href="#sit_qa" class="btn btn-basic" title="상품문의" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="상품문의">
				<i class="bi bi-question-circle"></i>
				<span class="visually-hidden">상품문의</span>
			</a>
		</div>

		<?php if(isset($item_list_href) && $item_list_href) { ?>
			<div>
				<a href="<?php echo $item_list_href ?>" class="btn btn-basic" title="카테고리 목록" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="카테고리 목록">
					<i class="bi bi-grid"></i>
					<span class="visually-hidden">카테고리 목록</span>
				</a>
			</div>
		<?php } ?>
	</div>
</div>

<script>
$(function(){
	$(window).on('scroll', function(){

		var screenHeight = $(window).height();
		var documentHeight = $(document).height() * 0.9;

		if ($(this).scrollTop() > screenHeight && $(this).scrollTop() < documentHeight) {
			$('#buyCart').slideDown("fast");
		} else {
			$('#buyCart').slideUp("fast");
		}
	});
});
</script>