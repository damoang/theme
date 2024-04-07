<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<?php if(!G5_IS_MOBILE) { ?>
<div class="shadow-sm p-3 mb-5 rounded px-3 mb-4">
    <?php echo na_widget('outlogin'); // 외부로그인 ?>
</div>

<div class="na-menu">
    <div class="nav nav-pills nav-vertical">
	    
        <div id="sidebar-site-menu" class="mb-3">
		<hr class="hr" />
		<div class="dropdown-header">
            커뮤니티
        </div>
		
            <div class="nav-item">
                <a class="nav-link" href="/free" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-f"></i>
                    <span style="" class="nav-link-title">
                        자유게시판
                    </span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="/qa" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-q"></i>
                    <span style="" class="nav-link-title">
                        마음껏 질문
                    </span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="/hello" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-i"></i>
                    <span style="" class="nav-link-title">
                        가입인사
                    </span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="/new" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-n"></i>
                    <span style="" class="nav-link-title">
                        새소게(새소식)
                    </span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="/tutorial" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-t"></i>
                    <span style="" class="nav-link-title">
                        사용기/강좌
                    </span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="/economy" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-e"></i>
                    <span style="" class="nav-link-title">
                        알뜰구매
                    </span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="/gallery" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-g"></i>
                    <span style="" class="nav-link-title">
                        갤러리
                    </span>
                </a>
            </div>


            <div class="nav-item">
                <a class="nav-link" href="/bbs/group.php?gr_id=community" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-c"></i>
                    <span style="" class="nav-link-title">
                        커뮤니티
                    </span>
                </a>
            </div>
			<?php if($is_member) { ?>
			<hr class="hr" />
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
              $where";
$sql .= " order by bo_order";
$result_q = sql_query($sql); }
?>
        <div class="dropdown-header">
            즐겨찾는 소모임
        </div>
<?php 
	while($row = mysqli_fetch_array($result_q)){ ?>
<div class="nav-item">
<a class="nav-link" href="/<?php echo $row['bo_table']; ?>" data-placement="left" target="_self">
	<i style="" class="fi fi-rs-circle-s"></i>
	<span style="" class="nav-link-title">
		<?php echo $row['bo_subject']; ?>
	</span>
</a>
</div>
<?php } } ?>
		<hr class="hr" />
		<div class="dropdown-header">
            운영
        </div>
		
		    <div class="nav-item">
                <a class="nav-link" href="/notice" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-n"></i>
                    <span style="" class="nav-link-title">
                        공지사항
                    </span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="/bug" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-b"></i>
                    <span style="" class="nav-link-title">
                        버그 제보
                    </span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link" href="/truthroom" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-r"></i>
                    <span style="" class="nav-link-title">
                        진실의 방
                    </span>
                </a>
            </div>
			<div class="nav-item">
                <a class="nav-link" href="/governance" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-g"></i>
                    <span style="" class="nav-link-title">
                        거버넌스
                    </span>
                </a>
            </div>
        </div>

		<hr class="hr">
		
        <div class="dropdown-header">
            소모임
        </div>
		<div class="somoim_menu">
		    <div class="nav-item">
                <a class="nav-link" href="/somoim/index.php" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-g"></i>
                    <span style="" class="nav-link-title">
                        소모임 메인
                    </span>
                </a>
            </div>
		    <div class="nav-item">
                <a class="nav-link" href="/somoim/favorite.php" data-placement="left" target="_self">
                    <i style="" class="fi fi-rs-circle-g"></i>
                    <span style="" class="nav-link-title">
                        즐겨찾기
                    </span>
                </a>
            </div>
        <?php 
					$somoim_menu_q = sql_Query("SELECT * FROM {$g5['board_table']} WHERE gr_id = 'group' ORDER BY bo_count_write DESC LIMIT 50");
					while($row = mysqli_fetch_array($somoim_menu_q)){ ?>
        <div class="nav-item">
            <a class="nav-link" href="/<?php echo $row['bo_table']; ?>" data-placement="left" target="_self">
                <i style="" class="fi fi-rs-circle-s"></i>
                <span style="" class="nav-link-title">
                    <?php echo $row['bo_subject']; ?>
                </span>
            </a>
        </div>
        <?php } ?>
		</div>
    </div>

</div><!-- end .na-menu -->
<?php } ?>