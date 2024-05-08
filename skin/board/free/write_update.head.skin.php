<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 멤버십
na_membership('write', '멤버십 회원만 등록할 수 있습니다.');

//하루 글쓰기 개수 제한 체크
na_board_write_permit_check($bo_table, $member['mb_id']);
