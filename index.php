<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

//banner array 2024.04.24 by munbbok
function getDisplayAdBanner($type = 1){
    $arrBanner = Array(
      Array(
        'type'=>1,
        'img'=>'/banners/images/dmb-1.jpg',
        'link'=>'https://smartstore.naver.com/damoang-net',
        'target'=>'_blank',
        'display'=>true
      ),
      Array(
        'type'=>1,
        'img'=>'/banners/images/dmb-2.jpg',
        'link'=>'https://smartstore.naver.com/damoang-net',
        'target'=>'_blank',
        'display'=>true
      ),
      Array(
        'type'=>1,
        'img'=>'/banners/images/dmb-3.jpg',
        'link'=>'https://smartstore.naver.com/damoang-net',
        'target'=>'_blank',
        'display'=>true
      ),
      Array(
        'type'=>1,
        'img'=>'/banners/images/dmb-4.jpg',
        'link'=>'https://smartstore.naver.com/damoang-net',
        'target'=>'_blank',
        'display'=>true
      ),
      Array(
        'type'=>1,
        'img'=>'/banners/images/dmb-5.jpg',
        'link'=>'https://smartstore.naver.com/damoang-net',
        'target'=>'_blank',
        'display'=>true
      ),
      Array(
        'type'=>1,
        'img'=>'/banners/images/dmb-6.jpg',
        'link'=>'https://smartstore.naver.com/damoang-net',
        'target'=>'_blank',
        'display'=>true
      ),
      Array(
        'type'=>1,
        'img'=>'/banners/images/dmb-7.jpg',
        'link'=>'https://smartstore.naver.com/damoang-net',
        'target'=>'_blank',
        'display'=>true
      ),
      Array(
        'type'=>2,
        'img'=>'/banners/images/dmb-s1.jpg',
        'link'=>'https://smartstore.naver.com/damoang-net',
        'target'=>'_blank',
        'display'=>true
      ),
    );
    
    $_result = Array();
    foreach($arrBanner as $k => $v){
        if($type === $v['type']) $_result[] = $v;
    }
    shuffle($_result);
    return $_result[0];
}
include_once(G5_THEME_PATH.'/head.php');

include_once(LAYOUT_PATH.'/index.php');

include_once(G5_THEME_PATH.'/tail.php');