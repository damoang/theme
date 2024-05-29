<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 헤더, 테일 사용설정
include_once(G5_PATH.'/head.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<section class="max-400 mx-auto py-md-5 mb-4">

    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" autocomplete="off">
    <input type="hidden" name="url" value="<?php echo $login_url ?>">

    <h3 class="px-3 py-2 mb-0 fs-4">
        <i class="bi bi-box-arrow-in-right"></i>
        로그인
    </h3>

    <ul id="mb_login" class="list-group list-group-flush line-top mb-4">
        <?php @include (get_social_skin_path().'/social_login.skin.php'); // 소셜로그인 사용시 소셜로그인 버튼 ?>
    </ul>
    </form>

<div class="text-center">
    <a href="<?php echo G5_URL ?>">
        <i class="bi bi-house-fill"></i>
        홈으로 돌아가기
    </a>
</div>
</section>

<script>
function flogin_submit(f) {

    if( $( document.body ).triggerHandler( 'login_sumit', [f, 'flogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>
<!-- } 로그인 끝 -->

<?php
// 헤더, 테일 사용설정
include_once(G5_PATH.'/tail.php');
