<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!IS_YC) {
    $default['de_admin_company_name'] = '다모앙'; // 회사명
    $default['de_admin_company_owner'] = '김선도'; // 대표자명
    $default['de_admin_company_addr'] = '서울특별시 강남구 테헤란로70길 12, 4층 402-J49호(대치동)'; // 주소
    $default['de_admin_company_saupja_no'] = '276-13-02570'; // 사업자 등록번호
    $default['de_admin_company_tel'] = '02-123-4567'; // 전화
    $default['de_admin_company_fax'] = '02-123-4568'; // 팩스
    $default['de_admin_tongsin_no'] = '제 OO구 - 123호'; // 통신판매업신고
    $default['de_admin_info_name'] = '김선도'; //개인정보관리책임자
}

// 메인이 아닐 경우
if (!IS_INDEX) {
    ?>
    <?php if (!IS_ONECOL) { // 2단 일 때 ?>
        </div>
        </div>
        <div class="order-2 col-md-4 col-lg-3">
            <div class="py-3">
                <?php include_once LAYOUT_PATH . '/component/sidebar.php'; // 사이드바 ?>
            </div>
        </div>
        </div>
    <?php } ?>
    </div>
    </div>
<?php } // 메인이 아닐 경우 ?>

<footer class="site-footer-wrap bg-body-tertiary py-4">
    <div class="container px-3 text-center">
        <div class="mb-2">
            <a href="<?php echo get_pretty_url('content', 'company'); ?>">
                사이트 소개
                <i class="bar">&nbsp;</i>
            </a>
            <a href="<?php echo get_pretty_url('content', 'provision'); ?>">
                이용약관
                <i class="bar">&nbsp;</i>
            </a>
            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">
                개인정보 처리방침
                <i class="bar">&nbsp;</i>
            </a>
            <a href="<?php echo get_pretty_url('content', 'operation_policy'); ?>">
                운영정책
                <i class="bar">&nbsp;</i>
            </a>
            <a href="/claim">
                소명 게시판
                <i class="bar">&nbsp;</i>
            </a>
            <a href="<?php echo get_device_change_url(); ?>">
                <?php echo (G5_IS_MOBILE) ? 'PC' : '모바일'; ?> 버전
            </a>
        </div>

        <div class="lh-lg mb-1">
            회사명 : <?php echo $default['de_admin_company_name'] ?>
            <span class="bar-sm">&nbsp;</span>
            대표 : <?php echo $default['de_admin_company_owner'] ?>
            <span class="bar-sm">&nbsp;</span>
            사업자 등록번호 : <?php echo $default['de_admin_company_saupja_no'] ?>

        </div>
        <div class="mb-2">
            주소 : <?php echo $default['de_admin_company_addr'] ?>
        </div>

            <div>contact : contact@damoang.net</div>

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
        <a href="#menuOffcanvas" class="btn-menu btn btn-basic btn-sm" data-bs-toggle="offcanvas"
        data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas" title="전체메뉴">
            <i class="bi bi-list"></i>
            <span class="visually-hidden">전체메뉴</span>
        </a>
        <a href="#loginOffcanvas" class="btn-member btn btn-basic btn-sm" data-bs-toggle="offcanvas"
        data-bs-target="#memberOffcanvas" aria-controls="memberOffcanvas" title="마이메뉴">
            <i class="bi bi-person-circle"></i>
            <span class="visually-hidden">마이메뉴</span>
        </a>
        <a href="#newOffcanvas" class="btn-new btn btn-basic btn-sm" data-bs-toggle="offcanvas"
        data-bs-target="#newOffcanvas" aria-controls="newOffcanvas" title="새글/새댓글">
            <i class="bi bi-lightning"></i>
            <span class="visually-hidden">새글/새댓글</span>
        </a>
        <div class="dropdown" data-bs-toggle="dropdown" aria-expanded="false" class="site-icon">
            <a href="#dark" class="btn btn-basic btn-sm " id="bd-theme">
                <i class="bi bi-sun"></i>
                <span class="visually-hidden">테마 변경</span>
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
        <?php if (IS_YC) { ?>
            <?php if (IS_SHOP) { ?>
                <a href="<?php echo G5_URL ?>" class="btn btn-basic btn-sm">
                    <i class="bi bi-arrow-right-circle"></i>
                    <?php echo $config['cf_title'] ?>
                </a>
            <?php } else { ?>
                <a href="<?php echo G5_SHOP_URL ?>" class="btn btn-basic btn-sm">
                    <i class="bi bi-arrow-right-circle"></i>
                    <?php echo (isset($nariya['seo_shop_title']) && $nariya['seo_shop_title']) ? $nariya['seo_shop_title'] : '쇼핑몰'; ?>
                </a>
            <?php } ?>
        <?php } ?>
    </div>
    <?php
    $offcanvas_buttons = ob_get_contents();
    ob_end_flush();
    ?>
</div>

<?php
// 전체검색 오프캔버스
include_once LAYOUT_PATH . '/component/search.offcanvas.php';

// 모바일 메뉴 오프캔버스
include_once LAYOUT_PATH . '/component/menu.offcanvas.php';

// 멤버 오프캔버스
include_once LAYOUT_PATH . '/component/member.offcanvas.php';

// 새글 오프캔버스
include_once LAYOUT_PATH . '/component/new.offcanvas.php';

// 알림 오프캔버스
if ($is_member)
    include_once LAYOUT_PATH . '/component/noti.offcanvas.php';

// 번역 오프캔버스
//include_once LAYOUT_PATH.'/component/trans.offcanvas.php';



// 신고 모달
include_once LAYOUT_PATH . '/component/singo.modal.php';

if ($config['cf_analytics'])
    echo $config['cf_analytics'];
?>

<?php if (!G5_IS_MOBILE) { // PC에서만 실행 ?>
    <script src="<?php echo LAYOUT_URL ?>/js/topbar.min.js"></script>
    <script src="<?php echo LAYOUT_URL ?>/js/topbar.load.js"></script>
<?php } ?>
