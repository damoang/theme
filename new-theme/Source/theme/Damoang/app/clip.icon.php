<?php
include_once('./_common.php');

$g5['title'] = '아이콘';
include_once(G5_PATH.'/head.sub.php');

// 아이콘 타입
$type = (isset($_REQUEST['type']) && $_REQUEST['type']) ? na_fid($_REQUEST['type']) : 'bi';

include_once(G5_THEME_PATH.'/app/clipboard.php');

$qstr_clip = ($is_clip) ? '&amp;clip=1' : '';
?>

<div class="sticky-top pb-3 bg-body">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="./clip.icon.php?type=bi<?php echo $qstr_clip; ?>" class="nav-link<?php echo ($type == 'bi') ? ' active" aria-current="page' : ''; ?>">BI</a>
		</li>
		<li class="nav-item">
			<a href="./clip.icon.php?type=fa<?php echo $qstr_clip; ?>" class="nav-link<?php echo ($type == 'fa') ? ' active" aria-current="page' : ''; ?>">FA</a>
		</li>
	</ul>
</div>

<div class="pe-3">
	<?php 
	if($type == 'bi') { 
		include_once(NA_PATH.'/icon.bi.php');
	?>
		<div class="row g-3">
			<?php 
			// 부트스트랩 아이콘
			for($i=0; $i < count($bis); $i++) { 
				if (!$bis[$i])
					continue;
			?>
				<div class="col-4 col-sm-3 col-md-2 col-lg-1">
					<button type="button" class="btn btn-basic btn-lg w-100 py-3 fs-2" onclick="clip_insert('<?php echo $bis[$i]; ?>');">
						<i class="bi <?php echo $bis[$i] ?>"></i>
					</button>
				</div>
			<?php } ?>
		</div>
	<?php } ?>

	<?php 
	if($type == 'fa') { 
		include_once(NA_PATH.'/icon.fa.php');
	?>
		<div class="row g-3">
			<?php 
			// 폰트어썸 아이콘
			$fkeys = array('web','access','hand','trans','gender','file','spin','form','pay','chart','cur','edit','direct','video','brand','medical');

			for($i=0; $i < count($fkeys); $i++) { 

				$key = $fkeys[$i];

				if (!$key)
					continue;

				for($j=0; $j < count($fas[$key]); $j++) { 
					if (!$fas[$key][$j])
						continue;
			?>
				<div class="col-4 col-sm-3 col-md-2 col-lg-1">
					<button type="button" class="btn btn-lg btn-basic w-100 py-3" onclick="clip_insert('<?php echo $fas[$key][$j]; ?>');">
						<i class="fa <?php echo $fas[$key][$j] ?> fs-2"></i>
					</button>
				</div>
			<?php	
				}
			} ?>
		</div>
	<?php } ?>
</div>

<script>
function clip_insert(txt){
	var clip = "{icon:" + txt + "}";
	<?php if($is_clip) { ?>
		$("#txtClip").val(clip);
		$('#clipModal').modal('show');
	<?php } else { ?>
		parent.document.getElementById("wr_content").value += clip;
		window.parent.naClipClose();
	<?php } ?>
}
</script>

<?php 
include_once(G5_PATH.'/tail.sub.php');