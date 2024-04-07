<?php
$sub_menu = "800100";
include_once('./_common.php');

// 처리하기
if(isset($_POST['act']) && $_POST['act'] == 'ok') {

	check_demo();

	auth_check_menu($auth, $sub_menu, 'w');

	$_POST['chk_bo_table'] = (isset($_POST['chk_bo_table']) && is_array($_POST['chk_bo_table'])) ? $_POST['chk_bo_table'] : array();

	if(!count($_POST['chk_bo_table']))
		alert('게시판을 한 개 이상 선택해 주십시오.');

	// 자료가 많을 경우 대비 설정변경
	@ini_set('memory_limit', '-1');

	$z = 0;
	for ($i=0; $i<count($_POST['chk_bo_table']); $i++) {
		$tmp_bo_table = preg_replace('/[^a-z0-9_]/i', '', $_POST['chk_bo_table'][$i]);

		if(!$tmp_bo_table)
			continue;

        $tmp_write_table = $g5['write_prefix'] . $tmp_bo_table; // 게시판 테이블 전체이름		
		$result = sql_query(" select * from $tmp_write_table where wr_is_comment = '0' ");
		while($row = sql_fetch_array($result)) {

			$wr_10 = na_url(na_wr_img($tmp_bo_table, $row, 1), 1);
			
			sql_query(" update {$tmp_write_table} set wr_10 = '".addslashes($wr_10)."' where wr_id = '{$row['wr_id']}' ");

			$z++;
		}
	}

	alert('총 '.$z.'건의 대표 이미지 복구 완료', './reimg.php');
}

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = 'SEO 대표이미지 복구하기';
include_once(G5_PATH.'/head.sub.php');

?>

<div id="menu_frm" class="new_win" style="background:#fff;">
    <h1><?php echo $g5['title']; ?></h1>

	<div class="local_desc01">
		게시물의 SEO, 썸네일에 사용될 대표 이미지를 복구합니다.
	</div>

	<form id="updateform" name="updateform" method="post" onsubmit="return update_submit(this);" style="padding:0 10px;">
	<input type="hidden" name="token" value="" id="token">
	<input type="hidden" name="act" value="ok">

	<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">게시판 그룹</th>
        <th scope="col">게시판</th>
    </tr>
    </thead>
    <tbody>
		<?php
			// 아이디 넘버링용
			$idn = 1;
			$result = sql_query(" select gr_id, gr_subject from {$g5['group_table']} order by gr_id ");
			if($result) {
				for ($i=0; $row=sql_fetch_array($result); $i++) {
		?>
				<tr>
				<td>
					<b><?php echo get_text($row['gr_subject']) ?></b>
				</td>
				<td style="text-align:left;">
					<?php
						$result1 = sql_query("select bo_table, bo_subject from {$g5['board_table']} where gr_id = '{$row['gr_id']}' order by bo_table ");
						for ($j=0; $row1=sql_fetch_array($result1); $j++) {
					?>
						<p>
							<input type="checkbox" name="chk_bo_table[]" value="<?php echo $row1['bo_table'] ?>" id="idCheck<?php echo $idn ?>">
							<label for="idCheck<?php echo $idn; ?>"><?php echo get_text($row1['bo_subject']) ?></label>
						</p>
					<?php $idn++; } ?>
				</td>
				</tr>
		<?php 
				}
			} 
		?>
		</tbody>
		</table>

		<br>

		<div class="btn_win02 btn_win">
			<input type="submit" value="실행하기" class="btn_submit btn" accesskey="s">
			<button type="button" class="btn_02 btn" onclick="window.close();">창닫기</button>
		</div>

		<br>

	</div>
	</form>
	<script>
		function update_submit(f) {
			var check = false;

			if (typeof(f.elements['chk_bo_table[]']) == 'undefined')
				;
			else {
				if (typeof(f.elements['chk_bo_table[]'].length) == 'undefined') {
					if (f.elements['chk_bo_table[]'].checked)
						check = true;
				} else {
					for (i=0; i<f.elements['chk_bo_table[]'].length; i++) {
						if (f.elements['chk_bo_table[]'][i].checked) {
							check = true;
							break;
						}
					}
				}
			}

			if (!check) {
				alert('게시판을 한개 이상 선택해 주십시오.');
				return false;
			}

			if(!confirm("실행 후 완료메시지가 나올 때까지 기다려 주세요.\n\n정말 실행하시겠습니까?")) {
				return false;	
			} 
			return true;
		}
	</script>

<?php 
include_once(G5_PATH.'/tail.sub.php');