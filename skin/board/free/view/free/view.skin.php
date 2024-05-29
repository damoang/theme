<?php

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
// 회원만 보기가 설정되어 있고, 접속한 회원의 레벨이 2 미만인 경우
if ($view['wr_1'] == '1' && $member['mb_level'] < 2) { // 회원만 가능

    alert('우리 "앙"님만 열람할 수 있어요!');
    return;

}
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);

?>

<!--script src="<?php echo G5_JS_URL ?>/viewimageresize.js"></script-->

<!-- 게시물 읽기 시작 { -->
<!--      <div class="alert alert-light mb-4 mx-3 mx-sm-0" role="alert">-->
<!--                 <img src="https://damoang.net/logo/0416_02.gif" style="max-width: 100%">-->
<!---->
<!--          </div>-->
<?php echo na_widget('damoang-image-banner', 'board-head'); ?>

           <?php echo $config['cf_10'];?>
<article id="bo_v" class="mb-4">
    <header>
        <h1 id="bo_v_title" class="px-3 pb-2 mb-0 lh-base fs-5">
            <?php echo $view_subject; // 글제목 출력 ?>  <?php echo ($write['wr_1']  == '1') ? '<i class="fa fa-id-badge"></i>' : ''; ?>
        </h1>
    </header>

    <section id="bo_v_info">
        <h3 class="visually-hidden">페이지 정보</h3>
        <div class="d-flex justify-content-end align-items-center line-top border-bottom bg-body-tertiary py-2 px-3 small">
            <div class="me-auto">
                <span class="visually-hidden">작성자</span>
                <?php
                $wr_name = ($view['mb_id']) ? str_replace('sv_member', 'sv_member text-truncate', $view['name']) : str_replace('sv_guest', 'sv_guest text-truncate', $view['name']);
                echo na_name_photo($view['mb_id'], $wr_name);
                // 회원 메모
                echo $view['da_member_memo'] ?? '';
                ?>
                <span class="d-block"><?php echo $ip; ?></span>
            </div>



            <div>
                <span class="visually-hidden">작성일</span>
                <?php echo na_date($view['wr_datetime'], 'orangered', 'H:i', 'm.d H:i', 'Y.m.d H:i'); ?>
            </div>
        </div>


        <div class="d-flex gap-1 align-items-start pt-2 px-3 small">
            <?php if ($category_name) { ?>
                <div class="pe-2">
                    <i class="bi bi-book"></i>
                    <span class="visually-hidden">분류</span>
                    <?php echo $view['ca_name'] ?>
                </div>
            <?php } ?>
            <div class="pe-2">
                <i class="bi bi-eye"></i>
                <?php echo number_format($view['wr_hit']) ?>
                <span class="visually-hidden">조회</span>
            </div>
            <?php if ($view['wr_comment']) { ?>
                <div class="pe-2">
                    <i class="bi bi-chat-dots"></i>
                    <?php echo number_format($view['wr_comment']) ?>
                    <span class="visually-hidden">댓글</span>
                </div>
            <?php } ?>
            <?php if ($board['bo_use_good']) { // 추천 ?>
                <div class="pe-2">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <?php echo number_format($view['wr_good']) ?>
                    <span class="visually-hidden">추천</span>
                </div>
            <?php } ?>
            <?php if ($board['bo_use_nogood']) { // 비추천 ?>
                <div class="pe-2">
                    <i class="bi bi-hand-thumbs-down"></i>
                    <?php echo number_format($view['wr_nogood']) ?>
                    <span class="visually-hidden">비추천</span>
                </div>
            <?php } ?>
            <?php ob_start(); ?>
            <?php if ($update_href || $delete_href || $copy_href || $move_href) { ?>
            <div class="ms-auto dropstart">
                <button type="button" class="btn btn-basic btn-sm" data-bs-toggle="dropdown" aria-expanded="false"
                        title="글버튼">
                    <i class="bi bi-three-dots-vertical"></i>
                    <span class="visually-hidden">글버튼</span>
                </button>
                <ul class="dropdown-menu">
                    <?php if ($update_href) { ?>
                        <li><a href="<?php echo $update_href ?>" class="dropdown-item">
                                <i class="bi bi-pencil-square"></i>
                                수정하기
                            </a></li>
                    <?php } ?>
                    <?php if ($delete_href) { ?>
                        <li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;"
                               class="dropdown-item">
                                <i class="bi bi-trash"></i>
                                삭제하기
                            </a></li>
                    <?php } ?>
                    <?php if ($copy_href || $move_href) { ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    <?php } ?>
                    <?php if ($copy_href) { ?>
                        <li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;"
                               class="dropdown-item">
                                <i class="bi bi-stickies"></i>
                                복사하기
                            </a></li>
                    <?php } ?>
                    <?php if ($move_href) { ?>
                        <li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;"
                               class="dropdown-item">
                                <i class="bi bi-arrows-move"></i>
                                이동하기
                            </a></li>
                    <?php } ?>
                </ul>
            </div>

            <div>
                <?php } else { ?>
                <div class="ms-auto">
                    <?php } ?>
                    <?php if ($member['mb_level'] == 5 or $member['mb_level'] == 10): ?>


                        <button id="moveToTureRoomBtn" class="btn btn-basic btn-sm">
                            <i class="bi-universal-access"></i> 진실의 방으로
                        </button>

                        <script>
                            document.getElementById('moveToTureRoomBtn').addEventListener('click', function () {
                                $.ajax({
                                    type: "POST",
                                    url: "./move_to_tureroom.php", // 서버 측 스크립트 파일 경로
                                    data: {
                                        // 이동할 데이터나 조건 등을 설정
                                        bo_table: "tureroom",
                                        // 추가 데이터
                                    },
                                    success: function (response) {
                                        // 성공적으로 처리된 후의 동작 (예: 알림 표시)
                                        alert("이동 완료: " + response);
                                    },
                                    error: function (xhr, status, error) {
                                        // 오류 처리
                                        alert("오류 발생");
                                    }
                                });
                            });
                        </script>


                    <?php endif; ?>


                    <?php if ($update_href) { ?>


                        <a href="<?php echo $update_href ?>" class="btn btn-basic btn-sm">
                            <i class="bi bi-pencil-square"></i>
                            수정
                        </a>
                    <?php } ?>
                    <?php if ($delete_href) { ?>
                        <a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;"
                           class="btn btn-basic btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                    <?php } ?>
                </div>
                <?php if ($search_href) { ?>
                    <div>
                        <a href="<?php echo $search_href ?>" class="btn btn-basic btn-sm">
                            <i class="bi bi-<?php echo ($stx) ? 'binoculars' : 'bookmarks'; ?>"></i>
                            <span class="d-none d-sm-inline-block"><?php echo ($stx) ? '검색' : '분류'; ?></span>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($reply_href) { ?>
                    <div>
                    </div>
                <?php } ?>
                <?php if ($write_href) { ?>
                    <div>
                        <!-- 쓰기버튼 삭제
          <a href="<?php echo $write_href ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil"></i>
            <span class="d-none d-sm-inline-block">쓰기</span>
          </a>
        -->
                    </div>

                <?php } ?>
                <?php
                $link_buttons = ob_get_contents();
                ob_end_flush();
                ?>
            </div>
    </section>

    <section id="bo_v_atc" class="border-bottom p-3">
        <h3 class="visually-hidden">본문</h3>
        <div id="bo_v_con">
            <?php
            // 첨부 동영상 출력 - 이미지출력보다 위에 있어야 함
            if ($is_video_attach)
                echo na_video_attach();

            // 링크 동영상 출력
            if ($is_video_link)
                echo na_video_link($view['link']);

            // 첨부 이미지 출력
            $v_img_count = count($view['file']);
            if ($v_img_count) {
                echo '<div id="bo_v_img" class="mb-3">' . PHP_EOL;
                for ($i = 0; $i <= $v_img_count; $i++) {
                    if (isset($view['file'][$i]))
                        echo str_replace('<img', '<img class="img-fluid"', get_file_thumbnail($view['file'][$i]));
                }
                echo '</div>' . PHP_EOL;
            }
            ?>
            <div id="bo_v_con" class="<?php echo $is_convert ?>">
                <?php echo get_view_thumbnail(na_view($view)); // 글내용 출력 ?>
            </div>
            <?php // if ($is_signature) { // 서명 ?>

            <?php echo na_widget('mb-sign') ?>
            <p><?php // echo $signature ?></p>
            <?php // } ?>
        </div>
        <?php
        // 추천/비추천 여부 확인
        $bg_status = '';

        $sql = "select bg_id, bg_flag from {$g5['board_good_table']}
            where bo_table = '{$bo_table}'
            and wr_id = '{$wr_id}'
            and mb_id = '{$member['mb_id']}'";
        $row = sql_fetch($sql);

        if ($row) {
            if (isset($row['bg_flag']) && $row['bg_flag']) {
                $bg_status = $row['bg_flag'];
            }
        }
        ?>
        <div class="pt-5 pb-4 text-center">
            <div id="bo_v_act" class="btn-group" role="group">
                <?php if ($board['bo_use_good']) { ?>
                    <button type="button"
                            onclick="na_good('<?php echo $bo_table ?>', '<?php echo $wr_id ?>', 'good', 'wr_good');"
                            class="btn <?php echo ($bg_status == 'good') ? 'btn-primary' : 'btn-basic' ?>" title="추천">
                        <i class="bi bi-hand-thumbs-up"></i>
                        <b id="wr_good"><?php echo number_format($view['wr_good']) ?></b>
                        <span class="visually-hidden">추천</span>
                    </button>
                <?php } ?>
                <?php if ($board['bo_use_nogood']) { ?>
                    <button type="button"
                            onclick="na_good('<?php echo $bo_table ?>', '<?php echo $wr_id ?>', 'nogood', 'wr_nogood');"
                            class="btn <?php echo ($bg_status == 'nogood') ? 'btn-primary' : 'btn-basic' ?>"
                            title="비추천">
                        <i class="bi bi-hand-thumbs-down"></i>
                        <b id="wr_nogood"><?php echo number_format($view['wr_nogood']) ?></b>
                        <span class="visually-hidden">비추천</span>
                    </button>
                <?php } ?>
                <?php if ($scrap_href) { // 스크랩 ?>
                    <button type="button" class="btn btn-basic" onclick="win_scrap('<?php echo $scrap_href ?>');"
                            title="스크랩">
                        <i class="bi bi-bookmark-star"></i> 스크랩
                        <span class="visually-hidden">스크랩</span>
                    </button>
                <?php } ?>
                <button type="button" class="btn btn-basic"
                        onclick="na_sns_share('<?php echo na_seo_text($view['wr_subject']) ?>', '<?php echo $pset['href'] ?>', '<?php echo $view['seo_img'] ?>');"
                        title="SNS 공유">
                    <i class="bi bi-share"></i> 공유
                    <span class="visually-hidden">SNS 공유</span>
                </button>
                <button type="button" class="btn btn-basic"
                        onclick="na_singo('<?php echo $bo_table ?>', '<?php echo $wr_id ?>', '0', '');" title="신고">
                    <i class="bi bi-virus"></i> 신고
                    <span class="visually-hidden">신고</span>
                </button>
                <?php if ($view['mb_id']) { // 회원만 가능 ?>
                    <button type="button" class="btn btn-basic" onclick="na_chadan('<?php echo $view['mb_id'] ?>');"
                            title="차단">
                        <i class="bi bi-heartbreak"></i> 차단
                        <span class="visually-hidden">차단</span>
                    </button>
                <?php } ?>
            </div>
        </div>


        <style>
            .sg-name .sv_wrap .profile_img {
                display: none
            }

            .na-list * {
                max-width: 100%;
                max-height: 100%
            }
        </style>
        <div class="border mx-3 mx-sm-0 mb-3 p-3">
            <div class="row row-cols-1 row-cols-md-2 align-items-center">
                <div class="col-sm-5 col-md-4 text-center">
                    <div class="row row-cols-1 row-cols-md-2 align-items-center">
                        <div class="col-sm-auto col-md-auto">
                            <img src="<?php echo na_member_photo($view['mb_id']) ?>" class="rounded-circle" onerror="this.onerror=null; this.src='<?php echo G5_IMG_URL . '/no_profile.gif' ?>';">
                        </div>
                        <div class="col-sm-auto col-md-auto sg-name">
                            <?php echo $view['name'] ?>
                        </div>
                    </div>
                    <!-- <div class="clearfix f-sm text-center">
            <span class="float-left">
              <?php echo na_xp_icon($view['mb_id'], '', $view) ?>
              <?php echo $view['wr_name'] ?>
            </span>
            <span class="float-right">
              레벨 <?php echo $mbs['as_level'] ?>
            </span>
          </div> -->
                    <!-- <div class="progress" title="레벨업까지 <?php echo number_format($mbs['as_max'] - $mbs['as_exp']); ?> 경험치 필요">
            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $per ?>"
              aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per ?>%">
              <span class="sr-only"><?php echo $per ?>%</span>
            </div>
          </div> -->
                </div>
                <div class="col-sm-7 col-md-8">
                    <ul class="na-list">
                        <p><?php echo $signature ?></p>
                        <?php
                        // 리스트
                        for ($i = 0; $i < $list_cnt; $i++) {

                            // 아이콘 체크
                            if (isset($list[$i]['icon_secret']) && $list[$i]['icon_secret']) {
                                $is_lock = true;
                                $wr_icon = '<span class="na-icon na-secret"></span> ';
                            } else if (isset($list[$i]['icon_new']) && $list[$i]['icon_new']) {
                                $wr_icon = '<span class="na-icon na-new"></span> ';
                            } else {
                                $wr_icon = '';
                            }

                            // 파일 아이콘
                            $icon_file = '';
                            if ($thumb || (isset($list[$i]['as_thumb']) && $list[$i]['as_thumb'])) {
                                $icon_file = '<span class="na-ticon na-image"></span>';
                            } else if (isset($list[$i]['icon_file']) && $list[$i]['icon_file']) {
                                $icon_file = '<span class="na-ticon na-file"></span>';
                            }
                            ?>
                            <li>
                                <div class="na-title">
                                    <div class="float-right text-muted f-sm font-weight-normal ml-2">
                                        <span class="sr-only">등록일</span>
                                        <?php echo na_date($list[$i]['wr_datetime'], 'orangered', 'H:i', 'm.d', 'Y.m.d') ?>
                                    </div>
                                    <div class="na-item">
                                        <a href="<?php echo $list[$i]['href'] ?>" class="na-subject">
                                            <?php echo $wr_icon ?><?php echo $list[$i]['subject'] ?>
                                        </a>
                                        <?php echo $icon_file ?>
                                        <?php if (isset($list[$i]['wr_comment']) && $list[$i]['wr_comment']) { ?>
                                            <div class="na-info">
                    <span class="count-plus orangered">
                      <span class="sr-only">댓글</span>
                      <?php echo $list[$i]['wr_comment']; ?>
                    </span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <?php if ($view['wr_8']) { ?>
            <div class="d-flex mb-2">
                <div class="me-2">
                    <i class="bi bi-tags"></i>
                    <span class="visually-hidden">태그</span>
                </div>
                <div>
                    <?php echo na_get_tag($view['wr_8']) ?>
                </div>
            </div>
        <?php } ?>
    </section>

    <?php
    // 링크
    $is_link = 0;
    for ($i = 1; $i <= count($view['link']); $i++) {
        if ($view['link'][$i])
            $is_link++;
    }

    // 첨부
    $is_attach = 0;
    for ($i = 0; $i < count($view['file']); $i++) {
        if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
            $is_attach++;
    }
    ?>

    <?php if ($is_link || $is_attach) { ?>
        <section id="bo_v_data" class="border-bottom">
            <ul class="list-group list-group-flush">
                <?php if ($is_link) { ?>
                    <li class="list-group-item pb-1">
                        <?php
                        for ($i = 1; $i <= count($view['link']); $i++) {
                            if ($view['link'][$i]) {
                                ?>
                                <div class="d-flex align-items-center mb-1">
                                    <div class="me-2">
                                        <i class="bi bi-link-45deg"></i>
                                        <span class="visually-hidden">링크</span>
                                    </div>
                                    <div class="text-truncate">
                                        <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                                            <?php echo get_text($view['link'][$i]) ?>
                                        </a>
                                    </div>
                                    <div class="ps-1 text-nowrap">
                                        <span class="count-plus"> <?php echo $view['link_hit'][$i] ?></span>
                                        <span class="visually-hidden">회 연결</span>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </li>
                <?php } ?>
                <?php if ($is_attach) { ?>
                    <li class="list-group-item pb-1">
                        <?php
                        //가변 파일
                        for ($i = 0; $i < count($view['file']); $i++) {
                            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
                                ?>
                                <div class="d-flex align-items-center mb-1">
                                    <div class="me-2">
                                        <i class="bi bi-download"></i>
                                        <span class="visually-hidden">첨부</span>
                                    </div>
                                    <div class="text-truncate">
                                        <a href="<?php echo $view['file'][$i]['href'] ?>" class="view_file_download"
                                           title="<?php echo $view['file'][$i]['content'] ?>">
                                            <?php echo $view['file'][$i]['source'] ?>
                                            <span class="visually-hidden">파일크기</span>
                                            <span class="small">(<?php echo $view['file'][$i]['size'] ?>)</span>
                                        </a>
                                    </div>
                                    <div class="ps-1 pe-2 text-nowrap">
                                        <span class="count-plus"> <?php echo $view['file'][$i]['download'] ?></span>
                                        <span class="visually-hidden">회 다운로드</span>
                                    </div>
                                    <div class="ms-auto text-nowrap small">
                                        <span class="visually-hidden">등록일</span>
                                        <?php echo date("Y.m.d H:i", strtotime($view['file'][$i]['datetime'])) ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </li>
                <?php } ?>
            </ul>
        </section>
    <?php } ?>



    <?php
    // 댓글
    include_once(NA_PATH . '/comment.skin.php');
    ?>

    <div class="d-flex align-items-center gap-1 border-top px-3 pt-2 mb-4">
        <?php if ($prev_href) { ?>
            <div>
                <a href="<?php echo $prev_href ?>" class="btn btn-basic btn-sm"
                   title="<?php echo $prev_wr_subject; ?> <?php echo date("Y.m.d", strtotime($prev_wr_date)) ?>"
                   title="이전글">
                    <i class="bi bi-chevron-left"></i>
                    <span class="d-none d-sm-inline-block">이전글</span>
                </a>
            </div>
        <?php } ?>
        <?php if ($next_href) { ?>
            <div>
                <a href="<?php echo $next_href ?>" class="btn btn-basic btn-sm"
                   title="<?php echo $next_wr_subject; ?> <?php echo date("Y.m.d", strtotime($next_wr_date)) ?>"
                   title="다음글">
                    <span class="d-none d-sm-inline-block">다음글</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        <?php } ?>
        <div>
            <a href="<?php echo get_pretty_url($bo_table, '', $qstr) ?>" class="btn btn-basic btn-sm" title="목록보기">
                <i class="bi bi-list-ul"></i>
                <span class="d-none d-sm-inline-block">목록</span>
            </a>
        </div>
        <?php echo $link_buttons; // 버튼 출력 ?>
    </div>
</article>

<div class="mb-3">
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
</div>


</script>
<script>
    function board_move(href) {
        window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
    }

    $(function () {
        <?php if ($board['bo_download_point'] < 0) { ?>
        $("a.view_file_download").click(function () {
            if (!g5_is_member) {
                na_alert('다운로드 권한이 없습니다.\n\n회원이시라면 로그인 후 이용해 보십시오.');
                return false;
            }

            let msg =
                "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다. 그래도 다운로드 하시겠습니까?";

            let href = $(this).attr("href") + "&js=on";
            $(this).attr("href", href);

            na_confirm(msg, function () {
                location.href = href;
            });

            return false;
        });
        <?php } ?>

        // 이미지 리사이즈
        // $("#bo_v_atc").viewimageresize();

        <?php if($view['is_chadan'] || $view['is_singo']) { ?>
        Swal.fire({
            html: "<b><?php echo ($view['is_chadan']) ? '차단 회원' : '신고한';?> 글입니다.</b><br><br>열람 하시겠습니까?",
            showCancelButton: true,
            allowOutsideClick: false,
            backdrop: 'rgba(0,0,0,0.75)',
        }).then(function (result) {
            if (result.isConfirmed) {
                ;
            } else if (result.isDismissed) {
                location.href = "<?php echo get_pretty_url($bo_table);?>";
            }
        });
        <?php } ?>
    });
</script>
