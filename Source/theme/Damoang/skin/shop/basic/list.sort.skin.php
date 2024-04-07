<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';

if($ca_id) {
	$shop_category_url = shop_category_url($ca_id);
    $sct_sort_href = (strpos($shop_category_url, '?') === false) ? $shop_category_url.'?1=1' : $shop_category_url;
} else if($ev_id) {
    $sct_sort_href .= 'ev_id='.$ev_id;
}

if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;

$sct_sort_href .= '&amp;sort=';
?>
<section id="sct_sort">
	<form>
	<h2 class="visually-hidden">상품 정렬</h2>
	<div class="d-flex px-3 px-sm-0 gap-2 mb-3">
		<div>
			<select id="ssch_sort" class="form-select" name="itsort" onchange="location.href='<?php echo $sct_sort_href ?>'+this.value;">
				<option value="it_sum_qty&amp;sortodr=desc"<?php echo ($sort == 'it_sum_qty') ? ' selected' : ''; ?>>판매많은순</option>
				<option value="it_price&amp;sortodr=asc"<?php echo ($sort == 'it_price' && $sortodr == 'asc') ? ' selected' : ''; ?>>낮은가격순</option>
				<option value="it_price&amp;sortodr=desc"<?php echo ($sort == 'it_price' && $sortodr == 'desc') ? ' selected' : ''; ?>>높은가격순</option>
				<option value="it_use_avg&amp;sortodr=desc"<?php echo ($sort == 'it_use_avg') ? ' selected' : ''; ?>>평점높은순</option>
				<option value="it_use_cnt&amp;sortodr=desc"<?php echo ($sort == 'it_use_cnt') ? ' selected' : ''; ?>>후기많은순</option>
				<option value="it_update_time&amp;sortodr=desc"<?php echo ($sort == 'it_update_time') ? ' selected' : ''; ?>>최근등록순</option>
			</select>
		</div>
		<?php if(!isset($ev_id) || !$ev_id) { ?>
			<div class="ms-auto">
				<select id="ssch_type" class="form-select" name="ittype" onchange="location.href='<?php echo $sct_sort_href ?>'+this.value;">
					<option value="it_name&amp;sortodr=asc"<?php echo ($sort == 'it_name') ? ' selected' : ''; ?>>상품명순</option>
					<option value="it_type1&amp;sortodr=desc"<?php echo ($sort == 'it_type1') ? ' selected' : ''; ?>>히트상품</option>
					<option value="it_type2&amp;sortodr=desc"<?php echo ($sort == 'it_type2') ? ' selected' : ''; ?>>추천상품</option>
					<option value="it_type3&amp;sortodr=desc"<?php echo ($sort == 'it_type3') ? ' selected' : ''; ?>>최신상품</option>
					<option value="it_type4&amp;sortodr=desc"<?php echo ($sort == 'it_type4') ? ' selected' : ''; ?>>인기상품</option>
					<option value="it_type5&amp;sortodr=desc"<?php echo ($sort == 'it_type5') ? ' selected' : ''; ?>>할인상품</option>
				</select>
			</div>
		<?php } ?>
	</div>
	</form>
</section>
