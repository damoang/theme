<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>

<div id="mb_confirm" class="max-400 mx-auto py-md-5">
	<form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
	<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
	<input type="hidden" name="w" value="u">
	<h3 class="px-3 py-2 mb-0 fs-5">
		<i class="bi bi-shield-lock"></i>
		비밀번호 확인
	</h3>
	<ul class="list-group list-group-flush line-top mb-4">
		<li class="list-group-item">
			<strong>비밀번호를 한번 더 입력해주세요.</strong>
			<p class="my-3">
			<?php if ($url == 'member_leave.php') { ?>
				비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
			<?php } else { ?>
				회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.
			<?php }  ?>
			</p>
			<div class="input-group mb-2">
				<span class="input-group-text">비밀번호<strong class="visually-hidden"> 필수</strong></span>
				<input type="password" name="mb_password" id="confirm_mb_password" required class="form-control required" maxLength="255">
				<button type="submit" id="btn_sumbit" class="btn btn-primary">확인</button>
			</div>
		</li>
		<li class="list-group-item text-center pt-3">
			<a href="<?php echo G5_URL ?>">
				<i class="bi bi-house-fill"></i>
				홈으로 돌아가기
			</a>
		</li>
	</ul>
	</form>
</div>

<script>
function fmemberconfirm_submit(f) {
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->

<?php
include_once(G5_PATH.'/tail.php');