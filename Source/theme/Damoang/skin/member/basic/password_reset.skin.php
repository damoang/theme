<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);

?>

<!-- 비밀번호 재설정 시작 { -->
<div id="pw_reset" class="m-auto f-de px-3 py-md-5 px-sm-0 mb-5">
	<form name="fpasswordreset" action="<?php echo $action_url; ?>" onsubmit="return fpasswordreset_submit(this);" method="post" autocomplete="off">
		<p>새로운 비밀번호를 입력해주세요.</p>
		<div class="py-2">
			<b>회원 아이디 : <?php echo $_POST['mb_id']; ?></b>
		</div>
		<div class="form-group">	
			<label for="mb_pw" class="sr-only">새 비밀번호<strong class="sr-only"> 필수</strong></label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fa fa-lock text-muted"></i></span>
				</div>
				<input type="password" name="mb_password" id="mb_pw" required class="form-control required" placeholder="새 비밀번호">
			</div>
		</div>
		<div class="form-group">	
			<label for="mb_pw2" class="sr-only">새 비밀번호 확인<strong class="sr-only"> 필수</strong></label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fa fa-lock text-muted"></i></span>
				</div>
				<input type="password" name="mb_password_re" id="mb_pw2" required class="form-control required" placeholder="새 비밀번호 확인">
			</div>
		</div>
		<p class="text-center">
			<button type="submit" class="btn btn-primary">변경하기</button>
		</p>
	</form>
</div>

<script>
function fpasswordreset_submit(f) {
    if ($("#mb_pw").val() == $("#mb_pw2").val()) {
        na_alert('비밀번호 변경되었습니다. 다시 로그인해 주세요.', function(){
			f.submit();
		});
    } else {
		na_alert('새 비밀번호와 비밀번호 확인이 일치하지 않습니다.');
    }
	return false;
}
</script>
<!-- } 비밀번호 재설정 끝 -->