<?php
$sub_menu = "800100";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '레벨업 경험치 시뮬레이터';
include_once(G5_PATH.'/head.sub.php');

if(!isset($opt) || !$opt) {
	$xp_point = isset($nariya['xp_point']) ? $nariya['xp_point'] : '';
	$xp_max = isset($nariya['xp_max']) ? $nariya['xp_max'] : '';
	$xp_rate = isset($nariya['xp_rate']) ? $nariya['xp_rate'] : '';
}

?>

<div id="menu_frm" class="new_win" style="background:#fff;">
    <h1><?php echo $g5['title']; ?></h1>

	<div class="local_desc01">
		레벨업 경험치 = 기준 경험치 + 기준 경험치 * 직전 레벨 * 경험치 증가율(배)
	</div>

	<form id="expform" name="expform" method="post" style="padding:0 10px;">
	<input type="hidden" name="opt" value="exp">

	<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">최대 레벨</th>
        <th scope="col">기준 경험치</th>
        <th scope="col">경험치 증가율(배)</th>
    </tr>
    </thead>
    <tbody>
	<tr>
	<td><input type=text size=10 id="xp_max" name="xp_max" value="<?php echo $xp_max ?>" class="frm_input" required></td>
	<td><input type=text size=10 id="xp_point" name="xp_point" value="<?php echo $xp_point ?>" class="frm_input" required></td>
	<td><input type=text size=10 id="xp_rate" name="xp_rate" value="<?php echo $xp_rate ?>" class="frm_input" required></td>
	</tr>
	</tbody>
	</table>

	<br>

	<div class="btn_win02 btn_win">
		<input type="submit" value="시뮬레이션" class="btn_submit btn" accesskey="s">
		<button type="button" class="btn_02 btn" onclick="window.close();">창닫기</button>
	</div>

	<br>

	<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">레벨</th>
        <th scope="col">최소 경험치</th>
        <th scope="col">최대 경험치</th>
        <th scope="col">레벨업 경험치</th>
        <th scope="col">비고</th>
    </tr>
    </thead>
    <tbody>
	<tr>
	<td>1</td>
	<td>0</td>
	<td><?php echo number_format((int)$xp_point); ?></td>
	<td><?php echo number_format((int)$xp_point); ?></td>
	<td></td>
	</tr>
	<?php
		$min_xp = $xp_point;
		for ($i=2; $i <= $xp_max; $i++) {
			$xp_plus = $xp_point + $xp_point * ($i - 1) * $xp_rate;
			$max_xp = $min_xp + $xp_plus;
	?>
		<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo number_format((int)$min_xp); ?></td>
		<td><?php echo number_format((int)$max_xp); ?></td>
		<td><?php echo number_format((int)$xp_plus); ?></td>
		<td>&nbsp;</td>
		</tr>
	<?php $min_xp = $max_xp; } ?>
	</table>

	<br>

	<div class="btn_win02 btn_win">
		<input type="submit" value="시뮬레이션" class="btn_submit btn" accesskey="s">
		<button type="button" class="btn_02 btn" onclick="window.close();">창닫기</button>
	</div>

	<br>

	</form>
</div>

<?php 
include_once(G5_PATH.'/tail.sub.php');