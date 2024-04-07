<?php
include_once('./_common.php');

$g5['title'] = '코드 등록';
include_once(G5_PATH.'/head.sub.php');

$input_style = 'textarea';
include_once(G5_THEME_PATH.'/app/clipboard.php');
?>

<form>
	<div id="codeType" class="input-group mb-3">
		<div class="form-floating">
			<input type="text" id="txtCode" class="form-control nofocus" placeholder="php, html 등 코드 종류 입력">
			<label for="txtCode">php, html 등 코드 종류 입력</label>
		</div>
		<button class="btn btn-primary clip-txt nofocus" type="button">코드 생성</button>
	</div>
	<textarea id="codeZone" name="codeZone" class="form-control nofocus"></textarea>
</form>

<script>
function mapHeight() {
	let height = $('#naClipContent', parent.document).height() - $('#codeType').height() - 50;
	document.getElementById('codeZone').style.height = height + "px";
}

mapHeight();

$(window).on('resize', function () {
	mapHeight();
});

$(function() {
	$('.clip-txt').click(function() {
		var txt = $('#txtCode').val();
		var code = $('#codeZone').val();

		if(!txt) {
			na_alert('코드 종류를 입력해 주세요.', function() {
				$('#txtCode').focus();
			});
			return false;
		}

		if(!code) {
			na_alert('등록할 코드를 입력해 주세요.', function() {
				$('#codeZone').focus();
			});
			return false;
		}

		var clip = "[code=" + txt + "]" + code + "[/code]";

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