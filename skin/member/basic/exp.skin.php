<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<ul class="list-group list-group-flush mb-4">
    <li class="list-group-item line-bottom">
        <i class="bi bi-battery-half"></i>
        누적 경험치
        <strong class="orangered"><?php echo number_format((int)$member['as_exp']) ?></strong> 점
    </li>
    <li class="list-group-item small bg-body-tertiary">
        전체 <b><?php echo $total_count ?></b>건 / <?php echo $page ?>페이지
    </li>
    <?php
    $i=0;
    $result = sql_query(" select * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ");
    if($result) {
        for ($i=0; $row=sql_fetch_array($result); $i++) {
    ?>
        <li class="list-group-item">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <?php echo $row['xp_content'] ?>
                    <div class="form-text">
                        <?php echo $row['xp_datetime']; ?>
                    </div>
                </div>
                <div class="ps-3 small text-nowrap">
                    <?php echo number_format($row['xp_point']); ?>
                </div>
            </div>
        </li>
    <?php
        }
    }

    if ($i == 0)
        echo '<li class="list-group-item py-5 text-center">자료가 없습니다.</li>';
    ?>
    <li class="list-group-item pb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="pe-3">
                <ul class="pagination pagination-sm">
                    <?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
                </ul>
            </div>
            <div>
                <button type="button" class="btn btn-basic btn-sm" onclick="window.close();">
                    <i class="bi bi-x-lg"></i>
                    <span class="d-none d-sm-inline-block">창닫기</span>
                </button>
            </div>
        </div>
    </li>
</ul>
