<?php
include_once('./_common.php');

if ($is_admin || IS_DEMO) {
	;
} else {
    die('접근권한이 없습니다.');
}

if (!isset($board['bo_table']) || !$board['bo_table'])
	die('잘못된 접근입니다.');

// 저장하기
if(isset($_POST['bo_table']) && $_POST['bo_table']) {

	check_demo();

	$vars = $_POST['boset'];

	// 파일 및 이동주소
	$pc_file = NA_DATA_PATH.'/board/board-'.$bo_table.'-pc.php';
	$mo_file = NA_DATA_PATH.'/board/board-'.$bo_table.'-mo.php';

	$goto_url = NA_URL.'/board.skin.php?bo_table='.$bo_table;

	if(is_file($board_skin_path.'/setup.save.php'))
		@include_once($board_skin_path.'/setup.save.php');

	// 초기화 - 캐시 삭제는 안함
	if(isset($_POST['freset']) && $_POST['freset'] == '1') {
		na_file_delete($pc_file);
		na_file_delete($mo_file);

		goto_url($goto_url);
	}

	// 값저장
	if(isset($_POST['both']) && $_POST['both'] == '1') {
		na_file_var_save($pc_file, $vars);
		na_file_var_save($mo_file, $vars);
	} else if(G5_IS_MOBILE) {
		na_file_var_save($mo_file, $vars);
	} else {
		na_file_var_save($pc_file, $vars);
	}

	goto_url($goto_url);

}

$g5['title'] = '게시판 스킨 설정';
include_once(G5_PATH.'/head.sub.php');
include_once(NA_PATH.'/lib/option.lib.php');

$idn = 1; // id Start
?>

<form id="fsetup" name="fsetup" action="<?php echo NA_URL ?>/board.skin.php" method="post" onsubmit="return fsetup_submit(this);">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="both" value="">
<input type="hidden" name="freset" value="">

<?php include_once (G5_THEME_PATH.'/app/board.skin.php'); ?>

</form>

<?php
include_once(G5_PATH.'/tail.sub.php');