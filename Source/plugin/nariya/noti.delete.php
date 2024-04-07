<?php
include_once("./_common.php");

// 알림 - https://sir.kr/g5_plugin/6259 기반으로 수정
if (!$is_member) { 
    alert("회원만 접근이 가능합니다.", G5_URL);
}

$read = isset($_POST['read']) ? preg_replace('/[^0-9a-z]/i', '', trim($_POST['read'])) : '';
$p_type = isset($_POST['p_type']) ? preg_replace('/[^0-9a-z]/i', '', trim($_POST['p_type'])) : '';

if($p_type == "del" || $p_type == "read"){
	for($i=0;$i<count($_POST['chk_bn_id']);$i++) {
        $k = preg_replace('/[^0-9a-z]/i', '', $_POST['chk_bn_id'][$i]);
        $ph_id = preg_replace('/[^0-9a-z\,]/i', '', $_POST['chk_g_ids'][$k]);
        $read_yn = preg_replace('/[^0-9a-z]/i', '', $_POST['chk_read_yn'][$k]);

        if($p_type == "read" && $read_yn == "Y"){
            continue;
        }

        $result = sql_query(" select ph_id, mb_id from ".$g5['na_noti']." where ph_id in (".$ph_id.") ", false);
        $tmp_ph_id = array();

		if($result) {
			while($row=sql_fetch_array($result)){
				if ($row['mb_id'] && $member['mb_id'] == $row['mb_id']){
					array_push($tmp_ph_id , $row['ph_id']);
				} else {
					alert("자신의 알림이 아니므로 삭제할 수 없습니다.", G5_BBS_URL.'/noti.php');
				}
			}
		}		

		if(count($tmp_ph_id) > 0){
            $group_ph_id = implode(",", $tmp_ph_id);
            if($p_type == "del"){ // 삭제
                sql_query(" delete from ".$g5['na_noti']." where ph_id in (".$group_ph_id.") ");
            } else if($p_type == "read"){ // 읽음
                sql_query(" update ".$g5['na_noti']." set ph_readed = 'Y' where ph_id in (".$group_ph_id.") ");
            }
        }
	}
} else if($p_type == "alldelete"){
    if (!(isset($token) && $token && get_session("noti_delete_token") == $token)){
        alert("토큰 에러로 삭제 불가합니다.");
    }

	sql_query(" delete from ".$g5['na_noti']." where mb_id = '".$member['mb_id']."' ");

    set_session('noti_delete_token', '');
} else {
    alert("잘못된 접근입니다.", G5_URL);
}

na_noti_update($member['mb_id']);

goto_url(G5_BBS_URL."/noti.php?page=$page&read=$read");