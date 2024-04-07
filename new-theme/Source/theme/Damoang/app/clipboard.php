<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 클립보드
$is_clip = (isset($_REQUEST['clip']) && $_REQUEST['clip']) ? '1' : '';

?>
<style>
	html, body {
		height: auto !important; }
</style>

<?php if(!$is_clip) return; ?>

<div class="modal fade" id="clipModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="false">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="bi bi-clipboard-check"></i> Clipboard</h5>
				<button type="button" class="btn-close nofocus" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<?php if(isset($input_style) && $input_style == 'textarea') { ?>
						<textarea rows="5" id="txtClip" class="form-control nofocus" aria-describedby="copy-btn"></textarea>
					<?php } else { ?>
						<input type="text" id="txtClip" class="form-control nofocus" aria-describedby="copy-btn">
					<?php } ?>
					<button class="btn btn-primary btn-copy nofocus" type="button" id="copy-btn" data-clipboard-target="#txtClip">
						Copy
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(function() {
	var clipboard = new ClipboardJS('.btn-copy');
	clipboard.on('success', function(e) {
		na_alert('복사가 되었으니 Ctrl + V 를 눌러 붙여넣기해 주세요.', function() {
			$('#clipModal').modal('hide');
			window.parent.naClipClose();
		});
	});
	clipboard.on('error', function(e) {
		na_alert('복사가 안되었으니 Ctrl + C 를 눌러 복사해 주세요.');
	});
});
</script>