<?php
include_once('./_common.php');
if(!$is_member){
    alert('로그인 하세요.', G5_BBS_URL.'/login.php');
}
$g5['title'] = "소모임 즐겨찾기";
include_once('./_head.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>
<div class="row row-cols-1 row-cols-sm-2">
<?php 
// 보드추출
if($member['mb_somoim_favorite'] != null){
    $array = json_decode($member['mb_somoim_favorite']);
$arrayer = '';
foreach ($array as $result){
    $arrayer .= ",'{$result}'";
}
$where = "AND bo_table IN (''{$arrayer})";
$bo_device = (G5_IS_MOBILE) ? 'pc' : 'mobile';
$sql = " select bo_table, bo_subject
			from {$g5['board_table']}
			where gr_id = 'group'
			  and bo_list_level <= '{$member['mb_level']}'
			  and bo_order >= 0
              $where
			  and bo_device <> '{$bo_device}' ";
if(!$is_admin)
	$sql .= " and bo_use_cert = '' ";
$sql .= " order by bo_order limit 30";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
	<div class="col">
		<h3 class="fs-5 px-3 py-2 mb-0">
            <a href="<?php echo get_pretty_url($row['bo_table']); ?>">
				<span class="pull-right more-plus"></span>
				<?php echo get_text($row['bo_subject']) ?>
			</a>
			<?php if($array && in_array($row['bo_table'],$array)) { ?>
				<a href="/somoim/follow.php?bo_table=<?=$row['bo_table']?>" class="btn btn-basic">해제</a>
			<?php } else { ?>
				<a href="/somoim/follow.php?bo_table=<?=$row['bo_table']?>" class="btn btn-basic">즐겨찾기</a>
			<?php } ?>
		</h3>
		<div class="line-top pb-4">
			<?php echo na_widget('wr-list', 'group-index-'.$row['bo_table'], 'wr_notice=1 bo_list='.$row['bo_table']); ?>
		</div>
	</div>
<?php } ?>
</div>

<?php
} else {

}

include_once('./_tail.php');