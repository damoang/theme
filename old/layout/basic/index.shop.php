<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 타이틀
echo na_widget('shop-banner-carousel', 'shop-banner-title');

// 메인에서 타이틀 풀페이지를 위해 헤더 카피 영역 숨김처리
?>
<style>
#header-copy { 
	display:none; }
</style>
<div id="main-wrap" class="site-main-wrap bg-body">
	<div class="container px-0 px-sm-3 py-3 py-3 py-sm-4">

		<section>
			<header>
				<h2 class="text-center fs-1 px-3 py-4 mb-0">
					<a href="<?php echo shop_type_url('1') ?>">
						히트상품
					</a>
				</h2>
			</header>
			<div class="mb-4">
				<?php 
					// 위젯설정 초기값
					$options = array();
					$options['rows'] = "6";
					$options['type1'] = "1";
					$options['option'] = "
loop:true,
margin: 20,
responsive:{
	0:{ items: 1, stagePadding: 60 },
	576:{ items: 2, stagePadding: 80 },
	768:{ items: 2, stagePadding: 100 },
	992:{ items: 3, stagePadding: 120 }
}, ";
					echo na_widget('it-gallery-slider', 'hit-item', $options);
				?>
			</div>
		</section>

		<section>
			<header>
				<h2 class="text-center fs-1 px-3 py-4 mb-0">
					<a href="<?php echo shop_type_url('2') ?>">
						추천상품
					</a>
				</h2>
			</header>
			<div class="px-3 px-sm-0 mb-4">
				<?php 
					// 위젯설정 초기값
					$options = array();
					$options['rows'] = "6";
					$options['type2'] = "1";
					$options['option'] = "
loop:true,
margin: 20,
responsive:{
	0:{ items: 1 },
	576:{ items: 2 },
	768:{ items: 3 },
	992:{ items: 4 }
}, ";
					echo na_widget('it-gallery-slider', 'good-item', $options);
				?>
			</div>
		</section>

		<section>
			<header>
				<h2 class="text-center fs-1 px-3 py-4 mb-0">
					<a href="<?php echo shop_type_url('4') ?>">
						인기상품
					</a>
				</h2>
			</header>
			<div class="mb-4">
				<?php 
					// 위젯설정 초기값
					$options = array();
					$options['rows'] = "6";
					$options['type4'] = "1";
					$options['option'] = "
loop:true,
margin: 20,
responsive:{
	0:{ items: 1, stagePadding: 60 },
	576:{ items: 2, stagePadding: 80 },
	768:{ items: 2, stagePadding: 100 },
	992:{ items: 3, stagePadding: 120 }
}, ";
					echo na_widget('it-gallery-slider', 'popular-item', $options);
				?>
			</div>
		</section>

		<section>
			<header>
				<h2 class="text-center fs-1 px-3 py-4 mb-0">
					<a href="<?php echo shop_type_url('5') ?>">
						할인상품
					</a>
				</h2>
			</header>
			<div class="px-3 px-sm-0 mb-4">
				<?php 
					// 위젯설정 초기값
					$options = array();
					$options['rows'] = "6";
					$options['type5'] = "1";
					$options['option'] = "
loop:true,
margin: 20,
responsive:{
	0:{ items: 1 },
	576:{ items: 2 },
	768:{ items: 3 },
	992:{ items: 4 }
}, ";

					echo na_widget('it-gallery-slider', 'dc-item', $options);
				?>
			</div>
		</section>

		<section>
			<header>
				<h2 class="text-center fs-1 px-3 py-4 mb-0">
					<a href="<?php echo shop_type_url('3') ?>">
						최신상품
					</a>
				</h2>
			</header>
			<div class="px-3 px-sm-0 mb-4">
				<?php 
					// 위젯설정 초기값
					$options = array();
					$options['rows'] = "12";
					$options['grid'] = "g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4";
					echo na_widget('it-gallery', 'new-item', $options);
				?>
			</div>
		</section>

	</div>
</div>