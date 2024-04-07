<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(NA_PATH.'/_adm.php');

auth_check_menu($auth, $sub_menu, "r");

if (!isset($g5['content_table'])) {
    die('<meta charset="utf-8">/data/dbconfig.php 파일에 <strong>$g5[\'content_table\'] = G5_TABLE_PREFIX.\'content\';</strong> 를 추가해 주세요.');
}

// 저장하기
if(isset($_POST['act_button']) && isset($_POST['token'])){

	check_demo();

	check_admin_token();

	auth_check_menu($auth, $sub_menu, "w");

	$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
	$chk            = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
	$act_button     = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

    for ($i = 0; $i < $post_count_chk; $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

		$post_co_id = isset($_POST['co_id'][$k]) ? clean_xss_tags($_POST['co_id'][$k], 1, 1) : '';
        $post_co_shop = isset($_POST['co_shop'][$k]) ? (int)$_POST['co_shop'][$k] : 0;

	    sql_query(" update {$g5['content_table']} set co_shop = '{$post_co_shop}' where co_id = '{$post_co_id}' ");

		run_event('admin_content_updated', $post_co_id);
	}

	// 페이지 이동
	goto_url('./contentlist.php?page='.$page);
}

//내용(컨텐츠)정보 테이블이 있는지 검사한다.
if (!sql_query(" DESCRIBE {$g5['content_table']} ", false)) {
    if (sql_query(" DESCRIBE {$g5['g5_shop_content_table']} ", false)) {
        sql_query(" ALTER TABLE {$g5['g5_shop_content_table']} RENAME TO `{$g5['content_table']}` ;", false);
    } else {
        $query_cp = sql_query(
            " CREATE TABLE IF NOT EXISTS `{$g5['content_table']}` (
                      `co_id` varchar(20) NOT NULL DEFAULT '',
                      `co_html` tinyint(4) NOT NULL DEFAULT '0',
                      `co_subject` varchar(255) NOT NULL DEFAULT '',
                      `co_content` longtext NOT NULL,
                      `co_hit` int(11) NOT NULL DEFAULT '0',
                      `co_include_head` varchar(255) NOT NULL,
                      `co_include_tail` varchar(255) NOT NULL,
                      PRIMARY KEY (`co_id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ",
            true
        );

        // 내용관리 생성
        sql_query(" insert into `{$g5['content_table']}` set co_id = 'company', co_html = '1', co_subject = '회사소개', co_content= '<p align=center><b>회사소개에 대한 내용을 입력하십시오.</b></p>' ", false);
        sql_query(" insert into `{$g5['content_table']}` set co_id = 'privacy', co_html = '1', co_subject = '개인정보 처리방침', co_content= '<p align=center><b>개인정보 처리방침에 대한 내용을 입력하십시오.</b></p>' ", false);
        sql_query(" insert into `{$g5['content_table']}` set co_id = 'provision', co_html = '1', co_subject = '서비스 이용약관', co_content= '<p align=center><b>서비스 이용약관에 대한 내용을 입력하십시오.</b></p>' ", false);
    }
}

if(IS_YC) {
	// 쇼핑몰 레이아웃 사용 추가
	if (!sql_fetch(" SHOW COLUMNS FROM {$g5['content_table']} LIKE 'co_shop' ")) {
		sql_query(" ALTER TABLE `{$g5['content_table']}` ADD `co_shop` tinyint(4) NOT NULL DEFAULT '0' AFTER `co_html` ", true);
	}
}

$g5['title'] = '내용관리';
require_once G5_ADMIN_PATH . '/admin.head.php';

$sql_common = " from {$g5['content_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "select * $sql_common order by co_id limit $from_record, {$config['cf_page_rows']} ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    <?php if ($page > 1) { ?><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">처음으로</a><?php } ?>
    <span class="btn_ov01"><span class="ov_txt">전체 내용</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
</div>

<form name="fcontent" id="fcontent" action="./contentlist.php" onsubmit="return fcontent_submit(this);" method="post">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo isset($token) ? $token : ''; ?>">

<div class="btn_fixed_top">
	<input type="submit" name="act_button" value="저장하기" onclick="document.pressed=this.value" class="btn_02 btn">
    <a href="./contentform.php" class="btn btn_01">내용추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption><?php echo $g5['title']; ?> 목록</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">제목</th>
				<?php if(IS_YC) { ?>
	                <th scope="col">레이아웃</th>
				<?php } ?>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $bg = 'bg' . ($i % 2);
            ?>
                <tr class="<?php echo $bg; ?>">
                    <td class="td_id"><?php echo $row['co_id']; ?></td>
                    <td class="td_left"><?php echo htmlspecialchars2($row['co_subject']); ?></td>
					<?php if(IS_YC) { ?>
						<?php $row['co_shop'] = isset($row['co_shop']) ? $row['co_shop'] : 0; ?>
						<td class="td_mng">
                            <input type="hidden" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                            <input type="hidden" name="co_id[<?php echo $i ?>]" value="<?php echo $row['co_id'] ?>">
                            <label for="co_shop_<?php echo $i ?>" class="sound_only">레이아웃</label>
                            <select name="co_shop[<?php echo $i ?>]" id="co_shop_<?php echo $i ?>">
                                <option value="0" <?php echo get_selected((int)$row['co_shop'], 0, true); ?>>커뮤니티</option>
                                <option value="1" <?php echo get_selected((int)$row['co_shop'], 1); ?>>쇼핑몰</option>
                            </select>
						</td>
					<?php } ?>
                    <td class="td_mng td_mng_l">
                        <a href="./contentform.php?w=u&amp;co_id=<?php echo $row['co_id']; ?>" class="btn btn_03"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>수정</a>
                        <a href="<?php echo get_pretty_url('content', $row['co_id']); ?>" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span> 보기</a>
                        <a href="./contentformupdate.php?w=d&amp;co_id=<?php echo $row['co_id']; ?>" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only"><?php echo htmlspecialchars2($row['co_subject']); ?> </span>삭제</a>
                    </td>
                </tr>
            <?php
            }

            if ($i == 0) {
				$colspan = IS_YC ? 4 : 3;
                echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 한건도 없습니다.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
    function fcontent_submit(f) {

        return true;

	}
</script>

<?php
require_once G5_ADMIN_PATH . '/admin.tail.php';
