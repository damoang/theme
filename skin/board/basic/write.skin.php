<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 여분필드 사용 내역
// wr_7 : 신고(lock)
// wr_8 : 태그
// wr_9 : 유튜브 동영상
// wr_10 : 대표 이미지

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

// 멤버십
na_membership('write', '멤버십 회원만 등록할 수 있습니다.');

//하루 글쓰기 개수 제한 체크
na_board_write_permit_check($bo_table, $member['mb_id']);

// 회원만 보기 설정
$boset['check_member_only'] = $boset['check_member_only'] ?? '0';
$boset['member_only_permit'] = $boset['member_only_permit'] ?? 'admin_only';
$member_only_permit = false;
if ($boset['check_member_only'] === '1') {
    if ($boset['member_only_permit'] === 'all') {
        // 전체 허용
        $member_only_permit = true;
    } else if ($boset['member_only_permit'] === 'admin_only' && $is_admin) {
        // 관리자만 허용
        $member_only_permit = true;
    }
}
// 최고관리자는 항상 허용
if ($is_admin === 'super') {
    $member_only_permit = true;
}
?>
<div class="rolling-noti-container small" id="rolling-noti-container">
  <div class="fixed-text">
    <span class="bi bi-bell"></span> 알림
  </div>
  <div class="divider">|</div>
  <div class="rolling-noti" id="rolling-noti"></div>
</div>
<section id="bo_w">

    <h2 class="fs-4 mb-0 pb-2 px-3">
        <?php echo str_replace($board['bo_subject'], '', $g5['title']) ?>
    </h2>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">

    <?php
        $option = '';
        $option_hidden = '';
        if ($is_notice || $is_html || $is_secret || $is_mail) {
            $option_start = PHP_EOL.'<div class="form-check form-check-inline">'.PHP_EOL;
            $option_end = PHP_EOL.'</div>'.PHP_EOL;

            if ($is_html) {
                if ($is_dhtml_editor) {
                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
                } else {
                    $option .= $option_start;
                    $option .= '<input class="form-check-input" type="checkbox" name="html" value="'.$html_value.'" id="html" onclick="html_auto_br(this);" '.$html_checked.'>';
                    $option .= '<label class="form-check-label" for="html">HTML</label>';
                    $option .= $option_end;
                }
            }

            if ($is_notice) {
                $option .= $option_start;
                $option .= '<input class="form-check-input" type="checkbox" name="notice" value="1" id="notice" '.$notice_checked.'>';
                $option .= '<label class="form-check-label" for="notice">공지</label>';
                $option .= $option_end;
            }

            if ($is_secret) {
                if ($is_admin || $is_secret==1) {
                    $option .= $option_start;
                    $option .= '<input class="form-check-input" type="checkbox" name="secret" value="secret" id="secret" '.$secret_checked.'>';
                    $option .= '<label class="form-check-label" for="secret">비밀</label>';
                    $option .= $option_end;
                } else {
                    $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                }
            }

            if ($is_mail) {
                $option .= $option_start;
                $option .= '<input class="form-check-input" type="checkbox" name="mail" value="mail" id="mail" '.$recv_email_checked.'>';
                $option .= '<label class="form-check-label" for="mail">답변메일받기</label>';
                $option .= $option_end;
            }
        }

        echo $option_hidden;
    ?>

    <ul class="list-group list-group-flush line-top mb-4">
    <?php if ($is_name) { ?>
        <li class="list-group-item">
            <div class="row">
                <label for="wr_name" class="col-sm-2 col-form-label">이름<strong class="visually-hidden"> 필수</strong></label>
                <div class="col-sm-6 col-md-4">
                    <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="form-control required" maxlength="20">
                </div>
            </div>
        </li>
    <?php } ?>

    <?php if ($is_password) { ?>
        <li class="list-group-item">
            <div class="row">
                <label for="wr_password" class="col-sm-2 col-form-label">비밀번호<strong class="visually-hidden"> 필수</strong></label>
                <div class="col-sm-6 col-md-4">
                    <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="form-control <?php echo $password_required ?>" maxlength="20">
                </div>
            </div>
        </li>
    <?php } ?>

    <?php if ($is_email) { ?>
        <li class="list-group-item">
            <div class="row">
                <label for="wr_email" class="col-sm-2 col-form-label">E-mail</label>
                <div class="col-sm-6 col-md-4">
                    <input type="text" name="wr_email" id="wr_email" value="<?php echo $email ?>" class="form-control email" maxlength="100">
                </div>
            </div>
        </li>
    <?php } ?>

    <?php if ($is_homepage) { ?>
        <li class="list-group-item">
            <div class="row">
                <label for="wr_homepage" class="col-sm-2 col-form-label">홈페이지</label>
                <div class="col-sm-10">
                    <input type="text" name="wr_homepage" id="wr_homepage" value="<?php echo $homepage ?>" class="form-control" maxlength="255">
                </div>
            </div>
        </li>
    <?php } ?>

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

    <?php if ($is_category) { ?>
        <li class="list-group-item">
            <div class="row">
                <label for="wr_category" class="col-sm-2 col-form-label">분류<strong class="visually-hidden"> 필수</strong></label>
                <div class="col-sm-6 col-md-4">
                    <select id="wr_category" name="ca_name" required class="form-select">
                        <option value="">선택하세요</option>
                        <?php echo $category_option ?>
                    </select>
                </div>
            </div>
        </li>
    <?php } ?>

    <li class="list-group-item">
        <div class="row">
            <label for="wr_subject" class="col-sm-2 col-form-label">제목<strong class="visually-hidden"> 필수</strong></label>
            <div class="col-sm-10">
                <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="form-control required" maxlength="255">
            </div>
        </div>
    </li>

    <?php
    if ($member_only_permit || $write['wr_1'] == '1') {
        // 설정 권한이 있거나 이미 설정된 글이라면 해제, 유지를 선택하도록 옵션 노출
    ?>
        <li class="list-group-item">
            <div class="row">
            <label for="wr_1" class="col-sm-2 col-form-label">회원만 보기</label>
            <div class="col-sm-10">
                <input class="form-check-input" type="checkbox" name="wr_1" value="1" id="wr_1" <?php if ($write['wr_1'] == '1') echo 'checked'; ?>>
                <label class="form-check-label" for="wr_1">로그인 한 회원만 볼 수 있습니다.</label>
            </div>
            </div>
        </li>
    <?php } ?>

    <li class="list-group-item">
        <label class="visually-hidden">내용<strong> 필수</strong></label>
        <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <div id="char_count_desc" class="form-text">최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 까지 등록할 수 있습니다.(현재 <span id="char_count">0</span>글자)</div>
        <?php } ?>

        <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>

        <?php if($is_dhtml_editor) { ?>
            <style> #wr_content { display:none; } </style>
        <?php } else { ?>
            <script> $("#wr_content").hide().addClass("form-control mb-2").show(); </script>
        <?php } ?>

        <?php include_once(G5_THEME_PATH.'/app/clip.write.php'); // 클립 버튼 ?>

    </li>

    <?php if(isset($boset['tag']) && isset($member['mb_level']) && (int)$member['mb_level'] >= (int)$boset['tag']) { // 태그 ?>
        <li class="list-group-item">
            <div class="row">
                <label for="wr_8" class="col-sm-2 col-form-label">태그</label>
                <div class="col-sm-10">
                    <input type="text" name="wr_8" value="<?php echo isset($write['wr_8']) ? $write['wr_8'] : ''; ?>" id="wr_8" class="form-control" maxlength="255">
                    <div class="form-text">
                        콤마(,)로 구분하여 복수 태그 등록 가능
                    </div>
                </div>
            </div>
        </li>
    <?php } ?>

    <?php if ($is_link) { // 링크 ?>
        <li class="list-group-item">
            <div class="row">
                <label class="col-sm-2 col-form-label">링크</label>
                <div class="col-sm-10">
                    <?php for ($i=1; $i<=G5_LINK_COUNT; $i++) { ?>
                        <input type="text" name="wr_link<?php echo $i ?>" value="<?php echo isset($write['wr_link'.$i]) ? $write['wr_link'.$i] : ''; ?>" id="wr_link<?php echo $i ?>" placeholder="https://..." class="form-control<?php echo ($i > 1) ? ' mt-2' : ''; ?>" maxlength="255">
                    <?php } ?>
                    <?php if (isset($boset['video_link']) && $boset['video_link']) { ?>
                        <div class="form-text">
                            유튜브, 비메오 등 동영상 공유주소 등록시 자동 출력
                        </div>
                    <?php } ?>
                </div>
            </div>
        </li>
    <?php } ?>

    <?php if ($is_file && (int)$board['bo_upload_count'] > 0) { // 첨부파일 ?>
        <li class="list-group-item">

            <div class="row">
                <label class="col-sm-2 col-form-label">첨부</label>
                <div class="col-sm-10">

                    <table id="variableFiles" class="w-100"></table>

                    <div class="form-text mt-0 mb-2">
                        용량이 <?php echo get_filesize($board['bo_upload_size']) ?> 이하 파일만 업로드 가능
                    </div>

                    <div class="btn-group" role="group">
                        <button type="button" onclick="add_file();" class="btn btn-basic">
                            <i class="bi bi-plus-circle"></i>
                            파일 추가
                        </button>
                        <button type="button" onclick="del_file();" class="btn btn-basic">
                            <i class="bi bi-dash-circle"></i>
                            파일 삭제
                        </button>
                    </div>

                    <script>
                    var flen = 0;
                    function add_file(delete_code) {

                        var upload_count = <?php echo (int)$board['bo_upload_count']; ?>;
                        if (upload_count && flen >= upload_count) {
                            na_alert('파일 '+upload_count+'개 까지 업로드가 가능합니다.');
                            return;
                        }

                        var objTbl;
                        var objNum;
                        var objRow;
                        var objCell;
                        var objContent;
                        if (document.getElementById)
                            objTbl = document.getElementById("variableFiles");
                        else
                            objTbl = document.all["variableFiles"];

                        objNum = objTbl.rows.length;
                        objCnt = objNum + 1;
                        objRow = objTbl.insertRow(objNum);
                        objCell = objRow.insertCell(0);

                        objContent = '<div class="input-group mb-2">';
                        objContent += '<label class="input-group-text" for="fileAttach'+objNum+'">#'+objCnt+'</label>';
                        objContent += '<input type="file" name="bf_file[]" class="form-control" id="fileAttach'+objNum+'">';
                        objContent += '</div>';

                        if (delete_code) {
                            objContent += delete_code;
                        } else {
                            <?php if ($is_file_content) { ?>
                                objContent += '<div class="input-group mb-2">';
                                objContent += '<label class="input-group-text" for="fileContent'+objNum+'">#'+objCnt+'</label>';
                                objContent += '<label class="input-group-text" for="fileContent'+objNum+'">파일 설명</label>';
                                objContent += '<input type="text" name="bf_content[]" class="form-control" id="fileContent'+objNum+'" maxlength="255">';
                                objContent += '</div>';
                            <?php } ?>
                        }

                        objCell.innerHTML = objContent;

                        flen++;
                    }

                    <?php
                        //수정시에 필요한 스크립트 : 수정의 경우 파일업로드 필드가 가변적으로 늘어나야 하고 삭제 표시도 해주어야 합니다.
                        $file_script = "";
                        $file_length = -1;

                        if ($w == "u") {
                            for ($i=0; $i<$file['count']; $i++) {
                                if ($file[$i]['source']) {
                                    $file_script .= "add_file('";
                                    if ($is_file_content) {
                                        $file_script .= '<div class="input-group mb-2">';
                                        $file_script .= '<label class="input-group-text" for="fileCotent'.$i.'">#'.($i+1).'</label>';
                                        $file_script .= '<label class="input-group-text" for="fileCotent'.$i.'">파일 설명</label>';
                                        $file_script .= '<input type="text" name="bf_content['.$i.']" value="'.addslashes(get_text($file[$i]['bf_content'])).'" class="form-control" id="fileContent'.$i.'" maxlength="255">';
                                        $file_script .= '</div>';
                                    }
                                    $file_script .= '<div class="input-group mb-2">';
                                    $file_script .= '<label class="input-group-text" for="fileDelet'.$i.'">';
                                    $file_script .= '<input class="form-check-input mt-0" type="checkbox" name="bf_file_del['.$i.']" value="1" id="fileDelet'.$i.'">';
                                    $file_script .= '</label>';
                                    $file_script .= '<label class="input-group-text" for="fileDelet'.$i.'">파일 삭제</label>';
                                    $file_script .= '<input type="text" class="form-control nofocus" readonly value="'.$file[$i]['source'].'('.$file[$i]['size'].')">';
                                    $file_script .= '<div class="input-group-text">';
                                    $file_script .= '<a href="'.$file[$i]['href'].'">열기</a>';
                                    $file_script .= '</div>';
                                    $file_script .= '</div>';
                                    $file_script .= "');\n";
                                } else {
                                    $file_script .= "add_file('');\n";
                                }
                            }
                            $file_length = $file['count'] - 1;
                        }

                        if ($file_length < 0) {
                            $file_script .= "add_file('');\n";
                            $file_length = 0;
                        }

                        echo $file_script;
                    ?>

                    function del_file() {
                        // file_length 이하로는 필드가 삭제되지 않아야 합니다.
                        var file_length = <?php echo (int)$file_length; ?>;
                        var objTbl = document.getElementById("variableFiles");
                        if (objTbl.rows.length - 1 > file_length) {
                            objTbl.deleteRow(objTbl.rows.length - 1);
                            flen--;
                        }
                    }
                    </script>
                </div>
            </div>
        </li>
    <?php } ?>

    <?php if ($captcha_html) { //자동등록방지  ?>
        <li class="list-group-item">
            <div class="row">
                <label class="col-sm-2 col-form-label">자동등록방지</label>
                <div class="col-sm-10 small">
                    <?php echo $captcha_html; ?>
                </div>
            </div>
        </li>
    <?php } ?>
    <li class="list-group-item pt-3">
        <div class="row g-3 justify-content-center">
            <div class="col-6 col-sm-5 md-4 col-xl-3 order-2">
                <button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg w-100">작성완료</button>
            </div>
            <div class="col-6 col-sm-5 md-4 col-xl-3 order-1">
                <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn btn-basic btn-lg w-100">취소</a>
            </div>
        </div>
    </li>
    </ul>

    </form>

</section>

<script>
$(document).on('change', 'input[type="file"]', function(event) {
    var upload_max_size = <?=(int)$board['bo_upload_size']?>;
    var file = event.target.files[0];
    if (file && (upload_max_size < file.size)) {
        alert('파일의 용량이 서버에 설정(<?=get_filesize($board['bo_upload_size'])?>)된 값보다 크므로 업로드 할 수 없습니다.')
        $(this).val('');
    }
});

<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo (int)$write_min; ?>); // 최소
var char_max = parseInt(<?php echo (int)$write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
});
<?php } ?>

function html_auto_br(obj) {
    if (obj.checked) {
        let msg = '자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을 &lt;br>태그로 변환하는 기능입니다.'
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
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
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
        na_alert("제목에 금지단어('"+subject+"')가 포함되어있습니다", function() {
            f.wr_subject.focus();
        });
        return false;
    }

    if (content) {
        na_alert("내용에 금지단어('"+content+"')가 포함되어있습니다", function() {
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
        });
        return false;
    }

    if (document.getElementById("char_count")) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(check_byte("wr_content", "char_count"));
            if (char_min > 0 && char_min > cnt) {
                na_alert("내용은 최소 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                na_alert("내용은 최대 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>
