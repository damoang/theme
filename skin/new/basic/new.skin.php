<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$new_skin_url.'/style.css">', 0);
?>

<form id="fsearch" name="fnew" method="get" class="px-3 mb-3 mx-auto" style="max-width:600px;">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <div class="row g-2">
        <div class="col-6 col-md-3">
            <label for="sfl" class="visually-hidden">게시판그룹</label>
            <?php echo str_replace('id="gr_id"', 'id="gr_id" class="form-select"', $group_select) ?>
        </div>
        <div class="col-6 col-md-3">
            <label for="view" class="visually-hidden">검색대상</label>
            <select name="view" id="view" class="form-select">
                <option value="">전체 게시물
                <option value="w">원글만
                <option value="c">댓글만
            </select>
        </div>
        <div class="col-12 col-md-6">
            <label for="new_mb_id" class="visually-hidden">검색어<strong class="visually-hidden"> 필수</strong></label>
            <div class="input-group">
                <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="new_mb_id" class="form-control" placeholder="회원아이디 검색만 가능">
                <button type="submit" class="btn btn-primary" title="검색하기">
                    <i class="bi bi-search"></i>
                    <span class="visually-hidden">검색하기</span>
                </button>
            </div>
        </div>
    </div>
</form>
<script>
document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
document.getElementById("view").value = "<?php echo $view ?>";
</script>

<?php if ($is_admin) { ?>
<form id="fnewlist" name="fnewlist" method="post" onsubmit="return fnew_submit(this);">
    <input type="hidden" name="sw"       value="move">
    <input type="hidden" name="view"     value="<?php echo $view; ?>">
    <input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
    <input type="hidden" name="stx"      value="<?php echo $stx; ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
    <input type="hidden" name="page"     value="<?php echo $page; ?>">
    <input type="hidden" name="pressed"  value="">
<?php } ?>

    <style>
#fnewlist .profile_img {
    display:none; }
</style>

    <ul class="list-group list-group-flush line-top">
    <li class="list-group-item bg-body-tertiary">
        <div class="d-flex gap-2 align-items-center">
            <div>
                전체 <b><?php echo number_format($total_count) ?></b> / <?php echo $page ?> 페이지
            </div>
            <?php if($is_admin) { ?>
            <div class="btn-group btn-group-sm ms-auto">
                <button type="submit" onclick="document.pressed=this.value" value="선택삭제" class="btn btn-basic nofocus" id="btn_submit">
                    <i class="bi bi-trash"></i>
                    삭제
                </button>
                <label class="btn btn-basic nofocus" for="allCheck">
                    <i class="bi bi-check2-square"></i>
                    선택
                    <input class="visually-hidden" type="checkbox" id="allCheck" onclick="if (this.checked) all_checked(true); else all_checked(false);">
                </label>
            </div>
            <?php } ?>
        </div>
    </li>
    <?php
        $list_cnt = count($list);
        $page_rows = (G5_IS_MOBILE) ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
        for ($i=0; $i < $list_cnt; $i++) {

            //이미지
            $new_img = na_check_img($list[$i]['wr_10']);
            $new_img =($new_img) ? na_thumb($new_img, 60, 60) : na_member_photo($list[$i]['mb_id']);

            $num = $total_count - ($page - 1) * $page_rows - $i;
            $gr_subject = get_text($list[$i]['gr_subject']);
            $bo_subject = get_text($list[$i]['bo_subject']);
            $wr_subject = get_text($list[$i]['wr_subject']);
        ?>
        <li class="list-group-item">
            <div class="d-flex align-items-center">
                <div class="pe-2">
                    <img src="<?php echo $new_img ?>" class="rounded-circle" style="max-width:50px;">
                </div>
                <div class="flex-grow-1">
                    <?php if($list[$i]['comment']) { ?>
                        <a href="<?php echo $list[$i]['href'] ?>">
                            [댓글] <?php echo $list[$i]['wr_subject'] ?>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo $list[$i]['href'] ?>">
                            <?php echo $list[$i]['wr_subject'] ?>
                        </a>
                        <?php if($list[$i]['wr_comment']) { ?>
                            <span class="visually-hidden">댓글</span>
                            <span class="count-plus orangered">
                                <?php echo $list[$i]['wr_comment'] ?>
                            </span>
                        <?php } ?>
                    <?php } ?>

                    <div class="form-text clearfix">
                        <span class="visually-hidden">등록자</span>
                            <?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']); ?>
                        <a href="<?php echo get_pretty_url($list[$i]['bo_table']); ?>">
                            <i class="bi bi-dot text-body-tertiary"></i><?php echo $bo_subject ?>
                        </a>
                        <div class="float-end" title="<?= get_text($list[$i]['wr_datetime']) ?>">
                            <span class="visually-hidden">등록일</span>
                            <?php echo na_date($list[$i]['wr_datetime'], 'orangered') ?>
                        </div>
                    </div>
                </div>
                <?php if ($is_admin) { ?>
                    <div class="ms-auto ps-3">
                        <input class="form-check-input me-1" type="checkbox" name="chk_bn_id[]" value="<?php echo $i ?>" id="chk_bn_id_<?php echo $i ?>">
                        <label for="chk_wr_id_<?php echo $i ?>" class="visually-hidden">
                                <?php echo $num?>번
                        </label>
                        <input type="hidden" name="bo_table[<?php echo $i ?>]" value="<?php echo $list[$i]['bo_table'] ?>">
                        <input type="hidden" name="wr_id[<?php echo $i ?>]" value="<?php echo $list[$i]['wr_id'] ?>">
                    </div>
                <?php } ?>
            </div>

        </li>
    <?php }  ?>
    <?php if (!$list_cnt) { ?>
    <li class="list-group-item text-center py-5">게시물이 없습니다.</li>
    <?php } ?>
    <li class="list-group-item">
        <ul class="pagination pagination-sm justify-content-center">
            <?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id=$gr_id&amp;view=$view&amp;mb_id=$mb_id&amp;page="); ?>
        </ul>
    </li>
</ul>

<?php if ($is_admin) { ?>
</form>

<script>
function all_checked(sw) {
    var f = document.fnewlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bn_id[]")
            f.elements[i].checked = sw;
    }
}
function fnew_submit(f)	{
    f.pressed.value = document.pressed;

    var cnt = 0;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
            cnt++;
    }

    if (!cnt) {
        na_alert(document.pressed + '할 게시물을 하나 이상 선택하세요.');

        return false;
    }

    if(document.pressed == "선택삭제") {
        na_confirm('선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다.', function() {
            $("#fnewlist").append('<input type="hidden" value="선택삭제" name="btn_submit">');
            f.action = "./new_delete.php";
            f.submit();
        });
    }
    return false;
}
</script>
<?php } ?>
