<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 댓글 여분필드 사용 내역
// wr_7 : 신고(lock)
// wr_9 : 대댓글 대상
// wr_10 : 럭키 포인트

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
if(!$is_ajax)
    add_stylesheet('<link rel="stylesheet" href="' . $comment_skin_url . '/comment.css?CACHEBUST">', 0);
?>

<?php if(!$is_ajax) { // 1번만 출력 ?>
<script>
// 글자수 제한
var char_min = parseInt(<?php echo $comment_min ?>); // 최소
var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>
<div id="viewcomment" class="mt-4">
<?php } ?>
    <div class="d-flex justify-content-between align-items-end px-3 mb-2">
        <div>
            댓글 <b><?php echo $write['wr_comment'] ?></b>
            <?php if($is_paging && $page) echo ' / '.$page.' 페이지'.PHP_EOL; ?>
        </div>
        <?php if($is_paging) { //페이징
            $comment_sort_href = NA_URL.'/comment.page.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id;
            switch($cob) {
                case 'new'		: $comment_sort_txt = '최신순'; break;
                case 'good'		: $comment_sort_txt = '추천순'; break;
                case 'nogood'	: $comment_sort_txt = '비추천순'; break;
                default			: $comment_sort_txt = '과거순'; break;
            }
        ?>

            <div>
                <div class="btn-group">
                    <button type="button" class="btn btn-basic btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $comment_sort_txt ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button class="dropdown-item" type="button" onclick="na_comment_sort('viewcomment', '<?php echo $comment_sort_href ?>', 'old');">과거순</button>
                        </li>
                        <li>
                            <button class="dropdown-item" type="button" onclick="na_comment_sort('viewcomment', '<?php echo $comment_sort_href ?>', 'new');">최신순</button>
                        </li>
                        <?php if($is_comment_good) { ?>
                            <button class="dropdown-item" type="button" onclick="na_comment_sort('viewcomment', '<?php echo $comment_sort_href ?>', 'good');">추천순</button>
                        <?php } ?>
                        <?php if($is_comment_nogood) { ?>
                            <button class="dropdown-item" type="button" onclick="na_comment_sort('viewcomment', '<?php echo $comment_sort_href ?>', 'nogood');">비추천순</button>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>

    <section id="bo_vc" class="na-fadein">
        <?php
        $good_list = array();
        if ($member['mb_id']) {
            // 추천/비추천 여부 확인을 위한 댓글의 추천내역 가져오기
            // 2024.04.15 서버 부하로 사용 안함
            /*$sql = " select {$write_table}.wr_id, {$g5['board_good_table']}.bg_id, {$g5['board_good_table']}.bg_flag
                    from {$write_table}
                    left join {$g5['board_good_table']} on
                        {$write_table}.wr_id = {$g5['board_good_table']}.wr_id
                    where {$write_table}.wr_id != '{$wr_id}'
                    and {$write_table}.wr_parent = '{$wr_id}'
                    and {$g5['board_good_table']}.mb_id = '{$member['mb_id']}'";
            $result = sql_query($sql);

            for ($i=0; $row=sql_fetch_array($result); $i++) {
                $good_list[$row['wr_id']] = $row['bg_flag'];
            }*/
        }

        // 댓글목록

        $comment_cnt = count($list);
        $wr_names = [];
        for ($i = 0; $i < $comment_cnt; $i++) {
            $comment_id = $list[$i]['wr_id'];
            $comment_depth = strlen($list[$i]['wr_comment_reply']) * 1;
            $comment = $list[$i]['content'];

            $wr_names[$list[$i]['wr_comment'] . ':' . $list[$i]['wr_comment_reply']] = $list[$i]['wr_name'];

            // 이미지
            $comment = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp|webp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src=\"$1://$2.$3\" alt=\"\">", $comment);

            // 이미지 썸네일
            $comment = str_replace('<img', '<img class="img-fluid"', get_view_thumbnail($comment));

            // 동영상
            $comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);

            // 컨텐츠
            $comment = na_content($comment);

            $comment_sv = $comment_cnt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
            $c_reply_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w';
            $c_edit_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w';
            $is_comment_reply_edit = ($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) ? 1 : 0;

            $comment_name = get_text($list[$i]['wr_name']);

            // 글 작성자가 쓴 댓글, 로그인 한 사용자가 쓴 댓글, 일반 댓글 색상으로 구분하기
            if (!empty($view['mb_id']) && $view['mb_id'] == $list[$i]['mb_id']) {
                $by_writer = 'bg-secondary-subtle'; // 글 작성자가 쓴 댓글
            } elseif (!empty($member['mb_id']) && $member['mb_id'] == $list[$i]['mb_id']) {
                $by_writer = 'bg-comment-writer'; // 로그인 한 사용자가 쓴 댓글
            } else {
                $by_writer = 'bg-body-tertiary'; // 일반 사용자가 쓴 댓글
            }

            $parent_wr_name = $wr_names[$list[$i]['wr_comment'] . ':' . substr($list[$i]['wr_comment_reply'], 0, -1)] ?? '';

        ?>
        <article id="c_<?php echo $comment_id ?>" <?php if ($comment_depth) { ?>style="margin-left:<?php echo $comment_depth ?>rem;"<?php } ?>>
            <div class="comment-list-wrap position-relative">
                <header style="z-index:<?php echo $comment_sv ?>">
                    <h3 class="visually-hidden">
                        <?php echo $comment_name; ?>님의
                        <?php if ($comment_depth) { ?><span class="visually-hidden">댓글의</span><?php } ?> 댓글
                    </h3>
                    <div class="d-flex align-items-center border-top <?php echo $by_writer ?> py-1 px-3 small">
                        <div class="me-2">
                            <?php if ($comment_depth) { ?>
                                <i class="bi bi-arrow-return-right"></i>
                                <span class="visually-hidden">대댓글</span>
                            <?php } ?>
                            <span class="visually-hidden">작성자</span>
                            <?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']); ?>
                            <?php
                            // 회원 메모
                            echo $list[$i]['da_member_memo'] ?? '';
                            ?>
                            (<?php echo $list[$i]['ip'] ?>)
                        </div>
                        <div>
                            <?php include(G5_SNS_PATH.'/view_comment_list.sns.skin.php'); // SNS ?>
                        </div>
                        <div class="ms-auto" title="<?= get_text($list[$i]['wr_datetime']) ?>">
                            <span class="visually-hidden">작성일</span>
                            <?php echo na_date($list[$i]['wr_datetime'], 'orangered'); ?>
                        </div>
                    </div>
                </header>
                <div class="comment-content p-3">
                    <div class="<?php echo $is_convert ?>">
                        <?php if ($comment_depth) { ?>
                            <?php if ($parent_wr_name) { ?>
                                <em class="da-commented-to"><strong>@<?= $parent_wr_name ?></strong>님에게 답글</em>
                            <?php } else { ?>
                                <em class="da-commented-to">다른 누군가에게 답글</em>
                            <?php } ?>
                        <?php } ?>
                        <?php
                        $is_lock = false;
                        if (strstr($list[$i]['wr_option'], "secret")) {
                            $is_lock = true;
                        ?>
                            <span class="na-icon na-secret"></span>
                        <?php } ?>

                        <?php echo $comment ?>
                    </div>
                    <?php if((int)$list[$i]['wr_10'] > 0) { // 럭키포인트 ?>
                        <div class="small mt-3">
                            <i class="bi bi-gift"></i>
                            <b><?php echo number_format((int)$list[$i]['wr_10']) ?></b> 럭키포인트 당첨을 축하드립니다.
                        </div>
                    <?php } ?>

                    <div class="d-flex justify-content-between mt-3">
                        <div class="btn-group btn-group-sm" role="group">
                        <?php if($is_comment_reply_edit) {
                            if($w == 'cu') {
                                $sql = " select wr_id, wr_content, mb_id from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
                                $cmt = sql_fetch($sql);
                                if (!($is_admin || ($member['mb_id'] == $cmt['mb_id'] && $cmt['mb_id'])))
                                    $cmt['wr_content'] = '';
                                $c_wr_content = $cmt['wr_content'];
                            }
                        ?>
                            <?php if ($list[$i]['is_reply']) { ?>
                                <button type="button" class="btn btn-basic" onclick="comment_box('<?php echo $comment_id ?>','c','<?php echo $comment_name;?>');" class="btn btn-basic btn-sm" title="답글">
                                    <i class="bi bi-chat-dots"></i>
                                    답글
                                </button>
                            <?php } ?>
                            <?php if ($list[$i]['is_edit']) { ?>
                                <button type="button" class="btn btn-basic" onclick="comment_box('<?php echo $comment_id ?>','cu','<?php echo $comment_name;?>');" class="btn btn-basic btn-sm" title="수정">
                                    <i class="bi bi-pencil"></i>
                                    <span class="d-none d-sm-inline-block">수정</span>
                                </button>
                            <?php } ?>
                            <?php if ($list[$i]['is_del']) { ?>
                                <a href="<?php echo $list[$i]['del_link']; ?>" onclick="<?php echo (isset($list[$i]['del_back']) && $list[$i]['del_back']) ? "na_delete('viewcomment', '".$list[$i]['del_href']."','".$list[$i]['del_back']."'); return false;" : "return comment_delete(this.href);";?>" class="btn btn-basic" title="삭제">
                                    <i class="bi bi-trash"></i>
                                    <span class="d-none d-sm-inline-block">삭제</span>
                                </a>
                            <?php } ?>
                        <?php } ?>
                            <?php if(!empty($is_member)) { // 로그인한 회원만 복사 가능 ?>
                            <button type="button" onclick="copy_comment_link('<?php echo $comment_id ?>');" class="btn btn-basic" title="복사">
                                <i class="bi bi-copy"></i>
                                <span class="d-none d-sm-inline-block">복사</span>
                            </button>
                            <?php } ?>
                            <button type="button" onclick="na_singo('<?php echo $bo_table ?>', '<?php echo $list[$i]['wr_id'] ?>', '0', 'c_<?php echo $comment_id ?>');" class="btn btn-basic" title="신고">
                                <i class="bi bi-eye-slash"></i>
                                <span class="d-none d-sm-inline-block">신고</span>
                            </button>
                            <?php if($list[$i]['mb_id']) { // 회원만 가능 ?>
                                <button type="button" onclick="na_chadan('<?php echo $list[$i]['mb_id'] ?>');" class="btn btn-basic" title="차단">
                                    <i class="bi bi-person-slash"></i>
                                    <span class="d-none d-sm-inline-block">차단</span>
                                </button>
                            <?php } ?>
                        </div>
                        <?php if($is_comment_good || $is_comment_nogood) { ?>
                            <div class="btn-group btn-group-sm" role="group">
                                <?php if($is_comment_good) { ?>
                                    <button type="button" onclick="na_good('<?php echo $bo_table ?>', '<?php echo $comment_id ?>', 'good', 'c_g<?php echo $comment_id ?>', 1);" class="btn <?php echo (isset($good_list[$list[$i]['wr_id']]) && $good_list[$list[$i]['wr_id']] == 'good') ? 'btn-primary' : 'btn-basic' ?>" title="추천">
                                        <span class="visually-hidden">추천</span>
                                        <i class="bi bi-hand-thumbs-up"></i>
                                        <span id="c_g<?php echo $comment_id ?>"><?php echo $list[$i]['wr_good'] ?></span>
                                    </button>
                                <?php } ?>
                                <?php if($is_comment_nogood) { ?>
                                    <button type="button" class="btn <?php echo (isset($good_list[$list[$i]['wr_id']]) && $good_list[$list[$i]['wr_id']] == 'nogood') ? 'btn-primary' : 'btn-basic' ?>" onclick="na_good('<?php echo $bo_table ?>', '<?php echo $comment_id ?>', 'nogood', 'c_ng<?php echo $comment_id ?>', 1);" title="비추천">
                                        <span class="visually-hidden">비추천</span>
                                        <i class="bi bi-hand-thumbs-down"></i>
                                        <span id="c_ng<?php echo $comment_id;?>"><?php echo $list[$i]['wr_nogood']; ?></span>
                                    </button>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="clearfix">
                    <span id="edit_<?php echo $comment_id ?>" class="bo_vc_w"></span><!-- 수정 -->
                    <span id="reply_<?php echo $comment_id ?>" class="bo_vc_re"></span><!-- 답변 -->
                    <?php if($is_paging) { ?>
                        <input type="hidden" value="<?php echo $comment_url.'&amp;page='.$page; ?>" id="comment_url_<?php echo $comment_id ?>">
                        <input type="hidden" value="<?php echo $page; ?>" id="comment_page_<?php echo $comment_id ?>">
                    <?php } ?>
                    <input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
                    <textarea id="save_comment_<?php echo $comment_id ?>" class="d-none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
                </div>
            </div>
        </article>
        <?php } ?>
        <?php if($is_paging) { //페이징 ?>
            <div class="d-flex flex-column flex-sm-row border-top justify-content-between p-3 gap-2">
                <div>
                    <ul class="pagination pagination-sm justify-content-center m-0">
                        <?php echo na_ajax_paging('viewcomment', $write_pages, $page, $total_page, $comment_page); ?>
                    </ul>
                </div>
                <div>
                    <button class="btn btn-basic btn-sm w-100" onclick="na_comment_new('viewcomment','<?php echo $comment_url ?>','<?php echo $total_count ?>');">
                        <i class="bi bi-arrow-clockwise"></i>
                        새로운 댓글 확인
                    </button>
                </div>
            </div>
        <?php } ?>
    </section>
<?php
// 아래 내용은 1번만 출력
if($is_ajax)
    return;
?>
</div><!-- #viewcomment 닫기 -->

<?php if ($is_comment_write) { $w = ($w == '') ? 'c' : $w; ?>

    <aside id="bo_vc_w">
        <h3 class="visually-hidden">댓글쓰기</h3>
        <form id="fviewcomment" name="fviewcomment" action="<?php echo $comment_action_url; ?>" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off" class="px-3 mb-3">
        <input type="hidden" name="w" value="<?php echo $w ?>" id="w">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
        <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
        <?php if($is_paging) { //페이징 ?>
            <input type="hidden" name="comment_url" value="" id="comment_url">
            <input type="hidden" name="cob" value="<?php echo $cob ?>">
        <?php } ?>
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>" id="comment_page">
        <input type="hidden" name="is_good" value="">

        <div class="p-2 bg-body-tertiary border rounded">
            <?php if ($is_guest) { ?>
                <div class="row g-2 mb-2">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-text" id="comment_name">
                                <i class="bi bi-person"></i>
                                <span class="visually-hidden">이름<strong> 필수</strong></span>
                            </span>
                            <input type="text" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" class="form-control" placeholder="이름" aria-label="이름" aria-describedby="comment_name" maxLength="20">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-text" id="comment_password">
                                <i class="bi bi-shield-lock"></i>
                                <span class="visually-hidden">비밀번호<strong> 필수</strong></span>
                            </span>
                            <input type="password" name="wr_password" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_password" class="form-control" placeholder="비밀번호" aria-label="비밀번호" aria-describedby="comment_password" maxLength="20">
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($comment_min || $comment_max) { ?>
                <div class="small mb-2" id="char_cnt">
                    현재 <b id="char_count">0</b>글자
                    /
                    <?php if($comment_min) { ?>
                        <?php echo number_format((int)$comment_min);?>글자 이상
                    <?php } ?>
                    <?php if($comment_max) { ?>
                        <?php echo number_format((int)$comment_max);?>글자 이하
                    <?php } ?>
                    등록 가능
                </div>
            <?php } ?>

            <style>
            #wr_content {
                height:92px; resize: none; overflow-y: hidden; }
            </style>
            <div class="mb-2">
                <script>
                    $(function () {
                        $("#fviewcomment textarea, .upload-file-area")
                        .on("dragenter", function (e) {
                            e.preventDefault();
                            e.stopPropagation();
                        }).on("dragover", function (e) {
                            e.preventDefault();
                            e.stopPropagation();
                            $('.upload-file-area').css("display", "flex");
                        }).on("dragleave", function (e) {
                            e.preventDefault();
                            e.stopPropagation();
                            if ($(this).hasClass('upload-file-area'))
                                $('.upload-file-area').css("display", "none");
                        }).on("drop", function (e) {
                            e.preventDefault();
                            var data = new FormData();
                            var files = e.originalEvent.dataTransfer.files;
                            data.append('bo_table', '<?php echo $bo_table ?>');
                            data.append('na_file', files[0]);

                            $.ajax({
                                type: 'POST',
                                url: '<?php echo NA_URL ?>/upload.image.php',
                                enctype : 'multipart/form-data',
                                dataType: 'json',
                                contentType: false,
                                processData: false,
                                data: data,
                                success: function (result) {
                                    $('.upload-file-area').css("display", "none");
                                    if(result.success) {
                                        parent.document.getElementById("wr_content").value += '[' + result.success + ']\n';
                                    } else {
                                        var chkErr = result.error.replace(/<[^>]*>?/g, '');
                                        if(!chkErr) {
                                            chkErr = '[E1]오류가 발생하였습니다.';
                                        }
                                        na_alert(chkErr);
                                        return false;
                                    }
                                },
                                error: function (request,status,error) {
                                    let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
                                    na_alert(msg);
                                    return false;
                                }
                            });
                        });
                    });
                </script>
                <div class="form-floating comment-textarea">
                    <div class="upload-file-area">
                        <div class="upload-file-over"></div>
                        <div class="icon-upload">
                            <i class="bi bi-upload"></i>
                        </div>
                        <div>여기에 파일을 놓아 업로드</div>
                    </div>
                    <textarea tabindex="1" placeholder="Leave a comment here" id="wr_content" name="wr_content" maxlength="10000" class="form-control lh-base"
                    <?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content;  ?></textarea>
                    <label id="wr_msg" for="wr_content">댓글을 입력해 주세요.</label>
                </div>
                <?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
            </div>

            <div class="d-flex align-items-center">
                <div>
                    <?php include_once(G5_THEME_PATH.'/app/clip.comment.php'); //댓글 버튼 모음 ?>
                </div>
                <div class="px-2">
                    <input type="checkbox" class="btn-check" name="wr_secret" value="secret" id="wr_secret" autocomplete="off">
                </div>
                <div class="ms-auto">
                    <button <?php echo ($is_paging) ? 'type="button" onclick="na_comment(\'viewcomment\');"' : 'type="submit"';?> class="btn btn-primary btn-sm" onKeyDown="na_comment_onKeyDown(<?php echo $is_paging?>);" id="btn_submit" title="댓글등록" tabindex="2">
                        <span class="d-none d-sm-inline-block">댓글</span>
                        등록
                    </button>
                </div>
            </div>
            <?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) {	?>
                <div  class="clearfix pt-2">
                    <div id="bo_vc_opt">
                        <ol id="bo_vc_sns">
                            <li id="bo_vc_send_sns"></li>
                        </ol>
                    </div>
                    <script>
                    // sns 등록
                    $(function() {
                        $("#bo_vc_send_sns").load("<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>", function() {
                            save_html = document.getElementById('bo_vc_w').innerHTML;
                        });
                    });
                    </script>
                </div>
            <?php } ?>
            <?php if ($is_guest) { ?>
                <div class="pt-2 text-center small border-top mt-2">
                    <?php echo $captcha_html; ?>
                </div>
            <?php } ?>
        </div>
        </form>
    </aside>
<?php } else { ?>
    <div id="bo_vc_login" class="alert alert-light mb-3 py-4 text-center mx-3" role="alert">
        <?php if($is_guest) { ?>
            <a href="<?php echo G5_BBS_URL ?>/login.php?wr_id=<?php echo $wr_id.$qstr ?>&amp;url=<?php echo urlencode(get_pretty_url($bo_table, $wr_id, $qstr).'#bo_vc_w') ?>">로그인한 회원만 댓글 등록이 가능합니다.</a>
        <?php } else { ?>
            댓글을 등록할 수 있는 권한이 없습니다.
        <?php } ?>
    </div>
<?php } ?>

<?php if ($is_comment_write) { ?>
    <script>
    var save_before = '';
    var save_html = document.getElementById('bo_vc_w').innerHTML;

    function good_and_write() {
        var f = document.fviewcomment;
        if (fviewcomment_submit(f)) {
            f.is_good.value = 1;
            f.submit();
        } else {
            f.is_good.value = 0;
        }
    }

    function fviewcomment_submit(f) {

        f.is_good.value = 0;

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": "",
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

        if (content) {
            na_alert("내용에 금지단어('"+content+"')가 포함되어있습니다", function() {
                f.wr_content.focus();
            });
            return false;
        }

        // 양쪽 공백 없애기
        var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
        document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
        if (char_min > 0 || char_max > 0) {
            check_byte('wr_content', 'char_count');
            var cnt = parseInt(document.getElementById('char_count').innerHTML);
            if (char_min > 0 && char_min > cnt) {
                na_alert("댓글은 최소 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            } else if (char_max > 0 && char_max < cnt) {
                na_alert("댓글은 쵀대 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        } else if (!document.getElementById('wr_content').value) {
            na_alert('댓글을 입력하여 주십시오.', function() {
                f.wr_content.focus();
            });
            return false;
        }

        if (typeof(f.wr_name) != 'undefined') {
            f.wr_name.value = f.wr_name.value.replace(pattern, "");
            if (f.wr_name.value == '') {
                na_alert('이름이 입력되지 않았습니다.', function() {
                    f.wr_name.focus();
                });
                return false;
            }
        }

        if (typeof(f.wr_password) != 'undefined') {
            f.wr_password.value = f.wr_password.value.replace(pattern, "");
            if (f.wr_password.value == '') {
                na_alert('비밀번호가 입력되지 않았습니다.', function() {
                    f.wr_password.focus();
                });
                return false;
            }
        }

        <?php if($is_guest) echo chk_captcha_js();  ?>

        set_comment_token(f);

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    function comment_box(comment_id, work, name) {
        var el_id,
            form_el = 'fviewcomment',
            respond = document.getElementById(form_el);

        // 댓글 아이디가 넘어오면 답변, 수정
        if (comment_id) {
            if (work == 'c')
                el_id = 'reply_' + comment_id;
            else
                el_id = 'edit_' + comment_id;
        } else
            el_id = 'bo_vc_w';

        if (save_before != el_id) {
            if (save_before) {
                document.getElementById(save_before).style.display = 'none';
            }

            document.getElementById(el_id).style.display = '';
            document.getElementById(el_id).appendChild(respond);
            //입력값 초기화
            document.getElementById('wr_content').value = '';

            // 댓글 수정
            if (work == 'cu') {
                document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
                if (typeof char_count != 'undefined')
                    check_byte('wr_content', 'char_count');
                if (document.getElementById('secret_comment_'+comment_id).value)
                    document.getElementById('wr_secret').checked = true;
                else
                    document.getElementById('wr_secret').checked = false;
            }

            document.getElementById('comment_id').value = comment_id;
            document.getElementById('w').value = work;

            if (comment_id && work == 'c') {
                document.getElementById('wr_msg').innerHTML = '<i class="bi bi-person-circle"></i> ' + name + '님에게 대댓글 쓰기';
            } else if(comment_id && work == 'cu') {
                document.getElementById('wr_msg').innerHTML = '<i class="bi bi-pencil-square"></i> ' + name + '님의 댓글 수정';
            } else {
                document.getElementById('wr_msg').innerHTML = '<i class="bi bi-chat-dots"></i> 댓글을 입력해 주세요.';
            }

            <?php if($is_paging) { //페이징 ?>
            if (comment_id) {
                document.getElementById('comment_page').value = document.getElementById('comment_page_'+comment_id).value;
                document.getElementById('comment_url').value = document.getElementById('comment_url_'+comment_id).value;
            } else {
                document.getElementById('comment_page').value = '';
                document.getElementById('comment_url').value = '<?php echo NA_URL ?>/comment.page.php?bo_table=<?php echo $bo_table;?>&wr_id=<?php echo $wr_id;?>';
            }
            <?php } ?>

            if(save_before)
                $("#captcha_reload").trigger("click");

            save_before = el_id;
        }
        $('.comment-textarea').find('textarea').keyup(); //댓글 수정 후, textarea height 자동조절
    }

    function comment_delete(url){
        na_confirm('이 댓글을 삭제하시겠습니까?', function() {
            location.href = url;
        });
        return false;
    }

    comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

    // 댓글 링크 복사
    function copy_comment_link(commentId) {
        if (commentId !== "") {
            var fullCommentLink = window.location.protocol
                + "//" + window.location.host
                + "/<?php echo $bo_table;?>/<?php echo $wr_id;?>#c_" + commentId;

            navigator.clipboard.writeText(fullCommentLink).then(() => {
                show_message("댓글 주소가 복사되었습니다");
            }).catch(error => {
                show_message("댓글 복사에 실패하였습니다. 유지관리 게시판에 에러메시지를 포함하여 신고 바랍니다." + error);
            });
        }
    }
    // 알림 메시지를 화면 중앙에 출력한다.
    function show_message(message) {
        var $message = $('<div class="semi-alert-message">' + message + '</div>');

        var msgStyle = `
        <style>
            .semi-alert-message {
                display: none;
                width: 205px;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #000;
                color: #fff;
                padding: 5px 10px;
                border-radius: 5px;
                z-index: 1000;
            }
        </style>`;
        $("head").append(msgStyle);
        $('body').append($message);

        $message.css({
            display: 'block'
        });

        setTimeout(() => {
            $message.fadeOut(500, function() {
                $(this).remove();
            });
        }, 1000);
    }

    $(function() {
        $('.comment-textarea').on('keyup', 'textarea', function (e){
            $(this).css('height', 'auto');

            $(this).height(this.scrollHeight - 22);
        });

        $('.comment-textarea').find('textarea').keyup();
    });
    </script>
<?php } ?>

<style>
    .da-commented-to {
        display: block;
        position: relative;
        top: -0.5rem;
        color: rgb(var(--bs-secondary-rgb));
        font-size: 0.875em;
        font-style: normal;
    }
</style>
