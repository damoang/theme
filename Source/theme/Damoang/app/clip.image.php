<?php
include_once('./_common.php');

// 파일용량(MB)
$is_max_upload_size = 2;

$g5['title'] = '이미지 등록';
include_once(G5_PATH.'/head.sub.php');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

<form id="na_upload_form" action="<?php echo NA_URL ?>/upload.image.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
	<div class="input-group">
		<input type="file" class="form-control nofocus" name="na_file" id="na_upload_file" aria-describedby="na_uploadFileBtn" aria-label="Upload">
		<button class="btn btn-primary nofocus" type="submit" id="na_uploadFileBtn">
			<i class="bi bi-upload"></i> 업로드
		</button>
	</div>
	<div class="form-text">
		<i class="bi bi-check2-circle"></i>
		<?php echo ($is_member) ? '이미지 파일(JPG/GIF/PNG)만 업로드 할 수 있습니다.' : '로그인한 회원만 가능합니다.';?>
	</div>
</form>

<script>
$(function(){
	$('#na_upload_form').ajaxForm({
		type: 'POST',
		url: '<?php echo NA_URL ?>/upload.image.php',
		enctype : 'multipart/form-data',
		dataType: 'json',
		contentType: false,
		processData: false,
		beforeSubmit: function (data, form, option) {
			var chkFile = $("input[name='na_file']").val();

			if(!chkFile) {
				na_alert('업로드 할 파일을 선택해 주세요.');
				return false;
			}

			var chkExt = chkFile.split('.').pop().toLowerCase();

			if($.inArray(chkExt, ['gif','png','jpg','jpeg']) == -1) {
				na_alert('이미지 파일(JPG/GIF/PNG)만 업로드 할 수 있습니다.');
				return false;
			}
		},
		success: function(result){
			if(result.success) {

				parent.document.getElementById("wr_content").value += '[' + result.success + ']\n';

				window.parent.naClipClose();

				var fileInput = $("input[name='na_file']");

				if ($.browser.msie) { //IE
					fileInput.replaceWith(fileInput.clone(true));
				} else {
					fileInput.val('');
				}
			} else {
				var chkErr = result.error.replace(/<[^>]*>?/g, '');
				if(!chkErr) {
					chkErr = '[E1]오류가 발생하였습니다.';
				}
				na_alert(chkErr);
				return false;
			}
		},
		error : function(request,status,error){
			let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
			na_alert(msg);
			return false;
		}                               
	});
});
</script>

<?php 
include_once(G5_PATH.'/tail.sub.php');