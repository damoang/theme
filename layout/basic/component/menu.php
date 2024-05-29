<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


?>
<nav class="site-nav d-none d-lg-block" role="navigation">
<?php if (!empty($config['cf_8'])): ?>
<a href="<?php echo $config['cf_8']; ?>" target="_blank"><?php echo $config['cf_8_subj'] ?></a> |
<?php endif; ?>
<a href="/bbs/group.php?gr_id=group" class="nav-link">소모임</a> |
<a href="/bbs/group.php?gr_id=community" class="nav-link">커뮤니티</a>
<!-- |
    <?php if (!empty($bo_table)): ?>
        <a href="/<?php echo $bo_table ?>?sca=&sfl=mb_id,1&stx=<?php echo $member['mb_id'] ?>">내 글 보기</a> |
        <a href="/<?php echo $bo_table ?>?bo_table=notice&sca=&sfl=mb_id%2C0&sop=and&stx=<?php echo $member['mb_id'] ?>">
            내 댓글 보기</a>

    <?php endif; ?> -->

</nav>
