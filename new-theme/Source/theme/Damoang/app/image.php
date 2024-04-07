<?php
include_once('./_common.php');

if ($is_admin || IS_DEMO) {
	;
} else {
    alert_close('접근권한이 없습니다.');
}

$type = (isset($_REQUEST['type'])) ? na_fid($_REQUEST['type']) : '';
$fid = (isset($_REQUEST['fid'])) ? na_fid($_REQUEST['fid']) : '';

if(!$type || !$fid)
    alert_close('값이 제대로 넘어오지 않았습니다.');

$mode = (isset($_REQUEST['mode'])) ? na_fid($_REQUEST['mode']) : '';

// 이미지 등록
if($mode == 'upload') {

	if(!isset($_FILES['imgFile']['tmp_name']) || !$_FILES['imgFile']['tmp_name']) 
		alert("파일을 등록해 주세요.");

	$upload_max_filesize = ini_get('upload_max_filesize');

	$_FILES['imgFile']['error'] = isset($_FILES['imgFile']['error']) ? $_FILES['imgFile']['error'] : 0;

	if($_FILES['imgFile']['error'] == 1) {
		alert('파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.');
	} else if ($_FILES['imgFile']['error'] != 0) {
		alert('파일이 정상적으로 업로드 되지 않았습니다.');
	}

	$_FILES['imgFile']['name'] = isset($_FILES['imgFile']['name']) ? $_FILES['imgFile']['name'] : '';

	if(!preg_match("/(\.(jpg|jpeg|gif|png))$/i", $_FILES['imgFile']['name']))
		alert('JPG, JPEG, GIF, PNG 파일만 등록이 가능합니다.');

	if(strlen($_FILES['imgFile']['name']) > 40)
		alert('확장자 포함해서 파일명을 40자 이내로 등록할 수 있습니다.'); 

	if(!preg_match("/([-A-Za-z0-9_])$/", $_FILES['imgFile']['name']))
		alert('파일명은 공백없이 영문자, 숫자, -, _ 만 사용 가능합니다.'); 

	list($thumb) = explode('-', $_FILES['imgFile']['name']);

	if($thumb == 'thumb')
		alert('파일명이 thumb- 일 경우 썸네일 파일로 인식되기 때문에 등록할 수 없습니다.'); 

	$spot = '';
	if(is_uploaded_file($_FILES['imgFile']['tmp_name'])) {

		$filename = $type.'-'.$_FILES['imgFile']['name'];

		$dest_file = NA_DATA_PATH.'/image/'.$filename;

		// 기존파일 삭제
		@unlink($dest_file);

		// 파일등록
		@move_uploaded_file($_FILES['imgFile']['tmp_name'], $dest_file);

		// 퍼미션변경
		@chmod($dest_file, G5_FILE_PERMISSION);

		$spot = '#'.urlencode(substr($filename, 0, strrpos($filename, '.')));
	}

	// 페이지 이동
	$goto_url = './image.php?fid='.urlencode($fid).'&amp;type='.urlencode($type);
	
	goto_url($goto_url);

} else if($mode == 'del') {

	$img = (isset($_REQUEST['img'])) ? $_REQUEST['img'] : '';

	if(!$img)
	    alert_close('값이 제대로 넘어오지 않았습니다.');

	if(!preg_match("/([-A-Za-z0-9_])$/", basename($img)))
		alert('파일명은 공백없이 영문자, 숫자, -, _ 만 사용 가능합니다.'); 

	if (!preg_match("/(\.(jpg|jpeg|gif|png))$/i", $img))
		alert('삭제 가능한 파일이 아닙니다.');

	// 이미지 주소
	$img_file = NA_DATA_PATH.'/image/'.$img;

	if(!is_file($img_file))
		alert('파일이 존재하지 않습니다.');

	// 썸네일 삭제를 위해 파일명 체크
	$name = basename($img_file);
	$name = substr($name, 0, strrpos($name, '.'));

	// 이미지 리스트 정리
	$arr = array();
	$list = array();

	// 썸네일 체크
	$arr = na_file_list(NA_DATA_PATH.'/image');

	$arr_cnt = is_array($arr) ? count($arr) : 0;

	$i=0;
	for($j=0; $j < $arr_cnt; $j++) {

		$tmp = isset($arr[$j]) ? $arr[$j] : '';

		if(!$tmp)
			continue;

		if(!preg_match("/(\.(jpg|jpeg|gif|png))$/i", $tmp))
			continue;

		list($head) = explode('-', $tmp);

		if($head != 'thumb')
			continue;

		if(strpos($tmp, $name) === false)
			continue;

		$list[$i] = $tmp;
		$i++;
	}

	// 썸네일 삭제
	$list_cnt = is_array($list) ? count($list) : 0;
	for($i=0; $i < $list_cnt; $i++) {

		if(!isset($list[$i]) || !$list[$i])
			continue;

		$del_file = NA_DATA_PATH.'/image/'.$list[$i];

		@chmod($del_file, G5_FILE_PERMISSION);
		@unlink($del_file);
	}

	// 본 이미지 삭제
	@chmod($img_file, G5_FILE_PERMISSION);
	@unlink($img_file);


	// 페이지 이동
	$goto_url = './image.php?fid='.urlencode($fid).'&amp;type='.urlencode($type);
	
	goto_url($goto_url);

}

$g5['title'] = '이미지 관리';
include_once(G5_PATH.'/head.sub.php');

// 이미지 리스트 정리
$arr = array();
$list = array();

$arr = na_file_list(NA_DATA_PATH.'/image');

$arr_cnt = (is_array($arr)) ? count($arr) : 0;

$i=0;
for($j=0; $j < $arr_cnt; $j++) {

	$img = isset($arr[$j]) ? $arr[$j] : '';

	if(!$img)
		continue;

	if (!preg_match("/(\.(jpg|jpeg|gif|png))$/i", $img))
		continue;

	list($head) = explode('-', $img);

	if($head != $type)
		continue;

	$list[$i] = $img;
	$i++;
}

$list_cnt = is_array($list) ? count($list) : 0;

?>

<form id="fsetup" name="fsetup" action="./image.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="fid" value="<?php echo $fid ?>">
<input type="hidden" name="type" value="<?php echo $type ?>">
<input type="hidden" name="mode" value="upload">
	<div class="p-3">
		<div class="input-group">
			<input type="file" name="imgFile" class="form-control" id="imgBoxFile">
			<button type="submit" class="btn btn-primary">등록하기</button>
		</div>
	</div>
</form>

<div class="px-3 pb-3">
	<div class="row g-2 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
		<?php for($i=0; $i < $list_cnt; $i++) { ?>
			<div class="col">
				<div class="card h-100">
					<div class="card-body text-center p-2 d-flex flex-column gap-2">
						<div>
							<a href="#image" class="d-block rounded overflow-hidden sel-img" title="../image/<?php echo $list[$i] ?>">
								<img src="<?php echo NA_DATA_URL ?>/image/<?php echo $list[$i] ?>" alt="" class="w-100">
							</a>
						</div>
						<div class="mt-auto">
							<a href="./image.php?mode=del&amp;fid=<?php echo urlencode($fid) ?>&amp;type=<?php echo urlencode($type) ?>&amp;img=<?php echo urlencode($list[$i]) ?>" class="btn btn-basic btn-sm img-del" title="삭제">
								<i class="bi bi-trash"></i>
								<span class="visually-hidden">삭제</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<script>
$(document).ready(function() {
	$('.img-del').click(function() {
		if(confirm("삭제하시겠습니까?")) {
			return true;
		}
		return false;
	});

	$('.sel-img').click(function() {
		$("#<?php echo $fid ?>", opener.document).val(this.title);
		window.close();
		return false;
	});
});
</script>

<?php 
include_once(G5_PATH.'/tail.sub.php');