<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 이미지 체크
function na_check_img($url) {
    global $config;

	return preg_match("/\.({$config['cf_image_extension']})$/i", basename($url)) ? na_url($url) : '';
}

// 이미지 비율
function na_img_ratio($w, $h, $ratio) {

	if(!$w || !$h)
		return $ratio;

	return round((($h / $w) * 100), 2);
}

// 이미지 저장
function na_save_img($url, $path) {

	if (!$url || !na_check_img($path)){
		return;
	}

	$rawdata = '';
	$ch = curl_init ($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,1); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$err = curl_error($ch);
	if(!$err) 
		$rawdata=curl_exec($ch);
	curl_close ($ch);
	if($rawdata) {
		$ym = date('ym', G5_SERVER_TIME);
		$data_dir = G5_DATA_PATH.'/editor/'.$ym;
		$data_url = G5_DATA_URL.'/editor/'.$ym;
		if(!is_dir($data_dir)) {
			@mkdir($data_dir, G5_DIR_PERMISSION);
			@chmod($data_dir, G5_DIR_PERMISSION);
		}
		$filename = basename($path);
		$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
        shuffle($chars_array);
        $shuffle = implode('', $chars_array);
        $file_name = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);
		$save_dir = sprintf('%s/%s', $data_dir, $file_name);
        $save_url = sprintf('%s/%s', $data_url, $file_name);

		$fp = fopen($save_dir,'w'); 
		fwrite($fp, $rawdata); 
		fclose($fp); 
		
		if(is_file($save_dir)) {
			@chmod($save_dir, G5_FILE_PERMISSION);
			return $save_url;
		}
	} 
	
	return;
}

// 컨텐츠 내 이미지 체크
function na_content_img($content) {

	if(!$content) 
		return;

	$content = stripslashes($content);
	$patten = "/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i";

	preg_match_all($patten, $content, $match);

	$n = 0;
	if (isset($match[1]) && is_array($match[1])) {
		foreach ($match[1] as $link) {
			$url = @parse_url($link);
			$url['host'] = isset($url['host']) ? $url['host'] : '';
			if ($url['host'] && $url['host'] != $_SERVER['HTTP_HOST']) {
				$url['path'] = isset($url['path']) ? $url['path'] : '';
				$image = na_save_img($link, $url['path']);
				if ($image)	{
					$content = str_replace($link, $image, $content);
					$n++;
				}
			}
		}
	}

	return array($n, $content);
}

// 이미지 넘기는 형태
function na_img_rows($img, $rows) {
	return ($rows > 1) ? $img : $img[0];
}

// 게시물 이미지 추출
function na_wr_img($bo_table, $wr, $re='') {
    global $g5, $config;

	$rows = isset($wr['img_rows']) ? (int)$wr['img_rows'] : 1;
	$rows = ($rows > 1) ? $rows : 1;

	// 전체 이미지 뽑기
	$all = (isset($wr['imgs_all']) && $wr['imgs_all']) ? true : false;

	if (!$re && !$all && $rows == "1" && isset($wr['wr_10']) && $wr['wr_10']) {
		if (na_check_img($wr['wr_10']))
			return na_url($wr['wr_10']);
	}

	$img = array();
	$link = array();

	// 이미지 카운팅
	$z = 0; // 직접
	$n = 0; // 링크

	// 직접 첨부
	if (isset($wr['wr_file']) && $wr['wr_file']) {
		$sql = " select bf_file, bf_content 
					from {$g5['board_file_table']} 
					where bo_table = '$bo_table' 
						and wr_id = '{$wr['wr_id']}' 
						and bf_type in (1, 2, 3, 18)
					order by bf_no ";
		$result = sql_query($sql, false);
		if($result) {
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				if($row['bf_file']) {
					$img[$z] = G5_DATA_URL.'/file/'.$bo_table.'/'.$row['bf_file'];
					$z++;
					if(!$all && $z == $rows)
						return na_img_rows($img, $rows);
				} 
			}
		}
	}

	// 본문 보다 링크 동영상 먼저 체크
	for ($i=1; $i<=G5_LINK_COUNT; $i++) {
		$wr_link = isset($wr['wr_link'.$i]) ? $wr['wr_link'.$i] : '';;

		if(!$wr_link)
			continue;

		$vimg = na_video_img(na_video_info(trim(strip_tags($wr_link))));
		if(!$vimg)
			continue;

		$img[$z] = str_replace(G5_PATH, G5_URL, $vimg);
		$z++;
		if(!$all && $z == $rows) 
			return na_img_rows($img, $rows);
	}

	// 본문
	if(isset($wr['wr_content']) && $wr['wr_content']) {
		$matches = get_editor_image(conv_content($wr['wr_content'], 1), false);
		$imgs = is_array($matches[1]) ? $matches[1] : array();
		$imgs_cnt = count($imgs);
		for($i=0; $i < $imgs_cnt; $i++) {
			// 이미지 path 구함
			$p = @parse_url($imgs[$i]);
			$p['path'] = isset($p['path']) ? $p['path'] : '';

			if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
				$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
			else
				$data_path = $p['path'];

			$srcfile = G5_PATH.$data_path;

			if(is_file($srcfile)) {
				$size = @getimagesize($srcfile);
				// 아이콘 등 링크 제거를 위해 100px 이하 이미지는 제외함
				if(empty($size) || $size[0] < 100)
					continue;

				$img[$z] = $imgs[$i];
				$z++;
				if(!$all && $z == $rows)
					return na_img_rows($img, $rows);

			} else {
				$link[$n] = $matches[1][$i];
				$n++;
			}
		}

		// 본문 동영상
		if(preg_match_all("/{(동영상|video)\:([^}]*)}/is", $wr['wr_content'], $match)) {
			$vimgs = (isset($match[2]) && is_array($match[2])) ? $match[2] : array();
			$vimgs_cnt = count($vimgs);
			for ($i=0; $i < $vimgs_cnt; $i++) {

				$vimg = na_video_img(na_video_info(trim(strip_tags($vimgs[$i]))));

				if(!$vimg || $vimg == 'none') 
					continue;

				$img[$z] = str_replace(G5_PATH, G5_URL, $vimg);
				$z++;
				if(!$all && $z == $rows) 
					return na_img_rows($img, $rows);

			}
		}

		// 본문링크 이미지
		$link_cnt = count($link);
		for($i=0; $i < $link_cnt; $i++) {
			$img[$z] = $link[$i];
			$z++;
			if(!$all && $z == $rows) 
				return na_img_rows($img, $rows);
		}
	}

	// 이미지 없음
	$img[$z] = '';

    return na_img_rows($img, $rows);
}

// 썸네일
function na_thumb($img, $thumb_w, $thumb_h) {

	if((int)$thumb_w > 0) {
		// 이미지 path 구함
		$p = parse_url($img);
		$p['path'] = isset($p['path']) ? $p['path'] : '';

		if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
			$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
		else
			$data_path = $p['path'];

		$srcfile = G5_PATH.$data_path;

		if(is_file($srcfile)) {
			$filename = basename($srcfile);
			$filepath = dirname($srcfile);
			$tname = thumbnail($filename, $filepath, $filepath, $thumb_w, $thumb_h, false, true);
			$img = G5_URL.str_replace($filename, $tname, $data_path);
		}
	}

	return $img;
}

//=====================================================================
// 영카트 쇼핑몰
//=====================================================================

function na_it_img($it_id, $it) {
    global $g5;

	$rows = isset($it['img_rows']) ? (int)$it['img_rows'] : 1;
	$rows = ($rows > 1) ? $rows : 1;

	// 전체 이미지 뽑기
	$all = (isset($it['imgs_all']) && $it['imgs_all']) ? true : false;

	$img = array();

	// 직접 첨부
	$z = 0;
	for($i=1;$i<=10; $i++) {
        $file = G5_DATA_PATH.'/item/'.$it['it_img'.$i];
        if(is_file($file) && $it['it_img'.$i]) {
            $size = @getimagesize($file);
            if(!isset($size[2]) || $size[2] < 1 || $size[2] > 3)
				continue;

			$img[$z] = G5_DATA_URL.'/item/'.$it['it_img'.$i];
			$z++;
			if(!$all && $z == $rows)
				return na_img_rows($img, $rows);
        }
    }

	// 이미지 없음
	$img[$z] = '';

    return na_img_rows($img, $rows);
}