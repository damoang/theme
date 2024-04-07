<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div id="main-wrap" class="bg-body">
    <div class="container px-0 px-sm-3 shadow-sm p-3 mb-5 rounded">
        <div class="row row-cols-1 row-cols-md-2 g-3">
            <div class="order-1 col-md-4 col-lg-3">
                <div class="sticky-top py-3">
                    <?php include_once LAYOUT_PATH.'/component/sidebar.php'; // 사이드바 ?>
                </div>
            </div>
            <div class="order-2 col-md-8 col-lg-9">
                <div class="sticky-top py-3">
                    <div class="alert alert-light mb-4 mx-3 mx-sm-0" role="alert"><?php echo $config['cf_1']; ?></div>
<div class="shadow-sm p-3 mb-5 rounded row">
    <!-- 사진 최신글2 { -->
        <h3 class="h3">뜨는 게시글</h3>
        <hr class="hr" />
    <?php echo na_widget('wr-gallery', 'dm-besteste3r', 'bo_list=free'); ?>
    <!-- } 사진 최신글2 끝 -->
</div>

                    <div class="shadow-sm p-3 mb-5 rounded row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                추천 게시글
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'dm-recommend', 'bo_list=free'); ?>
                            </div>
                        </div>

                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                자유게시판
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'dm-free', 'bo_list=free'); ?>
                            </div>
                        </div>
                        <!-- } 위젯 끝 -->
                    </div>
                    <div class="shadow-sm p-3 mb-5 rounded row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                공지사항
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'dm-notice', 'bo_list=free'); ?>
                            </div>
                        </div>

                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                랜덤글
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'dm-random', 'bo_list=free'); ?>
                            </div>
                        </div>
                        <!-- } 위젯 끝 -->
                    </div>
                    <hr class="hr" />
                    <div class="shadow-sm p-3 mb-5 rounded row">
                        <!-- 위젯 시작 { -->
                        <h3 class="fs-5 px-3 py-2 mb-0">
                            <a href="<?php echo get_pretty_url('gallery') ?>">
                                갤러리
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </a>
                        </h3>
                        <div class="line-top mb-4">
                            <?php echo na_widget('wr-gallery', 'dm-gallery', 'bo_list=gallery'); ?>
                        </div>
                    </div>
                    <div class="shadow-sm p-3 mb-5 rounded row">
                        <!-- 위젯 시작 { -->
                        <h3 class="fs-5 px-3 py-2 mb-0">
                            <a href="<?php echo get_pretty_url('new') ?>">
                                새소게
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </a>
                        </h3>
                        <div class="line-top mb-4">
                            <?php echo na_widget('wr-webzine', 'dm-new', 'bo_list=new'); ?>
                        </div>
                    </div>
                    <div class="shadow-sm p-3 mb-5 rounded row">
                        <!-- 위젯 시작 { -->
                        <h3 class="fs-5 px-3 py-2 mb-0">
                            <a href="<?php echo get_pretty_url('tutorial') ?>">
                                사용기/강좌
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </a>
                        </h3>
                        <div class="line-top mb-4">
                            <?php echo na_widget('wr-webzine', 'dm-tutorial', 'bo_list=tutorial'); ?>
                        </div>
                    </div>
                    <div class="shadow-sm p-3 mb-5 rounded row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                질문/답변
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'dm-qa', 'bo_list=qa'); ?>
                            </div>
                        </div>

                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                알뜰구매
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'dm-economy', 'bo_list=economy'); ?>
                            </div>
                        </div>
                        <!-- } 위젯 끝 -->
                    </div>
                    <h3 class="shadow-sm p-3 mb-5 rounded fs-5 px-3 py-2 mb-0">
                        <a href="/somoim/index.php">
                            <i class="bi bi-bell"></i>
                            TOP10 소모임
                            <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                        </a>
                    </h3>
                    
                    <div class="shadow-sm p-3 mb-5 rounded row row-cols-1 row-cols-sm-2">
                        <?php 
$sql = "select bo_table, bo_subject
			from {$g5['board_table']}
			where gr_id = 'group'
              ORDER BY bo_count_write DESC LIMIT 10";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
                        <div class="col">
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url($row['bo_table']); ?>">
                                    <span class="pull-right more-plus"></span>
                                    <?php echo get_text($row['bo_subject']) ?>
                                </a>
                            </h3>
                            <div class="line-top pb-4">
                                <?php echo na_widget('wr-list', 'group-index-'.$row['bo_table'], 'wr_notice=1 bo_list='.$row['bo_table']); ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<div class="order-2 col-md-4 col-lg-3">
    <div class="sticky-top py-3">
        <?php include_once LAYOUT_PATH.'/component/sidebar.php'; // 사이드바 ?>
    </div>
</div>