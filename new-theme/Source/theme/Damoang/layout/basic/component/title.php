<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//타이틀 안하는 페이지
$shop_notitle = (IS_SHOP) ? array(
	G5_SHOP_DIR.'-shop-list', // 상품목록 페이지(PC)
	G5_MOBILE_DIR.'-'.G5_SHOP_DIR.'-shop-list', // 상품목록 페이지(모바일)
	G5_SHOP_DIR.'-page-list', // 상품목록 페이지(PC)
	G5_MOBILE_DIR.'-'.G5_SHOP_DIR.'-page-list', // 상품목록 페이지(모바일)
	G5_SHOP_DIR.'-shop-item', // 상품상세페이지(PC)
	G5_MOBILE_DIR.'-'.G5_SHOP_DIR.'-shop-item', // 상품상세페이지(모바일)
	G5_SHOP_DIR.'-page-item', // 상품상세페이지(PC)
	G5_MOBILE_DIR.'-'.G5_SHOP_DIR.'-page-item', // 상품상세페이지(모바일)
) : array();

$notitle = array(
	G5_BBS_DIR.'-page-login', // 로그인 페이지
	G5_BBS_DIR.'-page-register', // 회원가입약관 페이지
	G5_BBS_DIR.'-page-register_form', // 회원가입약관폼 페이지
	G5_BBS_DIR.'-page-register_result', // 회원가입완료 페이지
	G5_BBS_DIR.'-page-password', // 비밀번호 입력 페이지
	G5_BBS_DIR.'-page-member_confirm', // 비밀번호 확인 페이지
);

if(in_array($file_id, $shop_notitle) || in_array($file_id, $notitle)) {
	return;
}

?>

<div class="page-title p-3 pt-4 mb-3">
	<div class="d-flex flex-column flex-sm-row align-items-sm-end gap-2">
		<div class="me-sm-auto">
			<h2 class="fs-4 mb-0">
				<?php echo na_htmlspecialchars($page_title, true) ?>
			</h2>
		</div>
		<?php 
			$nav_cnt = count($nav); 
			if($nav_cnt) {	
		?>
			<div>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0">
					<li><li class="breadcrumb-item"><a href="<?php G5_URL ?>/"><i class="bi bi-house-door"></i></a></li>
					<?php 
						$nav_now = $nav_cnt - 1;
						for($i=0; $i < $nav_cnt; $i++) { 
							if ($i == $nav_now) {
								echo '<li class="breadcrumb-item active" aria-current="page">'.$nav[$i]['text'].'</li>'.PHP_EOL;
							} else {
								$nav[$i]['target'] = ($nav[$i]['target']) ? $nav[$i]['target'] : '_self';
								echo '<li class="breadcrumb-item"><a href="'.$nav[$i]['href'].'" target="'.$nav[$i]['target'].'">'.$nav[$i]['text'].'</a></li>'.PHP_EOL;
							}
						}		
					?>
					</ol>
				</nav>
			</div>
		<?php } ?>
	</div>
</div>