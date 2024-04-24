<?php
if (!defined('_GNUBOARD_')) {
  exit;
}

$siteMenus = include 'inc.menu.php';
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
        <?php if (!empty($config['cf_9'])) { ?>
          <div class="nav-item">
            <a class="nav-link" href="<?php echo $config['cf_9']; ?>" data-placement="left" target="_blank">
              <i class="bi-youtube nav-icon"></i>
              <span class="nav-link-title">
                ▶️ 다모앙 방송국
              </span>
            </a>
          </div>
        <?php } ?>

        <div class="nav-item nav-link">
          <a href="/bbs/new.php?bo_table=&sca=&gr_id=&view=w&mb_id=<?php echo $member['mb_id'] ?>">내 글</a>&nbsp;|&nbsp;
          <a href="/bbs/new.php?bo_table=&sca=&gr_id=&view=c&mb_id=<?php echo $member['mb_id'] ?>">내 댓글</a>
        </div>

        <?php
        // 메뉴. `inc.menu.php` 파일에서 정의 됨
        foreach ($siteMenus as $menuGroup) {
          $groupTitle = $menuGroup['title'] ?? null;
          ?>

          <?php if ($groupTitle): ?>
            <div class="dropdown-header"><?= $groupTitle ?></div>
          <?php endif; ?>

          <div class="nav-item">
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
                $menuIndex = array_search($menuTitle, array_keys($siteMenus));
                $menuToggleId = 'sidebar-sub-s' . $menuIndex;
                $menuUrlOrigin = $menuItem['url'];
                $menuItem['url'] = '#' . $menuToggleId;
                $subMenus = $menuItem['items'];
              }
              ?>
              <div class="nav-item">
                <a class="nav-link <?= ($menuItem['page_id'] === $page_id) ? 'active' : ''; ?> <?= ($hasSub) ? 'dropdown-toggle collapsed collapsed' : '' ?>" href="<?= $menuItem['url'] ?>" data-placement="left" <?= ($hasSub) ? 'role="button" data-bs-toggle="collapse" data-bs-target="#' . $menuToggleId . '" aria-expanded="false" aria-controls="' . $menuToggleId . '"' : '' ?>>
                  <i class="<?= $menuItem['icon'] ?> nav-icon"></i>
                  <span class="nav-link-title" <?= ($hasSub) ? ' onclick="na_href(\'' . $menuUrlOrigin . '\', \'_self\');"' : '' ?>>
                    <?= $menuTitle ?>
                  </span>
                </a>

                <?php if ($hasSub): ?>
                  <!-- 하위 메뉴 -->
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
          </div>
        <?php } // endforeach $sitemenus ?>

        <?php if (IS_YC) { ?>
          <div class="nav-item">
            <a class="nav-link" href="<?php echo (IS_SHOP) ? G5_URL : G5_SHOP_URL; ?>" data-placement="left">
              <i class="bi-door-open nav-icon"></i>
              <span class="nav-link-title">
                <?php if (IS_SHOP) { ?>
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
            <i class="<?php echo (G5_IS_MOBILE) ? 'bi-pc-display' : 'bi-tablet'; ?> nav-icon"></i>
            <span class="nav-link-title"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일'; ?> 버전</span>
          </a>
        </div>
      </div>
    </div><!-- end .na-menu -->
  </div><!-- end .offcanvas-body -->
</div><!-- end .offcanvas -->