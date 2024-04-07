<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$g5['title'] = '장바구니';
include_once(G5_SHOP_PATH.'/_head.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

?>

<div id="sod_bsk" class="od_prd_list">

    <form name="frmcartlist" id="sod_bsk_list" class="2017_renewal_itemform" method="post" action="<?php echo $cart_action_url ?>">
	<ul class="list-group list-group-flush">
		<li class="list-group-item line-bottom">
			<div class="d-flex align-items-md-center gap-2 fw-bold">
				<div>
					<div class="form-check mb-0">
						<input class="form-check-input" type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked">
						<label class="form-check-label visually-hidden" for="ct_all">전체 상품 선택</label>
					</div>
				</div>
				<div class="flex-grow-1">
					<div class="row align-items-md-center gy-1 gx-3">
						<div class="col-12 col-md-7 text-center text-nowrap">상품명</div>
						<div class="d-none d-md-block col-md-1 text-end text-nowrap">총수량</div>
						<div class="d-none d-md-block col-md-1 text-end text-nowrap">판매가</div>
						<div class="d-none d-md-block col-md-1 text-end text-nowrap">포인트</div>
						<div class="d-none d-md-block col-md-1 text-end text-nowrap">배송비</div>
						<div class="d-none d-md-block col-md-1 text-end text-nowrap">소계</div>
					</div>
				</div>
			</div>
		</li>
		<?php
		$tot_point = 0;
		$tot_sell_price = 0;
		$send_cost = 0;

		// $s_cart_id 로 현재 장바구니 자료 쿼리
		$sql = " select a.ct_id,
						a.it_id,
						a.it_name,
						a.ct_price,
						a.ct_point,
						a.ct_qty,
						a.ct_status,
						a.ct_send_cost,
						a.it_sc_type,
						b.ca_id,
						b.ca_id2,
						b.ca_id3
				   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
				  where a.od_id = '$s_cart_id' ";
		$sql .= " group by a.it_id ";
		$sql .= " order by a.ct_id ";
		$result = sql_query($sql);

		$it_send_cost = 0;

		for ($i=0; $row=sql_fetch_array($result); $i++) {
			// 합계금액 계산
			$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
							SUM(ct_point * ct_qty) as point,
							SUM(ct_qty) as qty
						from {$g5['g5_shop_cart_table']}
						where it_id = '{$row['it_id']}'
						  and od_id = '$s_cart_id' ";
			$sum = sql_fetch($sql);

			if ($i==0) { // 계속쇼핑
				$continue_ca_id = $row['ca_id'];
			}

			$a1 = '<a href="'.shop_item_url($row['it_id']).'"><b>';
			$a2 = '</b></a>';
			$image = get_it_image($row['it_id'], 84, 84);

			$it_name = $a1 . stripslashes($row['it_name']) . $a2;
			$it_options = print_item_options($row['it_id'], $s_cart_id);
			if($it_options) {
				$mod_options = '<div class="sod_option_btn pt-1"><button type="button" class="btn btn-basic btn-sm" onclick="na_cartOption(\''.$row['it_id'].'\');"><i class="bi bi-check2-square"></i> 선택사항수정</button></div>';
				$it_name .= '<div class="sod_opt small pt-1">'.$it_options.'</div>';
			}

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
				$sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

				if($sendcost == 0)
					$ct_send_cost = '무료';
			}

			$point      = $sum['point'];
			$sell_price = $sum['price'];
		?>
		<li class="list-group-item">
			<div class="d-flex align-items-md-center gap-2">
				<div>
					<div class="form-check mb-0">
						<input class="form-check-input" type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
						<label class="form-check-label visually-hidden" for="ct_chk_<?php echo $i; ?>">상품</label>
					</div>
				</div>
				<div class="flex-grow-1">
					<div class="row align-items-md-center gy-1 gx-3">
						<div class="col-12 col-md-7">
							<div class="d-flex gap-2">
								<div>
									<a href="<?php echo shop_item_url($row['it_id']); ?>"><?php echo $image ?></a>
								</div>
								<div>
									<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
									<input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($row['it_name']); ?>">
									<?php echo $it_name.$mod_options ?>
								</div>
							</div>					
							<div class="border-top d-block d-md-none mt-2"></div>
						</div>
						<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
							<span class="float-start d-inline-block d-md-none">총수량</span>
							<?php echo number_format($sum['qty']) ?>
						</div>
						<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
							<span class="float-start d-inline-block d-md-none">판매가</span>
							<?php echo number_format($row['ct_price']) ?>
						</div>
						<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
							<span class="float-start d-inline-block d-md-none">포인트</span>
							<?php echo number_format($point) ?>
						</div>
						<div class="col-6 col-md-1 text-end text-nowrap clearfix small">
							<span class="float-start d-inline-block d-md-none">배송비</span>
							<?php echo $ct_send_cost ?>
						</div>
						<div class="col-12 col-md-1 text-end text-nowrap clearfix small">
							<div class="border-top d-block d-md-none mb-2"></div>
							<span class="float-start d-inline-block d-md-none">소계</span>
							<span id="sell_price_<?php echo $i ?>" class="fw-bold"><?php echo number_format($sell_price); ?></span>
						</div>
					</div>
				</div>
			</div>
		</li>
		<?php
			$tot_point      += $point;
			$tot_sell_price += $sell_price;
		} // for 끝

		if ($i == 0) {
			echo '<li class="list-group-item text-center py-5">상품이 없습니다.</li>';
		} else {
			// 배송비 계산
			$send_cost = get_sendcost($s_cart_id, 0);
		}

		$tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비

		if ($tot_price > 0 || $send_cost > 0) {
		?>
			<li class="list-group-item bg-body-tertiary">
				<div class="d-flex justify-content-center gap-3">
					<div>
						<span class="text-nowrap">배송비</span>
						<span class="text-nowrap"><strong><?php echo number_format($send_cost); ?></strong> 원</span>
					</div>
					<div>
						<span class="text-nowrap">포인트</span>
						<span class="text-nowrap"><strong><?php echo number_format($tot_point); ?></strong> 점</span>
					</div>
					<div>
						<span class="text-nowrap">총계 가격</span>
						<span class="text-nowrap"><strong><?php echo number_format($tot_price); ?></strong> 원</span> 
					</div>
				</div>
			</li>
	    <?php } ?>
		<li class="list-group-item">
			<div class="row justify-content-center g-2 mb-3">
				<?php if ($i == 0) { ?>
					<div class="col-12 col-sm-3">
						<a href="<?php echo G5_SHOP_URL; ?>/" class="btn btn-basic w-100">쇼핑하기</a>
					</div>
				<?php } else { ?>
					<div class="col-6 col-sm-3">
						<button type="button" class="btn btn-basic w-100" onclick="return form_check('seldelete');">선택삭제</button>
					</div>
					<div class="col-6 col-sm-3">
						<button type="button" class="btn btn-basic w-100" onclick="return form_check('alldelete');">비우기</button>
					</div>
					<div class="col-6 col-sm-3">
						<input type="hidden" name="url" value="./orderform.php">
						<input type="hidden" name="records" value="<?php echo $i; ?>">
						<input type="hidden" name="act" value="">
						<a href="<?php echo shop_category_url($continue_ca_id); ?>" class="btn btn-basic w-100">쇼핑하기</a>
					</div>
					<div class="col-6 col-sm-3">
						<button type="button" onclick="return form_check('buy');" class="btn btn-primary w-100">주문하기</button>
					</div>
				<?php } ?>
			</div>
			<?php if ($i != 0 && $naverpay_button_js) { ?>
		        <div class="cart-naverpay"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
	        <?php } ?>
		</li>
	</ul>
    </form>
</div>

<div class="modal fade" id="cartOptionModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<?php $action_url = (G5_HTTPS_DOMAIN) ? G5_HTTPS_DOMAIN.'/'.G5_SHOP_DIR.'/cartupdate.php' : G5_SHOP_URL.'/cartupdate.php'; ?>
				<form id="fcartOptionForm" name="fcartOptionForm" method="post" action="<?php echo $action_url ?>" onsubmit="return fcartOption_submit(this);">
					<div id="cartOptionModalContent"></div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
var cartOptionModal = new bootstrap.Modal(document.getElementById('cartOptionModal'));

// 장바구니
function na_cartOption(it_id) {
	$.ajax({
		url: g5_theme_shop_url + "/cartoption.php",
		type: "POST",
		data: { "it_id" : it_id },
		dataType: "json",
		async: true,
		cache: false,
		success: function(data, textStatus) {
			if(data.error) {
				na_alert(data.error);
				return false;
			} else {
				$("#cartOptionModalContent").html(data.html);
				
				cart_price_calculate();

				cartOptionModal.show();
			}
		},
		error : function(request, status, error){
			let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
			na_alert(msg);
		}
	});

	return false;
}

function fcartOption_check(f) {

    if($(".cart_opt_list").length < 1) {
		na_alert('상품의 선택옵션을 선택해 주십시오.');
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(document.getElementById("item_min_qty").value);
    var max_qty = parseInt(document.getElementById("item_max_qty").value);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
			na_alert('수량을 입력해 주십시오.');
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
			na_alert('수량은 숫자로 입력해 주십시오.');
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
			na_alert('수량은 1이상 입력해 주십시오.');
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
		na_alert('선택옵션 개수 총합 '+number_format(String(min_qty))+'개 이상 주문해 주십시오.');
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
		na_alert('선택옵션 개수 총합 '+number_format(String(max_qty))+'개 이하로 주문해 주십시오.');
        return false;
    }

	f.action.value = 'cart_update';

	$.ajax({
		url: g5_shop_url + '/ajax.action.php',
		type: "POST",
		data: $("#fcartOptionForm").serialize(),
		dataType: "json",
		async: true,
		cache: false,
		success: function(data, textStatus) {
			if(data.error) {
				na_alert(data.error);
				return false;
			} else {
				na_alert('상품옵션을 수정하였습니다.');
				location.reload(true);
			}
		},
		error : function(request, status, error){
			let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
			na_alert(msg);
		}
	});

	return false;
}

// 바로구매, 장바구니 폼 전송
function fcartOption_submit(f) {

	f.action = "<?php echo $action_url ?>";
    f.target = "";

	var pressed = document.pressed;
	if(fcartOption_check(f)) {
		return true;
	}

	return false;
}

function fsubmit_check(f) {
    if($("input[name^=ct_chk]:checked").length < 1) {
		na_alert('구매하실 상품을 하나이상 선택해 주십시오.');
        return false;
    }

    return true;
}

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if (act == "buy") {
        if($("input[name^=ct_chk]:checked").length < 1) {
			na_alert('주문하실 상품을 하나이상 선택해 주십시오.');
            return false;
        }

        f.act.value = act;
        f.submit();
    } else if (act == "alldelete") {
        f.act.value = act;
        f.submit();
    } else if (act == "seldelete") {
        if($("input[name^=ct_chk]:checked").length < 1) {
			na_alert('삭제하실 상품을 하나이상 선택해 주십시오.');
            return false;
        }

        f.act.value = act;
        f.submit();
    }

    return true;
}

$(function() {

	// 모두선택
    $("input[name=ct_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=ct_chk]").attr("checked", true);
        else
            $("input[name^=ct_chk]").attr("checked", false);
    });

});

</script>

<?php
include_once(G5_SHOP_PATH.'/_tail.php');