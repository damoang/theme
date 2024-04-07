<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

// 게시물 추출
$wset['rows_notice'] = true; // 추출수에 공지글 포함
$list = na_board_rows($wset);
$list_cnt = count($list);

// 랭킹
$rank = na_rank_start($wset['rows'], $wset['page']);
$is_rank = (isset($wset['rank']) && $wset['rank']) ? $wset['rank'] : '';
$wset['rank_color'] = (isset($wset['rank_color']) && $wset['rank_color']) ? $wset['rank_color'] : 'text-bg-primary';

// 아이콘
$icon = isset($wset['icon']) ? '<i class="'.str_replace('+', ' ', $wset['icon']).'"></i>' : '';

// 보드명, 분류명
$is_bo_name = (isset($wset['bo_name']) && $wset['bo_name']) ? true : false;
$bo_name = ($is_bo_name && (int)$wset['bo_name'] > 0) ? $wset['bo_name'] : 0;

// 공지글 강조
$wr_notice = (isset($wset['is_notice']) && $wset['is_notice']) ? ' bg-body-tertiary fw-bold' : '';

?>

<ul class="list-group list-group-flush border-bottom">
<?php 
for ($i=0; $i < $list_cnt; $i++) { 

	$row = $list[$i];

	// 유뷰트 동영상(wr_9)
	$vinfo = na_check_youtube($row['wr_9']);

	// 이미지(wr_10)
	$img = na_check_img($row['wr_10']);

	// 아이콘 체크
	if ($is_rank && !$row['is_notice']) {
		$wr_head = '<span class="badge '.$is_rank.' '.$wset['rank_color'].' fw-normal">'.$rank.'</span>';
		$rank++;
	} else {
		$wr_head = $icon;
	}

	$wr_icon = '';
	if($row['icon_new'])
		$wr_icon .= '<span class="na-icon na-new"></span>'.PHP_EOL;
	
	if ($row['icon_secret'])
		$wr_icon .= '<span class="na-icon na-secret"></span>'.PHP_EOL;

	if($vinfo['vid']) {
		$wr_icon .= '<span class="na-icon na-video"></span>'.PHP_EOL;
	} else if($img) {
		$wr_icon .= '<span class="na-icon na-image"></span>'.PHP_EOL;
	}

	// 이미지 미리보기
	$img_popover = (!G5_IS_MOBILE && $img) ? ' data-bs-toggle="popover-img" data-img="'.na_thumb($img, 400, 225).'"' : '';

	// 보드명, 분류명
	if($is_bo_name) {
		$ca_name = '';
		if(isset($row['bo_subject']) && $row['bo_subject']) {
			$ca_name = ($bo_name) ? cut_str($row['bo_subject'], $bo_name, '') : $row['bo_subject'];
		} else if($row['ca_name']) {
			$ca_name = ($bo_name) ? cut_str($row['ca_name'], $bo_name, '') : $row['ca_name'];
		}

		if($ca_name) {
			$row['subject'] = '['.$ca_name.'] '.$row['subject'];
		}
	}
?>
	<li class="list-group-item<?php echo ($row['is_notice']) ? $wr_notice : ''; ?>">
		<div class="d-flex align-items-center gap-1">
			<div class="text-truncate">
				<a href="<?php echo $row['href'] ?>"<?php echo $img_popover ?>>
					<?php echo $wr_head ?>
					<?php echo $row['subject'] ?>
				</a>
			</div>
			<?php if($wr_icon) { ?>
				<div class="text-nowrap">
					<?php echo $wr_icon ?>
				</div>
			<?php } ?>
			<?php if($row['wr_comment']) { ?>
				<div class="count-plus orangered ms-1">
					<span class="visually-hidden">댓글</span>
					<?php echo $row['wr_comment'] ?>
				</div>
			<?php } ?>
			<div class="ms-auto ps-1 small text-body-tertiary">
				<?php echo na_date($row['wr_datetime'], 'orangered', 'H:i', 'm.d', 'm.d') ?>
			</div>
		</div>
	</li>
<?php } ?>
<?php if(!$list_cnt) { ?>
	<li class="list-group-item text-center py-5">
		게시물이 없습니다.
	</li>
<?php } ?>
</ul>

<?php if($setup_href) { ?>
	<div class="btn-wset py-2">
		<button onclick="naClipView('<?php echo $setup_href ?>');" class="btn btn-basic btn-sm">
			<i class="bi bi-gear"></i>
			위젯설정
		</button>
	</div>
<?php } ?>