<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 멤버십
na_membership('write', '멤버십 회원만 등록할 수 있습니다.');

//하루 글쓰기 개수 제한 체크
na_board_write_permit_check($bo_table, $member['mb_id']);

/*
* 회원만 보기 설정
*
* 설정/변경 권한을 체크하고, 권한이 없으면 기존 설정 유지
*/
if (!da_board_member_only_permit_check()) {
    if ($wr['wr_1'] == '1') {
        // 이미 회원만 보기 설정 글이라면 유지하거나 해제가능하도록 함
        $wr_1 = $wr_1 ?? '';
    } else {
        $wr_1 = $wr['wr_1'] ?? '';
    }
}
$wr_1 = get_text($wr_1 ?? '');
