<?php
include_once('./_common.php');

if ($is_admin == 'super' || IS_DEMO) {
	;
} else {
    die('접근권한이 없습니다.');
}

$wid = isset($_REQUEST['wid']) ? na_fid($_REQUEST['wid']) : '';
$wname = isset($_REQUEST['wname']) ? na_fid($_REQUEST['wname']) : '';
$layout = isset($_REQUEST['layout']) ? na_fid($_REQUEST['layout']) : '';

if(!$wid || !$wname || !$layout)
    die('값이 제대로 넘어오지 않았습니다.');

$wdir = isset($_REQUEST['wdir']) ? $_REQUEST['wdir'] : '';
$optp = isset($_REQUEST['optp']) ? $_REQUEST['optp'] : '';
$optm = isset($_REQUEST['optm']) ? $_REQUEST['optm'] : '';

// 설정값아이디
$id = $wname.'-'.$wid;

// 저장하기
if(isset($_POST['wname']) && $_POST['wname']) {

	// 파일
	$pc_file = NA_DATA_PATH.'/widget/w-'.$id.'-pc.php';
	$mo_file = NA_DATA_PATH.'/widget/w-'.$id.'-mo.php';
	echo $optp;
	// 이동주소
	$goto_url = NA_URL.'/widget.form.php?layout='.urlencode($layout).'&amp;wname='.urlencode($wname).'&amp;wid='.urlencode($wid);
	$goto_url .= '&amp;optp='.$optp.'&amp;optm='.$optm;
	if($wdir) {
		$wdir = preg_replace('/[^-A-Za-z0-9_\/]/i', '', trim(str_replace(G5_PATH, '', $wdir)));
		$goto_url .= '&amp;wdir='.urlencode($wdir);
	}

	// 초기화 - 캐시 삭제는 안함
	if(isset($_POST['freset']) && $_POST['freset']) {
		na_file_delete($pc_file);
		na_file_delete($mo_file);

		goto_url($goto_url);
	}

	// 기본 위젯 설정
	$pc = (isset($_POST['wset']) && is_array($_POST['wset'])) ? $_POST['wset'] : array();

	// 기본 설정 저장
	na_file_var_save($pc_file, $pc);

	// 모바일 위젯 설정
	$mo = array();
	if(isset($_POST['mo']) && is_array($_POST['mo'])) {
		$mo = $_POST['mo'];
		$mo = array_merge($pc, $mo);
	} else {
		$mo = $pc;
	}

	// 모바일 설정 저장
	na_file_var_save($mo_file, $mo);

	// 위젯 캐시 초기화
	g5_delete_cache(md5('w-'.$wname.'-'.$wid.'-pc'));
	g5_delete_cache(md5('w-'.$wname.'-'.$wid.'-mo'));

	goto_url($goto_url);
}

$optp = ($optp) ? unserialize(stripslashes(stripslashes($optp))) : '';
$optm = ($optm) ? unserialize(stripslashes(stripslashes($optm))) : '';

// 경로
if($wdir) {
    $wdir = preg_replace('/[^-A-Za-z0-9_\/]/i', '', trim(str_replace(G5_PATH, '', $wdir)));
	$widget_path = G5_PATH.$wdir.'/'.$wname;
	$widget_url = str_replace(G5_PATH, G5_URL, $widget_path);
} else {
	$widget_path = G5_THEME_PATH.'/layout/'.$layout.'/widget/'.$wname;
	$widget_url = G5_THEME_URL.'/layout/'.$layout.'/widget/'.$wname;
}

if(!file_exists($widget_path.'/widget.setup.php'))
	die('위젯 설정을 할 수 없는 위젯입니다.');

include_once(NA_PATH.'/lib/option.lib.php');

// 기본 설정값
$wset = array();
if(!is_file(NA_DATA_PATH.'/widget/w-'.$id.'-pc.php') && $optp) {
	$wset = is_array($optp) ? $optp : na_query($optp);
} else {
	$wset = na_file_var_load(NA_DATA_PATH.'/widget/w-'.$id.'-pc.php');
}

// 모바일 설정값
$mo = array();
if(!is_file(NA_DATA_PATH.'/widget/w-'.$id.'-mo.php') && $optm) {
	$mo = is_array($optm) ? $optm : na_query($optm);
} else {
	$mo = na_file_var_load(NA_DATA_PATH.'/widget/w-'.$id.'-mo.php');
}

$g5['title'] = '위젯 설정';
include_once(G5_PATH.'/head.sub.php');

// 아이디 넘버링용
$idn = 1;
?>

<form id="fsetup" name="fsetup" action="./widget.form.php" method="post" onsubmit="return fsetup_submit(this);">
<input type="hidden" name="wid" value="<?php echo $wid ?>">
<input type="hidden" name="wname" value="<?php echo $wname ?>">
<input type="hidden" name="wdir" value="<?php echo $wdir ?>">
<input type="hidden" name="optp" value="<?php echo urlencode(addslashes(serialize($optp))) ?>">
<input type="hidden" name="optm" value="<?php echo urlencode(addslashes(serialize($optm))) ?>">
<input type="hidden" name="layout" value="<?php echo $layout ?>">
<input type="hidden" name="freset" value="">

<?php include_once(G5_THEME_PATH.'/app/widget.form.php'); ?>

</form>

<?php
include_once(G5_PATH.'/tail.sub.php');