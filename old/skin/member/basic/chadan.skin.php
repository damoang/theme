<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<form id="fchadan" name="fchadan" method="post" action="./chadan.php" onsubmit="return fchadan_submit(this);">
<input type="hidden" name="unlock" value="1">

<ul class="list-group list-group-flush mb-4">
	<li class="list-group-item line-bottom">
		차단 회원 <b><?php echo number_format((int)$total_count) ?></b>명
	</li>
	<li class="list-group-item small bg-body-tertiary">
		<i class="bi bi-info-circle"></i>
		차단 회원은 최대 <?php echo NA_MAX_CHADNA ?>명까지 등록이 가능합니다.
	</li>
    <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li class="list-group-item">
			<div class="d-flex align-items-center">
				<div class="pe-2">
					<img src="<?php echo na_member_photo($list[$i]['mb_id']); ?>" class="rounded-circle" style="max-width:40px;">
				</div>
				<div class="flex-grow-1">
					<?php echo get_text($list[$i]['mb_nick']) ?>
				</div>
				<div class="ps-3">
					<div class="form-check form-switch m-0">
						<input class="form-check-input" type="checkbox" role="switch" name="chk_mb_id[]" value="<?php echo $list[$i]['mb_id'] ?>" id="chk_mb_id_<?php echo $i ?>">
						<label class="form-check-label visually-hidden" for="chk_mb_id_<?php echo $i ?>"><?php echo $i ?>번</label>
					</div>
				</div>
			</div>
        </li>
	<?php }  ?>
	<?php if ($i == 0) { ?>
		<li class="list-group-item text-center py-5">
			차단한 회원이 없습니다.
		</li>
	<?php } ?>
	<li class="list-group-item text-center pt-3">
		<button type="button" class="btn btn-basic me-2" onclick="window.close();">
			창닫기
		</button>
		<button type="submit" class="btn btn-primary">차단 해제하기</button>	
	</li>
</ul>
</form>
<script>
function fchadan_submit(f) {

	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_mb_id[]" && f.elements[i].checked)
		chk_count++;
	}

	if (!chk_count) {
		na_alert('차단 해제할 회원을 한명 이상 선택하세요.');
		return false;
	}

    return true;
}
</script>