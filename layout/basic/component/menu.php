<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


?>

<nav class="site-nav d-none d-lg-block" role="navigation">
  <?php if (!empty($config['cf_8'])): ?>
  <a href="<?php echo $config['cf_8'];?>" target="_blank"><?php echo $config['cf_8_subj']?></a> |
  <?php endif; ?>  
  <a href="/notice" class="nav-link">공지사항</a> | <a href="/bbs/group.php?gr_id=group" class="nav-link">소모임</a> | <a
    href="/bbs/group.php?gr_id=community" class="nav-link">커뮤니티</a>
</nav>