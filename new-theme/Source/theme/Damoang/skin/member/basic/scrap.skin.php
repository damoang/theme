<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<ul class="list-group list-group-flush mb-4">
	<li class="list-group-item pt-3 line-bottom">
		전체 <b><?php echo number_format((int)$total_count) ?></b>건 / <?php echo $page ?>페이지
	</li>
    <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li class="list-group-item">
			<div class="d-flex align-items-center">
				<div class="flex-grow-1">
					<a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;">
						<?php echo $list[$i]['subject'] ?>
					</a>
					<div class="form-text clearfix">
						<a href="<?php echo $list[$i]['opener_href'] ?>" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;">
							<?php echo $list[$i]['bo_subject'] ?>
						</a>
						<div class="float-end">
							<?php echo $list[$i]['ms_datetime'] ?>
						</div>
					</div>
				</div>
				<div class="ps-3">
					<a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;" class="win-del" title="삭제">
						<i class="bi bi-trash fs-5 text-body-tertiary"></i>
						<span class="visually-hidden">삭제</span>
					</a>
				</div>
			</div>
        </li>
	<?php }  ?>
	<?php if ($i == 0) { ?>
		<li class="list-group-item text-center py-5">
			자료가 없습니다.
		</li>
	<?php } ?>
	<li class="list-group-item pb-4">
		<div class="d-flex justify-content-between align-items-center">
			<div class="pe-3">
				<ul class="pagination pagination-sm">
					<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?$qstr&amp;page="); ?>
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
