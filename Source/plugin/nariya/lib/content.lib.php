<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 페이지 아이디 생성
function na_pid($link='') {
	global $bo_table, $wr_id, $sca, $wr_seo_title, $gr_id, $co_id, $co_seo_title, $qstr;
	global $ca_id, $it_id, $it_seo_title, $type;

	$link = G5_URL.str_replace(G5_PATH, '', $_SERVER['SCRIPT_FILENAME']);

	$url = @parse_url(str_replace(G5_URL.'/', '', $link));
	$url['path'] = isset($url['path']) ? $url['path'] : '';
	$file = basename($url['path'],".php");

	$mid = array();
	$fid = '';
	$href = '';
	$is_pid = false;
	if(strpos($link, G5_BBS_URL) !== false) {
		if($bo_table && ($file == 'board' || $file == 'write')) {
			$fid = G5_BBS_DIR.'-board';
			$me_id = G5_BBS_DIR.'-board-'.$bo_table;
			$eq_id = array(G5_BBS_DIR, 'board', $bo_table);

			$mid[] = $me_id;

			if($sca) {
				$mid[] = $me_id.'-'.$sca;
				$eq_id[] = $sca;
			}

			$href = ($wr_id) ? get_pretty_url($bo_table, $wr_id, $qstr) : get_pretty_url($bo_table, '', $qstr);

		} else if($gr_id && $file == 'group') {

			$fid = G5_BBS_DIR.'-group';
			$mid[] = G5_BBS_DIR.'-group-'.$gr_id;
			$eq_id = array(G5_BBS_DIR, 'group', $gr_id);

		} else if($file == 'content') {

			$fid = G5_BBS_DIR.'-content';
			$eq_id = array(G5_BBS_DIR, 'content');

			if($co_id) {
				$mid[] = G5_BBS_DIR.'-content-'.$co_id;
				$eq_id[] = $co_id;
			}

			if($co_seo_title) {
				$mid[] = G5_BBS_DIR.'-content-'.$co_seo_title;
				$eq_id[] = $co_seo_title;
			}

			$href = get_pretty_url('content', $co_id);

		} else if($file == 'qalist' || $file == 'qaview' || $file == 'qawrite') {

			$fid = G5_BBS_DIR.'-qa';
			$mid[] = G5_BBS_DIR.'-qa';
			$eq_id = array(G5_BBS_DIR, 'qa');

		} else {
			$is_pid = true;
		}

	} else if(IS_YC && strpos($link, G5_SHOP_URL) !== false) {

		if($ca_id && $file == 'list') {

			$fid = G5_SHOP_DIR.'-shop-list';
			$mid[] = G5_SHOP_DIR.'-shop-list-'.$ca_id;
			$eq_id = array(G5_SHOP_DIR, 'shop', 'list', $ca_id);
			$href = add_pretty_shop_url(shop_category_url($ca_id), 'shop', $qstr);

		} else if($it_id && $file == 'item') {

			$fid = G5_SHOP_DIR.'-shop-item';
			$eq_id = array(G5_SHOP_DIR, 'shop', 'item');
			
			if($it_id) {
				$mid[] = G5_SHOP_DIR.'-shop-item-'.$it_id;
				$eq_id[] = $it_id;
			}

			if($it_seo_title) {
				$mid[] = G5_SHOP_DIR.'-shop-item-'.$it_seo_title;
				$eq_id[] = $it_seo_title;
			}

			$href = shop_item_url($it_id);

		} else if($type && $file == 'listtype') {

			$fid = G5_SHOP_DIR.'-shop-type';
			$mid[] = G5_SHOP_DIR.'-shop-type-'.$type;
			$eq_id = array(G5_SHOP_DIR, 'shop', 'type', $type);
			$href = add_pretty_shop_url(shop_type_url($type), 'shop', $qstr);

		} else {
			$is_pid = true;
		}

	} else {
		$is_pid = true;
	}

	if($is_pid) {
		$pdir = str_replace('/', '-', str_replace(basename($url['path']), '', $url['path']));
		if($pdir && substr($pdir, -1) === '-') {
			$pdir = substr($pdir, 0, -1); 
		}
		$pdir = ($pdir) ? $pdir : 'root';
		$fid = $pdir.'-page-'.$file;
		$mid[] = $fid;
		$eq_id = array($pdir, 'page', $file);
	}

	if(!$href) {
		$href = $link;
		$url = @parse_url($_SERVER['REQUEST_URI']);
		if(isset($url['query']) && $url['query']) {
			$href .= '?'.$url['query'];
		}
	}

	$pset = array('pid'=>$mid[0], 'fid'=>$fid, 'mid'=>$mid, 'uid'=>implode('-', $eq_id), 'href'=>$href, 'file'=>$file);

	return $pset;
}

// BS3 Style
function na_paging($write_pages, $cur_page, $total_page, $url, $add='') {

	$first = '<i class="bi bi-chevron-double-left"></i>';
	$prev = '<i class="bi bi-chevron-left"></i>';
	$next = '<i class="bi bi-chevron-right"></i>';
	$last = '<i class="bi bi-chevron-double-right"></i>';

    $url = preg_replace('#(&amp;)?page=[0-9]*#', '', $url);
	$url .= substr($url, -1) === '?' ? 'page=' : '&amp;page=';

	if(!$cur_page) $cur_page = 1;
	if(!$total_page) $total_page = 1;

	$str = '';
	if($first) {
		if ($cur_page < 2) {
			//$str .= '<li class="page-first page-item disabled"><a class="page-link">'.$first.'</a></li>'.PHP_EOL;
		} else {
			$str .= '<li class="page-first page-item"><a class="page-link" href="'.$url.'1'.$add.'" title="첫 페이지">'.$first.'<span class="visually-hidden">첫 페이지</span></a></li>'.PHP_EOL;
		}
	}

	$start_page = (((int)(($cur_page - 1 ) / $write_pages)) * $write_pages) + 1;
	$end_page = $start_page + $write_pages - 1;

	if ($end_page >= $total_page) { 
		$end_page = $total_page;
	}

	if ($start_page > 1) { 
		$str .= '<li class="page-prev page-item"><a class="page-link" href="'.$url.($start_page-1).$add.'" title="이전 페이지">'.$prev.'<span class="visually-hidden">이전 페이지</span></a></li>'.PHP_EOL;
	} else {
		//$str .= '<li class="page-prev page-item disabled"><a class="page-link">'.$prev.'</a></li>'.PHP_EOL; 
	}

	if ($total_page > 0){
		for ($k=$start_page;$k<=$end_page;$k++){
			if ($cur_page != $k) {
				$str .= '<li class="page-item"><a class="page-link" href="'.$url.$k.$add.'">'.$k.'</a></li>'.PHP_EOL;
			} else {
				$str .= '<li class="page-item active" aria-current="page"><a class="page-link">'.$k.'<span class="visually-hidden">페이지 현재</span>
</a></li>'.PHP_EOL;
			}
		}
	}

	if ($total_page > $end_page) {
		$str .= '<li class="page-next page-item"><a class="page-link" href="'.$url.($end_page+1).$add.'" title="다음 페이지">'.$next.'<span class="visually-hidden">다음 페이지</span></a></li>'.PHP_EOL;
	} else {
		//$str .= '<li class="page-next page-item disabled"><a class="page-link">'.$next.'</a></li>'.PHP_EOL;
	}

	if($last) {
		if ($cur_page < $total_page) {
			$str .= '<li class="page-last page-item"><a class="page-link" href="'.$url.($total_page).$add.'" title="마지막 페이지">'.$last.'<span class="visually-hidden">마지막 페이지/span></a></li>'.PHP_EOL;
		} else {
			//$str .= '<li class="page-last page-item disabled"><a class="page-link">'.$last.'</a></li>'.PHP_EOL;
		}
	}

	return $str;
}

function na_ajax_paging($id, $write_pages, $cur_page, $total_page, $url, $add='', $opt='1') {

	$first = '<i class="bi bi-chevron-double-left"></i>';
	$prev = '<i class="bi bi-chevron-left"></i>';
	$next = '<i class="bi bi-chevron-right"></i>';
	$last = '<i class="bi bi-chevron-double-right"></i>';

    $url = preg_replace('#(&amp;)?page=[0-9]*#', '', $url);
	$url .= substr($url, -1) === '?' ? 'page=' : '&amp;page=';

	if(!$cur_page) $cur_page = 1;
	if(!$total_page) $total_page = 1;

	$ajax = (isset($css) && $css) ? ' class="'.$css.'"' : ''; // Ajax용 클래스

	$str = '';
	if($first) {
		if ($cur_page < 2) {
			//$str .= '<li class="page-first page-item disabled"><a class="page-link">'.$first.'</a></li>'.PHP_EOL;
		} else {
			$str .= '<li class="page-first page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.'1'.$add.'\', \''.$opt.'\');" title="첫 페이지">'.$first.'<span class="visually-hidden">첫 페이지</span></a></li>'.PHP_EOL;
		}
	}

	$start_page = (((int)(($cur_page - 1 ) / $write_pages)) * $write_pages) + 1;
	$end_page = $start_page + $write_pages - 1;

	if ($end_page >= $total_page) { 
		$end_page = $total_page;
	}

	if ($start_page > 1) { 
		$str .= '<li class="page-prev page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.($start_page-1).$add.'\', \''.$opt.'\'); return false;" title="이전 페이지">'.$prev.'<span class="visually-hidden">이전 페이지</span></a></li>'.PHP_EOL;
	} else {
		//$str .= '<li class="page-prev page-item disabled"><a class="page-link">'.$prev.'</a></li>'.PHP_EOL; 
	}

	if ($total_page > 0){
		for ($k=$start_page;$k<=$end_page;$k++){
			if ($cur_page != $k) {
				$str .= '<li class="page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.$k.$add.'\', \''.$opt.'\'); return false;">'.$k.'</a></li>'.PHP_EOL;
			} else {
				$str .= '<li class="page-item active" aria-current="page"><a class="page-link">'.$k.'<span class="visually-hidden">페이지 현재</span></a></li>'.PHP_EOL;
			}
		}
	}

	if ($total_page > $end_page) {
		$str .= '<li class="page-next page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.($end_page+1).$add.'\', \''.$opt.'\'); return false;" title="다음 페이지">'.$next.'<span class="visually-hidden">다음 페이지</span></a></li>'.PHP_EOL;
	} else {
		//$str .= '<li class="page-next page-item disabled"><a class="page-link">'.$next.'</a></li>'.PHP_EOL;
	}

	if($last) {
		if ($cur_page < $total_page) {
			$str .= '<li class="page-last page-item"><a class="page-link" href="javascript:;" onclick="na_page(\''.$id.'\', \''.$url.($total_page).$add.'\', \''.$opt.'\'); return false;" title="마지막 페이지">'.$last.'<span class="visually-hidden">마지막 페이지</span></a></li>'.PHP_EOL;
		} else {
			//$str .= '<li class="page-last page-item disabled"><a class="page-link">'.$last.'</a></li>'.PHP_EOL;
		}
	}

	return $str;
}

// Callback
function na_callback_map($m) {
	return isset($m[2]) ? na_map($m[2]) : '';
}

function na_callback_video($m) {
	return isset($m[2]) ? na_video($m[2]) : '';
}

function na_callback_soundcloud($m) {
	return isset($m[1]) ? na_soundcloud($m[1]) : '';
}

function na_callback_icon($m) {
	return isset($m[2]) ? na_icon($m[2]) : '';
}

function na_callback_emo($m) {
	return isset($m[2]) ? na_emoticon($m[2], '') : '';
}

function na_callback_attach($m) {
	return isset($m[2]) ? na_attach($m[2]) : '';
}


// FA Icon
function na_fa($str){
	$str = ($str) ? preg_replace_callback("/{(아이콘|icon)\:([^}]*)}/is", "na_callback_icon", $str) : $str;
	return $str;
}


// Emoticon Icon
function na_emo($str){
	$str = preg_replace_callback("/{(이모티콘|emo)\:([^}]*)}/is", "na_callback_emo", $str); // Emoticon 
	return $str;
}

//Show Contents
function na_content($str) {
	$str = na_url_auto_link($str);
	$str = preg_replace_callback("/{(첨부|attach)\:([^}]*)}/is", "na_callback_attach", $str); // Attach
	$str = preg_replace_callback("/{(지도|map)\:([^}]*)}/is", "na_callback_map", $str); // Map
	$str = preg_replace_callback("/{(동영상|video)\:([^}]*)}/is", "na_callback_video", $str); // Video
	$str = preg_replace_callback("/{(아이콘|icon)\:([^}]*)}/is", "na_callback_icon", $str); // FA Icon
	$str = preg_replace_callback("/{(이모티콘|emo)\:([^}]*)}/is", "na_callback_emo", $str); // Emoticon 
	$str = preg_replace_callback("/\[soundcloud([^\]]*)\]/is", "na_callback_soundcloud", $str); // SoundCloud
	$str = preg_replace_callback("/(\[code\]|\[code=(.*)\])(.*)\[\/code\]/iUs", "na_syntaxhighlighter", $str); // SyntaxHighlighter

	return $str;
}

// 별점
function na_star($avg) {

    $avg = round($avg, 2);

	if ($avg > 5) 
		$avg = 5;
    else if ($avg < 0) 
		$avg = 0;

	$score = explode('.', $avg);
	$star_s = isset($score[0]) ? (int)$score[0] : 0;
	$star_m = isset($score[1]) ? (int)$score[1] : 0;

	$star_e = ($star_m) ? 4 - $star_s : 5 - $star_s; 

	$star = '';
	for($i=0; $i < $star_s; $i++)
		$star .= '<i class="bi bi-star-fill"></i>';

	if($star_m) 
		$star .= '<i class="bi bi-star-half"></i>';

	for($i=0; $i < $star_e; $i++)
		$star .= '<i class="bi bi-star"></i>';
	
	return $star;
}

// 확장자 종류체크
function na_ext_type($file) {

	if(!$file) 
		return;

	$video = array("mp4", "m4v", "f4v", "mov", "flv", "webm");
	$caption = array("vtt", "srt", "ttml", "dfxp");
	$audio = array("acc", "m4a", "f4a", "mp3", "ogg", "oga");
	$image = array("jpg", "jpeg", "gif", "png");
	$pdf = array("pdf");
	$torrent = array("torrent");

	$ext = strtolower(substr(strrchr($file, "."), 1)); 

	$type = 0;
	if(in_array($ext, $image)) {
		$type = 1;
	} else if(in_array($ext, $video)) {
		$type = 2;
	} else if(in_array($ext, $audio)) {
		$type = 3;
	} else if(in_array($ext, $pdf)) {
		$type = 4;
	} else if(in_array($ext, $caption)) {
		$type = 5;
	} else if(in_array($ext, $torrent)) {
		$type = 6;
	}

	return $type;
}

// Icon
function na_icon($str){

	if(!$str || $str == 'none') 
		return;

	$arr = explode(":", $str);
	$icon = isset($arr[0]) ? $arr[0] : '';
	$opt = isset($arr[1]) ? $arr[1] : '';

	$gubun = substr($icon, 0, 3); 
	if($gubun == 'bi-') {
		$str = "<i class='bi ".$icon."'></i>";
	} else if($gubun == 'fa-') {
		$str = "<i class='fa ".$icon."'></i>";
	} else {
		switch($opt) {
			case 'c' : $str = "<i class='".$icon."'></i>"; break;
			case 't' : $str = $icon; break;
			default	 : $str = "<i class='fa fa-".$icon."'></i>"; break;
		}
	}

	return $str;
}

// Emoticon
function na_emoticon($str){

	if(!$str) 
		return;

	$arr = explode(":", $str);
	$emo = isset($arr[0]) ? $arr[0] : '';
	$width = isset($arr[1]) ? (int)$arr[1] : 0;

	if($emo && is_file(NA_PATH.'/skin/emo/'.$emo)) {
		$width = ($width > 0) ? $width : 50;
		$icon = '<img src="'.NA_URL.'/skin/emo/'.$emo.'" width="'.$width.'" alt="" />';
	} else {
		$icon = '';
	}

	return $icon;
}

//Syntaxhighlighter
function na_syntaxhighlighter($m) {

	$str = isset($m[3]) ? $m[3] : '';

	if(!$str) 
		return;

	$str = stripslashes($str);
	$str = preg_replace("/(<br>|<br \/>|<br\/>|<p>)/i", "\n", $str);
	$str = preg_replace("/(<div>|<\/div>|<\/p>)/i", "", $str);
	$str = str_replace("&nbsp;", " ", $str);
	$str = str_replace("/</", "&lt;", $str);
	$str = str_replace("/[/", "&lsqb;", $str);
	$str = str_replace("/{/", "&lcub;", $str);

	if(!$str) 
		return;

	$brush = isset($m[2]) ? strtolower(trim($m[2])) : 'html';

	na_script('code');

	return '<div class="line-numbers"><pre><code class="language-'.$brush.'">'.$str.'</code></pre></div>'.PHP_EOL;
}

//Google Map
function na_map($geo_data) {

	$geo_data = stripslashes($geo_data);

	if(!$geo_data) 
		return;

	$geo_data = str_replace(array("&#034;", "&#039;"), array("\"", "'"), $geo_data);

	$map = array();
	$map = na_query($geo_data);

	if(isset($map['loc']) && $map['loc']) {
		$map['z'] = isset($map['z']) ? ','.$map['z'] : '';
		$map['geo'] = $map['loc'].$map['z'];
	} else {
		$map['geo'] = (isset($map['geo']) && $map['geo']) ? $map['geo'] : '';
	}
	
	if(!isset($map['geo']) || !$map['geo'])
		return;

	//Marker
	$map['m'] = isset($map['m']) ? $map['m'] : '';

	//Place
	$map['p'] = isset($map['p']) ? $map['p'] : '';

	$id = na_rid();

	$canvas = '<div class="na-videowrap mb-3"><div class="na-videoframe"><iframe id="map_'.$id.'" name="map_'.$id.'" src="'.NA_URL.'/map.php?id='.urlencode($id).'&amp;geo='.urlencode($map['geo']).'&amp;marker='.urlencode($map['m']).'&amp;place='.urlencode($map['p']).'" marginwidth="0" marginheight="0" frameborder="0" width="100%" height="100%" scrolling="no"></iframe></div></div>';

	return $canvas;
}

// SoundCloud
function na_soundcloud($str) {

	$str = strip_tags($str);
	$str = str_replace(array("&#034;", "&#039;", "\"", "'"), array("", "", "", ""), $str);

	if(!$str) 
		return;

	$cloud = array();
	$cloud = na_query($str);

	$cloud['url'] = isset($cloud['url']) ? $cloud['url'] : '';
	$cloud['params'] = isset($cloud['params']) ? $cloud['params'] : '';

	$player = '';
	if($cloud['url'] && preg_match('/api.soundcloud.com/i', $cloud['url'])) {
		$cloud['params'] = ($cloud['params']) ? '&'.str_replace("&amp;", "&", $cloud['params']) : '';
		$player = '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.urlencode($cloud['url']).$cloud['params'].'"></iframe>'.PHP_EOL;
	}

	return $player;
}

function na_rich_content_video($matches){
	global $view;

	$num = $matches[2];

	if(isset($view['file'][$num]['file']) && $view['file'][$num]['file'])
		$num = $view['file'][$num]['path'].'/'.$view['file'][$num]['file'];

	$str = ($matches[3]) ? $num.':'.$matches[3] : $num;

	return '{동영상:'.$str.'}';
}

function na_view($data){

	if(isset($data['as_img']) && $data['as_img'] == "2") {
		$data['content'] = $data['rich_content'];
	}

	$data['content'] = preg_replace_callback("/{(동영상|video)\:([0-9]+)[:]?([^}]*)}/i", "na_rich_content_video", $data['content']);

	return na_content($data['content']);
}

function na_seo_text($text){

	$text = str_replace('"', '', na_get_text($text));
	$text = str_replace("'", "", $text);

	return $text;
}