<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!IS_YC)
	die(NA_YC);

$item_rows = (isset($_REQUEST['item']) && (int)$_REQUEST['item'] > 0) ? $_REQUEST['item'] : 3;

$list = array();

$i = 0;
$hresult = sql_query(" select ev_id, ev_subject, ev_subject_strong from {$g5['g5_shop_event_table']} where ev_use = '1' order by ev_id desc ");
if(sql_num_rows($hresult)) {
	for ($i=0; $row=sql_fetch_array($hresult); $i++) {

		$list[$i] = na_ev_data($row);

		if($list[$i]['item']) {
			$list[$i]['it'] = array();
			$sql = " select b.* from `{$g5['g5_shop_event_item_table']}` a left join `{$g5['g5_shop_item_table']}` b on (a.it_id = b.it_id)
						            where a.ev_id = '{$row['ev_id']}'
						            order by it_id desc
						            limit $item_rows ";
	        $result = sql_query($sql);
		    for($j=0; $row1=sql_fetch_array($result); $j++) {
				$list[$i]['it'][$j] = na_it_data($row1);
			}
		}
	}
}

$total_count = $list_cnt = $i;