<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<div class="px-3">
	<h2 class="visually-hidden">사이트 이용안내</h2>

	<h5 class="text-primary pb-2">1. 사이트 이용시 주의사항</h5>

	<p class="pb-2">본 사이트 이용시 기본적으로 아래 4가지 사항은 반드시 지켜주세요.</p>

	<ol>
		<li>무분별한 비방성글이나 욕설 금지
		<li>무분별한 광고글 및 불법자료 관련글 금지
		<li>개인정보 또는 금전거래를 목적으로 하는 글 금지
		<li>펌글 또는 이미지는 반드시 출처 기록(저작권 문제)
	</ol>

	<p>
		해당되는 게시물은 발견 즉시 차단되며, 해당 게시물을 작성한 회원은 불량회원이 되어 일정기간 접속이 차단되며,	욕설이나 광고글 등 분위기를 어지럽히는 글작성으로 차된되거나 불량회원이 되시면 직접 탈퇴하는 것이 불가능하니 주의해 주시길 바랍니다.
	</p>

	<h5 class="text-primary pt-4 pb-2">2. 포인트 제도 안내</h5>

	<p class="pb-2">본 사이트는 사이트 활성화와 다양한 혜택을 서비스하기 위해 포인트 제도를 운영하고 있습니다.</p>

	<ol>
		<li> 포인트 정책은 수시로 변경될 수 있으며, 이를 별도로 통보하지 않습니다.
		<li> 포인트 획득을 위한 도배 및 어뷰징 등의 행위자는 통보없이 "포인트 몰수" 또는 "회원정지" 또는 "사이트 접근차단" 등의 조치를 받을 수 있습니다.
		<li> 적립된 포인트는 사이트내 서비스를 이용하는 목적 이외의 어떠한 효력도 갖고 있지 않습니다.
		<li> 회원가입시 <b><?php echo number_format($config['cf_register_point']);?></b> 포인트 적립(1회), 로그인시  <b><?php echo number_format($config['cf_login_point']);?></b> 포인트 적립(매일), 쪽지발송시 <b><?php echo number_format($config['cf_memo_send_point']);?></b> 포인트 차감(매회)
	</ol>

	<div class="table-responsive">
		<table class="table">
		<tr class="active">
			<th class="na-table-head text-center">그룹명</th>
			<th class="na-table-head text-center">게시판명</th>
			<th class="na-table-head text-center">글수</th>
			<th class="na-table-head text-center">댓글수</th>
			<th class="na-table-head text-center">읽기점수</th>
			<th class="na-table-head text-center">쓰기점수</th>
			<th class="na-table-head text-center">댓글점수</th>
			<th class="na-table-head text-center">다운점수</th>
		</tr>
		<?php
			$result = sql_query(" select gr_id, gr_subject from {$g5['group_table']} where gr_order = '' or gr_order >= '0' order by gr_order ", false);
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$result1 = sql_query("select bo_table, bo_subject, bo_count_write, bo_count_comment, bo_read_point, bo_write_point, bo_comment_point, bo_download_point from {$g5['board_table']} where gr_id = '{$row['gr_id']}' order by bo_order ", false);
				$rowspan = sql_num_rows($result1);

				if(!$rowspan) 
					continue; // 게시판이 없으면 통과

				for ($j=0; $row1=sql_fetch_array($result1); $j++) {
				?>
				<tr>
				<?php if($j == 0) { ?>
					<th rowspan="<?php echo $rowspan;?>" class="text-center"><?php echo $row['gr_subject'] ?></th>
				<?php } ?>
				<td><a href="<?php echo get_pretty_url($row1['bo_table']) ?>"><?php echo $row1['bo_subject'] ?></a></td>
				<td class="text-center"><?php echo ($row1['bo_count_write']) ? number_format($row1['bo_count_write']) : '-'; ?></td>
				<td class="text-center"><?php echo ($row1['bo_count_comment']) ? number_format($row1['bo_count_comment']) : '-'; ?></td>
				<td class="text-center"><?php echo ($row1['bo_read_point']) ? number_format($row1['bo_read_point']) : '-'; ?></td>
				<td class="text-center"><?php echo ($row1['bo_write_point']) ? number_format($row1['bo_write_point']) : '-'; ?></td>
				<td class="text-center"><?php echo ($row1['bo_comment_point']) ? number_format($row1['bo_comment_point']) : '-'; ?></td>
				<td class="text-center"><?php echo ($row1['bo_download_point']) ? number_format($row1['bo_download_point']) : '-'; ?></td>
				</tr>
			<?php } ?>
		<?php } ?>
		</table>
	</div>

	<h5 class="text-primary pt-4 pb-2">3. 게시물 규제정책</h5>

	<p>본 사이트의 게시물 규제정책은 방송통신심의위원회의 SafeNet 등급기준에 대한 연령별 권장사항 중 12세 이상 (중학생가) 레벨을 따르고자 노력합니다.</p>

	<p class="py-2">본 사이트의 각종 게시판에 게시자가 올린 게시물이 아래과 같은 게시물에 해당되는 경우 관리자는 사전 통지 없이 해당 게시물을 삭제할 수 있으며, 이를 작성한 게시자는 웹사이트의 이용이 차단될 수 있습니다. 또한, 명예훼손 및 저작권침해에 해당 되는 내용에 대해서는 한국저작권보호원(<a href="https://www.kcopa.or.kr/" target="_blank">https://www.kcopa.or.kr</a>)에 신고될 수 있습니다.</p>

	<ol>
		<li>인종이나 성(性), 국적, 종교적, 정치적 분쟁 등 사회문화적 편견에 기반을 둔 내용의 글
		<li>자신 또는 타인의 전화번호, 주민등록번호, 실명등의 개인정보를 포함하고 있는 글
		<li>회사가 인정하지 않는 프로그램, 부적절한 파일 등의 유포나 사용을 유도하는 글
		<li>회사에서 규정한 게시물 원칙에 어긋나거나, 게시판 성격에 부합하지 않는 글
		<li>와레즈사이트, 토렌트사이트 또는 이와 유사한 사이트를 소개, 권유하는 글
		<li>회사 또는 회사 임직원을 사칭하거나 회사 및 회사 임직원을 비방하는 글
		<li>회사에서 판매하였거나 판매하는 제품을 허락없이 재판매하는 글
		<li>같은 내용을 의도적으로 수 차례에 걸쳐 반복적으로 게재한 글
		<li>도배 또는 욕설, 음란한 단어 및 표현을 포함한 글
		<li>이용약관 및 관련법령에 위배되는 내용의 글
		<li>현행법상 처벌의 근거가 되는 글
		<li>관계법령에 위배된다고 판단되는 글
		<li>불법복제 또는 해킹을 조장하는 내용의 글
		<li>저작권 침해 및 이와 유사한 내용을 담은 글
		<li>타인에게 불쾌감이나 혐오감을 줄 수 있는 글
		<li>기타 게시판의 성격에 맞지 않는다고 판단되는 글
		<li>기타 정당한 권한 없이 타인의 권리를 침해하는 내용
		<li>공공질서 및 미풍양속에 위반되는 내용이나 링크를 포함한 글
		<li>회사의 자산을 악의적으로 평가 저하시키려는 내용이 포함된 글
		<li>계정거래, 현금거래 등 불법적인 시도 또는 타 고객들을 선동하는 글
		<li>허위사실을 유포하거나 다수의 고객에게 오해를 불러일으킬 수 있는 내용의 글
		<li>다른 회원 또는 제3자에게 불쾌감을 주거나 비방함으로써 명예를 손상시키는 글
		<li>회사 또는 타인을 비방하거나 중상 모략으로 명예를 훼손시키거나 모욕을 주는 글
		<li>회사에서 인정하지 않은 영리를 목적으로 하거나 광고 및 홍보 또는 그와 유사한 내용임이 객관적으로 확인되는 글
	</ol>

	<h5 class="text-primary pt-4 pb-2">4. 레벨별 경험치 안내</h5>

	<p class="pb-2">본 사이트에서는 회원등급과 별도로 회원레벨이 적용되며, 각 레벨별 경험치는 다음과 같습니다.</p>

	<?php
		//Exp
		$xp_point = $nariya['xp_point'];
		$xp_max = $nariya['xp_max'];
		$xp_rate = $nariya['xp_rate'];
	?>

	<div class="table-responsive">
		<table class="table">
		<tr>
			<th class="na-table-head text-center">레벨</th>
			<th class="na-table-head text-center">최소 경험치</th>
			<th class="na-table-head text-center">최대 경험치</th>
			<th class="na-table-head text-center">레벨업 경험치</th>
			<th class="na-table-head text-center">비고</th>
		</tr>
		<tr>
			<th class="text-center">1</th>
			<td class="text-center">0</td>
			<td class="text-center"><?php echo number_format($xp_point);?></td>
			<td class="text-center"><?php echo number_format($xp_point);?></td>
			<td class="text-center"></td>
		</tr>
		<?php
			$min_xp = $xp_point;
			for ($i=2; $i <= $xp_max; $i++) {
				$xp_plus = $xp_point + $xp_point * ($i - 1) * $xp_rate;
				$max_xp = $min_xp + $xp_plus;
		?>
			<tr>
				<th class="text-center"><?php echo $i; ?></th>
				<td class="text-center"><?php echo number_format($min_xp);?></td>
				<td class="text-center"><?php echo number_format($max_xp);?></td>
				<td class="text-center"><?php echo number_format($xp_plus);?></td>
				<td class="text-center">&nbsp;</td>
			</tr>
			<?php $min_xp = $max_xp; } ?>
		</table>
	</div>

</div>