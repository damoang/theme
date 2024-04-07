<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
#menuOffcanvas .offcanvas-title .btn-menu { display:none; }
</style>
<div class="offcanvas offcanvas-end" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title px-2" id="menuOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">

		<div class="na-menu">
		<div class="nav nav-pills nav-vertical">



<div id="sidebar-site-menu" class="mb-3">
<hr class="hr" />
<div class="dropdown-header">
	커뮤니티
</div>

	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/free" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-f"></i>
			<span style="" class="nav-link-title">
				자유게시판
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/qa" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-q"></i>
			<span style="" class="nav-link-title">
				마음껏 질문
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/hello" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-i"></i>
			<span style="" class="nav-link-title">
				가입인사
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/new" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-n"></i>
			<span style="" class="nav-link-title">
				새소게(새소식)
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/tutorial" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-t"></i>
			<span style="" class="nav-link-title">
				사용기/강좌
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/economy" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-e"></i>
			<span style="" class="nav-link-title">
				알뜰구매
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/gallery" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-g"></i>
			<span style="" class="nav-link-title">
				갤러리
			</span>
		</a>
	</div>


	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/bbs/group.php?gr_id=community" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-c"></i>
			<span style="" class="nav-link-title">
				커뮤니티
			</span>
		</a>
	</div>
	<hr class="hr" />
<div class="dropdown-header">
	운영
</div>

	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/notice" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-n"></i>
			<span style="" class="nav-link-title">
				공지사항
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/bug" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-b"></i>
			<span style="" class="nav-link-title">
				버그 제보
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/truthroom" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-r"></i>
			<span style="" class="nav-link-title">
				진실의 방
			</span>
		</a>
	</div>
	<div class="nav-item">
		<a class="nav-link" href="https://damoang.net/governance" data-placement="left" target="_self">
			<i style="" class="fi fi-rs-circle-g"></i>
			<span style="" class="nav-link-title">
				거버넌스
			</span>
		</a>
	</div>
</div>

<hr class="hr" />
<div class="dropdown-header">
	소모임
</div>
<?php 
			$somoim_menu_q = sql_Query("SELECT * FROM {$g5['board_table']} WHERE gr_id = 'group' ORDER BY bo_count_write DESC LIMIT 20");
			while($row = mysqli_fetch_array($somoim_menu_q)){ ?>
<div class="nav-item">
	<a class="nav-link" href="https://damoang.net/<?php echo $row['bo_table']; ?>" data-placement="left" target="_self">
		<i style="" class="fi fi-rs-circle-s"></i>
		<span style="" class="nav-link-title">
			<?php echo $row['bo_subject']; ?>
		</span>
	</a>
</div>
<?php } ?>
<hr class="hr"/>
				<div class="dropdown-header">
					About us
				</div>

				<div id="offcanvas-misc-menu" class="mb-3">
					<?php
						$iRow = array();
						$iRow[] = array(G5_BBS_DIR.'-content-company', 'bi-balloon-heart', '사이트 소개', get_pretty_url('content', 'company'));
						$iRow[] = array(G5_BBS_DIR.'-content-provision', 'bi-check2-square', '서비스 이용약관', get_pretty_url('content', 'provision'));
						$iRow[] = array(G5_BBS_DIR.'-content-privacy', 'bi-person-lock', '개인정보 처리방침', get_pretty_url('content', 'privacy'));

						for ($i=0; $i < count($iRow); $i++) { 
					?>
						<div class="nav-item">
							<a class="nav-link<?php echo ($page_id == $iRow[$i][0]) ? ' active' : ''; ?>" href="<?php echo $iRow[$i][3] ?>" data-placement="left">
								<i style="" class="<?php echo $iRow[$i][1] ?> nav-icon"></i>
								<span class="nav-link-title"><?php echo $iRow[$i][2] ?></span>
							</a>
						</div>
					<?php } ?>

					<?php if (IS_YC) { ?>
						<div class="nav-item">
							<a class="nav-link" href="<?php echo (IS_SHOP) ? G5_URL : G5_SHOP_URL; ?>" data-placement="left">
								<i style="" class="bi-door-open nav-icon"></i>
								<span class="nav-link-title">
									<?php if(IS_SHOP) { ?>
										<?php echo $config['cf_title'] ?>
									<?php } else { ?>
										<?php echo (isset($nariya['seo_shop_title']) && $nariya['seo_shop_title']) ? $nariya['seo_shop_title'] : '쇼핑몰'; ?>
									<?php } ?>
								</span>
							</a>
						</div>
					<?php } ?>

					<div class="nav-item">
						<a class="nav-link" href="<?php echo get_device_change_url() ?>" data-placement="left">
							<i style="" class="<?php echo (G5_IS_MOBILE) ? 'bi-pc-display' : 'bi-tablet'; ?> nav-icon"></i>
							<span class="nav-link-title"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일'; ?> 버전</span>
						</a>
					</div>

				</div>
			</div>
		</div><!-- end .na-menu -->


	</div>
</div>
