<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Admin
function na_admin($val='', $opt='') {
	global $is_admin, $member, $group, $board, $nariya;

	if(!$member['mb_id'])
		return;

	// 게시판 관리자
	if($opt) {
		if($val && in_array($member['mb_id'], array_map('trim', explode(",", $val)))) {
			$is_admin = 'board';
			if(isset($board['bo_admin'])) {
				$board['bo_admin'] = $member['mb_id']; // 게시판 관리자 변경
			}
		}
	} else {
		if($nariya['cf_admin'] && in_array($member['mb_id'], array_map('trim', explode(",", $nariya['cf_admin'])))) {
			$is_admin = 'super'; // 통합 최고관리자
		} else if($nariya['cf_group'] && in_array($member['mb_id'], array_map('trim', explode(",", $nariya['cf_group'])))) {
			$is_admin = 'group'; // 통합 그룹관리자
			if(isset($group['gr_admin'])) {
				$group['gr_admin'] = $member['mb_id']; // 그룹 관리자 변경
			}
		}
	}
}

// 포인트 중복 부여
function na_insert_point($mb_id, $point, $content='', $rel_table='', $rel_id='', $rel_action='', $expire=0, $repeat=0) {
    global $config;
    global $g5;
    global $is_admin;

    // 포인트 사용을 하지 않는다면 return
    if (!$config['cf_use_point']) { return 0; }

    // 포인트가 없다면 업데이트 할 필요 없음
    if ($point == 0) { return 0; }

    // 회원아이디가 없다면 업데이트 할 필요 없음
    if ($mb_id == '') { return 0; }
    $mb = sql_fetch(" select mb_id from {$g5['member_table']} where mb_id = '$mb_id' ");
    if (!$mb['mb_id']) { return 0; }

    // 회원포인트
    $mb_point = get_point_sum($mb_id);

    // 이미 등록된 내역이라면 건너뜀
    if (!$repeat && ($rel_table || $rel_id || $rel_action)) {
        $sql = " select count(*) as cnt from {$g5['point_table']}
                  where mb_id = '$mb_id'
                    and po_rel_table = '$rel_table'
                    and po_rel_id = '$rel_id'
                    and po_rel_action = '$rel_action' ";
        $row = sql_fetch($sql);
        if ($row['cnt'])
            return -1;
    }

    // 포인트 건별 생성
    $po_expire_date = '9999-12-31';
    if($config['cf_point_term'] > 0) {
        if($expire > 0)
            $po_expire_date = date('Y-m-d', strtotime('+'.($expire - 1).' days', G5_SERVER_TIME));
        else
            $po_expire_date = date('Y-m-d', strtotime('+'.($config['cf_point_term'] - 1).' days', G5_SERVER_TIME));
    }

    $po_expired = 0;
    if($point < 0) {
        $po_expired = 1;
        $po_expire_date = G5_TIME_YMD;
    }
    $po_mb_point = $mb_point + $point;

    $sql = " insert into {$g5['point_table']}
                set mb_id = '$mb_id',
                    po_datetime = '".G5_TIME_YMDHIS."',
                    po_content = '".addslashes($content)."',
                    po_point = '$point',
                    po_use_point = '0',
                    po_mb_point = '$po_mb_point',
                    po_expired = '$po_expired',
                    po_expire_date = '$po_expire_date',
                    po_rel_table = '$rel_table',
                    po_rel_id = '$rel_id',
                    po_rel_action = '$rel_action' ";
    sql_query($sql);

    // 포인트를 사용한 경우 포인트 내역에 사용금액 기록
    if($point < 0) {
        insert_use_point($mb_id, $point);
    }

    // 포인트 UPDATE
    $sql = " update {$g5['member_table']} set mb_point = '$po_mb_point' where mb_id = '$mb_id' ";
    sql_query($sql);

    return 1;
}

// 레벨 체크
function na_chk_xp($old_grade, $old_level, $old_exp, $exp) {
	global $nariya;

	$info = array();

	$xp_rate = (isset($nariya['xp_rate']) && $nariya['xp_rate']) ? $nariya['xp_rate'] : 0;
	$xp_point = (isset($nariya['xp_point']) && (int)$nariya['xp_point'] > 0) ? (int)$nariya['xp_point'] : 0;
	$max_level = (isset($nariya['xp_max']) && (int)$nariya['xp_max'] > 0) ? (int)$nariya['xp_max'] : 0;
	$exp = ($exp > 0) ? $exp : 0;

	if($exp <= $xp_point) {
		$level = 1;
		$xp_max = $xp_point;
		$xp_min = 0;
	} else if($old_level == $max_level) {
		$level = $max_level;
		$xp_min = $exp;
		$xp_max = $exp;
	} else {
		$xp_min = $xp_point;
		for ($i=2; $i <= $max_level; $i++) {
			$xp_plus = $xp_point + $xp_point * ($i - 1) * $xp_rate;
			$xp_max = $xp_min + $xp_plus;
			if($exp <= $xp_max) {
				$level = $i;
				break;
			}
			$xp_min = $xp_max;
		}
	}

	$msg = 0;
	$old_level = ($old_level > 0) ? $old_level : 1;
	if($level > $old_level) { // 레벨업
		$msg = 1;
	} else if($level < $old_level) { // 레벨다운
		$msg = 2;
	}

	// 자동등업
	$grade = $old_grade;
	if(isset($nariya['xp_auto']) && $nariya['xp_auto']) {

		list($start, $tmp) = na_explode(':', $nariya['xp_auto']);

		$start = (int)$start;

		if($start && $tmp) {
			$gup = array();
			$lup = array();

			$arr = na_explode(',', $tmp.','.$max_level);
			$arr_cnt = count($arr);
			$n = 0;
			for($i=0; $i < $arr_cnt; $i++) {

				$lvl = (int)$arr[$i];

				if(!$lvl)
					continue;

				$gup[] = $start + $n; // 등급
				$lup[] = $lvl; // 레벨
				$n++;
			}

			if(!empty($gup) && in_array($old_grade, $gup)) {
				$lup_cnt = count($lup);
				for($i=0; $i < $lup_cnt; $i++) {
					if($level <= $lup[$i]) {
						$grade = $gup[$i];
						break;
					}
				}

				if($grade > $old_grade) { // 등업
					$msg = 3;
				} else if($grade < $old_grade) { // 등급 다운
					$msg = 4;
				}
			}
		}
	}

	return array($grade, $level, $exp, $xp_max, $msg);
}

// 경험치 정리
function na_sum_xp($mb) {
    global $g5;

	$mb_id = $mb['mb_id'];

	// 경험치 내역의 합을 구하고
	$row = sql_fetch(" select sum(xp_point) as sum_exp from {$g5['na_xp']} where mb_id = '$mb_id' ");

	// 레벨변동 체크
	list($grade, $level, $exp, $max, $msg) = na_chk_xp($mb['mb_level'], $mb['as_level'], $mb['as_exp'], $row['sum_exp']);

	// 회원정보 UPDATE
	if($msg) {
		sql_query(" update {$g5['member_table']} 
						set mb_level = '{$grade}',
						as_msg = '{$msg}',
						as_exp = '{$exp}', 
						as_level = '{$level}', 
						as_max = '{$max}' where mb_id = '$mb_id' ");
	} else {
		$sql = ($mb['as_max'] == $max) ? "" : ", as_max = '{$max}'";
		sql_query(" update {$g5['member_table']} set as_exp = '{$exp}' $sql where mb_id = '$mb_id' ");
	}
}

// 경험치 부여
function na_insert_xp($mb_id, $point, $content='', $rel_table='', $rel_id='', $rel_action='', $repeat=0) {
    global $config;
    global $g5;
    global $is_admin;

    // 경험치가 없다면 업데이트 할 필요 없음
    if ($point == 0) { return 0; }

    // 회원아이디가 없다면 업데이트 할 필요 없음
    if ($mb_id == "") {	return 0; }

    $mb = sql_fetch(" select mb_id, mb_level, as_level, as_exp, as_max from {$g5['member_table']} where mb_id = '$mb_id' ");
    if (!$mb['mb_id']) { return 0; }

    // 이미 등록된 내역이라면 건너뜀
    if (!$repeat && ($rel_table || $rel_id || $rel_action)) {
        $row = sql_fetch(" select count(*) as cnt from {$g5['na_xp']}
                  where mb_id = '$mb_id'
                    and xp_rel_table = '$rel_table'
                    and xp_rel_id = '$rel_id'
                    and xp_rel_action = '$rel_action' ");
        if ($row['cnt'])
            return -1;
    }

    // 경험치 건별 생성
    $result = sql_query(" insert into {$g5['na_xp']}
			      set mb_id = '$mb_id',
                    xp_datetime = '".G5_TIME_YMDHIS."',
                    xp_content = '".addslashes($content)."',
                    xp_point = '$point',
                    xp_rel_table = '$rel_table',
                    xp_rel_id = '$rel_id',
                    xp_rel_action = '$rel_action' ");

	// 회원정보 UPDATE
	na_sum_xp($mb);

	return 1;
}

// 경험치 삭제
function na_delete_xp($mb_id, $rel_table, $rel_id, $rel_action) {
    global $g5;

    // 회원아이디가 없다면 업데이트 할 필요 없음
    if ($mb_id == "") {	return 0; }

    $result = false;
    if ($rel_table || $rel_id || $rel_action) {

		$mb = sql_fetch(" select mb_id, mb_level, as_level, as_exp, as_max from {$g5['member_table']} where mb_id = '$mb_id' ");
	    if (!$mb['mb_id']) { return 0; }

        $result = sql_query(" delete from {$g5['na_xp']}
					where mb_id = '$mb_id'
						and xp_rel_table = '$rel_table'
				        and xp_rel_id = '$rel_id'
						and xp_rel_action = '$rel_action' ");

		// 회원정보 UPDATE
		if($result) {
			na_sum_xp($mb);
		}
	}

    return $result;
}

// 레벨 아이콘
function na_xp_icon($mb_id, $level='', $mb=array()){
	global $nariya, $xp;

	if(!$nariya['lvl_skin'])
		return;

	if($level) {
		$xp_icon = $level;
	} else if(!$mb_id) {
		$xp_icon = 'guest';
	} else if(!empty($xp['admin']) && in_array($mb_id, $xp['admin'])) {
		$xp_icon = 'admin';
	} else if(!empty($xp['special']) && in_array($mb_id, $xp['special'])) {
		$xp_icon = 'special';
	} else {
		if(!isset($mb['as_level'])) {
			$mb = get_member($mb_id, 'as_level');
		}
		$xp_icon = $mb['as_level'];	
	}

	$xp_icon = $xp_icon ? $xp_icon : '1';

	$xp_icon = '<span class="xp-icon"><img src="'.NA_URL.'/skin/level/'.$nariya['lvl_skin'].'/'.$xp_icon.'.'.$nariya['lvl_ext'].'"></span> ';

	return $xp_icon;
}

// 회원등급명
function na_grade($grade) {
	global $nariya;

	if(!$grade)
		$grade = 1;

	$g = 'mb_gn'.$grade;

	$gn = (isset($nariya[$g]) && $nariya[$g]) ? $nariya[$g] : '';

	return $gn;
}

// 회원사진
function na_member_photo($mb_id){

	static $no_profile_cache = '';
    static $member_cache = array();
    
    $src = '';

    if ($mb_id){
        if (isset($member_cache[$mb_id])) {
            $src = $member_cache[$mb_id];
        } else {
            $member_img = G5_DATA_PATH.'/member_image/'.substr($mb_id,0,2).'/'.get_mb_icon_name($mb_id).'.gif';
            if (is_file($member_img)) {
                if(defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME) {
                    $member_img .= '?'.filemtime($member_img);
                }
                $member_cache[$mb_id] = $src = str_replace(G5_DATA_PATH, G5_DATA_URL, $member_img);
            }
        }
    }

    if(!$src){
        if(!empty($no_profile_cache)){
            $src = $no_profile_cache;
        } else {
            // 프로필 이미지가 없을때 기본 이미지
            $no_profile_img = (defined('G5_THEME_NO_PROFILE_IMG') && G5_THEME_NO_PROFILE_IMG) ? G5_THEME_NO_PROFILE_IMG : G5_NO_PROFILE_IMG;
            $tmp = array();
            preg_match( '/src="([^"]*)"/i', $no_profile_img, $tmp);
            $no_profile_cache = $src = isset($tmp[1]) ? $tmp[1] : G5_IMG_URL.'/no_profile.gif';
        }
    }

	return $src;
}

function na_name_photo($mb_id, $name, $memo = false){
	global $nariya;
	global $member;
	$is_photo = false;

	$matches = get_editor_image($name, true);
	if($memo){
		if(check_memo($mb_id)){
			$name = "<div style='display: inline-flex;'><div>".$name;
		}
	}
	for($i=0; $i<count($matches[1]); $i++) {

        $img = $matches[1][$i];
        $mb_icon = isset($matches[0][$i]) ? $matches[0][$i] : '';

        preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $img, $m);
        $alt = isset($m[1]) ? get_text($m[1]) : '';

		$name = str_replace($mb_icon, '<img src="'.na_member_photo($mb_id).'" alt="'.$alt.'" class="mb-photo">', $name);

		$is_photo = true;

		break;
    }
	$nansu = rand(10000,1000000);
	$sam = $mb_id.$nansu;
	if($is_photo) {
		if($nariya['lvl_skin'])
			$name = str_replace('onclick="return false;">','onclick="return false;">'.na_xp_icon($mb_id), $name);
	} else {
		$mb_photo = ($nariya['lvl_skin']) ? na_xp_icon($mb_id) : '';
		$mb_photo .= '<img src="'.na_member_photo($mb_id).'" alt="" class="mb-photo">';

		$name = str_replace('onclick="return false;">','onclick="return false;">'.$mb_photo, $name);
	}

	if($memo){
		if($rk = check_memo($mb_id)){
			$name .= "</div><div style='margin-left: 15px; display: inline-flex;'><a href='javascript:void(0);' onclick='memo_{$sam}()'><i class='bi bi-sticky'></i></a>{$rk['message']}</div></div>";
		}
	}


	$name .= "<div id='memo_".$sam."' style='display:none;'><form action='/bbs/dam_memo.php' method='post'><input type='hidden' name='before' value='{$_SERVER['REQUEST_URI']}' /><input type='hidden' name='loader_k' value='memotext_{$sam}' /><input type='hidden' name='target' value='{$mb_id}' /><input type='text' name='memotext_".$sam."' /></form></div>";
	echo "
	<script>
	function memo_{$sam}(){
		const mem_{$sam} = document.getElementById('memo_{$sam}');
		if(mem_{$sam}.style.display == 'none'){
			mem_{$sam}.style.display = 'inline-block';
		} else {
			mem_{$sam}.style.display = 'none';
		}
		
	}
	</script>";
	return $name;
}

// 멤버십 체크
function is_membership($cols='') {
	global $nariya, $member, $is_admin, $is_guest, $write;

	if ($is_guest)
		return false;

	if ($is_admin || (isset($write['mb_id']) && $write['mb_id'] === $member['mb_id'])) {
		return true; // 관리자 또는 자기자신이면 통과
	} else {
		$mbs_list = isset($nariya['mbs_list']) ? $nariya['mbs_list'] : '';
		$mbs_list = ($cols) ? $cols : $mbs_list;
		if($mbs_list) {
			$chk_today = (int)date('Ymd', G5_SERVER_TIME);
			$mbs_arr = na_explode(',', $mbs_list);
			for ($i=0; $i < count($mbs_arr); $i++) {
				$db = trim($mbs_arr[$i]);

				if(!$db)
					continue;

				if(isset($member[$db]) && $member[$db]) {
					$mbs_day = $member[$db];
					$chk_mbs = (int)str_replace('-', '', $mbs_day);
					if ($chk_mbs >= $chk_today) {
						return true;
					}
				}
			}
		}
	}

	return false;
}

// 멤버십 체크
function na_membership($flag, $msg, $opt='') {
	global $nariya, $member, $is_admin, $is_guest, $boset, $write;

	$db = (isset($boset['mbs_db']) && $boset['mbs_db']) ? na_fid($boset['mbs_db']) : '';
	if (!$db)
		return;

	$mb = 'mbs_'.$flag;
	if (!$opt && (!isset($boset[$mb]) || !$boset[$mb]))
		return;

	if ($is_guest)
		alert('멤버십 회원 전용입니다.');

	if(!isset($nariya['mbs_list']) || !$nariya['mbs_list']) {
		if ($flag === 'list' || $flag === 'view') {
			echo '<div class="alert alert-danger mb-3" role="alert">나리야 설정에 설정한 멤버십 칼럼을 등록해야 작동합니다.</div>';
			return;
		} else {
			alert('나리야 설정에 설정한 멤버십 칼럼을 등록해야 작동합니다.');
		}
	}

	$mbs_list = na_explode(',', $nariya['mbs_list']);
	if(!in_array($db, $mbs_list)) {
		if ($flag === 'list' || $flag === 'view') {
			echo '<div class="alert alert-danger mb-3" role="alert">나리야 설정에 설정한 멤버십 칼럼을 등록해야 작동합니다.</div>';
			return;
		} else {
			alert('나리야 설정에 설정한 멤버십 칼럼을 등록해야 작동합니다.');
		}
	}

	if (!isset($member[$db])) {
		if ($flag === 'list' || $flag === 'view') {
			echo '<div class="alert alert-danger mb-3" role="alert">지정하신 멤버십 칼럼이 회원정보 테이블에 존재하지 않습니다.</div>';
			return;
		} else {
			alert('설정한 멤버십 칼럼이 회원정보 테이블에 존재하지 않습니다.');
		}
	}

	if ($is_admin || (isset($write['mb_id']) && $write['mb_id'] === $member['mb_id'])) {
		; // 관리자 또는 자기자신이면 통과
	} else {
		$mbs_day = $member[$db];
		if (!$mbs_day)
			alert($msg);

		$chk_mbs = (int)str_replace('-', '', $mbs_day);
		$chk_today = (int)date('Ymd', G5_SERVER_TIME);
		if ($chk_today > $chk_mbs) {
			alert('기존 멤버십이 '.$mbs_day.' 종료되어 재가입 후 이용할 수 있습니다.');
		}
	}
	return;
}


// 회원정보 재가공
function na_member($member) {
	global $g5, $config, $is_member;

	if ($is_member) {
		$member['sideview'] = get_sideview($member['mb_id'], $member['mb_nick'], $member['mb_email'], $member['mb_homepage']);
		$member['mb_scrap_cnt'] = isset($member['mb_scrap_cnt']) ? (int)$member['mb_scrap_cnt'] : 0;
    }

	$member['as_level'] = isset($member['as_level']) ? $member['as_level'] : 1; // 레벨	
	$member['as_noti'] = isset($member['as_noti']) ? $member['as_noti'] : 0; // 알림수
	$member['mb_memo_cnt'] = isset($member['mb_memo_cnt']) ? $member['mb_memo_cnt'] : 0; // 쪽지수
	$member['noti_cnt'] = $member['as_noti'] + $member['mb_memo_cnt'];
	$member['mb_grade'] = na_grade($member['mb_level']);

    // 회원, 방문객 카운트
    $sql = " select sum(IF(mb_id<>'',1,0)) as mb_cnt, count(*) as total_cnt from {$g5['login_table']}  where mb_id <> '{$config['cf_admin']}' ";
    $row = sql_fetch($sql);

	$member['connect_cnt'] = isset($row['total_cnt']) ? $row['total_cnt'] : 0;
	$member['login_cnt'] = isset($row['mb_cnt']) ? $row['mb_cnt'] : 0;

	return $member;
}
