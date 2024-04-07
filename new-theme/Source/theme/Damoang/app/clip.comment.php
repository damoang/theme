<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div class="btn-group btn-group-sm" role="group">
	<button type="button" class="btn btn-basic" onclick="btnClip('emo');" title="이모티콘">
		<i class="bi bi-emoji-smile"></i>
		<span class="visually-hidden">이모티콘</span>
	</button>
	<button type="button" class="btn btn-basic" onclick="btnClip('icon');" title="아이콘">
		<i class="bi bi-ui-radios-grid"></i>
		<span class="visually-hidden">아이콘</span>
	</button>
	<button type="button" class="btn btn-basic" onclick="btnClip('video');" title="동영상">
		<i class="bi bi-camera-video"></i>
		<span class="visually-hidden">동영상</span>
	</button>
	<button type="button" class="btn btn-basic" onclick="btnClip('image');" title="이미지">
		<i class="bi bi-image"></i>
		<span class="visually-hidden">이미지</span>
	</button>

	<?php if(isset($boset['code']) && $boset['code']) { ?>
		<button type="button" class="btn btn-basic" onclick="btnClip('code');" title="코드">
			<i class="bi bi-code-slash"></i>
			<span class="visually-hidden">코드</span>
		</button>
	<?php } ?>
	<?php if(isset($nariya['kakaomap_key']) && $nariya['kakaomap_key']) { ?>
		<button type="button" class="btn btn-basic" onclick="btnClip('map');" title="지도">
			<i class="bi bi-geo-alt-fill"></i>
			<span class="visually-hidden">지도</span>
		</button>
	<?php } ?>
	<button type="button" class="btn btn-basic" title="새댓글 작성" onclick="comment_box('','c');">
		<i class="bi bi-arrow-clockwise"></i>
		<span class="visually-hidden">새댓글 작성</span>
	</button>
</div>

<script>
function btnClip(id) {

	let url = '<?php echo G5_THEME_URL ?>/app/clip.' + id + '.php';

	if(id == 'image')
		url += '?bo_table=<?php echo $bo_table ?>';

	naClipView(url);
}
</script>