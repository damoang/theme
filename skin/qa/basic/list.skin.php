<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
if ($is_admin != 'super'){
    alert('자유게시판에 부탁드립니다.');}

?>

<div class="d-flex gap-3 align-items-center px-3 mb-2">
    <div class="d-none d-sm-block">
        <?php
            if ($stx)
                $htxt = '검색';
            else if ($sca)
                $htxt = $sca;
            else
                $htxt = '전체';

            echo $htxt;
        ?>
        <b><?php echo number_format((int)$total_count) ?></b> / <?php echo $page ?> 페이지
    </div>
    <div class="ms-auto">
        <a href="#qaSearch" data-bs-toggle="collapse" data-bs-target="#qaSearch" aria-expanded="false" aria-controls="qaSearch" class="text-body-tertiary">
            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="검색">
                <i class="bi bi-search"></i>
                <span class="visually-hidden">검색</span>
            </span>
        </a>
    </div>
    <?php if ($admin_href) {  ?>
        <div>
            <a href="#qaAdmin" data-bs-toggle="dropdown" aria-expanded="false" class="text-body-tertiary">
                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="관리자">
                    <i class="bi bi-gear-fill"></i>
                    <span class="visually-hidden">관리자</span>
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a href="<?php echo $admin_href ?>" class="dropdown-item">
                        <i class="bi bi-gear"></i>
                        문의 설정
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <label class="dropdown-item" for="allCheck">
                        <i class="bi bi-check2-square"></i>
                        전체 선택
                        <input class="visually-hidden" type="checkbox" id="allCheck" onclick="if (this.checked) all_checked(true); else all_checked(false);">
                    </label>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button class="dropdown-item" type="button" onclick="fqalist_submit('선택삭제');">
                        <i class="bi bi-trash"></i>
                        선택 삭제
                    </button>
                <li>
            </ul>
        </div>
    <?php } ?>
    <?php if ($write_href) { ?>
        <div>
            <a href="<?php echo $write_href ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil"></i>
                문의등록
            </a>
        </div>
    <?php } ?>
</div>

<div class="collapse<?php echo ($stx) ? ' show' : '';?>" id="qaSearch">
    <div class="px-3 py-2 border-top">
        <form name="fsearch" method="get">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">
            <div class="row g-2">
                <div class="col-4 col-sm-3">
                    <label for="qa_sfl" class="visually-hidden">검색대상</label>
                    <select id="qa_sfl" name="sfl" class="form-select form-select-sm">
                        <?php echo get_qa_sfl_select_options($sfl); ?>
                    </select>
                </div>
                <div class="col-8 col-sm-9">
                    <label for="bo_stx" class="visually-hidden">검색어 필수</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="stx" id="qa_stx" value="<?php echo stripslashes($stx) ?>" required placeholder="검색어 입력">
                        <a href="<?php echo G5_BBS_URL ?>/qalist.php" class="btn btn-basic" title="초기화">
                            <i class="bi bi-arrow-clockwise"></i>
                            <span class="visually-hidden">초기화</span>
                        </a>
                        <button class="btn btn-primary" type="submit" id="fsearch_submit" title="검색">
                            <i class="bi bi-search"></i>
                            <span class="d-none d-sm-inline-block">검색</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if ($category_option) {

    $category_href = G5_BBS_URL.'/qalist.php';

    $category_option = '';
    $ca_cnt = (isset($categories) && is_array($categories)) ? count($categories) : 0;
    for ($i=0; $i < $ca_cnt; $i++) {
        $category = trim($categories[$i]);
        if ($category=='')
            continue;

        $ca_active = $ca_current = '';

        // 현재 선택된 분류라면
        if($category==$sca) {
            $ca_active = ' active fw-bold" aria-current="page';
            $ca_current = '<span class="visually-hidden">현재 분류</span>';
        }
        $category_option .= '<li class="col nav-item"><a class="nav-link text-truncate py-0'.$ca_active.'" href="'.($category_href."?sca=".urlencode($category)).'">'.$ca_current.$category.'</a></li>'.PHP_EOL;
    }

?>
    <nav id="qa_category" class="border-top py-2">
        <ul class="nav row row-cols-3 row-cols-sm-4 row-cols-md-5 row-cols-lg-6 g-1 small">
            <li class="col nav-item">
                <a class="nav-link text-truncate py-0<?php echo $sca ? '' : ' active fw-bold" aria-current="page'; ?>" href="<?php echo G5_BBS_URL.'/qalist.php' ?>">전체	</a>
            </li>
            <?php echo $category_option ?>
        </ul>
    </nav>
<?php } ?>

<div id="qa_list">
    <form name="fqalist" id="fqalist" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="<?php echo get_text($token) ?>">

    <ul class="list-group list-group-flush line-top mb-4">
        <?php
        $list_cnt = count($list);
        for ($i=0; $i < $list_cnt; $i++) {

            $photo_img = '';
            for ($j=1; $j<=2; $j++) {
                if(preg_match("/\.({$config['cf_image_extension']})$/i", $list[$i]['qa_file'.$j])) {
                    $photo_img = na_thumb(G5_DATA_URL.'/qa/'.$list[$i]['qa_file'.$j], 60, 60);
                    break;
                }
            }

            if(!$photo_img) {
                $imgUrls = get_editor_image($list[$i]['qa_content'], false);
                $photo_img = isset($imgUrls[1][0]) ? na_thumb($imgUrls[1][0], 60, 60) : na_member_photo($list[$i]['mb_id']);
            }
        ?>
            <li class="list-group-item">
                <div class="d-flex align-items-center">
                    <div class="pe-2">
                        <img src="<?php echo $photo_img ?>" class="rounded-circle" style="max-width:50px;">
                    </div>
                    <div class="flex-grow-1">

                        <a href="<?php echo $list[$i]['view_href'] ?>">
                            <?php echo $list[$i]['subject'] ?>
                        </a>
                        <?php if ($list[$i]['category']) { ?>
                            <span class="badge text-body-tertiary px-1">
                                <?php echo $list[$i]['category'] ?>
                                <span class="visually-hidden">분류</span>
                            </span>
                        <?php } ?>
                        <?php if ($list[$i]['icon_file']) { ?>
                            <span class="na-icon na-file"></span>
                        <?php } ?>

                        <div class="form-text clearfix">
                            <span class="me-1<?php echo ($list[$i]['qa_status'] ? '' : 'orangered'); ?>">
                                <?php echo ($list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?>
                            </span>
                            <i class="bi bi-dot"></i>
                            <span class="visually-hidden">등록자</span>
                            <?php echo $list[$i]['name'] ?>

                            <div class="float-end">
                                <span class="visually-hidden">등록일</span>
                                <?php echo na_date($list[$i]['qa_datetime'], 'orangered', 'full') ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($is_checkbox) { ?>
                    <div class="ms-auto ps-3">
                        <input class="form-check-input me-1" type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
                        <label for="chk_qa_id_<?php echo $i ?>" class="visually-hidden">
                            <?php echo $list[$i]['subject'] ?>
                        </label>
                    </div>
                    <?php } ?>
                </div>
            </li>
        <?php } ?>
        <?php if (!$list_cnt) { ?>
            <li class="list-group-item text-center py-5">
                문의글이 없습니다.
            </li>
        <?php } ?>
        <li class="list-group-item">
            <ul class="pagination pagination-sm justify-content-center">
                <?php echo preg_replace('/(\.php)(&amp;|&)/i', '$1?', na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './qalist.php'.$qstr.'&amp;page='));?>
            </ul>
        </li>
    </ul>

    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(txt) {
    var f = document.fqalist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        na_alert(txt + '할 게시물을 하나 이상 선택하세요.');
        return false;
    }

    if(txt == "선택삭제") {
        let msg = '선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다.';
        na_confirm(msg, function() {
            var input = document.createElement('input');
 			input.type = 'hidden';
            input.name = 'btn_submit';
            input.value = '선택삭제';
            f.appendChild(input);
            f.removeAttribute("target");
            f.action = g5_bbs_url+"/qadelete.php";
            f.submit();
        });
        return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
