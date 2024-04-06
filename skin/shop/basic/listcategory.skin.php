<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$str = '';
$exists = false;

$ca_id_len = strlen($ca_id);
$len2 = $ca_id_len + 2;
$len4 = $ca_id_len + 4;

// 최하위 분류의 경우 상단에 동일한 레벨의 분류를 출력해주는 코드
if (!$exists) {
    $str = '';

    $tmp_ca_id = substr($ca_id, 0, strlen($ca_id)-2);
    $tmp_ca_id_len = strlen($tmp_ca_id);
    $len2 = $tmp_ca_id_len + 2;
    $len4 = $tmp_ca_id_len + 4;

    // 차차기 분류의 건수를 얻음
    $sql = " select count(*) as cnt from {$g5['g5_shop_category_table']} where ca_id like '$tmp_ca_id%' and ca_use = '1' and length(ca_id) = $len4 ";
    $row = sql_fetch($sql);
    $cnt = $row['cnt'];

    $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '$tmp_ca_id%' and ca_use = '1' and length(ca_id) = $len2 order by ca_order, ca_id ";
    $result = sql_query($sql);
    while ($row=sql_fetch_array($result)) {

		$ca_active = $ca_current = '';
        if ($ca_id == $row['ca_id']) { // 활성 분류 표시
			$ca_active = ' active fw-bold" aria-current="page';
			$ca_current = '<span class="visually-hidden">현재 분류</span>';
		}

        if ($cnt) {
            $str .= '<li class="col nav-item"><a class="nav-link text-truncate'.$ca_active.'" href="'.shop_category_url($row['ca_id']).'">'.$row['ca_name'].'</a></li>';
            $sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '{$row['ca_id']}%' and ca_use = '1' and length(ca_id) = $len4 order by ca_order, ca_id ";
            $result2 = sql_query($sql2);
            $k=0;
            while ($row2=sql_fetch_array($result2)) {
                $str .= '<li class="col nav-item"><a class="nav-link text-truncate" href="'.shop_category_url($row2['ca_id']).'">'.$row2['ca_name'].'</a></li>';
                $k++;
            }
        } else {
            $str .= '<li class="col nav-item"><a class="nav-link text-truncate'.$ca_active.'" href="'.shop_category_url($row['ca_id']).'">'.$row['ca_name'].'</a></li>';
        }

        $exists = true;
    }
}

if ($exists) {
?>
<nav id="sct_ct" class="border-top border-bottom px-3 px-sm-0 py-3 mb-3">
    <h2 class="visually-hidden">현재 상품 분류와 관련된 분류</h2>
	<ul class="nav row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-1 nav-pills text-center">
		<?php echo $str ?>
	</ul>
</nav>
<?php }