<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 사이트 메뉴
$siteMenus = include 'inc.menu.php';

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
                    <?php echo na_widget('damoang-logo', 'default'); ?>
                </div>
                <div class="ms-auto">
                    <?php
                    // 메뉴 및 메뉴위치 : 좌측 .me-auto, 중앙 .mx-auto, 우측 .ms-auto
                    include_once LAYOUT_PATH.'/component/menu.php';
                    ?>
                </div>
                <div>
                    <a href="#newOffcanvas" data-bs-toggle="offcanvas" data-bs-target="#newOffcanvas" aria-controls="newOffcanvas" class="site-icon">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="새글/새댓글">
                            <i class="bi bi-lightning"></i>
                            <span class="visually-hidden">새글/새댓글</span>
                        </span>
                    </a>
                </div>
                <?php if ($member['mb_level'] >= 2) { ?>
                <div>
                    <a href="#search" data-bs-toggle="offcanvas" data-bs-target="#searchOffcanvas" aria-controls="searchOffcanvas" class="site-icon">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="검색">
                            <i class="bi bi-search"></i>
                            <span class="visually-hidden">검색</span>
                        </span>
                    </a>
                </div>
                <?php } ?>
                <div>
                    <a href="#memberOffcanvas" data-bs-toggle="offcanvas" data-bs-target="#memberOffcanvas" aria-controls="memberOffcanvas" class="site-icon">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo ($is_member) ? '마이메뉴' : '로그인'; ?>">
                            <i class="bi bi-person-circle"></i>
                            <span class="visually-hidden"><?php echo ($is_member) ? '마이메뉴' : '로그인'; ?></span>
                        </span>
                    </a>
                </div>
                <?php if ($is_member) { ?>
                    <div>
                        <a href="#notiOffcanvas" data-bs-toggle="offcanvas" data-bs-target="#notiOffcanvas" aria-controls="notiOffcanvas" class="site-icon">
                            <span class="position-relative" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="알림">
                                <i class="bi bi-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle spinner-grow spinner-grow bg-primary d-none da-noti-indicator" style="--bs-spinner-width: 5px; --bs-spinner-height: 5px;">
                                    <span class="visually-hidden">새 알림이 있습니다</span>
                                </span>
                                <span class="visually-hidden">알림 보기</span>
                            </span>
                        </a>
                    </div>
                <?php } ?>
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
                    <div class="py-3">
                        <?php
                            // 페이지 타이틀
                            include_once LAYOUT_PATH.'/component/title.php';
                        ?>
        <?php } ?>


<?php } // 메인이 아닐 경우 ?>
