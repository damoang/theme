<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 썸네일 크기
$thumb_w = 600;

if ($total_count) { 
?>
	<div class="accordion accordion-flush border-bottom mb-3" id="itemuse-list">
	<?php 
	$num = $total_count - ($page - 1) * $rows;
	for ($i=0; $row=sql_fetch_array($result); $i++) {
			$row = na_is_data($row, $thumb_w);
			$num = $num - $i;
			$img = $row['img'] ? na_thumb($row['img'], 100, 100) : '';

			// 신고 등 용도
			$uid = 'is-'.$row['is_id'];
	?>
		<div id="<?php echo $uid ?>" class="accordion-item">
			<div class="accordion-header">
				<a href="#item-<?php echo $uid ?>" class="accordion-button collapsed py-2" data-bs-toggle="collapse" data-bs-target="#item-<?php echo $uid ?>" aria-expanded="false" aria-controls="itemuse<?php echo $i ?>">
					<div class="d-flex align-items-center">
						<div>
							<img src="<?php echo ($img) ? $img : na_member_photo($row['mb_id']); ?>" class="rounded-circle" style="max-width:50px;">
						</div>
						<div class="px-2">
							<div class="small text-secondary lh-lg">
								<span class="text-primary">
									<?php echo $row['star'] ?>
									<strong class="visually-hidden">별 <?php echo $row['star_score'] ?> 개</strong>
								</span>
								<i class="bi bi-chat-square-text ms-2"></i>
								<?php echo $row['name'] ?>
							</div>
							<div>
								<strong class="visually-hidden">후기 제목</strong>
								<?php echo $row['subject'] ?>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div id="item-<?php echo $uid ?>" class="accordion-collapse collapse">
				<div class="accordion-body">
					<div class="small mb-2">
						<?php echo na_date($row['is_time'], 'orangered', 'Y.m.d H:i', 'Y.m.d H:i', 'Y.m.d H:i') ?>
					</div>
					<div class="mb-3">
						<strong class="visually-hidden">후기 내용</strong>
						<?php echo $row['content'] ?> 
					</div>
					<div class="d-flex justify-content-end gap-2">
						<?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
							<a href="<?php echo $itemuse_form.'&amp;is_id='.$row['is_id'].'&amp;w=u' ?>" class="itemuse_form btn btn-basic btn-sm" onclick="return false;" title="수정">
								<i class="bi bi-pencil"></i>
								<span class="d-none d-sm-inline-block">수정</span>
							</a>
							<a href="<?php echo $itemuse_formupdate.'&amp;is_id='.$row['is_id'].'&amp;w=d&amp;hash='.$row['hash'] ?>" class="itemuse_delete btn btn-basic btn-sm" title="삭제">
								<i class="bi bi-trash"></i>
								<span class="d-none d-sm-inline-block">삭제</span>
							</a>
						<?php } ?>
						<button type="button" onclick="na_singo('<?php echo $row['it_id'] ?>', '<?php echo $row['is_id'] ?>', '1', '<?php echo $uid ?>');" class="btn btn-basic btn-sm" title="신고">
							<i class="bi bi-eye-slash"></i>
							<span class="d-none d-sm-inline-block">신고</span>
						</button>
						<?php if($row['mb_id']) { // 회원만 가능 ?>
							<button type="button" onclick="na_chadan('<?php echo $row['mb_id'] ?>');" class="btn btn-basic btn-sm" title="차단">
								<i class="bi bi-person-slash"></i>
								<span class="d-none d-sm-inline-block">차단</span>
							</button>
						<?php } ?>
					</div>

					<?php if($row['re_subject']) { // 답변 ?>
						<div class="d-flex border-top mt-2 pt-2">
							<div class="pe-2">
								<i class="bi bi-arrow-return-right"></i>
							</div>
							<div class="flex-grow-1">
								<strong class="visually-hidden">후기 답변</strong>
								<?php
									// echo $row['re_subject'];
									// echo $row['re_name']

									// 답변 내용만 출력함
									echo $row['re_content']
								?>
							</div>	
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } // end for ?>
	</div>
	<ul class="pagination pagination-sm justify-content-center mb-0">
		<?php echo na_ajax_paging('itemuse', (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, G5_SHOP_URL.'/itemuse.php?it_id='.$it_id.'&amp;page='); ?>
	</ul>

<?php } else { ?>
	<div class="text-center px-3 py-5">
		사용후기가 없습니다.
	</div>
<?php } ?>

<div class="d-flex justify-content-center align-items-center gap-2 p-3">
	<div>
		<a href="<?php echo $itemuse_form ?>" class="btn btn-primary itemuse_form">
			<i class="bi bi-chat-square-text"></i>
			사용후기 쓰기<span class="visually-hidden"> 새 창</span>
		</a>
	</div>
	<div>
		<a href="<?php echo $itemuse_list ?>" class="btn btn-basic">
			더보기
		</a>
	</div>
</div>

<?php
// 이하 내용 ajax에서 출력 안함
if(isset($is_ajax) && $is_ajax)
	return;
?>
<style>
#itemuse-list .accordion-body img { width:auto !important; max-width:100%; }
#itemuse-list .accordion-body p { padding:0; margin:0; }
</style>
<script>
$(function(){
    $(document).on('click', '.itemuse_form', function() {
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(document).on('click', '.itemuse_delete', function() {
		var href = $(this).href;
		na_confirm('정말 삭제 하시겠습니까?\n\n삭제 후에는 되돌릴수 없습니다.', function(){
			location.href = href;
		});
		return false;
    });
});
</script>