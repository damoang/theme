<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if (!defined("_ORDERINQUIRY_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

?>
<style>
#sod_v_info { display:none; }
</style>
<ul class="list-group list-group-flush">
	<li class="list-group-item line-bottom">
		<i class="bi bi-box2-heart"></i>
		주문번호를 누르면 주문상세내역을 조회할 수 있습니다.
	</li>
	<li class="list-group-item d-none d-xl-block bg-body-tertiary">
		<div class="row align-items-md-center gy-1 gx-3 fw-bold">
			<div class="col-2 text-end text-nowrap">주문번호</div>
			<div class="col-2 text-end text-nowrap">주문일시</div>
			<div class="col-1 text-end text-nowrap">상품수</div>
			<div class="col-2 text-end text-nowrap">주문금액</div>
			<div class="col-2 text-end text-nowrap">입금액</div>
			<div class="col-2 text-end text-nowrap">미입금액</div>
			<div class="col-1 text-end text-nowrap">상태</div>
		</div>
	</li>
	<?php
    $sql = " select *
               from {$g5['g5_shop_order_table']}
              where mb_id = '{$member['mb_id']}'
              order by od_id desc
              $limit ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

        switch($row['od_status']) {
            case '주문':
                $od_status = '<span class="status_01">입금확인중</span>';
                break;
            case '입금':
                $od_status = '<span class="status_02">입금완료</span>';
                break;
            case '준비':
                $od_status = '<span class="status_03">상품준비중</span>';
                break;
            case '배송':
                $od_status = '<span class="status_04">상품배송</span>';
                break;
            case '완료':
                $od_status = '<span class="status_05">배송완료</span>';
                break;
            default:
                $od_status = '<span class="status_06">주문취소</span>';
                break;
        }
    ?>

	<li class="list-group-item">
		<div class="row align-items-center gy-1 gx-3">
			<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 text-end text-nowrap clearfix">
				<span class="d-inline-block d-xl-none float-start">주문번호</span>
				<a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>"><?php echo $row['od_id']; ?></a>	
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 text-end text-nowrap clearfix">
				<span class="d-inline-block d-xl-none float-start">주문일시</span>
				<?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3 col-xl-1 text-end text-nowrap clearfix">
				<span class="d-inline-block d-xl-none float-start">상품수</span>
				<?php echo $row['od_cart_count']; ?>			
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 text-end text-nowrap clearfix">
				<span class="d-inline-block d-xl-none float-start">주문금액</span>
				<?php echo display_price($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?>			
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 text-end text-nowrap clearfix">
				<span class="d-inline-block d-xl-none float-start">입금액</span>
				<?php echo display_price($row['od_receipt_price']); ?>			
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 text-end text-nowrap clearfix">
				<span class="d-inline-block d-xl-none float-start">미입금액</span>
				<?php echo display_price($row['od_misu']); ?>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3 col-xl-1 text-end text-nowrap clearfix">
				<span class="d-inline-block d-xl-none float-start">상태</span>
				<a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>">
					<?php echo $od_status; ?>
				</a>
			</div>
			<div class="col-sm-6 col-md-8 col-lg-3 d-block d-xl-none">
				<a class="btn btn-basic btn-sm w-100" href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>">
					상세내역보기
					<i class="bi bi-arrow-bar-right"></i>
				</a>
			</div>
		</div>
	</li>
    <?php
    }

    if ($i == 0)
        echo '<li class="list-group-item py-5 text-center">주문 내역이 없습니다.</li>';
    ?>
</ul>