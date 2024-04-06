<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

?>
<ul class="nav nav-tabs ps-3 pt-3">
	<li class="nav-item">
		<a class="nav-link<?php echo ($kind == "recv") ? ' active" aria-current="page' : ''; ?>" href="./memo.php?kind=recv">
			받은쪽지
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link<?php echo ($kind == "send") ? ' active" aria-current="page' : ''; ?>" href="./memo.php?kind=send">
			보낸쪽지
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link<?php echo ($kind == "") ? ' active" aria-current="page' : ''; ?>" href="./memo_form.php">
			쪽지쓰기
		</a>
	</li>
</ul>
<div class="position-relative line-top" style="margin-top:-1px;"></div>