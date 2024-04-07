<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

// 큰이미지 개수
$big_rows = 1;

// 큰이미지 영역 및 썸네일 크기 설정
$big_thumb_width = 400;
$big_thumb_height = 250;

if($big_thumb_width && $big_thumb_height) {
	$big_img_height = ($big_thumb_height / $big_thumb_width) * 100;
} else {
	$big_img_height = '56.25';
}

// 큰이미지 제목줄
$big_subject_line = 2;
$big_subject_height = 26 * $big_subject_line + 2;

// 큰이미지 글내용 길이
$big_cut_txt = 150;

// 작은이미지 영역 및 썸네일 크기 설정
$thumb_width = 300;
$thumb_height = 230;

if($thumb_width && $thumb_height) {
	$img_height = ($thumb_height / $thumb_width) * 100;
} else {
	$img_height = '56.25';
}

// 작은이미지 크기 설정(sm|md)
$mix_img_size = 'sm';

// 작은이미지 제목줄
$subject_line = 2;
$subject_height = 22 * $subject_line + 2;

// 작은이미지 글내용 길이
$cut_txt = 40;

// 작은이미지 글내용 출력(true:출력|false:숨김)
$is_content = false;

// 배경색상 랜덤
$bg_red = array("bg-red", "bg-orangered", "bg-green", "bg-blue", "bg-purple", "bg-yellow", "bg-navy");

// 추출개수
$list_count = (is_array($list) && $list) ? count($list) : 0;

// 랜덤(true:출력|false:숨김)
$is_rand = true;
if(isset($is_rand) && $is_rand && $list_count)
	shuffle($list);
?>
<style>

</style>
<div class="pic_mix_lt3">
    <h2 class="lat_title"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a></h2>

	<div class="pic_mix_lt3_row">
		<div class="pic_mix_lt3_col">
			<?php
			for ($i=0; $i<$big_rows; $i++) {

				$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $big_thumb_width, $big_thumb_height, false, true);

				if($thumb['src']) {
					$img = $thumb['src'];
				} else {
					$img = G5_IMG_URL.'/no_img.png';
					$thumb['alt'] = '이미지가 없습니다.';
				}
				$img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
				$wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);

				if ($list[$i]['icon_secret']){
					$list[$i]['subject'] = "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> " . $list[$i]['subject'];
				}

				if ($list[$i]['is_notice'])
					$list[$i]['subject'] = "<strong>".$list[$i]['subject']."</strong>";

			?>
			<div class="post-big-style">

				<div class="mix-row">
					<div class="mix-img mix-img-lg">
						<div class="img-wrap post-thumb img-hover-scale thumb-overlay" style="padding-bottom:<?php echo $big_img_height ?>%;">
							<div class="img-item">
								<a href="<?php echo $wr_href; ?>">
									<?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?>
								</a>
								<?php if($list[$i]['ca_name']){ ?>
								<div class="post-content-overlay entry-meta meta-0 transition-ease-04">
									<a href="<?php echo $wr_href; ?>"><span class="post-cat <?php echo $bg_red[rand(0, 6)];?>"><?php echo $list[$i]['ca_name'];?></span></a>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="mix-body">
						<div class="mix-info">
							<?php if($list[$i]['ca_name']){ ?>
							<div class="entry-meta meta-0" style="margin-bottom: 1rem !important;">
								<a href="<?php echo $wr_href; ?>"><span class="post-cat <?php echo $bg_red[rand(0, 6)];?>"><?php echo $list[$i]['ca_name'];?></span></a>
							</div>
							<?php } ?>
							<div class="title" style="margin-top: 0.5rem !important;">
								<div class="item">
									<a href="<?php echo $wr_href; ?>" class="post-title" style="height:<?php echo $big_subject_height;?>px;">
										<?php echo $list[$i]['subject'] ?>
									</a>
									<?php
									if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
									if ($list[$i]['icon_hot']) echo "<span class=\"hot_icon\">H<span class=\"sound_only\">인기글</span></span>";
									?>
								</div>
							</div>
							<div class="entry-meta meta-1" style="margin-top: 0.5rem !important;margin-bottom: 0.5rem !important;">
								<span class="post-on"><i class="fa fa-clock-o"></i> <?php echo $list[$i]['datetime2'] ?></span>
								<span class="hit-count has-dot"><i class="fa fa-eye"></i> <?php echo $list[$i]['wr_hit'];?></span>
								<span style="float: right !important;"><?php echo $list[$i]['name'];?></span>
							</div>
							<p style="font-size: 0.98rem;line-height: 1.5;"><?php echo cut_str(strip_tags($list[$i]['wr_content']), $big_cut_txt)?></p>
						</div>
					</div>
				</div>

			</div>
			<?php } ?>
		</div>
		<div class="pic_mix_lt3_col">

			<ul>
				<?php
				for ($i=$big_rows; $i<$list_count; $i++) {
					$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

					if($thumb['src']) {
						$img = $thumb['src'];
					} else {
						$img = G5_IMG_URL.'/no_img.png';
						$thumb['alt'] = '이미지가 없습니다.';
					}
					$img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
					$wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);

					if ($list[$i]['icon_secret']){
						$list[$i]['subject'] = "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> " . $list[$i]['subject'];
					}

					if ($list[$i]['is_notice'])
						$list[$i]['subject'] = "<strong>".$list[$i]['subject']."</strong>";

				?>
				<li class="galley_li post-small-style">

					<div class="mix-row">
						<div class="mix-img mix-img-<?php echo $mix_img_size;?>">
							<div class="img-wrap post-thumb img-hover-scale thumb-overlay" style="padding-bottom:<?php echo $img_height ?>%;">
								<div class="img-item">
									<a href="<?php echo $wr_href; ?>">
										<?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?>
									</a>
								</div>
							</div>
						</div>
						<div class="mix-body">
							<div class="mix-info">
								<?php if($list[$i]['ca_name']){ ?>
								<div class="entry-meta meta-0" style="margin-bottom: 1rem !important;">
									<a href="<?php echo $wr_href; ?>"><span class="post-cat <?php echo $bg_red[rand(0, 6)];?>"><?php echo $list[$i]['ca_name'];?></span></a>
								</div>
								<?php } ?>
								<div class="title" style="margin-top: 0.5rem !important;">
									<div class="item">
										<a href="<?php echo $wr_href; ?>" class="post-title" style="height:<?php echo $subject_height;?>px;">
											<?php echo $list[$i]['subject'] ?>
										</a>
										<?php
										if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
										if ($list[$i]['icon_hot']) echo "<span class=\"hot_icon\">H<span class=\"sound_only\">인기글</span></span>";
										?>
									</div>
								</div>
								<div class="entry-meta meta-1" style="margin-top: 0.5rem !important;margin-bottom: 0.5rem !important;">
									<span class="post-on"><i class="fa fa-clock-o"></i> <?php echo $list[$i]['datetime2'] ?></span>
									<span class="hit-count has-dot"><i class="fa fa-eye"></i> <?php echo $list[$i]['wr_hit'];?></span>
									<span style="float: right !important;"><?php echo $list[$i]['name'];?></span>
								</div>
								<?php if($is_content){ ?>
								<p style="font-size: 0.98rem;line-height: 1.5;"><?php echo cut_str(strip_tags($list[$i]['wr_content']), $cut_txt)?></p>
								<?php } ?>
							</div>
						</div>
					</div>

				</li>
				<?php }  ?>
				<?php if ($list_count == 0) { //게시물이 없을 때  ?>
				<li class="empty_li">게시물이 없습니다.</li>
				<?php }  ?>
			</ul>

		</div>
	</div>

    <a style="width: 200px" href="<?php echo get_pretty_url($bo_table); ?>" class="btn lt_more"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a>

</div>
