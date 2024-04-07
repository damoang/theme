<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$category_skin_url.'/category.css">', 0);

?>

<div class="d-flex gap-2 align-items-center px-3 mb-2">
	<div class="order-0 d-none d-sm-block">
		<?php 
			if ($stx)
				$htxt = '검색';
			else if ($sca)
				$htxt = $sca;
			else
				$htxt = '전체';

			echo $htxt;
		?>
		<b><?php echo number_format((int)$total_count) ?></b> / <?php echo $page ?> 페이지
	</div>
	<div class="ms-auto order-1 pe-1">
		<a href="#boardSearch" data-bs-toggle="collapse" data-bs-target="#boardSearch" aria-expanded="false" aria-controls="boardSearch" class="text-body-tertiary">
			<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="검색">
				<i class="bi bi-search"></i>
				<span class="visually-hidden">검색</span>
			</span>
		</a>
	</div>
	<?php if ($is_admin) {  ?>
	<div class="order-2 pe-1">
		<a href="<?php echo G5_THEME_URL ?>/app/search.video.php?bo_table=<?php echo $bo_table ?>" class="win_point text-body-tertiary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="동영상 검색">
			<i class="bi bi-camera-reels"></i>
			<span class="visually-hidden">동영상 검색</span>
		</a>
	</div>
	<?php } ?>
	<?php if ($is_checkbox || $admin_href || IS_DEMO) {  ?>
		<div class="order-3 dropdown pe-1">
			<a href="#boardAdmin" data-bs-toggle="dropdown" aria-expanded="false" class="text-body-tertiary">
				<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="관리자">
					<i class="bi bi-gear-fill"></i>
					<span class="visually-hidden">관리자</span>
				</span>
			</a>
			<ul class="dropdown-menu dropdown-menu-end">
				<?php if ($admin_href) { ?>
					<li>
						<a href="<?php echo $admin_href ?>" class="dropdown-item">
							<i class="bi bi-gear"></i>
							보드 설정
						</a>
					</li>
				<?php } ?>
				<?php if(IS_DEMO || $admin_href) { ?>
					<li>
						<a href="#naClip" class="dropdown-item" onclick="naClipView('<?php echo NA_URL ?>/board.skin.php?bo_table=<?php echo $bo_table;?>');" data-bs-toggle="offcanvas" data-bs-target="#naClip" aria-controls="naClip">
							<i class="bi bi-magic"></i>
							스킨 설정
						</a>
					</li>
				<?php } ?>
				<?php if ($is_checkbox) { ?>
					<li><hr class="dropdown-divider"></li>
					<li>
						<label class="dropdown-item" for="allCheck">
							<i class="bi bi-check2-square"></i>
							전체 선택						
							<input class="visually-hidden" type="checkbox" id="allCheck" onclick="if (this.checked) all_checked(true); else all_checked(false);">
						</label>
					</li>
					<li><hr class="dropdown-divider"></li>
					<li>
						<button class="dropdown-item" type="button" onclick="fboardlist_submit('선택삭제');">
							<i class="bi bi-trash"></i>
							선택 삭제
						</button>
					<li>
					<li>
						<button class="dropdown-item" type="button" onclick="fboardlist_submit('선택복사');">
							<i class="bi bi-clipboard-check"></i>
							선택 복사
						</button>
					<li>
					<li>
						<button class="dropdown-item" type="button" onclick="fboardlist_submit('선택이동');">
							<i class="bi bi-arrows-move"></i>
							선택 이동
						</button>
					<li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	<?php if ($rss_href) { ?>
		<div class="order-4 pe-1">
			<a href="<?php echo $rss_href ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="RSS" class="text-body-tertiary">
				<i class="bi bi-rss"></i>
				<span class="visually-hidden">RSS</span>
			</a>
		</div>
	<?php } ?>
	<div class="order-first order-sm-5">
		<?php $sst_tag = na_query(subject_sort_link('', $qstr2, 1)); ?>
		<form>
			<select class="form-select form-select-sm" name="sst" onchange="location.href='<?php echo str_replace('&sst=', '', $sst_tag['href']);?>&sst='+this.value;">
				<option value="">최신순</option>
				<option value="wr_datetime"<?php echo get_selected($sst, 'wr_datetime');?>>날짜순</option>
				<option value="wr_hit"<?php echo get_selected($sst, 'wr_hit');?>>조회순</option>
				<?php if($is_good) { ?>
					<option value="wr_good"<?php echo get_selected($sst, 'wr_good');?>>추천순</option>
				<?php } ?>
				<?php if($is_nogood) { ?>
					<option value="wr_nogood"<?php echo get_selected($sst, 'wr_nogood');?>>비추천순</option>
				<?php } ?>
			</select>
		</form>
	</div>
	<?php if ($write_href && !$wr_id) { ?>
		<div class="order-last">
			<a href="<?php echo $write_href ?>" class="btn btn-primary btn-sm">
				<i class="bi bi-pencil"></i>
				쓰기
			</a>
		</div>
	<?php } ?>
</div>

<div class="collapse<?php echo ($stx) ? ' show' : '';?>" id="boardSearch">
	<div class="px-3 py-2 border-top">
		<form id="fsearch" name="fsearch" method="get">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<div class="row g-2">
				<div class="col-6 col-md-3 col-lg-2">
					<label for="bo_sfl" class="visually-hidden">검색대상</label>
					<select id="bo_sfl" name="sfl" class="form-select form-select-sm">
						<?php echo get_board_sfl_select_options($sfl); ?>
					</select>
				</div>
				<div class="col-6 col-md-3 col-lg-2">
					<label for="bo_sop" class="visually-hidden">검색조건</label>
					<select id="bo_sop" name="sop" class="form-select form-select-sm">
						<option value="and"<?php echo get_selected($sop, "and") ?>>그리고</option>
						<option value="or"<?php echo get_selected($sop, "or") ?>>또는</option>
					</select>	
				</div>
				<div class="col-12 col-md-6 col-lg-8">
					<label for="bo_stx" class="visually-hidden">검색어 필수</label>
					<div class="input-group input-group-sm">
						<input type="text" class="form-control" name="stx" id="bo_stx" value="<?php echo stripslashes($stx) ?>" required placeholder="검색어 입력">
						<a href="<?php echo get_pretty_url($bo_table) ?>" class="btn btn-basic" title="초기화">
							<i class="bi bi-arrow-clockwise"></i>
							<span class="visually-hidden">초기화</span>
						</a>
						<button class="btn btn-primary" type="submit" id="fsearch_submit" title="검색">
							<i class="bi bi-search"></i>
							<span class="d-none d-sm-inline-block">검색</span>
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?php
// 분류
if ($is_category) {

	// 분류별 총 게시물수
	$catecnt = na_cate_cnt($bo_table, $board);

	// 분류별 새 게시물수
	$catenew = na_cate_new($bo_table, $board);

	$category_option = '';
	$ca_cnt = (isset($categories) && is_array($categories)) ? count($categories) : 0;
	for ($i=0; $i < $ca_cnt; $i++) {
		$category = trim($categories[$i]);
		if ($category=='')
			continue;

		$ca_active = $ca_current = '';

		// 현재 선택된 분류라면
		if($category==$sca) {
			$ca_active = ' active fw-bold" aria-current="page';
			$ca_current = '<span class="visually-hidden">현재 분류</span>';
		}
		$category_option .= '<li class="col nav-item"><a class="nav-link text-truncate py-0'.$ca_active.'" href="'.(get_pretty_url($bo_table,'','sca='.urlencode($category))).'">'.PHP_EOL;
		$cakey = md5($category);
		$cacnt = isset($catecnt[$cakey]) ? (int)$catecnt[$cakey] : 0;
		$canew = isset($catenew[$cakey]) ? (int)$catenew[$cakey] : 0;
		$canew = ($canew > 0) ? '<span class="orangered">+'.$canew.'</span>' : '';
		$category_option .= $ca_current.$category.'('.$cacnt.$canew.')</a></li>'.PHP_EOL;
	}

?>
	<nav id="bo_category" class="border-top py-2">
		<ul class="nav row row-cols-3 row-cols-sm-4 row-cols-md-5 row-cols-lg-6 g-1 small">
			<li class="nav-item col">
				<a class="nav-link text-truncate py-0<?php echo $sca ? '' : ' active fw-bold" aria-current="page'; ?>" href="<?php echo get_pretty_url($bo_table) ?>">
					전체(<?php echo isset($catecnt['all']) ? $catecnt['all'] : 0; ?><?php echo isset($catecnt['all']) && (int)$catenew['all'] > 0 ? '<span class="orangered">+'.$catenew['all'].'</span>' : '';?>)
				</a>
			</li>
			<?php echo $category_option ?>
		</ul>
	</nav>
<?php } ?>
