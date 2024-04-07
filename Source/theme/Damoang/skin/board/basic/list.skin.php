<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

// 멤버십
na_membership('list', '멤버십 회원만 목록을 볼 수 있습니다.');

// 분류 스킨
$category_skin = isset($boset['category_skin']) && $boset['category_skin'] ? $boset['category_skin'] : 'basic';
$category_skin_url = $board_skin_url.'/category/'.$category_skin;
$category_skin_path = $board_skin_path.'/category/'.$category_skin;

// 목록 스킨
$list_skin = isset($boset['list_skin']) && $boset['list_skin'] ? $boset['list_skin'] : 'list';
$list_skin_url = $board_skin_url.'/list/'.$list_skin;
$list_skin_path = $board_skin_path.'/list/'.$list_skin;
?>

<div id="bo_list_wrap">
	<?php
		// 분류 스킨
		$skin_file = $category_skin_path.'/category.skin.php';
		if (is_file($skin_file)) {
			include_once $skin_file;
		} else {
			echo '<div class="text-center px-3 py-5">'.str_replace(G5_PATH, '', $skin_file).' 스킨 파일이 없습니다.</div>'.PHP_EOL;
		}
	?>
	<form name="fboardlist" id="fboardlist" method="post">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="spt" value="<?php echo $spt ?>">
		<input type="hidden" name="sca" value="<?php echo $sca ?>">
		<input type="hidden" name="sst" value="<?php echo $sst ?>">
		<input type="hidden" name="sod" value="<?php echo $sod ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="sw" value="">

		<?php 
		// 목록 스킨
		$skin_file = $list_skin_path.'/list.skin.php';
		if (is_file($skin_file)) {
			include_once $skin_file;
		} else {
			echo '<div class="text-center px-3 py-5">'.str_replace(G5_PATH, '', $skin_file).' 스킨 파일이 없습니다.</div>'.PHP_EOL;
		}
		?>

		<ul class="pagination pagination-sm justify-content-center">
			<?php if($prev_part_href) { ?>
				<li class="page-item"><a class="page-link" href="<?php echo $prev_part_href;?>">Prev</a></li>
			<?php } ?>
			<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, get_pretty_url($bo_table, '', $qstr.'&amp;page=')) ?>
			<?php if($next_part_href) { ?>
				<li class="page-item"><a  class="page-link" href="<?php echo $next_part_href;?>">Next</a></li>
			<?php } ?>
		</ul>

	</form>
</div>
<?php
// 게시판 스킨 설정
if($is_admin)
	@include_once G5_THEME_PATH.'/app/board.setup.php';
?>
<?php if ($is_checkbox) { ?>
<noscript>
<p align="center">자바스크립트를 사용하지 않는 경우 별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>

<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(txt) {
	var f = document.fboardlist;
	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
			chk_count++;
	}

	if (!chk_count) {
		na_alert(txt + '할 게시물을 하나 이상 선택하세요.');
		return false;
	}

	if(txt == "선택복사") {
		select_copy("copy");
		return;
	}

	if(txt == "선택이동") {
		select_copy("move");
		return;
	}

	if(txt == "선택삭제") {
		let msg = '선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다.\n답변글이 있는 게시글을 선택하신 경우 답변글도 선택하셔야 게시글이 삭제됩니다.';
		na_confirm(msg, function() {
			var input = document.createElement('input');
 			input.type = 'hidden';
			input.name = 'btn_submit';
			input.value = '선택삭제';
			f.appendChild(input);
			f.removeAttribute("target");
			f.action = g5_bbs_url+"/board_list_update.php";
			f.submit();
		});
		return false;
	}

	return false;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
	var f = document.fboardlist;

	if (sw == "copy")
		str = "복사";
	else
		str = "이동";

	var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

	f.sw.value = sw;
	f.target = "move";
    f.action = g5_bbs_url+"/move.php";
	f.submit();
}
</script>
<?php } ?>
