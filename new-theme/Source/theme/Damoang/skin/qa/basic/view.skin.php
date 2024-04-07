<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);

?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<article id="qa_v" class="mb-4">
    <header>
		<h2 id="qa_v_title" class="px-3 my-2 fs-4 lh-base">
			<?php echo $view['subject']; // 글제목 출력 ?>
		</h2>
    </header>

	<section id="qa_v_info">
        <h3 class="visually-hidden">페이지 정보</h3>
		<div class="d-flex justify-content-end align-items-center line-top border-bottom bg-body-tertiary py-2 px-3 small">
			<div class="me-auto">
				<span class="visually-hidden">작성자</span>
				<?php if($is_admin) { ?>
					<?php echo na_name_photo($view['mb_id'], get_sideview($view['mb_id'], $view['name'], $view['qa_email'], '')) ?>
				<?php } else { ?>
					<?php echo $view['name'] ?>
				<?php } ?>
			</div>
			<div>
				<span class="visually-hidden">작성일</span>
				<?php echo na_date($view['qa_datetime'], 'orangered', 'H:i', 'm.d H:i', 'Y.m.d H:i'); ?>
			</div>
		</div>

		<div class="d-flex align-items-center gap-2 pt-2 px-3 small">
			<?php if($view['email']) { ?>
				<div>
					<button type="button" class="btn btn-basic btn-sm" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php echo $view['email'] ?>">
						<span class="visually-hidden">이메일</span>
						<i class="bi bi-envelope-at"></i>
					</button>
				</div>
			<?php } ?>
			<?php if($view['hp']) { ?>
				<div>
					<button type="button" class="btn btn-basic btn-sm" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php echo $view['hp'] ?>">
						<span class="visually-hidden">휴대폰</span>
						<i class="bi bi-telephone"></i>
					</button>
				</div>
			<?php } ?>
			<?php if ($view['category']) { ?>
				<div>
					<i class="bi bi-book"></i>
					<?php echo $view['category'] ?>
					<span class="visually-hidden">분류</span>
				</div>
			<?php } ?>
			<div class="ms-auto">
				<?php ob_start(); ?>
				<a href="<?php echo $list_href ?>" class="btn btn-basic btn-sm" title="목록">
					<i class="bi bi-list"></i>
					<span class="d-none d-sm-inline-block">목록</span>
				</a>
				<?php if ($update_href) { ?>
					<a href="<?php echo $update_href ?>" class="btn btn-basic btn-sm" title="수정">
							<i class="bi bi-pencil-square"></i>
							<span class="d-none d-sm-inline-block">수정</span>
					</a>
				<?php } ?>
				<?php if ($delete_href) { ?>
					<a href="<?php echo $delete_href ?>" class="btn btn-basic btn-sm" title="삭제">
						<i class="bi bi-trash"></i>
						<span class="d-none d-sm-inline-block">삭제</span>
					</a>
				<?php } ?>
				<?php if ($write_href) { ?>
					<a href="<?php echo $write_href ?>" class="btn btn-primary btn-sm"록 title="쓰기">
						<i class="bi bi-pencil"></i>
						<span class="d-none d-sm-inline-block">문의등록</span>
					</a>
				<?php } ?>
				<?php
				$link_buttons = ob_get_contents();
				ob_end_flush();
				?>
			</div>
		</div>
    </section>

    <section id="qa_v_atc" class="border-bottom p-3">
		<h3 class="visually-hidden">본문</h3>
		<div id="qa_v_con">
			<?php
			// 파일 출력
			if($view['img_count']) {
				echo '<div id="qa_v_img" class="text-center mb-3">'.PHP_EOL;
				for ($i=0; $i<$view['img_count']; $i++) {
					//echo $view['img_file'][$i];
					echo str_replace('<img', '<img class="img-fluid"', get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']));
				}
				echo '</div>'.PHP_EOL;
			}
			?>
			<!-- 본문 내용 시작 { -->
	        <div id="qa_v_con">
				<?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?>
			</div>
		    <!-- } 본문 내용 끝 -->

			<?php if($view['qa_type']) { ?>
		        <div id="qa_v_addq" class="pt-3">
					<a href="<?php echo $rewrite_href; ?>" class="btn btn-basic btn-sm" title="추가질문">
						<i class="bi bi-plus-lg"></i>
						추가질문
					</a>
				</div>
	        <?php } ?>
		</div>
	</section>

	<?php if($view['download_count']) { ?>
	<section id="qa_v_data">
		<ul class="list-group list-group-flush border-bottom">
			<li class="list-group-item pb-1">
			<?php for ($i=0; $i<$view['download_count']; $i++) { ?>
				<div class="d-flex align-items-center mb-1">
					<div class="me-2">
						<i class="bi bi-download"></i>
						<span class="visually-hidden">첨부</span>
					</div>
					<div class="text-truncate">
						<a href="<?php echo $view['download_href'][$i] ?>" class="view_file_download" download>
							<?php echo $view['download_source'][$i] ?>
						</a>
					</div>
				</div>
			<?php } ?>
			</li>
		</ul>
	</section>
	<?php } ?>

	<div class="d-flex align-items-center gap-2 px-3 pt-2 mb-4">
		<?php if($prev_href) { ?>
			<div>
				<a href="<?php echo $prev_href ?>" class="btn btn-basic btn-sm" title="이전글">
					<i class="bi bi-chevron-left"></i>
					<span class="d-none d-sm-inline-block">이전글</span>
				</a>	
			</div>
		<?php } ?>
		<?php if($next_href) { ?>
			<div>
				<a href="<?php echo $next_href ?>" class="btn btn-basic btn-sm" title="다음글">
					<span class="d-none d-sm-inline-block">다음글</span>
					<i class="bi bi-chevron-right"></i>
				</a>	
			</div>
		<?php } ?>
		<div class="ms-auto">
			<?php echo $link_buttons; // 버튼 출력 ?>
		</div>
	</div>

	<?php
    // 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
    if(!$view['qa_type']) {
        if($view['qa_status'] && $answer['qa_id'])
            include_once($qa_skin_path.'/view.answer.skin.php');
        else
            include_once($qa_skin_path.'/view.answerform.skin.php');
    }
    ?>

    <?php if($view['rel_count']) { ?>
    <section id="qa_v_rel">
		<ul class="list-group list-group-flush">
			<li class="list-group-item">
		        <h3 class="m-0 fs-5">
					<i class="bi bi-diagram-3"></i>
					연관질문
				</h3>
			</li>
			<?php for($i=0; $i<$view['rel_count']; $i++) { ?>
			<li class="list-group-item">
				<div class="d-flex align-items-center text-body-tertiary">
					<div class="me-2 small">
						<?php echo ($rel_list[$i]['qa_status'] ? '답변완료' : '<span class="orangered">답변대기</span>'); ?>
					</div>
					<div>
	                    <a href="<?php echo $rel_list[$i]['view_href']; ?>">
		                    <?php echo $rel_list[$i]['subject'] ?>
			            </a>
					</div>
					<div class="ms-auto small">
						<?php echo $rel_list[$i]['date'] ?>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
    </section>
    <?php } ?>

</article>
<!-- } 게시판 읽기 끝 -->

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 이미지 리사이즈
    $("#qa_v_atc").viewimageresize();
});
</script>