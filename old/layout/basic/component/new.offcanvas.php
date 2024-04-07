<?php 
if (!defined('_GNUBOARD_')) { 
	include_once('./_common.php');

	$wset = array();

	// 최고관리자와 일반회원의 적용옵션이 다름
	if($is_admin != 'super') {
		$wset['wr_chadan'] = 1; // 차단회원글 제외
		$wset['wr_secret'] = 1; // 비밀글 제외
		$wset['wr_singo'] = 1; // 잠금글 제외
	}

	// 게시물
	$wset['rows'] = 7;
	$wset['bo_name'] = 2;
	$post = na_board_rows($wset);

	// 댓글
	$wset['wr_comment'] = 1;
	$comment = na_board_rows($wset);

	// 보드명, 분류명
	$is_bo_name = (isset($wset['bo_name']) && $wset['bo_name']) ? true : false;
	$bo_name = ($is_bo_name && (int)$wset['bo_name'] > 0) ? $wset['bo_name'] : 0;

?>
	<ul class="list-group list-group-flush border-bottom mb-4">
		<li class="list-group-item line-bottom fw-bold">
			<i class="bi bi-pencil"></i>
			새글
			<a href="<?php echo G5_BBS_URL ?>/new.php?view=w" class="float-end fw-normal">
				더보기
			</a>
		</li>

		<?php 
		for ($i=0; $i < count($post); $i++) { 

			$row = $post[$i];

			// 유뷰트 동영상(wr_9)
			$vinfo = na_check_youtube($row['wr_9']);

			// 이미지(wr_10)
			$img = na_check_img($row['wr_10']);
			$img = ($img) ? na_thumb($img, 60, 60) : na_member_photo($row['mb_id']);

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
			<li class="list-group-item">
				<div class="d-flex align-items-center gap-2">
					<div>
						<img src="<?php echo $img ?>" class="rounded-circle" style="max-width:60px;">
					</div>
					<div class="flex-grow-1">
						<a href="<?php echo $row['href'] ?>" class="small ellipsis-2 mb-1">
							<?php echo $wr_icon ?>
							<?php echo $row['subject'] ?>
						</a>
						<p class="small text-secondary clearfix mb-0">
							<i class="bi bi-person-circle"></i>
							<?php echo $row['name'] ?>

							<span class="float-end">
								<?php echo na_date($row['wr_datetime'], 'orangered', 'H:i', 'm.d', 'Y.m.d') ?>
							</span>
						</p>
					</div>
				</div>
			</li>
		<?php } ?>
		<?php if(!$i) { ?>
			<li class="list-group-item text-center py-5">
				게시물이 없습니다.
			</li>
		<?php } ?>
	</ul>

	<ul class="list-group list-group-flush border-bottom">
		<li class="list-group-item line-bottom fw-bold">
			<i class="bi bi-chat-dots"></i>
			새댓글
			<a href="<?php echo G5_BBS_URL ?>/new.php?view=c" class="float-end fw-normal">
				더보기
			</a>
		</li>

		<?php 
		for ($i=0; $i < count($comment); $i++) { 

			$row = $comment[$i];

			$img = na_member_photo($row['mb_id']);

			$wr_icon = '';
			if($row['icon_new'])
				$wr_icon .= '<span class="na-icon na-new"></span>'.PHP_EOL;
			
			if ($row['icon_secret'])
				$wr_icon .= '<span class="na-icon na-secret"></span>'.PHP_EOL;

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
			<li class="list-group-item">
				<div class="d-flex align-items-center gap-2">
					<div>
						<img src="<?php echo $img ?>" class="rounded-circle" style="max-width:60px;">
					</div>
					<div class="flex-grow-1">
						<p class="small text-secondary clearfix mb-1">
							<i class="bi bi-person-circle"></i>
							<?php echo $row['name'] ?>

							<span class="float-end">
								<?php echo na_date($row['wr_datetime'], 'orangered', 'H:i', 'm.d', 'Y.m.d') ?>
							</span>
						</p>

						<a href="<?php echo $row['href'] ?>" class="small ellipsis-2">
							<?php echo $wr_icon ?>
							<?php echo $row['subject'] ?>
						</a>
					</div>
				</div>
			</li>
		<?php } ?>
		<?php if(!$i) { ?>
			<li class="list-group-item text-center py-5">
				댓글이 없습니다.
			</li>
		<?php } ?>
	</ul>
<?php exit; } // end Ajax ?>
<style>
#newOffcanvas .offcanvas-title .btn-new { display:none; }
</style>
<div class="offcanvas offcanvas-end" tabindex="-1" id="newOffcanvas" aria-labelledby="newOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="newOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">
		<div id="new-list"></div>
	</div>
</div>

<script>
$(function () {
	const myNewOffcanvas = document.getElementById('newOffcanvas');
	myNewOffcanvas.addEventListener('show.bs.offcanvas', event => {
		$('#new-list').load('<?php echo LAYOUT_URL ?>/component/new.offcanvas.php');
	});
});
</script>
