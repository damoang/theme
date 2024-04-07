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
		<li class="list-group-item py-3">
			<div class="input-group mb-2">
				<span class="input-group-text">
					<i class="bi bi-person text-muted"></i>
				</span>
				<div class="form-floating">
					<input type="text" name="mb_id" id="login_id" class="form-control required" placeholder="아이디">
					<label for="login_id">아이디</label>
				</div>
			</div>

			<div class="input-group mb-3">
				<span class="input-group-text">
					<i class="bi bi-shield-lock text-muted"></i>
				</span>
				<div class="form-floating">
					<input type="password" name="mb_password" id="login_pw" class="form-control required" placeholder="비밀번호">
					<label for="login_pw">비밀번호</label>
				</div>
			</div>

			<div class="d-flex gap-3 mb-3">
				<div>
					<a href="<?php echo G5_BBS_URL ?>/register.php" class="btn btn-basic py-2">
						<i class="bi bi-people"></i>
						회원가입
					</a>
				</div>
				<div class="flex-grow-1">
					<button type="submit" class="btn btn-primary w-100 py-2">
						로그인
					</button>
				</div>
			</div>

			<div class="d-flex justify-content-between align-items-center">
				<div>
					<div class="form-check form-check-inline form-switch">
						<input class="form-check-input auto-login" type="checkbox" name="auto_login" role="switch" id="auto_login">
						<label class="form-check-label" for="auto_login">자동로그인</label>
					</div>
				</div>
				<div>
					<a href="<?php echo G5_BBS_URL ?>/password_lost.php">
						<i class="bi bi-search"></i>
						아이디/비밀번호 찾기
					</a>
				</div>
			</div>
		</li>
		<?php @include (get_social_skin_path().'/social_login.skin.php'); // 소셜로그인 사용시 소셜로그인 버튼 ?>
	</ul>
	</form>

<?php 
	$url = isset($url) ? $url : '';	
	if(IS_YC && isset($default['de_level_sell']) && $default['de_level_sell'] == 1) { // 쇼핑몰 상품구입 권한 
?>
	<!-- 주문하기, 신청하기 -->
	<?php if (preg_match("/orderform.php/", $url)) { ?>
		<h3 class="px-3 my-2 fs-4">
			<i class="bi bi-check2-square"></i>
			비회원 구매
		</h3>		
		<ul id="mb_login_notmb" class="list-group list-group-flush line-top mb-4">
			<li class="list-group-item">
				<div id="guest_privacy">
					<table class="table table-bordered mb-2">
					<thead>
					<tr>
						<th class="text-center">구분</th>
						<th class="text-center">개인정보수집 내용</th>
					</tr>
					</thead>
					<tbody class="table-group-divider">
					<tr>
						<td class="text-nowrap">수집 목적</td>
						<td>서비스 이용에 관한 통지, CS대응을 위한 이용자 식별</td>
					</tr>
					<tr>
						<td>수집 항목</td>
						<td>이름, 비밀번호, 주소, 이메일, 연락처, 결제정보</td>
					</tr>
					<tr>
						<td>보유 기간</td>
						<td>5년(전자상거래 등에서의 소비자보호에 관한 법률)</td>
					</tr>
					</tbody>
					</table>
				</div>
				<div class="small text-secondary text-center">
					비회원 주문은 포인트를 지급하지 않습니다.
				</div>
			</li>
			<li class="list-group-item bg-body-tertiary">
				<div class="form-check form-switch form-check-inline">
					<input class="form-check-input" type="checkbox" role="switch" name="agree" value="1" id="agree">
					<label class="form-check-label" for="agree">개인정보수집에 대한 내용에 동의합니다.</label>
				</div>
			</li>
			<li class="list-group-item pt-3">
				<a href="javascript:guest_submit(document.flogin);" class="btn btn-primary btn-lg w-100">비회원으로 구매하기</a>
			</li>
		</ul>
		<script>
		function guest_submit(f) {
			if (document.getElementById('agree')) {
				if (!document.getElementById('agree').checked) {
					na_alert('개인정보수집에 대한 내용에 동의하셔야 합니다.');
					return false;
				}
			}
			f.url.value = "<?php echo $url; ?>";
			f.action = "<?php echo $url; ?>";
			f.submit();
		}
		</script>

    <?php } else if (preg_match("/orderinquiry.php$/", $url)) { ?>
		<h3 class="px-3 my-2 fs-4">
			<i class="bi bi-check2-square"></i>
			비회원 주문조회
		</h3>		
		<ul id="mb_login_od_wr" class="list-group list-group-flush line-top mb-4">
			<li class="list-group-item">

				<div class="my-3">
					메일로 발송해드린 주문서의 <strong>주문번호</strong> 및 주문 시 입력하신 <strong>비밀번호</strong>를 정확히 입력해주십시오.
				</div>

				<form name="forderinquiry" method="post" action="<?php echo urldecode($url); ?>" autocomplete="off">
					<div class="input-group mb-2">
						<span class="input-group-text">주문번호<strong class="visually-hidden"> 필수</strong></span>
						<input type="text" name="od_id" id="od_id" required class="form-control required">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">비밀번호<strong class="visually-hidden"> 필수</strong></span>
						<input type="password" name="od_pwd" id="od_pwd" required class="form-control required">
					</div>
					
					<button type="submit" class="btn btn-primary btn-lg w-100">조회하기</button>
				</form>
			</li>
		</ul>
    <?php } ?>
<?php } ?>
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