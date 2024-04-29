<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="px-3 mb-4">
  <?php echo na_widget('outlogin'); // 외부로그인 ?>
</div>

<div class="na-menu">
  <div class="nav nav-pills nav-vertical">



    <div id="sidebar-site-menu" class="mb-3">
      <?php
if (!empty($config['cf_9'])) {
    ?>
      <div class="nav-item">
        <a class="nav-link" href="<?php echo $config['cf_9'];?>" data-placement="left" target="_blank">
          <i class="bi-youtube nav-icon"></i>
          <span class="nav-link-title">▶️ 다모앙 방송국
          </span>
        </a>
      </div>
      <?php
}
?>
      <div class="nav-item nav-link">
        <a href="/bbs/search.php?srows=10&amp;gr_id=&amp;sfl=mb_id&amp;stx=<?php echo $member['mb_id'] ?>">내 글</a>&nbsp;|&nbsp;
        <a href="/bbs/new.php?bo_table=&amp;sca=&amp;gr_id=&amp;view=c&amp;mb_id=<?php echo $member['mb_id'] ?>">내 댓글</a>&nbsp;|&nbsp;<a
          href="/bbs/noti.php"><i class="bi bi-bell"></i>알림</a>
      </div>

			<div id="sidebar-site-menu" class="mb-3">
			<?php
			for ($i=0; $i < $menu_cnt; $i++) {
				// 주메뉴
				$me = $menu[$i];

				$collapsed = ' collapsed';
				$expanded = 'false';
				$active = $show = '';
				if($me['on']) {
					if($me['eq']) {
						$active = $collapsed = ' active';
					}
					$expanded = 'true';
					$show = ' show';
				}

				// 1차서브
				if($me['is_sub']) {
					$id_s1 = 'sidebar-sub-s'.$i;
				?>
				<div class="nav-item">
					<a class="nav-link dropdown-toggle collapsed<?php echo $collapsed ?>" href="#<?php echo $id_s1 ?>" role="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $id_s1 ?>" aria-expanded="<?php echo $expanded ?>" aria-controls="<?php echo $id_s1 ?>">
						<i class="<?php echo ($me['icon']) ? $me['icon'] : 'bi-clipboard'; ?> nav-icon"></i>
						<?php if($me['me_link'] === '#') { ?>
							<span class="nav-link-title">
						<?php } else { ?>
							<span class="nav-link-title" onclick="na_href('<?php echo $me['me_link'] ?>','<?php echo $me['me_target'] ?>');">
						<?php } ?>
							<?php echo $me['me_name'] ?>
							<?php if($me['new']) { ?>
								<span class="small">
									<b class="badge bg-primary rounded-pill fw-normal"><?php echo $me['new'] ?></b>
								</span>
							<?php } ?>
						</span>
					</a>
					<div id="<?php echo $id_s1 ?>" class="nav-collapse collapse<?php echo $show ?>" data-bs-parent="#sidebar-site-menu">
						<?php
						// 1차 서브
						for ($j=0; $j < count($me['s']); $j++) {
							$me1 = $me['s'][$j];

							$collapsed1 = ' collapsed';
							$expanded1 = 'false';
							$active1 = $show1 = '';
							if($me1['on']) {
								if($me1['eq']) {
									$collapsed1 = $active1 = ' active';
								}
								$expanded1 = 'true';
								$show1 = ' show';
							}

							// 2차 서브
							if($me1['is_sub']) {
								$id_s2 = $id_s1.$j;
						?>
								<div id="<?php echo $id_s2.'-head' ?>">
									<div class="nav-item">
										<a class="nav-link dropdown-toggle<?php echo $collapsed1 ?>" href="#<?php echo $id_s2 ?>" role="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $id_s2 ?>" aria-expanded="<?php echo $expanded1 ?>" aria-controls="<?php echo $id_s2 ?>">
											<?php if($me1['me_link'] === '#') { ?>
												<span>
											<?php } else { ?>
												<span onclick="na_href('<?php echo $me1['me_link'] ?>','<?php echo $me1['me_target'] ?>');">
											<?php } ?>
												<?php echo $me1['me_name'] ?>
												<?php if($me1['new']) { ?>
													<span class="small">
														<b class="badge bg-primary rounded-pill fw-normal"><?php echo $me1['new'] ?></b>
													</span>
												<?php } ?>
											</span>
										</a>
										<div id="<?php echo $id_s2 ?>" class="nav-collapse collapse<?php echo $show1 ?>" data-bs-parent="#<?php echo $id_s2.'-head' ?>">
											<?php
											for ($k=0; $k < count($me1['s']); $k++) {
												$me2 = $me1['s'][$k];
												$active2 = ($me2['on']) ? ' active' : '';
											?>
												<a class="nav-link<?php echo $active2 ?>" href="<?php echo $me2['me_link'] ?>" target="<?php echo $me2['me_target'] ?>">
													<?php echo $me2['me_name'] ?>
													<?php if($me2['new']) { ?>
														<span class="small">
															<b class="badge bg-primary rounded-pill fw-normal"><?php echo $me2['new'] ?></b>
														</span>
													<?php } ?>
												</a>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<a class="nav-link<?php echo $active1 ?>" href="<?php echo $me1['me_link'] ?>" target="<?php echo $me1['me_target'] ?>">
									<?php echo $me1['me_name'] ?>
									<?php if($me1['new']) { ?>
										<span class="small">
											<b class="badge bg-primary rounded-pill fw-normal"><?php echo $me1['new'] ?></b>
										</span>
									<?php } ?>
								</a>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
				<?php } else { ?>
				<div class="nav-item">
					<a class="nav-link<?php echo $active ?>" href="<?php echo $me['me_link'] ?>" data-placement="left" target="<?php echo $me['me_target'] ?>">
						<i class="<?php echo ($me['icon']) ? $me['icon'] : 'bi-clipboard'; ?> nav-icon"></i>
						<span class="nav-link-title">
							<?php echo $me['me_name'] ?>
							<?php if($me['new']) { ?>
								<span class="small">
									<b class="badge bg-primary rounded-pill fw-normal"><?php echo $me['new'] ?></b>
								</span>
							<?php } ?>
						</span>
					</a>
				</div>
				<?php } // end is_sub 1차서브 ?>
			<?php } // end for 주메뉴 ?>
			</div>
		<?php } // end is_menu ?>

		<?php if(IS_SHOP) { ?>
			<div class="dropdown-header">
				Shopping
			</div>

			<div id="sidebar-misc-menu" class="mb-3">
			<?php
				$iRow = array();
				$iRow[] = array(G5_SHOP_DIR.'-page-orderinquiry', 'bi-bag-check', '주문내역', G5_SHOP_URL.'/orderinquiry.php');
				$iRow[] = array(G5_SHOP_DIR.'-page-personalpay', 'bi-credit-card', '개인결제', G5_SHOP_URL.'/personalpay.php');
				$iRow[] = array(G5_SHOP_DIR.'-page-itemuselist', 'bi-pencil-square', '사용후기', G5_SHOP_URL.'/itemuselist.php');
				$iRow[] = array(G5_SHOP_DIR.'-page-itemqalist', 'bi-chat-dots', '상품문의', G5_SHOP_URL.'/itemqalist.php');
				$iRow[] = array(G5_SHOP_DIR.'-page-search', 'bi-search-heart', '상품검색', G5_SHOP_URL.'/search.php');
				$iRow[] = array(G5_SHOP_DIR.'-page-couponzone', 'bi-ticket', '쿠폰존', G5_SHOP_URL.'/couponzone.php');

				for ($i=0; $i < count($iRow); $i++) {
			?>
				<div class="nav-item">
					<a class="nav-link<?php echo ($page_id == $iRow[$i][0]) ? ' active' : ''; ?>" href="<?php echo $iRow[$i][3] ?>" data-placement="left">
						<i class="<?php echo $iRow[$i][1] ?> nav-icon"></i>
						<span class="nav-link-title"><?php echo $iRow[$i][2] ?></span>
					</a>
				</div>
			<?php } ?>
			</div>
		<?php } ?>

		<div class="dropdown-header">
			Miscellaneous
		</div>

		<div id="sidebar-misc-menu" class="mb-3">
		<?php
			// 현재접속자
			$login_connect = ($member['login_cnt']) ? ' <span class="small"><b class="badge bg-primary rounded-pill fw-normal">'.$member['login_cnt'].'</b></span>' : '';

			$iRow = array();
			$iRow[] = array(G5_BBS_DIR.'-page-faq', 'bi-question-circle', 'FAQ', G5_BBS_URL.'/faq.php');
			$iRow[] = array(G5_BBS_DIR.'-page-new', 'bi-pencil', '새글모음', G5_BBS_URL.'/new.php');
			$iRow[] = array(G5_BBS_DIR.'-page-tag', 'bi-tags', '태그모음', G5_BBS_URL.'/tag.php');
			$iRow[] = array(G5_BBS_DIR.'-page-search', 'bi-search', '게시물검색', G5_BBS_URL.'/search.php');
			$iRow[] = array(G5_BBS_DIR.'-page-current_connect', 'bi-people', '현재접속자'.$login_connect, G5_BBS_URL.'/current_connect.php');

			for ($i=0; $i < count($iRow); $i++) {
		?>
			<div class="nav-item">
				<a class="nav-link<?php echo ($page_id == $iRow[$i][0]) ? ' active' : ''; ?>" href="<?php echo $iRow[$i][3] ?>" data-placement="left">
					<i class="<?php echo $iRow[$i][1] ?> nav-icon"></i>
					<span class="nav-link-title"><?php echo $iRow[$i][2] ?></span>
				</a>
			</div>
		<?php } ?>
		</div>

		<div class="dropdown-header">
			About us
		</div>

              <!-- 서브 메뉴 -->
              <?php if ($hasSub): ?>
                  <div id="<?= $menuToggleId ?>" class="nav-collapse collapse" data-bs-parent="#sidebar-site-menu">
                    <?php foreach ($subMenus as $subMenuTitle => $subMenuUrl): ?>
                      <a class="nav-link" href="<?= $subMenuUrl ?>">
                        <?= $subMenuTitle ?>
                      </a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
            </div>
          <?php } ?>
        <?php } // endforeach $siteMenus ?>

        <div class="nav-item">
          <a class="nav-link" href="<?php echo get_device_change_url() ?>" data-placement="left">
            <i class="<?php echo (G5_IS_MOBILE) ? 'bi-pc-display' : 'bi-tablet'; ?> nav-icon"></i>
            <span class="nav-link-title"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일'; ?> 버전</span>
          </a>
        </div>

        <div style="padding: 14px 0;">
          <?php echo na_widget('damoang-image-banner', 'side-banner'); ?>
        </div>

        <script async
          src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6922133409882969"
          crossorigin="anonymous"></script>
        <!-- sub -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6922133409882969"
          data-ad-slot="3231235128" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

      </div>
    </div>
  </div><!-- end .na-menu -->
