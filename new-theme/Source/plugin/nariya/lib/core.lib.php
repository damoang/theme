<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// DB SET
function na_db_set() {

	$engine = '';
	if(in_array(strtolower(G5_DB_ENGINE), array('innodb', 'myisam'))){
		$engine = 'ENGINE='.G5_DB_ENGINE;
	}

	$charset = 'CHARSET=utf8';
	if(G5_DB_CHARSET !== 'utf8'){
		 $charset = 'CHARACTER SET '.get_db_charset(G5_DB_CHARSET);
	}

	return $engine.' DEFAULT '.$charset;
}

// 랜덤아이디 생성
function na_rid($length=20) {
    
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

	return substr(str_shuffle($chars), 0, $length);
}

// 파일명 체크
function na_fid($file) {

    $file = preg_replace('/[^-A-Za-z0-9_]/i', '', trim($file));
    $file = substr($file, 0, 100);

	return $file;
}

// 아이디 체크
function na_check_id($id) {
    if (preg_match("/[^-A-Za-z0-9_]+/i", $id))
        return false;
    else
        return true;
}

// 태그 속성 분리
function na_query($str) {

	$arr = array();

    if (function_exists('array_combine')) {
		$str = stripcslashes($str);

		preg_match_all('@(?P<attribute>[^\s\'\"]+)\s*=\s*(\'|\")?(?P<value>[^\s\'\"]+)(\'|\")?@i', $str, $match);

		$arr = @array_change_key_case(array_combine($match['attribute'], $match['value']));
	}

	return $arr;
}

// Sort Array
function na_sort($arr, $field, $rev=false) {

	if(!is_array($arr) || !count($arr)) return;

	foreach($arr as $res)
		$sort[] = $res[$field];

	($rev) ? array_multisort($sort, SORT_DESC, $arr) : array_multisort($sort, SORT_ASC, $arr);

	return $arr;
}

// 저장 파일 삭제
function na_file_delete($file) {

	if($file && is_file($file)) {
		@chmod($file, G5_FILE_PERMISSION);
		@unlink($file);
	}

	return;
}

// 파일에 저장된 변수 불러오기
function na_file_var_load($file) {

	$data = array();
	if($file && is_file($file))
		@include($file);

	return array_map_deep('stripslashes', $data);
}

// 파일에 변수 저장하기
function na_dir_file($file) {

	if(!$file) 
		return false;

	$dir = dirname($file);
	if(is_dir($dir)) {
		if(is_file($file)) {
			@chmod($file, G5_FILE_PERMISSION);
			@unlink($file);
		}
	} else {
		umask(0);
	    if(!mkdir($dir, G5_DIR_PERMISSION, true)){
	      return false;
		}
    } 

	return true;
}

// 파일 확장자
function na_file_info($str) {

	$file = array();

	$str = basename($str);
	$f = explode(".", $str);
	$l = sizeof($f);
	if($l > 1) {
		$file['ext'] = strtolower($f[$l-1]);
		$file['name'] = str_replace($f[$l-1], "", $str);
	} else {
		$file['ext'] = '';
		$file['name'] = $str;
	}

	return $file;	
}

// 파일에 변수 저장하기
function na_file_var_save($file, $data) {

	if(!$file) 
		return;

	// php 파일만 허용
	$info = na_file_info($file);
	if($info['ext'] != 'php')
		return;

	// 파일 기록
	if(na_dir_file($file)) {
		$handle = fopen($file, 'w');
		$content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$data=".var_export($data, true).";";
		fwrite($handle, $content);
		fclose($handle);
	}

	return;
}

// URL 치환
function na_url($url, $rev='') {

	$url = ($rev) ? str_replace(G5_URL.'/', "./", str_replace(NA_DATA_URL.'/', "../", $url)) : str_replace("./", G5_URL.'/', str_replace("../", NA_DATA_URL.'/', $url));
	
	return $url;
}

// PATH 치환
function na_path($url, $rev='') {

	$url = $rev ? str_replace(G5_PATH.'/', "./", $url) : str_replace("./", G5_PATH.'/', $url);

	return $url;
}

// 문자열을 배열로 전환
function na_explode($stx, $str) {
	return ($stx && $str) ? array_map('trim', explode($stx, $str)) : array();
}

// 나리야 설정값
function na_config() {

	$init = array();
	$init = na_file_var_load(NA_PATH.'/lib/init.lib.php');

	$data = array();
	$data = na_file_var_load(G5_DATA_PATH.'/nariya/nariya.php');

	return array_merge($init, $data);
}

// 게시판 등 스킨 설정값
function na_skin_config($skin, $opt='') {

	$data = array();
	if($skin) {
		$type = (G5_IS_MOBILE) ? 'mo' : 'pc';
		$file_name = ($opt) ? 'board/board-'.$opt : 'skin/skin-'.$skin;
		$file = G5_DATA_PATH.'/nariya/'.$file_name.'-'.$type.'.php';
		$data = na_file_var_load($file);
	}

	return $data;
}

function na_htmlspecialchars($str, $rev=false) {

	return ($rev) ? htmlspecialchars_decode(trim($str)) : htmlspecialchars(trim($str), ENT_COMPAT);
}

// Get Text
function na_get_text($str) {

	$str = strip_tags(preg_replace("/(<(script|style)\b[^>]*>).*?(<\/\2>)/is", "", $str));
	$str = preg_replace("/{(첨부|attach)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(지도|map)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(이미지|img)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(동영상|video)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(아이콘|icon)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/{(이모티콘|emo)\:([^}]*)}/is", "", $str);
	$str = preg_replace("/\[soundcloud([^\]]*)\]/is", "", $str);
	$str = preg_replace("/\[code=([^\]]*)\]/is", "", $str);
	$str = str_replace(array("&nbsp;", "[code]", "[/code]", "[map]", "[/map]"), array("", "", "", "", ""), $str);
	$str = preg_replace("/\s\s+/", " ", $str);
	$str = trim($str);

	return $str;
}

// Cut Text
function na_cut_text($str, $len, $sfx="…") {

	$str = cut_str(na_get_text($str), $len, $sfx);

	return $str;
}

// Skin Path
function na_skin_path($dir, $skin) {
    global $config;

    if(preg_match('#^theme/(.+)$#', $skin, $match)) { // 테마에 포함된 스킨이라면
        $theme_path = '';
        $cf_theme = trim($config['cf_theme']);

        $theme_path = G5_PATH.'/'.G5_THEME_DIR.'/'.$cf_theme;
        $skin_path = $theme_path.'/'.G5_SKIN_DIR.'/'.$dir.'/'.$match[1];
    } else {
        $skin_path = G5_SKIN_PATH.'/'.$dir.'/'.$skin;
    }

    return $skin_path;
}

// Skin url
function na_skin_url($dir, $skin) {
    return str_replace(G5_PATH, G5_URL, na_skin_path($dir, $skin));
}

// 스킨경로를 얻는다
function na_dir_list($path, $len='') {

    $arr = array();

	if(!is_dir($path)) 
		return $arr;

	$handle = opendir($path);
    while ($file = readdir($handle)) {
        if($file == "."||$file == "..") continue;

        if(is_dir($path.'/'.$file)) 
			$arr[] = $file;
    }
    closedir($handle);
    sort($arr);

    return $arr;
}

// 폴더내 파일을 얻는다
function na_file_list($path, $ext='') {

	$arr = array();

	if(!is_dir($path)) 
		return $arr;

	$handle = opendir($path);
	while ($file = readdir($handle)) {

		if($file == "."||$file == "..")
			continue;

		if($ext) {
			$tmp = strtolower(substr(strrchr($file, "."), 1)); 
			if($tmp == $ext) {
				$arr[] = substr($file, 0, strrpos($file, "."));
			}
		} else {
			$arr[] = $file;
		}
	}
	closedir($handle);
	sort($arr);

	return $arr;
}

// 통합 등록 체크
function na_check_new($datetime) {
	global $config;
	
	if(isset($config['cf_new_del']) && $config['cf_new_del'] > 0) {
		;
	} else {
		return true;
	}

	return ($datetime >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($config['cf_new_del'] * 86400))) ? true : false;
}

// Delete
function na_delete($bo_table, $wr_id) {
	global $g5;

	// 태그 삭제
	na_delete_tag($bo_table, $wr_id);

	// 신고 삭제
	sql_query(" delete from {$g5['na_singo']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and wr_flag = '0' ");

	// 쓰기, 댓글 경험치만 삭제
	$row = sql_fetch(" select mb_id, xp_rel_action from {$g5['na_xp']}
			  where xp_rel_table = '$bo_table'
				and xp_rel_id = '$wr_id'
				and (xp_rel_action = '쓰기' or xp_rel_action = '댓글') ");

	if(isset($row['mb_id']) && $row['mb_id'])
		na_delete_xp($row['mb_id'], $bo_table, $wr_id, $row['xp_rel_action']);

}

// 자동링크
function na_url_auto_link($str){

	global $config;

	$matches = array();

    preg_match_all("/<a([^>]*)>(.*?)<\/a>/iS", $str, $matches);

	if(!isset($matches[2]) || empty($matches[2]))
		return $str;

	$m_cnt = count($matches[2]);
	for($i=0; $i < $m_cnt; $i++) {
		if(isset($matches[2][$i]) && $matches[2][$i] && preg_match("/[^가-힣<>]+/i", $matches[2][$i]) && !preg_match("/\.({$config['cf_image_extension']})$/i", $matches[2][$i])) {
			$encode = '>'.$matches[2][$i].'</';
			$decode = '>'.urldecode($matches[2][$i]).'</';
			$str = str_replace($encode, $decode, $str);
		}
	}

	return $str;
}
