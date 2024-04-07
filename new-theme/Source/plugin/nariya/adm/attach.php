<?php
$sub_menu = '400300';
include_once('./_common.php');

$it_id = (isset($_REQUEST['it_id']) && $_REQUEST['it_id']) ? safe_replace_regex($_REQUEST['it_id'], 'it_id') : '';

$it = get_shop_item($it_id);

if(!$it)
	alert_close('상품정보가 존재하지 않습니다.');

$it_id = $it['it_id'];

if ($is_admin != 'super') {
	$sql = " select it_id from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b
			  where a.it_id = '$it_id'
				and a.ca_id = b.ca_id
				and b.ca_mb_id = '{$member['mb_id']}' ";
	$row = sql_fetch($sql);
	if (!$row['it_id'])
		alert_close("\'{$member['mb_id']}\' 님께서 등록 할 권한이 없는 상품입니다.");
}

$file_path = G5_DATA_PATH.'/itme/'.$it_id;

$upload_max_filesize = ini_get('upload_max_filesize');

if(isset($_POST['post_action']) && isset($_POST['token'])){

	check_demo();

	//check_admin_token();

	if($_POST['post_action'] == 'save') {

		auth_check_menu($auth, $sub_menu, 'w');

		// 파일개수 체크
		$file_count   = 0;
		$upload_count = (isset($_FILES['sf_file']['name']) && is_array($_FILES['sf_file']['name'])) ? count($_FILES['sf_file']['name']) : 0;

		for ($i=0; $i<$upload_count; $i++) {
			if($_FILES['sf_file']['name'][$i] && is_uploaded_file($_FILES['sf_file']['tmp_name'][$i]))
				$file_count++;
		}

		$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

		// 가변 파일 업로드
		$file_upload_msg = '';
		$upload = array();

		if(isset($_FILES['sf_file']['name']) && is_array($_FILES['sf_file']['name'])) {
			for ($i=0; $i<count($_FILES['sf_file']['name']); $i++) {
				$upload[$i]['file']     = '';
				$upload[$i]['source']   = '';
				$upload[$i]['filesize'] = 0;
				$upload[$i]['free'] = (isset($_POST['sf_free'][$i]) && $_POST['sf_free'][$i]) ? 1 : 0;

				// 삭제에 체크가 되어있다면 파일을 삭제합니다.
				if (isset($_POST['sf_file_del'][$i]) && $_POST['sf_file_del'][$i]) {
					$upload[$i]['del_check'] = true;

					$row = sql_fetch(" select * from {$g5['na_file']} where it_id = '{$it_id}' and sf_no = '{$i}' ");
					$delete_file = $file_path.'/'.$row['sf_file'];
					if(file_exists($delete_file)){
						@unlink($delete_file);
					}
				} else {
					$upload[$i]['del_check'] = false;
				}

				$tmp_file  = $_FILES['sf_file']['tmp_name'][$i];
				$filesize  = $_FILES['sf_file']['size'][$i];
				$filename  = $_FILES['sf_file']['name'][$i];
				$filename  = get_safe_filename($filename);

				// 서버에 설정된 값보다 큰파일을 업로드 한다면
				if ($filename) {
					if ($_FILES['sf_file']['error'][$i] == 1) {
						$file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
						continue;
					} else if ($_FILES['sf_file']['error'][$i] != 0) {
						$file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
						continue;
					}
				}

				if (is_uploaded_file($tmp_file)) {

					//=================================================================\
					// 090714
					// 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
					// 에러메세지는 출력하지 않는다.
					//-----------------------------------------------------------------
					$timg = @getimagesize($tmp_file);
					// image type
					if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
						 preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
						if ($timg['2'] < 1 || $timg['2'] > 18)
							continue;
					}
					//=================================================================

					$upload[$i]['image'] = $timg;

					// 프로그램 원래 파일명
					$upload[$i]['source'] = $filename;
					$upload[$i]['filesize'] = $filesize;

					// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
					$filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc|phar)/i", "$0-x", $filename);

					shuffle($chars_array);
					$shuffle = implode('', $chars_array);

					// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
					$upload[$i]['file'] = md5(sha1($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

					$dest_file = G5_DATA_PATH.'/item/'.$it_id.'/'.$upload[$i]['file'];

					// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
					$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['sf_file']['error'][$i]);

					// 올라간 파일의 퍼미션을 변경합니다.
					chmod($dest_file, G5_FILE_PERMISSION);

				}
			}   // end for
		}   // end if

		for ($i=0; $i<count($upload); $i++) {
			$upload[$i]['source'] = sql_real_escape_string($upload[$i]['source']);
			$sf_content[$i] = isset($sf_content[$i]) ? sql_real_escape_string($sf_content[$i]) : '';

			$row = sql_fetch(" select count(*) as cnt from {$g5['na_file']} where it_id = '{$it_id}' and sf_no = '{$i}' ");
			if ($row['cnt']) {
				// 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
				// 그렇지 않다면 내용만 업데이트 합니다.
				if ($upload[$i]['del_check'] || $upload[$i]['file']) {
					$sql = " update {$g5['na_file']}
								set sf_source = '{$upload[$i]['source']}',
									sf_file = '{$upload[$i]['file']}',
									sf_content = '{$sf_content[$i]}',
									sf_free = '{$upload[$i]['free']}',
									sf_filesize = '".(int)$upload[$i]['filesize']."',
									sf_datetime = '".G5_TIME_YMDHIS."'
							  where it_id = '{$it_id}'
									and sf_no = '{$i}' ";
					sql_query($sql);

				} else {

					$sql = " update {$g5['na_file']}
								set sf_content = '{$sf_content[$i]}',
									sf_free = '{$upload[$i]['free']}'
								where it_id = '{$it_id}'
									  and sf_no = '{$i}' ";
					sql_query($sql);
				}

			} else {

				$sql = " insert into {$g5['na_file']}
							set it_id = '{$it_id}',
								sf_no = '{$i}',
								sf_source = '{$upload[$i]['source']}',
								sf_file = '{$upload[$i]['file']}',
								sf_content = '{$sf_content[$i]}',
								sf_download = 0,
								sf_free = '{$upload[$i]['free']}',
								sf_filesize = '".(int)$upload[$i]['filesize']."',
								sf_datetime = '".G5_TIME_YMDHIS."' ";
				sql_query($sql);
			}
		}

		// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
		// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
		$row = sql_fetch(" select max(sf_no) as max_sf_no from {$g5['na_file']} where it_id = '{$it_id}' ");
		for ($i=(int)$row['max_sf_no']; $i>=0; $i--) {
			$row2 = sql_fetch(" select sf_file from {$g5['na_file']} where it_id = '{$it_id}' and sf_no = '{$i}' ");

			// 정보가 있다면 빠집니다.
			if (isset($row2['sf_file']) && $row2['sf_file']) 
				break;

			// 그렇지 않다면 정보를 삭제합니다.
			sql_query(" delete from {$g5['na_file']} where it_id = '{$it_id}' and sf_no = '{$i}' ");
		}

		if ($file_upload_msg)
		    alert($file_upload_msg, './attach.php?it_id='.$it_id);
	}

	// 페이지 이동
	goto_url('./attach.php?it_id='.$it_id);
}

$g5['title'] = '첨부파일 관리';
include_once(G5_PATH.'/head.sub.php');
?>
<style>
body { background:#fff; }
</style>
<div id="attach" class="new_win">
    <h1 id="win_title"><?php echo get_text($it['it_name']) ?></h1>
	<form name="fattach" id="fattach" action="./attach.php" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="it_id" value="<?php echo $it_id ?>">
	<input type="hidden" name="token" value="">
	<input type="hidden" name="post_action" value="save">
    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>첨부파일 업로드</caption>
        <colgroup>
            <col class="grid_1">
			<col>
            <col class="grid_1">
        </colgroup>
		<thead>
		<tr>
			<th scope="col">삭제</th>
			<th scope="col">파일 : 한번에 최대 <?php echo $upload_max_filesize ?> 까지 업로드 가능</th>
			<th scope="col">무료</th>
		<tbody>
		<?php 
		$attach = na_file($it['it_id']);
		for ($i=0; $i < 10; $i++) { 
			$href = isset($attach[$i]['href']) ? $attach[$i]['href'] : '';
			$source = isset($attach[$i]['source']) ? $attach[$i]['source'] : '';
			$size = isset($attach[$i]['size']) ? $attach[$i]['size'] : '';
			$free = isset($attach[$i]['free']) ? $attach[$i]['free'] : '';
		?>
			<tr>
			<td align="center">
				<?php if($href) { ?>
					<input type="checkbox" id="sf_file_del<?php echo $i ?>" name="sf_file_del[<?php echo $i  ?>]" value="1"> 
				<?php } ?>
			</td>
			<td>
				<?php if($href) { ?>
					<p style="text-align:left">
						<a href="<?php echo $href ?>">
							<?php echo $source ?> (<?php echo $size ?>)
						</a>
					</p>
				<?php } ?>
				<input type="file" name="sf_file[<?php echo $i ?>]" style="width:100%;">
			</td>
			<td align="center">
				<input type="checkbox" id="sf_free<?php echo $i ?>" name="sf_free[<?php echo $i  ?>]" value="1"<?php echo get_checked($free, "1")?>>
			</td>
			</tr>
		<?php } ?>
        </tbody>
        </table>
	</div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="저장하기" id="btn_submit" class="btn_submit">
    </div>

	</form>
</div>
<?php 
include_once(G5_PATH.'/tail.sub.php');