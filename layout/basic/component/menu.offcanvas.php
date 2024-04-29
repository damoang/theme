<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
#menuOffcanvas .offcanvas-title .btn-menu {
  display: none;
}
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
          <a href="/bbs/new.php?bo_table=&sca=&gr_id=&view=w&mb_id=<?php echo $member['mb_id'] ?>">내 글</a>&nbsp;|&nbsp;<a href="/bbs/new.php?bo_table=&sca=&gr_id=&view=c&mb_id=<?php echo $member['mb_id'] ?>">내 댓글</a>&nbsp;|&nbsp;<a
            href="/bbs/noti.php"><i class="bi bi-bell"></i>알림</a>
        </div>

					<div id="offcanvas-site-menu" class="mb-3">
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
							$id_s1 = 'sub-s'.$i;
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
							<div id="<?php echo $id_s1 ?>" class="nav-collapse collapse<?php echo $show ?>" data-bs-parent="#offcanvas-site-menu">
								<?php
								// 1차 서브
								for ($j=0; $j < count($me['s']); $j++) {
									$me1 = $me['s'][$j];

          <?php if ($groupTitle): ?>
            <div class="dropdown-header"><?= $groupTitle ?></div>
          <?php endif; ?>

          <?php
            foreach ($menuGroup['items'] as $menuTitle => $menuItem) {
              $hasSub = false;
              $subMenus = null;

              if (!is_array($menuItem)) {
                $menuItem = ['url' => $menuItem];
              }

              $menuItem['url'] = $menuItem['url'] ?? '#';
              $menuItem['icon'] = $menuItem['icon'] ?? 'bi-clipboard';
              $hasSub = !empty($menuItem['items']) && is_array($menuItem['items']);

              if (!$menuitme['page_id']) {
                if (preg_match('/\/([a-zA-Z0-9]+)$/i', $menuItem['url'], $matches)) {
                  $menuItem['page_id'] = G5_BBS_DIR . '-board-' . $matches[1];
                }
              }

              if ($hasSub) {
                $menuIndex = array_search($menuTitle, array_keys($siteMenus[$menuGroupIndex]['items']));
                $menuToggleId = "sidebar-sub-s{$menuGroupIndex}-{$menuIndex}";
                $menuUrlOrigin = $menuItem['url'];
                $menuItem['url'] = '#' . $menuToggleId;
                $subMenus = $menuItem['items'];
              }
            ?>
              <div class="nav-item">
                <a
                  class="nav-link <?= ($menuItem['page_id'] === $page_id) ? 'active' : ''; ?><?= ($hasSub) ? 'dropdown-toggle collapsed collapsed' : '' ?>"
                  href="<?= $menuItem['url'] ?>"
                  data-placement="left"
                  <?= ($hasSub) ? 'role="button" data-bs-toggle="collapse" data-bs-target="#' . $menuToggleId . '" aria-expanded="false" aria-controls="' . $menuToggleId . '"' : '' ?>
                >
                  <i class="<?= $menuItem['icon'] ?> nav-icon"></i>
                    <span class="nav-link-title" <?= ($hasSub) ? ' onclick="na_href(\'' . $menuUrlOrigin . '\', \'_self\');"' : '' ?>>
                      <?php if ($menuItem['shortcut']) { ?><span class="badge text-bg-secondary"><?= $menuItem['shortcut'] ?></span><?php } ?>
                      <?= $menuTitle ?>
                    </span>
                </a>

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

        </div>
      </div>
    </div><!-- end .na-menu -->


  </div>
</div>