<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$nick = na_name_photo($mb['mb_id'], get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']));

$kind = isset($kind) ? $kind : 'recv';

if($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
}
else {
    $kind_str = "받는";
    $kind_date = "보낸";
}

include_once ($member_skin_path.'/memo_tab.skin.php');

?>

<ul class="list-group list-group-flush mb-4">
	<li class="list-group-item bg-body-tertiary">
		<div class="d-flex justify-content-end align-items-center small">
			<div class="me-auto">
				<span class="visually-hidden">작성자</span>
				<?php echo $nick ?>
			</div>
			<div>
				<span class="visually-hidden">작성일</span>
				<?php echo na_date($memo['me_send_datetime'], 'orangered', 'H:i', 'm.d H:i', 'Y.m.d H:i'); ?>
			</div>
		</div>
	</li>
	<li class="list-group-item" style="min-height:180px;">
		<?php echo na_content(conv_content($memo['me_memo'], 0)) ?>
	</li>
	<li class="list-group-item pb-4">
		<div class="d-flex align-items-center">
			<div class="me-auto">
				<div class="btn-group btn-group-sm" role="group">
				<?php if($prev_link) { ?>
					<a href="<?php echo $prev_link ?>" class="btn btn-basic btn-sm nofocus" title="이전 쪽지">
						<i class="bi bi-chevron-left"></i>
						<span class="visually-hidden">이전 쪽지</span>
					</a>
				<?php } ?>
				<?php if($next_link) { ?>
					<a href="<?php echo $next_link ?>" class="btn btn-basic btn-sm nofocus" title="다음 쪽지">
						<i class="bi bi-chevron-right"></i>
						<span class="visually-hidden">다음 쪽지</span>
					</a>
				<?php } ?>
				</div>
			</div>
			<div>
				<div class="btn-group btn-group-sm" role="group">
					<a href="<?php echo $del_link; ?>" onclick="del(this.href); return false;" class="btn btn-basic memo_del" title="삭제" role="button">
						<i class="bi bi-trash"></i>
						삭제
					</a>
					<?php if ($kind == 'recv') {  ?>
						<a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="btn btn-basic" role="button">
							<i class="bi bi-reply"></i>
							답장
						</a>  
					<?php } ?>
					<a href="./memo.php?kind=<?php echo $kind.$qstr;?>" class="btn btn-basic" title="목록" role="button">
						<i class="bi bi-list"></i>
						목록
					</a>
				</div>
			</div>
		</div>
	</li>
</ul>
