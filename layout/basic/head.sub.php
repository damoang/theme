<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 쇼핑몰 레이아웃 크기 : sm, lg
define('IS_SHOP_LAYOUT', 'sm');

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
(IS_SHOP || in_array($page_id, $one_cols)) ? define('IS_ONECOL', true) : define('IS_ONECOL', false);

?>
<!doctype html>
<html lang="ko" data-bs-theme="light"
  class="<?php echo (G5_IS_MOBILE) ? 'is-mobile' : 'is-pc'; ?> <?php echo (IS_SHOP) ? 'is-shop' : 'is-bbs'; ?>">

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

  <link rel="apple-touch-icon" sizes="180x180" href="<?= G5_THEME_URL ?>/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= G5_THEME_URL ?>/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= G5_THEME_URL ?>/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="<?= G5_THEME_URL ?>/img/favicon/site.webmanifest">
  <link rel="shortcut icon" href="<?= G5_THEME_URL ?>/img/favicon/favicon.ico">
  <meta name="msapplication-config" content="<?= G5_THEME_URL ?>/img/favicon/browserconfig.xml">

  <script>
  (function() {
    'use strict';

    const shortcuts = {
      'KeyA': '/event',
      'KeyB': '/bug',
      'KeyC': '/bbs/group.php?gr_id=community',
      'KeyE': '/economy',
      'KeyF': '/free',
      'KeyG': '/gallery',
      'KeyH': '/',
      'KeyI': '/hello',
      'KeyJ': '/truthroom',
      'KeyK': '/notice',
      'KeyL': '/lecture',
      'KeyN': '/new',
      'KeyP': '/pds',
      'KeyQ': '/qa',
      // Refresh the page when 'R' is pressed
      'KeyR': 'refresh',
      'KeyS': '/bbs/group.php?gr_id=group',
      'KeyT': '/tutorial',
      'KeyV': '/governance',
      'KeyW': '/promotion',
      'KeyZ': '/bbs/noti.php',
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

  // 자바스크립트에서 사용하는 전역변수 선언
  var g5_url = "<?php echo G5_URL ?>";
  var g5_bbs_url = "<?php echo G5_BBS_URL ?>";
  var g5_is_member = "<?php echo isset($is_member) ? $is_member : ''; ?>";
  var g5_is_admin = "<?php echo isset($is_admin) ? $is_admin : ''; ?>";
  var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
  var g5_bo_table = "<?php echo isset($bo_table) ? $bo_table : ''; ?>";
  var g5_sca = "<?php echo isset($sca) ? $sca : ''; ?>";
  var g5_editor =
    "<?php echo ($config['cf_editor'] && isset($board['bo_use_dhtml_editor']) && $board['bo_use_dhtml_editor']) ? $config['cf_editor'] : ''; ?>";
  var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
  <?php if (IS_YC) { ?>
  var g5_theme_shop_url = "<?php echo G5_THEME_SHOP_URL ?>";
  var g5_shop_url = "<?php echo G5_SHOP_URL ?>";
  <?php } ?>
  <?php if(defined('G5_IS_ADMIN')) { ?>
  var g5_admin_url = "<?php echo G5_ADMIN_URL ?>";
  <?php } ?>
  var na_url = "<?php echo NA_URL ?>";

  // 참고로, 소스 어디에선가 onLoad 관련하여 스크립트로 호출하는 부분이 있다면
  // 이거 적용하면 해당 부분은 무시됩니다.
  //     그런 부분 있으시다면 onload용 함수 하나 만드셔서 해당 함수에서 필요한 함수들을 순차적으로 실행하게 하면 될 듯 합니다.
  //            window.attachEvent("onload", set_ui_custom());

  //	            window.addEventListener("load", set_ui_custom);
  </script>
  <script src="<?php echo G5_THEME_URL ?>/js/jquery-3.5.1.min.js?ver=<?php echo G5_JS_VER; ?>"></script>
  <script src="https://fastly.jsdelivr.net/npm/sweetalert2@11?ver=<?php echo G5_JS_VER; ?>"></script>
  <script src="<?php echo G5_THEME_URL ?>/js/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
  <script src="<?php echo G5_THEME_URL ?>/js/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
  <script src="<?php echo G5_THEME_URL ?>/js/bootstrap.bundle.min.js?ver=<?php echo G5_JS_VER; ?>"></script>
  <script src="<?php echo G5_THEME_URL ?>/js/clipboard.min.js"></script>
  <script src="<?php echo G5_THEME_URL ?>/js/nariya.js?ver=2404281"></script>
  <script src="<?php echo LAYOUT_URL ?>/js/darkmode.js?ver=<?php echo G5_JS_VER; ?>" data-cfasync="false"></script>
  <script src="<?php echo LAYOUT_URL ?>/js/customui.js?ver=<?php echo G5_JS_VER; ?>" data-cfasync="false"></script>
  <script src="<?php echo LAYOUT_URL ?>/js/custom_features.js?ver=<?php echo G5_JS_VER; ?>" data-cfasync="false">
  <?php
  // 레이아웃 스크립트
  add_javascript('<script src="'.LAYOUT_URL.'/js/layout.js"></script>', 0);
  ?>
  </script>

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
