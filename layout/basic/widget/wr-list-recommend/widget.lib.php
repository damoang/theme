<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// 기간 체크 시간 단위로
function sql_hrterm($term, $field) {
    $sql_term = '';
    if($term && $field) {
        if ($term > 0 || $term == 'hour') {
            $term = ($term == 'hour') ? 0 : $term;
            $chk_term = date("Y-m-d H:i:s", G5_SERVER_TIME - ((int)$term * 3600));
            $sql_term = " and $field >= '{$chk_term}' ";
        }
    }

    return $sql_term;
}

// 게시물 추출
function na_board_rows_custom($wset)
{
    global $g5;

    $caches = false;
    $is_cache = isset($wset['cache']) ? (int) $wset['cache'] : 0;
    if ($is_cache > 0) {
        $caches = g5_get_cache($wset['cacheId'], $is_cache * 60);
    }

    // 캐시값 넘김
    if (isset($caches['list']) && is_array($caches['list']))
        return $caches['list'];

    $list = array();

    $rows = isset($wset['rows']) ? (int) $wset['rows'] : 0;
    $rows = ($rows > 0) ? $rows : 7;
    $page = isset($wset['page']) ? (int) $wset['page'] : 0;
    $page = ($page > 1) ? $page : 1;

    $wset['rows_notice'] = isset($wset['rows_notice']) ? $wset['rows_notice'] : '';
    $wset['bo_list'] = isset($wset['bo_list']) ? $wset['bo_list'] : '';
    $wset['bo_except'] = isset($wset['bo_except']) ? $wset['bo_except'] : '';
    $wset['gr_list'] = isset($wset['gr_list']) ? $wset['gr_list'] : '';
    $wset['gr_except'] = isset($wset['gr_except']) ? $wset['gr_except'] : '';
    $wset['ca_list'] = isset($wset['ca_list']) ? $wset['ca_list'] : '';
    $wset['ca_except'] = isset($wset['ca_except']) ? $wset['ca_except'] : '';
    $wset['mb_list'] = isset($wset['mb_list']) ? $wset['mb_list'] : '';
    $wset['mb_except'] = isset($wset['mb_except']) ? $wset['mb_except'] : '';
    $wset['list_content'] = isset($wset['list_content']) ? $wset['list_content'] : '';
    $wset['sideview'] = isset($wset['sideview']) ? $wset['sideview'] : '';
    $wset['list_file'] = isset($wset['list_file']) ? $wset['list_file'] : '';

    $wset['term'] = isset($wset['term']) ? $wset['term'] : '';
    $wset['dayterm'] = isset($wset['dayterm']) ? (int) $wset['dayterm'] : 0;
    $wset['hrterm'] = isset($wset['hrterm']) ? (int) $wset['hrterm'] : 0;
    $wset['sort'] = isset($wset['sort']) ? $wset['sort'] : '';
    $wset['wr_image'] = isset($wset['wr_image']) ? $wset['wr_image'] : '';
    $wset['wr_video'] = isset($wset['wr_video']) ? $wset['wr_video'] : '';
    $wset['wr_singo'] = isset($wset['wr_singo']) ? $wset['wr_singo'] : '';
    $wset['wr_notice'] = isset($wset['wr_notice']) ? $wset['wr_notice'] : '';
    $wset['wr_secret'] = isset($wset['wr_secret']) ? $wset['wr_secret'] : '';
    $wset['wr_chadan'] = isset($wset['wr_chadan']) ? $wset['wr_chadan'] : '';
    $wset['wr_comment'] = isset($wset['wr_comment']) ? $wset['wr_comment'] : '';

    $bo_table = $wset['bo_list'];
    $term = ($wset['term'] == 'day') ? $wset['dayterm'] : $wset['term'];
    $sql_where = (isset($wset['where']) && $wset['where']) ? 'and ' . $wset['where'] : '';
    $sql_orderby = (isset($wset['orderby']) && $wset['orderby']) ? $wset['orderby'] . ',' : '';

    $post = array();
    $i_start = 0;
    if ($wset['wr_notice']) { // 공지글

        // 추출게시판 정리
        list($plus, $minus) = na_bo_list($wset['gr_list'], $wset['gr_except'], $wset['bo_list'], $wset['bo_except']);
        $sql_notice = na_sql_find('bo_table', $plus, 0);
        $sql_notice .= na_sql_find('bo_table', $minus, 1);

        $result = sql_query(" select bo_table, bo_subject, bo_notice from {$g5['board_table']} where (1) $sql_notice ");
        if ($result) {
            for ($i = 0; $row = sql_fetch_array($result); $i++) {

                $row['bo_notice'] = trim($row['bo_notice']);

                if (!$row['bo_notice'])
                    continue;

                $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

                $result1 = sql_query(" select * from $tmp_write_table where find_in_set(wr_id, '{$row['bo_notice']}') ");
                if ($result1) {
                    for ($j = 0; $row1 = sql_fetch_array($result1); $j++) {

                        $row1['is_notice'] = true;
                        $row1['bo_table'] = $row['bo_table'];
                        $row1['bo_subject'] = $row['bo_subject'];

                        $post[] = $row1;
                    }
                }
            }
        }

        $post_cnt = count($post);

        if ($post_cnt)
            $post = na_sort($post, 'wr_datetime', true);

        $post_cnt = ($post_cnt > $rows) ? $rows : $post_cnt;

        for ($i = 0; $i < $post_cnt; $i++) {
            $list[$i] = na_wr_row($post[$i], $wset);
        }

        $i_start = $i;
    }

    unset($post);

    if ($wset['rows_notice'])
        $rows = $rows - $i_start;

    if ($rows > 0) {
        $start_rows = 0;
        $board_cnt = na_explode(',', $bo_table);

        // 차단회원 체크
        $is_chadan = false;
        if ($wset['wr_chadan'] && !$is_cache) {
            global $member, $is_member;

            $chadan_list = ($is_member && isset($member['as_chadan']) && trim($member['as_chadan'])) ? na_explode(',', $member['as_chadan']) : array();
            $chadan_count = count($chadan_list);

            // 차단회원글 제외
            if ($chadan_count)
                $is_chadan = true;
        }

        if (!$bo_table || count($board_cnt) > 1 || $wset['bo_except']) {

            // 정렬
            $sql_orderby .= na_sql_sort('new', $wset['sort']);

            // 회원글
            $sql_where .= na_sql_find('a.mb_id', $wset['mb_list'], $wset['mb_except']);

            // 차단회원글
            if ($is_chadan)
                $sql_where .= na_sql_find('a.mb_id', trim($member['as_chadan']), 1);

            // 추출게시판 정리
            list($plus, $minus) = na_bo_list($wset['gr_list'], $wset['gr_except'], $wset['bo_list'], $wset['bo_except']);
            $sql_where .= na_sql_find('a.bo_table', $plus, 0);
            $sql_where .= na_sql_find('a.bo_table', $minus, 1);

            // 기간(일수,today,yesterday,month,prev)
            if ($term == 'hour')
                $sql_where .= sql_hrterm($wset['hrterm'], 'a.bn_datetime');
            else
                $sql_where .= na_sql_term($term, 'a.bn_datetime');

            // 댓글
            $sql_where .= ($wset['wr_comment']) ? " and a.wr_is_comment = '1'" : " and a.wr_is_comment = '0'";

            // 이미지
            $sql_where .= ($wset['wr_image']) ? " and a.wr_image <> ''" : "";

            // 유튜브
            $sql_where .= ($wset['wr_video']) ? " and a.wr_video <> ''" : "";

            // 비밀글
            $sql_where .= ($wset['wr_secret']) ? "" : " and a.wr_is_secret = '0'";

            // 잠금글
            $sql_where .= ($wset['wr_singo']) ? "" : " and a.wr_singo != 'lock'";

            // 공통쿼리
            $sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b where a.bo_table = b.bo_table and b.bo_use_search = 1 $sql_where ";
            if ($page > 1) {
                $total = sql_fetch("select count(*) as cnt $sql_common ");
                $total_count = $total['cnt'];
                $total_page = ceil($total_count / $rows);  // 전체 페이지 계산
                $start_rows = ($page - 1) * $rows; // 시작 열을 구함
            }

            $result = sql_query(" select a.bo_table, a.wr_id, b.bo_subject $sql_common order by $sql_orderby limit $start_rows, $rows ", true);
            if ($result) {

                for ($i = $i_start; $row = sql_fetch_array($result); $i++) {

                    $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

                    $wr = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");

                    $wr['bo_table'] = $row['bo_table'];
                    $wr['bo_subject'] = $row['bo_subject'];

                    $list[$i] = na_wr_row($wr, $wset);
                }
            }

        } else { //단수

            // 정렬
            $sql_orderby .= na_sql_sort('bo', $wset['sort']);

            // 회원글
            $sql_where .= na_sql_find('mb_id', $wset['mb_list'], $wset['mb_except']);

            // 차단회원글
            if ($is_chadan)
                $sql_where .= na_sql_find('mb_id', trim($member['as_chadan']), 1);

            // 기간(일수,today,yesterday,month,prev)
            if ($wset['term'] == 'hour')
                $sql_where .= sql_hrterm($wset['hrterm'], 'wr_datetime');
            else
                $sql_where .= na_sql_term($term, 'wr_datetime');

            // 분류
            $sql_where .= na_sql_find('ca_name', $wset['ca_list'], $wset['ca_except']);

            // 이미지
            $sql_where .= ($wset['wr_image']) ? " and wr_10 <> ''" : "";

            // 유튜브
            $sql_where .= ($wset['wr_video']) ? " and wr_9 <> ''" : "";

            // 비밀글
            $sql_where .= ($wset['wr_secret']) ? "" : na_sql_find('wr_option', 'secret', 1);

            // 잠금글
            $sql_where .= ($wset['wr_singo']) ? "" : " and wr_7 <> 'lock'";

            // 댓글
            $wr_comment = ($wset['wr_comment']) ? 1 : 0;

            $tmp_write_table = $g5['write_prefix'] . $bo_table;

            $sql_common = "from $tmp_write_table where wr_is_comment = '$wr_comment' $sql_where";

            if ($page > 1) {
                $total = sql_fetch("select count(*) as cnt $sql_common ");
                $total_count = $total['cnt'];
                $total_page = ceil($total_count / $rows);  // 전체 페이지 계산
                $start_rows = ($page - 1) * $rows; // 시작 열을 구함
            }
            $result = sql_query(" select * $sql_common order by $sql_orderby limit $start_rows, $rows ");
            if ($result) {
                for ($i = $i_start; $row = sql_fetch_array($result); $i++) {

                    $row['bo_table'] = $bo_table;

                    $list[$i] = na_wr_row($row, $wset);
                }
            }
        }
    }

    // 캐싱
    if ($is_cache > 0) {
        $caches = array('list' => $list);
        g5_set_cache($wset['cacheId'], $caches, $is_cache * 60);
    }

    return $list;
}
