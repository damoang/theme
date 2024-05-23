<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>
<ul class="nav nav-tabs ps-3">
    <li class="nav-item">
        <a class="nav-link<?php echo ($is_read == "all") ? '  active" aria-current="page' : '';?>" href="<?php echo G5_BBS_URL ?>/noti.php">
            전체보기
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo ($is_read == "y") ? '  active" aria-current="page' : '';?>" href="<?php echo G5_BBS_URL ?>/noti.php?read=y">
            읽은알림
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo ($is_read == "n") ? '  active" aria-current="page' : '';?>" href="<?php echo G5_BBS_URL ?>/noti.php?read=n">
            안읽은알림
        </a>
    </li>
</ul>

<div class="position-relative line-top" style="margin-top:-1px;"></div>

<form id="fnotilist" name="fnotilist" method="post" action="#" onsubmit="return fnoti_submit(this);">
<input type="hidden" name="read"    value="<?php echo $read; ?>">
<input type="hidden" name="page"    value="<?php echo (int)$page; ?>">
<input type="hidden" name="token"    value="<?php echo $token; ?>">
<input type="hidden" name="pressed" value="">
<input type="hidden" name="p_type"	value="" id="p_type">

<ul class="list-group list-group-flush mb-4">
    <li class="list-group-item small bg-body-tertiary">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                전체 <b><?php echo number_format((int)$total_count) ?></b> / <?php echo $page ?> 페이지
            </div>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-basic dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    관리
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <button class="dropdown-item" type="button">
                            <label class="p-0 m-0" for="allCheck">
                                <i class="bi bi-check2-circle"></i>
                                전체선택
                            </label>
                            <div class="visually-hidden">
                                <input type="checkbox" id="allCheck" onclick="if (this.checked) all_checked(true); else all_checked(false);">
                            </div>
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" >
                            <i class="bi bi-trash"></i>
                            선택삭제
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="submit" name="btn_submit" value="읽음표시" onclick="document.pressed=this.value">
                            <i class="bi bi-eye"></i>
                            읽음표시
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="submit" name="btn_submit" value="전체삭제" onclick="document.pressed=this.value">
                            <i class="bi bi-x-circle"></i>
                            전체삭제
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <?php for($i=0; $i < $list_cnt; $i++) { ?>
        <li class="list-group-item">
            <div class="d-flex align-items-center">
                <div>
                    <img src="<?php echo na_member_photo($list[$i]['mb_id']); ?>" class="rounded-circle" style="max-width:50px;">
                </div>
                <div class="flex-grow-1 px-2">
                    <a href="<?php echo $list[$i]['href'] ?>">
                        <?php echo ($list[$i]['ph_readed'] == "Y") ? '' : '<span class="orangered">[읽기 전]</span> '; ?>
                        <?php echo $list[$i]['subject'] ?>
                    </a>
                    <div class="form-text">
                        <?php echo $list[$i]['wtime'] ?>
                        <?php echo $list[$i]['msg'] ?>
                    </div>
                </div>
                <div>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" role="switch" name="chk_bn_id[]" value="<?php echo $i ?>" id="chk_bn_id_<?php echo $i ?>">
                        <label class="form-check-label visually-hidden" for="chk_bn_id_<?php echo $i ?>"><?php echo $i ?>번</label>
                    </div>
                    <input type="hidden" name="chk_g_ids[<?php echo $i ?>]" value="<?php echo $list[$i]['g_ids'] ?>" >
                    <input type="hidden" name="chk_read_yn[<?php echo $i ?>]" value="<?php echo $list[$i]['ph_readed'] ?>" >
                </div>
            </div>
        </li>
    <?php } ?>
    <?php if (!$list_cnt) { ?>
        <div class="list-group-item text-center py-5">
            자료가 없습니다.
        </div>
    <?php } ?>
    <?php if(isset($nariya['noti_days']) && $nariya['noti_days']){ ?>
        <li class="list-group-item small bg-body-tertiary">
            <i class="bi bi-info-circle"></i>
            알림 내역은 <b><?php echo $nariya['noti_days'] ?></b>일 동안만 보관 됩니다.
        </li>
    <?php } ?>
    <li class="list-group-item">
        <ul class="pagination pagination-sm justify-content-center">
            <?php echo na_paging($page_rows, $page, $total_page,"{$_SERVER['PHP_SELF']}?$query_string&amp;page="); ?>
        </ul>
    </li>
</ul>

</form>

<script>
function all_checked(sw) {
    var f = document.fnotilist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bn_id[]")
            f.elements[i].checked = sw;
    }
}

function fnoti_submit(f) {

    if(document.pressed == "전체삭제") {
        na_confirm('모든 알림을 정말 삭제 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다', function() {
            $("#p_type").val("alldelete");
            $("#fnotilist").append('<input type="hidden" value="전체삭제" name="btn_submit">');
            f.removeAttribute("target");
            f.action = "<?php echo NA_URL ?>/noti.delete.php";
            f.submit();
        });
        return false;

    } else {
        var chk_count = 0;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
            chk_count++;
        }

        if (!chk_count) {
            na_alert(document.pressed + '할 알림을 하나 이상 선택하세요.');
            return false;
        }

        if(document.pressed == "읽음표시") {
            $("#p_type").val("read");
        }

        if(document.pressed == "선택삭제") {
            na_confirm('선택한 알림을 정말 삭제 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다', function() {
                $("#p_type").val("del");
                $("#fnotilist").append('<input type="hidden" value="선택삭제" name="btn_submit">');
                f.removeAttribute("target");
                f.action = "<?php echo NA_URL ?>/noti.delete.php";
                f.submit();
            });
            return false;
        }
    }

    f.action = "<?php echo NA_URL ?>/noti.delete.php";

    return true;
}
</script>
