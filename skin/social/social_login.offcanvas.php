<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

if (!$config['cf_social_login_use']) {
    // 소셜 로그인을 사용하지 않으면
    return;
}

$social_pop_once = false;

$self_url = G5_BBS_URL . "/login.php";

//새창을 사용한다면
if (G5_SOCIAL_USE_POPUP) {
    $self_url = G5_SOCIAL_LOGIN_URL . '/popup.php';
}

add_stylesheet('<link rel="stylesheet" href="' . get_social_skin_url() . '/style.css?ver=' . G5_CSS_VER . '">', 10);
?>
<div id="sns_offcanvas" class="login-sns sns-wrap-32 sns-wrap-over border-top py-3 mt-3">
    <h3 class="visually-hidden">소셜계정으로 로그인</h3>
    <div class="sns-wrap">
        <?php if (social_service_check('naver')) { // 네이버 로그인을 사용한다면 ?>
            <a href="<?php echo $self_url; ?>?provider=naver&amp;url=<?php echo $urlencode; ?>" class="sns-icon social_link_win sns-naver my-3" title="네이버">
                <span class="ico"></span>
                <span class="txt">네이버<i> 로그인</i></span>
            </a>
        <?php } // end if ?>
        <?php if (social_service_check('kakao')) { // 카카오 로그인을 사용한다면 ?>
            <a href="<?php echo $self_url; ?>?provider=kakao&amp;url=<?php echo $urlencode; ?>" class="sns-icon social_link_win sns-kakao my-3" title="카카오">
                <span class="ico"></span>
                <span class="txt">카카오<i> 로그인</i></span>
            </a>
        <?php } // end if ?>
        <?php if (social_service_check('facebook')) { // 페이스북 로그인을 사용한다면 ?>
            <a href="<?php echo $self_url; ?>?provider=facebook&amp;url=<?php echo $urlencode; ?>" class="sns-icon social_link_win sns-facebook my-3" title="페이스북">
                <span class="ico"></span>
                <span class="txt">페이스북<i> 로그인</i></span>
            </a>
        <?php } // end if ?>
        <?php if (social_service_check('google')) { // 구글 로그인을 사용한다면 ?>
            <a href="<?php echo $self_url; ?>?provider=google&amp;url=<?php echo $urlencode; ?>" class="sns-icon social_link_win sns-google my-3" title="구글">
                <span class="ico"></span>
                <span class="txt">구글<i> 로그인</i></span>
            </a>
        <?php } // end if ?>
        <?php if (social_service_check('twitter')) { // 트위터 로그인을 사용한다면 ?>
            <a href="<?php echo $self_url; ?>?provider=twitter&amp;url=<?php echo $urlencode; ?>" class="sns-icon social_link_win sns-twitter my-3" title="트위터">
                <span class="ico"></span>
                <span class="txt">트위터<i> 로그인</i></span>
            </a>
        <?php } // end if ?>
        <?php if (social_service_check('payco')) { // 페이코 로그인을 사용한다면 ?>
            <a href="<?php echo $self_url; ?>?provider=payco&amp;url=<?php echo $urlencode; ?>" class="sns-icon social_link_win sns-payco my-3" title="페이코">
                <span class="ico"></span>
                <span class="txt">페이코<i> 로그인</i></span>
            </a>
        <?php } // end if ?>

        <?php if (G5_SOCIAL_USE_POPUP && !$social_pop_once) {
            $social_pop_once = true;
            ?>
            <script>
                $(function ($) {
                    $(".sns-wrap").on("click", "a.social_link_win", function (e) {
                        e.preventDefault();

                        var pop_url = $(this).attr("href");
                        var newWin = window.open(
                            pop_url,
                            "social_sing_on",
                            "location=0,status=0,scrollbars=1,width=600,height=500"
                        );

                        if (!newWin || newWin.closed || typeof newWin.closed == 'undefined') {
                            na_alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');
                        }
                        return false;
                    });
                });
            </script>
        <?php } ?>

        <div class="form-check text-start mt-4">
            <input class="form-check-input sociallogin_remeber" type="checkbox" name="sociallogin_remeber" id="sociallogin_remeber" />
            <label class="form-check-label" for="sociallogin_remeber">30일 동안 로그인 유지</label>
            <div class="alert alert-light social-remember-alert" role="alert">
                <p class="mb-0">
                    <strong>로그인 유지 기능 사용 시 <u>최대 30일 동안</u> 로그인이 유지됩니다.</strong>
                    <br>
                    본인만 이용하는 PC/모바일 기기에서만 사용하세요.
                </p>
            </div>
        </div>
    </div>
</div>