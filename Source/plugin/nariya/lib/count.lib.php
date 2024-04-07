<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 게시판 분류별 글수
function na_cate_cnt($bo_table, $board, $check=0){
    global $g5;

    $list = array();

	$bo = (isset($board['bo_table']) && $board['bo_table'] === $bo_table) ? $board : get_board_db($bo_table, true);

	if (!isset($bo['bo_table']) || !$bo['bo_table'])
		return $list;

	if (!isset($bo['bo_use_category']) || !$bo['bo_use_category'])
		return $list;

	$write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

    $key = md5($bo_table.'-cate-count');

	// 캐시 : 10년
	$cache_time = 86400 * 365 * 10; 
	$caches = false;
	if(!$check){
		$caches = g5_get_cache($key, $cache_time);
		if(isset($caches['all']))
			return $caches;
	}
	
    if( $caches === false ){

		// 전체 게시물수
		$all = sql_fetch(" select count(*) as cnt from $write_table where wr_is_comment = 0 ");
		$list['all'] = isset($all['cnt']) ? $all['cnt'] : 0;

		$cates = explode('|', $board['bo_category_list']);
		$cates = array_unique($cates);
		foreach($cates as $cate => $name) {
			$row = sql_fetch(" select count(*) as cnt from $write_table where wr_is_comment = 0 and ca_name = '{$name}' ");
			$ckey = md5($name);
			$list[$ckey] = isset($row['cnt']) ? $row['cnt'] : 0;
		}

		g5_set_cache($key, $list, $cache_time);
	}

	return $list;
}

// 게시판 분류별 새 게시물수
function na_cate_new($bo_table, $board, $check=0){
    global $g5, $nariya;

	$list = array();

    $caches = false;
	$new_time = (isset($nariya['new_post']) && (int)$nariya['new_post'] > 0) ? (int)$nariya['new_post'] : 24;
	$cache_time = (isset($nariya['new_cache']) && (int)$nariya['new_cache'] > 0) ? (int)$nariya['new_cache'] : 5;
	$time_unit = 60; //분으로 고정
	$key = $bo_table.'-cate-new';
	$key = md5($key);
	if(!$check) {
		$caches = g5_get_cache($key, $cache_time * $time_unit);
		$list = isset($caches['all']) ? $caches : array();
	}

	if( $caches === false ){
		$bo = (isset($board['bo_table']) && $board['bo_table'] === $bo_table) ? $board : get_board_db($bo_table, true);

		if (!isset($bo['bo_table']) || !$bo['bo_table'])
			return $list;

		if (!isset($bo['bo_use_category']) || !$bo['bo_use_category'])
			return $list;

		$write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
		$where = "and wr_datetime >= DATE_SUB(NOW(), INTERVAL $new_time HOUR)";

		// 전체 게시물수
		$all = sql_fetch(" select count(*) as cnt from $write_table where wr_is_comment = 0 $where ");
		$list['all'] = isset($all['cnt']) ? $all['cnt'] : 0;

		$cates = explode('|', $bo['bo_category_list']);
		$cates = array_unique($cates);
		foreach($cates as $cate => $name) {
			$row = sql_fetch(" select count(*) as cnt from $write_table where wr_is_comment = 0 and ca_name = '{$name}' $where ");
			$ckey = md5($name);
			$list[$ckey] = isset($row['cnt']) ? $row['cnt'] : 0;
		}

		g5_set_cache($key, $list, $cache_time * $time_unit);
	}

	return $list;
}

// 게시판별 새 게시물수
function na_post_new($check=0) {
	global $g5, $nariya;

	$list = array();

	$key = md5('new_post');

	$new_time = (isset($nariya['new_post']) && (int)$nariya['new_post'] > 0) ? (int)$nariya['new_post'] : 24;
	$cache_time = (isset($nariya['new_cache']) && (int)$nariya['new_cache'] > 0) ? (int)$nariya['new_cache'] : 5;

	$caches = false;
	$time_unit = 60; //분으로 고정
	if(!$check) {
		$caches = g5_get_cache($key, $cache_time * $time_unit);
		$list = isset($caches['total_newpost']) ? $caches : array();
	}

	if($caches === false){
		$total_cnt = 0;
		$sql = " select bo_table, count(*) as cnt
					from {$g5['board_new_table']} 
					where wr_id = wr_parent and bn_datetime >= DATE_SUB(NOW(), INTERVAL $new_time HOUR)
					group by bo_table ";
		$result = sql_query($sql);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			if(!$row['bo_table'] || !$row['cnt'])
				continue;

			$arr_key = $row['bo_table'];
			$list[$arr_key] = $row['cnt'];
			$total_cnt = $total_cnt + $row['cnt'];
		}

		$list['total_newpost'] = $total_cnt;

		g5_set_cache($key, $list, $cache_time * $time_unit);
	}

	return $list;
}
