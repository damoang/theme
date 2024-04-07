<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<style>
	body { padding:0; margin:0; }
	.myphoto img { width:<?php echo $photo_width ?>px; height:<?php echo $photo_height ?>px; }
</style>

<section class="px-3 py-5">
	<form name="fphotoform" class="form" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="mode" value="u">
		
		<h3 class="text-center">My Photo</h3>
		
		<p class="myphoto my-4 text-center">
			<img src="<?php echo na_member_photo($member['mb_id']) ?>?nocache=<?php echo time() ?>" class="rounded-circle">
		</p>
		<p class="my-3">
			회원사진은 이미지 중 GIF/JPG/PNG 파일만 가능하며, 등록시 <?php echo $photo_width ?>x<?php echo $photo_height ?> 사이즈로 자동으로 조절됩니다.
		</p>

		<div class="input-group mb-3">
			<label class="input-group-text" for="MbIcon2">사진</label>
			<input type="file" name="mb_icon2" class="form-control" id="MbIcon2">
			<?php if ($is_photo) { ?>
				<span class="input-group-text">
					<span class="form-check form-check-inline me-0">
						<input class="form-check-input" type="checkbox" name="del_mb_icon2" value="1" id="delMbIcon">
						<label class="form-check-label" for="delMbIcon">삭제</label>
					</span>
				</span>
			<?php } ?>
		</div>

		<div class="text-center">
			<button type="button" class="btn btn-basic" onclick="window.close();">닫기</button>
			<button type="submit" class="btn btn-primary">확인</button>
		</div>		
	</form>
</section>
