<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Plugin Scripts
function na_script($id, $opt=''){
	global $config, $nariya;

	if($id == 'kakaotalk') {
		if(!defined('NA_KAKAO')) {
			define('NA_KAKAO', true);
			if($config['cf_kakao_js_apikey']) {
				echo '<script src="https://developers.kakao.com/sdk/js/kakao.min.js" async></script>'.PHP_EOL;
				echo 'var kakao_javascript_apikey = "'.$config['cf_kakao_js_apikey'].'";'.PHP_EOL;
				echo '<script src="'.G5_JS_URL.'/kakaolink.js?ver='.G5_JS_VER.'"></script>'.PHP_EOL;
			}
		}
	
	} else if($id == 'code') {
		if(!defined('NA_CODE')) {
			define('NA_CODE', true);
			add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/app/prism/prism.css">', 0);
			$sh = '<script src="'.G5_THEME_URL.'/app/prism/prism.js"></script>'.PHP_EOL;
			$sh .= '<script>var is_SyntaxHighlighter = true;</script>';
			add_javascript($sh, 0);
		}
	} else if($id == 'owl') {
		if(!defined('NA_OWL')) {
			define('NA_OWL', true);
			add_javascript('<script src="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.js"></script>', 0);
			add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.css">', 0);
		}
	} else if($id == 'mask') {
		if(!defined('NA_MASK')) {
			define('NA_MASK', true);
			include_once(G5_THEME_PATH.'/mask.php');
			add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/mask.css">', 0);
		}
	} else if($id == 'unitegallery') {
		if(!defined('NA_UG')) {
			define('NA_UG', true);
			add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/app/unitegallery/css/unite-gallery.css">', 0);
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/js/unitegallery.min.js"></script>', 0);
		}

		if($opt == 'tiles') {
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/themes/tiles/ug-theme-tiles.js"></script>', 0);
		} else if($opt == 'tilesgrid') {
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/themes/tilesgrid/ug-theme-tilesgrid.js"></script>', 0);
		} else if($opt == 'carousel') {
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/themes/carousel/ug-theme-carousel.js"></script>', 0);
		} else if($opt == 'compact') {
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/themes/compact/ug-theme-compact.js"></script>', 0);
		} else if($opt == 'grid') {
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/themes/grid/ug-theme-grid.js"></script>', 0);
		} else if($opt == 'slider') {
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/themes/slider/ug-theme-slider.js"></script>', 0);
		} else if($opt == 'video') {
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/themes/video/ug-theme-video.js"></script>', 0);
			add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/app/unitegallery/themes/video/skin-right-thumb.css">', 0);
		} else {
			add_javascript('<script src="'.G5_THEME_URL.'/app/unitegallery/themes/default/ug-theme-default.js"></script>', 0);
			add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/app/unitegallery/themes/default/ug-theme-default.css">', 0);
		}
	}

	return;
}