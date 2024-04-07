<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);

// 페이지 타이틀로 사용
// if ($himg_src)
// echo '<div id="faq_himg"><img src="'.$himg_src.'" alt="" class="img-fluid"></div>'.PHP_EOL;

// 상단 HTML
if ($fm['fm_head_html'])
echo '<div id="faq_hhtml">'.conv_content($fm['fm_head_html'], 1).'</div>'.PHP_EOL;

?>

<ul class="list-group list-group-flush mb-4">
	<li class="list-group-item border-0">
		<form name="faq_search_form" method="get" class="mx-auto" style="max-width:400px">
		<input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
			<div class="input-group">
				<input type="text" name="stx" value="<?php echo $stx; ?>" id="faq-stx" class="form-control" placeholder="검색어 입력">
				<button type="submit" class="btn btn-primary">
					<i class="bi bi-search"></i>
					<span class="visually-hidden">검색하기</span>
				</button>
			</div>
		</form>	
	</li>
	<li class="list-group-item border-0 px-0">
		<ul class="nav row row-cols-3 row-cols-sm-4 row-cols-md-5 row-cols-lg-6 g-1 small">
			<?php foreach($faq_master_list as $v){ ?>
				<li class="col nav-item">
					<a class="nav-link text-truncate py-0<?php echo ($v['fm_id'] == $fm_id) ? ' active fw-bold" aria-current="page' : ''; ?>" href="<?php echo $category_href;?>?fm_id=<?php echo $v['fm_id'];?>">
						<?php echo $v['fm_subject'];?>
					</a>
				</li>
			<?php } ?>
		</ul>	
	</li>
	<li class="list-group-item clearfix line-top bg-body-tertiary">
		<div class="d-flex gap-2 align-items-center">
			<div>
				전체	<b><?php echo number_format($total_count) ?></b> / <?php echo $page ?> 페이지	
			</div>
			<?php if($admin_href) { ?>
				<div class="ms-auto">
					<a href="<?php echo $admin_href ?>" class="float-end btn btn-basic btn-sm">
						<i class="bi bi-pencil-square"></i> FAQ 수정
					</a>
				</div>
			<?php } ?>
		</div>
	</li>
    <?php // FAQ 내용
    if(count($faq_list)){
		$i=0;
		foreach($faq_list as $key=>$v){
			if(empty($v))
				continue;

			$i++;
		?>
            <li class="list-group-item">
				<div class="d-flex align-items-center">
					<div class="pe-2">
						 <a data-bs-toggle="collapse" href="#faq-<?php echo $i?>">
							<i class="bi bi-question-circle fs-4"></i>
						</a>
					</div>
					<div>
						 <a data-bs-toggle="collapse" href="#faq-<?php echo $i?>">
			               	<?php echo conv_content($v['fa_subject'], 1); ?>
						</a>
					</div>
					<div class="ms-auto ps-2 text-body-tertiary">
						 <a data-bs-toggle="collapse" href="#faq-<?php echo $i?>">
							<i class="bi bi-chevron-compact-down fs-5"></i>
						</a>
					</div>
				</div>
				<div class="collapse" id="faq-<?php echo $i?>">
					<div class="border-top mt-2 pt-2">
	                    <?php echo conv_content($v['fa_content'], 1); ?>
					</div>
				</div>
            </li>
	<?php
		}
    } else {
        if($stx){
            echo '<li class="list-group-item text-center py-5">등록된 FAQ가 없습니다.">검색된 게시물이 없습니다.</li>';
        } else {
            echo '<li class="list-group-item text-center py-5">등록된 FAQ가 없습니다.';
            if($is_admin)
                echo '<div class="mt-2"><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.</div>';
            echo '</li>';
        }
    }
    ?>
	<li class="list-group-item">
		<ul class="pagination pagination-sm justify-content-center">
			<?php echo na_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
		</ul>	
	</li>
</ul>

<?php 
if ($fm['fm_tail_html'])
echo '<div id="faq_thtml" class="faq-html">'.conv_content($fm['fm_tail_html'], 1).'</div>'.PHP_EOL;

if ($timg_src)
echo '<div id="faq_timg" class="faq-img"><img src="'.$timg_src.'" alt="" class="img-fluid"></div>'.PHP_EOL;