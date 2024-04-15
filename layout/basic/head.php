<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 스크립트
add_javascript('<script src="'.LAYOUT_URL.'/js/layout.js"></script>', 0);

if(IS_SHOP) {
	$member['todayview_cnt'] = get_boxcart_datas_count();
	$member['cart_cnt'] = get_view_today_items_count();
	$member['wishlist_cnt'] = get_wishlist_datas_count();
}

// 메뉴 및 페이지 위치 생성
list($menu, $nav) = na_menu();

// 팝업레이어 : index에서만 실행
if(IS_INDEX)
	include G5_BBS_PATH.'/newwin.inc.php';
?>
<div class="site-wrap w-100 h-100">
	<div id="header-copy" class="header-copy">&nbsp;<?php //위치 확보를 위한 헤더 영역 복제 ?></div>
	<header id="header-navbar" class="site-navbar">
		<div class="container px-3">
			<div class="d-flex gap-3 align-items-center">
				<div>
					<a href="<?php echo HOME_URL ?>" class="fs-2 fw-bold">
                        <img height="48" src="https://damoang.net/logo/1.svg"/>

                    </a>
				</div>
				<div class="ms-auto">
					<?php
					// 메뉴 및 메뉴위치 : 좌측 .me-auto, 중앙 .mx-auto, 우측 .ms-auto
					include_once LAYOUT_PATH.'/component/menu.php';
					?>
				</div>

				<div class="dropdown">
					<a href="#dark" id="bd-theme" data-bs-toggle="dropdown" aria-expanded="false" class="site-icon">
						<span class="theme-icon-active" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="다크모드">
							<i class="bi bi-sun"></i>
							<span class="visually-hidden">다크모드</span>
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-end py-0 shadow-none border navbar-dropdown-caret theme-dropdown-menu" aria-labelledby="bd-theme" data-bs-popper="static">
						<div class="card position-relative border-0">
							<div class="card-body p-1">
								<button type="button" class="dropdown-item rounded-1" data-bs-theme-value="light">
									<span class="me-2 theme-icon">
										<i class="bi bi-sun"></i>
									</span>
									Light
								</button>
								<button type="button" class="dropdown-item rounded-1 my-1" data-bs-theme-value="dark">
									<span class="me-2 theme-icon">
										<i class="bi bi-moon-stars"></i>
									</span>
									Dark
								</button>
								<button type="button" class="dropdown-item rounded-1" data-bs-theme-value="auto">
									<span class="me-2 theme-icon">
										<i class="bi bi-circle-half"></i>
									</span>
									Auto
								</button>
							</div>
						</div>
					</div>
				</div>

				<div>
					<a href="#newOffcanvas" data-bs-toggle="offcanvas" data-bs-target="#newOffcanvas" aria-controls="newOffcanvas" class="site-icon">
						<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="새글/새댓글">
							<i class="bi bi-lightning"></i>
							<span class="visually-hidden">새글/새댓글</span>
						</span>
					</a>
				</div>
				<div>
					<a href="#search" data-bs-toggle="offcanvas" data-bs-target="#searchOffcanvas" aria-controls="searchOffcanvas" class="site-icon">
						<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="검색">
							<i class="bi bi-search"></i>
							<span class="visually-hidden">검색</span>
						</span>
					</a>
				</div>
				<div>
					<a href="#memberOffcanvas" data-bs-toggle="offcanvas" data-bs-target="#memberOffcanvas" aria-controls="memberOffcanvas" class="site-icon">
						<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo ($is_member) ? '마이메뉴' : '로그인'; ?>">
							<i class="bi bi-person-circle"></i>
							<span class="visually-hidden"><?php echo ($is_member) ? '마이메뉴' : '로그인'; ?></span>
						</span>
					</a>
				</div>
				<div>
					<a href="#menuOffcanvas" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
						<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="메뉴">
							<i class="bi bi-list fs-4"></i>
							<span class="visually-hidden">메뉴</span>
						</span>
					</a>
				</div>
			</div>
		</div><!-- .container -->
	</header>

<?php
// 메인이 아닐 경우
if(!IS_INDEX) {
?>
	<div id="main-wrap" class="bg-body">
		<div class="container px-0 px-sm-3<?php echo (IS_ONECOL) ? ' py-3' : ''; ?>">
		<?php if(IS_ONECOL) { // 1단 일 때
			// 페이지 타이틀
			include_once LAYOUT_PATH.'/component/title.php';
		} else { // 2단 일 때
?>
			<div class="row row-cols-1 row-cols-md-2 g-3">
				<div class="order-1 col-md-8 col-lg-9">
					<div class="sticky-top py-3">
						<?php
							// 페이지 타이틀
							include_once LAYOUT_PATH.'/component/title.php';
						?>


		<?php } ?>

                        <?php if (!empty($bo_table)): ?>
                            <a href="/<?php echo $bo_table ?>?sca=&sfl=mb_id,1&stx=<?php echo $member['mb_id'] ?>">[내글
                                보기]</a>
                        <?php endif; ?>
<?php } // 메인이 아닐 경우 ?>
