<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(IS_EXTEND)
	na_delivery_complete("입금");

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

$g5['title'] = '주문상세내역';
include_once('./_head.php');

// LG 현금영수증 JS
if($od['od_pg'] == 'lg') {
    if($default['de_card_test']) {
    echo '<script language="JavaScript" src="'.SHOP_TOSSPAYMENTS_CASHRECEIPT_TEST_JS.'"></script>'.PHP_EOL;
    } else {
        echo '<script language="JavaScript" src="'.SHOP_TOSSPAYMENTS_CASHRECEIPT_REAL_JS.'"></script>'.PHP_EOL;
    }
}
?>

<!-- 주문상세내역 시작 { -->
<div id="sod_fin">
    <section id="sod_fin_list">
        <h2 class="visually-hidden">주문하신 상품</h2>

        <?php
        $st_count1 = $st_count2 = 0;
        $custom_cancel = false;

        $sql = " select it_id, it_name, ct_send_cost, it_sc_type
                    from {$g5['g5_shop_cart_table']}
                    where od_id = '$od_id'
                    group by it_id
                    order by ct_id ";
        $result = sql_query($sql);
        ?>
		<ul class="list-group list-group-flush">
			<li class="list-group-item">        
				<div id="sod_fin_no">
					<i class="bi bi-box2-heart"></i>
					주문번호 <strong><?php echo $od_id; ?></strong>
				</div>
			</li>
			<li class="list-group-item line-top bg-body-tertiary">
				<div class="row align-items-md-center gy-1 gx-3 fw-bold">
					<div class="col-12 col-md-6 text-center text-nowrap">상품명</div>
					<div class="d-none d-md-block col-md-1 text-end text-nowrap">총수량</div>
					<div class="d-none d-md-block col-md-1 text-end text-nowrap">판매가</div>
					<div class="d-none d-md-block col-md-1 text-end text-nowrap">포인트</div>
					<div class="d-none d-md-block col-md-1 text-end text-nowrap">배송비</div>
					<div class="d-none d-md-block col-md-1 text-end text-nowrap">소계</div>
					<div class="d-none d-md-block col-md-1 text-end text-nowrap">상태</div>
				</div>
			</li>
			<?php
			for($i=0; $row=sql_fetch_array($result); $i++) {
				$image = get_it_image($row['it_id'], 55, 55);

				$sql = " select ct_id, it_name, ct_option, ct_qty, ct_price, ct_point, ct_status, io_type, io_price
							from {$g5['g5_shop_cart_table']}
							where od_id = '$od_id'
							  and it_id = '{$row['it_id']}'
							order by io_type asc, ct_id asc ";
				$res = sql_query($sql);
				$rowspan = sql_num_rows($res) + 1;

				// 합계금액 계산
				$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
								SUM(ct_qty) as qty
							from {$g5['g5_shop_cart_table']}
							where it_id = '{$row['it_id']}'
							  and od_id = '$od_id' ";
				$sum = sql_fetch($sql);

				// 배송비
				switch($row['ct_send_cost'])
				{
					case 1:
						$ct_send_cost = '착불';
						break;
					case 2:
						$ct_send_cost = '무료';
						break;
					default:
						$ct_send_cost = '선불';
						break;
				}

				// 조건부무료
				if($row['it_sc_type'] == 2) {
					$sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $od_id);

					if($sendcost == 0)
						$ct_send_cost = '무료';
				}

				for($k=0; $opt=sql_fetch_array($res); $k++) {
					if($opt['io_type'])
						$opt_price = $opt['io_price'];
					else
						$opt_price = $opt['ct_price'] + $opt['io_price'];

					$sell_price = $opt_price * $opt['ct_qty'];
					$point = $opt['ct_point'] * $opt['ct_qty'];

					if($k == 0) {
			?>
			<?php } ?>
			<li class="list-group-item">

				<div class="row align-items-md-center gy-1 gx-3">
					<div class="col-12 col-md-6">
						<div class="d-flex gap-2">
							<div>
								<?php echo $image; ?>
							</div>
							<div>
						    	<a href="<?php echo shop_item_url($row['it_id']); ?>">
									<?php echo $row['it_name']; ?>
								</a>
			                	<div class="sod_opt small pt-1">
									<?php echo get_text($opt['ct_option']); ?>
								</div>
							</div>
						</div>					
						<div class="border-top d-block d-md-none mt-2"></div>
					</div>
					<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
						<span class="float-start d-inline-block d-md-none">총수량</span>
						<?php echo number_format($opt['ct_qty']); ?>
					</div>
					<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
						<span class="float-start d-inline-block d-md-none">판매가</span>
						<?php echo number_format($opt_price); ?>
					</div>
					<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
						<span class="float-start d-inline-block d-md-none">포인트</span>
						<?php echo number_format($point); ?>
					</div>
					<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
						<span class="float-start d-inline-block d-md-none">배송비</span>
						<?php echo $ct_send_cost; ?>
					</div>
					<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
						<span class="float-start d-inline-block d-md-none">소계</span>
						<?php echo number_format($sell_price); ?>
					</div>
					<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
						<span class="float-start d-inline-block d-md-none">상태</span>
						<?php echo $opt['ct_status']; ?>
					</div>
				</div>

			</li>		
			<?php
					$tot_point       += $point;

					$st_count1++;
					if($opt['ct_status'] == '주문')
						$st_count2++;
				}
			}

			// 주문 상품의 상태가 모두 주문이면 고객 취소 가능
			if($st_count1 > 0 && $st_count1 == $st_count2)
				$custom_cancel = true;
			?>
			<li class="list-group-item text-end">
				<button type="button" class="btn btn-basic btn-sm" data-bs-toggle="modal" data-bs-target="#stsModal">
					<i class="bi bi-info-circle"></i>
					상품 상태 설명
				</button>
			</li>
		</ul>

		<div class="modal fade" id="stsModal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
						<div id="sod_sts_explan" class="p-3 pb-1">
							<dl id="sod_fin_legend">
								<dt>주문</dt>
								<dd>주문이 접수되었습니다.
								<dt>입금</dt>
								<dd>입금(결제)이 완료 되었습니다.
								<dt>준비</dt>
								<dd>상품 준비 중입니다.
								<dt>배송</dt>
								<dd>상품 배송 중입니다.
								<dt>완료</dt>
								<dd>상품 배송이 완료 되었습니다.
							</dl>
						</div>
						<div class="text-center">
							<button type="button" class="btn btn-basic btn-sm" data-bs-dismiss="modal" title="닫기">
								<i class="bi bi-x-lg"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>

	<div class="row">
		<div class="col-md-6 col-lg-7">
	        <h2 class="visually-hidden">결제/배송 정보</h2>

			<div class="sticky-top pt-4">
				<section id="sod_fin_dvr">
					<h3 class="fs-5 px-3 my-2">
						배송정보
					</h3>
					<ul class="list-group list-group-flush line-top">
						<?php if ($od['od_invoice'] && $od['od_delivery_company']) { ?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-3 fw-bold">
										배송회사
									</div>
									<div class="col-9">
										<?php echo $od['od_delivery_company']; ?> <?php echo get_delivery_inquiry($od['od_delivery_company'], $od['od_invoice'], 'dvr_link'); ?>
									</div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col-3 fw-bold">
										운송장번호
									</div>
									<div class="col-9">
										<?php echo $od['od_invoice']; ?>
									</div>
								</div>
							</li>
							<li class="list-group-item border-bottom">
								<div class="row">
									<div class="col-3 fw-bold">
										배송일시
									</div>
									<div class="col-9">
										<?php echo $od['od_invoice_time']; ?>
									</div>
								</div>
							</li>
						<?php } else { ?>
							<li class="list-group-item">
								<div class="alert alert-light m-0" role="alert">
									아직 배송하지 않았거나 배송정보를 입력하지 못하였습니다.
								</div>							
							</li>
						<?php } ?>
					</ul>
				</section>

				<?php
				// 총계 = 주문상품금액합계 + 배송비 - 상품할인 - 결제할인 - 배송비할인
				$tot_price = $od['od_cart_price'] + $od['od_send_cost'] + $od['od_send_cost2']
								- $od['od_cart_coupon'] - $od['od_coupon'] - $od['od_send_coupon']
								- $od['od_cancel_price'];

				$receipt_price  = $od['od_receipt_price']
								+ $od['od_receipt_point'];
				$cancel_price   = $od['od_cancel_price'];

				$misu = true;
				$misu_price = $tot_price - $receipt_price;

				if ($misu_price == 0 && ($od['od_cart_price'] > $od['od_cancel_price'])) {
					$wanbul = " (완불)";
					$misu = false; // 미수금 없음
				}
				else
				{
					$wanbul = display_price($receipt_price);
				}

				// 결제정보처리
				if($od['od_receipt_price'] > 0)
					$od_receipt_price = display_price($od['od_receipt_price']);
				else
					$od_receipt_price = '아직 입금되지 않았거나 입금정보를 입력하지 못하였습니다.';

				$app_no_subj = '';
				$disp_bank = true;
				$disp_receipt = false;
				if($od['od_settle_case'] == '신용카드' || $od['od_settle_case'] == 'KAKAOPAY' || is_inicis_order_pay($od['od_settle_case']) ) {
					$app_no_subj = '승인번호';
					$app_no = $od['od_app_no'];
					$disp_bank = false;
					$disp_receipt = true;
				} else if($od['od_settle_case'] == '간편결제') {
					$app_no_subj = '승인번호';
					$app_no = $od['od_app_no'];
					$disp_bank = false;
				} else if($od['od_settle_case'] == '휴대폰') {
					$app_no_subj = '휴대폰번호';
					$app_no = $od['od_bank_account'];
					$disp_bank = false;
					$disp_receipt = true;
				} else if($od['od_settle_case'] == '가상계좌' || $od['od_settle_case'] == '계좌이체') {
					$app_no_subj = '거래번호';
					$app_no = $od['od_tno'];

					if( function_exists('shop_is_taxsave') && $misu_price == 0 && shop_is_taxsave($od, true) === 2 ){
						$disp_receipt = true;
					}
				}
				?>
				<section id="sod_frm_orderer" class="pt-4">
					<h3 class="fs-5 px-3 my-2">
						주문하시는 분
					</h3>
					<ul class="list-group list-group-flush line-top border-bottom">
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									이름
								</div>
								<div class="col-9">
									<?php echo get_text($od['od_name']); ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									전화번호
								</div>
								<div class="col-9">
									<?php echo get_text($od['od_tel']); ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									핸드폰
								</div>
								<div class="col-9">
									<?php echo get_text($od['od_hp']); ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									주소
								</div>
								<div class="col-9">
									<?php echo get_text(sprintf("(%s%s)", $od['od_zip1'], $od['od_zip2']).' '.print_address($od['od_addr1'], $od['od_addr2'], $od['od_addr3'], $od['od_addr_jibeon'])); ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									E-mail
								</div>
								<div class="col-9">
									<?php echo get_text($od['od_email']); ?>
								</div>
							</div>
						</li>
					</ul>
				</section>

				<section id="sod_fin_receiver" class="pt-4">
					<h3 class="fs-5 px-3 my-2">
						받으시는 분
					</h3>
					<ul class="list-group list-group-flush line-top border-bottom">
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									이름
								</div>
								<div class="col-9">
									<?php echo get_text($od['od_b_name']); ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									전화번호
								</div>
								<div class="col-9">
									<?php echo get_text($od['od_b_tel']); ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									핸드폰
								</div>
								<div class="col-9">
									<?php echo get_text($od['od_b_hp']); ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									주소
								</div>
								<div class="col-9">
									<?php echo get_text(sprintf("(%s%s)", $od['od_b_zip1'], $od['od_b_zip2']).' '.print_address($od['od_b_addr1'], $od['od_b_addr2'], $od['od_b_addr3'], $od['od_b_addr_jibeon'])); ?>
								</div>
							</div>
						</li>
						<?php
						// 희망배송일을 사용한다면
						if ($default['de_hope_date_use']) {
						?>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									희망배송일
								</div>
								<div class="col-9">
									<?php echo substr($od['od_hope_date'],0,10).' ('.get_yoil($od['od_hope_date']).')' ;?>
								</div>
							</div>
						</li>
						<?php }
						if ($od['od_memo']) {
						?>
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 fw-bold">
									전하실 말씀
								</div>
								<div class="col-9">
									<?php echo conv_content($od['od_memo'], 0); ?>
								</div>
							</div>
						</li>
						<?php } ?>
					</ul>
				</section>
			</div><!-- } .sticky-top 닫기 -->
		</div><!-- } .col 닫기 -->

		<div class="col-md-6 col-lg-5">
			<div class="sticky-top pt-4">
				<section id="sod_bsk_tot2">
					<h3 class="fs-5 px-3 my-2">
						주문정보
					</h3>
					<ul class="list-group list-group-flush line-top border-bottom">
						<li class="list-group-item">
							<div class="row">
								<div class="col-4 fw-bold">
									주문총액
								</div>
								<div class="col-8 text-end">
									<strong><?php echo number_format($od['od_cart_price']); ?>원</strong>
								</div>
							</div>
						</li>

						<?php if($od['od_cart_coupon'] > 0) { ?>
							<li class="list-group-item small">
								<div class="row">
									<div class="col-4">
										개별상품 쿠폰할인
									</div>
									<div class="col-8 text-end">
										<?php echo number_format($od['od_cart_coupon']); ?>원
									</div>
								</div>
							</li>
						<?php } ?>

						<?php if($od['od_coupon'] > 0) { ?>
							<li class="list-group-item small">
								<div class="row">
									<div class="col-4">
										주문금액 쿠폰할인
									</div>
									<div class="col-8 text-end">
										<?php echo number_format($od['od_coupon']); ?>원
									</div>
								</div>
							</li>
						<?php } ?>

						<?php if ($od['od_send_cost'] > 0) { ?>
							<li class="list-group-item small">
								<div class="row">
									<div class="col-4">
										배송비
									</div>
									<div class="col-8 text-end">
										<?php echo number_format($od['od_send_cost']); ?>원
									</div>
								</div>
							</li>
						<?php } ?>

						<?php if($od['od_send_coupon'] > 0) { ?>
							<li class="list-group-item small">
								<div class="row">
									<div class="col-4">
										배송비 쿠폰할인
									</div>
									<div class="col-8 text-end">
										<?php echo number_format($od['od_send_coupon']); ?>원
									</div>
								</div>
							</li>
						<?php } ?>

						<?php if ($od['od_send_cost2'] > 0) { ?>
							<li class="list-group-item small">
								<div class="row">
									<div class="col-4">
										추가배송비
									</div>
									<div class="col-8 text-end">
										<?php echo number_format($od['od_send_cost2']); ?>원
									</div>
								</div>
							</li>
						<?php } ?>

						<?php if ($od['od_cancel_price'] > 0) { ?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										취소금액
									</div>
									<div class="col-8 text-end">
										<?php echo number_format($od['od_cancel_price']); ?>원
									</div>
								</div>
							</li>
						<?php } ?>
						<li class="list-group-item bg-body-tertiary">
							<div class="row">
								<div class="col-4 fw-bold">
									총계
								</div>
									<div class="col-8 text-end">
									<strong><?php echo number_format($tot_price); ?>원</strong>
								</div>
							</div>
						</li>
						<li class="list-group-item small">
							<div class="row">
								<div class="col-4">
									적립포인트
								</div>
									<div class="col-8 text-end">
									<?php echo number_format($tot_point); ?>점
								</div>
							</div>
						</li>
						<li class="list-group-item divider-line bg-body-tertiary">
							<div class="row">
								<div class="col-4 fw-bold">
									총 구매액
								</div>
								<div class="col-8 text-end">
									<strong><?php echo display_price($tot_price); ?></strong>
								</div>
							</div>
						</li>

						<li id="alrdy" class="list-group-item bg-body-tertiary">
							<div class="row">
								<div class="col-4 fw-bold">
									결제액
								</div>
								<div class="col-8 text-end">
									<strong><?php echo $wanbul; ?></strong>
								</div>
							</div>
						</li>
						<?php if( $od['od_receipt_point'] ){    //포인트로 결제한 내용이 있으면 ?>
							<li class="list-group-item small">
								<div class="row gy-1">
									<div class="col-4">
										<span class="ms-3">포인트 결제</span>
									</div>
									<div class="col-8 text-end">
										<?php echo number_format($od['od_receipt_point']); ?>점
									</div>
									<div class="col-4">
										<span class="ms-3">실결제</span>
									</div>
									<div class="col-8 text-end">
										<?php echo number_format($od['od_receipt_price']); ?>원
									</div>
								</div>
							</li>
						<?php } ?>
						<?php if ($misu_price > 0) { ?>
							<li class="list-group-item bg-body-tertiary">
								<div class="row">
									<div class="col-4 fw-bold">
										미결제액
									</div>
									<div class="col-8 text-end">
										<strong><?php echo display_price($misu_price); ?></strong>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
				</section>

				<section id="sod_fin_pay" class="pt-4">
					<h2 class="fs-5 px-3 my-2">
						결제정보
					</h2>
					<ul class="list-group list-group-flush line-top">
						<li class="list-group-item">
							<div class="row">
								<div class="col-4 fw-bold">
									주문번호
								</div>
								<div class="col-8 text-end">
									<?php echo $od_id; ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-4 fw-bold">
									주문일시
								</div>
								<div class="col-8 text-end">
									<?php echo $od['od_time']; ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-4 fw-bold">
									결제방식
								</div>
								<div class="col-8 text-end">
									<?php echo check_pay_name_replace($od['od_settle_case'], $od, 1); ?>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-4 fw-bold">
									결제금액
								</div>
								<div class="col-8 text-end">
									<?php echo $od_receipt_price; ?>
								</div>
							</div>
						</li>
						<?php if($od['od_receipt_price'] > 0) { ?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										결제일시
									</div>
									<div class="col-8 text-end">
										<?php echo $od['od_receipt_time']; ?>
									</div>
								</div>
							</li>
						<?php
						}
			
						// 승인번호, 휴대폰번호, 거래번호
						if($app_no_subj && $app_no) {
						?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										<?php echo $app_no_subj; ?>
									</div>
									<div class="col-8 text-end">
										<?php echo $app_no; ?>
									</div>
								</div>
							</li>
						<?php
						}
			
						// 계좌정보
						if($disp_bank) {
						?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										입금자명
									</div>
									<div class="col-8 text-end">
										<?php echo get_text($od['od_deposit_name']); ?>
									</div>
								</div>
							</li>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										입금계좌
									</div>
									<div class="col-8 text-end">
										<?php echo get_text($od['od_bank_account']); ?>
									</div>
								</div>
							</li>
						<?php
						}
			
						if($disp_receipt) {
						?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										영수증
									</div>
									<div class="col-8 text-end">
										<?php
										if($od['od_settle_case'] == '휴대폰')
										{
											if($od['od_pg'] == 'lg') {
												require_once G5_SHOP_PATH.'/settle_lg.inc.php';
												$LGD_TID      = $od['od_tno'];
												$LGD_MERTKEY  = $config['cf_lg_mert_key'];
												$LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);
					
												$hp_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
											} else if($od['od_pg'] == 'inicis') {
												$hp_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
											} else {
												$hp_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'mcash_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$od['od_receipt_price'].'\', \'winreceipt\', \'width=500,height=690,scrollbars=yes,resizable=yes\');';
											}
										?>
										<a href="javascript:;" onclick="<?php echo $hp_receipt_script; ?>">영수증 출력</a>
										<?php
										}
					
										if($od['od_settle_case'] == '신용카드' || is_inicis_order_pay($od['od_settle_case']) || (shop_is_taxsave($od, true) && $misu_price == 0) )
										{
											if($od['od_pg'] == 'lg') {
												require_once G5_SHOP_PATH.'/settle_lg.inc.php';
												$LGD_TID      = $od['od_tno'];
												$LGD_MERTKEY  = $config['cf_lg_mert_key'];
												$LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);
					
												$card_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
											} else if($od['od_pg'] == 'inicis') {
												$card_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
											} else {
												$card_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'card_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$od['od_receipt_price'].'\', \'winreceipt\', \'width=470,height=815,scrollbars=yes,resizable=yes\');';
											}
										?>
										<a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>">영수증 출력</a>
										<?php
										}
					
										if($od['od_settle_case'] == 'KAKAOPAY')
										{
											//$card_receipt_script = 'window.open(\'https://mms.cnspay.co.kr/trans/retrieveIssueLoader.do?TID='.$od['od_tno'].'&type=0\', \'popupIssue\', \'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=420,height=540\');';
											$card_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
										?>
										<a href="javascript:;" onclick="<?php echo $card_receipt_script; ?>">영수증 출력</a>
										<?php
										}
										?>

									</div>
								</div>
							</li>
						<?php
						}
			
						if ($od['od_receipt_point'] > 0) {
						?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										포인트사용
									</div>
									<div class="col-8 text-end">
										<?php echo display_point($od['od_receipt_point']); ?>
									</div>
								</div>
							</li>
						<?php
						}
			
						if ($od['od_refund_price'] > 0) {
						?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										환불 금액
									</div>
									<div class="col-8 text-end">
										<?php echo display_price($od['od_refund_price']); ?>
									</div>
								</div>
							</li>
						<?php
						}
			
						// 현금영수증 발급을 사용하는 경우에만
						if (function_exists('shop_is_taxsave') && shop_is_taxsave($od)) {
							// 미수금이 없고 현금일 경우에만 현금영수증을 발급 할 수 있습니다.
							if ($misu_price == 0 && $od['od_receipt_price'] && ($od['od_settle_case'] == '무통장' || $od['od_settle_case'] == '계좌이체' || $od['od_settle_case'] == '가상계좌')) {
						?>
							<li class="list-group-item">
								<div class="row">
									<div class="col-4 fw-bold">
										현금영수증
									</div>
									<div class="col-8 text-end">
										<?php
										if ($od['od_cash'])
										{
											if($od['od_pg'] == 'lg') {
												require_once G5_SHOP_PATH.'/settle_lg.inc.php';
						
												switch($od['od_settle_case']) {
													case '계좌이체':
														$trade_type = 'BANK';
														break;
													case '가상계좌':
														$trade_type = 'CAS';
														break;
													default:
														$trade_type = 'CR';
														break;
												}
												$cash_receipt_script = 'javascript:showCashReceipts(\''.$LGD_MID.'\',\''.$od['od_id'].'\',\''.$od['od_casseqno'].'\',\''.$trade_type.'\',\''.$CST_PLATFORM.'\');';
											} else if($od['od_pg'] == 'inicis') {
												$cash = unserialize($od['od_cash_info']);
												$cash_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid='.$cash['TID'].'&clpaymethod=22\',\'showreceipt\',\'width=380,height=540,scrollbars=no,resizable=no\');';
											} else {
												require_once G5_SHOP_PATH.'/settle_kcp.inc.php';
						
												$cash = unserialize($od['od_cash_info']);
												$cash_receipt_script = 'window.open(\''.G5_CASH_RECEIPT_URL.$default['de_kcp_mid'].'&orderid='.$od_id.'&bill_yn=Y&authno='.$cash['receipt_no'].'\', \'taxsave_receipt\', \'width=360,height=647,scrollbars=0,menus=0\');';
											}
										?>
											<a href="javascript:;" onclick="<?php echo $cash_receipt_script; ?>" class="btn_frmline">현금영수증 확인하기</a>
										<?php
										}
										else
										{
										?>
											<a href="javascript:;" onclick="window.open('<?php echo G5_SHOP_URL; ?>/taxsave.php?od_id=<?php echo $od_id; ?>', 'taxsave', 'width=550,height=400,scrollbars=1,menus=0');" class="btn_frmline is-long-text">현금영수증을 발급하시려면 클릭하십시오.</a>
										<?php } ?>
									</div>
								</div>
							</li>
						<?php
							}
						}

						// 취소한 내역이 없다면
						if ($cancel_price == 0) {
							if ($custom_cancel) {
						?>
							<li class="list-group-item">
								<form method="post" action="./orderinquirycancel.php" onsubmit="return fcancel_check(this);">
									<input type="hidden" name="od_id" value="<?php echo $od['od_id']; ?>">
									<input type="hidden" name="token" value="<?php echo $token; ?>">

									<div class="input-group">
										<div class="form-floating">
											<input type="text" name="cancel_memo" id="cancel_memo" required class="form-control required" maxlength="100" placeholder="주문취소사유">
											<label for="cancel_memo">주문취소사유</label>
										</div>
										<input type="submit" value="주문취소" class="btn btn-basic">
									</div>
								</form>
							</li>
						<?php
							}
						} else {
						?>
							<li class="list-group-item">
								<div class="alert alert-light mb-0" role="alert">
									주문 취소, 반품, 품절된 내역이 있습니다.
								</div>
							</li>
						<?php } ?>
					</ul>
				</section>

			</div><!-- } .sticky-top 닫기 -->
		</div><!-- } .col 닫기 -->
	</div><!-- } .row 닫기 -->

    <?php if ($od['od_settle_case'] == '가상계좌' && $od['od_misu'] > 0 && $default['de_card_test'] && $is_admin && $od['od_pg'] == 'kcp') {
    preg_match("/\s{1}([^\s]+)\s?/", $od['od_bank_account'], $matchs);
    $deposit_no = trim($matchs[1]);
    ?>
    <p>관리자가 가상계좌 테스트를 한 경우에만 보입니다.</p>
    <div class="tbl_frm01 tbl_wrap">
        <form method="post" action="http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti_Proc.jsp" target="_blank">
        <table>
        <caption>모의입금처리</caption>
        <colgroup>
            <col class="grid_3">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="col"><label for="e_trade_no">KCP 거래번호</label></th>
            <td><input type="text" name="e_trade_no" value="<?php echo $od['od_tno']; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="deposit_no">입금계좌</label></th>
            <td><input type="text" name="deposit_no" value="<?php echo $deposit_no; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="req_name">입금자명</label></th>
            <td><input type="text" name="req_name" value="<?php echo $od['od_deposit_name']; ?>"></td>
        </tr>
        <tr>
            <th scope="col"><label for="noti_url">입금통보 URL</label></th>
            <td><input type="text" name="noti_url" value="<?php echo G5_SHOP_URL; ?>/settle_kcp_common.php"></td>
        </tr>
        </tbody>
        </table>
        <div id="sod_fin_test" class="btn_confirm">
            <input type="submit" value="입금통보 테스트" class="btn_submit">
        </div>
        </form>
    </div>
    <?php } ?>

</div>
<!-- } 주문상세내역 끝 -->

<script>
$(function() {
    $("#sod_sts_explan_open").on("click", function() {
        var $explan = $("#sod_sts_explan");
        if($explan.is(":animated"))
            return false;

        if($explan.is(":visible")) {
            $explan.slideUp(200);
            $("#sod_sts_explan_open").text("상태설명보기");
        } else {
            $explan.slideDown(200);
            $("#sod_sts_explan_open").text("상태설명닫기");
        }
    });

    $("#sod_sts_explan_close").on("click", function() {
        var $explan = $("#sod_sts_explan");
        if($explan.is(":animated"))
            return false;

        $explan.slideUp(200);
        $("#sod_sts_explan_open").text("상태설명보기");
    });
});

function fcancel_check(f)
{
    if(!confirm("주문을 정말 취소하시겠습니까?"))
        return false;

    var memo = f.cancel_memo.value;
    if(memo == "") {
        alert("취소사유를 입력해 주십시오.");
        return false;
    }

    return true;
}		
</script>

<?php
include_once('./_tail.php');