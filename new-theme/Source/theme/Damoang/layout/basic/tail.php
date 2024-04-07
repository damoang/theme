<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 메인이 아닐 경우
if(!IS_INDEX) {
?>
		<?php if(!IS_ONECOL) { // 2단 일 때 ?>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
<?php } // 메인이 아닐 경우 ?>

	<footer class="site-footer-wrap bg-body-tertiary py-4">
		<div class="container px-3 text-center">

			<div class="small">
				Copyright &copy; <b><?php $host = @parse_url(G5_URL); echo $host['host'] ?></b>. All rights reserved.
			</div>

		</div>
	</footer>
</div>

<div id="toTop" class="position-fixed bottom-0 end-0 lh-1" style="display:none; z-index:11;">
	<a href="#top" class="d-none d-sm-inline-block fs-1 m-3">
		<i class="bi bi-arrow-up-square-fill"></i>
	</a>
</div>

<div class="d-none">
<?php 
// 오프캔버스 공통 버튼셋	
ob_start(); 
?>
	<div class="d-flex gap-2">
		<a href="<?php echo HOME_URL ?>" class="btn btn-basic btn-sm" title="홈으로">
			<i class="bi bi-house-door"></i>
			<span class="visually-hidden">홈으로</span>
		</a>
		<a href="#menuOffcanvas" class="btn-menu btn btn-basic btn-sm" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas" title="전체메뉴">
			<i class="bi bi-list"></i>
			<span class="visually-hidden">전체메뉴</span>
		</a>
		<a href="#loginOffcanvas" class="btn-member btn btn-basic btn-sm" data-bs-toggle="offcanvas" data-bs-target="#memberOffcanvas" aria-controls="memberOffcanvas" title="마이메뉴">
			<i class="bi bi-person-circle"></i>
			<span class="visually-hidden">마이메뉴</span>
		</a>
	</div>
<?php
$offcanvas_buttons = ob_get_contents();
ob_end_flush();
?>
</div>

<?php 
// 전체검색 오프캔버스
include_once LAYOUT_PATH.'/component/search.offcanvas.php';

// 모바일 메뉴 오프캔버스
include_once LAYOUT_PATH.'/component/menu.offcanvas.php';

// 멤버 오프캔버스
include_once LAYOUT_PATH.'/component/member.offcanvas.php';  

// 새글 오프캔버스
include_once LAYOUT_PATH.'/component/new.offcanvas.php';  

// 알림 오프캔버스
if($is_member) 
	include_once LAYOUT_PATH.'/component/noti.offcanvas.php';

// 번역 오프캔버스
include_once LAYOUT_PATH.'/component/trans.offcanvas.php';  

// 영카트 쇼핑몰 사용시 출력
if(IS_YC) {
	// 오늘 본 상품 오프캔버스
	include_once LAYOUT_PATH.'/component/todayview.offcanvas.php';

	// 장바구니 오프캔버스
	include_once LAYOUT_PATH.'/component/cart.offcanvas.php';

	// 위시리스트 오프캔버스
	include_once LAYOUT_PATH.'/component/wishlist.offcanvas.php';

	// 이벤트 오프캔버스
	include_once LAYOUT_PATH.'/component/event.offcanvas.php';

	// 사용후기 오프캔버스
	include_once LAYOUT_PATH.'/component/itemuse.offcanvas.php';

	// 상품문의 오프캔버스
	include_once LAYOUT_PATH.'/component/itemqa.offcanvas.php';
}

// 신고 모달
include_once LAYOUT_PATH.'/component/singo.modal.php';

if ($config['cf_analytics'])
    echo $config['cf_analytics'];
?>

<?php if(!G5_IS_MOBILE) { // PC에서만 실행?>
<script src="<?php echo LAYOUT_URL ?>/js/topbar.min.js"></script>
<script src="<?php echo LAYOUT_URL ?>/js/topbar.load.js"></script>
<?php } ?>