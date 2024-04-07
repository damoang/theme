<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//------------------------------------------------------------------------------
// 결제 후 처리를 위한 무배송 상품의 장바구니 정보 업데이트
//------------------------------------------------------------------------------
function na_delivery_check($row){
	global $g5, $nariya, $is_guest;

	if(!isset($row['it_8']) || !isset($row['it_9']) || !isset($row['ct_id']) || !$row['ct_id'])
		return;

	$sql = array();

	$row['it_9'] = (int)$row['it_9'];

	if($is_guest && ($row['it_8'] || $row['it_9'])) {
		alert(get_text($row['it_name']).' 상품은 로그인한 회원만 구매할 수 있습니다.');
	}

	if($row['it_delivery'] != $row['it_9'])
		$sql[] = "it_delivery = '".$row['it_9']."'";

	if($row['it_8']) {
		$mbs = na_explode(',', $row['it_8']);
		$mc = isset($mbs[0]) ? na_fid($mbs[0]) : '';  // DB칼럼
		$md = isset($mbs[1]) ? (int)$mbs[1] : 0; // 기간

		if(!isset($nariya['mbs_list']) || !$nariya['mbs_list']) {
			alert('나리야 설정에 설정한 멤버십 칼럼을 등록해야 구매할 수 있습니다.');
		}

		$mbs_list = na_explode(',', $nariya['mbs_list']);
		if(!in_array($mc, $mbs_list)) {
			alert('나리야 설정에 설정한 멤버십 칼럼을 등록해야 구매할 수 있습니다.');
		}

		if(!$md) {
			alert('멤버십 기간을 설정하셔야 구매할 수 있습니다.');
		}

		$sql[] = "it_mbs = '".addslashes($row['it_8'])."'";
	}

	if(!empty($sql))
		sql_query(" update {$g5['g5_shop_cart_table']} set ".implode(', ', $sql)." where ct_id = '{$row['ct_id']}' ");

	return;
}

//------------------------------------------------------------------------------
// 무배송 상품 결제와 동시에 완료처리하고, 주문포인트를 즉시 적립한다.
//------------------------------------------------------------------------------
function na_delivery_complete($ct_status='입금') {
    global $g5;

	if($ct_status == '입금' || $ct_status == '완료') {

		$result = sql_query(" select * from {$g5['g5_shop_cart_table']} where ct_status = '$ct_status' and ((it_delivery = '1' and ct_point_use = '0') or (it_mbs <> '' and it_mbs_use = '0')) ");
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			// 회원 ID 를 얻는다.
			$od_row = sql_fetch("select od_id, mb_id, od_time, od_receipt_time from {$g5['g5_shop_order_table']} where od_id = '{$row['od_id']}' ");

			// 포인트 미적립 상태이고 회원이면서 적립 포인트가 0보다 크다면
			$ct_point_use = '';
			if(!$row['ct_point_use']) {
				if ($od_row['mb_id'] && $row['ct_point'] > 0) {
					$po_point = $row['ct_point'] * $row['ct_qty'];
					$po_content = "주문번호 {$od_row['od_id']} ({$row['ct_id']}) 적립완료";
					insert_point($od_row['mb_id'], $po_point, $po_content, "@delivery", $od_row['mb_id'], "{$od_row['od_id']},{$row['ct_id']}");
				}

				$ct_point_use = ", ct_point_use = '1'";
			}

			$ct_mbs_use = '';
			if ($od_row['mb_id'] && $row['it_mbs'] && !$row['it_mbs_use']) {
				$mbs = na_explode(',', $row['it_mbs']);
				$mc = isset($mbs[0]) ? na_fid($mbs[0]) : '';  // DB칼럼
				$md = isset($mbs[1]) ? (int)$mbs[1] : 0; // 기간
				$md = $md * $row['ct_qty']; // 구매수 만큼 기간 증가
				$mx = isset($mbs[2]) ? (int)$mbs[2] : 0; // 경험치

				// DB칼럼과 기간이 있으면...
				if ($mc && $md) {
					$mb = get_member($od_row['mb_id']);
				
					$mbs_now = 0;
					if (!isset($mb[$mc])) {
						// 필드 자동 생성
						sql_query(" ALTER TABLE {$g5['member_table']} ADD $mc varchar(10) NOT NULL DEFAULT '' ");
					} else {
						$mbs_now = (int)str_replace('-', '', $mb[$mc]);
					}			

					$mb_today = (int)str_replace('-', '', G5_TIME_YMD);
					$mbs_end = ($mbs_now >= $mb_today) ? $mb[$mc]." +".$md." days" : G5_TIME_YMD." +".$md." days";
					$mbs_end = date("Y-m-d", strtotime($mbs_end));

					// 회원정보 업데이트
					sql_query(" update {$g5['member_table']} set $mc = '{$mbs_end}' where mb_id = '{$od_row['mb_id']}' ");

					if ($mx > 0) {
						$xp_point = $mx * $row['ct_qty'];
						$xp_content = "주문번호 {$od_row['od_id']} ({$row['ct_id']}) 멤버십 경험치 적립완료";
						na_insert_xp($od_row['mb_id'], $xp_point, $xp_content, "@membership", $od_row['mb_id'], "{$od_row['od_id']},{$row['ct_id']}");
					}

					$ct_mbs_use = ", it_mbs_use = '1'";
				}
			}

			// 완료처리
			sql_query("update {$g5['g5_shop_cart_table']} set ct_status = '완료' $ct_point_use $ct_mbs_use where ct_id = '{$row['ct_id']}' ");
		}

	} else if ($ct_status == '취소') {

		$result = sql_query(" select * from {$g5['g5_shop_cart_table']} where ct_status = '$ct_status' and (it_delivery = '1' or (it_mbs <> '' and it_mbs_use = '1')) ");
		for ($i=0; $row=sql_fetch_array($result); $i++) {

			// 회원 ID 를 얻는다.
			$od_row = sql_fetch("select od_id, mb_id, od_time, od_receipt_time from {$g5['g5_shop_order_table']} where od_id = '{$row['od_id']}' ");

			$ct_mbs_use = '';
			if ($row['it_mbs_use']) {
				$mbs = na_explode(',', $row['it_mbs']);
				$mc = isset($mbs[0]) ? na_fid($mbs[0]) : '';  // DB칼럼
				$md = isset($mbs[1]) ? (int)$mbs[1] : 0; // 기간
				$md = $md * $row['ct_qty']; // 구매수 만큼 기간 증가
				$mx = isset($mbs[2]) ? (int)$mbs[2] : 0; // 경험치

				// DB칼럼과 기간이 있으면...
				if ($mc && $md) {
					$mb = get_member($od_row['mb_id']);

					// 현재 멤버십 만료일에서 증가된 기간 차감
					$mbs_start = date("Y-m-d", strtotime($mb[$mc]." -".$md." days"));

					// 회원정보 업데이트
					sql_query(" update {$g5['member_table']} set $mc = '{$mbs_start}' where mb_id = '{$od_row['mb_id']}' ");

					if ($mx > 0) {
						na_delete_xp($od_row['mb_id'], "@membership", $od_row['mb_id'], "{$od_row['od_id']},{$row['ct_id']}");
					}

					$ct_mbs_use = ", it_mbs_use = '0'";
				}
			}

			// 취소처리
			sql_query("update {$g5['g5_shop_cart_table']} set ct_status = '취소', it_delivery = '0' $ct_mbs_use where ct_id = '{$row['ct_id']}' ");
		}
	}
}

// 컨텐츠 다운로드
function na_file($it_id) {
    global $g5;

    $file['count'] = 0;
    $result = sql_query(" select * from {$g5['na_file']} where it_id = '$it_id' order by sf_no ");
    $nonce = download_file_nonce_key($it_id, 0);
    while ($row = sql_fetch_array($result)) {
        $no = (int) $row['sf_no'];
        $sf_content = $row['sf_content'] ? html_purifier($row['sf_content']) : '';
        $file[$no]['href'] = NA_URL."/download.php?it_id=$it_id&amp;no=$no&amp;nonce=$nonce";
        $file[$no]['download'] = $row['sf_download'];
        $file[$no]['path'] = G5_DATA_URL.'/itme/'.$it_id;
        $file[$no]['size'] = get_filesize($row['sf_filesize']);
        $file[$no]['free'] = $row['sf_free'];
		$file[$no]['datetime'] = $row['sf_datetime'];
        $file[$no]['source'] = addslashes($row['sf_source']);
        $file[$no]['sf_content'] = $sf_content;
        $file[$no]['content'] = get_text($sf_content);
        $file[$no]['file'] = $row['sf_file'];
        $file['count']++;
    }

    return $file;
}

//------------------------------------------------------------------------------
// Nariya Hook Extend
//------------------------------------------------------------------------------
class NARIYA_EXTEND {

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

		// 입력필드 업데이트
		add_replace('head_css_url', array($this, 'head_css_url'), 10, 2);

	} // end function

	// 관리자 공통
	public function head_css_url($css_url, $g5_url){
		global $sub_menu;

		if(G5_IS_ADMIN) {
			// 상품정보 등록폼 여분필드 정의
			if($sub_menu == '400300') {
				global $it;

				$it['it_1_subj'] = '유튜브 영상 주소';
				$it['it_8_subj'] = '맴버십(회원DB칼럼,기간,경험치)';
				$it['it_9_subj'] = '무배송(1)';
				$it['it_10_subj'] = '타이틀 이미지 주소';
			}
		}

		return $css_url;

	} // end function

}

$GLOBALS['nariya_extend'] = NARIYA_EXTEND::getInstance();