<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<style>
.singo-thumb { background-size: cover; background-position: center center; background-repeat: no-repeat; }
</style>
<ul class="list-group list-group-flush mb-4">
	<li class="list-group-item line-bottom">
		<div class="d-flex justify-content-between align-items-end">
			<div>
				전체 <b><?php echo number_format((int)$total_count) ?></b>건 / <?php echo $page ?>페이지
			</div>
			<div>
				<form>
					<select class="form-select form-select-sm" name="bo_select" onchange="location='./singo.php?bo_id='+this.value;">
						<option value="">전체보기</option>
						<?php for($i=0;$i<count($bo_list);$i++) { ?>
							<option value="<?php echo $bo_list[$i]['bo_table'] ?>"<?php echo get_selected($bo_id, $bo_list[$i]['bo_table']) ?>>
								<?php echo $bo_list[$i]['bo_subject'] ?>
							</option>
						<?php } ?>
					</select>
				</form>
			</div>
		</div>
	</li>
	<li class="list-group-item small bg-body-tertiary">
		<i class="bi bi-info-circle"></i>
		<?php if(IS_YC) { ?>
			게시물, 사용후기, 상품문의에 대해 최대 <b><?php echo NA_MAX_SINGO ?></b>개까지 신고할 수 있습니다.
		<?php } else { ?>
			게시물에 대해 최대 <b><?php echo NA_MAX_SINGO ?></b>개까지 신고할 수 있습니다.
		<?php } ?>
	</li>
	<li class="list-group-item pt-3 pb-0">
		<?php 
		for ($i=0; $i < count($list); $i++) {  
			$thumb = $list[$i]['img'] ? na_thumb($list[$i]['img'], 400, 0) : '';
			
		?>
			<div class="card mb-3">
				<div class="row row-cols-2 g-0">
					<div class="col-<?php echo $thumb ? 8 : 12; ?>">
						<div class="card-body">
							<h5 class="card-title">
								신고 사유 : <?php echo $list[$i]['reason'] ?>
							</h5>
							<p class="card-text mb-2">
								<small class="text-body-secondary">
									<?php echo $list[$i]['sg_time'] ?>
								</small>
							</p>
							<p class="card-text mb-3">
								<?php echo $list[$i]['content'] ?>
							</p>
							<a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;" class="win-del" title="삭제">
								<i class="bi bi-trash"></i> 삭제하기
							</a>
						</div>
					</div>
					<?php if ($thumb) { ?>
						<div class="col-4 singo-thumb" style="background-image: url('<?php echo $list[$i]['img'] ?>');">
							&nbsp;
						</div>
					<?php } ?>
				</div>
			</div>
		<?php }  ?>
		<?php if ($i == 0) { ?>
			<div class="text-center py-5 mb-3">
				신고 자료가 없습니다.
			</div>
		<?php } ?>
	</li>
	<li class="list-group-item pb-4">
		<div class="d-flex justify-content-between align-items-center">
			<div class="pe-3">
				<ul class="pagination pagination-sm">
					<?php echo na_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?".$bo_qstr."page="); ?>
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
