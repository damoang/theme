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

      <!-- 사이드 메뉴 -->
      <div class="nav-item">
        <!-- 사이트 메뉴 -->
        <?php
        // 메뉴. `inc.menu.php` 파일에서 정의 됨
        foreach ($siteMenus as $menuGroupIndex => $menuGroup) {
          $groupTitle = $menuGroup['title'] ?? null;
        ?>

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
