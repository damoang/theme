<?php 
if (!defined('_GNUBOARD_')) { 
	include_once('./_common.php');

	$rows = 10; // 추출 갯수
	$thumb_w = 400; // 썸네일 크기
	include_once(NA_PATH.'/shop.itemqa.rows.php');
?>
	<ul class="list-group list-group-flush border-bottom">
		<li class="list-group-item line-bottom fw-bold">
			<i class="bi bi-chat-square-text"></i>
			상품문의 <span class="orangered"><?php echo number_format($total_count) ?></span> 개
			<a href="<?php echo shop_item_url($it_id) ?>#sit_qa" class="float-end fw-normal">
				더보기
			</a>		
		</li>
	</ul>
	<?php if($list_cnt) { ?>
		<div class="accordion accordion-flush border-bottom mb-3" id="itemqa-offcanvas">
		<?php 
		for ($i=0; $i < $list_cnt; $i++) { 
			$row = $list[$i];
			$img = $row['img'] ? na_thumb($row['img'], 100, 100) : '';

			// 신고 등 용도
			$uid = 'iqoc-'.$row['iq_id'];
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
		<?php } ?>
		</div>
	<?php } else { ?>
		<div class="border-bottom text-center py-5">
			상품문의가 없습니다.
		</div>
	<?php } ?>
<?php exit; } // end Ajax ?>

<style>
#iqOffcanvas .offcanvas-body img { max-width:100%; }
#iqOffcanvas .offcanvas-body p { padding:0; margin:0; /* 글에디터 줄간격 조절 */ }
</style>
<div class="offcanvas offcanvas-end" tabindex="-1" id="iqOffcanvas" aria-labelledby="iqOffcanvasLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="iqOffcanvasLabel">
			<?php echo $offcanvas_buttons ?>
		</h5>
		<button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body pt-0">
		<div id="iq-list"></div>
	</div>
</div>

<script>
function na_itemqa(it_id) {
	$('#iq-list').load('<?php echo LAYOUT_URL ?>/component/itemqa.offcanvas.php?it_id='+it_id);
	$('#iqOffcanvas').offcanvas('show');
}
</script>
