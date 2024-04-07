<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 함수
function na_widget($wname, $wid='', $opt='', $mopt='', $wdir='', $addon=''){
	global $is_admin;

	// 적합성 체크
	if(!na_check_id($wname) || !na_check_id($wid))
		return '<div class="px-3 py-5 text-center">위젯 스킨과 아이디는 영문자, 숫자, -, _ 만 가능함</div>';

	if($wdir) {
	    $wdir = preg_replace('/[^-A-Za-z0-9_\/]/i', '', trim(str_replace(G5_PATH, '', $wdir)));
		$widget_path = G5_PATH.$wdir.'/'.$wname;
		$widget_url = str_replace(G5_PATH, G5_URL, $widget_path);
	} else {
		$widget_url = LAYOUT_URL.'/widget/'.$wname;
		$widget_path = LAYOUT_PATH.'/widget/'.$wname;
	}

	if(!is_file($widget_path.'/widget.php')) 
		return;

	$wfile = (G5_IS_MOBILE) ? 'mo' : 'pc'; 
	$widget_file = NA_DATA_PATH.'/widget/w-'.$wname.'-'.$wid.'-'.$wfile.'.php';
	$setup_href = '';

	$wset = array();

	$is_opt = true;
	if($wid) {
		if(is_file($widget_file)) {
			$wset = na_file_var_load($widget_file);
			$is_opt = false;
		}

		if($is_admin == 'super' || IS_DEMO) {
			$setup_href = NA_URL.'/widget.form.php?layout='.urlencode(LAYOUT_SKIN).'&amp;wid='.urlencode($wid).'&amp;wname='.urlencode($wname).'&amp;wdir='.urlencode($wdir);
		}
	}
	
	if($is_opt && $opt) {
		$wset = is_array($opt) ? $opt : na_query($opt);
		if(G5_IS_MOBILE && !empty($wset) && $mopt) {
			$marr = is_array($mopt) ? $mopt : na_query($mopt);
			$wset = array_merge($wset, $marr);
		}
	}

	// 설정 초기값
	if($setup_href) {
		if($opt)
			$setup_href .= '&amp;optp='.urlencode(addslashes(serialize($opt)));
		if($mopt)
			$setup_href .= '&amp;optm='.urlencode(addslashes(serialize($mopt)));
	}

	// 옵션지정시 추가쿼리구문 작동안됨
	unset($wset['where']);
	unset($wset['orderby']);

	// 초기값
	$wset['cacheId'] = md5('w-'.$wname.'-'.$wid.'-'.$wfile);
	$wset['cache'] = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	$wset['bo_new'] = isset($wset['bo_new']) ? (int)$wset['bo_new'] : 24;

	$is_ajax = false;

    ob_start();
	@include ($widget_path.'/widget.php');
    $widget = ob_get_contents();
	ob_end_clean();

	return $widget;
}

// 기간 체크
function na_sql_term($term, $field) {

	$sql_term = '';
	if($term && $field) {
		if($term > 0 || $term == 'week') {
			$term = ($term == 'week') ? 1 + (int)date("w", G5_SERVER_TIME) : $term;
			$chk_term = date("Y-m-d H:i:s", G5_SERVER_TIME - ($term * 86400));
			$sql_term = " and $field >= '{$chk_term}' ";
		} else {
			$day = getdate();
			$today = $day['year'].'-'.sprintf("%02d",$day['mon']).'-'.sprintf("%02d",$day['mday']).' 00:00:00';	// 오늘
			$yesterday = date("Y-m-d", (G5_SERVER_TIME - 86400)).' 00:00:00'; // 어제
			$nowmonth = $day['year'].'-'.sprintf("%02d",$day['mon']).'-01 00:00:00'; // 이번달

			if($day['mon'] == "1") { //1월이면
				$prevyear = $day['year'] - 1;
				$prevmonth = $prevyear.'-12-01 00:00:00';
			} else {
				$prev = $day['mon'] - 1;
				$prevmonth = $day['year'].'-'.sprintf("%02d",$prev).'-01 00:00:00';
			}

			switch($term) {
				case 'today'		: $sql_term = " and $field >= '{$today}'"; break;
				case 'yesterday'	: $sql_term = " and $field >= '{$yesterday}' and $field < '{$today}'"; break;
				case 'month'		: $sql_term = " and $field >= '{$nowmonth}'"; break;
				case 'prev'			: $sql_term = " and $field >= '{$prevmonth}' and $field < '{$nowmonth}'"; break;
			}
		}
	}

	return $sql_term;
}

// 자료 소팅
function na_sql_sort($type, $sort) {

	$orderby = '';
	if($type == 'new') {
		switch($sort) { 
			case 'asc'		: $orderby = 'a.bn_id'; break;
			case 'date'		: $orderby = 'a.bn_datetime desc'; break;
			case 'comment'	: $orderby = 'a.wr_comment desc'; break;
			case 'good'		: $orderby = 'a.wr_good desc'; break;
			case 'nogood'	: $orderby = 'a.wr_nogood desc'; break;
			case 'like'		: $orderby = '(a.wr_good - a.wr_nogood) desc'; break;
			case 'rand'		: $orderby = 'rand()'; break;
			default			: $orderby = 'a.bn_id desc'; break;
		}
	} else if($type == 'bo') {
		switch($sort) { 
			case 'asc'			: $orderby = 'wr_id'; break;
			case 'date'			: $orderby = 'wr_datetime desc'; break;
			case 'hit'			: $orderby = 'wr_hit desc'; break;
			case 'comment'		: $orderby = 'wr_comment desc'; break;
			case 'good'			: $orderby = 'wr_good desc'; break;
			case 'nogood'		: $orderby = 'wr_nogood desc'; break;
			case 'like'			: $orderby = '(wr_good - wr_nogood) desc'; break;
			case 'link'			: $orderby = '(wr_link1_hit + wr_link2_hit) desc'; break;
			case 'rand'			: $orderby = 'rand()'; break;
			default				: $orderby = 'wr_id desc'; break;
		}
	} else if($type == 'it') {
		switch($sort) { 
			case 'hp'			: $orderby = 'it_price desc'; break;
			case 'lp'			: $orderby = 'it_price asc'; break;
			case 'qty'			: $orderby = 'it_sum_qty desc'; break;
			case 'use'			: $orderby = 'it_use_cnt desc'; break;
			case 'hit'			: $orderby = 'it_hit desc'; break;
			case 'star'			: $orderby = 'it_use_avg desc'; break;
			case 'rand'			: $orderby = 'rand()'; break;
			default				: $orderby = 'it_order, it_id desc'; break;
		}
	}

	return $orderby;
}

// 게시판 정리
function na_sql_find($field, $str, $ex='') {

	if(!$field || !$str)
		return;

	$ex = ($ex) ? '=0' : '';
	$sql = " and find_in_set(".$field.", '".$str."')".$ex;

	return $sql;
}

// 칼럼
function na_cols($wset) {
	
	$cols = '';
	if(isset($wset['xs']) && (int)$wset['xs'] > 0)
		$cols .= ' row-cols-'.$wset['xs'];
	if(isset($wset['sm']) && (int)$wset['sm'] > 0)
		$cols .= ' row-cols-sm-'.$wset['sm'];
	if(isset($wset['md']) && (int)$wset['md'] > 0)
		$cols .= ' row-cols-md-'.$wset['md'];
	if(isset($wset['lg']) && (int)$wset['lg'] > 0)
		$cols .= ' row-cols-lg-'.$wset['lg'];
	if(isset($wset['xl']) && (int)$wset['xl'] > 0)
		$cols .= ' row-cols-xl-'.$wset['xl'];
	if(isset($wset['xxl']) && (int)$wset['xxl'] > 0)
		$cols .= ' row-cols-xxl-'.$wset['xxl'];
	
	return $cols;
}

// 랭킹시작 번호
function na_rank_start($rows, $page) {

	$rows = (int)$rows;
	$page = (int)$page;

	$rank = ($rows > 0 && $page > 1) ?  (($page - 1) * $rows + 1) : 1;

	return $rank;
}

// Date & Time
function na_date($date, $class='', $day='H:i', $month='m.d H:i', $year='Y.m.d H:i') {

	$date = strtotime($date);
	$today = date('Y-m-d', $date);

	if (G5_TIME_YMD == $today) {
		if($day == 'before') {
			$diff = G5_SERVER_TIME - $date;

			$s = 60; //1분 = 60초
			$h = $s * 60; //1시간 = 60분
			$d = $h * 24; //1일 = 24시간
			$y = $d * 10; //1년 = 1일 * 10일

			if ($diff < $s) {
				$time = $diff.'초 전';
			} else if ($h > $diff && $diff >= $s) {
				$time = round($diff / $s).'분 전';
			} else if ($d > $diff && $diff >= $h) {
				$time = round($diff / $h).'시간 전';
			} else {
				$time = date($day, $date);
			} 
		} else {
			$time = date($day, $date);
		}

		if($class) {
			$time = '<span class="'.$class.'">'.$time.'</span>';
		}
	} else if(substr(G5_TIME_YMD, 0, 7) == substr($today, 0, 7)) {
		$time = date($month, $date);
	} else {
		$time = date($year, $date);
	} 

	return $time;
}

// 그누 get_list()함수에서 전역변수 일부 수정
function na_get_list($write_row, $board) {
    global $g5, $config, $g5_object;

    $g5_object->set('bbs', $write_row['wr_id'], $write_row, $board['bo_table']);

    // 배열전체를 복사
    $list = $write_row;
    unset($write_row);

	$list['subject'] = get_text($list['wr_subject']);

    if(!(isset($list['wr_seo_title']) && $list['wr_seo_title']) && $list['wr_id'] ){
        seo_title_update(get_write_table_name($board['bo_table']), $list['wr_id'], 'bbs');
    }

    // 목록에서 내용 미리보기 사용한 게시판만 내용을 변환함 (속도 향상) : kkal3(커피)님께서 알려주셨습니다.
    if ($board['bo_use_list_content']){
		$html = 0;
		if (strstr($list['wr_option'], 'html1'))
			$html = 1;
		else if (strstr($list['wr_option'], 'html2'))
			$html = 2;

        $list['content'] = conv_content($list['wr_content'], $html);
	}

    // 당일인 경우 시간으로 표시함
    $list['datetime'] = substr($list['wr_datetime'],0,10);
    $list['datetime2'] = $list['wr_datetime'];
	$list['datetime2'] = ($list['datetime'] == G5_TIME_YMD) ? substr($list['datetime2'],11,5) : substr($list['datetime2'],5,5);
    $list['last'] = substr($list['wr_last'],0,10);
    $list['last2'] = $list['wr_last'];
	$list['last2'] = ($list['last'] == G5_TIME_YMD) ? substr($list['last2'],11,5) : substr($list['last2'],5,5);

    $list['wr_homepage'] = get_text($list['wr_homepage']);

    $tmp_name = get_text(cut_str($list['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
    $tmp_name2 = cut_str($list['wr_name'], $config['cf_cut_name']); // 설정된 자리수 만큼만 이름 출력
    if ($board['bo_use_sideview'])
        $list['name'] = get_sideview($list['mb_id'], $tmp_name2, $list['wr_email'], $list['wr_homepage']);
    else
        $list['name'] = '<span class="'.($list['mb_id']?'sv_member':'sv_guest').'">'.$tmp_name.'</span>';

    $list['icon_link'] = ($list['wr_link1'] || $list['wr_link2']) ? true : false;

    // 분류명 링크
    $list['ca_name_href'] = get_pretty_url($board['bo_table'], '', 'sca='.urlencode($list['ca_name']));
    $list['href'] = get_pretty_url($board['bo_table'], $list['wr_id']);
    $list['comment_href'] = $list['href'];
    $list['icon_new'] = ($board['bo_new'] && $list['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600))) ? true : false;
    $list['icon_secret'] = (strstr($list['wr_option'], 'secret') || $list['wr_7'] == 'lock') ? true : false;

    // 링크
    for ($i=1; $i<=G5_LINK_COUNT; $i++) {
        $list['link'][$i] = set_http(get_text($list["wr_link{$i}"]));
        $list['link_href'][$i] = G5_BBS_URL.'/link.php?bo_table='.$board['bo_table'].'&amp;wr_id='.$list['wr_id'].'&amp;no='.$i;
        $list['link_hit'][$i] = (int)$list["wr_link{$i}_hit"];
    }

    // 가변 파일
    if ($board['bo_use_list_file']) {
        $list['file'] = get_file($board['bo_table'], $list['wr_id']);
    } else {
        $list['file']['count'] = $list['wr_file'];
    }

	$list['icon_file'] = $list['file']['count'] ? true : false;
	$list['is_notice'] = isset($list['is_notice']) ? $list['is_notice'] : false;

    return $list;
}

// 게시물 정리
function na_wr_row($wr, $wset) {
	global $g5;

	//비번은 아예 배열에서 삭제
	if(isset($wr['wr_password']))
		unset($wr['wr_password']);

	//이메일 저장 안함
	$wr['wr_email'] = '';
	if($wset['wr_comment']) { // 댓글일 때
		if (strstr($wr['wr_option'], 'secret')){
			$wr['wr_subject'] = $wr['wr_content'] = '비밀댓글입니다.';
		} else {
			$tmp_write_table = $g5['write_prefix'] . $wr['bo_table'];
			$row = sql_fetch("select wr_option from $tmp_write_table where wr_id = '{$wr['wr_parent']}' ");
			if (strstr($row['wr_option'], 'secret')){
				$wr['wr_subject'] = $wr['wr_content'] = '비밀댓글입니다.';
				$wr['wr_option'] = $row['wr_option'];
			} else {
				// 댓글에서 40자 잘라서 글제목으로
				$wr['wr_subject'] = cut_str($wr['wr_content'], 80);
			}
		}
		$wr['wr_comment'] = 0;
	} else if (strstr($wr['wr_option'], 'secret')){
		$wr['wr_content'] = '비밀글입니다.';
		$wr['wr_link1'] = $wr['wr_link2'] = '';
		$wr['file'] = array('count'=>0);
	}

	$bo = array();
	$bo['bo_table'] = $wr['bo_table'];
	$bo['bo_new'] = (isset($wset['bo_new']) && $wset['bo_new']) ? $wset['bo_new'] : 24;
	$bo['bo_use_list_content'] = isset($wset['list_content']) ? $wset['list_content'] : '';
	$bo['bo_use_sideview'] = isset($wset['sideview']) ? $wset['sideview'] : '';
	$bo['bo_use_list_file'] = isset($wset['list_file']) ? $wset['list_file'] : '';

	$list = array();
	$list = na_get_list($wr, $bo);

	if($bo['bo_use_sideview']) {
		$list['name'] = na_name_photo($list['mb_id'], $list['name']);
	}

	return $list;
}

// 그룹 내 게시판
function na_bo_list($gr_list, $gr_except, $bo_list, $bo_except) {
	global $g5;

	$bo = array();
	$plus = array();
	$minus = array();

	if($gr_list) {
		$gr = array();

		// 지정그룹의 게시판 다 뽑기
		$result = sql_query(" select bo_table from {$g5['board_table']} where find_in_set(gr_id, '{$gr_list}') ");
		if($result) {
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$gr[] = $row['bo_table'];
			}
		}

		if($bo_list) {
			$bo = na_explode(',', $bo_list);
			if($gr_except) {
				if($bo_except) {
					$gr = array_merge($gr, $bo);
					$minus = array_unique($gr);
				} else {
					$minus = array_diff($gr, $bo);
					$plus = $bo;
				}
			} else {
				if($bo_except) {
					$plus = array_diff($gr, $bo);
					$minus = $bo;
				} else {
					$gr = array_merge($gr, $bo);
					$plus = array_unique($gr);
				}
			}
		} else {
			if($gr_except) {
				$minus = $gr;				
			} else {
				$plus = $gr;
			}
		}
	} else if($bo_list) {
		$bo = na_explode(',', $bo_list);
		if($bo_except) {
			$minus = $bo;
		} else {
			$plus = $bo;
		}
	} 

	return array(implode(',', $plus), implode(',', $minus));
}

// 게시물 추출
function na_board_rows($wset) {
	global $g5;

	$caches = false;
	$is_cache = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	if($is_cache > 0) {
		$caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
	}

	// 캐시값 넘김
	if(isset($caches['list']) && is_array($caches['list']))
		return $caches['list'];

	$list = array();

	$rows = isset($wset['rows']) ? (int)$wset['rows'] : 0;
	$rows = ($rows > 0) ? $rows : 7;
	$page = isset($wset['page']) ? (int)$wset['page'] : 0;
	$page = ($page > 1) ? $page : 1;

	$wset['rows_notice'] = isset($wset['rows_notice']) ? $wset['rows_notice'] : '';
	$wset['bo_list'] = isset($wset['bo_list']) ? $wset['bo_list'] : '';
	$wset['bo_except'] = isset($wset['bo_except']) ? $wset['bo_except'] : '';
	$wset['gr_list'] = isset($wset['gr_list']) ? $wset['gr_list'] : '';
	$wset['gr_except'] = isset($wset['gr_except']) ? $wset['gr_except'] : '';
	$wset['ca_list'] = isset($wset['ca_list']) ? $wset['ca_list'] : '';
	$wset['ca_except'] = isset($wset['ca_except']) ? $wset['ca_except'] : '';
	$wset['mb_list'] = isset($wset['mb_list']) ? $wset['mb_list'] : '';
	$wset['mb_except'] = isset($wset['mb_except']) ? $wset['mb_except'] : '';
	$wset['list_content'] = isset($wset['list_content']) ? $wset['list_content'] : '';
	$wset['sideview'] = isset($wset['sideview']) ? $wset['sideview'] : '';
	$wset['list_file'] = isset($wset['list_file']) ? $wset['list_file'] : '';

	$wset['term'] = isset($wset['term']) ? $wset['term'] : '';
	$wset['dayterm'] = isset($wset['dayterm']) ? (int)$wset['dayterm'] : 0;
	$wset['sort'] = isset($wset['sort']) ? $wset['sort'] : '';
	$wset['wr_image'] = isset($wset['wr_image']) ? $wset['wr_image'] : '';
	$wset['wr_video'] = isset($wset['wr_video']) ? $wset['wr_video'] : '';
	$wset['wr_singo'] = isset($wset['wr_singo']) ? $wset['wr_singo'] : '';
	$wset['wr_notice'] = isset($wset['wr_notice']) ? $wset['wr_notice'] : '';
	$wset['wr_secret'] = isset($wset['wr_secret']) ? $wset['wr_secret'] : '';
	$wset['wr_chadan'] = isset($wset['wr_chadan']) ? $wset['wr_chadan'] : '';
	$wset['wr_comment'] = isset($wset['wr_comment']) ? $wset['wr_comment'] : '';

	$bo_table = $wset['bo_list'];
	$term = ($wset['term'] == 'day' && $wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];
	$sql_where = (isset($wset['where']) && $wset['where']) ? 'and '.$wset['where'] : '';
	$sql_orderby = (isset($wset['orderby']) && $wset['orderby']) ? $wset['orderby'].',' : '';

	$post = array();
	$i_start = 0;
	if($wset['wr_notice']) { // 공지글

		// 추출게시판 정리
		list($plus, $minus) = na_bo_list($wset['gr_list'], $wset['gr_except'], $wset['bo_list'], $wset['bo_except']);
		$sql_notice = na_sql_find('bo_table', $plus, 0);
		$sql_notice .= na_sql_find('bo_table', $minus, 1);

		$result = sql_query(" select bo_table, bo_subject, bo_notice from {$g5['board_table']} where (1) $sql_notice ");
		if($result) {
			for ($i=0; $row=sql_fetch_array($result); $i++) {

				$row['bo_notice'] = trim($row['bo_notice']);

				if(!$row['bo_notice'])
					continue;

				$tmp_write_table = $g5['write_prefix'] . $row['bo_table']; 

				$result1 = sql_query(" select * from $tmp_write_table where find_in_set(wr_id, '{$row['bo_notice']}') ");
				if($result1) {
					for ($j=0; $row1=sql_fetch_array($result1); $j++) {

						$row1['is_notice'] = true;
						$row1['bo_table'] = $row['bo_table'];
						$row1['bo_subject'] = $row['bo_subject'];

						$post[] = $row1;
					}
				}
			}
		}

		$post_cnt = count($post);

		if($post_cnt)
			$post = na_sort($post, 'wr_datetime', true);

		$post_cnt = ($post_cnt > $rows) ? $rows : $post_cnt;

		for($i=0; $i < $post_cnt; $i++) {
			$list[$i] = na_wr_row($post[$i], $wset);
		}

		$i_start = $i;
	}

	unset($post);

	if($wset['rows_notice'])
		$rows = $rows - $i_start;

	if ($rows > 0) {
		$start_rows = 0;
		$board_cnt = na_explode(',', $bo_table);

		// 차단회원 체크
		$is_chadan = false;
		if($wset['wr_chadan'] && !$is_cache) {
			global $member, $is_member;

			$chadan_list = ($is_member && isset($member['as_chadan']) && trim($member['as_chadan'])) ? na_explode(',', $member['as_chadan']) : array();
			$chadan_count = count($chadan_list);

			// 차단회원글 제외
			if ($chadan_count)
				$is_chadan = true;
		}

		if(!$bo_table || count($board_cnt) > 1 || $wset['bo_except']) {

			// 정렬
			$sql_orderby .= na_sql_sort('new', $wset['sort']);

			// 회원글
			$sql_where .= na_sql_find('a.mb_id', $wset['mb_list'], $wset['mb_except']);

			// 차단회원글
			if($is_chadan)
				$sql_where .= na_sql_find('a.mb_id', trim($member['as_chadan']), 1);

			// 추출게시판 정리
			list($plus, $minus) = na_bo_list($wset['gr_list'], $wset['gr_except'], $wset['bo_list'], $wset['bo_except']);
			$sql_where .= na_sql_find('a.bo_table', $plus, 0);
			$sql_where .= na_sql_find('a.bo_table', $minus, 1);

			// 기간(일수,today,yesterday,month,prev)
			$sql_where .= na_sql_term($term, 'a.bn_datetime');

			// 댓글
			$sql_where .= ($wset['wr_comment']) ? " and a.wr_is_comment = '1'" : " and a.wr_is_comment = '0'";

			// 이미지
			$sql_where .= ($wset['wr_image']) ? " and a.wr_image <> ''" : "";

			// 유튜브
			$sql_where .= ($wset['wr_video']) ? " and a.wr_video <> ''" : "";

			// 비밀글
			$sql_where .= ($wset['wr_secret']) ? "" : " and a.wr_is_secret = '0'";

			// 잠금글
			$sql_where .= ($wset['wr_singo']) ? "" : " and a.wr_singo != 'lock'";

			// 공통쿼리
			$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b where a.bo_table = b.bo_table and b.bo_use_search = 1 $sql_where ";
			if($page > 1) {
				$total = sql_fetch("select count(*) as cnt $sql_common ");
				$total_count = $total['cnt'];
				$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
				$start_rows = ($page - 1) * $rows; // 시작 열을 구함
			}

			$result = sql_query(" select a.bo_table, a.wr_id, b.bo_subject $sql_common order by $sql_orderby limit $start_rows, $rows ", true);
			if($result) {

				for ($i=$i_start; $row=sql_fetch_array($result); $i++) {

					$tmp_write_table = $g5['write_prefix'] . $row['bo_table']; 

					$wr = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");
					
					$wr['bo_table'] = $row['bo_table'];
					$wr['bo_subject'] = $row['bo_subject'];

					$list[$i] = na_wr_row($wr, $wset);
				}
			}

		} else { //단수

			// 정렬
			$sql_orderby .= na_sql_sort('bo', $wset['sort']);

			// 회원글
			$sql_where .= na_sql_find('mb_id', $wset['mb_list'], $wset['mb_except']);

			// 차단회원글
			if($is_chadan)
				$sql_where .= na_sql_find('mb_id', trim($member['as_chadan']), 1);

			// 기간(일수,today,yesterday,month,prev)
			$sql_where .= na_sql_term($term, 'wr_datetime');

			// 분류
			$sql_where .= na_sql_find('ca_name', $wset['ca_list'], $wset['ca_except']);

			// 이미지
			$sql_where .= ($wset['wr_image']) ? " and wr_10 <> ''" : "";

			// 유튜브
			$sql_where .= ($wset['wr_video']) ? " and wr_9 <> ''" : "";

			// 비밀글
			$sql_where .= ($wset['wr_secret']) ? "" : na_sql_find('wr_option', 'secret', 1);

			// 잠금글
			$sql_where .= ($wset['wr_singo']) ? "" : " and wr_7 <> 'lock'";

			// 댓글
			$wr_comment = ($wset['wr_comment']) ? 1 : 0;

			$tmp_write_table = $g5['write_prefix'] . $bo_table;

			$sql_common = "from $tmp_write_table where wr_is_comment = '$wr_comment' $sql_where";

			if($page > 1) {
				$total = sql_fetch("select count(*) as cnt $sql_common ");
				$total_count = $total['cnt'];
				$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
				$start_rows = ($page - 1) * $rows; // 시작 열을 구함
			}
			$result = sql_query(" select * $sql_common order by $sql_orderby limit $start_rows, $rows ");
			if($result) {
				for ($i=$i_start; $row=sql_fetch_array($result); $i++) { 

					$row['bo_table'] = $bo_table;

					$list[$i] = na_wr_row($row, $wset);
				}
			}
		}
	}

	// 캐싱
	if($is_cache > 0) {
		$caches = array('list' => $list);
		g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
	}

	return $list;
}

// 회원추출
function na_member_rows($wset) {
	global $g5;

	$caches = false;
	$is_cache = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	if($is_cache > 0) {
		$caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
	}

	// 캐시값 넘김
	if(isset($caches['list']) && is_array($caches['list']))
		return $caches['list'];

	$list = array();

	$rows = isset($wset['rows']) ? (int)$wset['rows'] : 0;
	$rows = ($rows > 0) ? $rows : 7;

	$mode = isset($wset['mode']) ? $wset['mode'] : '';

	$wset['term'] = isset($wset['term']) ? $wset['term'] : '';
	$wset['dayterm'] = isset($wset['dayterm']) ? (int)$wset['dayterm'] : 0;
	$term = ($wset['term'] == 'day' && (int)$wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];

	$wset['mb_list'] = isset($wset['mb_list']) ? $wset['mb_list'] : '';
	$sql_mb = na_sql_find('mb_id', $wset['mb_list'], 1);

	if($mode == 'connect') { // 현재접속회원
		$sql = " select * from {$g5['login_table']} where mb_id <> '' $sql_mb order by lo_datetime desc ";

	} else if($mode == 'post' || $mode == 'comment') { // 글,댓글 등록수
		$sql_term = na_sql_term($term, 'bn_datetime');
		$sql_wr = ($mode == 'comment') ? "and wr_parent <> wr_id" : "and wr_parent = wr_id";
		$sql = " select mb_id, count(mb_id) as cnt from {$g5['board_new_table']} 
					where mb_id <> '' $sql_wr $sql_mb $sql_term group by mb_id order by cnt desc limit 0, $rows ";

	} else if($term && $mode == 'point') { // 포인트(기간설정)
		$sql_term = na_sql_term($term, 'po_datetime');
		$sql = " select mb_id, sum(po_point) as cnt from {$g5['point_table']} 
					where po_point > 0 $sql_mb $sql_term group by mb_id order by cnt desc limit 0, $rows ";

	} else if($term && $mode == 'exp') { // 경험치(기간설정)
		$sql_term = na_sql_term($term, 'xp_datetime');
		$sql = " select mb_id, sum(xp_point) as cnt from {$g5['na_xp']} 
					where 1 $sql_mb $sql_term group by mb_id order by cnt desc limit 0, $rows ";

	} else {
		$field = 'mb_point';
		switch($mode) {
			case 'exp'		: $field = 'as_exp'; $orderby = 'as_exp desc'; break; //경험치
			case 'new'		: $orderby = 'mb_datetime desc'; break; //신규가입
			case 'recent'	: $orderby = 'mb_today_login desc'; break; //최근접속
			default			: $orderby = 'mb_point desc'; break; //포인트(기본값)
		}
		$sql = "select *, $field as cnt from {$g5['member_table']} where mb_leave_date = '' and mb_intercept_date = '' $sql_mb order by $orderby limit 0, $rows ";
	}

	$result = sql_query($sql);
	if($result) {
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = ($row['mb_id'] && $row['mb_nick']) ? $row : get_member($row['mb_id']);
			$list[$i]['cnt'] = $row['cnt'];
			if(!$list[$i]['mb_open']) {
				$list[$i]['mb_email'] = '';
				$list[$i]['mb_homepage'] = '';
			}
			$list[$i]['name'] = get_sideview($list[$i]['mb_id'], $list[$i]['mb_nick'], $list[$i]['mb_email'], $list[$i]['mb_homepage']);
		}
	}

	// 캐싱
	if($is_cache > 0) {
		$caches = array('list' => $list);
		g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
	}

	return $list;
}

// 인기검색어 추출
function na_popular_rows($wset) {
	global $g5;

	$caches = false;
	$is_cache = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	if($is_cache > 0) {
		$caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
	}

	// 캐시값 넘김
	if(isset($caches['list']) && is_array($caches['list']))
		return $caches['list'];

	$list = array();

	$rows = isset($wset['rows']) ? (int)$wset['rows'] : 0;
	$rows = ($rows > 0) ? $rows : 10;

	$wset['term'] = isset($wset['term']) ? $wset['term'] : '';
	$wset['dayterm'] = isset($wset['dayterm']) ? (int)$wset['dayterm'] : 0;
	$term = ($wset['term'] == 'day' && (int)$wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];
	$sql_term = na_sql_term($term, 'pp_date');

	// 한글이 포함된 검색어만
	$wset['han'] = isset($wset['han']) ? $wset['han'] : '';
	$sql_han = ($wset['han']) ? "and pp_word regexp '[가-힣]'" : '';
	$sql = " select pp_word, count(pp_word) as cnt from {$g5['popular_table']} where (1) $sql_term $sql_han group by pp_word order by cnt desc limit 0, $rows ";
	$result = sql_query($sql);
	if($result) {
		for ($i=0; $row=sql_fetch_array($result); $i++) { 
			$list[$i] = $row;
		}
	}

	// 캐싱
	if($is_cache > 0) {
		$caches = array('list' => $list);
		g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
	}

	return $list;
}

// 태그추출
function na_tag_rows($wset) {
	global $g5;

	$caches = false;
	$is_cache = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	if($is_cache > 0) {
		$caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
	}

	// 캐시값 넘김
	if(isset($caches['list']) && is_array($caches['list']))
		return $caches['list'];

	$list = array();

	$rows = isset($wset['rows']) ? (int)$wset['rows'] : 0;
	$rows = ($rows > 0) ? $rows : 10;

	$wset['new'] = isset($wset['new']) ? (int)$wset['new'] : 0;
	$orderby = ($wset['new'] > 0) ? "lastdate desc," : "";
	$result = sql_query(" select * from {$g5['na_tag']} where cnt > 0 order by $orderby cnt desc, type, idx, tag limit 0, $rows ");
	if($result) {
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list[$i] = $row;
			$list[$i]['href'] = G5_BBS_URL.'/tag.php?q='.urlencode($row['tag']);
		}
	}

	// 캐싱
	if($is_cache > 0) {
		$caches = array('list' => $list);
		g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
	}

	return $list;
}

// 태그 관련글 추출
function na_tag_post_rows($wset) {
	global $g5;

	$caches = false;
	$is_cache = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	if($is_cache > 0) {
		$caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
	}

	// 캐시값 넘김
	if(isset($caches['list']) && is_array($caches['list']))
		return $caches['list'];

	$list = array();

	$tag = isset($wset['tag']) ? $wset['tag'] : '';

	if(!$tag)
		return $list;	

	$rows = isset($wset['rows']) ? (int)$wset['rows'] : 0;
	$rows = ($rows > 0) ? $rows : 7;
	$page = isset($wset['page']) ? (int)$wset['page'] : 0;
	$page = ($page > 1) ? $page : 1;


	$wset['term'] = isset($wset['term']) ? $wset['term'] : '';
	$wset['dayterm'] = isset($wset['dayterm']) ? (int)$wset['dayterm'] : 0;
	$term = ($wset['term'] == 'day' && (int)$wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];

	$wset['bo_list'] = isset($wset['bo_list']) ? $wset['bo_list'] : '';
	$wset['bo_except'] = isset($wset['bo_except']) ? $wset['bo_except'] : '';
	$wset['gr_list'] = isset($wset['gr_list']) ? $wset['gr_list'] : '';
	$wset['gr_except'] = isset($wset['gr_except']) ? $wset['gr_except'] : '';
	$wset['mb_list'] = isset($wset['mb_list']) ? $wset['mb_list'] : '';
	$wset['mb_except'] = isset($wset['mb_except']) ? $wset['mb_except'] : '';

	// 회원글
	$sql_mb = na_sql_find('mb_id', $wset['mb_list'], $wset['mb_except']);

	// 추출게시판 정리
	list($plus, $minus) = na_bo_list($wset['gr_list'], $wset['gr_except'], $wset['bo_list'], $wset['bo_except']);
	$sql_plus = na_sql_find('bo_table', $plus, 0);
	$sql_minus = na_sql_find('bo_table', $minus, 1);

	// 기간(일수,today,yesterday,month,prev)
	$sql_term = na_sql_term($term, 'lastdate');

	$start_rows = 0;

	// 공통쿼리
	$sql_common = " from {$g5['na_tag_log']} where bo_table <> '' and find_in_set(tag, '{$tag}') $sql_plus $sql_minus $sql_mb $sql_term group by bo_table, wr_id ";

	if($page > 1) {
		$total = sql_query(" select count(*) as cnt $sql_common ", false);
		$total_count = @sql_num_rows($total);
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}

	$result = sql_query(" select bo_table, wr_id $sql_common order by regdate desc limit $start_rows, $rows ");
	if($result) {
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			$tmp_write_table = $g5['write_prefix'] . $row['bo_table']; 

			$wr = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");
			
			$wr['bo_table'] = $row['bo_table'];

			$list[$i] = na_wr_row($wr, $wset);
		}
	}

	// 캐싱
	if($is_cache > 0) {
		$caches = array('list' => $list);
		g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
	}

	return $list;
}

// FAQ 추출
function na_faq_rows($wset) {
	global $g5;

	$caches = false;
	$is_cache = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	if($is_cache > 0) {
		$caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
	}

	// 캐시값 넘김
	if(isset($caches['list']) && is_array($caches['list']))
		return $caches['list'];

	$list = array();

	$rows = isset($wset['rows']) ? (int)$wset['rows'] : 0;
	$rows = ($rows > 0) ? $rows : 7;

	$wset['fa_list'] = isset($wset['fa_list']) ? $wset['fa_list'] : '';
	$wset['except'] = isset($wset['except']) ? $wset['except'] : '';

	$sql_fa = na_sql_find('fm_id', $wset['fa_list'], $wset['except']);

	$result = sql_query(" select * from {$g5['faq_table']} where 1 $sql_fa order by fa_order, fa_id limit 0, $rows ");
	if($result) {
		for ($i=0; $row=sql_fetch_array($result); $i++) { 
			$list[$i] = $row;
			$list[$i]['subject'] = get_text($row['fa_subject']);
			$list[$i]['content'] = conv_content($row['fa_content'], 1);
			$list[$i]['href'] = G5_BBS_URL.'/faq.php?fm_id='.$row['fm_id'];
		}
	}

	// 캐싱
	if($is_cache > 0) {
		$caches = array('list' => $list);
		g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
	}

	return $list;
}

//=====================================================================
// 영카트 쇼핑몰
//=====================================================================

// 배너 추출
function na_shop_banner_rows($wset) {
    global $g5;

	if(!IS_YC) {
		return array('error'=>NA_YC);
	}

	$device = (G5_IS_MOBILE) ? 'mobile' : 'pc';

	$caches = false;
	$is_cache = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	if($is_cache > 0) {
		$wset['cacheId'] = $wset['cacheId'].md5($device);
		$caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
	}

	// 캐시값 넘김
	if(isset($caches['list']) && is_array($caches['list']))
		return $caches['list'];

	$list = array();

	// 위치
	$position = (isset($wset['position']) && $wset['position'] == '메인') ? '메인' : '왼쪽';

	// 접속기기
	$sql_device = " and (bn_device = 'both' or bn_device = '".$device."') ";

	// 배너 출력
    $sql = " select * from {$g5['g5_shop_banner_table']} 
						where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time $sql_device and bn_position = '$position' 
						order by bn_order, bn_id desc ";
	$result = sql_query($sql);
	$i = 0;
	for ($j=0; $row=sql_fetch_array($result); $j++) {

		$bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];

		if (!is_file($bimg))
			continue;

		$list[$i] = $row;
		$list[$i]['bn_img'] = G5_DATA_URL.'/banner/'.$row['bn_id'].'?'.preg_replace('/[^0-9]/i', '', $row['bn_time']);
		if(strpos($row['bn_url'], '#') !== false) {
			$list[$i]['bn_url'] = $row['bn_url'];
		} else {
			$list[$i]['bn_url'] = ($row['bn_url'] && $row['bn_url'] != 'http://') ? G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'] : '';
		}

		$i++;
	}

	// 캐싱
	if($is_cache > 0) {
		$caches = array('list' => $list);
		g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
	}

	return $list;
}

function na_item_type_sql($wset, $tbl='') {

	$type = array();

	for($i=1; $i < 6; $i++) {
		if(!isset($wset['type'.$i]) || !$wset['type'.$i])
			continue;

		$type[] = $tbl."it_type".$i." = '1'";
	}

	$sql = count($type) > 0 ? " and ( ".implode(" or ", $type)." )" : "";

	return $sql;
}

function na_item_category_sql($ca_list, $tbl='', $count=3) {

	if (!$ca_list)
		return;

	$ca = array();
	$cas = na_explode(',', $ca_list);
	for($i=0; $i < $count; $i++) {
		if(!isset($cas[$i]) || !$cas[$i])
			continue;

		$ca_id = $cas[$i];	
		$ca[] = "(".$tbl."ca_id like '".$ca_id."%' or ".$tbl."ca_id2 like '".$ca_id."%' or ".$tbl."ca_id3 like '".$ca_id."%')";
	}

	$sql = count($ca) > 0 ? " and ( ".implode(" or ", $ca)." )" : "";

	return $sql;
}

// 아이템 정리
function na_it_data($row) {

	$row['img'] = na_it_img($row['it_id'], $row);
	$row['href'] = shop_item_url($row['it_id']);
	$row['icon'] = item_icon($row);
	$row['name'] = get_text(stripslashes($row['it_name']));
	$row['cur_price'] = $row['it_cust_price'] ? display_price($row['it_cust_price']) : '';
	$row['price'] = display_price(get_price($row), $row['it_tel_inq']);
	$row['content'] = ($row['it_basic']) ? na_get_text($row['it_basic']) : cut_str(na_get_text($row['it_explan']), 100);
	$row['star'] = $row['it_use_avg'] ? na_star($row['it_use_avg']) : '';
	$row['star_score'] = (int)get_star($row['it_use_avg']);
	$row['soldout'] = is_soldout($row['it_id'], true);

	return $row;
}

// 후기 정리
function na_is_data($row, $thumb_w=800) {

	$imgs = get_editor_image($row['is_content'], false);
	$row['img'] = isset($imgs[1][0]) ? $imgs[1][0] : '';
	$row['name'] = get_text($row['is_name']);
	$row['subject'] = conv_subject($row['is_subject'], 255, '…');
	$row['content'] = get_view_thumbnail(conv_content($row['is_content'], 1), $thumb_w);
	$row['star_score'] = (int)get_star($row['is_score']);
	$row['star'] = na_star($row['star_score']);
	$row['re_name'] = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
	$row['re_subject'] = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'], 255, '…') : '';
	$row['re_content'] = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumb_w) : '';
	$row['hash'] = md5($row['is_id'].$row['is_time'].$row['is_ip']);

	return $row;
}

// 문의 정리
function na_iq_data($row, $thumb_w=600, $realtime=true) {
	global $is_admin, $member;

	$is_secret = false;
	if($row['iq_secret']) {
		if($realtime && ($is_admin || $member['mb_id' ] == $row['mb_id'])) {
			;
		} else {
			$is_secret = true;
			$row['question'] = $row['iq_question'] = '비밀글로 보호된 문의입니다.';
			$row['img'] = $row['answer'] = '';
		}
	} 

	if (!$is_secret) {
		$content = conv_content($row['iq_question'], 1);
		$imgs = get_editor_image($content, false);
		$row['img'] = isset($imgs[1][0]) ? $imgs[1][0] : '';
		$row['question'] = get_view_thumbnail($content, $thumb_w);
		$row['answer'] = $row['iq_answer'] ? get_view_thumbnail(conv_content($row['iq_answer'], 1), $thumb_w) : '';
	}

	$row['name'] = get_text($row['iq_name']);
	$row['subject'] = conv_subject($row['iq_subject'], 255, '…');
	$row['hash'] = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);

	return $row;
}

// 이벤트 정리
function na_ev_data($row) {
	global $g5;

	$row['name'] = get_text($row['ev_subject']);
	$row['href'] = G5_SHOP_URL.'/event.php?ev_id='.$row['ev_id'];

	$event_img = G5_DATA_PATH.'/event/'.$row['ev_id'].'_m'; // 이벤트 이미지
	$row['img'] = is_file($event_img) ? $event_img : '';

	$row1 = sql_fetch(" select count(*) as cnt from `{$g5['g5_shop_event_item_table']}` where ev_id = '{$row['ev_id']}' ");
	$row['item'] = isset($row1['cnt']) ? $row1['cnt'] : 0;

	return $row;
}

// 아이템 추출
function na_item_rows($wset) {
	global $g5;

	if(!IS_YC) {
		return array('error'=>NA_YC);
	}

	$caches = false;
	$is_cache = isset($wset['cache']) ? (int)$wset['cache'] : 0;
	if($is_cache > 0) {
		$caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
	}

	// 캐시값 넘김
	if(isset($caches['list']) && is_array($caches['list']))
		return $caches['list'];

	$list = array();

	$wset['it_list'] = isset($wset['it_list']) ? $wset['it_list'] : '';

	// 상품지정시
	if($wset['it_list']) {
		$it_list = na_explode(',', $wset['it_list']);
		$wset['rows'] = count($lt_list);
		$wset['page'] = 1;

		// 상품지정
		$sql_where .= na_sql_find('it_id', $wset['it_list']);
		
		// 정렬
		$sql_orderby .= 'it_order, it_id desc';

	} else {

		$rows = isset($wset['rows']) ? (int)$wset['rows'] : 0;
		$rows = ($rows > 0) ? $rows : 12;
		$page = isset($wset['page']) ? (int)$wset['page'] : 0;
		$page = ($page > 1) ? $page : 1;

		//정리
		$wset['ca_list'] = isset($wset['ca_list']) ? $wset['ca_list'] : '';
		$wset['sort'] = isset($wset['sort']) ? $wset['sort'] : '';
		$wset['term'] = isset($wset['term']) ? $wset['term'] : '';
		$wset['dayterm'] = isset($wset['dayterm']) ? (int)$wset['dayterm'] : 0;
		$term = ($wset['term'] == 'day' && $wset['dayterm'] > 0) ? $wset['dayterm'] : $wset['term'];

		$sql_where = (isset($wset['where']) && $wset['where']) ? 'and '.$wset['where'] : '';
		$sql_orderby = (isset($wset['orderby']) && $wset['orderby']) ? $wset['orderby'].',' : '';

		// 타입
		$sql_where .= na_item_type_sql($wset);

		// 분류
		$sql_where .= na_item_category_sql($wset['ca_list']);

		// 기간(일수,today,yesterday,month,prev)
		$sql_where .= na_sql_term($term, 'it_time');

		// 정렬
		$sql_orderby .= na_sql_sort('it', $wset['sort']);
	}

	$start_rows = 0;

	$sql_common = "from {$g5['g5_shop_item_table']} where it_use = '1' and it_soldout <> '1' $sql_where";
	if($page > 1) {
		$total = sql_fetch("select count(*) as cnt $sql_common ");
		$total_count = $total['cnt'];
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
		$start_rows = ($page - 1) * $rows; // 시작 열을 구함
	}

	$result = sql_query(" select *  $sql_common order by $sql_orderby limit $start_rows, $rows ");
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$list[$i] = na_it_data($row);
	}

	// 캐싱
	if($is_cache > 0) {
		$caches = array('list' => $list);
		g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
	}

	return $list;
}
