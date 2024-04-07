<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$breadcrumb = '';
if (isset($ca_id) && $ca_id) {
    $len = strlen($ca_id) / 2;
    for ($i=1; $i<=$len; $i++) {

		$code = substr($ca_id, 0, $i*2);

        $row = sql_fetch(" select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$code' ");

		$href_category = shop_category_url($code);

		$breadcrumb .= '<li class="breadcrumb-item';
		if ($ca_id == $code) {
	        $breadcrumb .= ' active" aria-current="page';
			$item_list_href = $href_category;
		}
		$breadcrumb .= '"><a href="'.$href_category.'">'.$row['ca_name'].'</a></li>'.PHP_EOL;
    }
} else {
	$breadcrumb = '<li class="breadcrumb-item active" aria-current="page">'.$g5['title'].'</li>';
}

?>
<nav id="sct_location" aria-label="breadcrumb" class="px-3 px-sm-0 pb-3 mb-0">
	<ol class="breadcrumb mb-0">
		<li class="breadcrumb-item">
			<a href="<?php echo G5_SHOP_URL; ?>">
				<i class="bi bi-shop"></i>
				<span class="visually-hidden">Home</span>
			</a>
		</li>
	    <?php echo $breadcrumb ?>
	</ol>
</nav>
