<?php
$sub_menu = "800100";
include_once('./_common.php');

$is_yc = (defined('G5_USE_SHOP') && G5_USE_SHOP) ? '1' : '';

if(isset($_POST['post_action']) && isset($_POST['token'])){

	check_demo();

	check_admin_token();

	if($_POST['post_action'] == 'save') {

		auth_check_menu($auth, $sub_menu, 'w');

		// 기본 폴더 체크
		if(!is_dir(NA_DATA_PATH)) {
			@mkdir(NA_DATA_PATH, G5_DIR_PERMISSION);
			@chmod(NA_DATA_PATH, G5_DIR_PERMISSION);
		}

		// 세부 폴더 체크
		$folders = array('board', 'image', 'page', 'skin', 'video', 'widget');
		for($i=0; $i < count($folders); $i++) {
			$folder_path = NA_DATA_PATH.'/'.$folders[$i];
			if(!is_dir($folder_path)) {
				@mkdir($folder_path, G5_DIR_PERMISSION);
				@chmod($folder_path, G5_DIR_PERMISSION);
			}
		}

		// Check DB 
		$is_extend = (isset($_POST['na']['is_extend']) && $_POST['na']['is_extend']) ? true : false;
		include_once('./db.php');

		// 레벨 아이콘 확장자
		if(isset($_POST['na']['lvl_skin']) && $_POST['na']['lvl_skin']) {
			$lvl_skin_path = G5_THEME_PATH.'/skin/level/'.$_POST['na']['lvl_skin'];
			if(is_file($lvl_skin_path.'/1.png')) {
				$_POST['na']['lvl_ext'] = 'png';
			} else if(is_file($lvl_skin_path.'/1.jpg')) {
				$_POST['na']['lvl_ext'] = 'jpg';
			}
		}

		// 설정값 파일로 저장
		na_file_var_save(NA_DATA_PATH.'/nariya.php', $_POST['na']);
	}

	// 페이지 이동
	goto_url('./admin.php');
}

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '기본설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

?>

<style>
	input.extra-value-input { width: 100%; }
</style>

<form name="fnariya" id="fnariya" method="post" onsubmit="return fnariya_submit(this);">
	<input type="hidden" name="token" value="" id="token">
	<input type="hidden" name="post_action" value="save">
	<input type="hidden" name="na[is_yc]" value="<?php echo $is_yc ?>">
	<input type="hidden" name="na[is_demo]" value="<?php echo (is_dir(G5_PATH.'/DEMO')) ? '1' : ''; ?>">

	<h2 class="h2_frm">기본 설정</h2>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col class="grid_4">
			<col>
		</colgroup>
		<tbody>

		<!-- 기본 설정 -->
		<tr>
			<th scope="row">
				버전
			</th>
			<td>
				<b><?php echo NA_VER ?></b>
			</td>
		</tr>
		<tr>
			<th scope="row">
				DB 관리
			</th>
			<td>
				<?php if (isset($member['as_chadan'])) { ?>
					<?php echo help('업데이트 또는 패치시 DB 업그레이드를 실행해 주셔야 합니다.') ?>
					<button type="button" class="btn btn_03" onclick="na_upgrade('./db.php');">
						DB 업그레이드
					</button>
				<?php } else { ?>
					<?php echo help('※ 반드시 아래 버튼을 클릭하여 나리야를 먼저 설치해 주세요!!!') ?>
					<button type="button" class="btn btn_03" onclick="na_upgrade('./db.php');">
						나리야 설치하기
					</button>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th scope="row">
				PC 레이아웃
			</th>
			<td>
				<?php echo help('테마 내 /layout 폴더') ?>
				<select name="na[layout_pc]">
					<?php 
					$skins = get_skin_dir('', G5_THEME_PATH.'/layout');
					for ($i=0; $i<count($skins); $i++) { 
					?>
						<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($nariya['layout_pc'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				모바일 레이아웃
			</th>
			<td>
				<?php echo help('테마 내 /layout 폴더') ?>
				<select name="na[layout_mo]">
					<?php 
					$skins = get_skin_dir('', G5_THEME_PATH.'/layout');
					for ($i=0; $i<count($skins); $i++) { 
					?>
						<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($nariya['layout_mo'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				기본 SEO 이미지
			</th>
			<td>
				<?php echo help('https://... 형태의 풀 이미지 주소를 등록해 주세요.'); ?>
				<input type="text" name="na[seo_img]" value="<?php echo get_sanitize_input($nariya['seo_img']) ?>" class="frm_input extra-value-input" size="80">
			</td>
		</tr>
		<tr>
			<th scope="row">
				기본 SEO 설명글
			</th>
			<td>
				<?php echo help('구글의 경우 설명의 제한이 990픽셀이므로 한글 기준으로 50자 내외 등록 - 한글 글자크기는 보통 20픽셀'); ?>
				<textarea name="na[seo_desc]" style="height:80px;"><?php echo get_text($nariya['seo_desc']); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				기본 SEO 키워드
			</th>
			<td>
				<?php echo help('구글의 경우 제목과 키워드의 제한이 560픽셀이므로 한글 기준으로 30자 내외 등록 - 한글 글자크기는 보통 20픽셀'); ?>
				<textarea name="na[seo_keys]" style="height:80px;"><?php echo get_text($nariya['seo_keys']); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				메뉴 새글 체크
			</th>
			<td>
				<input type="text" name="na[new_post]" value="<?php echo $nariya['new_post'] ?>" class="frm_input" size="5"> 
				시간 이내 게시물에 대해 
				<input type="text" name="na[new_cache]" value="<?php echo $nariya['new_cache'] ?>" class="frm_input" size="5"> 
				분 간격으로 캐싱
			</td>
		</tr>

		<?php if($is_yc) { ?>
			<!-- 쇼핑몰 설정 -->
			<tr>
			<td colspan="2" style="padding-left:0; padding-top:30px;">
				<span class="h2_frm">쇼핑몰 설정</span>
			</td>
			</tr>
			<tr>
				<th scope="row">
					쇼핑몰 PC 레이아웃
				</th>
				<td>
					<?php echo help('테마 내 /layout 폴더') ?>
					<select name="na[layout_shop_pc]">
						<?php 
						$skins = get_skin_dir('', G5_THEME_PATH.'/layout');
						for ($i=0; $i<count($skins); $i++) { 
						?>
							<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($nariya['layout_shop_pc'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					쇼핑몰 모바일 레이아웃
				</th>
				<td>
					<?php echo help('테마 내 /layout 폴더') ?>
					<select name="na[layout_shop_mo]">
						<?php 
						$skins = get_skin_dir('', G5_THEME_PATH.'/layout');
						for ($i=0; $i<count($skins); $i++) { 
						?>
							<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($nariya['layout_shop_mo'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					쇼핑몰 SEO 타이틀
				</th>
				<td>
					<?php echo help('쇼핑몰 인덱스 페이지 타이틀을 입력해 주세요.'); ?>
					<input type="text" name="na[seo_shop_title]" value="<?php echo get_sanitize_input($nariya['seo_shop_title']) ?>" class="frm_input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					쇼핑몰 SEO 이미지
				</th>
				<td>
					<?php echo help('https://... 형태의 풀 이미지 주소를 등록해 주세요.'); ?>
					<input type="text" name="na[seo_shop_img]" value="<?php echo get_sanitize_input($nariya['seo_shop_img']) ?>" class="frm_input extra-value-input" size="80">
				</td>
			</tr>
			<tr>
				<th scope="row">
					쇼핑몰 SEO 설명글
				</th>
				<td>
					<?php echo help('구글의 경우 설명의 제한이 990픽셀이므로 한글 기준으로 50자 내외 등록 - 한글 글자크기는 보통 20픽셀'); ?>
					<textarea name="na[seo_shop_desc]" style="height:80px;"><?php echo get_text($nariya['seo_shop_desc']); ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row">
					쇼핑몰 SEO 키워드
				</th>
				<td>
					<?php echo help('구글의 경우 제목과 키워드의 제한이 560픽셀이므로 한글 기준으로 30자 내외 등록 - 한글 글자크기는 보통 20픽셀'); ?>
					<textarea name="na[seo_shop_keys]" style="height:80px;"><?php echo get_text($nariya['seo_shop_keys']); ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row">
					쇼핑몰 기능 확장
				</th>
				<td>
					<?php echo help('다운로드 컨텐츠, 포인트 구매, 멤버십 상품 등 기능 추가') ?>
					<label>
						<input type="checkbox" name="na[is_extend]" value="1"<?php echo get_checked('1', $nariya['is_extend'])?>> 쇼핑몰 기능 확장
					</label>
				</td>
			</tr>
			<?php if($nariya['is_extend']) { ?>
				<tr>
					<th scope="row">
						멤버십 칼럼
					</th>
					<td>
						<?php echo help('<b style="color:red;">주의!!!!! 입력시 자동으로 DB에 입력한 칼럼이 추가되나 삭제를 일일이 DB에서 직접하셔야 하니 신중히 설정해 주세요.</b><br>DB의 회원정보 테이블에 추가될 멤버십 칼럼으로 콤마(,)로 구분하여 복수 등록 가능합니다.'); ?>
						<input type="text" name="na[mbs_list]" value="<?php echo get_sanitize_input($nariya['mbs_list']) ?>" class="frm_input extra-value-input" size="80">
					</td>
				</tr>
			<?php } ?>
			<tr>
				<th scope="row">
					1:1 문의 레이아웃
				</th>
				<td>
					<?php echo help('커뮤니티/쇼핑몰을 분리해서 사이트 운영시에만 적용됩니다.') ?>
					<label>
						<input type="checkbox" name="na[shop_qa]" value="1"<?php echo get_checked('1', $nariya['shop_qa'])?>> 1:1 문의 쇼핑몰 레이아웃 사용하기
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					FAQ 레이아웃
				</th>
				<td>
					<?php echo help('커뮤니티/쇼핑몰을 분리해서 사이트 운영시에만 적용됩니다.') ?>
					<label>
						<input type="checkbox" name="na[shop_faq]" value="1"<?php echo get_checked('1', $nariya['shop_faq'])?>> FAQ 쇼핑몰 레이아웃 사용하기
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					각 게시판 레이아웃
				</th>
				<td>
					<?php echo help('커뮤니티/쇼핑몰을 분리해서 사이트 운영시에만 적용됩니다.') ?>
					각 게시판의 스킨설정에서 쇼핑몰 레이아웃 사용유무를 설정할 수 있습니다.
				</td>
			</tr>
		<?php } ?>

		<!-- 게시판 설정 -->
		<tr>
		<td colspan="2" style="padding-left:0; padding-top:30px;">
			<span class="h2_frm">게시판 설정</span>
		</td>
		</tr>
		<tr>
			<th scope="row">
				새글 DB 복구
			</th>
			<td>
				<?php echo help('기본환경설정의 최근글 삭제일 이내 게시물에 대해서만 복구합니다.') ?>
				<button type="button" class="btn btn_03" onclick="na_upgrade('./renew.php');">새글 DB 복구</button>
			</td>
		</tr>
		<tr>
			<th scope="row">
				대표 이미지 복구
			</th>
			<td>
				<?php echo help('게시물의 SEO, 썸네일에 사용될 대표 이미지를 복구합니다.') ?>
				<button type="button" class="btn btn_03" onclick="win_memo('./reimg.php');">대표 이미지 복구</button>
			</td>
		</tr>
		<tr>
			<th scope="row">
				동영상 이미지 저장
			</th>
			<td>
				<?php echo help('유튜브, 비메오 등 동영상 썸네일용 대표이미지를 '.str_replace(G5_PATH, '', NA_DATA_PATH).'/video 폴더 내에 서비스별로 저장합니다.') ?>
				<label>
					<input type="checkbox" name="na[save_video_img]" value="1"<?php echo get_checked('1', $nariya['save_video_img'])?>> 서버 저장
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row">
				추천/비추천 취소
			</th>
			<td>
				<input type="text" name="na[cancel_good]" value="<?php echo (int)$nariya['cancel_good'] ?>" class="frm_input" size="5"> 초 이내
				<input type="text" name="na[cancel_times]" value="<?php echo (int)$nariya['cancel_times'] ?>" class="frm_input" size="5"> 회까지 추천/비추천 취소 가능
			</td>
		</tr>
		<tr>
			<th scope="row">
				최대 추천/비추천
			</th>
			<td>
				<input type="text" name="na[max_good]" value="<?php echo (int)$nariya['max_good'] ?>" class="frm_input" size="5"> 회/일
			</td>
		</tr>
		<tr>
			<th scope="row">
				최대 신고수
			</th>
			<td>
				<?php echo help('게시판별/상품후기/상품문의 등 최대 신고 횟수로 값이 클 경우 사용자 및 서버에 부하를 많이 줍니다.') ?>
				<input type="text" name="na[max_singo]" value="<?php echo (int)$nariya['max_singo'] ?>" class="frm_input" size="5"> 회
			</td>
		</tr>
		<tr>
			<th scope="row">
				게시물 잠금
			</th>
			<td>
				<?php echo help('신고 내역 중에서 게시판의 게시물에 대해서만 잠금처리가 됩니다.') ?>
				<input type="text" name="na[singo]" value="<?php echo (int)$nariya['singo'] ?>" class="frm_input" size="5"> 회 신고 접수시 게시물 자동 잠금
			</td>
		</tr>
		<tr>
			<th scope="row">
				알림 보관일
			</th>
			<td>
				<?php echo help('설정일이 지난 알림 자동 삭제, 0 이면 모두 보관') ?>
				<input type="text" name="na[noti_days]" value="<?php echo (int)$nariya['noti_days'] ?>" class="frm_input" size="5"> 일 동안 보관
			</td>
		</tr>
		<tr>
			<th scope="row">
				실시간 알림
			</th>
			<td>
				<?php echo help('0 설정시 실시간 알림 체크를 하지 않습니다.') ?>
				<input type="text" name="na[noti_check]" value="<?php echo (int)$nariya['noti_check'] ?>" class="frm_input" size="5"> 초 간격으로 알림 체크
			</td>
		</tr>
		<tr>
			<th scope="row">
				1:1 문의 알림
			</th>
			<td>
				<?php echo help('1:1 문의에 새글 등록시 알림 받을 회원아이디 목록으로 콤마(,)로 구분하여 복수등록 가능합니다.') ?>
				<textarea name="na[noti_qa]" style="height:80px;"><?php echo get_text($nariya['noti_qa']); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				유튜브 API 키
			</th>
			<td>
				<?php echo help('1) https://console.developers.google.com/apis 접속 후 좌측 라이브러리 선택'); ?>
				<?php echo help('2) YouTube Data API v3 선택 후 사용'); ?>
				<?php echo help('3) 사용자 인증 정보 > 사용자 인증 정보 만들기 > API 키 선택하면 API 키 생성 완료됨'); ?>
				<input type="text" name="na[youtube_key]" value="<?php echo get_sanitize_input($nariya['youtube_key']) ?>" class="frm_input" size="80">
			</td>
		</tr>
		<tr>
			<th scope="row">
				카카오 지도 API 키
			</th>
			<td>
				<?php echo help('구글맵 보다 우선 실행. 카카오 개발자 사이트(https://developers.kakao.com) 접속 → 개발자 등록 및 앱 생성 → 웹 플랫폼 추가 → 사이트 도메인 등록 → 앱 키 중 JavaScript 키 등록') ?>
				<input type="text" name="na[kakaomap_key]" value="<?php echo get_sanitize_input($nariya['kakaomap_key']) ?>" class="frm_input" size="80">
			</td>
		</tr>
		<tr>
			<th scope="row">
				페이스북 토큰
			</th>
			<td>
				<?php echo help('페북 동영상 썸네일을 가져오기 위해서는 페북 개발자센터에서 앱을 등록하고 Tools & Support > Graph API Explorer 메뉴에서 Get Token > Get App Token 실행 후 생성된 토큰을 등록해야 합니다.') ?>
				<input type="text" name="na[fb_key]" value="<?php echo get_sanitize_input($nariya['fb_key']) ?>" class="frm_input" size="80">
			</td>
		</tr>

		<!-- 회원 설정 -->
		<tr>
		<td colspan="2" style="padding-left:0; padding-top:30px;">
			<span class="h2_frm">회원 설정</span>
		</td>
		</tr>
		<tr>
			<th scope="row">
				최고관리자
			</th>
			<td>
				<?php echo help('회원아이디를 콤마(,)로 구분하여 복수 회원 등록이 가능합니다.') ?>
				<textarea name="na[cf_admin]" style="height:80px;"><?php echo get_text($nariya['cf_admin']); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				그룹관리자
			</th>
			<td>
				<?php echo help('회원아이디를 콤마(,)로 구분하여 복수 회원 등록이 가능합니다.') ?>
				<textarea name="na[cf_group]" style="height:80px;"><?php echo get_text($nariya['cf_group']); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				최대 차단수
			</th>
			<td>
				<?php echo help('최대 차단 회원수로 값이 클 경우 사용자 및 서버에 부하를 많이 줍니다.') ?>
				<input type="text" name="na[max_chadan]" value="<?php echo (int)$nariya['max_chadan'] ?>" class="frm_input" size="5"> 회
			</td>
		</tr>
		<tr>
			<th scope="row">
				회원 전용
			</th>
			<td>
				<?php echo help('사이트를 회원 전용으로 설정합니다. 3등급 이상 설정시 가입 회원을 3등급으로 조정해 줘야 합니다.') ?>
				<select name="na[mb_only]">
					<option value="">사용안함</option>
					<option value="2"<?php echo get_selected($nariya['mb_only'], "2") ?>>2등급 이상(자동승인)</option>
					<option value="3"<?php echo get_selected($nariya['mb_only'], "3") ?>>3등급 이상(승인심사)</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				레벨 아이콘
			</th>
			<td colspan="3">
				<?php echo help('/plugin/nariya/skin/level 폴더. gif, png, jpg 아이콘 모두 사용 가능. ※ 주의 : 회원수에 따라 서버 부하가 많이 발생할 수도 있음') ?>
				<select name="na[lvl_skin]">
					<option value="">사용안함</option>
					<?php 
					$nariya['lvl_skin'] = isset($nariya['lvl_skin']) ? $nariya['lvl_skin'] : '';
					$skins = get_skin_dir('', NA_PATH.'/skin/level');
					for ($i=0; $i<count($skins); $i++) { 
					?>
						<option value="<?php echo $skins[$i] ?>"<?php echo get_selected($nariya['lvl_skin'], $skins[$i]) ?>><?php echo $skins[$i] ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				관리자 레벨 아이콘
			</th>
			<td colspan="3">
				<?php echo help('회원아이디를 콤마(,)로 구분하여 복수 회원 등록이 가능합니다.') ?>
				<textarea name="na[lvl_admin]" style="height:80px;"><?php echo get_text($nariya['lvl_admin']); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				스페셜 레벨 아이콘
			</th>
			<td colspan="3">
				<?php echo help('회원아이디를 콤마(,)로 구분하여 복수 회원 등록이 가능합니다.') ?>
				<textarea name="na[lvl_special]" style="height:80px;"><?php echo get_text($nariya['lvl_special']); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">
				레벨업 경험치
			</th>
			<td colspan="3">
				<?php echo help('레벨당 레벨업을 위한 최소 필요 경험치') ?>
				<?php $nariya['xp_point'] = (isset($nariya['xp_point']) && $nariya['xp_point']) ? (int)$nariya['xp_point'] : 1000; ?>
				<input type="text" name="na[xp_point]" size="6" value="<?php echo $nariya['xp_point'] ?>" class="frm_input"> 경험치
				&nbsp;
				<a href="./exp.calc.php" class="btn btn_03 win_point">레벨업 경험치 시뮬레이터</a>
			</td>
		</tr>
		<tr>
			<th scope="row">
				경험치 증가율
			</th>
			<td colspan="3">
				<?php echo help('레벨업 필요 경험치 = 기준 경험치 + 기준 경험치 * 직전 레벨 * 경험치 증가율') ?>
				<?php $nariya['xp_rate'] = (isset($nariya['xp_rate']) && $nariya['xp_rate']) ? (float)$nariya['xp_rate'] : 0.1; ?>
				<input type="text" name="na[xp_rate]" size="6" value="<?php echo $nariya['xp_rate'] ?>" class="frm_input"> 배 * 직전 레벨 * 기준 경험치
			</td>
		</tr>
		<tr>
			<th scope="row">
				최고 레벨
			</th>
			<td colspan="3">
				<?php $nariya['xp_max'] = (isset($nariya['xp_max']) && $nariya['xp_max']) ? (int)$nariya['xp_max'] : 99; ?>
				<input type="text" name="na[xp_max]" size="6" value="<?php echo $nariya['xp_max'] ?>" class="frm_input"> 레벨
			</td>
		</tr>
		<tr>
			<th scope="row">
				자동 등업
			</th>
			<td colspan="3">
				<?php echo help('자동등업 시작등급:각 등급별 최고레벨 방식으로 설정하며, 각 등급별 최고 레벨은 낮은 레벨부터 콤마(,)를 이용하여 구분합니다.') ?>
				<?php echo help('ex) 2:19,39,59,79 설정시 2등급은 1~19레벨까지, 3등급은 20~39레벨까지, 4등급은 40~59레벨까지 5등급은 60~79레벨까지, 6등급은 80~최고 레벨까지 자동부여 됩니다.') ?>
				<?php echo help('ex) 3:24,49,74 설정시 자동등업이 3등급부터 적용되므로 2등급을 3등급으로 등업하는 것은 수동으로 해주셔야 합니다. 즉, 3등급부터 6등급까지만 레벨에 따른 자동등업이 적용됩니다.') ?>
				<?php $nariya['xp_auto'] = isset($nariya['xp_auto']) ? $nariya['xp_auto'] : ''; ?>
				<input type="text" name="na[xp_auto]" size="80" value="<?php echo get_text($nariya['xp_auto']) ?>" class="frm_input extra-value-input">
			</td>
		</tr>
		<tr>
			<th scope="row">
				로그인 경험치
			</th>
			<td colspan="3">
				<?php echo help('로그인시 적립되는 경험치로 1일 1회만 적용됩니다.') ?>
				<?php $nariya['xp_login'] = isset($nariya['xp_login']) ? (int)$nariya['xp_login'] : 0; ?>
				<input type="text" name="na[xp_login]" size="6" value="<?php echo $nariya['xp_login'];?>" class="frm_input"> 경험치
			</td>
		</tr>
		<tr>
			<th scope="row">
				회원등급명
			</th>
			<td>
				<?php echo help('회원 등급에 따른 이름으로 미설정시 출력되지 않습니다.') ?>

				<div class="tbl_head01 tbl_wrap">
					<table>
					<caption>회원등급명</caption>
					<thead>
					<tr>
						<th scope="col">구분</th>
						<th scope="col">1등급</th>
						<th scope="col">2등급</th>
						<th scope="col">3등급</th>
						<th scope="col">4등급</th>
						<th scope="col">5등급</th>
						<th scope="col">6등급</th>
						<th scope="col">7등급</th>
						<th scope="col">8등급</th>
						<th scope="col">9등급</th>
						<th scope="col">10등급</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							회원등급명
						</td>
						<td>
							<input type="text" name="na[mb_gn1]" value="<?php echo get_text($nariya['mb_gn1']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn2]" value="<?php echo get_text($nariya['mb_gn2']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn3]" value="<?php echo get_text($nariya['mb_gn3']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn4]" value="<?php echo get_text($nariya['mb_gn4']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn5]" value="<?php echo get_text($nariya['mb_gn5']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn6]" value="<?php echo get_text($nariya['mb_gn6']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn7]" value="<?php echo get_text($nariya['mb_gn7']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn8]" value="<?php echo get_text($nariya['mb_gn8']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn9]" value="<?php echo get_text($nariya['mb_gn9']); ?>" class="frm_input">
						</td>
						<td>
							<input type="text" name="na[mb_gn10]" value="<?php echo get_text($nariya['mb_gn10']); ?>" class="frm_input">
						</td>
					</tr>
					<tr>
						<td>예시</td>
						<td>비회원</td>
						<td>일반회원</td>
						<td>정회원</td>
						<td>VIP</td>
						<td>일반운영자</td>
						<td>그룹운영자</td>
						<td>통합운영자</td>
						<td>일반관리자</td>
						<td>중간관리자</td>
						<td>최고관리자</td>
					</tr>
					</tbody>
					</table>
				</div>

			</td>
		</tr>
		</tbody>
		</table>
	</div>

	<div class="btn_fixed_top btn_confirm">
		<input type="submit" value="저장" class="btn_submit btn" accesskey="s">
	</div>
</form>


<script>
<?php if (isset($member['as_chadan'])) { ?>
function na_upgrade(url) {
	$.post(url, function(data) {
		alert(data);
		return false;
	});
}
<?php } else { ?>
function na_upgrade(url) {
    if(confirm("나리야 설치시 DB에 알림, 신고, 태그, 레벨 등을 위한 새로운 테이블과 기존 그누의 회원 및 새글DB에 칼럼을 추가합니다.\n\n나리야로 인해 추가되는 부분은 /plugin/nariya/adm/db.php 파일을 참고해 주세요.\n\n정말 나리야를 설치하시겠습니까?")) {
		$.post(url, function(data) {
			alert(data);
			location.reload(true);
			return false;
		});
	}
	return false;
}
<?php } ?>
function fnariya_submit(f) {

	f.action = "./admin.php";

	return true;

}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');