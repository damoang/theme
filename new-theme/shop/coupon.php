<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if ($is_guest)
    alert_close('회원만 조회하실 수 있습니다.');

$g5['title'] = $member['mb_nick'].' 님의 쿠폰 내역';
include_once(G5_PATH.'/head.sub.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

$sql = " select cp_id, cp_subject, cp_method, cp_target, cp_start, cp_end, cp_type, cp_price
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."'
            order by cp_no ";
$result = sql_query($sql);
?>

<!-- 쿠폰 내역 시작 { -->
<div id="coupon" class="new_win">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>
    <ul>
    <?php
    $cp_count = 0;
    for($i=0; $row=sql_fetch_array($result); $i++) {
        if(is_used_coupon($member['mb_id'], $row['cp_id']))
            continue;

        if($row['cp_method'] == 1) {
            $sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
            $ca = sql_fetch($sql);
            $cp_target = $ca['ca_name'].'의 상품할인';
        } else if($row['cp_method'] == 2) {
            $cp_target = '결제금액 할인';
        } else if($row['cp_method'] == 3) {
            $cp_target = '배송비 할인';
        } else {
            $it = get_shop_item($row['cp_target'], true);
            $cp_target = $it['it_name'].' 상품할인';
        }

        if($row['cp_type'])
            $cp_price = $row['cp_price'].'%';
        else
            $cp_price = number_format($row['cp_price']).'원';

        $cp_count++;
    ?>
    <li>
        <div class="cou_top">
            <span class="cou_tit"><?php echo $row['cp_subject']; ?></span>
            <span class="cou_pri"><?php echo $cp_price; ?></span>
        </div>
        <div>
            <span class="cou_target"><?php echo $cp_target; ?> <i class="fa fa-angle-right" aria-hidden="true"></i></span>
            <span class="cou_date"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo substr($row['cp_start'], 2, 8); ?> ~ <?php echo substr($row['cp_end'], 2, 8); ?></span>
        </div>
    </li>
    <?php
    }

    if(!$cp_count)
        echo '<li class="empty_li">사용할 수 있는 쿠폰이 없습니다.</li>';
    ?>
    </ul>
    <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
</div>

<?php
include_once(G5_PATH.'/tail.sub.php');