<?php
if (!defined('_GNUBOARD_'))
    exit; //개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);
$widget_path = LAYOUT_PATH . '/widget/wr-list-recommend';
require_once $widget_path . '/widget.lib.php';

// 게시물 추출
$wset['rows_notice'] = true; // 추출수에 공지글 포함
$list = na_board_rows_custom($wset);
$list_cnt = count($list);

// 랭킹
$rank = na_rank_start($wset['rows'], $wset['page']);
$is_rank = (isset($wset['rank']) && $wset['rank']) ? $wset['rank'] : '';
$wset['rank_color'] = (isset($wset['rank_color']) && $wset['rank_color']) ? $wset['rank_color'] : 'text-bg-primary';

// 아이콘
$icon = isset($wset['icon']) ? '<i class="' . str_replace('+', ' ', $wset['icon']) . '"></i>' : '';

// 보드명, 분류명
$is_bo_name = (isset($wset['bo_name']) && $wset['bo_name']) ? true : false;
$bo_name = ($is_bo_name && (int) $wset['bo_name'] > 0) ? $wset['bo_name'] : 0;

// 공지글 강조
$wr_notice = (isset($wset['is_notice']) && $wset['is_notice']) ? ' bg-body-tertiary fw-bold' : '';

?>

<ul class="list-group list-group-flush border-bottom">
    <?php
    for ($i = 0; $i < $list_cnt; $i++) {

        $row = $list[$i];

        // 유뷰트 동영상(wr_9)
        $vinfo = na_check_youtube($row['wr_9']);

        // 이미지(wr_10)
        $img = na_check_img($row['wr_10']);

        // 아이콘 체크
        if ($is_rank && !$row['is_notice']) {
            $wr_head = '<span class="badge ' . $is_rank . ' ' . $wset['rank_color'] . ' fw-normal">' . $rank . '</span>';
            $rank++;
        } else {
            $wr_head = $icon;
        }

        $wr_icon = '';
        if ($row['icon_new'])
            $wr_icon .= '<span class="na-icon na-new"></span>' . PHP_EOL;

        if ($row['icon_secret'])
            $wr_icon .= '<span class="na-icon na-secret"></span>' . PHP_EOL;

        if ($vinfo['vid']) {
            $wr_icon .= '<span class="na-icon na-video"></span>' . PHP_EOL;
        } else if ($img) {
            $wr_icon .= '<span class="na-icon na-image"></span>' . PHP_EOL;
        }

        // 보드명, 분류명
        if ($is_bo_name) {
            $ca_name = '';
            if (isset($row['bo_subject']) && $row['bo_subject']) {
                $ca_name = ($bo_name) ? cut_str($row['bo_subject'], $bo_name, '') : $row['bo_subject'];
            } else if ($row['ca_name']) {
                $ca_name = ($bo_name) ? cut_str($row['ca_name'], $bo_name, '') : $row['ca_name'];
            }

            if ($ca_name) {
                $row['subject'] = '<small>[' . $ca_name . ']</small> ' . $row['subject'];
            }
        }
        ?>
        <li class="list-group-item da-link-block <?php echo ($row['is_notice']) ? $wr_notice : ''; ?>">
            <div class="d-flex align-items-center gap-1">
                <?php if (!$row['is_notice']) { ?>
                <!-- 추천 수 -->
                <!--  추천수에 따른 컬러세트 지정(메인) -->
                <?php
                    $rcmd_step = "rcmd-box step1";
                    if($row['wr_good'] <= 15) {
                        $rcmd_step = "rcmd-box step1";
                    }else if($row['wr_good'] > 15 && $row['wr_good'] <= 25) {
                        $rcmd_step = "rcmd-box step2";
                    }else if($row['wr_good'] > 25 && $row['wr_good'] <= 50) {
                        $rcmd_step = "rcmd-box step3";
                    }else if($row['wr_good'] > 50) {
                        $rcmd_step = "rcmd-box step4";
                    }
                ?>
                <span class="<?php echo $rcmd_step ?> rcmd-sm"><?= intval($row['wr_good'] ?? 0) ?></span>
                <?php } ?>
                <!-- 제목 -->
                <div class="text-truncate">
                    <a href="<?php echo $row['href'] ?>" class="da-link-block">
                        <!-- 게시글 제목 텍스트 부분 클릭시 서버요청 2번 하는 버그 수정 -->
                        <?php echo $wr_head ?>
                        <?php echo $row['subject'] ?>
                    </a>
                </div>

                <div class="ms-auto ps-1 small text-body-tertiary text-nowrap">
                    <?php echo na_date($row['wr_datetime'], 'orangered') ?>
                </div>
            </div>
        </li>
    <?php } ?>
    <?php if (!$list_cnt) { ?>
        <li class="list-group-item text-center py-5">
            게시물이 없습니다.
        </li>
    <?php } ?>
</ul>

<?php if ($setup_href) { ?>
    <div class="btn-wset py-2">
        <button onclick="naClipView('<?php echo $setup_href ?>');" class="btn btn-basic btn-sm">
            <i class="bi bi-gear"></i>
            위젯설정
        </button>
    </div>
<?php } ?>
