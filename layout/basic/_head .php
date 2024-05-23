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
                        <svg width="263" height="76" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" overflow="hidden"><defs><clipPath id="clip0"><rect x="810" y="174" width="263" height="76"/></clipPath><image width="150" height="150" xlink:href="data:image/png;base64,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" preserveAspectRatio="none" id="img1"></image><clipPath id="clip2"><path d="M-0.100453 0.0169123 210589 0.0169123 210589 210589-0.09375 210589Z" fill-rule="evenodd" clip-rule="evenodd"/></clipPath></defs><g clip-path="url(#clip0)" transform="translate(-810 -174)"><g transform="matrix(0.000360892 0 0 0.000360892 810 174)"><g clip-path="url(#clip2)"><use width="100%" height="100%" xlink:href="#img1" transform="matrix(1403.93 0 0 1403.93 -0.100453 0.0169123)"></use></g></g><path d="M1044.36 222.908C1043.06 222.909 1041.76 222.945 1040.46 223.015 1039.56 223.05 1038.87 223.267 1038.41 223.665 1037.94 224.063 1037.71 224.729 1037.71 225.665 1037.71 226.598 1037.94 227.256 1038.41 227.64 1038.87 228.023 1039.56 228.231 1040.46 228.265 1041.76 228.334 1043.06 228.37 1044.36 228.371 1045.66 228.372 1046.96 228.37 1048.26 228.365 1049.56 228.37 1050.86 228.372 1052.16 228.371 1053.46 228.37 1054.76 228.334 1056.06 228.265 1056.96 228.231 1057.64 228.023 1058.11 227.64 1058.57 227.256 1058.81 226.598 1058.81 225.665 1058.81 224.729 1058.57 224.063 1058.11 223.665 1057.64 223.267 1056.96 223.05 1056.06 223.015 1054.76 222.945 1053.46 222.909 1052.16 222.908 1050.86 222.907 1049.56 222.909 1048.26 222.915 1046.96 222.909 1045.66 222.907 1044.36 222.908ZM955.658 220.415 955.658 227.165 962.758 227.165 962.758 220.415ZM896.008 219.415 936.358 219.415 936.358 226.665 920.708 226.665 920.708 234.965 911.608 234.965 911.608 226.665 896.008 226.665ZM1048.26 216.065C1049.76 216.063 1051.25 216.067 1052.73 216.077 1054.22 216.088 1055.71 216.117 1057.21 216.165 1060.19 216.257 1062.46 217.122 1064.01 218.758 1065.57 220.395 1066.35 222.697 1066.36 225.665 1066.33 228.477 1065.52 230.74 1063.93 232.452 1062.34 234.165 1060.13 235.102 1057.31 235.265 1055.71 235.336 1054.1 235.38 1052.48 235.396 1050.87 235.411 1049.26 235.418 1047.66 235.415 1046.26 235.418 1044.85 235.411 1043.43 235.396 1042.02 235.38 1040.61 235.336 1039.21 235.265 1036.38 235.105 1034.17 234.174 1032.58 232.471 1030.99 230.768 1030.18 228.499 1030.16 225.665 1030.17 222.722 1030.96 220.432 1032.52 218.796 1034.08 217.159 1036.34 216.282 1039.31 216.165 1040.81 216.117 1042.3 216.088 1043.78 216.077 1045.27 216.067 1046.76 216.063 1048.26 216.065ZM995.558 211.565C994.197 211.578 993.193 211.964 992.545 212.721 991.897 213.478 991.518 214.526 991.408 215.865 991.265 217.248 991.1 218.656 990.914 220.09 990.727 221.523 990.625 222.931 990.608 224.315 990.628 225.44 990.962 226.202 991.608 226.602 992.253 227.002 993.087 227.19 994.108 227.165 995.249 227.154 996.116 226.838 996.708 226.215 997.299 225.592 997.666 224.725 997.808 223.615 998.006 222.285 998.234 220.806 998.489 219.177 998.744 217.548 998.884 216.094 998.908 214.815 998.902 213.695 998.613 212.872 998.039 212.346 997.465 211.82 996.638 211.559 995.558 211.565ZM995.608 205.165C997.291 205.15 999.002 205.384 1000.74 205.866 1002.48 206.349 1003.95 207.164 1005.14 208.313 1006.34 209.462 1006.96 211.029 1007.01 213.015 1007.01 213.142 1007.01 213.275 1007 213.415 1007 213.554 1006.98 213.688 1006.96 213.815L1005.61 225.865C1005.35 227.869 1004.65 229.466 1003.53 230.654 1002.4 231.841 1001.02 232.693 999.37 233.209 997.724 233.725 995.986 233.977 994.158 233.965 992.409 233.988 990.651 233.797 988.883 233.392 987.116 232.988 985.632 232.23 984.432 231.12 983.231 230.01 982.606 228.408 982.558 226.315 982.557 226.142 982.559 225.975 982.564 225.815 982.569 225.654 982.584 225.488 982.608 225.315 982.899 221.615 983.216 217.915 983.558 214.215 983.938 210.841 985.252 208.476 987.501 207.121 989.75 205.766 992.452 205.114 995.608 205.165ZM948.108 201.565 955.958 201.565 954.908 213.465 963.058 213.465 964.108 201.565 971.958 201.565 970.908 213.465 976.358 213.465 976.358 220.415 971.358 220.415 971.358 227.165 979.358 227.165 979.358 234.065 939.008 234.065 939.008 227.165 947.058 227.165 947.058 220.415 941.958 220.415 941.958 213.465 947.058 213.465ZM1027.36 192.315 1052.91 192.315 1052.91 198.915 1048.16 198.915 1052.96 213.865 1045.61 213.865C1044.87 211.792 1044.13 209.713 1043.4 207.627 1042.66 205.542 1041.99 203.438 1041.41 201.315 1041.25 202.257 1040.8 203.55 1040.06 205.196 1039.33 206.842 1038.54 208.487 1037.7 210.133 1036.86 211.779 1036.21 213.073 1035.76 214.015L1026.81 214.015 1033.61 198.915 1027.36 198.915ZM941.958 192.315 976.358 192.315 976.358 199.215 941.958 199.215ZM898.908 192.315 933.508 192.315 933.508 199.215 906.958 199.215 906.958 201.215 933.008 201.215 933.008 208.115 907.008 208.115 907.008 210.215 934.158 210.215 934.158 217.165 898.908 217.165ZM1056.76 192.265 1064.86 192.265 1064.86 199.515 1070.51 199.515 1070.51 206.415 1064.86 206.415 1064.86 214.465 1056.76 214.465ZM1011.61 192.265 1019.71 192.265 1019.71 209.565 1025.31 209.565 1025.31 216.315 1019.71 216.315 1019.71 234.065 1011.61 234.065ZM991.408 191.615 1001.96 191.615 1001.16 197.265 1008.41 197.265 1008.41 203.915 982.358 203.915 982.358 197.265 990.558 197.265Z" stroke="#042433" stroke-width="3" stroke-linejoin="round" stroke-miterlimit="10" stroke-opacity="0" fill="#0D6EFD" fill-rule="evenodd"/><text fill="#000000" fill-opacity="0" font-family="Arial,Arial_MSFontService,sans-serif" font-size="43.8008" x="896.008" y="229.94">투표하장</text></g></svg>
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
<?php } // 메인이 아닐 경우 ?>
