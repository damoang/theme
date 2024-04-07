<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// UTF-8 확장 커스텀 함수 - http://jmnote.com/wiki/Utf8_ord
function na_utf8_ord($ch) {
	$len = strlen($ch);
	if($len <= 0) return false;
	$h = ord($ch[0]);
	if($h <= 0x7F) return $h;
	if($h < 0xC2) return false;
	if($h <= 0xDF && $len>1) return ($h & 0x1F) <<  6 | (ord($ch[1]) & 0x3F);
	if($h <= 0xEF && $len>2) return ($h & 0x0F) << 12 | (ord($ch[1]) & 0x3F) << 6 | (ord($ch[2]) & 0x3F);
	if($h <= 0xF4 && $len>3) return ($h & 0x0F) << 18 | (ord($ch[1]) & 0x3F) << 12 | (ord($ch[2]) & 0x3F) << 6 | (ord($ch[3]) & 0x3F);
	return false;
}

 // UTF-8 한글 초성 추출 - http://jmnote.com/wiki/UTF-8_%ED%95%9C%EA%B8%80_%EC%B4%88%EC%84%B1_%EB%B6%84%EB%A6%AC_(PHP)
function na_chosung($str) {

	$result = array();

	//$cho = array("가","까","나","다","따","라","마","바","빠","사","싸","아","자","짜","차","카","타","파","하");
	//$cho = array("ㄱ","ㄲ","ㄴ","ㄷ","ㄸ","ㄹ","ㅁ","ㅂ","ㅃ","ㅅ","ㅆ","ㅇ","ㅈ","ㅉ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ");
	//$cho = array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18");

	$cho = array("가","가","나","다","다","라","마","바","바","사","사","아","자","자","차","카","타","파","하");
	$str = mb_substr($str,0,1,"UTF-8");
	$code = na_utf8_ord($str) - 44032;
	if ($code > -1 && $code < 11172) {
		$cho_idx = $code / 588;
		$result[0] = 0; //한글
		$result[1] = $cho[$cho_idx];
	} else {
		$str = strtoupper($str); //대문자로 변경
		if(preg_match("/[0-9]+/i", $str)) {
			$result[0] = 2; //숫자
			$result[1] = $str;
		} else if(preg_match("/[A-Z]+/i", $str)) {
			$result[0] = 1; //영어
			$result[1] = $str;
		} else {
			$result[0] = 3; //특수문자
			$result[1] = addslashes($str);
		}
	}

	return $result;
}

// Check Tag
function na_check_tag($tag) {

	$tag = str_replace(array("\"", "'"), array("", ""), na_get_text($tag));

	if(!$tag) 
		return;
	
	$list = array();
	$arr = na_explode(',', $tag);
	foreach($arr as $tmp) {
		if(!$tmp) 
			continue;

		$list[] = $tmp;
	}

	if(count($list) == 0) 
		return;

	$list = array_unique($list);

	$str = implode(',', $list);

	return $str;
}

// Delete Tag
function na_delete_tag($bo_table, $wr_id='') {
    global $g5;

	if($bo_table && $wr_id) {
	    $result = sql_query("select tag_id from {$g5['na_tag_log']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
		if($result) {
			while ($row = sql_fetch_array($result)) {
				sql_query("update {$g5['na_tag']} set cnt = cnt - 1 where id = '{$row['tag_id']}'");
			}
			sql_query("delete from {$g5['na_tag_log']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}'");
		}
	} else if($bo_table) {
	    $result = sql_query("select tag_id from {$g5['na_tag_log']} where bo_table = '{$bo_table}' ");
		if($result) {
			while ($row = sql_fetch_array($result)) {
				sql_query("update {$g5['na_tag']} set cnt = cnt - 1 where id = '{$row['tag_id']}'");
			}
			sql_query("delete from {$g5['na_tag_log']} where bo_table = '{$bo_table}'");
		}
	}

	return;
}

// Add Tag
function na_add_tag($it_tag, $bo_table, $wr_id='', $mb_id='') {
    global $g5;

	$arr = array();

	// 기존 태그 삭제
	na_delete_tag($bo_table, $wr_id);

	// 태그정리
	$it_tag = na_check_tag($it_tag);

	if(!$it_tag) 
		return;

	// 카운팅이 0 또는 음수인 태그 삭제
	sql_query("delete from {$g5['na_tag']} where cnt <= '0'");

	// 태그등록
	$tags = array_map('trim', explode(',', $it_tag));
	foreach($tags as $tag) {
		$row = sql_fetch("select id from {$g5['na_tag']} where tag = '{$tag}' ");
		if (isset($row['id']) && $row['id']) {
			$tag_id = $row['id'];
			sql_query("update {$g5['na_tag']} set cnt = cnt + 1, lastdate='".G5_TIME_YMDHIS."' where id='{$tag_id}'");
		} else {
			//색인 만들기
			list($type, $idx) = na_chosung($tag);
			sql_query("insert into {$g5['na_tag']} set type = '{$type}', idx = '{$idx}', tag='".addslashes($tag)."', cnt=1, regdate='".G5_TIME_YMDHIS."', lastdate='".G5_TIME_YMDHIS."'");
			$tag_id = sql_insert_id();
		} 

		sql_query(" insert into {$g5['na_tag_log']} set bo_table = '{$bo_table}', wr_id = '{$wr_id}', tag_id = '{$tag_id}', tag = '".addslashes($tag)."', mb_id = '{$mb_id}', regdate = '".G5_TIME_YMDHIS."' ");
	}

	return $it_tag;
}

// Get Tag
function na_get_tag($it_tag) {

	$it_tag = na_get_text($it_tag);

	if(!$it_tag) 
		return;

	$tags = array();
	$tags = array_map('trim', explode(",", $it_tag));

	$i = 0;
	$str = '';
	foreach($tags as $tag) {
		if($i > 0)
			$str .= ', ';

		$str .= '<a href="'.G5_BBS_URL.'/tag.php?q='.urlencode($tag).'" rel="tag">#'.$tag.'</a>';
		$i++;
	}

	return $str;
}
