<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);
?>

<form name="fsearch" onsubmit="return fsearch_submit(this);" method="get" class="px-3 mb-2 mx-auto">
<input type="hidden" name="srows" value="<?php echo $srows ?>">
<div class="row g-2">
	<div class="col-6 col-md-3">
		<label for="sfl" class="visually-hidden">게시판그룹</label>
		<?php echo str_replace('id="gr_id"', 'id="gr_id" class="form-select"', $group_select) ?>
		<script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>
	</div>
	<div class="col-6 col-md-3">
		<label for="sfl" class="visually-hidden">검색조건</label>
		<select name="sfl" id="sfl" class="form-select">
			<option value="wr_subject||wr_content"<?php echo get_selected($sfl, "wr_subject||wr_content") ?>>제목+내용</option>
			<option value="wr_subject"<?php echo get_selected($sfl, "wr_subject") ?>>제목</option>
			<option value="wr_content"<?php echo get_selected($sfl, "wr_content") ?>>내용</option>
			<option value="mb_id"<?php echo get_selected($sfl, "mb_id") ?>>회원아이디</option>
			<option value="wr_name"<?php echo get_selected($sfl, "wr_name") ?>>이름</option>
		</select>
	</div>
	<div class="col-12 col-md-6">
		<label for="new_mb_id" class="visually-hidden">검색어<strong class="visually-hidden"> 필수</strong></label>
		<div class="input-group">
			<div class="input-group-text">
				<div class="form-check form-check-inline me-0">
					<input class="form-check-input" type="checkbox" id="sop" name="sop" value="or"<?php echo ($sop == "or") ? " checked" : ""; ?>>
					<label class="form-check-label" for="sop">또는</label>
				</div>
			</div>
			<input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" class="form-control" placeholder="검색어 입력">
			<button type="submit" class="btn btn-primary" title="검색하기">
				<i class="bi bi-search"></i>
				<span class="visually-hidden">검색하기</span>
			</button>
		</div>
	</div>
</div>

<script>
function fsearch_submit(f) {
	var stx = f.stx.value.trim();
	if (stx.length < 2) {
		na_alert('검색어는 두글자 이상 입력하십시오.', function() {
			f.stx.select();
			f.stx.focus();
		});
		return false;
	}

	// 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
	var cnt = 0;
	for (var i = 0; i < stx.length; i++) {
		if (stx.charAt(i) == ' ')
			cnt++;
	}

	if (cnt > 1) {
		na_alert('빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.', function() {
			f.stx.select();
			f.stx.focus();
		});
		return false;
	}

	f.stx.value = stx;
	f.action = "";
	return true;
}
</script>
</form>

<style>
#fsearchlist .profile_img {
	display:none; }
</style>
<ul id="fsearchlist" class="list-group list-group-flush mb-4">
    <?php
    if ($stx) {
        if ($board_count) {
     ?>
		<li class="list-group-item">
			게시판 <?php echo $board_count ?> 개
			<i class="bi bi-dot"></i>
			게시물 <?php echo number_format($total_count) ?> 개
			<i class="bi bi-dot"></i>
			<?php echo number_format($page) ?>/<?php echo number_format($total_page) ?> 페이지 열람 중
		</li>
		<li class="list-group-item line-top">
			<ul class="nav row row-cols-3 row-cols-sm-4 row-cols-md-5 row-cols-lg-6 g-1 small">
				<li class="col nav-item">
					<a class="nav-link text-truncate p-0<?php echo $sch_all ? ' active fw-bold" aria-current="page' : ''; ?>" href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>">
						전체
					</a>
				</li>
		        <?php 
 					$str_board_list = str_replace('<li>', '<li class="col nav-item">', $str_board_list); 
 					$str_board_list = str_replace('" ><strong>', '" class="nav-link text-truncate p-0"><strong>', $str_board_list);
 					$str_board_list = str_replace('sch_on', '"nav-link text-truncate p-0 active fw-bold" aria-current="page"', $str_board_list);
 					$str_board_list = str_replace('<span class="cnt_cmt">', '(', $str_board_list);
 					$str_board_list = str_replace('</span>', ')', $str_board_list);
 					$str_board_list = str_replace('<strong>', '', $str_board_list);
 					$str_board_list = str_replace('</strong>', '', $str_board_list);
					echo $str_board_list;
				?>
			</ul>
		</li>
    <?php
        } else {
     ?>
		<li class="list-group-item line-top text-center py-5">
			검색된 자료가 하나도 없습니다.
		</li>
    <?php } }  ?>

	<?php for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) { ?>
		<li class="list-group-item bg-body-tertiary">
	        <h3 class="p-0 m-0 fs-6">
				<a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>">
					<?php echo $bo_subject[$idx] ?> 내 결과
					<span class="float-end fs-6" title="더보기">
						<i class="bi bi-three-dots"></i>
						<span class="visually-hidden">더보기</span>
					</span>
				</a>
			</h3>
		</li>
        <?php
        for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {

			//이미지
			$sch_img = na_check_img($list[$idx][$i]['wr_10']);
			$sch_img =($sch_img) ? na_thumb($sch_img, 60, 60) : na_member_photo($list[$idx][$i]['mb_id']);

			$comment_def = $comment_href = '';
			if ($list[$idx][$i]['wr_is_comment']) {
                $comment_def = '[댓글] ';
                $comment_href = '#c_'.$list[$idx][$i]['wr_id'];
            }
		?>
            <li class="list-group-item">
				<div class="d-flex align-items-center">
					<div class="pe-2">
						<img src="<?php echo $sch_img ?>" class="rounded-circle" style="max-width:60px;">
					</div>
					<div class="flex-grow-1">
						<a href="<?php echo $list[$idx][$i]['href'].$comment_href ?>" target="_blank" class="float-end text-body-tertiary" title="새창">
							<i class="bi bi-box-arrow-up-right"></i>
							<span class="visually-hidden">새창</span>
						</a>

						<a href="<?php echo $list[$idx][$i]['href'].$comment_href ?>">
							<?php echo $comment_def ?>
							<?php echo str_replace('sch_word', 'badge bg-primary rounded-pill', $list[$idx][$i]['subject']) ?>
						</a>

						<div class="form-text">
							<?php echo str_replace('sch_word', 'badge bg-primary rounded-pill', $list[$idx][$i]['content']) ?>
						</div>

						<div class="form-text clearfix">
							<span class="visually-hidden">등록자</span>
							<?php echo na_name_photo($list[$idx][$i]['mb_id'], $list[$idx][$i]['name']); ?>
							<div class="float-end">
								<span class="visually-hidden">등록일</span>
								<?php echo na_date($list[$idx][$i]['wr_datetime'], 'orangered', 'H:i', 'm.d', 'Y.m.d') ?>
							</div>
						</div>
					</div>
				</div>
            </li>
        <?php }  ?>
    <?php }	//end for?>
	<?php if(isset($search_query)) { ?>
		<li class="list-group-item">
			<ul class="pagination pagination-sm justify-content-center">
				<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$search_query.'&amp;gr_id='.$gr_id.'&amp;srows='.$srows.'&amp;onetable='.$onetable.'&amp;page='); ?>
			</ul>
		</li>
	<?php } ?>
</ul>
