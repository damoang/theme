<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 현재 날짜와 시간을 'Y-m-d H:i:s' 형식으로 지정
$dt = new DateTime();
$formatted_dt = $dt->format('Y-m-d');
    
?>

<div id="main-wrap" class="bg-body">
    <div class="container px-0 px-sm-3">
        <div class="row row-cols-1 row-cols-md-2 g-3">
            <div class="order-1 col-md-8 col-lg-9">
                <div class="py-3">
                    <?php echo na_widget('damoang-image-banner', 'wide-banner'); ?>
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                    <a href="/free?bo_table=free&sop=and&sod=desc&sfl=wr_datetime&stx=<?php echo urlencode($formatted_dt); ?>&sca=&page=1&sst=wr_good">

                                    <i class="bi bi-chat-dots"></i>
                                    추천 글 (오늘 기준)
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list-recommend', 'idx-recommended-o', 'bo_list=free wr_notice=1 is_notice=1 wr_comment=0'); ?>

                            </div>
                            <!-- } 위젯 끝 -->
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url('new') ?>">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                    새로운 소식
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-new', 'bo_list=new wr_notice=1 is_notice=1'); ?>

                            </div>
                            <!-- } 위젯 끝 -->
                        </div>

                        <div class="col">
                            <h3 class="fs-5 px-3 py-2 mb-0 line-bottom">
                                <a href="<?php echo get_pretty_url('notice') ?>">
                                    <i class="bi bi-bell"></i>
                                    공지사항
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                           <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-notice', 'bo_list=notice wr_notice=1 is_notice=1'); ?>
                          </div>
                          <!-- 위젯 시작 { -->
                          <h3 class="fs-5 px-3 py-2 mb-0">
                            <a href="<?php echo get_pretty_url('qa') ?>">
                                <i class="bi bi-question-circle"></i>
                                질문답변
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </a>
                        </h3>
                        <div class="line-top mb-4">
                            <?php echo na_widget('wr-list', 'idx-qa', 'bo_list=qa wr_notice=1 is_notice=1'); ?>
                        </div>
                        <!-- } 위젯 끝 -->
                          <!-- 위젯 시작 { -->
                          <h3 class="fs-5 px-3 py-2 mb-0">
                            <a href="<?php echo get_pretty_url('angmap') ?>">
                                <i class="bi bi-geo-alt-fill"></i>
                                앙지도
                                <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                            </a>
                        </h3>
                        <div class="line-top mb-4">
                            <?php echo na_widget('wr-list', 'idx-map', 'bo_list=qa wr_notice=0 is_notice=0'); ?>
                        </div>
                        <!-- } 위젯 끝 -->
                 
                        </div>
                    </div>
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6922133409882969"
                         crossorigin="anonymous"></script>
                    <!-- 게시풀 하단 -->
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:860px;height:100px"
                         data-ad-client="ca-pub-6922133409882969"
                         data-ad-slot="3013497299"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url('economy') ?>">
                                    <i class="bi bi-cart-plus-fill"></i>
                                    알뜰구매
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-download', 'bo_list=gallery wr_notice=1 is_notice=1'); ?>

                            </div>
                            <!-- } 위젯 끝 -->
                        </div>

                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url('free') ?>">
                                    <i class="bi bi-chat-dots"></i>
                                    자유게시판
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-free', 'bo_list=free wr_notice=1 is_notice=1'); ?>
                            </div>
                            <!-- } 위젯 끝 -->

                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url('lecture') ?>">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    강좌 / 팁
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-lecture', 'bo_list=lecture wr_notice=1 is_notice=1'); ?>

                            </div>
                            <!-- } 위젯 끝 -->
                        </div>

                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url('tutorial') ?>">
                                    <i class="bi bi-chat-dots"></i>
                                    사용기
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-use', 'bo_list=tutorial wr_notice=1 is_notice=1'); ?>
                            </div>
                            <!-- } 위젯 끝 -->

                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url('new') ?>">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                    새로운 소식
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-new', 'bo_list=new wr_notice=1 is_notice=1'); ?>

                            </div>
                            <!-- } 위젯 끝 -->

                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url('pds') ?>">
                                    <i class="bi bi-postcard-heart"></i>
                                    자료실
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-pds', 'bo_list=qa wr_notice=1 is_notice=1'); ?>

                            </div>
                            <!-- } 위젯 끝 -->


                        </div>

                        <div class="col">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="/bbs/group.php?gr_id=group">
                                    <i class="fa fa-users"></i>
                                    소모임
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-group', 'bo_list=group wr_notice=1 is_notice=1'); ?>

                            </div>
                            <!-- } 위젯 끝 -->
                        </div>

                    </div>

                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6922133409882969"
                         crossorigin="anonymous"></script>
                    <!-- 게시풀 하단 -->
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:860px;height:100px"
                         data-ad-client="ca-pub-6922133409882969"
                         data-ad-slot="3013497299"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>

                    <!-- 위젯 시작 { -->
                    <h3 class="fs-5 px-3 py-2 mb-0">
                        <a href="<?php echo get_pretty_url('gallery') ?>">
                            <i class="bi bi-images"></i>
                            갤러리
                            <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                        </a>
                    </h3>
                    <div class="line-top mb-4">
                        <?php echo na_widget('wr-gallery', 'idx-gallery', 'bo_list=gallery wr_notice=1 is_notice=1 rows=8'); ?>
                    </div>
                    <!-- } 위젯 끝 -->


                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                          
                        </div>
                        <div class="col">
                            <?php /*<div class="col d-none">
                            <!-- 위젯 시작 { -->
                            <h3 class="fs-5 px-3 py-2 mb-0">
                                <a href="<?php echo get_pretty_url('angmap') ?>">
                                    <i class="bi-geo-alt-fill"></i>
                                    앙지도
                                    <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                </a>
                            </h3>
                            <div class="line-top mb-4">
                                <?php echo na_widget('wr-list', 'idx-map', 'bo_list=angmap wr_notice=1 is_notice=1'); ?>

                            </div>
                            <!-- } 위젯 끝 -->
   */?>
                        </div>


                    </div>
                    <?php if ($is_member) { ?>

                    <?php } else { ?>


                    <?php if (is_mobile()) { ?>
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6922133409882969"
                                crossorigin="anonymous"></script>
                        <!-- 수평형 -->
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-6922133409882969"
                             data-ad-slot="5448923097"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    <?php } else { ?>
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6922133409882969"
                                crossorigin="anonymous"></script>
                        <!-- 게시풀 하단 -->
                        <ins class="adsbygoogle"
                             style="display:inline-block;width:860px;height:100px"
                             data-ad-client="ca-pub-6922133409882969"
                             data-ad-slot="3013497299"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    <?php } ?>

                    <?php /*<div class="col d-none">
                            <div class="row row-cols-1 row-cols-lg-2">
                            <div class="col">
                                <!-- 위젯 시작 { -->
                                <h3 class="fs-5 px-3 py-2 mb-0">
                                    <a href="<?php echo get_pretty_url('notice') ?>">
                                        <i class="bi bi-bell"></i>
                                        공지사항
                                        <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                    </a>
                                </h3>
                                <div class="line-top mb-4">
                                    <?php echo na_widget('wr-list', 'idx-notice', 'bo_list=notice wr_notice=1 is_notice=1'); ?>

                                </div>
                                <!-- } 위젯 끝 -->
                            </div>

                            <div class="col">
                                <!-- 위젯 시작 { -->
                                <h3 class="fs-5 px-3 py-2 mb-0">
                                    <a href="<?php echo get_pretty_url('free') ?>">
                                        <i class="bi bi-chat-dots"></i>
                                        자유게시판
                                        <i class="bi bi-plus small float-end mt-1 text-body-tertiary"></i>
                                    </a>
                                </h3>
                                <div class="line-top mb-4">
                                    <?php echo na_widget('wr-list', 'idx-free-b', 'bo_list=free wr_notice=1 is_notice=1'); ?>
                                </div>
                                <!-- } 위젯 끝 -->

                            </div>
                        </div>
                        */?>


                    <?php } ?>

                </div>
            </div>
            <div class="order-2 col-md-4 col-lg-3">
                <div class="py-3">
                    <?php include_once LAYOUT_PATH . '/component/sidebar.php'; // 사이드바 ?>
                </div>
            </div>
        </div>
    </div>
</div>
