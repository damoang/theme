<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $list_skin_url . '/list.css?CACHEBUST">', 0);
?>

<section id="bo_list" class="line-top mb-3">
    
    <ul class="list-group list-group-flush border-bottom">
        <li class="list-group-item d-none d-md-block hd-wrap">
            <div class="d-flex flex-md-row align-items-md-center gap-1 fw-bold">
                <?php if($is_good) { ?>
                    <div class="hd-num text-center">
                        <?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a>
                    </div>
                <?php } ?>
                <!-- <div class="col-1 text-center">
                    번호
                </div> -->
                <div class="text-center flex-grow-1">
                    제목
                </div>
                <div class="ms-md-auto">
                    <div class="d-flex gap-2">
                        <div class="hd-name text-center">
                            이름
                        </div>
                        <div class="hd-date text-center">
                            <?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</a>
                        </div>
                        <div class="hd-num text-center">
                            <?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회</a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php
        $list_cnt = count($list);
        for ($i=0; $i < $list_cnt; $i++) {

            // 여분필드 사용 내역
            // wr_7 : 신고(lock)
            // wr_8 : 태그
            // wr_9 : 유튜브 동영상
            // wr_10 : 대표 이미지

            $row = $list[$i];

            // 유뷰트 동영상(wr_9)
            $vinfo = na_check_youtube($row['wr_9']);

            // 이미지(wr_10)
            $img = na_check_img($row['wr_10']);

            //아이콘 체크
            $wr_icon = '';
            if (isset($row['icon_new']) && $row['icon_new'])
                $wr_icon .= '<span class="na-icon na-new"></span>'.PHP_EOL;

            if (isset($row['icon_secret']) && $row['icon_secret'])
                $wr_icon .= '<span class="na-icon na-secret"></span>'.PHP_EOL;

            if (isset($row['icon_hot']) && $row['icon_hot'])
                $wr_icon .= '<span class="na-icon na-hot"></span>'.PHP_EOL;

            if ($vinfo['vid']) {
                $wr_icon .= '<span class="na-icon na-video"></span>'.PHP_EOL;
            } else if ($img) {
                $wr_icon .= '<span class="na-icon na-image"></span>'.PHP_EOL;
            } else if (isset($row['icon_file']) && $row['icon_file']) {
                $wr_icon .= '<span class="na-icon na-file"></span>'.PHP_EOL;
            } else if (isset($row['icon_link']) && $row['icon_link']) {
                $wr_icon .= '<span class="na-icon na-link"></span>'.PHP_EOL;
            }

            // 잠긴글, 공지글, 현재글 스타일
            $li_css = '';
            if ($row['wr_7'] == 'lock') { // 잠금(wr_7)
                $li_css = '';
                $row['subject'] = '<span class="text-decoration-line-through">'.$row['subject'].'</span>';
                $row['num'] = '<span class="orangered">잠금</span>';
            } else if ($wr_id == $row['wr_id']) { // 열람
                $li_css = ' bg-light-subtle';
                $row['subject'] = '<b class="text-primary fw-medium">'.$row['subject'].'</b>';
                $row['num'] = '<span class="orangered">열람</span>';
            } else if ($row['is_notice']) { // 공지
                $li_css = ' bg-light-subtle';
                $row['subject'] = '<strong class="fw-medium">'.$row['subject'].'</strong>';
                $row['num'] = '<span class="orangered">공지</span>';
                $row['wr_good'] = '<span class="orangered">공지</span>';
            }

            // 내가 작성한 글 강조하기
            $writter_bg = "";
            if(trim($list[$i]['mb_id']) == trim($member['mb_id'])){
                $writter_bg = "writter-bg";
            }
        ?>
            <li class="list-group-item da-link-block <?php echo $li_css; ?> <?php echo $writter_bg; ?>">

                <div class="d-flex align-items-center gap-1">
                    <?php if($is_good) { ?>
                        <!--  추천수에 따른 컬러세트 지정(게시판 목록) -->
                        <?php
                            $rcmd_step = "rcmd-box step1";
                            if(strpos($row['wr_good'],'공지') == true) {
                                $rcmd_step = ""; //공지사항은 추천수 표시하지 않고 "공지" 텍스트 출력
                            }else if($row['wr_good'] == 0) {
                                $rcmd_step = "rcmd-box step0";
                            }else if($row['wr_good'] <= 5) {
                                $rcmd_step = "rcmd-box step1";
                            }else if($row['wr_good'] > 5 && $row['wr_good'] <=10) {
                                $rcmd_step = "rcmd-box step2";
                            }else if($row['wr_good'] > 10 && $row['wr_good'] <=50) {
                                $rcmd_step = "rcmd-box step3";
                            }else if($row['wr_good'] > 50) {
                                $rcmd_step = "rcmd-box step4";
                            }
                        ?>
                        <div class="wr-num text-nowrap rcmd-pc">
                            <i class="bi bi-hand-thumbs-up d-inline-block d-md-none"></i>
                            <div class="<?php echo $rcmd_step ?>">
                            <?php echo $row['wr_good'] ?>
                            </div>
                            <span class="visually-hidden">추천</span>
                        </div>
                    <?php } ?>
                    <!-- <div class="col-1 wr-no d-none d-md-block">
                        <?//php echo $row['num'] ?>
                    </div> -->
                    <?php if ($is_checkbox) { ?>
                        <div>
                            <input class="form-check-input me-1" type="checkbox" name="chk_wr_id[]" value="<?php echo $row['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                            <label for="chk_wr_id_<?php echo $i ?>" class="visually-hidden">
                                <?php echo $row['subject'] ?>
                            </label>
                        </div>
                    <?php } ?>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                            <div class="d-inline-flex flex-fill overflow-hidden align-items-center">
                                <?php
                                // 회원만 보기
                                echo $row['da_member_only'] ?? '';
                                ?>
                                <a href="<?php echo $row['href'] ?>" class="da-link-block subject-ellipsis" title="<?php echo $row['wr_subject']; ?>">
                                    <?php if($row['icon_reply']) { ?>
                                        <i class="bi bi-arrow-return-right"></i>
                                        <span class="visually-hidden">답변</span>
                                    <?php } ?>
                                    <?php echo $row['subject']; // 제목 ?>
                                </a>

                                <?php if (!$sca && $is_category && $row['ca_name']) { ?>
                                    <a href="<?php echo $row['ca_name_href'] ?>" class="badge text-body-tertiary px-1">
                                        <?php echo $row['ca_name'] ?>
                                        <span class="visually-hidden">분류</span>
                                    </a>
                                <?php } ?>

                                <?php echo $wr_icon; ?>

                                <?php if($row['wr_comment']) { ?>
                                    <span class="visually-hidden">댓글</span>
                                    <span class="count-plus orangered">
                                        <?php echo $row['wr_comment'] ?>
                                    </span>
                                <?php } ?>
                                <?php if ($row['da_member_memo'] ?? '') { ?>
                                    <!-- 다모앙 회원 메모 -->
                                    <span class="float-end"><?= $row['da_member_memo'] ?></span>
                                <?php } ?>
                            </div>
                            <div class="da-list-meta">
                                <div class="d-flex gap-2">
                                    <div class="wr-name ms-auto order-last order-md-1">
                                        <?php
                                            $wr_name = ($row['mb_id']) ? str_replace('sv_member', 'sv_member text-truncate d-block', $row['name']) : str_replace('sv_guest', 'sv_guest text-truncate d-block', $row['name']);
                                            echo na_name_photo($row['mb_id'], $wr_name);
                                        ?>
                                    </div>
                                    <div class="wr-date text-nowrap order-5 order-md-2">
                                        <i class="bi bi-clock d-inline-block d-md-none"></i>
                                        <?php echo na_date($row['wr_datetime'], 'orangered da-list-date') ?>
                                        <span class="visually-hidden">등록</span>
                                    </div>
                                    <!-- 추천 수 (모바일) -->
                                    <?php if($is_good && $row['wr_good'] > 0) { ?>
                                        <div class="wr-num da-rcmd rcmd-mb text-nowrap d-md-none">
                                            <div class="<?php echo $rcmd_step ?> w-auto">
                                            <?php if(!strpos($row['wr_good'], '공지')) { ?>
                                                <i class="bi bi-hand-thumbs-up" style="font-size:.7rem"></i>
                                            <?php } ?>
                                            <?php echo $row['wr_good'] ?>
                                            </div>
                                            <span class="visually-hidden">추천</span>
                                        </div>
                                    <?php } ?>
                                    <div class="wr-num text-nowrap order-4">
                                        <i class="bi bi-eye d-inline-block d-md-none"></i>
                                        <?php echo $row['wr_hit'] ?>
                                        <span class="visually-hidden">조회</span>
                                    </div>
                                    <div class="wr-num text-nowrap order-2 d-md-none d-none da-list-meta--comments">
                                        <i class="bi bi-chat-dots d-inline-block d-md-none"></i>
                                        <?php echo $row['wr_comment'] ?>
                                        <span class="visually-hidden">댓글</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </li>
    <?php } ?>
    <?php if ($list_cnt - $notice_count === 0) { ?>
        <li class="list-group-item text-center py-5">
            게시물이 없습니다.
        </li>
    <?php } ?>
    </ul>
</section>

