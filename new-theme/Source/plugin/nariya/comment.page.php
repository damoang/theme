<?php
if (!defined('_GNUBOARD_')) {
	define('G5_CAPTCHA', true);
	include_once('./_common.php');

	if (!$board['bo_table'])
	   die('존재하지 않는 게시판입니다.');

	if (!$write['wr_id'])
		die('글이 존재하지 않습니다.'.PHP_EOL.PHP_EOL.'글이 삭제되었거나 이동된 경우입니다.');

	if (!get_session('ss_view_'.$bo_table.'_'.$wr_id))
		die('잘못된 접근입니다.');

	check_device($board['bo_device']);

	// 그룹접근 사용
	if (isset($group['gr_use_access']) && $group['gr_use_access']) {
		if ($is_guest) {
			die('비회원은 이 게시판에 접근할 권한이 없습니다.'.PHP_EOL.PHP_EOL.'회원이시라면 로그인 후 이용해 보십시오.');
		}

		// 그룹관리자 이상이라면 통과
		if ($is_admin === "super" || $is_admin === "group") {
			;
		} else {
			// 그룹접근
			$sql = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$board['gr_id']}' and mb_id = '{$member['mb_id']}' ";
			$row = sql_fetch($sql);
			if (!$row['cnt']) {
				die('접근 권한이 없으므로 글읽기가 불가합니다.'.PHP_EOL.PHP_EOL.'궁금하신 사항은 관리자에게 문의 바랍니다.');
			}
		}
	}

	// 로그인된 회원의 권한이 설정된 읽기 권한보다 작다면
	if ($member['mb_level'] < $board['bo_read_level']) {
		if ($is_member)
			die('글을 읽을 권한이 없습니다.');
		else
			die('글을 읽을 권한이 없습니다.'.PHP_EOL.PHP_EOL.'회원이시라면 로그인 후 이용해 보십시오.'); 
	}

	// 본인확인을 사용한다면
    if ($board['bo_use_cert'] != '' && $config['cf_cert_use'] && !$is_admin) {
        // 인증된 회원만 가능
        if ($is_guest) {
			die('이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.'.PHP_EOL.PHP_EOL.'회원이시라면 로그인 후 이용해 보십시오.');
        }

        if (strlen($member['mb_dupinfo']) == 64 && $member['mb_certify']) { // 본인 인증 된 계정 중에서 di로 저장 되었을 경우에만
            //goto_url(G5_BBS_URL."/member_cert_refresh.php?url=".urlencode(get_pretty_url($bo_table, $wr_id, $qstr)));
			die('이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.'.PHP_EOL.PHP_EOL.'본인인증을 다시 해주세요.');
        }

        if ($board['bo_use_cert'] == 'cert' && !$member['mb_certify']) {            
			die('이 게시판은 본인확인 하신 회원님만 글읽기가 가능합니다.'.PHP_EOL.PHP_EOL.'회원정보 수정에서 본인확인을 해주시기 바랍니다.');
        }

        if ($board['bo_use_cert'] == 'adult' && !$member['mb_adult']) {
			die('이 게시판은 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.'.PHP_EOL.PHP_EOL.'현재 성인인데 글읽기가 안된다면 회원정보 수정에서 본인확인을 다시 해주시기 바랍니다.');
        }
    }

	// 자신의 글이거나 관리자라면 통과
	if (($write['mb_id'] && $write['mb_id'] === $member['mb_id']) || $is_admin) {
		;
	} else {
		// 비밀글이라면
		if (strstr($write['wr_option'], "secret")) {
			// 회원이 비밀글을 올리고 관리자가 답변글을 올렸을 경우
			// 회원이 관리자가 올린 답변글을 바로 볼 수 없던 오류를 수정
			$is_owner = false;
			if ($write['wr_reply'] && $member['mb_id'])	{
				$sql = " select mb_id from {$write_table} where wr_num = '{$write['wr_num']}' and wr_reply = '' and wr_is_comment = 0 ";
				$row = sql_fetch($sql);
				if ($row['mb_id'] === $member['mb_id'])
					$is_owner = true;
			}

			$ss_name = 'ss_secret_'.$bo_table.'_'.$write['wr_num'];

			if (!$is_owner)	{
				if (!get_session($ss_name))
					die('비밀글은 본인과 관리자만 볼 수 있습니다.');
			}
		}
	}

	// 새로운 댓글 체크
	if(isset($cnew) && $cnew) {
		$msg = ((int)$write['wr_comment'] === (int)$count) ? '새로운 댓글이 없습니다.' : '';
		die($msg);
	}

	// IP
	$is_ip_view = $board['bo_use_ip_view'];
	if ($is_admin) {
		$is_ip_view = true;
	}

	// 신고/차단 댓글 체크
	$singo_write = na_singo_array('write', $bo_table);

	$view = get_view($write, $board, $board_skin_path);

	$is_ajax_comment = true;
} else {
	$is_ajax_comment = false;
	$is_list_page = $page;
	$page = 0;
}

include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$captcha_html = "";
if ($is_guest && $board['bo_comment_level'] < 2) {
    $captcha_html = captcha_html('_comment');
}

$c_id = isset($_GET['c_id']) ? clean_xss_tags($_GET['c_id'], 1, 1) : '';
$c_wr_content = '';
$na_comment_where = '';
@include_once($board_skin_path.'/view_comment.head.skin.php');

$list = array();

$is_comment_write = false;
if ($member['mb_level'] >= $board['bo_comment_level'])
    $is_comment_write = true;

if (count($singo_write) > 0)
	$na_comment_where .= na_sql_find('wr_id', implode(',', $singo_write), 1);

// 차단회원글 제외
if ($is_member && isset($member['as_chadan']) && trim($member['as_chadan']))
	$na_comment_where .= na_sql_find('mb_id', trim($member['as_chadan']), 1);

// 코멘트 출력
$sql_common = "from {$write_table} where wr_parent = '{$wr_id}' and wr_is_comment = '1' $na_comment_where ";

if ($na_comment_where) {
	$row = sql_fetch(" select count(*) as cnt " . $sql_common);
	$total_count = $row['cnt'];
} else {
	$total_count = (int)$write['wr_comment'];
}

$crows = isset($boset['comment_rows']) ? (int)$boset['comment_rows'] : 0;
$crows = ($crows > 0) ? $crows : 20;

$total_page  = ceil($total_count / $crows);  // 전체 페이지 계산

// 댓글 정렬
$cob = isset($cob) ? $cob : '';
$boset['comment_sort'] = isset($boset['comment_sort']) ? $boset['comment_sort'] : '';

if(!$cob && $boset['comment_sort']) {
	$cob = $boset['comment_sort'];
}

if($cob == 'new') {
	$start_page = 1;
	$comment_orderby = 'wr_comment desc, wr_comment_reply';
} else if($cob == 'good') {
	$start_page = 1;
	$comment_orderby = 'wr_good desc, wr_comment, wr_comment_reply';
} else if($cob == 'nogood') {
	$start_page = 1;
	$comment_orderby = 'wr_nogood desc, wr_comment, wr_comment_reply';
} else if($cob == 'star') {
	$start_page = 1;
	$comment_orderby = 'as_star_score desc, wr_comment, wr_comment_reply';
} else {
	$cob = 'old';
	$start_page = $total_page;
	$comment_orderby = 'wr_comment, wr_comment_reply';
}

if($page && $page > 0) {
	;
} else {
	$page = $start_page; // 페이지가 없으면 마지막 페이지
}

$from_record = ($page - 1) * $crows; // 시작 열을 구함
if($from_record < 0)
	$from_record = 0;

$sql = " select * $sql_common order by $comment_orderby limit $from_record, $crows ";
$result = sql_query($sql);
if($result) {
	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$list[$i] = $row;

		//$list[$i]['name'] = get_sideview($row['mb_id'], cut_str($row['wr_name'], 20, ''), $row['wr_email'], $row['wr_homepage']);

		$tmp_name = get_text(cut_str($row['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
		if ($board['bo_use_sideview'])
			$list[$i]['name'] = get_sideview($row['mb_id'], $tmp_name, $row['wr_email'], $row['wr_homepage']);
		else
			$list[$i]['name'] = '<span class="'.($row['mb_id']?'member':'guest').'">'.$tmp_name.'</span>';

		// 공백없이 연속 입력한 문자 자르기 (way 보드 참고. way.co.kr)
		//$list[$i]['content'] = eregi_replace("[^ \n<>]{130}", "\\0\n", $row['wr_content']);

		$list[$i]['content'] = $list[$i]['content1']= '비밀댓글 입니다.';
		if (!strstr($row['wr_option'], 'secret') ||
			$is_admin ||
			($write['mb_id']===$member['mb_id'] && $member['mb_id']) ||
			($row['mb_id']===$member['mb_id'] && $member['mb_id'])) {
			$list[$i]['content1'] = $row['wr_content'];
			$list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');
			$list[$i]['content'] = search_font($stx, $list[$i]['content']);
		} else {

			// 대댓글의 비밀글을 원댓글쓴이에게도 보이기
			$is_pre_commenter = false;
			if($row['wr_comment_reply'] && $member['mb_id']) {
				$pre_cmt = sql_fetch(" select mb_id from {$write_table} where wr_parent = '$wr_id' and wr_is_comment = 1 and wr_comment = '{$row['wr_comment']}' and wr_comment_reply = '".substr($row['wr_comment_reply'],0,-1)."' "); 
				if($pre_cmt['mb_id'] && $pre_cmt['mb_id'] === $member['mb_id']) {
					$is_pre_commenter = true;
				}		
			}

			$ss_name = 'ss_secret_comment_'.$bo_table.'_'.$list[$i]['wr_id'];

			if(get_session($ss_name) || $is_pre_commenter) {
				$list[$i]['content'] = conv_content($row['wr_content'], 0, 'wr_content');
				$list[$i]['content'] = search_font($stx, $list[$i]['content']);
			} else {
				$list[$i]['content'] = '<a href="'.G5_BBS_URL.'/password.php?w=sc&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].$qstr.'" class="s_cmt">댓글내용 확인</a>';
			}
		}

		$list[$i]['datetime'] = substr($row['wr_datetime'],2,14);

		// 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
		$list[$i]['ip'] = $row['wr_ip'];
		if (!$is_admin)
			$list[$i]['ip'] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['wr_ip']);

		$list[$i]['is_reply'] = false;
		$list[$i]['is_edit'] = false;
		$list[$i]['is_del']  = false;
		if ($is_comment_write || $is_admin) {

			$token = '';

			if ($member['mb_id']) {

				if ($row['mb_id'] === $member['mb_id'] || $is_admin) {

					set_session('ss_delete_comment_'.$row['wr_id'].'_token', $token = uniqid(time()));
					$list[$i]['del_link']  = G5_BBS_URL.'/delete_comment.php?bo_table='.$bo_table.'&amp;comment_id='.$row['wr_id'].'&amp;token='.$token.'&amp;page='.$page.$qstr;
					$list[$i]['del_href']  = NA_URL.'/comment.delete.php?bo_table='.$bo_table.'&comment_id='.$row['wr_id'].'&token='.$token;
					$list[$i]['del_back']  = NA_URL.'/comment.page.php?bo_table='.$bo_table.'&wr_id='.$wr_id.'&page='.$page.'&cob='.$cob;
					$list[$i]['is_edit']   = true;
					$list[$i]['is_del']    = true;

				}

			} else {

				if (!$row['mb_id']) {
					$list[$i]['del_href']  = '';
					$list[$i]['del_back']  = '';
					$list[$i]['del_link'] = G5_BBS_URL.'/password.php?w=x&amp;bo_table='.$bo_table.'&amp;comment_id='.$row['wr_id'].'&amp;page='.$page.$qstr;
					$list[$i]['is_del']   = true;
				}
			}

			if (strlen($row['wr_comment_reply']) < 5)
				$list[$i]['is_reply'] = true;
		}

		// 05.05.22
		// 답변있는 코멘트는 수정, 삭제 불가
		if ($i > 0 && !$is_admin) {

			if ($row['wr_comment_reply']) {

				$tmp_comment_reply = substr($row['wr_comment_reply'], 0, strlen($row['wr_comment_reply']) - 1);
				
				if ($tmp_comment_reply == $list[$i-1]['wr_comment_reply']) {
					$list[$i-1]['is_edit'] = false;
					$list[$i-1]['is_del'] = false;
				}
			}
		}
	}
}

//  코멘트수 제한 설정값
if(!$is_ajax_comment) {
	if ($is_admin) {
		$comment_min = $comment_max = 0;
	} else {
		$comment_min = (int)$board['bo_comment_min'];
		$comment_max = (int)$board['bo_comment_max'];
	}
}

$comment_url = NA_URL.'/comment.page.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;cob='.$cob;
$comment_page = NA_URL.'/comment.page.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;cob='.$cob.'&amp;page=';
$comment_action_url = https_url(G5_PLUGIN_DIR.'/'.NA_DIR)."/comment.write.php";
$comment_common_url = short_url_clean(G5_BBS_URL.'/board.php?'.clean_query_string($_SERVER['QUERY_STRING']));
$write_pages = G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'];

include_once($board_skin_path.'/view_comment.skin.php');

if(!$is_ajax_comment) {
	if (!$member['mb_id']) // 비회원일 경우에만
		echo '<script src="'.G5_JS_URL.'/md5.js"></script>'."\n";

	@include_once($board_skin_path.'/view_comment.tail.skin.php');

	$page = $is_list_page;
}