<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

class NARIYA_STANDARD {

    // Hook 포함 클래스 작성 요령
    // https://github.com/Josantonius/PHP-Hook/blob/master/tests/Example.php
    /**
     * Class instance.
     */

    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    public static function singletonMethod() {
        return self::getInstance();
    }

    public function __construct() {

		$this->add_hooks();
    }

	public function add_hooks() {

		// 관리자 페이지
		if(defined('G5_IS_ADMIN')) {

			// 입력필드 업데이트
			add_replace('head_css_url', array($this, 'head_css_url'), 10, 2);

			// 관리자 메인 메뉴 추가
			add_replace('admin_amenu', array($this, 'admin_amenu'), 1, 1);

			// 관리자 서브 메뉴 추가
			add_replace('admin_menu', array($this, 'admin_menu'), 1, 1);

			// 관리자 공통
			add_event('admin_common', array($this, 'admin_common'));

			// 메뉴 캐시 생성
			add_event('admin_menu_list_update', array($this, 'admin_menu_list_update'));

			// 게시판 삭제
			add_event('admin_board_list_update', array($this, 'admin_board_list_update'), 1, 4);

		} else {

			// 경고창
			add_event('alert', array($this, 'alert'), 1, 4);

			// 경고창(팝업창)
			add_event('alert_close', array($this, 'alert_close'), 1, 2);
		} 

		// 1:1 문의 설정 체크
		add_replace('get_qa_config', array($this, 'get_qa_config'), 1, 1);

		// 1:1 문의 모바일 스킨경로 재설정
		add_replace('qa_mobile_content_head', array($this, 'qa_mobile_content_head'), 1, 2);

		// 쪽지발송
		add_event('memo_form_update_before', array($this, 'memo_form_update_before'), 1, 1);

		// 게시물 등록
		add_event('write_update_after', array($this, 'write_update_after'), 1, 5);
		
		// 댓글등록
		add_event('comment_update_after', array($this, 'comment_update_after'), 10, 5);

		// 게시물 삭제
		add_event('bbs_delete', array($this, 'bbs_delete'), 10, 2);

		// 게시물 선택삭제
		add_event('bbs_delete_all', array($this, 'bbs_delete_all'), 10, 2);

		// 게시물 이동/복사
		add_event('bbs_move_update', array($this, 'bbs_move_update'), 10, 4);

		// 게시물 추천
		add_event('bbs_good_before', array($this, 'bbs_good_before'), 10, 3);
		add_event('bbs_increase_good_json', array($this, 'bbs_increase_good_json'), 10, 3);

		// 댓글 추천
		add_event('comment_good_before', array($this, 'comment_good_before'), 10, 3);
		add_event('comment_increase_good_json', array($this, 'comment_increase_good_json'), 10, 3);

		// 1:1 문의
		add_event('qawrite_update', array($this, 'qawrite_update'), 10, 4);

		// 새게시물 삭제
		add_event('bbs_new_delete', array($this, 'bbs_new_delete'), 10, 2);

		// 경험치 체크
		add_event('member_login_check', array($this, 'member_login_check'), 10, 3);

		// 자동등업
		add_event('tail_sub', array($this, 'tail_sub'), 10, 0);

		//=====================================================================
		// 영카트 쇼핑몰
		//=====================================================================
		if(IS_YC) {

			// 메뉴 캐시 생성
			add_event('admin_shop_menu_update', array($this, 'admin_shop_menu_update'));

			// 사용후기 삭제
			add_event('shop_item_use_deleted', array($this, 'shop_item_use_deleted'), 10, 2);

			// 상품문의
			add_event('shop_item_qa_deleted', array($this, 'shop_item_qa_deleted'), 10, 2);

		} // end IS_YC

	} // end function

	// 관리자 메인 메뉴 추가
	public function admin_amenu($admin_amenu){
		global $nariya;

		$admin_amenu['800'] = 'nariya_amenu';

		@ksort($admin_amenu);

		return $admin_amenu;

	} // end function

	// 관리자 서브 메뉴 추가
	public function admin_menu($admin_menu){
		global $nariya;

		$admin_menu['menu800'] = array(
			array('800000', '나리야 빌더', NA_ADMIN_URL.'/admin.php', 'nariya'),
		);

		$admin_menu['menu800'][] = array('800100', '나리야 설정', NA_ADMIN_URL.'/admin.php', 'nariya_config');
		if(IS_YC) {
			$admin_menu['menu800'][] = array('800200', '쇼핑몰 메뉴', NA_ADMIN_URL.'/menu_shop.php', 'nariya_menu');
		}
		$admin_menu['menu800'][] = array('800300', '경험치 관리', NA_ADMIN_URL.'/exp.php', 'nariya_exp');
		$admin_menu['menu800'][] = array('800400', '신고글 관리', NA_ADMIN_URL.'/singo.php', 'nariya_singo');


		return $admin_menu;

	} // end function

	// 관리자 공통
	public function admin_common(){
		global $sub_menu;

		if($sub_menu == '400300') { //상품정보 등록폼
			global $it;

			$it['it_1_subj'] = '유튜브 영상 주소';
			$it['it_8_subj'] = '맴버십 설정(DB칼럼,기간,등급)';
			$it['it_9_subj'] = '무배송 상품';
			$it['it_10_subj'] = '타이틀 이미지 주소';
		}

	} // end function

	public function head_css_url($css_url, $g5_url){
		global $sub_menu;

		if(IS_YC) {
			// 상품분류 등록폼 여분필드 정의
			if($sub_menu == '400200') {
				global $ca;

				$ca['ca_9_subj'] = '메뉴 아이콘(ex, bi-house)';
				$ca['ca_10_subj'] = '타이틀 이미지 주소';
			}
		}

		return $css_url;

	} // end function

	// 메뉴 아이템 가공
	public function check_menu_item($it){
	    global $config;

		$me = array();
		$me = $it;

		// 값 삭제	
		unset($me['me_id']);
		unset($me['me_use']);
		unset($me['me_mobile_use']);
		unset($me['me_order']);

		// 값 정리
		$me['me_link'] = short_url_clean($it['me_link']);
		$me['id'] = '';

		if (strpos($me['me_link'], G5_URL) !== false) {

			// 링크 정리
			$url = @parse_url(str_replace(G5_URL.'/', '', $it['me_link']));
			$url['path'] = isset($url['path']) ? $url['path'] : '';
			$url['file'] = basename($url['path'],".php");
			$url['query'] = isset($url['query']) ? $url['query'] : '';
			@parse_str($url['query'], $query);
			
			// 짧은 주소 체크
		    if (isset($config['cf_bbs_rewrite']) && $config['cf_bbs_rewrite']){

				$path = explode('/', $url['path']);
				$bo_table = isset($path[0]) ? $path[0] : '';
				$wr_id = isset($path[1]) ? $path[1] : '';

				$warr = explode('-', $wr_id);
				$stype = isset($warr[0]) ? $warr[0] : '';
				$sval = isset($warr[1]) ? $warr[1] : '';

				if (IS_YC && $bo_table == 'shop' && $stype == 'list') {
					$url['file'] = 'list';
					$query['ca_id'] = $sval;
				} else if (IS_YC && $bo_table == 'shop' && $stype == 'type') {
					$url['file'] = 'listtype';
					$query['type'] = $sval;
				} else if (IS_YC && $bo_table == 'shop' && $wr_id) {
					$url['file'] = 'item';
					if (preg_match('/[^0-9a-zA-Z_]+/i', $wr_id)) {
						$query['it_seo_title'] = urldecode($wr_id);
					} else {
						$query['it_id'] = $wr_id;
					}
				} else if ($bo_table == 'content') {
					$url['file'] = 'content';
					if (preg_match('/[^0-9a-zA-Z_]+/i', $wr_id)) {
						$query['co_seo_title'] = urldecode($wr_id);
					} else {
						$query['co_id'] = $wr_id;
					}
				} else {
					$bo_table = preg_replace('/[^a-z0-9_]/i', '', trim($bo_table));
					$bo_table = substr($bo_table, 0, 20);
					$board = get_board_db($bo_table, true);
					if (isset($board['bo_table']) && $board['bo_table']) {
						$url['file'] = ($wr_id == 'write') ? 'write' : 'board';
						$query['bo_table'] = $bo_table;
						if($url['file'] == 'board') {
							$query['sca'] = isset($query['sca']) ? urldecode($query['sca']) : '';
							if (preg_match('/[^0-9]+/i', $wr_id)) {
								$query['wr_seo_title'] = urldecode($wr_id);
							} else {
								$query['wr_id'] = $wr_id;
							}
						}
					}
				}
			}

			// 값정리
			$name = na_explode('|', $me['me_name']);
			$me['me_name'] = isset($name[0]) ? $name[0] : $me['me_name'];
			$me['icon'] = isset($name[1]) ? $name[1] : '';
			$me['file'] = isset($url['file']) ? $url['file'] : '';
			$me['gr_id'] = isset($query['gr_id']) ? $query['gr_id'] : '';
			$me['bo_table'] = isset($query['bo_table']) ? $query['bo_table'] : '';
			$me['wr_id'] = isset($query['wr_id']) ? $query['wr_id'] : '';
			$me['wr_seo_title'] = isset($query['wr_seo_title']) ? $query['wr_seo_title'] : '';
			$me['sca'] = isset($query['sca']) ? $query['sca'] : '';
			$me['type'] = isset($query['type']) ? $query['type'] : '';
			$me['ca_id'] = isset($query['ca_id']) ? $query['ca_id'] : '';
			$me['it_id'] = isset($query['it_id']) ? $query['it_id'] : '';
			$me['it_seo_title'] = isset($query['it_seo_title']) ? $query['it_seo_title'] : '';
			$me['co_id'] = isset($query['co_id']) ? $query['co_id'] : '';
			$me['co_seo_title'] = isset($query['co_seo_title']) ? $query['co_seo_title'] : '';

			$is_pid = false;
			if($me['bo_table'] && ($me['file'] == 'board' || $me['file'] == 'write')) {
				$me_id = array(G5_BBS_DIR, 'board', $me['bo_table']);

				if($me['sca'])
					$me_id[] = $me['sca'];

			} else if($me['file'] == 'content') {
				$me_id = array(G5_BBS_DIR, 'content');

				if($me['co_id'])
					$me_id[] = $me['co_id'];

				if($me['co_seo_title'])
					$me_id[] = $me['co_seo_title'];
			} else if($me['file'] == 'group') {
				$me_id = array(G5_BBS_DIR, 'group', $me['gr_id']);
			} else if($me['file'] == 'qalist' || $me['file'] == 'qaview' || $me['file'] == 'qawrite') {
				$me_id = array(G5_BBS_DIR, 'qa');
			} else if($me['file'] == 'list') {
				$me_id = array(G5_SHOP_DIR, 'shop', 'list', $me['ca_id']);
			} else if($me['file'] == 'listtype') {
				$me_id = array(G5_SHOP_DIR, 'shop', 'type', $me['type']);
			} else if($me['file'] == 'item') {
				$me_id = array(G5_SHOP_DIR, 'shop', 'item');

				if($me['it_id'])
					$me_id[] = $me['it_id'];

				if($me['it_seo_title'])
					$me_id[] = $me['it_seo_title'];

			} else {
				$is_pid = true;
			}

			if($is_pid) {

				$pdir = str_replace('/', '-', str_replace(basename($url['path']), '', $url['path']));
				if($pdir && substr($pdir, -1) === '-') {
					$pdir = substr($pdir, 0, -1); 
				}
				$pdir = ($pdir) ? $pdir : 'root';
				$me_id = array($pdir, 'page', $me['file']);
			}

			$me['id'] = implode('-', $me_id);
		} else {
			// 값정리
			$name = na_explode('|', $me['me_name']);
			$me['me_name'] = isset($name[0]) ? $name[0] : $me['me_name'];
			$me['icon'] = isset($name[1]) ? $name[1] : '';
			$me['file'] = '';
			$me['gr_id'] = '';
			$me['bo_table'] = '';
			$me['wr_id'] = '';
			$me['wr_seo_title'] = '';
			$me['sca'] = '';
			$me['type'] = '';
			$me['ca_id'] = '';
			$me['it_id'] = '';
			$me['it_seo_title'] = '';
			$me['co_id'] = '';
			$me['co_seo_title'] = '';
		}
		
		// 타켓 정리
		if($me['me_target'] === 'self' || $me['me_target'] === 'blank')
			$me['me_target'] = '_'.$me['me_target'];

		return $me;

	} // end function

	// 메뉴 캐시 생성
	public function admin_menu_list_update(){
		global $g5;

		if(defined('NA_SHOP_MENU')) {
			$db_table = $g5['na_menu'];
			$db_prefix = 'shop-';
		} else {
			$db_table = $g5['menu_table'];
			$db_prefix = '';
		}

		// PC, 모바일 2회 반복
        for ($z=0; $z < 2; $z++) {

			$me = array();
			$where = $z ? "me_mobile_use = '1'" : "me_use = '1'";

			$sql = " select *
					from {$db_table}
					where $where
					and length(me_code) = '2'
					order by me_order, me_id ";

			$result = sql_query($sql, false);

			for ($i=0; $row=sql_fetch_array($result); $i++) {

				$me[$i] = $this->check_menu_item($row);

				$sql2 = " select *
						from {$db_table}
						where me_use = '1'
						and length(me_code) = '4'
						and substring(me_code, 1, 2) = '{$row['me_code']}'
						order by me_order, me_id ";

				$result2 = sql_query($sql2);
				for ($j=0; $row2=sql_fetch_array($result2); $j++) {

					$me[$i]['s'][$j] = $this->check_menu_item($row2);

					$sql3 = " select *
							from {$db_table}
							where me_use = '1'
							and length(me_code) = '6'
							and substring(me_code, 1, 4) = '{$row2['me_code']}'
							order by me_order, me_id ";

					$result3 = sql_query($sql3);
					for ($k=0; $row3=sql_fetch_array($result3); $k++) {
						$me[$i]['s'][$j]['s'][$k] = $this->check_menu_item($row3);
					}

					$me[$i]['s'][$j]['is_sub'] = $k ? true : false;
				}

				$me[$i]['is_sub'] = $j ? true : false;
			}

			// 메뉴 파일 생성
			$me_file = $z ? $db_prefix.'menu-mo.php' : $db_prefix.'menu-pc.php';
			na_file_var_save(NA_DATA_PATH.'/'.$me_file, $me);
		}				

	} // end function

	// 쇼핑몰 메뉴 캐시 생성
	public function admin_shop_menu_update(){

		$this->admin_menu_list_update();

	} // end function

	// 게시판 삭제
	public function admin_board_list_update($act_button, $chk, $board_table, $qstr) {
		global $g5;
		
		if ($act_button === "선택삭제") {
			for($i=0; $i < count($board_table); $i++) {
				// 태그 삭제
				na_delete_tag($board_table[$i]);

				// 신고 삭제
				sql_query(" delete from {$g5['na_singo']} where bo_table = '{$board_table[$i]}' and wr_flag = '0' ");

				// 알림 삭제
				sql_query(" delete from {$g5['na_noti']} where bo_table = '{$board_table[$i]}' ");

				// 새글 삭제
				sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$board_table[$i]}' ");
			}
		}

		// 글수 정리
		$bo_ids = array_unique($board_table);
		foreach($bo_ids as $bo_id){
			// 분류별 게시물수 캐시 생성
			na_cate_cnt($bo_id, array(), 1);

			// 분류별 새게시물수 캐시 생성	
			na_cate_new($bo_id, array(), 1);
		}

		// 새게시물 카운팅 캐시 생성
		na_post_new(1);

	}  // end function

	// 경고창
	public function alert($msg, $url, $error, $post) {
	    global $g5, $config, $member, $is_member, $is_admin, $board;
		global $nariya, $pset, $page_id, $file_id;

		$msg = $msg ? strip_tags($msg, '<br>') : '올바른 방법으로 이용해 주십시오.';

		$header = '';
		if (isset($g5['title'])) {
			$header = $g5['title'];
		}
		include_once(NA_PATH.'/bbs/alert.php');
		exit;

	} // end function

	// 경고창(팝업창)
	public function alert_close($msg, $error) {
	    global $g5, $config, $member, $is_member, $is_admin, $board;
		global $nariya, $pset, $page_id, $file_id;

		$msg = strip_tags($msg, '<br>');

		$header = '';
		if (isset($g5['title'])) {
			$header = $g5['title'];
		}
		include_once(NA_PATH.'/bbs/alert.close.php');
		exit;

	} // end function

	// 쪽지 발송
	public function memo_form_update_before($recv_list) {
	    global $g5, $member, $is_admin;

		// 관리자 발송이 아닐 경우 차단 체크
		if(!$is_admin) {

			$error_list  = array();

			for ($i=0; $i<count($recv_list); $i++) {
				$row = sql_fetch(" select as_chadan from {$g5['member_table']} where mb_id = '{$recv_list[$i]}' ");
				if (isset($row['as_chadan']) && $row['as_chadan']) {
					if (in_array($member['mb_id'], na_explode(',', $row['as_chadan'])))
						$error_list[] = $recv_list[$i];
				}
			}

			$error_msg = implode(",", $error_list);

			if ($error_msg)
				alert("회원아이디 '{$error_msg}' 은(는) 접근이 차단된 회원아이디 입니다.\\n쪽지를 발송하지 않았습니다.");
		}
	} // end function

	// 1:1 문의 설정값 체크
	public function get_qa_config($qaconfig){
		global $nariya;

		if(isset($nariya['shop_qa']) && $nariya['shop_qa']) {
			if(IS_YC && (!defined('G5_COMMUNITY_USE') || G5_COMMUNITY_USE !== false)) {
				define('_SHOP_', true);
			}
		}

		return $qaconfig;
	} // end function

	// 1:1 문의 모바일 스킨경로 재설정
	public function qa_mobile_content_head($content, $qaconfig){
		global $qa_skin_path, $ga_skin_url;
		
		if($qaconfig['qa_mobile_skin'] === 'theme/PC-Skin') {
			$qa_skin_path = get_skin_path('qa', $qaconfig['qa_skin']);
			$qa_skin_url  = get_skin_url('qa', $qaconfig['qa_skin']);
		}

		return $content;
	} // end function

	// 1:1 문의
	public function qawrite_update($qa_id=0, $write=array(), $w='', $qaconfig){
		global $g5, $is_member, $member, $is_admin, $nariya;

		// 알림
		if($qa_id){

			$noti = array();
			$qa_write = array();

			$qa_id = (int)$qa_id;

			// 새글 알림
			if(isset($nariya['noti_qa']) && $nariya['noti_qa']  && ($w === '' || $w === 'r')) {

				$noti_mb = array();
				$noti_mb = array_map('trim', explode(",", $nariya['noti_qa']));

				if($is_member) {
					array_diff($noti_mb, array($member['mb_id']));
				}

				$noti_cnt = count($noti_mb);
				if($noti_cnt) {

					$qa_write = sql_fetch(" select * from {$g5['qa_content_table']} where qa_id = '$qa_id' ");

					$noti['wr_id'] = $noti['rel_wr_id'] = $qa_id;
					$noti['rel_mb_id'] = $member['mb_id'];
					$noti['rel_mb_nick'] = $member['mb_nick'];
					$noti['rel_url'] = '/'.G5_BBS_DIR.'/qaview.php?qa_id='.$qa_id;
					$noti['rel_msg'] = sql_real_escape_string(na_cut_text($qa_write['qa_content'], 70));
					$noti['parent_subject'] = sql_real_escape_string(na_cut_text($qa_write['qa_subject'], 70));

					// 알림 등록
					for($i=0; $i < $noti_cnt; $i++) {
						na_noti('inquire', 'inquire', $noti_mb[$i], $noti);
					}
				}
			}

			// 답변 알림
			if($w === 'a'){
				if(!isset($qa_write['qa_subject'])) {
					$qa_write = sql_fetch(" select * from {$g5['qa_content_table']} where qa_id = '$qa_id' ");
				}

				if ($qa_write['mb_id'] !== $member['mb_id']) {

					if(!isset($noti['wr_id'])) {
						$noti['wr_id'] = $noti['rel_wr_id'] = $qa_id;
						$noti['rel_mb_id'] = $member['mb_id'];
						$noti['rel_mb_nick'] = $member['mb_nick'];
						$noti['rel_url'] = '/'.G5_BBS_DIR.'/qaview.php?qa_id='.$qa_id;
						$noti['parent_subject'] = sql_real_escape_string(na_cut_text($qa_write['qa_subject'], 70));
					}						

					$qa_answer = (isset($_POST['qa_subject'])) ? $_POST['qa_subject'] : '';
					$noti['rel_msg'] = sql_real_escape_string(na_cut_text($qa_answer, 70));

					// 알림
					na_noti('inquire', 'answer', $qa_write['mb_id'], $noti);
				}
			}
		}
	} // end function

	// 게시물 등록
	public function write_update_after($board, $wr_id, $w, $qstr, $redirect_url) {
		global $g5, $member, $nariya, $boset, $is_admin, $is_member, $is_direct, $file_upload_msg;

		// 여분필드 사용 내역
		// wr_7 : 신고(lock)
		// wr_8 : 태그
		// wr_9 : 유튜브 동영상
		// wr_10 : 대표 이미지

		$wr = array();
		$bo_table = $board['bo_table'];
		$write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블;

		// 게시물
		$wr = get_write($write_table, $wr_id, true);

		// 태그
		$wr_8 = na_add_tag($wr['wr_8'], $bo_table, $wr_id, $wr['mb_id']);

		// 유튜브
		$wr_9 = na_wr_youtube($wr);

		// 이미지 서버 저장
		$sql_content = '';
		if (isset($boset['save_image']) && $boset['save_image']) {
			list($cnt, $wr_content) = na_content_img($wr['wr_content']);
			if ($cnt && $wr_content) {
				$sql_content = "wr_content = '".addslashes($wr_content)."',";
				$wr['wr_content'] = $wr_content;
			}
		}

		// 대표 이미지
		$wr_10 = na_url(na_wr_img($bo_table, $wr), 1);

		// 게시물 업데이트
		$sql = " update {$write_table} 
					set ".$sql_content." 
						wr_8 = '".addslashes($wr_8)."',
						wr_9 = '".addslashes($wr_9)."',
						wr_10 = '".addslashes($wr_10)."'
					where wr_id = '{$wr_id}' ";
		sql_query($sql);

		// 새글 업데이트
		if(na_check_new($wr['wr_datetime'])) {

			$wr_is_secret = (strstr($wr['wr_option'], 'secret')) ? 1 : 0;

			$sql = " update {$g5['board_new_table']}
							set wr_is_secret = '{$wr_is_secret}',
								wr_singo = '{$wr['wr_7']}',
								wr_image = '{$wr_10}',
								wr_video = '{$wr_9}',
							where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ";
			sql_query($sql, false);
		}

		// 경험치
		$boset['xp_write'] = isset($boset['xp_write']) ? (int)$boset['xp_write'] : 0;
		if($member['mb_id'] && $w != 'u' && $boset['xp_write']) {
			$xp_txt = ($w) ? '글답변' : '글쓰기';
			na_insert_xp($member['mb_id'], $boset['xp_write'], "{$board['bo_subject']} {$wr_id} {$xp_txt}", $bo_table, $wr_id, '쓰기');
		}

		// 새게시물 알림
		$boset['noti_mb'] = isset($boset['noti_mb']) ? $boset['noti_mb'] : '';
		if($w != 'u' && $boset['noti_mb']) {
			$noti_mb = array();
			$noti_mb = array_map('trim', explode(",", $boset['noti_mb']));

			if($is_member)
				array_diff($noti_mb, array($member['mb_id']));

			$noti_cnt = is_array($noti_mb) ? count($noti_mb) : 0;
			if($noti_cnt) {
				if(!isset($wr['mb_id']))
					$wr = get_write($write_table, $wr_id, true);

				if(!$wr_content)
					$wr_content = $wr['wr_content'];

				$noti['rel_msg'] = sql_real_escape_string(na_cut_text($wr_content, 70));
				$noti['parent_subject'] = sql_real_escape_string(na_cut_text($wr['wr_subject'], 90));
				$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
				$noti['wr_id'] = $noti['wr_parent'] = $noti['rel_wr_id'] = $wr_id;
				$noti['rel_mb_id'] = $wr['mb_id'];
				$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;
				$noti['rel_mb_nick'] = $is_member ? clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']) : $wr['wr_name'];
				$noti['rel_mb_nick'] = addslashes($noti['rel_mb_nick']);

				// 알림 등록
				for($i=0; $i < $noti_cnt; $i++) {

					if($wr['mb_id'] && $noti_mb[$i] === $wr['mb_id'])
						continue;

					na_noti('board', 'write', $noti_mb[$i], $noti);
				}
			}
		}

		// 답글 알림
		$boset['noti_no'] = isset($boset['noti_no']) ? $boset['noti_no'] : '';
		if($w == 'r' && isset($_POST['wr_id']) && $_POST['wr_id'] && !$boset['noti_no']) {
			// 원글
			$org = get_write(get_write_table_name($board['bo_table']), (int) $_POST['wr_id'], true);

			if($org['mb_id'] && $member['mb_id'] !== $org['mb_id']) {

				if(!isset($wr['mb_id']))
					$wr = get_write($write_table, $wr_id, true);

				if(!$wr_content)
					$wr_content = $wr['wr_content'];

				if(isset($noti))
					unset($noti);

				$noti['rel_msg'] = sql_real_escape_string(na_cut_text($wr_content, 70));
				$noti['parent_subject'] = sql_real_escape_string(na_cut_text($org['wr_subject'], 90));
				$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
				$noti['wr_id'] = $noti['wr_parent'] = $org['wr_id'];
				$noti['rel_wr_id'] = $wr_id;
				$noti['rel_mb_id'] = $wr['mb_id'];
				$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;

				$noti['rel_mb_nick'] = $is_member ? clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']) : $wr['wr_name'];
				$noti['rel_mb_nick'] = addslashes($noti['rel_mb_nick']);

				// 알림 등록
				na_noti('board', 'reply', $org['mb_id'], $noti);
			}
		}

		// 분류별 게시물수 캐시 생성
		na_cate_cnt($bo_table, $board, 1);

		// 분류별 새게시물수 캐시 생성	
		na_cate_new($bo_table, $board, 1);

		// 새게시물 카운팅 캐시 생성
		na_post_new(1);

		// 목록으로 이동
		if($w == '' && isset($is_direct) && $is_direct) {
			if($file_upload_msg) {
				alert($file_upload_msg, short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table));
			} else {
				goto_url(short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table));
			}
		}

	} // end function

	// 댓글 등록
	public function comment_update_after($board, $wr_id, $w, $qstr, $redirect_url) {
		global $g5, $is_member, $member, $comment_id, $boset;

		// 게시판 테이블
		$bo_table = $board['bo_table'];
		$write_table = $g5['write_prefix'].$bo_table;

		// 원 댓글
		$request_comment_id = (isset($_POST['comment_id']) && $_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;
		$reply_array = ($request_comment_id) ? get_write($write_table, $request_comment_id, true) : array();

		// 대댓글 대상 체크
		$comment_sql = '';
		if($w === 'c' && $comment_id && isset($reply_array['wr_name']) && $reply_array['wr_name'])
			$comment_sql = "wr_9 = '".$reply_array['wr_name'].",".$reply_array['mb_id']."'";

		// 럭키 점수
		$is_lucky = 0;
		if($is_member  && $comment_id && $w === 'c') {

			$lucky_point = isset($boset['na_lucky_point']) ? (int)$boset['na_lucky_point'] : 0;
			$lucky_dice = isset($boset['na_lucky_dice']) ? (int)$boset['na_lucky_dice'] : 0;

			if($lucky_point > 0 && $lucky_dice > 0) {
				// 주사위 굴림
				$dice1 = rand(1, $lucky_dice);
				$dice2 = rand(1, $lucky_dice);
				if($dice1 == $dice2) {
					// 럭키포인트는 게시물당 1번만 당첨
					$sql = " select count(*) as cnt 
									from {$g5['point_table']} 
									where mb_id = '{$member['mb_id']}' 
										and po_rel_table = '$bo_table'
										and po_rel_id = '$wr_id'
										and po_rel_action = '@lucky' ";
					$row = sql_fetch($sql);

					// 당첨내역이 없을 경우 포인트 등록
					if(!$row['cnt']) {
						$point = rand(1, $lucky_point);
						$po_content = $board['bo_subject'].' '.$wr_id.' 럭키포인트 당첨!';

						insert_point($member['mb_id'], $point, $po_content, $bo_table, $wr_id, '@lucky');

						if($comment_sql)
							$comment_sql .= ', ';

						$comment_sql .= "wr_10 = '".$point."'"; //댓글 여분필드 10번은 럭키 포인트 점수로...
					}
				}
			}
		}

		// 댓글 업데이트
		if($comment_sql)
		    sql_query(" update $write_table set $comment_sql where wr_id = '$comment_id' ");

		// 댓글
		$wr = get_write($write_table, $comment_id, true);

		// 새글 업데이트
		if(na_check_new($wr['wr_datetime'])) {

			$wr_is_secret = (strstr($wr['wr_option'], 'secret')) ? 1 : 0;

			$sql = " update {$g5['board_new_table']}
							set wr_is_comment = '1',
								wr_is_secret = '{$wr_is_secret}',
								wr_singo = '{$wr['wr_7']}'
							where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' ";
			sql_query($sql);
		} 

		// 댓글 경험치
		$boset['xp_comment'] = isset($boset['xp_comment']) ? (int)$boset['xp_comment'] : 0;
		if($member['mb_id'] && $w != 'cu' && $boset['xp_comment'])
			na_insert_xp($member['mb_id'], $boset['xp_comment'], "{$board['bo_subject']} {$wr_id}-{$comment_id} 댓글쓰기", $bo_table, $comment_id, '댓글');

		// 알림
		$boset['noti_no'] = isset($boset['noti_no']) ? $boset['noti_no'] : '';
		if ($comment_id && $w === 'c' && !$boset['noti_no']) {

			$noti = array();

			// 원 글
			$wr = get_write($write_table, $wr_id, true);

			$parent_subject = sql_real_escape_string(na_cut_text($wr['wr_subject'], 90));

			// 현 댓글
			$comment_wr = get_write($write_table, $comment_id, true);

			// 자신의 댓글이 아닐 경우
			$is_reply_noti = (isset($reply_array['mb_id']) && $reply_array['mb_id'] !== $member['mb_id']) ? true : false;
			$mb_id = ($member['mb_id']) ? $member['mb_id'] : '';

			// 댓글을 남긴 경우
			if(($wr['mb_id'] && $wr['mb_id'] != $member['mb_id']) || $is_reply_noti){

				$noti['rel_mb_nick'] = $is_member ? clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']) : $comment_wr['wr_name'];
				$noti['rel_mb_nick'] = addslashes($noti['rel_mb_nick']);

				// 대댓글인 경우
				if(isset($reply_array['wr_is_comment']) && $reply_array['wr_is_comment']){
					$ph_to_case = 'comment';
					$tmp_mb_id = ($reply_array['mb_id']) ? $reply_array['mb_id'] : $wr['mb_id'];
					$noti['wr_id'] = ($reply_array['wr_id']) ? $reply_array['wr_id'] : $wr_id;
					$noti['parent_subject'] = sql_real_escape_string(na_cut_text($reply_array['wr_content'], 30));

				} else { // 댓글인 경우
					$ph_to_case = 'board';
					$tmp_mb_id = $wr['mb_id'];
					$noti['wr_id'] = $wr_id;
					$noti['parent_subject'] = sql_real_escape_string(na_cut_text($wr['wr_subject'], 30));
				}

				if($tmp_mb_id !== $member['mb_id']) {
					$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
					$noti['parent_subject'] = $parent_subject;
					$noti['wr_parent'] = $wr['wr_parent'];
					$noti['rel_wr_id'] = $comment_id;
					$noti['rel_mb_id'] = $mb_id;
					$noti['rel_msg'] = sql_real_escape_string(na_cut_text($comment_wr['wr_content'], 30));
					$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id."#c_".$comment_id;

					// 알림 등록
					na_noti($ph_to_case, 'comment', $tmp_mb_id, $noti);
				}

				// 원글 알림
				if(isset($reply_array['wr_id']) && $reply_array['wr_id'] && ($wr['mb_id'] && $wr['mb_id'] != $member['mb_id'])){

					// 원글을 쓴 회원이 댓글을 써서 그 댓글에 댓글을 다는 경우가 맞다면... sql에서 insert 하지 않는다.
					$ph_readed = ($reply_array['mb_id'] && !strcmp($reply_array['mb_id'], $wr['mb_id'])) ? 'Y' : '';

					if($ph_readed !== 'Y' ) {
						if(!isset($noti['bo_table'])) {
							$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
							$noti['parent_subject'] = $parent_subject;
							$noti['wr_parent'] = $wr['wr_parent'];
							$noti['rel_wr_id'] = $comment_id;
							$noti['rel_mb_id'] = $mb_id;
							$noti['rel_msg'] = sql_real_escape_string(na_cut_text($comment_wr['wr_content'], 30));
							$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id."#c_".$comment_id;
						}

						// 알림 등록
						na_noti('board', 'comment', $wr['mb_id'], $noti);
					}
				}
			}
		}

	} // end function

	// 게시물 추천
    public function bbs_good_before($bo_table, $wr_id, $good){
        global $g5, $nariya, $member, $is_guest;

		$max_good = isset($nariya['max_good']) ? (int)$nariya['max_good'] : 0;

		if ($is_guest || !$max_good)
			return;

		$row = sql_fetch(" select count(*) as cnt from {$g5['board_good_table']} where mb_id = '{$member['mb_id']}' and DATE(bg_datetime) = DATE(NOW()) ");
		$count = isset($row['cnt']) ? (int)$row['cnt'] : 0;
		if($count >= $max_good) {
			$error = '더이상 추천 또는 비추천을 할 수 없습니다.<br><br>하루 최대 '.$max_good.'회까지 추천/비추천 할 수 있습니다.';
			die(json_encode(array('error' => $error)));
		}
	}

    public function bbs_increase_good_json($bo_table, $wr_id, $good){
        global $g5, $is_member, $member, $board, $boset;

		/* 추천 알림 사용안함
		$boset['noti_no'] = isset($boset['noti_no']) ? $boset['noti_no'] : '';
		if (!$boset['noti_no']) {
			$ph_from_case = ($good === 'good') ? 'good' : 'nogood';

			$wr = get_write(get_write_table_name($bo_table), $wr_id, true);

			$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
			$noti['wr_id'] = $noti['rel_wr_id'] = $wr_id;
			$noti['wr_parent'] = $wr['wr_parent'];
			$noti['rel_mb_id'] = $member['mb_id'];
			$noti['rel_mb_nick'] = $member['mb_nick'];
			$noti['rel_msg'] = sql_real_escape_string(na_cut_text($wr['wr_content'], 70));
			$noti['parent_subject'] = sql_real_escape_string(na_cut_text($wr['wr_subject'], 70));
			$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;

			// 알림 등록
			na_noti('board', $ph_from_case, $wr['mb_id'], $noti);
		}
		*/

		// 새글 DB 업데이트
		if(!isset($wr['wr_id']))
			$wr = get_write(get_write_table_name($bo_table), $wr_id, true);

		if(na_check_new($wr['wr_datetime'])) {
			$new_sql = ($good === 'good') ? "wr_good = '{$wr['wr_good']}'" : "wr_nogood = '{$wr['wr_nogood']}'";
			sql_query(" update {$g5['board_new_table']} set $new_sql where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", false);
		}
	} // end function

	// 댓글 추천
    public function comment_good_before($bo_table, $wr_id, $good){

		$this->bbs_good_before($bo_table, $wr_id, $good);

	} // end function

    public function comment_increase_good_json($bo_table, $wr_id, $good){
        global $g5, $is_member, $member, $boset;

		/* 추천알림 사용안함
		$boset['noti_no'] = isset($boset['noti_no']) ? $boset['noti_no'] : '';
		if (!$boset['noti_no']) {
			$ph_from_case = ($good === 'good') ? 'good' : 'nogood';

			$wr = get_write(get_write_table_name($bo_table), $wr_id, true);

			$noti['bo_table'] = $noti['rel_bo_table'] = $bo_table;
			$noti['wr_id'] = $noti['rel_wr_id'] = $wr_id;
			$noti['wr_parent'] = $wr['wr_parent'];
			$noti['rel_mb_id'] = $member['mb_id'];
			$noti['rel_mb_nick'] = $member['mb_nick'];
			$noti['rel_msg'] = sql_real_escape_string(na_cut_text($wr['wr_content'], 70));
			$noti['parent_subject'] = sql_real_escape_string(na_cut_text($wr['wr_content'], 70));
			$noti['rel_url'] = "/".G5_BBS_DIR."/board.php?bo_table=".$bo_table."&wr_id=".$wr['wr_parent']."#c_".$wr_id;

			// 알림 등록
			na_noti('comment', $ph_from_case, $wr['mb_id'], $noti);
		}
		*/

		// 새글 DB 업데이트
		if(!isset($wr['wr_id']))
			$wr = get_write(get_write_table_name($bo_table), $wr_id, true);

		if(na_check_new($wr['wr_datetime'])) {
			$new_sql = ($good === 'good') ? "wr_good = '{$wr['wr_good']}'" : "wr_nogood = '{$wr['wr_nogood']}'";
			sql_query(" update {$g5['board_new_table']} set $new_sql where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
		}
	} // end function

	// 새글 삭제
	public function bbs_new_delete($chk_bn_id, $save_bo_table){
		global $g5, $nariya;
				
		$mb_ids = array();
		$bo_ids = array();

		if(is_array($chk_bn_id)){
			for($i=0;$i<count($chk_bn_id);$i++){
				
				$k = $chk_bn_id[$i];

				$bo_table = isset($_POST['bo_table'][$k]) ? preg_replace('/[^a-z0-9_]/i', '', $_POST['bo_table'][$k]) : '';
				$wr_id    = isset($_POST['wr_id'][$k]) ? preg_replace('/[^a-z0-9_]/i', '', $_POST['wr_id'][$k]) : 0;

				if($wr_id && $bo_table){
					
					// 게시판 아이디 담기
					$bo_ids[] = $bo_table;

					// 태그, 신고 등 삭제
					na_delete($bo_table, $wr_id);

					// 신고 삭제
					sql_query(" delete from {$g5['na_singo']} where bo_table = '{$bo_table}' and rel_wr_id = '{$wr_id}' and wr_flag = '0' ");

					// 읽지 않은 알림 회원 체크
					$result = sql_query(" select * from {$g5['na_noti']} where ph_readed = 'N' and bo_table = '{$bo_table}' and rel_wr_id = '{$wr_id}' ");
					if($result) {
						while($row=sql_fetch_array($result)){
							$mb_ids[] = $row['mb_id'];
						}
					}

					// 알림 삭제
					sql_query(" delete from {$g5['na_noti']} where bo_table = '{$bo_table}' and rel_wr_id = '{$wr_id}' ");
				}
			}
		}

		// 회원별 알림 정리
		if(!empty($mb_ids)){
			$mb_ids = array_unique($mb_ids);
			foreach($mb_ids as $mb_id){
				na_noti_update($mb_id);
			}
		}

		// 글수 정리
		if(!empty($bo_ids)){
			$bo_ids = array_unique($bo_ids);
			foreach($bo_ids as $bo_id){
				// 분류별 게시물수 캐시 생성
				na_cate_cnt($bo_id, array(), 1);

				// 분류별 새게시물수 캐시 생성	
				na_cate_new($bo_id, array(), 1);
			}

			// 새게시물 카운팅 캐시 생성
			na_post_new(1);
		}

	} // end function

	// 게시물 선택삭제
	public function bbs_delete_all($tmp_array, $board){
		global $g5;

		$mb_ids = array();

		$bo_table = $board['bo_table'];

		foreach($tmp_array as $wr_id){

			// 태그, 신고 등 삭제
			na_delete($bo_table, $wr_id);

			// 신고 삭제
			sql_query(" delete from {$g5['na_singo']} where bo_table = '{$bo_table}' and rel_wr_id = '{$wr_id}' and wr_flag = '0' ");

			// 읽지 않은 알림 회원 체크
			$result = sql_query(" select * from {$g5['na_noti']} where ph_readed = 'N' and bo_table = '{$bo_table}' and rel_wr_id = '{$wr_id}' ");
			if($result) {
				while($row=sql_fetch_array($result)){
					$mb_ids[] = $row['mb_id'];
				}
			}

			// 알림 삭제
			sql_query(" delete from {$g5['na_noti']} where bo_table = '{$bo_table}' and rel_wr_id = '{$wr_id}' ");

		}

		if(!empty($mb_ids)){
			$mb_ids = array_unique($mb_ids);
			foreach($mb_ids as $mb_id){
				na_noti_update($mb_id);
			}
		}

		// 분류별 게시물수 캐시 생성
		na_cate_cnt($bo_table, array(), 1);

		// 분류별 새게시물수 캐시 생성	
		na_cate_new($bo_table, array(), 1);

		// 새게시물 카운팅 캐시 생성
		na_post_new(1);

	} // end function

	// 게시물 이동/복사
	public function bbs_move_update($bo_table, $chk_bo_table, $wr_id_list, $opener_href){

		// 글수 정리
		if(!empty($chk_bo_table)){
			$bo_ids = array_unique($chk_bo_table);
			foreach($bo_ids as $bo_id){
				// 분류별 게시물수 캐시 생성
				na_cate_cnt($bo_id, array(), 1);

				// 분류별 새게시물수 캐시 생성	
				na_cate_new($bo_id, array(), 1);
			}
		}

		// 분류별 게시물수 캐시 생성
		na_cate_cnt($bo_table, array(), 1);

		// 분류별 새게시물수 캐시 생성	
		na_cate_new($bo_table, array(), 1);

		// 새게시물 카운팅 캐시 생성
		na_post_new(1);

	} // end function

	// 글삭제	
	public function bbs_delete($write_id, $board){

		$delete_id = (is_array($write_id)) ? $write_id['wr_id'] : $write_id;

		$this->bbs_delete_all(array($delete_id), $board);

	} // end function

	// 경험치 체크
	public function member_login_check($mb, $link, $is_social_login){
		
		// 경험치 합계
		na_sum_xp($mb);

	} // end function

	// 레벨업 메시지 & DB 테이블 최적화
	public function tail_sub(){
		global $g5, $config, $member, $is_admin, $nariya;

		$member['as_msg'] = isset($member['as_msg']) ? $member['as_msg'] : '';
		$member['as_level'] = isset($member['as_level']) ? $member['as_level'] : 1;

		if($member['mb_id']) {
			switch($member['as_msg']) { //Message
				case '1'	: $msg = '레벨업! '.$member['as_level'].'레벨이 되었습니다.';	break;
				case '2'	: $msg = '레벨다운! '.$member['as_level'].'레벨이 되었습니다.'; break;
				case '3'	: $msg = '등업! '.$member['mb_level'].'등급이 되었습니다.'; break;
				case '4'	: $msg = '등급다운! '.$member['mb_level'].'등급이 되었습니다.'; break;
				default		: $msg = ''; break;
			}

			if($msg) {
				// 회원정보 업데이트
				sql_query(" update {$g5['member_table']} set as_msg = '0' where mb_id = '{$member['mb_id']}' ");

				// 메시지
				echo "<script> $(document).ready(function(){ Swal.fire({ text: '".$msg."' }); });</script>";
			}
		}

		// DB 테이블 최적화 : 최고관리자일 때만 실행
		if($config['cf_admin'] != $member['mb_id'] || $is_admin != 'super')
			return;

		// 실행일 비교
		if(!isset($config['na_optimize_date'])) {
			sql_query(" ALTER TABLE `{$g5['config_table']}` ADD `na_optimize_date` varchar(255) NOT NULL DEFAULT '' ");
		} else {
			if(isset($config['na_optimize_date']) && $config['na_optimize_date'] >= G5_TIME_YMD)
				return;
		}

		// 설정일이 지난 알림 삭제
		if(isset($nariya['noti_days']) && (int)$nariya['noti_days'] > 0) {
			sql_query(" delete from {$g5['na_noti']} where (TO_DAYS('".G5_TIME_YMDHIS."') - TO_DAYS(ph_datetime)) > '{$nariya['noti_days']}' ");
			sql_query(" OPTIMIZE TABLE `{$g5['na_noti']}` ");
		}

		// 실행일 기록
		if(isset($config['na_optimize_date'])) {
			sql_query(" update {$g5['config_table']} set na_optimize_date = '".G5_TIME_YMD."' ");
		}

	} // end function

	//=====================================================================
	// 영카트 쇼핑몰
	//=====================================================================

	// 사용후기 삭제
	public function shop_item_use_deleted($is_id, $it_id){
		global $g5;

		// 사용후기 신고글 삭제
		sql_query(" delete from {$g5['na_singo']} where sg_table = '{$it_id}' and sg_id = '{$is_id}' and sg_flag = '1' ");

	} // end function

	// 상품문의 삭제
	public function shop_item_qa_deleted($iq_id, $it_id){
		global $g5;

		// 상품문의 신고글 삭제
		sql_query(" delete from {$g5['na_singo']} where sg_table = '{$it_id}' and sg_id = '{$iq_id}' and sg_flag = '2' ");

	} // end function

}

$GLOBALS['nariya_standard'] = NARIYA_STANDARD::getInstance();