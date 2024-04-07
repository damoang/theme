<?php 
if (!defined('_GNUBOARD_')) { 
	include_once('./_common.php');

	if($is_guest)
		die('<i class="bi bi-person-circle"></i> 로그인한 회원만 가능합니다.');

	$member['as_noti'] = isset($member['as_noti']) ? $member['as_noti'] : 0;
	$member['mb_memo_cnt'] = isset($member['mb_memo_cnt']) ? $member['mb_memo_cnt'] : 0;

	$noti_cnt = $member['as_noti'] + $member['mb_memo_cnt'];

	// 카운팅만 할 경우
	if(isset($_REQUEST['cnt']) && (int)$_REQUEST['cnt']) {
		echo '{ "count": "'.$noti_cnt.'" }';
		exit;
	}

	// 안 읽은 알림 : 목록수 20개
	list($total_noti, $noti) = na_noti_list(20, '', 0, 'n', false);

	$noti = (is_array($noti)) ? $noti : array();
?>
	<ul class="list-group list-group-flush border-bottom">
		<li class="list-group-item line-bottom fw-bold">
			<i class="bi bi-bell"></i>
			알림 <span class="orangered"><?php echo number_format($noti_cnt) ?></span> 개

			<a href="<?php echo G5_BBS_URL ?>/noti.php" class="float-end fw-normal small mt-1">
				더보기
			</a>		
		</li>
		<?php if($member['mb_memo_cnt']) { ?>
			<li class="list-group-item">
				<a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo">
					<i class="bi bi-envelope-exclamation"></i>
					미확인 쪽지가 <span class="orangered"><?php echo number_format((int)$member['mb_memo_cnt']) ?></span>통 있습니다.
				</a>
			</li>
		<?php } ?>
		<?php for($i=0; $i < count($noti); $i++) { ?>
			<li class="list-group-item">
				<div class="d-flex align-items-center">
					<div class="pe-2">
						<img src="<?php echo na_member_photo($noti[$i]['mb_id']) ?>" class="rounded-circle" style="max-width:60px;">
					</div>
					<div class="flex-grow-1 text-truncate">
						<a href="<?php echo $noti[$i]['href'] ?>">
							<?php echo $noti[$i]['subject'] ?>
						</a>
						<div class="form-text text-wrap">
							<?php echo $noti[$i]['wtime'] ?>
							<?php echo $noti[$i]['msg'] ?> 
						</div>
					</div>
				</div>
			</li>
		<?php } ?>
		<?php if(!$i) { ?>
			<li class="list-group-item text-center py-5">
				알림이 없습니다.
			</li>
		<?php } ?>
	</ul>
<?php exit; } // end Ajax ?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="notiOffcanvas" aria-labelledby="notiOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="notiOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">
		<div id="noti-list"></div>
	</div>
</div>

<div class="noti-toast toast fade hide align-items-center fixed-bottom m-3" aria-live="polite" aria-atomic="true" data-bs-delay="10000" role="alert">
	<div class="d-flex align-items-center">
		<div class="toast-body">
			<div class="spinner-grow spinner-grow-sm text-primary" role="status">
				  <span class="visually-hidden">Check it!</span>
			</div>
			<a href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#notiOffcanvas" aria-controls="notiOffcanvas">
				<strong class="noti-count"></strong>개의 알림이 도착했습니다.
			</a>
		</div>
		<button type="button" class="btn-close me-2 m-auto nofocus" data-bs-dismiss="toast" aria-label="Close"></button>
	</div>
</div>

<script>
function noti_count() {
	$.get('<?php echo LAYOUT_URL ?>/component/noti.offcanvas.php?cnt=1', function(data) {
		if (data.count > 0) {
			$('.noti-count').text(number_format(data.count));
			$('.noti-toast').removeClass('hide').addClass('show');
		} else {
			$('.noti-toast').removeClass('show').addClass('hide');
		}
	}, "json");
	return false;
}

$(function () {
	const myNotiOffcanvas = document.getElementById('notiOffcanvas');
	myNotiOffcanvas.addEventListener('show.bs.offcanvas', event => {
		$('#noti-list').load('<?php echo LAYOUT_URL ?>/component/noti.offcanvas.php');
		$('.noti-toast').removeClass('show').addClass('hide');
	});

	noti_count();

	<?php if(isset($nariya['noti_check']) && (int)$nariya['noti_check'] > 0) { // 알림 자동 체크?>
	setInterval(function() {
		noti_count();
	}, <?php echo (int)$nariya['noti_check'] ?> * 1000);
	<?php } ?>
});
</script>
