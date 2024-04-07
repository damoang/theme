<?php
include_once("./_common.php");

// 알림 - https://sir.kr/g5_plugin/6259 기반으로 수정

if (!$is_member) { 
    alert("회원만 접근이 가능합니다.");
}

$g_ids = isset($g_ids) ? preg_replace('/[^0-9a-z\,]/i', '', $g_ids) : '';

if(!$g_ids){
    alert("g_ids값이 없습니다.", G5_BBS_URL.'/noti.php');
}

$tmp_ph_id = array();

$result = sql_query(" select ph_id, mb_id, bo_table, wr_parent, ph_to_case, ph_from_case, rel_url from ".$g5['na_noti']." where ph_id in (".$g_ids.") ");

if($result) {
	while($row=sql_fetch_array($result)){

		if ($row['mb_id'] && $member['mb_id'] == $row['mb_id']){
			array_push($tmp_ph_id , $row['ph_id']);
		} else {
			alert("자신의 알림이 아니므로 리다이렉트 할 수 없습니다.", G5_BBS_URL.'/noti.php');
		}

		$tmp_bo_table = $row['bo_table'];
		$tmp_wr_parent = $row['wr_parent'];
		$tmp_url = $row['rel_url'];
	}
}

if(count($tmp_ph_id) > 0){
	$group_ph_id = implode(",", $tmp_ph_id);
	if($tmp_bo_table && $tmp_wr_parent){
		$tmp_add_sql = "OR ( bo_table = '$tmp_bo_table' AND wr_parent = '$tmp_wr_parent' AND mb_id = '{$member['mb_id']}' )";
	}

	//알림데이터 해당 행 읽음으로 업데이트	
	sql_query(" update ".$g5['na_noti']." set ph_readed = 'Y' where ph_id in (".$group_ph_id.") $tmp_add_sql ");

	na_noti_update($member['mb_id']);

	// 리다이렉트 하기
	goto_url(short_url_clean(G5_URL.$tmp_url));
} else {
    alert("알림 정보가 없어 리다이렉트 할 수 없습니다.", G5_BBS_URL.'/noti.php');
}