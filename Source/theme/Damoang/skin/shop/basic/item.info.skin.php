<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

// 관련상품
$rel_str = '';
if ($default['de_rel_list_use']) {
	$rel_skin_file = $skin_dir.'/'.$default['de_rel_list_skin'];
	if(!is_file($rel_skin_file))
		$rel_skin_file = G5_SHOP_SKIN_PATH.'/'.$default['de_rel_list_skin'];

	$sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
	$list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
	$list->set_query($sql);
	$rel_str = $list->run();
}

function na_anchor($anc_id) {
    global $default;
    global $item_use_count, $item_qa_count, $item_relation_count;
?>

<ul class="nav nav-tabs lh-lg mb-0 px-3">
	<li class="nav-item">
		<a class="nav-link<?php if ($anc_id == 'inf') echo ' active" aria-current="page'; ?>" href="#sit_inf">
			<span class="d-none d-sm-inline-block"><i class="bi bi-info-circle"></i> 상품</span>정보
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link<?php if ($anc_id == 'use') echo ' active" aria-current="page'; ?>" href="#sit_use">
			<span class="d-none d-sm-inline-block"><i class="bi bi-chat-square-text"></i> 사용</span>후기
			<span class="badge text-bg-primary"><?php echo $item_use_count ?></span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link<?php if ($anc_id == 'qa') echo ' active" aria-current="page'; ?>" href="#sit_qa">
			<span class="d-none d-sm-inline-block"><i class="bi bi-question-circle"></i> 상품</span>문의
			<span class="badge text-bg-primary"><?php echo $item_qa_count ?></span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link<?php if ($anc_id == 'dex') echo ' active" aria-current="page'; ?>" href="#sit_dex">
			<i class="bi bi-truck"></i> 배송/교환
		</a>
	</li>
</ul>

<?php } ?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<?php if(IS_EXTEND) { 
	$attach = na_file($it_id);
	if(isset($attach['count']) && $attach['count'] > 0) {
?>
	<div class="mt-4">
		<ul class="list-group list-group-flush">
			<li class="list-group-item divider-line">
				<h3 class="fs-5 mb-0">다운로드</h3>
			</li>
			<?php for ($i=0; $i < $attach['count']; $i++) { ?>
			<li class="list-group-item">
				<div class="d-flex align-items-center">
					<div>
						<?php if($attach[$i]['free']) { ?>
							<span class="badge text-bg-secondary">무료</span>
						<?php } else { ?>
							<span class="badge text-bg-primary">유료</span>
						<?php } ?>
					</div>
					<div class="mx-2">
						<i class="bi bi-download"></i>
						<span class="visually-hidden">첨부</span>
					</div>
					<div>
						<a href="<?php echo $attach[$i]['href'] ?>">
							<?php echo $attach[$i]['source'] ?>
							<span class="visually-hidden">파일크기</span>
							<span class="small">(<?php echo $attach[$i]['size'] ?>)</span>
						</a>
					</div>
				</div>
			</li>
			<?php } ?>
			<li class="list-group-item small text-secondary">
				<i class="bi bi-info-circle"></i>
				유료 첨부는 구매하신 분만 다운로드할 수 있습니다.
			</li>
		</ul>
	</div>
<?php } 
} ?>
<section id="sit_info" class="mt-4">
	<div id="sit_inf">
		<?php echo na_anchor('inf') ?>
		<h2 class="visually-hidden">
			상품정보
		</h2>
		<div class="px-3 my-5">

			<?php if ($it['it_explan']) { // 상품 상세설명 ?>
				<div id="sit_inf_explan" class="mb-4">
					<?php echo conv_content($it['it_explan'], 1); ?>
				</div>
			<?php } ?>
			<?php
			if ($it['it_info_value']) { // 상품 정보 고시
				$info_data = unserialize(stripslashes($it['it_info_value']));
				if(is_array($info_data)) {
					$gubun = $it['it_info_gubun'];
					$info_array = $item_info[$gubun]['article'];
			?>
			
			<h3 class="fs-2 text-center mb-4">
				상품정보고시
			</h3>
			<div class="table-responsive">
				<table id="sit_inf_open" class="table table-bordered">
				<tbody>
				<?php
				foreach($info_data as $key=>$val) {
					$ii_title = $info_array[$key][0];
					$ii_value = $val;
				?>
				<tr>
					<th scope="row" class="col-md-4"><?php echo $ii_title ?></th>
					<td class="col-md-8"><?php echo $ii_value ?></td>
				</tr>
				<?php } //foreach?>
				</tbody>
				</table>
				<!-- 상품정보고시 end -->
				<?php
					} else {
						if($is_admin) {
							echo '<p>상품 정보 고시 정보가 올바르게 저장되지 않았습니다.<br>config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로<br>변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요. </p>';
						}
					}
				} //if
				?>
			</div>
		</div>
	</div>

	<?php if ($rel_str) { ?>
		<div id="sit_rel" class="mb-5">
			<h2 class="fs-2 pb-3 text-center">
				관련상품
			</h2>
			<?php echo $rel_str ?>
		</div>
	<?php } ?>

	<div id="sit_use" class="mb-5">
		<?php echo na_anchor('use') ?>
		<h2 class="visually-hidden">
			사용후기
		</h2>
		<div id="itemuse">
			<?php include_once(NA_PATH.'/shop/itemuse.php') ?>
		</div>
	</div>

	<div id="sit_qa" class="mb-5">
		<?php echo na_anchor('qa') ?>
		<h2 class="visually-hidden">
			상품문의
		</h2>
		<div id="itemqa">
			<?php include_once(NA_PATH.'/shop/itemqa.php') ?>
		</div>
	</div>

	<div id="sit_dex" class="mb-5">
		<?php echo na_anchor('dex') ?>
		<h2 class="visually-hidden">
			배송/교환
		</h2>
		<div>
			<?php include_once(G5_SHOP_SKIN_PATH.'/item.delivery.php') ?>
		</div>	            		
	</div>

</section>

<script>
$(function() {
    // 이미지 리사이즈
    $("#sit_info").viewimageresize();
});
</script>