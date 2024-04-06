<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<section id="qa_v_ans" class=" mb-4">
    <header>
		<h3 class="px-3 py-2 fs-6 lh-base bg-body-tertiary border-top border-bottom">
			<span class="badge bg-primary">A</span> <?php echo get_text($answer['qa_subject']); ?>
		</h3>
		<div class="d-flex align-items-center gap-2 px-3 small">
			<div>
				<i class="bi bi-alarm"></i>
				<?php echo na_date($answer['qa_datetime'], 'orangered', 'H:i', 'm.d H:i', 'Y.m.d H:i'); ?>
			</div>
			<div class="ms-auto">
				<?php if($answer_update_href) { ?>
				<a href="<?php echo $answer_update_href; ?>" class="btn btn-basic btn-sm" title="답변수정">
					<i class="bi bi-pencil-square"></i>
					<span class="d-none d-sm-inline-block">답변수정</span>
				</a>
				<?php } ?>
				<?php if($answer_delete_href) { ?>
					<a href="<?php echo $answer_delete_href; ?>" class="btn btn-basic btn-sm" onclick="del(this.href); return false;" title="답변삭제">
						<i class="bi bi-trash"></i>
						<span class="d-none d-sm-inline-block">답변삭제</span>
					</a>
				<?php } ?>	
			</div>
		</div>
	</header>
	
    <div id="ans_con" class="p-3 border-bottom">
		<?php
			// 파일 출력
			if($answer['img_count']) {
				echo '<div id="qa_v_img" class="text-center mb-3">'.PHP_EOL;
				for ($i=0; $i<$answer['img_count']; $i++) {
					echo str_replace('<img', '<img class="img-fluid"', get_view_thumbnail($answer['img_file'][$i], $qaconfig['qa_image_width']));
				}
				echo '</div>'.PHP_EOL;
			}
			
			echo get_view_thumbnail(conv_content($answer['qa_content'], $answer['qa_html']), $qaconfig['qa_image_width']); 
		?>
	</div>

	<ul class="list-group list-group-flush">
		<?php if(isset($answer['download_count']) && $answer['download_count']) { ?>
			<li class="list-group-item pb-1">
			<?php for ($i=0; $i<$answer['download_count']; $i++) { ?>
				<div class="d-flex align-items-center mb-1">
					<div class="me-2">
						<i class="bi bi-download"></i>
						<span class="visually-hidden">첨부</span>
					</div>
					<div class="text-truncate">
						<a href="<?php echo $answer['download_href'][$i] ?>" class="view_file_download" download>
							<?php echo $answer['download_source'][$i] ?>
						</a>
					</div>
				</div>
			<?php } ?>
			</li>
	    <?php } ?>
		<li class="list-group-item text-end">
			<a href="<?php echo $rewrite_href; ?>" class="btn btn-basic btn-sm" title="추가질문">
				<i class="bi bi-plus-lg"></i>
				추가질문
			</a>
		</li>
	</ul>
</section>
