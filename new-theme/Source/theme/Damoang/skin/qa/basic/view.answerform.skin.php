<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(!$is_admin) {
	 echo '<div class="text-center p-3"><i class="bi bi-chat-dots"></i> 문의에 대한 답변을 준비 중입니다.</div>';
	 return;
}
?>

<section id="qa_v_ans_form">

	<h3 class="visually-hidden">답변등록</h3>

    <form name="fanswer" method="post" action="./qawrite_update.php" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="qa_id" value="<?php echo $view['qa_id']; ?>">
    <input type="hidden" name="w" value="a">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_dhtml_editor) {
        $option_hidden .= '<input type="hidden" name="qa_html" value="1">';
    } else {
		$option .= '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="qa_html" value="'.$html_value.'" id="html" onclick="html_auto_br(this);" '.$html_checked.'><label class="form-check-label" for="html">HTML</label></div>';
    }
    echo $option_hidden;
    ?>

	<ul class="list-group list-group-flush mb-3 line-top">
	<?php if ($option) { ?>
		<li class="list-group-item">
			<div class="row align-items-center">
				<label class="col-sm-2 col-form-label">옵션</label>
				<div class="col-sm-10">
					<?php echo $option; ?>
				</div>
			</div>
		</li>
	<?php } ?>
	<li class="list-group-item">
		<div class="row">
			<label for="qa_subject" class="col-sm-2 col-form-label">제목<strong class="visually-hidden"> 필수</strong></label>
			<div class="col-sm-10">
				<input type="text" name="qa_subject" value="" id="qa_subject" required class="form-control required" maxlength="255">
			</div>
		</div>
	</li>	
	<li class="list-group-item">
		<label class="visually-hidden">내용<strong> 필수</strong></label>
		<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
		<?php if($is_dhtml_editor) { ?>
			<style> #qa_content { display:none; } </style>
		<?php } else { ?>
			<script> $("#qa_content").hide().addClass("form-control").show(); </script>
		<?php } ?>
	</li>	
	<li class="list-group-item">
		<div class="row">
			<label class="col-sm-2 col-form-label">첨부</label>
			<div class="col-sm-10">	
				<div class="input-group mb-2">
					<label class="input-group-text" for="bf_file_1"><i class="bi bi-upload"></i></label>
					<input type="file" name="bf_file[1]" class="form-control" id="bf_file_1">
				</div>
				<?php if($w == 'u' && $write['qa_file1']) { ?>
					<div class="form-check mb-2">
						<input class="form-check-input" name="bf_file_del[1]" type="checkbox" id="bf_file_del1" value="1">
						<label class="form-check-label" for="bf_file_del1"><?php echo $write['qa_source1'] ?> 파일 삭제</label>
					</div>
				<?php } ?>
				<div class="input-group mb-2">
					<label class="input-group-text" for="bf_file_2"><i class="bi bi-upload"></i></label>
					<input type="file" name="bf_file[2]" class="form-control" id="bf_file_2">
				</div>
				<?php if($w == 'u' && $write['qa_file2']) { ?>
					<div class="form-check mb-2">
						<input class="form-check-input" name="bf_file_del[2]" type="checkbox" id="bf_file_del2" value="1">
						<label class="form-check-label" for="bf_file_del2"><?php echo $write['qa_source2'] ?> 파일 삭제</label>
					</div>
				<?php } ?>
				<div class="form-text">
					용량이 <?php echo get_filesize($qaconfig['qa_upload_size']) ?> 이하 파일만 업로드 가능
				</div>
			</div>
		</div>
	</li>
	<li class="list-group-item pt-3">
		<div class="row justify-content-center">
			<div class="col-6 col-sm-5 md-4 col-xl-3 order-2">
				<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg w-100">답변 등록</button>
			</div>
		</div>
	</li>
    </ul>
    </form>

    <script>
    function html_auto_br(obj) {
        if (obj.checked) {
			let msg = '자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을 &lt;br>태그로 변환하는 기능입니다.';
			na_confirm(msg, function() {
				obj.value = "html2";
			}, function() {
				obj.value = "html1";
			});
        } else {
			obj.value = "";
		}
    }

    function fwrite_submit(f) {

		<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.qa_subject.value,
                "content": f.qa_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
			na_alert("제목에 금지단어('"+subject+"')가 포함되어있습니다.", function(){
				f.qa_subject.focus();
			});
            return false;
        }

        if (content) {
			na_alert("내용에 금지단어('"+content+"')가 포함되어있습니다.", function(){
				if (typeof(ed_wr_content) != "undefined")
					ed_qa_content.returnFalse();
				else
					f.qa_content.focus();
			});
            return false;
        }

        $.ajax({
            type: "POST",
            url: g5_bbs_url+"/ajax.write.token.php",
            data: { 'token_case' : 'qa_write' },
            cache: false,
            async: false,
            dataType: "json",
            success: function(data) {
                if (typeof data.token !== "undefined") {
                    token = data.token;
                    if(typeof f.token === "undefined")
                        $(f).prepend('<input type="hidden" name="token" value="">');
                    $(f).find("input[name=token]").val(token);
                }
            }
        });

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>
</section>