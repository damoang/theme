<?php
include_once('./_common.php');

$it_id = isset($_POST['it_id']) ? get_search_string(trim($_POST['it_id'])) : '';

$pattern = '#[/\'\"%=*\#\(\)\|\+\&\!\$~\{\}\[\]`;:\?\^\,]#';
$it_id  = $it_id ? preg_replace($pattern, '', $it_id) : '';

$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' and it_use = '1' ";
$it = sql_fetch($sql);
$it_point = get_item_point($it);

if(!isset($it['it_id']) || !$it['it_id'])
	die(json_encode(array('error' => '상품정보가 존재하지 않습니다.')));

// 장바구니 자료
$cart_id = get_session('ss_cart_id');
$sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$cart_id' and it_id = '$it_id' order by io_type asc, ct_id asc ";
$result = sql_query($sql);

// 판매가격
$sql2 = " select ct_price, it_name, ct_send_cost from {$g5['g5_shop_cart_table']} where od_id = '$cart_id' and it_id = '$it_id' order by ct_id asc limit 1 ";
$row2 = sql_fetch($sql2);

if(!sql_num_rows($result))
	die(json_encode(array('error' => '장바구니에 상품이 존재하지 않습니다.')));

if(defined('G5_THEME_USE_OPTIONS_TRTD') && G5_THEME_USE_OPTIONS_TRTD){
	$option_item = get_item_options($it['it_id'], $it['it_option_subject'], '');
	$supply_item = get_item_supply($it['it_id'], $it['it_supply_subject'], '');
} else {
	// 선택 옵션 ( 기존의 tr td 태그로 가져오려면 'div' 를 '' 로 바꾸거나 또는 지워주세요 )
	$option_item = get_item_options($it['it_id'], $it['it_option_subject'], 'div', 1);

	// 추가 옵션 ( 기존의 tr td 태그로 가져오려면 'div' 를 '' 로 바꾸거나 또는 지워주세요 )
	$supply_item = get_item_supply($it['it_id'], $it['it_supply_subject'], 'div', 1);
}

ob_start();
?>

<input type="hidden" name="act" value="optionmod">
<input type="hidden" name="it_id[]" value="<?php echo $it['it_id']; ?>">
<input type="hidden" id="item_price" value="<?php echo $row2['ct_price']; ?>">
<input type="hidden" name="ct_send_cost" value="<?php echo $row2['ct_send_cost']; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" id="it_min_qty" value="<?php echo (int)$it['it_buy_min_qty'] ?>">
<input type="hidden" id="it_max_qty" value="<?php echo (int)$it['it_buy_max_qty'] ?>">

<ul class="list-group list-group-flush">
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
		<ul id="cart_opt_added" class="list-group list-group-flush border-bottom">
        <?php
        for($i=0; $row=sql_fetch_array($result); $i++) {
            if(!$row['io_id'])
                $it_stock_qty = get_it_stock_qty($row['it_id']);
            else
                $it_stock_qty = get_option_stock_qty($row['it_id'], $row['io_id'], $row['io_type']);

            if($row['io_price'] < 0)
                $io_price = '('.number_format($row['io_price']).'원)';
            else
                $io_price = '(+'.number_format($row['io_price']).'원)';

            $cls = 'opt';
            if($row['io_type'])
                $cls = 'spl';
        ?>
		<li class="list-group-item cart_<?php echo $cls ?>_list">
            <input type="hidden" name="io_type[<?php echo $it['it_id'] ?>][]" value="<?php echo $row['io_type'] ?>">
            <input type="hidden" name="io_id[<?php echo $it['it_id'] ?>][]" value="<?php echo $row['io_id'] ?>">
            <input type="hidden" name="io_value[<?php echo $it['it_id'] ?>][]" value="<?php echo $row['ct_option'] ?>">
            <input type="hidden" class="io_price" value="<?php echo $row['io_price'] ?>">
            <input type="hidden" class="io_stock" value="<?php echo $it_stock_qty ?>">
            <div class="opt_name mb-1">
                <span class="sit_opt_subj"><?php echo $row['ct_option'] ?></span>
            </div>
			<label for="ct_qty_<?php echo $i ?>" class="visually-hidden">수량</label>
			<div class="input-group opt_count">
				<input type="text" name="ct_qty[<?php echo $it['it_id'] ?>][]" value="<?php echo $row['ct_qty'] ?>" id="ct_qty_<?php echo $i ?>" class="form-control">
				<button type="button" class="cart_qty_plus btn btn-basic" title="증가" value="1">
					<i class="bi bi-plus-lg"></i>
					<span class="visually-hidden">증가</span>
				</button>
				<button type="button" class="cart_qty_minus btn btn-basic" title="감소" value="2">
					<i class="bi bi-dash-lg"></i>
					<span class="visually-hidden">감소</span>
				</button>
				<button type="button" class="btn btn-basic cart_opt_del" title="삭제" value="3">
					<i class="bi bi-x-lg"></i>
					<span class="visually-hidden">삭제</span>
				</button>
			</div>
        </li>
        <?php } ?>
		</ul>
	</li>
	<li class="list-group-item text-end fs-5 bg-body-tertiary">
		<div id="cart_tot_price"></div>
	</li>
	<li class="list-group-item px-0">
		<div class="d-flex gap-2">
			<div class="flex-grow-1">
				<button type="submit" class="btn btn-primary btn-lg w-100">
					<i class="bi bi-cart-check"></i>
					확인
				</button>
			</div>
			<div>
				<button type="button" class="btn btn-basic btn-lg" data-bs-dismiss="modal" aria-label="Close" title="닫기">
					<i class="bi bi-x-lg"></i>
					<span class="visually-hidden">닫기</span>
				</button>
			</div>
		</div>
	</li>
</ul>
<?php
$content = ob_get_contents();
ob_end_clean();

$result = array(
	'error'  => '',
	'html'   => $content
);

die(json_encode($result));