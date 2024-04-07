<?php
include_once('./_common.php');

$g5['title'] = '동영상 코드';
include_once(G5_PATH.'/head.sub.php');

include_once(G5_THEME_PATH.'/app/clipboard.php');
?>

<form class="pe-1">
	<div class="input-group mb-3">
		<div class="form-floating">
			<input type="text" id="txtCode" class="form-control nofocus" placeholder="https://...">
			<label for="txtCode">동영상 공유주소 입력 : https://...</label>
		</div>
		<button class="btn btn-primary clip-txt nofocus" type="button">코드 생성</button>
	</div>

	<div class="mb-2">
		<i class="bi bi-camera-video"></i>
		공유주소 등록이 가능한 사이트 목록
	</div>

	<div class="border rounded p-3">
		<ul class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2 mb-0 list-unstyled">
			<li class="col"><a href="https://youtu.be" target="_blank">youtu.be</a></li>
			<li class="col"><a href="https://vimeo.com" target="_blank">vimeo.com</a></li>
			<li class="col"><a href="https://ted.com" target="_blank">ted.com</a></li>
			<li class="col"><a href="https://tv.kakao.com" target="_blank">tv.kakao.com</a></li>
			<li class="col"><a href="https://pandora.tv" target="_blank">pandora.tv</a></li>
			<?php if($nariya['fb_key']) { ?>
			<li class="col"><a href="https://facebook.com" target="_blank">facebook.com</a></li>
			<?php } ?>
			<li class="col"><a href="https://tv.naver.com" target="_blank">tv.naver.com</a></li>
			<li class="col"><a href="https://slideshare.net" target="_blank">slideshare.net</a></li>
			<li class="col"><a href="https://sendvid.com" target="_blank">sendvid.com</a></li>
			<li class="col"><a href="https://vine.co" target="_blank">vine.co</a></li>
			<li class="col"><a href="https://yinyuetai.com" target="_blank">yinyuetai.com</a></li>
			<li class="col"><a href="https://vlive.tv" target="_blank">vlive.tv</a></li>
			<li class="col"><a href="https://srook.net" target="_blank">srook.net</a></li>
			<li class="col"><a href="https://twitch.tv" target="_blank">twitch.tv</a></li>
			<li class="col"><a href="https://openload.co" target="_blank">openload.co</a></li>
			<li class="col"><a href="https://soundcloud.com" target="_blank">soundcloud.com</a></li>
			<li>mp4 동영상파일 URL</li>
		</ul>
	</div>
</form>

<script>
$(function() {
	$('.clip-txt').click(function() {
		var txt = $('#txtCode').val();

		if(!txt) {
			na_alert('동영상의 공유주소(url)을 입력해 주세요.', function() {
				$('#txtCode').focus();
			});
			return false;
		}

		var clip = "{video: " + txt + " }";

		<?php if($is_clip) { ?>
			$("#txtClip").val(clip);
			$('#clipModal').modal('show');
		<?php } else { ?>
			parent.document.getElementById("wr_content").value += clip;
			window.parent.naClipClose();
		<?php } ?>
	});
});
</script>

<?php 
include_once(G5_PATH.'/tail.sub.php');