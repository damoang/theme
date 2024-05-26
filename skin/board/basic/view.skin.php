<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 회원만 보기가 설정되어 있고, 접속한 회원의 레벨이 2 미만인 경우
// 회원만 가능
if ($view['wr_1'] == '1' && $member['mb_level'] < 2) {
    alert('우리 "앙"님만 열람할 수 있어요!');
    return;
}

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

// 다모앙 회원 메모
$view = run_replace('da_board_view', $view);
$view = run_replace('board_view', $view);

// 회원만 보기
$view['da_is_member_only'] = false;
$view['da_member_only'] = '';

if ($view['wr_1'] == '1') {
    $view['da_is_member_only'] = true;
    $view['da_member_only'] = '<em class="border rounded p-1" style="font-size: 0.75em; font-style: normal;">회원만</em>';
}

// 카테고리 이동
if (!empty($boset['check_category_move'] && isset($_POST['targetCategory']) && isset($_POST['targetWrId']))) {
    $relativePath = '../../../app/change.category.php';
    $currentPath = __DIR__;
    $absolutePath = realpath($currentPath . '/' . $relativePath);
    include($absolutePath);

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

// 내용 스킨
$skin_file = $view_skin_path.'/view.skin.php';
if (is_file($skin_file)) {
    include_once $skin_file;
} else {
    echo '<div class="text-center px-3 py-5">'.str_replace(G5_PATH, '', $skin_file).' 스킨 파일이 없습니다.</div>'.PHP_EOL;
}
