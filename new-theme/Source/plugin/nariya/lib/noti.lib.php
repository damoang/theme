<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 알림 - https://sir.kr/g5_plugin/6259 기반으로 수정
function na_noti_count($mb_id){
	global $g5;

	$sql = " select count(*) as cnt from ( select count(*) from ".$g5['na_noti']." where mb_id = '".$mb_id."' and ph_readed = 'N' group by wr_id, ph_from_case , rel_bo_table ) as rowcount "; //읽지 않은 알림 총 갯수

	$row = sql_fetch($sql);

	return $row['cnt'];
}

// 알림 - https://sir.kr/g5_plugin/6259 기반으로 수정
function na_noti_update($mb_id){
	global $g5, $nariya;

	if(!$mb_id)
		return;

	$noti_days = (int)$nariya['noti_days'];

	if($noti_days){

		$sql_datetime = date("Y-m-d H:i:s", G5_SERVER_TIME - ($noti_days * 86400));

		sql_query(" delete from ".$g5['na_noti']." where mb_id = '".$mb_id."' and ph_datetime < '".$sql_datetime."'");
	}

	$cnt = na_noti_count($mb_id);

	sql_query(" update ".$g5['member_table']." set as_noti = '".$cnt."' where mb_id = '".$mb_id."' ");
	
	return $cnt;
}

// 알림 - https://sir.kr/g5_plugin/6259 기반으로 수정
function na_noti($ph_to_case, $ph_from_case, $mb_id, $noti=array()) {
	global $g5;

	if(!$mb_id)
		return;

	$sql = " insert into ".$g5['na_noti']."
				set ph_to_case = '".$ph_to_case."', 
					ph_from_case = '".$ph_from_case."', 
					bo_table = '".$noti['bo_table']."', 
					rel_bo_table = '".$noti['rel_bo_table']."', 
					wr_id = '".$noti['wr_id']."', 
					rel_wr_id = '".$noti['rel_wr_id']."', 
					mb_id = '".$mb_id."', 
					rel_mb_id = '".$noti['rel_mb_id']."', 
					rel_mb_nick = '".$noti['rel_mb_nick']."',
					rel_msg = '".$noti['rel_msg']."', 
					parent_subject = '".$noti['parent_subject']."', 
					rel_url = '".$noti['rel_url']."', 
					ph_readed = 'N' , 
					ph_datetime = '".G5_TIME_YMDHIS."', 
					wr_parent = '".$noti['wr_parent']."'
			";
	$result = sql_query($sql);

	if($result){
		na_noti_update($mb_id);
	}
}

// 알림 - https://sir.kr/g5_plugin/6259 기반으로 수정
function na_short_time($wdate = ""){

	if(!$wdate) 
		return '방금';

	$time = G5_SERVER_TIME - strtotime($wdate);

	if(!$time) 
		return '방금';

	$stat = ' 전';
	
	if($time < 0){ 
		$time*=-1; 
		$stat = ' 후'; 
	} // $time=abs($time);

	$ago = array();
	if($time < 172800){
		//$ct = array(31536000,2592000,604800,86400,3600,60,1); // 대략(년:365일,월:30일 기준)
		//$tt = array('년','달','주','일','시간','분','초');
		$ct = array(86400,3600,60,1); // 대략(년:365일,월:30일 기준)
		$tt = array('일','시간','분','초');
		foreach($ct as $k => $v){
			if($n=floor($time/$v)){
				$ago[] = $n.$tt[$k];
				$time-=$n*$v;
			}
		}
		return implode(' ',array_slice($ago,0,1)).$stat;
	} else {
		return date("m", strtotime($wdate))."월 ".date("d", strtotime($wdate))."일";
	}
}

// 알림 - https://sir.kr/g5_plugin/6259 기반으로 수정
function na_noti_list($readnum = null, $where_add = "", $from_record = 0, $is_read='n', $is_json=true){
	global $g5, $is_member, $member;

	if(!isset($readnum) || !$readnum){
		$readnum = 5;
	}

	$sql_search = " where p.mb_id = '".$member['mb_id']."'";
	$sub_sql_search = " where mb_id = '".$member['mb_id']."'";

	if($is_json){
		$group_by_fields = "p.wr_id, p.ph_from_case, p.rel_bo_table";
		$sub_group_by_fields = "wr_id, ph_from_case, rel_bo_table";
	} else {
		$group_by_fields = "p.ph_readed, p.wr_id, p.ph_from_case, p.rel_bo_table";
		$sub_group_by_fields = "ph_readed, wr_id, ph_from_case, rel_bo_table";
	}

	if($is_read){
		if($is_read === 'y') {
			$sql_search .= " and p.ph_readed = 'Y'";
			$sub_sql_search .= " and ph_readed = 'Y'";
		} else if($is_read === 'n') {
			$sql_search .= " and p.ph_readed = 'N'";
			$sub_sql_search .= " and ph_readed = 'N'";
		}
	}

	$total = sql_fetch(" select count(*) as count from ( select count(*) from ".$g5['na_noti']." p $sql_search group by $group_by_fields ) as rowcount ", false);
	$total['count'] = isset($total['count']) ? $total['count'] : 0;

	$sql = " select p.*, m.mb_nick, p2.num, p2.g_ids, p2.g_rel_mb from ".$g5['na_noti']." p ";

	$sql .= " inner join ( select max(ph_id) as ph_id, count(wr_id) as num, group_concat(ph_id) as g_ids, group_concat(rel_mb_id) as g_rel_mb from ".$g5['na_noti']." $sub_sql_search $where_add group by $sub_group_by_fields ) p2 On p.ph_id = p2.ph_id ";

	// 데이터 최신순
	$sql .= " left outer join ".$g5['member_table']." m On p.rel_mb_id = m.mb_id $sql_search order by p.ph_datetime desc limit $from_record, $readnum ";

	$list = array();

	$result = sql_query($sql);
	if($result) {
		for ($i=0; $row=sql_fetch_array($result); $i++){
			$tmp_total = $row['num'];
			$tmp_to_name = ($row['mb_nick']) ? $row['mb_nick'] : $row['rel_mb_nick'];
			$tmp_mb_count = count(array_unique(explode("," ,$row['g_rel_mb']))); //참여 인원에서 중복 인원 제외
			$tmp_total = ($tmp_mb_count) ? $tmp_mb_count : $tmp_total; //참여 인원에서 중복 제외 인원 대입
			$tmp_add_msg = ($tmp_total > 1) ? "외 ".((int)$tmp_total - 1)."명이 " : "이 내 ";
			$tmp_msg = "";

			switch($row['ph_to_case']) {
				case 'board':
					$pg_to_case = "글";
				break;
				case 'comment':
					$pg_to_case = "댓글";
				break;
				case 'inquire':
					$pg_to_case = "문의";
				break;
			}

			switch($row['ph_from_case']) {
				case 'write':
					$pg_from_case = "글";
					$wr_board = get_board_db($row['bo_table']);
					$bo_table_name = strip_tags($wr_board['bo_subject']);
					$tmp_msg = "<span>".$tmp_to_name."</span>님이 ".$bo_table_name."에 ".$pg_from_case."을 작성하였습니다.";
				break;
				case 'board':
					$pg_from_case = "글";
					$tmp_msg = "<span>".$tmp_to_name."</span>님".$tmp_add_msg.$pg_to_case."에 ".$pg_from_case."을 남기셨습니다.";
				break;
				case 'comment':
					$pg_from_case = "댓글";
					$tmp_msg = "<span>".$tmp_to_name."</span>님".$tmp_add_msg.$pg_to_case."에 ".$pg_from_case."을 남기셨습니다.";
				break;
				case 'good':
					$tmp_msg = "<span>".$tmp_to_name."</span>님".$tmp_add_msg.$pg_to_case."을 좋아합니다.";
				break;
				case 'nogood':
					$tmp_msg = "<span>".$tmp_to_name."</span>님".$tmp_add_msg.$pg_to_case."을 싫어합니다.";
				break;
				case 'inquire':
					$pg_from_case = "글";
					$tmp_msg = "<span>".$tmp_to_name."</span>님이 ".$pg_to_case."에 ".$pg_from_case."을 남기셨습니다.";
				break;
				case 'answer':
				case 'reply':
					$pg_from_case = "답변";
					$tmp_msg = "<span>".$tmp_to_name."</span>님".$tmp_add_msg.$pg_to_case."에 ".$pg_from_case."을 남기셨습니다.";
				break;
			}

			$add_qry = 'noti='.$row['ph_id'];
			
			if(!$is_json){
				$list[$i] = $row;
			}
			$list[$i]['ph_id'] = $row['ph_id'];
			$list[$i]['ph_from_case'] = $row['ph_from_case'];
			$list[$i]['subject'] = get_text($row['parent_subject']);
			$list[$i]['msg'] = $tmp_msg;
			$list[$i]['wtime'] = na_short_time($row['ph_datetime']);
			$list[$i]['url'] = short_url_clean(G5_URL.$row['rel_url'], $add_qry);
			$list[$i]['href'] = ($row['ph_readed'] == "Y") ? short_url_clean(G5_URL.$row['rel_url']) : NA_URL.'/noti.read.php?g_ids='.urlencode($row['g_ids']);
			$list[$i]['g_ids'] = $row['g_ids'];
		}
	}

	$list_cnt = count($list);

	if($is_json){
		if (1 > $list_cnt) {
			die("{\"error\":\"\", \"count\":\"".$total['count']."\", \"res_count\":\"".$list_cnt."\", \"response\": 0 }");
		}

		die("{\"error\":\"\", \"count\":\"".$total['count']."\", \"res_count\":\"".$list_cnt."\", \"response\": ".json_encode($list)." }");
	}

	return array($total['count'], $list);
}
