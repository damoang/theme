<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// AJAX 상태 여부
$is_ajax = (isset($is_ajax_comment) && $is_ajax_comment) ? true : false;

// 자동 변환
$is_convert = (isset($boset['comment_convert']) && $boset['comment_convert']) ? 'na-content' : 'na-convert';

// 페이징 댓글
$is_paging = (isset($boset['comment_rows']) && $boset['comment_rows']) ? true : false;

// 댓글 추천 비추천 설정
$is_comment_good = (isset($boset['comment_good']) && $boset['comment_good']) ? true : false;
$is_comment_nogood = (isset($boset['comment_nogood']) && $boset['comment_nogood']) ? true : false;

// 댓글 스킨
$comment_skin = isset($boset['comment_skin']) && $boset['comment_skin'] ? $boset['comment_skin'] : 'basic';
$comment_skin_url = $board_skin_url.'/comment/'.$comment_skin;
$comment_skin_path = $board_skin_path.'/comment/'.$comment_skin;

$skin_file = $comment_skin_path.'/comment.skin.php';
if (is_file($skin_file)) {
	include_once $skin_file;
} else {
	echo '<div class="text-center px-3 py-5">'.str_replace(G5_PATH, '', $skin_file).' 스킨 파일이 없습니다.</div>'.PHP_EOL;
}
