<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="row row-cols-1 row-cols-sm-2">
<?php 
// 보드추출
$bo_device = (G5_IS_MOBILE) ? 'pc' : 'mobile';
$sql = " select bo_table, bo_subject
			from {$g5['board_table']}
			where gr_id = '{$gr_id}'
			  and bo_list_level <= '{$member['mb_level']}'
			  and bo_order >= 0
			  and bo_device <> '{$bo_device}' ";
if(!$is_admin)
	$sql .= " and bo_use_cert = '' ";
$sql .= " order by bo_order ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
	<div class="col">
		<h3 class="fs-5 px-3 py-2 mb-0">
			<a href="<?php echo get_pretty_url($row['bo_table']); ?>">
				<span class="pull-right more-plus"></span>
				<?php echo get_text($row['bo_subject']) ?>
			</a>
		</h3>
		<div class="line-top pb-4">
			<?php echo na_widget('wr-list', 'group-index-'.$row['bo_table'], 'wr_notice=1 bo_list='.$row['bo_table']); ?>
		</div>
	</div>
<?php } ?>
</div>
