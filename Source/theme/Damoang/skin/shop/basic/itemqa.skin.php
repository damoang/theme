<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 썸네일 크기
$thumb_w = 600;

if ($total_count) { 
?>
	<div class="accordion accordion-flush border-bottom mb-3" id="itemqa-list">
	<?php 
	$num = $total_count - ($page - 1) * $rows;
	for ($i=0; $row=sql_fetch_array($result); $i++) {
			$row = na_iq_data($row, $thumb_w);
			$num = $num - $i;
			$img = $row['img'] ? na_thumb($row['img'], 100, 100) : '';

			// 신고 등 용도
			$uid = 'iq-'.$row['iq_id'];
	?>
		<div id="<?php echo $uid ?>" class="accordion-item">
			<div class="accordion-header">
				<a href="#item-<?php echo $uid ?>" class="accordion-button collapsed py-2" data-bs-toggle="collapse" data-bs-target="#item-<?php echo $uid ?>" aria-expanded="false" aria-controls="item<?php echo $uid ?>">
					<div class="d-flex gap-2 align-items-center">
						<div>
							<img src="<?php echo ($img) ? $img : na_member_photo($row['mb_id']); ?>" class="rounded-circle" style="max-width:50px;">
						</div>
						<div class="pe-2">
							<div class="small text-secondary lh-lg">
								<?php echo $row['answer'] ? '답변완료 ' : '<span class="orangered">답변대기</span>'; // 답변 ?>
								<i class="bi bi-pencil-square ms-1"></i>
								<?php echo $row['name'] ?>
							</div>
							<div>
								 <strong class="visually-hidden">문의 제목</strong>
								<?php echo $row['iq_secret'] ? '<span class="na-icon na-secret"></span>' : ''; // 비밀 ?>
								<?php echo $row['subject'] ?>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div id="item-<?php echo $uid ?>" class="accordion-collapse collapse">
				<div class="accordion-body">
					<div class="small mb-2">
						<?php echo na_date($row['iq_time'], 'orangered', 'Y.m.d H:i', 'Y.m.d H:i', 'Y.m.d H:i') ?>
					</div>
					<div class="mb-3">
						 <strong class="visually-hidden">문의 내용</strong>
						<?php echo $row['question'] ?> 
					</div>
					<div class="d-flex justify-content-end gap-2">
						<?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
							<a href="<?php echo $itemqa_form.'&amp;iq_id='.$row['iq_id'].'&amp;w=u' ?>" class="itemqa_form btn btn-basic btn-sm" onclick="return false;" title="수정">
								<i class="bi bi-pencil"></i>
								<span class="d-none d-sm-inline-block">수정</span>
							</a>
							<a href="<?php echo $itemqa_formupdate.'&amp;iq_id='.$row['iq_id'].'&amp;w=d&amp;hash='.$row['hash'] ?>" class="itemqa_delete btn btn-basic btn-sm" title="삭제">
								<i class="bi bi-trash"></i>
								<span class="d-none d-sm-inline-block">삭제</span>
							</a>
						<?php } ?>
						<?php if(!$row['iq_secret']) { ?>
							<button type="button" onclick="na_singo('<?php echo $row['it_id'] ?>', '<?php echo $row['iq_id'] ?>', '2', '<?php echo $uid ?>');" class="btn btn-basic btn-sm" title="신고">
								<i class="bi bi-eye-slash"></i>
								<span class="d-none d-sm-inline-block">신고</span>
							</button>
							<?php if($row['mb_id']) { // 회원만 가능 ?>
								<button type="button" onclick="na_chadan('<?php echo $row['mb_id'] ?>');" class="btn btn-basic btn-sm" title="차단">
									<i class="bi bi-person-slash"></i>
									<span class="d-none d-sm-inline-block">차단</span>
								</button>
							<?php } ?>
						<?php } ?>
					</div>

					<?php if($row['answer']) { // 답변 ?>
						<div class="d-flex border-top mt-2 pt-2">
							<div class="pe-2">
								<i class="bi bi-arrow-return-right"></i>
							</div>
							<div class="flex-grow-1">
								<strong class="visually-hidden">문의 답변</strong>
								<?php echo $row['answer'] ?>
							</div>	
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } // end for ?>
	</div>
	<ul class="pagination pagination-sm justify-content-center mb-0">
		<?php echo na_ajax_paging('itemqa', (G5_IS_MOBILE) ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, G5_SHOP_URL.'/itemqa.php?it_id='.$it_id.'&amp;page=') ?>
	</ul>

<?php } else { ?>
	<div class="text-center px-3 py-5">
		상품문의가 없습니다.
	</div>
<?php } ?>

<div class="d-flex justify-content-center align-items-center gap-2 p-3">
	<div>
		<a href="<?php echo $itemqa_form ?>" class="btn btn-primary itemuse_form">
			<i class="bi bi-question-circle"></i>
			상품문의 쓰기<span class="visually-hidden"> 새 창</span>
		</a>
	</div>
	<div>
		<a href="<?php echo $itemqa_list ?>" class="btn btn-basic">
			더보기
		</a>
	</div>
</div>

<?php
// 이하 내용 ajax에서 출력 안함
if(isset($iq_ajax) && $iq_ajax)
	return;
?>
<style>
#itemqa-list .accordion-body img { width:auto !important; max-width:100%; }
#itemqa-list .accordion-body p { padding:0; margin:0; }
</style>
<script>
$(function(){
    $(document).on('click', '.itemqa_form', function() {
        window.open(this.href, "itemqa_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(document).on('click', '.itemqa_delete', function() {
		var href = $(this).href;
		na_confirm('정말 삭제 하시겠습니까?\n\n삭제 후에는 되돌릴수 없습니다.', function() {
			location.href = href;
		});
		return false;
    });
});
</script>