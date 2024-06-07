<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$kind = isset($kind) ? $kind : 'recv';

include_once ($member_skin_path.'/memo_tab.skin.php');

?>

<style>
.mb-photo {
    display:none; }

.memo-photo img {
    max-width: 50px; }
</style>

<ul class="list-group list-group-flush mb-4">
    <li class="list-group-item bg-body-tertiary small">
        전체 <?php echo $kind_title ?> 쪽지 <b><?php echo $total_count ?></b>통 / <?php echo $page ?>페이지
    </li>
    <?php
    $list_cnt = count($list);
    for ($i=0; $i < $list_cnt; $i++) {
        $readed = (substr($list[$i]['me_read_datetime'],0,1) == 0) ? '' : 'read';
        $memo_preview = utf8_strcut(strip_tags($list[$i]['me_memo']), 30, '...');
    ?>
        <li class="list-group-item">
            <div class="d-flex align-items-center">
                <div class="pe-2 memo-photo">
                    <img src="<?php echo na_member_photo($list[$i]['mb_id']); ?>" class="rounded-circle">
                </div>
                <div class="flex-grow-1">
                    <div class="text-truncate mb-1">
                        <a href="<?php echo $list[$i]['view_href']; ?>">
                            <?php echo ($readed) ? '' : '<span class="orangered">[미확인]</span>';?>
                            <?php echo $memo_preview; ?>
                        </a>
                    </div>
                    <div class="clearfix small">
                        <?php echo na_name_photo($list[$i]['mb_id'], $list[$i]['name']) ?>
                        <div class="float-end">
                            <?php echo na_date($list[$i]['send_datetime'], 'orangered', 'full'); ?>
                        </div>
                    </div>
                </div>
                <div class="ps-3">
                    <a href="<?php echo $list[$i]['del_href'] ?>" onclick="del(this.href); return false;" class="win-del" title="삭제">
                        <i class="bi bi-trash fs-5 text-body-tertiary"></i>
                        <span class="visually-hidden">삭제</span>
                    </a>
                </div>
            </div>
        </li>
    <?php } ?>
    <?php if (!$list_cnt) { ?>
        <li class="list-group-item py-5 text-center">
            <?php echo $kind_title ?> 쪽지가 없습니다.
        </li>
    <?php } ?>
    <?php if($config['cf_memo_del']){ ?>
        <li class="list-group-item bg-body-tertiary small">
            <?php echo $kind_title ?> 쪽지 보관일수는 최장 <strong><?php echo $config['cf_memo_del'] ?></strong>일 입니다.
        </li>
    <?php } ?>
    <li class="list-group-item pb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="pe-3">
                <ul class="pagination pagination-sm">
                    <?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "./memo.php?kind=$kind".$qstr."&amp;page=") ?>
                </ul>
            </div>
            <div>
                <button type="button" class="btn btn-basic btn-sm" onclick="window.close();">
                    <i class="bi bi-x-lg"></i>
                    <span class="d-none d-sm-inline-block">창닫기</span>
                </button>
            </div>
        </div>
    </li>
</ul>
