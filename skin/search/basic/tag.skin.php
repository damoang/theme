<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css" media="screen">', 0);

?>

<form id="fsearch" name="fsearch" method="get" class="mx-auto mb-3 px-3" style="max-width:600px;">
<div class="row g-2">
    <div class="col-4">
        <label for="eq" class="visually-hidden">검색조건</label>
        <select name="eq" id="eq" class="form-select">
            <option value=""<?php echo get_selected($eq, "") ?>>포함</option>
            <option value="1"<?php echo get_selected($eq, "1") ?>>일치</option>
        </select>
    </div>
    <div class="col-8">
        <label for="new_mb_id" class="visually-hidden">검색어<strong class="visually-hidden"> 필수</strong></label>
        <div class="input-group">
            <input type="text" id="tag_stx" name="q" value="<?php echo stripslashes($q) ?>" required class="form-control" placeholder="태그 입력">
            <button type="submit" class="btn btn-primary" title="검색하기">
                <i class="bi bi-search"></i>
                <span class="visually-hidden">검색하기</span>
            </button>
        </div>
    </div>
</div>
</form>

<ul class="nav nav-tabs ps-3">
    <?php if($q) { ?>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="javascript:;">
                검색
            </a>
        </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link<?php echo (!$q && $sort == "") ? ' active" aria-current="page' : ''; ?>" href="./tag.php">
            최신
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo ($sort == "popular") ? ' active" aria-current="page' : ''; ?>" href="./tag.php?sort=popular">
            인기
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo ($sort == "index") ? ' active" aria-current="page' : ''; ?>" href="./tag.php?sort=index">
            색인
        </a>
    </li>
</ul>

<?php if(!$q && $is_admin == 'super') { ?>
<form id="tagform" name="tagform" method="post" onsubmit="return ftag_submit(this);">
<input type="hidden" name="sort" value="<?php echo $sort ?>">
<input type="hidden" name="opt" value="del">
<?php } ?>

<ul class="list-group list-group-flush line-top mb-4">
    <li class="list-group-item bg-body-tertiary">
        <div class="d-flex align-items-center">
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
    <?php if($q && $list_cnt) { //검색결과 ?>
        <li class="list-group-item">
            <ul class="list-group">
            <?php for($i=0; $i < $list_cnt; $i++) { ?>
                <li class="list-group-item border-left-0 border-right-0 px-3 py-2 py-md-2">
                    <div class="clearfix">
                        <a href="<?php echo $list[$i]['href'] ?>" class="float-left">
                            <strong><?php echo $list[$i]['subject'] ?></strong>

                            <?php if($list[$i]['comment']) { ?>
                                <span class="sr-only">댓글</span>
                                <span class="count-plus orangered">
                                    <?php echo $list[$i]['comment'] ?>
                                </span>
                            <?php } ?>
                        </a>
                        <a href="<?php echo $list[$i]['href'] ?>" target="_blank" class="float-left text-black-50 ml-2" title="새창으로 보기">
                            <i class="fa fa-window-restore" aria-hidden="true"></i>
                            <span class="sr-only">새창으로 보기</span>
                        </a>
                    </div>

                    <div class="clearfix f-de text-muted">
                        <?php echo $list[$i]['content'] ?>
                    </div>

                    <div class="clearfix f-sm text-muted">
                        <div class="float-right">
                            <span class="sr-only">등록자</span>
                            <?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']) ?>
                        </div>
                        <div class="float-left mr-3">
                            <span class="sr-only">등록일</span>
                            <?php echo na_date($list[$i]['wr_datetime'], 'orangered') ?>
                        </div>
                        <div class="float-left">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            <span class="sr-only">조회</span>
                            <?php echo $list[$i]['wr_hit'] ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
            </ul>
        </li>
    <?php } else if($list_cnt) { ?>
        <li class="list-group-item">

            <div class="row py-3 border-bottom">
                <div class="col-sm-4">
                <?php for($i=0; $i < $list_cnt; $i++) { ?>

                    <?php if($i > 0 && $list[$i]['is_sp']) { ?>
                        </div>
                    </div>
                    <div class="row py-3 border-bottom">
                        <div class="col-sm-4">
                    <?php } ?>

                    <?php if($list[$i]['is_sp']) {
                        switch($sort) {
                            case 'index'    : $tagbox_title = $list[$i]['idx']; break;
                            case 'popular'  : $tagbox_title = 'TOP '.$list[$i]['last']; break;
                            default         : $tagbox_title = date('M', $list[$i]['date']).' '.date('Y', $list[$i]['date']); break;
                        }
                    ?>

                            <h5 class="mb-2"><b><?php echo $tagbox_title;?></b></h5>
                        </div>
                        <div class="col-sm-8">
                    <?php } ?>
                        <div class="na-title float-left mb-2">
                            <div class="na-item">
                                <?php if($is_admin == 'super') { ?>
                                    <input type="checkbox" class="mb-0 mr-2" name="chk_id[]" value="<?php echo $i;?>">
                                    <input type="hidden" name="id[<?php echo $i;?>]" value="<?php echo $list[$i]['id'];?>">
                                <?php } ?>
                                <a href="<?php echo $list[$i]['href'] ?>" class="na-subject">
                                    <?php echo ($sort == 'popular') ? $list[$i]['rank'].'.' : '';?>
                                    #<?php echo $list[$i]['tag'];?>
                                </a>
                                <div class="na-info">
                                    <span class="sr-only">등록수</span>
                                    <span class="count-plus orangered">
                                        <?php echo $list[$i]['cnt'];?>
                                    </span>
                                </div>
                            </div>
                        </div>
                <?php } ?>
                </div>
            </div>

        </li>
    <?php } else { ?>
        <li class="list-group-item text-center py-5">자료가 없습니다.</li>
    <?php } ?>
    <li class="list-group-item">
        <ul class="pagination pagination-sm justify-content-center">
            <?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $list_page) ?>
        </ul>
    </li>
</ul>

<?php if(!$q && $is_admin == 'super') { ?>
</form>
<script>
    function ftag_submit(f) {

        var cnt = 0;
        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                cnt++;
        }

        if (!cnt) {
            alert("삭제할 태그를 하나 이상 선택하세요.");
            return false;
        }

        if (!confirm("태그 삭제시 색인과 로그 기록만 삭제되고, 글에 등록된 태그는 삭제되지 않습니다.\n\n선택한 태그를 정말 삭제 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
            return false;
        }

        f.action = "./tag.php";

        return true;
    }
</script>
<?php } ?>
