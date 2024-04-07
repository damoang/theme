<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<ul class="list-group list-group-flush pt-3 mb-4">
	<li class="list-group-item">
		<div class="d-flex justify-content-center align-items-center mb-2">
			<div class="pe-2">
				<img src="<?php echo na_member_photo($mb['mb_id']); ?>" class="rounded-circle" style="max-width:60px;">
			</div>
			<div>
				<h3 class="mb-1 pb-0 fs-5">
					<strong style="letter-spacing:-1px;"><?php echo get_text($mb['mb_nick']) ?></strong>
				</h3>
				<div class="small">
					<?php echo na_grade($mb['mb_level']); ?>
				</div>
			</div>
		</div>
		<?php 
			$mb['as_max'] = (isset($mb['as_max']) && $mb['as_max'] > 0) ? $mb['as_max'] : 1;
			$per = (int)(($mb['as_exp'] / $mb['as_max']) * 100);
		?>
		<div class="d-flex justify-content-between mb-1 small">
			<div>Lv.<?php echo $mb['as_level'] ?></div>
			<div>
				Exp <?php echo number_format($mb['as_exp']) ?>
			</div>
		</div>

		<div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Next <?php echo number_format($mb['as_max'] - $mb['as_exp']) ?>">
			<div class="progress" role="progressbar" aria-label="Exp" aria-valuenow="<?php echo $per ?>" aria-valuemin="0" aria-valuemax="100">
				<div class="progress-bar progress-bar-striped progress-bar-animated small" style="width: <?php echo $per ?>%"><?php echo $per ?>%</div>
			</div>
		</div>	
	</li>
	<li class="list-group-item small">
		<i class="bi bi-database"></i>
		<?php echo number_format($mb['mb_point']) ?> 포인트 보유
		<?php if ($member['mb_level'] >= $mb['mb_level']) { ?>
			<div class="pt-1">
				<i class="bi bi-box-arrow-in-right"></i>
				<?php echo substr($mb['mb_datetime'],0,10) ?> 가입 (<?php echo number_format($mb_reg_after);?>일)
			</div>
			<div class="pt-1">
				<i class="bi bi-person"></i>
				<?php echo $mb['mb_today_login'] ?> 최종 접속
			</div>
		<?php } ?>
		<?php if ($mb_homepage) {  ?>
			<div class="pt-1">
				<a href="<?php echo $mb_homepage ?>" target="_blank">
					<i class="bi bi-house"></i>
					<?php echo $mb_homepage ?>
				</a>
			</div>
		<?php } ?>
	</li>
	<?php if(trim($mb['mb_profile'])) { ?>
		<li class="list-group-item">
			<h4 class="visually-hidden">인사말</h4>
			<?php echo $mb_profile ?>		
		</li>
	<?php } ?>
	<li class="list-group-item text-center pb-4">
		<button type="button" onclick="window.close();" class="btn btn-basic btn-sm">
			<i class="bi bi-x-lg"></i>
			창닫기
		</button>
	</li>
</ul>

<script>
	window.resizeTo(320, 500);
</script>