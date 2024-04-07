<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 미디어 종류 파악
function na_check_ext($type='') {

	if($type == 'video') {
		$ext = array('mp4', 'm4v', 'f4v', 'mov', 'flv', 'webm');
	} else if($type == 'audio') {
		$ext = array('acc', 'm4a', 'f4a', 'mp3', 'ogg', 'oga');
	} else if($type == 'caption') {
		$ext = array('vtt', 'srt', 'ttml', 'dfxp');
	} else if($type == 'image') {
		$ext = array('jpg', 'jpeg', 'gif', 'png', 'webp');
	} else {
		$ext = array("mp4", "m4v", "f4v", "mov", "flv", "webm", "acc", "m4a", "f4a", "mp3", "ogg", "oga");
	}

	return $ext;
}

// 유튜브 동영상
function na_check_youtube($url) {

	$match = array();

	$vid = $type = '';
	if(preg_match("/\/shorts\//i", $url)) {
		$type = 'shorts';
		$info = @parse_url($url); 
		if(isset($info['host']) && ($info['host'] == 'youtube.com' || $info['host'] == 'www.youtube.com'))
			$vid = isset($info['path']) ? str_replace('/shorts/', '', $info['path']) : '';
	} else if(preg_match("/\/live\//i", $url)) {
		$type = 'live';
		$info = @parse_url($url); 
		if(isset($info['host']) && ($info['host'] == 'youtube.com' || $info['host'] == 'www.youtube.com'))
			$vid = isset($info['path']) ? str_replace('/live/', '', $info['path']) : '';
	} else {
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
		$vid = isset($match[1]) ? $match[1] : '';
	}

	return array('vid'=>$vid, 'type'=>$type);
}

// 동영상 종류 파악
function na_video_info($video_url) {
	global $boset;

	$video = array();
	$query = array();
	$option = array();

	$arr = explode("|", $video_url);
	$url = isset($arr[0]) ? trim($arr[0]) : '';
	$opt = isset($arr[1]) ? $arr[1] : '';

	if($url) {
		if(!preg_match('/(http|https)\:\/\//i', $url))
			$url = 'https:'.$url;
	} else {
		return;
	}

	// 초기값
	$is_auto = isset($boset['video_auto']) ? $boset['video_auto'] : '';
	$video['video'] = str_replace(array("&nbsp;", " "), array("", ""), $url);
	$video['video_url'] = str_replace(array("&nbsp;", "&amp;", " "), array("", "&", ""), $url);

	if($opt)
		$option = na_query($opt);

	// 미디어파일 직접 지정일 경우
	if(isset($option['file']) && $option['file']) {
		$video['type'] = 'file';
		$video['vid'] = 'file';
		$video['img'] = (isset($option['img']) && $option['img']) ? str_replace(array("&nbsp;", " "), array("", ""), trim(strip_tags($option['img']))) : '';
		$video['caption'] = (isset($option['caption']) && $option['caption']) ? str_replace(array("&nbsp;", " "), array("", ""), trim(strip_tags($option['caption']))) : '';
		return $video;
	}

	$info = @parse_url($video['video_url']); 
	$info['host'] = isset($info['host']) ? $info['host'] : '';
	$info['path'] = isset($info['path']) ? $info['path'] : '';
	$info['query'] = isset($info['query']) ? $info['query'] : '';

	if($info['query']) 
		parse_str($info['query'], $query); 
	
	// 확장자 체크 && jwplayer
	$filename = ($info['path']) ? basename($info['path']) : '';
	if($filename) {
		$ext = na_file_info($filename);
		if(in_array($ext['ext'], na_check_ext())) {
			$video['type'] = 'file';
			$video['vid'] = 'file';
			return $video;
		}
	}

	// Fullscreen
	$fs = ' allowfullscreen webkitallowfullscreen mozallowfullscreen';
	$vw = 640;
	$vh = 360;

	switch($info['host']) {

		// Youtube
		case 'www.youtube.com' :
		case 'youtube.com'	   :
		case 'm.youtube.com'   :
		case 'youtu.be'		   :   

			$video['type'] = 'youtube';
			$vinfo = na_check_youtube($video['video_url']);

			$video['vid'] = $vinfo['vid'];
			if($vinfo['type'] == 'shorts') {
				$vw = 315; 
				$vh = 560;
				$video['max_width'] = 450;
			} else {
				if(isset($option['s'])) {
					$video['s'] = $option['s'];
				} else if(isset($query['s'])) {
					$video['s'] = $query['s'];
				} else {
					$video['s'] = '';
				}

				if($video['s']) { 
					$vw = 480; 
					$vh = 880; 
				}
			}

			$vlist = isset($query['list']) ? '&list='.$query['list'] : '';
			
			$start = '';
			if(isset($query['t'])) {
				$start = '&start='.$query['t'];
			} else if(isset($query['start'])) {
				$start = '&start='.$query['start'];
			} else if(isset($option['start'])) {
				$start = '&start='.$option['start'];
			}

			$autoplay = ($is_auto) ? '&autoplay=1' : '';
			$video['iframe'] = '<iframe width="'.$vw.'" height="'.$vh.'" src="https://www.youtube.com/embed/'.$video['vid'].'?autohide=1&vq=hd720&wmode=opaque'.$vlist.$autoplay.$start.'" frameborder="0"'.$fs.'></iframe>';
			break;

		// Vimeo
		case 'vimeo.com' :
			$video['type'] = 'vimeo';
			$vquery = explode("/",$video['video_url']);
			$num = count($vquery) - 1;
			list($video['vid']) = explode("#",$vquery[$num]);
			$vw = 717; 
			$vh = 403;
			$autoplay = ($is_auto) ? '&amp;autoplay=1' : '';
			$video['iframe'] = '<iframe src="https://player.vimeo.com/video/'.$video['vid'].'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff'.$autoplay.'&amp;wmode=opaque" width="'.$vw.'" height="'.$vh.'" frameborder="0"'.$fs.'></iframe>';
			break;

		/* TikTok
		case 'www.tiktok.com' :
			$video['type'] = 'tiktok';
			list($vurl) = explode("?", $video['video_url']);
			$video['video_url'] = $vurl;
			$vquery = explode("/", $info['path']);
			$num = count($vquery) - 1;
			$video['vid'] = $vquery[$num];
			$video['max_width'] = 450;
			$vw = 323; 
			$vh = 574;
			$video['iframe'] = '<blockquote class="tiktok-embed" cite="'.$video['video_url'].'" data-video-id="'.$video['vid'].'" style="max-width: 605px;min-width: 325px;" ><section></section></blockquote><script async src="https://www.tiktok.com/embed.js"></script>';
			break;
		*/
		// Ted
		case 'www.ted.com' :
			$video['type'] = 'ted';
			$vids = explode("?", $video['video_url']);
			$vquery = explode("/",$vids[0]);
			$num = count($vquery) - 1;
			list($video['vid']) = explode(".", $vquery[$num]);
			list($rid) = explode(".", trim($info['path']));
			$rid = str_replace($video['vid'], '', $rid);
			$lang = (isset($query['language']) && $query['language']) ? 'lang/'.$query['language'].'/' : '';
			if($lang) {
				$rid = (stripos($rid, $lang) === false) ? $rid.$lang : $rid;
			}
			$video['rid'] = trim($rid.$video['vid']).'.html';
			$video['iframe'] = '<iframe src="https://embed-ssl.ted.com'.$video['rid'].'?&wmode=opaque" width="'.$vw.'" height="'.$vh.'" frameborder="0" scrolling="no"'.$fs.'></iframe>';
			break;

		// Kakao tv & Daum tv
		case 'tvpot.daum.net' :
		case 'tv.kakao.com'	  :
			$video['type'] = 'kakao';
			if(isset($query['vid']) && $query['vid']) {
				$video['vid'] = $query['vid'];
			} else if(isset($query['clipid']) && $query['clipid']) {
				$video['vid'] = 1;
				$play = ap_video_id($video);
				$video['vid'] = isset($play['vid']) ? $play['vid'] : '';
			} else {
				$video['vid'] = trim(str_replace("/v/","",$info['path']));
			}
			$autoplay = ($is_auto) ? '&autoplay=1' : '';
			$video['iframe'] = '<iframe width="'.$vw.'" height="'.$vh.'" src="https://tv.kakao.com/embed/player/cliplink/'.$video['vid'].'?service=kakao_tv'.$autoplay.'&wmode=opaque" frameborder="0" scrolling="no"'.$fs.'></iframe>';
			break;

		// Pandora tv
		case 'channel.pandora.tv' :
		case 'www.pandora.tv'	  :
		case 'pan.best'			  :
			$video['type'] = 'pandora';
			$video['vid'] = 1;
			$play = na_video_id($video);
			$video['ch_userid'] = isset($play['userid']) ? $play['userid'] : '';
			$video['prgid'] = isset($play['prgid']) ? $play['prgid'] : '';
			$video['vid'] = $video['ch_userid'].'_'.$video['prgid'];
			$video['iframe'] = '<iframe frameborder="0" width="'.$vw.'" height="'.$vh.'" src="https://channel.pandora.tv/php/embed.fr1.ptv?userid='.$video['ch_userid'].'&prgid='.$video['prgid'].'&skin=1&share=on&wmode=opaque"'.$fs.'></iframe>';
			break;

		// Dailymotion
		case 'www.dailymotion.com'  :
		case 'dai.ly'				:
			$video['type'] = 'dailymotion';
			if($info['host'] == 'dai.ly') {
				$video['vid'] = trim($info['path']);
			} else {
				list($vurl) = explode("#", $video['video_url']);
				$vquery = explode("/", $vurl);
				$num = count($vquery) - 1;
				list($video['vid']) = explode("_", $vquery[$num]);
			}
			$video['iframe'] = '<iframe frameborder="0" width="'.$vw.'" height="'.$vh.'" src="https://www.dailymotion.com/embed/video/'.$video['vid'].'?&wmode=opaque"'.$fs.'></iframe>';
			break;

		// Facebook
		case 'www.facebook.com'  :
			$video['type'] = 'facebook';
			if(isset($query['video_id']) && $query['video_id']){
				$video['vid'] = $query['video_id'];
			} else if(isset($query['v']) && $query['v']) {
				$video['vid'] = $query['v'];
			} else {
				$vtmp = explode("/videos/", trim($info['path']));
				list($video['vid']) = isset($vtmp[1]) ? explode("/", $vtmp[1]) : array('');
			}
			if(is_numeric($video['vid'])) {
				$video['iframe'] = '<iframe src="https://www.facebook.com/video/embed?video_id='.urlencode($video['vid']).'" width="'.$vw.'" height="'.$vh.'" frameborder="0"'.$fs.'></iframe>';
			} else {
				$video = NULL;
			}
			break;

		// Naver Blog
		case 'serviceapi.nmv.naver.com'  :
			$video['type'] = 'naver';
			$video['vid'] = isset($query['vid']) ? $query['vid'] : '';
			$video['outKey'] = isset($query['outKey']) ? $query['outKey'] : '';
			$vw = 720;
			$vh = 438;
			$autoplay = ($is_auto) ? '&isp=1' : '';
			$video['iframe'] = '<iframe width="'.$vw.'" height="'.$vh.'" src="https://serviceapi.nmv.naver.com/flash/convertIframeTag.nhn?vid='.$video['vid'].'&outKey='.$video['outKey'].'&wmode=opaque'.$autoplay.'" frameborder="no" scrolling="no"'.$fs.'></iframe>';
			break;

		// Naver tvcast
		case 'serviceapi.rmcnmv.naver.com'  :
		case 'tvcast.naver.com'				:
		case 'tv.naver.com'					:
			$video['type'] = 'tvcast';
			if(isset($query['vid']) && $query['vid']) {
				$video['vid'] = $query['vid'];
				$video['outKey'] = isset($query['outKey']) ? $query['outKey'] : '';
			} else {
				list($video['vid']) = explode("/", trim(str_replace("/v/","",$info['path']))); 
			}
			$vw = 740;
			$vh = 416;
			$autoplay = ($is_auto) ? 'true' : 'false';
			$video['iframe'] = '<iframe src="https://tv.naver.com/embed/'.$video['vid'].'?autoPlay='.$autoplay.'" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" width="'.$vw.'" height="'.$vh.'" allow="autoplay"'.$fs.'></iframe>';
			break;

		// Slideshare
		case 'www.slideshare.net'  :
			$video['type'] = 'slideshare';
			$video['vid'] = 1;
			$play = na_video_id($video);
			$video['play_url'] = isset($play['play_url']) ? $play['play_url'] : '';
			$video['vid'] = isset($play['vid']) ? $play['vid'] : '';
			$vw = 425;
			$vh = 355;
			$video['iframe'] = '<iframe src="'.str_replace("http:", "https:", $video['play_url']).'" width="'.$vw.'" height="'.$vh.'" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"'.$fs.'></iframe>';
			break;

		// Sendvid
		case 'sendvid.com'  :
			$video['type'] = 'sendvid';
			$video['vid'] = trim(str_replace("/","",$info['path']));
			$vw = 853;
			$vh = 480;
			$video['iframe'] = '<iframe src="https://sendvid.com/embed/'.$video['vid'].'" width="'.$vw.'" height="'.$vh.'" frameborder="0"'.$fs.'></iframe>';
			break;

		// Vine
		case 'vine.co'  :
			$video['type'] = 'vine';
			$vtmp = explode("/v/", trim($info['path']));
			list($video['vid']) = isset($vtmp[1]) ? explode("/", $vtmp[1]) : array('');
			$vw = 600; 
			$vh = 600;
			$video['iframe'] = '<iframe src="https://vine.co/v/'.$video['vid'].'/embed/simple" width="'.$vw.'" height="'.$vh.'" frameborder="0"'.$fs.'></iframe>';
			break;

		// Yinyuetai
		case 'player.yinyuetai.com'  :
		case 'v.yinyuetai.com'		 :
			$video['type'] = 'yinyuetai';
			$video['vid'] = str_replace("/", "", str_replace("v_0.swf", "", str_replace("player", "", str_replace("video","",$info['path']))));
			$vw = 480; 
			$vh = 334; 
			$video['iframe'] = '<embed src="https://player.yinyuetai.com/video/player/'.$video['vid'].'/v_0.swf" quality="high" width="'.$vw.'" height="'.$vh.'" align="middle" allowScriptAccess="sameDomain" allowfullscreen="true" type="application/x-shockwave-flash"></embed>';
			break;

		// Vlive
		case 'www.vlive.tv'  :
			$video['type'] = 'vlive';
			$vtmp = explode("/video/", trim($info['path']));
			list($video['vid']) = isset($vtmp[1]) ? explode("/", $vtmp[1]) : array('');
			$vw = 544; 
			$vh = 306; 
			$autoplay = ($is_auto) ? '?autoPlay=true' : '';
			$video['iframe'] = '<iframe src="https://www.vlive.tv/embed/'.$video['vid'].$autoplay.'" width="'.$vw.'" height="'.$vh.'" frameborder="no" scrolling="no" marginwidth="0" marginheight="0"'.$fs.'></iframe>';
			break;
			
		// Srook
		case 'www.srook.net'  :
			$video['type'] = 'srook';
			$vquery = explode("/", trim($info['path']));
			$video['author'] = isset($vquery[1]) ? $vquery[1] : '';
			$video['key'] = isset($vquery[2]) ? $vquery[2] : '';
			$video['vid'] = $video['author'].'_'.$video['key'];
			$video['pageNo'] = (isset($query['pageNo']) && $query['pageNo']) ? '&pageNo='.$query['pageNo'] : '';
			$vw = 720; 
			$vh = 480; 
			$video['iframe'] = '<iframe src="https://www.srook.net/nemo_embed/srookviewer.html?author='.$video['author'].'&key='.$video['key'].'&btype=0'.$video['pageNo'].'" width="'.$vw.'" height="'.$vh.'" frameborder="no" scrolling="no" marginwidth="0" marginheight="0"'.$fs.'></iframe>';
			break;

		// Twitch
		case 'twitch.tv'  :
		case 'www.twitch.tv'  :
			$video['type'] = 'twitch';
			$vw = 620; 
			$vh = 378; 
			if(preg_match('/\/clip\//i', $video['video_url'])) {
				$vtmp = explode("/clip/", trim($info['path']));
				list($video['vid']) = isset($vtmp[1]) ? explode("/", $vtmp[1]) : array('');
				$video['iframe'] = '<iframe src="https://clips.twitch.tv/embed?clip='.$video['vid'].'&parent='.$_SERVER["SERVER_NAME"].'" frameborder="0" scrolling="no" width="'.$vw.'" height="'.$vh.'"'.$fs.'></iframe>';
			} else if(preg_match('/\/videos\//i', $video['video_url'])) {
				$vtmp = explode("/videos/", trim($info['path']));
				list($video['vid']) = isset($vtmp[1]) ? explode("/", $vtmp[1]) : array('');
				$video['iframe'] = '<iframe src="https://player.twitch.tv/?video='.$video['vid'].'&parent='.$_SERVER["SERVER_NAME"].'" width="'.$vw.'" height="'.$vh.'" allowfullscreen="true" frameborder="no" scrolling="no"'.$fs.'></iframe>';
			} else if($info['path']) {
				$vtmp = explode("/", $info['path']);
				$video['vid'] = isset($vtmp[1]) ? $vtmp[1] : '';
				$video['iframe'] = '<iframe src="https://player.twitch.tv/?channel='.$video['vid'].'&parent='.$_SERVER["SERVER_NAME"].'" frameborder="0" scrolling="no" width="'.$vw.'" height="'.$vh.'"'.$fs.'></iframe>';
			}

			break;

		// Openload
		case 'openload.co'  :
			$video['type'] = 'openload';
			$vtmp = explode("/embed/", trim($info['path']));
			list($video['vid']) = isset($vtmp[1]) ? explode("/", $vtmp[1]) : array('');
			$video['iframe'] = '<iframe src="https://openload.co/embed/'.$video['vid'].'?wmode=opaque" width="'.$vw.'" height="'.$vh.'" frameborder="no" scrolling="no"'.$fs.'></iframe>';
			break;

		// Soundcloud
		case 'soundcloud.com'  :
			$video['type'] = 'soundcloud';
			$play = na_video_id($video);
			$video['vid'] = isset($play['vid']) ? $play['vid'] : '';
			break;
	}

	// 동영상 비율
	$video['ratio'] = round(($vh / $vw), 4) * 100;

	return $video;
}

// Video Player
function na_video($vid, $opt='') {

	$video = array();
	$vid = str_replace("&nbsp;", " ", strip_tags($vid));
	$video = na_video_info($vid);

	if($opt) 
		return $video; //비디오 정보만 넘기기

	if(!isset($video['vid']) || !$video['vid']) 
		return;

	$video['type'] = isset($video['type']) ? $video['type'] : '';

	// JWPLAYER6
	$iframe = '';
	if($video['type'] == "file") {

		$video['img'] = isset($video['img']) ? $video['img'] : '';
		$video['caption'] = isset($video['caption']) ? $video['caption'] : '';

		return na_jwplayer($video['video'], $video['img'], $video['caption']);

	} else if(isset($video['iframe']) && $video['iframe']) {
		$iframe = $video['iframe'];
		// vine.co
		if($video['type'] == "vine" && !defined('VINE_VIDEO')) {
			define('VINE_VIDEO', true);
			$iframe .= '<script src="https://platform.vine.co/static/scripts/embed.js"></script>';
		}

	} else if($video['type'] == "soundcloud") {
		$vpath = str_replace("-", "/", $video['vid']);
		$arr = explode("/", $vpath);
		$vtype = isset($arr[0]) ? $arr[0] : '';
		$vcode = isset($arr[1]) ? $arr[1] : '';
		if(G5_IS_MOBILE) {
			$iframe = '<div class="na-soundcloud-mo">';
			if($vtype == 'playlists') {
				$iframe .= '<iframe width="100%" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/'.$vpath.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>';
			} else {
				$iframe .= '<iframe width="100%" height="400" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/'.$vpath.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>';
			}
			$iframe .= '</div>';
		} else {
			$iframe = '<div class="na-soundcloud">';
			if($vtype == 'playlists') {
				$iframe .= '<iframe width="100%" height="450" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/'.$vpath.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
			} else {
				$iframe .= '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/'.$vpath.'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
			}
			$iframe .= '</div>';
		}

		return $iframe;
	}

	$player = '';
	if($iframe) {
		$sero_size = (isset($video['s']) && $video['s']) ? ' na-video-sero' : '';
		$max_width = (isset($video['max_width']) && $video['max_width']) ? ' style="max-width:'.$video['max_width'].'px;"' : '';
		$player .= '<div class="na-videowrap'.$sero_size.'"'.$max_width.'>'.PHP_EOL;
		$player .= '<div class="na-videoframe" style="padding-bottom: '.$video['ratio'].'%;">'.PHP_EOL;
		$player .= $iframe.PHP_EOL;
		$player .= '</div>'.PHP_EOL;
		$player .= '</div>'.PHP_EOL;
	}

	return $player;
}

// 동영상 이미지 주소 가져오기
function na_video_imgurl($video) {
	global $nariya;

	$url = isset($video['video_url']) ? $video['video_url'] : '';
	$vid = isset($video['vid']) ? $video['vid'] : '';
	$type = isset($video['type']) ? $video['type'] : '';

	$imgurl = '';
	if($type == "file") { //JWPLAYER
		return;
	} else if($type == "vimeo") { //비메오
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://vimeo.com/api/v2/video/".$vid.".php");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = unserialize(curl_exec($ch));
		curl_close($ch);

		$imgurl = isset($output[0]['thumbnail_large']) ? $output[0]['thumbnail_large'] : '';

	} else if($type == "youtube") { //유튜브

		$imgurl = 'https://img.youtube.com/vi/'.$vid.'/hqdefault.jpg';

	} else if($type == "srook") { //www.srook.net

		$arr = explode("_", $vid);
		$author = isset($arr[0]) ? $arr[0] : '';
		$key = isset($arr[1]) ? $arr[1] : '';

		$imgurl = 'http://www.srook.net/ctlimg/pageImg.ashx?p=1|'.$key.'|'.$author;

	} else if($type == "facebook"){

		if(!isset($nariya['fb_key']) || !$nariya['fb_key']) 
			return;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v2.8/".$vid."?fields=id,picture&access_token=".$nariya['fb_key']);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = json_decode(curl_exec($ch));
		curl_close($ch);
		
		$imgurl = $output->picture;

	} else if($type == "naver" || $type == "tvcast"){ //라니안님 코드 반영

		$info = @parse_url($url);
		$info['host'] = isset($info['host']) ? $info['host'] : '';
		$info['query'] = isset($info['query']) ? $info['query'] : '';

		if($info['host'] == "tvcast.naver.com" || $info['host'] == "tv.naver.com") {
			;
		} else {
			$url_type = ($type == "naver") ? "nmv" : "rmcnmv"; // 네이버 블로그 영상과 tvcast 영상 구분

			parse_str($info['query'], $query); 

			$vid .= isset($query['outKey']) ? "&outKey=".$query['outKey'] : '';
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://serviceapi.{$url_type}.naver.com/flash/videoInfo.nhn?vid=".$vid);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$output = curl_exec($ch);
			curl_close($ch);

			preg_match('/\<CoverImage\>\<\!\[CDATA\[(?P<img_url>[^\s\'\"]+)\]\]\>\<\/CoverImage\>/i', $output, $video);

			$imgurl = isset($video['img_url']) ? $video['img_url'] : '';
		}

	}
	
	if(!$imgurl) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		if($type == "soundcloud") {
			$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0'; 
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);

		//parsing begins here:
		$doc = new DOMDocument();
		@$doc->loadHTML($output);

		$metas = $doc->getElementsByTagName('meta');

		for ($i = 0; $i < $metas->length; $i++) {
			$meta = $metas->item($i);
			if($meta->getAttribute('property') == "og:image" || $meta->getAttribute('name') == "og:image") {
				if($meta->getAttribute('content')) {
					$imgurl = str_replace("type=f240", "type=f640", $meta->getAttribute('content')); //640 사이즈로 변경
				}
				break;
			}
		}
	}

	return $imgurl;
}

// 동영상 이미지 가져오기
function na_video_img($video, $fimg='') {
	global $nariya;

	if(!isset($video['type']) || !$video['type']) 
		return;

	if($video['type'] == 'file') 
		return $fimg;

	// 동영상 대표이미지 링크 그대로 사용
	if(!isset($nariya['save_video_img']) || !$nariya['save_video_img']) {
		return na_video_imgurl($video);
	}

	$no_image = NA_PATH.'/img/blank.gif';
	$video_path = NA_DATA_PATH.'/video';
	$video_url = NA_DATA_URL.'/video';
	$type_path = $video_path.'/'.$video['type'];
	$type_url = $video_url.'/'.$video['type'];

	$code_vid = urldecode(na_fid($video['vid']));

	$img = $type_path.'/'.$code_vid.'.jpg';
	$no_img = $type_path.'/'.$code_vid.'_none';

	if(is_file($img)) {
		return $img;
	} else if($video['type'] != 'youtube' && is_file($no_img)) { // 유튜브만 이미지 다시 가져옴
		return;
	} else {
		//썸네일 저장폴더
		if(!is_dir($video_path)) {
	        @mkdir($video_path, G5_DIR_PERMISSION);
	        @chmod($video_path, G5_DIR_PERMISSION);
		}

		if(!is_dir($type_path)) {
	        @mkdir($type_path, G5_DIR_PERMISSION);
	        @chmod($type_path, G5_DIR_PERMISSION);
		}

		//동영상 이미지 주소 가져오기
		$imgurl = na_video_imgurl($video);

		if($imgurl) {
			$ch = curl_init ($imgurl);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$err = curl_error($ch);
			if(!$err) 
				$rawdata=curl_exec($ch);
			curl_close ($ch);
			if($rawdata) {
				$fp = fopen($img,'w'); 
				fwrite($fp, $rawdata); 
				fclose($fp); 
				@chmod($img, G5_FILE_PERMISSION);
				@unlink($no_img);
				return $img;
			} else {
				if(!is_file($no_img)) {
					@copy($no_image, $no_img);
					@chmod($no_img, G5_FILE_PERMISSION);
				}
				return;
			}
		} 

		if(!is_file($no_img)) {
			@copy($no_image, $no_img);
			@chmod($no_img, G5_FILE_PERMISSION);
		}

		return;
	} 

	return;
}

// 동영상 실제 아이디 가져오기
function na_video_id($vinfo) {

	$play = array();
	$info = array();
	$query = array();

	if (!isset($vinfo['type']) || !$vinfo['type'] || $vinfo['type'] == 'file')
		return $play;

	$url = isset($vinfo['video_url']) ? $vinfo['video_url'] : '';
	$vid = isset($vinfo['vid']) ? $vinfo['vid'] : '';
	$type = isset($vinfo['type']) ? $vinfo['type'] : '';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	if($type == "soundcloud") {
		$useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0'; 
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	}
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = curl_exec($ch);
	curl_close($ch);

	switch($type) {
		case 'tvcast' : 
			$name = 'property'; 
			$key = 'og:video:url'; 
			$value = 'content'; 
			break;

		case 'daum' : 
			$name = 'property'; 
			$key = 'og:url'; 
			$value = 'content'; 
			break;

		case 'kakao' : 
			$name = 'property'; 
			$key = 'og:url'; 
			$value = 'content'; 
			break;

		case 'pandora' : 
			$name = 'property'; 
			$key = 'og:url'; 
			$value = 'content'; 
			break;

		case 'slideshare' : 
			$name = 'name'; 
			$key = 'twitter:player'; 
			$value = 'value'; 
			break;

		case 'soundcloud' : 
			$name = 'property'; 
			$key = 'twitter:player'; 
			$value = 'content'; 
			break;

		default : 
			$name = $key = $value = ''; 
			break;
	}

	if(!$name)
		return $play;

	// Parsing begins here:
	$doc = new DOMDocument();
	@$doc->loadHTML($output);

	$metas = $doc->getElementsByTagName('meta');

	$content = '';
	for ($i = 0; $i < $metas->length; $i++) {
		$meta = $metas->item($i);
		if($meta->getAttribute($name) == $key) {
			$content = str_replace("&amp;", "&", $meta->getAttribute($value));
			break;
		}
	}

	if(!$content)
		return $play;
	
	$info = @parse_url($content);
	$info['path'] = isset($info['path']) ? $info['path'] : '';
	$info['query'] = isset($info['query']) ? $info['query'] : '';

	switch($type) {

		case 'tvcast' :
			@parse_str($info['query'], $query); 
			$play['vid'] = isset($query['vid']) ? $query['vid'] : '';
			$play['outKey'] = isset($query['outKey']) ? $query['outKey'] : '';
			break;

		case 'tvcast' :
		case 'daum'	  :
			$play['vid'] = trim(str_replace("/v/","",$info['path']));
			break;

		case 'pandora' :
			$arr = explode("/", trim(str_replace("/view/","",$info['path'])));
			$play['userid'] = isset($arr[0]) ? $arr[0] : '';
			$play['prgid'] = isset($arr[1]) ? $arr[1] : '';
			break;

		case 'slideshare' :
			$play['play_url'] = $content;
			$play['vid'] = trim(str_replace("/slideshow/embed_code/","",$info['path'])); 
			break;

		case 'soundcloud' :
			@parse_str($info['query'], $query);
			$query['url'] = isset($query['url']) ? $query['url'] : '';
			$vinfo = @parse_url($query['url']);
			$vinfo['path'] = isset($vinfo['path']) ? $vinfo['path'] : '';
			if(strpos($vinfo['path'], '/tracks/') !== false || strpos($vinfo['path'], '/playlists/') !== false) {
				$play['vid'] = str_replace(array("/tracks/", "/playlists/"), array("tracks-", "playlists-"), $vinfo['path']);
			}
			break;

		default	: 
			break;
	}

	return $play;
}

// Jwpalyer Caption
function na_get_caption($attach, $source, $num) {

	if(!$source) 
		return;

	$carr = array();
	$iarr = array();
	$earr = array();

	$caption = na_check_ext('caption');
	$image = na_check_ext('image');
	$fname = na_file_info($source);

	for ($i=0; $i < $attach['count']; $i++) {

		if($i == $num) 
			continue;

		$file = na_file_info($attach[$i]['source']);

		if($fname['name'] == $file['name']) {
			$fileurl = $attach[$i]['path'].'/'.$attach[$i]['file'];
			if(in_array($file['ext'], $caption)) {
				$carr[] = $fileurl;
			} else if(in_array($file['ext'], $image)) {
				$iarr[] = $fileurl;
				$earr[] = $i;
			}
		}
	}

	// 제외번호는 배열로 다 넘김
	$in = (isset($iarr[0]) && $iarr[0]) ? $iarr[0] : '';
	$cn = (isset($carr[0]) && $carr[0]) ? $carr[0] : '';

	return array($in, $cn, $earr);
}

// JWPlayer List
function na_jwplayer_list($url) {

	if(!$url) return;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);    
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$xml = trim(curl_exec($ch));
	curl_close($ch);

	if(!$xml) return;

	preg_match_all("/<item>(.*)<\/item>/is", $xml, $matchs);

	$count = (isset($matchs[1]) && is_array($matchs[1])) ? count($matchs[1]) : 0;

	return $count;
}

// JWPlayer6
function na_jwplayer($url, $img='', $caption='', $title=''){
	global $nariya, $boset;

	if(!$url) 
		return;

	$file = na_file_info($url);
	$ext = $file['ext'];

	$is_auto = isset($boset['video_auto']) ? $boset['auto_auto'] : '';

	// VIDEO, AUDIO 태그 우선 출력
	//if($nariya['jw6_video']) {
		if($ext == "mp4" || $ext == "webm") {
			$player = '<div class="na-videowrap"><div class="na-videoframe">';
			$player .= '<video src="'.$url.'" controls loop';
			if($is_auto) {
				$player .= ' autoplay';
			}
			if($img) {
				$player .= ' poster="'.$img.'"';
			}
			$player .= ' width="640" height="360">브라우저가 VIDEO 태그를 지원하지 않습니다.</video></div></div>';

			return $player;

		} else if($ext == "mp3" || $ext == "ogg" || $ext == "wav") {

			$player = '<audio src="'.$url.'" controls loop';
			if($is_auto) {
				$player .= ' autoplay';
			}
			$player .= ' style="width:100%;min-width:100%;">브라우저가 AUDIO 태그를 지원하지 않습니다.</audio>';

			return $player;
		}
	//}

	$video = na_check_ext('video');
	$audio = na_check_ext('audio');

	if($ext == "rss") {
		$type = 'plist';
		$cnt = na_jwplayer_list($url);
		if($cnt > 0) {
			;
		} else {
			return;
		}
	} else if(in_array($ext, $audio)) {
		$type = 'audio';
	} else if(in_array($ext, $video)) {
		$type = 'video';
	} else {
		return;
	}

	$jw_id = 'jw-'.na_rid();

	// 자동실행
	if($is_auto) {
		$auto = 'true';
		$mute = 'mute: "true",';
	} else {
		$auto = 'false';
		$mute = '';
	}

	$jw_script = '';	
	if($type == 'audio' && !$img && !$caption) {
		$jw_script .= '<script>
					    jwplayer("'.$jw_id.'").setup({
							file: "'.$url.'",
							title: "'.$title.'",
							autostart: "'.$auto.'",
							'.$mute.'
							width: "100%",
							height: "40",
							repeat: "file"
						});
					 </script>'.PHP_EOL;
	} else if($type == 'plist') {
		$plist = (G5_IS_MOBILE) ? 'aspectratio: "16:9", listbar: { position: "right", size:150 }' : 'aspectratio: "16:9", listbar: { position: "right", size:200 }';
		$jw_script .= '<script>
						jwplayer("'.$jw_id.'").setup({
							playlist: "'.$url.'",
							autostart: "'.$auto.'",
							'.$mute.'
							width: "100%",
							'.$plist.'
						});
					 </script>'.PHP_EOL;
	} else {
		$img = ($img) ? 'image: "'.$img.'",' : '';
		$caption = ($caption) ? 'tracks: [{file: "'.$caption.'"}],' : '';
		$jw_script .= '<script>
						jwplayer("'.$jw_id.'").setup({
							file: "'.$url.'",
							title: "'.$title.'",
							autostart: "'.$auto.'",
							'.$mute.'
							'.$img.'
							'.$caption.'
							aspectratio: "16:9",
							width: "100%"
						});
					 </script>'.PHP_EOL;
	}

	$jw = '';
	if($jw_script) {
		if(!defined('NA_JW6')) {
			define('NA_JW6', true);
			$nariya['jw6_key'] = isset($nariya['jw6_key']) ? $nariya['jw6_key'] : '';
			$jw .= '<script src="'.G5_THEME_URL.'/app/jwplayer/jwplayer.js"></script>'.PHP_EOL;
			$jw .= '<script>jwplayer.key="'.$nariya['jw6_key'].'";</script>'.PHP_EOL;
		}
		$jw .= '<div class="na-jwplayer"><div id="'.$jw_id.'">Loading the player...</div>'.PHP_EOL;
		$jw .= $jw_script;
		$jw .= '</div>'.PHP_EOL;
	}

	return $jw;
}

// 첨부 동영상 출력
function na_video_attach($attach='', $num='') {

	if(!$attach || !is_array($attach)) {
		global $view;

		$attach = array();
		$attach = $view['file'];
	}

	$video = '';
	$cinfo = array();
	$exceptfile = array();

	if($attach['count']) {

		$vext = na_check_ext();
		$vext[] = 'rss'; // jwplayer rss 추가

		for ($i=0; $i<$attach['count']; $i++) {

			if ($attach[$i]['source'] && !$attach[$i]['view']) {

				$ext = na_file_info($attach[$i]['source']);

				if(in_array($ext['ext'], $vext)) {

					$cinfo = na_get_caption($attach, $attach[$i]['source'], $i);

					$screen = (isset($cinfo[0]) && $cinfo[0]) ? $cinfo[0] : '';
					$caption = (isset($cinfo[1]) && $cinfo[1]) ? $cinfo[1] : '';
					$except = (isset($cinfo[2]) && is_array($cinfo[2])) ? $cinfo[2] : array();

					$title = ($attach[$i]['content']) ? $attach[$i]['content'] : $attach[$i]['source'];

					$video .= na_jwplayer($attach[$i]['path'].'/'.$attach[$i]['file'], $screen, $caption, $title);

					if(count($except) > 0) 
						$exceptfile = array_merge($exceptfile, $except);
				}
			}
		}

		// 동영상 이미지는 출력이미지에서 제외
		if(isset($view['file']) && count($exceptfile)) { 
			$refile = array();
			$j = 0;
			for ($i=0; $i<$attach['count']; $i++) {

				if (in_array($i, $exceptfile)) 
					continue;

				$refile[$j] = $attach[$i];
				$j++;
			}

			if($j > 0) {
				$view['file'] = $refile;
				$view['file']['count'] = $j;
			}
		}
	}

	return $video;
}

// 링크 동영상 출력
function na_video_link($link, $num='', $img='') {

	$vext = na_check_ext();

	$j = 0;
	$video = '';
	$link = (is_array($link)) ? $link : array();
	$img = (is_array($img)) ? $img : array();
	$link_cnt = count($link);
	for ($i=0; $i<=$link_cnt; $i++) {

		if(!isset($link[$i]) || !$link[$i]) 
			continue;

		list($url) = explode("|", $link[$i]);

		$url = str_replace("&amp;", "&", $url);
		$ext = strtolower(substr(strrchr(basename($url), "."), 1));
		$player = ($ext && in_array($ext, $vext)) ? na_jwplayer($url, $img[$i]) : na_video($url);

		if($player) {
			$video .= $player;
			$j++;
			if($num && $j == $num) return $video;
		}
	}

	return $video;
}

function na_wr_youtube($wr) {

	$content = '';

    // 링크
    for ($i=1; $i<=G5_LINK_COUNT; $i++) {
        $content .= set_http(get_text($wr["wr_link{$i}"])).' ';
    }

    $content .= $wr['wr_content'];

	$matchs = array();

	preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $matchs);

	$urls = isset($matchs[0]) ? $matchs[0] : array();

	foreach($urls as $url) {

		$vinfo = na_check_youtube($url);

		if($vinfo['vid'] && (!$vinfo['type'] || $vinfo['type'] == 'shorts'))
			return ($vinfo['type']) ? 'https://youtube.com/shorts/'.$vinfo['vid'] : 'https://youtu.be/'.$vinfo['vid'];
	}

	return;
}