<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

// 와이드 이미지 배너
echo na_widget('damoang-image-banner', 'board-head');
?>

<?php
if ($gr_id === 'group') {
    // 소모임
?>
    <div class="row">
        <div class="col-md-6">
            <!-- 위젯 시작 { -->
            <h3 class="fs-5 px-3 py-2 mb-0">
                <a href="/bbs/group.php?gr_id=group">
                    <i class="fa fa-users"></i>
                    최신 글
                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                </a>
            </h3>
            <div class="line-top mb-4">
                <?php echo na_widget('wr-list', 'idx-group', 'gr_list=group rows=50 bo_name=10 wr_notice=0 is_notice=0'); ?>
            </div>
            <!-- } 위젯 끝 -->
        </div>

        <div class="col-md-6">
            <!-- 위젯 시작 { -->
            <h3 class="fs-5 px-3 py-2 mb-0">
                <a href="/bbs/group.php?gr_id=group">
                    <i class="bi bi-chat-dots"></i>
                    추천 글
                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                </a>
            </h3>
            <div class="line-top mb-4">
                <?php echo na_widget('wr-list-recommend', 'idx-group', 'gr_list=group sort=good rows=50 bo_name=10'); ?>
            </div>
            <!-- } 위젯 끝 -->
        </div>
    </div>

<?php
} else {
    // 그 외
?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
        <?php
        // 보드추출
        $bo_device = (G5_IS_MOBILE) ? 'pc' : 'mobile';
        $sql = " SELECT bo_table, bo_subject
            from {$g5['board_table']}
            where gr_id = '{$gr_id}'
            and bo_list_level <= '{$member['mb_level']}'
            and bo_order >= 0
            and bo_device <> '{$bo_device}' ";
        if (!$is_admin)
            $sql .= " and bo_use_cert = '' ";
        $sql .= " order by bo_order ";
        $result = sql_query($sql);

        for ($i = 0; $row = sql_fetch_array($result); $i++) {
        ?>
            <div class="col">
                <h3 class="fs-5 px-3 py-2 mb-0">
                    <a href="<?php echo get_pretty_url($row['bo_table']); ?>">
                        <span class="pull-right more-plus"></span>
                        <?php echo get_text($row['bo_subject']) ?>
                    </a>
                </h3>
                <div class="line-top pb-4">
                    <?php echo na_widget('wr-list', 'group-index-' . $row['bo_table'], 'wr_notice=1 bo_list=' . $row['bo_table']); ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
