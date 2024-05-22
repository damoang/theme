<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$connect_skin_url.'/style.css">', 0);

$rows = array();
$admin_list = (isset($nariya['cf_admin']) && $nariya['cf_admin']) ? $config['cf_admin'].','.$nariya['cf_admin'] : $config['cf_admin'];
$admin_arr = na_explode(",", $admin_list);
$list_cnt = count($list);
for ($i=0; $i < $list_cnt; $i++) {
    // 최고관리자 제외
    if($list[$i]['mb_id'] && in_array($list[$i]['mb_id'], $admin_arr))
        continue;

    $rows[] = $list[$i];
}
unset($list);

$rows_cnt = count($rows);

?>

<h2 class="visually-hidden">
    현재 접속자 목록
</h2>
<ul class="list-group list-group-flush border-bottom mb-4">
    <li class="list-group-item line-bottom pt-0">
        <i class="bi bi-people"></i>
        현재 <b><?php echo $list_cnt ?></b> 명 접속 중
    </li>
    <?php
    $admin_list = (isset($nariya['cf_admin']) && $nariya['cf_admin']) ? $config['cf_admin'].','.$nariya['cf_admin'] : $config['cf_admin'];
    $admin_arr = na_explode(",", $admin_list);
    for ($i=0; $i < $rows_cnt; $i++) {

        $rows[$i]['num'] = sprintf('%03d', $i);

        //$location = conv_content($list[$i]['lo_location'], 0);
        $location = $rows[$i]['lo_location'];
        // 최고관리자에게만 허용
        // 이 조건문은 가능한 변경하지 마십시오.
        if ($rows[$i]['lo_url'] && $is_admin == 'super') $display_location = "<a href=\"".$rows[$i]['lo_url']."\">".$location."</a>";
        else $display_location = $location;
    ?>
        <li class="list-group-item">
            <div class="d-flex align-items-center">
                <div class="pe-3">
                    <img src="<?php echo na_member_photo($rows[$i]['mb_id']); ?>" class="rounded-circle" style="max-width:50px;">
                </div>
                <div class="flex-grow-1">
                    <?php echo $rows[$i]['num'] ?>. <?php echo $rows[$i]['name'] ?>
                    <div class="form-text text-truncate">
                        <?php echo $display_location ?>
                    </div>
                </div>
            </div>
        </li>
    <?php } ?>
    <?php if(!$rows_cnt) { ?>
        <li class="list-group-item text-center py-5">
            현재 접속자가 없습니다.
        </li>
    <?php } ?>
</ul>
