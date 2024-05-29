<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 1단 칼럼 페이지 아이디($pid)
$one_cols = array(
    G5_BBS_DIR . '-page-password_lost', // 아이디 및 비밀번호 찾기 페이지
    G5_BBS_DIR . '-page-register', // 회원약관 페이지
    G5_BBS_DIR . '-page-register_form', // 회원가입폼 페이지
    G5_BBS_DIR . '-page-register_result', // 회원가입폼 완료
    G5_BBS_DIR . '-page-login', // 로그인 페이지
    G5_BBS_DIR . '-page-register_email', // 메일인증 메일주소 변경 페이지
    G5_BBS_DIR . '-page-password_reset', // 비밀번호 변경 페이지
    G5_BBS_DIR . '-page-password', // 비밀번호 입력 페이지
    G5_BBS_DIR . '-page-member_cert_refresh', // 본인인증을 다시 해주세요.
    G5_BBS_DIR . '-page-member_confirm', // 회원 비밀번호 확인
);

// 1단 체크
(in_array($page_id, $one_cols)) ? define('IS_ONECOL', true) : define('IS_ONECOL', false);

?>
<!doctype html>
<html lang="ko" data-bs-theme="light"
    class="<?php echo (G5_IS_MOBILE) ? 'is-mobile' : 'is-pc'; ?> is-bbs">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" id="meta_viewport"
            content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">
        <meta name="HandheldFriendly" content="true">
        <meta name="format-detection" content="telephone=no">
        <?php
        if ($config['cf_add_meta'])
            echo $config['cf_add_meta'] . PHP_EOL;
        ?>
        <title><?php echo $g5_head_title; ?></title>
        <link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/css/bootstrap.min.css">
        <?php
        add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_URL . '/css/' . (G5_IS_MOBILE ? 'mobile' : 'default') . '.css">', 0);
        add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_URL . '/css/nariya.css">', 0);
        add_stylesheet('<link rel="stylesheet" href="' . LAYOUT_URL . '/css/style.css">', 0);
        add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_URL . '/css/bootstrap-icons.min.css">', 0);
        add_stylesheet('<link rel="stylesheet" href="' . G5_JS_URL . '/font-awesome/css/font-awesome.min.css">', 0);
        add_stylesheet('<link rel="canonical" href="' . $pset['href'] . '">', 100);
        $agent = $_SERVER["HTTP_USER_AGENT"];
        if (!preg_match('/macintosh|mac os x/i', $agent)) {
            add_stylesheet('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500&family=Roboto:wght@300;400;500&display=swap">', 0);
        }
        ?>

        <script>

            (function () {
                'use strict';

                const shortcuts = {
                    'KeyA': '/bbs/noti.php',
                    'KeyK': '/notice',
                    'KeyF': '/free',
                    'KeyQ': '/qa',
                    'KeyI': '/hello',
                    'KeyN': '/new',
                    'KeyT': '/tutorial',
                    'KeyL': '/lecture',
                    'KeyP': '/pds',
                    'KeyE': '/economy',
                    'KeyG': '/gallery',
                    'KeyS': '/bbs/group.php?gr_id=group',
                    'KeyV': '/governance',
                    'KeyC': '/bbs/group.php?gr_id=community',
                    'KeyB': '/bug',
                    'KeyJ': '/truthroom',
                    'KeyH': '/',
                    // Refresh the page when 'R' is pressed
                    'KeyR': 'refresh',
                    // 추가 단축키와 페이지를 여기에 추가하세요.
                };


                function isInputElement(element) {
                    return ['INPUT', 'TEXTAREA', 'SELECT'].includes(element.tagName);
                }

                function isKeyCombination(event) {
                    return event.ctrlKey || event.shiftKey || event.altKey || event.metaKey;
                }

                function isContentEditableElement(element) {
                    while (element) {
                        if (element.contentEditable === 'true') {
                            return true;
                        }
                        element = element.parentElement;
                    }
                    return false;
                }

                function handleKeyPress(event) {
                    if (isInputElement(event.target) || isKeyCombination(event) || isContentEditableElement(event.target)) {
                        return;
                    }

                    const code = event.code;
                    if (shortcuts[code]) {
                        if (shortcuts[code] === 'refresh') {
                            window.location.reload(); // Refresh the page
                        } else {
                            window.location.href = shortcuts[code]; // Navigate to the specified URL
                        }
                    }
                }

                window.addEventListener('keydown', handleKeyPress);


            })();


            function set_ui_custom() {
                try {
                    $("#user_ui_custom_styles").remove();
                } catch {
                }
                var ui_custom_storage_str = localStorage.getItem("ui_custom");
                if (ui_custom_storage_str != null && ui_custom_storage_str != "") {
                    var ui_obj = JSON.parse(ui_custom_storage_str);
                    var ui_keys = Object.keys(ui_obj);
                    var ui_custom_style = "";
                    var ui_root_style = "";
                    var ui_media992_style = "";
                    if (ui_obj.ui_custom != null && ui_obj.ui_custom) {
                        //화면 너비 설정
                        if (ui_obj.show_width != null) {
                            ui_custom_style += ".container {max-width: " + ui_obj.show_width + "px !important;}\n";
                        }
                        //메뉴 스크롤 적용
                        if (ui_obj.menu_scroll != null && ui_obj.menu_scroll) {
                            ui_custom_style += "#header-copy.header-copy {display: none;}\n";
                            ui_custom_style += "#header-navbar.site-navbar {position: relative !important;display: block !important; height: 64px !important;}\n";
                        }

                        //닉네임 감추기
                        if (ui_obj.hide_nick != null && ui_obj.hide_nick) {
                            var profile_html = $(".sv_member.ellipsis-1").html();
                            $(".sv_member.ellipsis-1").html(profile_html.substr(0, profile_html.indexOf("/span>") + 6) + " 회원님");
                        }

                        //root style 글씨체 및 크기
                        if (ui_obj.font_family != null) {
                            ui_root_style += "--bs-body-font-family:" + ui_obj.font_family + " !important;\n";
                        }
                        if (ui_obj.font_size != null) {
                            ui_root_style += "--bs-body-font-size:" + ui_obj.font_size + "em !important;\n";
                        }
                        if (ui_obj.line_height != null) {
                            ui_root_style += "--bs-body-line-height:" + ui_obj.line_height + " !important;\n";
                        }

                        //media 992px 이상
                        //왼쪽 메뉴 적용
                        if (ui_obj.left_menu != null && ui_obj.left_menu) {
                            ui_media992_style += ".order-2 {order: 0 !important;}\n";
                        }
                        //메뉴바 크기 설정
                        if (ui_obj.menu_width != null) {
                            var content_width = 100 - ui_obj.menu_width;
                            ui_media992_style += ".col-lg-9 {width: " + content_width + "% !important;}\n";
                            ui_media992_style += ".col-lg-3 {width: " + ui_obj.menu_width + "% !important;}\n";
                        }
                        //검색메뉴 항상 보임
                        if (ui_obj.list_search != null && ui_obj.list_search) {
                            ui_media992_style += "#boardSearch {display: block !important;}\n";
                        }

                        if (ui_root_style != "") {
                            ui_custom_style += ":root {\n" + ui_root_style + "}\n";
                        }
                        if (ui_media992_style != "") {
                            ui_custom_style += "@media (min-width: 992px) {\n" + ui_media992_style + "}\n";
                        }
                        if (ui_custom_style != "") {
                            $("body").append("<style id=\"user_ui_custom_styles\">\n" + ui_custom_style + "</style>");

                        }
                    }
                }
            }


            document.addEventListener('DOMContentLoaded', function () {
                try {
                    set_ui_custom();
                } catch (error) {
                    console.error('Failed to initialize custom UI settings:', error);
                }
            });

            // 자바스크립트에서 사용하는 전역변수 선언
            var g5_url = "<?php echo G5_URL ?>";
            var g5_bbs_url = "<?php echo G5_BBS_URL ?>";
            var g5_is_member = "<?php echo isset($is_member) ? $is_member : ''; ?>";
            var g5_is_admin = "<?php echo isset($is_admin) ? $is_admin : ''; ?>";
            var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
            var g5_bo_table = "<?php echo isset($bo_table) ? $bo_table : ''; ?>";
            var g5_sca = "<?php echo isset($sca) ? $sca : ''; ?>";
            var g5_editor = "<?php echo ($config['cf_editor'] && isset($board['bo_use_dhtml_editor']) && $board['bo_use_dhtml_editor']) ? $config['cf_editor'] : ''; ?>";
            var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
            <?php if(defined('G5_IS_ADMIN')) { ?>
            var g5_admin_url = "<?php echo G5_ADMIN_URL ?>";
            <?php } ?>
            var na_url = "<?php echo NA_URL ?>";
        </script>
        <script src="<?php echo G5_THEME_URL ?>/js/jquery-3.5.1.min.js?ver=<?php echo G5_JS_VER; ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11?ver=<?php echo G5_JS_VER; ?>"></script>
        <script src="<?php echo G5_THEME_URL ?>/js/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
        <script src="<?php echo G5_THEME_URL ?>/js/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
        <script src="<?php echo G5_THEME_URL ?>/js/bootstrap.bundle.min.js?ver=<?php echo G5_JS_VER; ?>"></script>
        <script src="<?php echo G5_THEME_URL ?>/js/clipboard.min.js"></script>
        <script src="<?php echo G5_THEME_URL ?>/js/nariya.js?ver=2404281"></script>
        <script src="<?php echo LAYOUT_URL ?>/js/darkmode.js?ver=<?php echo G5_JS_VER; ?>"
                data-cfasync="false"></script>
        <?php
        if (!defined('G5_IS_ADMIN'))
            echo $config['cf_add_script'];
        ?>


    </head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg" class="visually-hidden">' . $sr_admin_msg . get_text($member['mb_nick']) . '님 로그인 중 ';
    echo '<a href="' . G5_BBS_URL . '/logout.php">로그아웃</a></div>';
}
