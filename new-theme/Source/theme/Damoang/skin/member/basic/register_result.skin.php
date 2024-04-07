<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

// 초기값
$default['de_member_reg_coupon_use'] = isset($default['de_member_reg_coupon_use']) ? $default['de_member_reg_coupon_use'] : '';
$default['de_member_reg_coupon_price'] = isset($default['de_member_reg_coupon_price']) ? $default['de_member_reg_coupon_price'] : 0;
$default['de_member_reg_coupon_minimum'] = isset($default['de_member_reg_coupon_minimum']) ? $default['de_member_reg_coupon_minimum'] : 0;

?>
<div class="max-600 m-auto py-md-5">
	<h3 class="px-3 py-2 mb-0 fs-5">
		<i class="bi bi-gift"></i>
		회원가입을 축하합니다.
	</h3>
	<ul class="list-group list-group-flush line-top mb-4">
		<?php if (!is_use_email_certify()) {  ?>
			<li class="list-group-item ">
				회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.
				발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.

				<div class="form-text my-3">
					이메일 주소를 잘못 입력하셨다면, 사이트 관리자에게 문의해주시기 바랍니다.
				</div>

				<i class="bi bi-person"></i>
				아이디 : <?php echo $mb['mb_id'] ?>
				<br>
				<i class="bi bi-envelope-at"></i>
				이메일 : <?php echo $mb['mb_email'] ?>
			</li>
		<?php } ?>
		<li class="list-group-item">
			아이디, 비밀번호 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있으며, 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.
			<div class="form-text mt-3">
				회원 탈퇴는 언제든지 가능하며 일정기간이 지난 후, 회원님의 정보는 삭제하고 있습니다.
			</div>
		</li>
		<?php if(IS_YC && $default['de_member_reg_coupon_use'] && get_session('ss_member_reg_coupon') == 1) { ?>
			<li id="result_coupon" class="list-group-item py-md-4">
				<i class="fa fa-gift" aria-hidden="true"></i>
				주문시 사용하실 수 있는 <strong><?php echo display_price($default['de_member_reg_coupon_price']); ?> 할인 쿠폰</strong><?php echo ($default['de_member_reg_coupon_minimum'] ? '(주문금액 '.display_price($default['de_member_reg_coupon_minimum']).'이상)' : ''); ?>이 발행되었으니, 마이페이지에서 확인하실 수 있습니다.
			</li>
		<?php } ?>
		<li class="list-group-item text-center">
			<a href="<?php echo G5_URL ?>">
				<i class="bi bi-house-fill"></i>
				홈으로 돌아가기
			</a>
		</li>
	</ul>
</div>
