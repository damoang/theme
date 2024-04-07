<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 멤버십
na_membership('view', '멤버십 회원만 열람할 수 있습니다.');

// 제목
$view_subject = get_text($view['wr_subject']);

// 첨부 동영상 출력안함
$is_video_attach = (isset($boset['video_attach']) && $boset['video_attach']) ? false : true;

// 링크 동영상 출력안함
$is_video_link = (isset($boset['video_link']) && $boset['video_link']) ? false : true;

// 자동 변환
$is_convert = (isset($boset['post_convert']) && $boset['post_convert']) ? 'na-content' : 'na-convert';

// SyntaxHighLighter
if(isset($boset['code']) && $boset['code'])
	na_script('code');

// 분류 스킨
$view_skin = isset($boset['view_skin']) && $boset['view_skin'] ? $boset['view_skin'] : 'basic';
$view_skin_url = $board_skin_url.'/view/'.$view_skin;
$view_skin_path = $board_skin_path.'/view/'.$view_skin;

// 내용 스킨
$skin_file = $view_skin_path.'/view.skin.php';
if (is_file($skin_file)) {
	include_once $skin_file;
} else {
	echo '<div class="text-center px-3 py-5">'.str_replace(G5_PATH, '', $skin_file).' 스킨 파일이 없습니다.</div>'.PHP_EOL;
}