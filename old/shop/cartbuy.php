<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<input type="hidden" name="it_id[]" value="<?php echo $it_id ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">
<input type="hidden" name="action">
<input type="hidden" id="item_min_qty" value="<?php echo (int)$it['it_buy_min_qty'] ?>">
<input type="hidden" id="item_max_qty" value="<?php echo (int)$it['it_buy_max_qty'] ?>">

<h3 class="fs-5 px-3 my-2">
	<a href="<?php echo $it_href ?>">
		<?php echo stripslashes($it['it_name']); ?>
	</a>
</h3>
<ul class="list-group list-group-flush line-top mb-4">
	<li class="list-group-item">
		<div class="row g-2 align-items-center">
			<label class="col-4 col-form-label">가격</label>
			<div class="col-8 text-end">
				<strong><?php echo display_price(get_price($it)); ?></strong>
				<input type="hidden" id="item_price" value="<?php echo get_price($it); ?>">
			</div>
		</div>
	</li>
	<?php if ($config['cf_use_point']) { // 포인트 사용한다면 ?>
	<li class="list-group-item">
		<div class="row g-2 align-items-center">
			<label class="col-4 col-form-label">포인트</label>
			<div class="col-8 text-end">
				<?php 
					$it_supply_point = ($it['it_supply_subject']) ? '(추가옵션 제외)' : '';
					echo ($it['it_point_type'] == 2) ? '구매금액'.$it_supply_point.'의 '.$it['it_point'].'%' : number_format(get_item_point($it)).'점'; 
				?>
			</div>
		</div>
	</li>
	<?php } ?>
	<li class="list-group-item">
		<div class="row g-2 align-items-center">
			<label for="cart_send_cost" class="col-4 col-form-label">배송비</label>
			<div class="col-8 text-end">
				<?php
					if($it['it_sc_type'] == 1) {
						$sc_method = '무료배송';
					} else {
						if($it['it_sc_method'] == 1) {
							$sc_method = '수령후 지불';
						} else if($it['it_sc_method'] == 2) {
							$sc_method = '<select name="ct_send_cost" id="cart_send_cost" class="form-select">
											  <option value="0">주문시 결제</option>
											  <option value="1">수령후 지불</option>
										  </select>';
						} else {
							$sc_method = '주문시 결제';
						}
					}
					
					echo $sc_method;
				?>
			</div>
		</div>
	</li>
	<?php if($it['it_buy_min_qty']) { ?>
	<li class="list-group-item">
		<div class="row g-2 align-items-center">
			<label class="col-4 col-form-label">최소구매수량</label>
			<div class="col-8 text-end">
				<?php echo number_format($it['it_buy_min_qty']); ?> 개
			</div>
		</div>
	</li>
	<?php } ?>
	<?php if($it['it_buy_max_qty']) { ?>
	<li class="list-group-item">
		<div class="row g-2 align-items-center">
			<label class="col-4 col-form-label">최대구매수량</label>
			<div class="col-8 text-end">
				<?php echo number_format($it['it_buy_max_qty']); ?> 개
			</div>
		</div>
	</li>
	<?php } ?>
	<?php if($option_item) { ?>
	<li class="list-group-item pb-1">
		<h4 class="form-text">선택옵션</h4>
		<?php 
			// 선택옵션
			$option_item = str_replace('it_', 'item_', $option_item);
			$option_item = str_replace('get_item_options', 'get_item_options row g-2 align-items-center mb-2', $option_item);
			$option_item = str_replace('class="label-title"', '', $option_item);
			$option_item = str_replace('for="', 'class="col-4 col-form-label" for="', $option_item);
			$option_item = str_replace('<span>', '<div class="col-8 text-end td_sitem_sel">', $option_item);
			$option_item = str_replace('</span>', '</div"></div>', $option_item);
			$option_item = str_replace('class="item_option"', 'class="form-select item_option"', $option_item);
			echo $option_item;
		?>
	</li>
	<?php } ?>
	<?php if($supply_item) { ?>
	<li class="list-group-item pb-1">
		<h4 class="form-text">추가옵션</h4>
		<?php 
			// 선택옵션
			$supply_item = str_replace('it_', 'item_', $supply_item);
			$supply_item = str_replace('get_item_supply', 'get_item_supply row g-2 align-items-center mb-2', $supply_item);
			$supply_item = str_replace('class="label-title"', '', $supply_item);
			$supply_item = str_replace('for="', 'class="col-4 col-form-label" for="', $supply_item);
			$supply_item = str_replace('<span class="td_sitem_sel">', '<div class="col-8 text-end td_sitem_sel">', $supply_item);
			$supply_item = str_replace('</span>', '</div"></div>', $supply_item);
			$supply_item = str_replace('class="item_supply"', 'class="form-select item_supply"', $supply_item);
			echo $supply_item;
		?>
	</li>
	<?php } ?>
	<li id="cart_sel_option" style="list-style:none;">
		<?php 
		if(!$option_item) {
			if(!$it['it_buy_min_qty'])
				$it['it_buy_min_qty'] = 1;
		?>
		<ul id="cart_opt_added" class="list-group list-group-flush border-bottom">
			<li class="list-group-item cart_opt_list">
				<input type="hidden" name="io_type[<?php echo $it_id ?>][]" value="0">
				<input type="hidden" name="io_id[<?php echo $it_id ?>][]" value="">
				<input type="hidden" name="io_value[<?php echo $it_id ?>][]" value="<?php echo $it['it_name'] ?>">
				<input type="hidden" class="io_price" value="0">
				<input type="hidden" class="io_stock" value="<?php echo $it['it_stock_qty'] ?>">
				<div class="opt_name mb-1">
					<span class="cart_opt_subj"><?php echo $it['it_name'] ?></span>
					<span class="cart_opt_prc">+0원</span>
				</div>
				<label for="ct_qty_<?php echo $i ?>" class="visually-hidden">수량</label>
				<div class="input-group opt_count">
					<input type="text" name="ct_qty[<?php echo $it_id ?>][]" value="<?php echo $it['it_buy_min_qty'] ?>" id="ct_qty_<?php echo $i ?>" class="form-control">
					<button type="button" class="cart_qty_plus btn btn-basic" title="증가" value="1">
						<i class="bi bi-plus-lg"></i>
						<span class="visually-hidden">증가</span>
					</button>
					<button type="button" class="cart_qty_minus btn btn-basic" title="감소" value="2">
						<i class="bi bi-dash-lg"></i>
						<span class="visually-hidden">감소</span>
					</button>
				</div>
			</li>
		</ul>
		<?php } ?>
	</li>
	<li class="list-group-item text-end fs-5 bg-body-tertiary">
		<div id="cart_tot_price"></div>
	</li>
	<li class="list-group-item">
		<div class="row g-2">
			<div class="col">
				<button type="submit" onclick="document.pressed=this.value;" value="1" class="cart_btn_cart btn btn-basic btn-lg w-100">
					<i class="bi bi-basket"></i>
					장바구니
				</button>
			</div>
			<div class="col">
				<button type="submit" onclick="document.pressed=this.value;" value="0" class="cart_btn_buy btn btn-primary btn-lg w-100">
					<i class="bi bi-bag-check"></i>
					바로구매
				</button>
			</div>
		</div>
	</li>
	<li class="list-group-item">
		<a href="<?php echo G5_SHOP_URL ?>/cart.php" class="small">
			<i class="bi bi-check2-square"></i>
			장바구니에 담긴 상품 확인
		</a>
	</li>
</ul>	            
