<?php
$sub_menu = "800200";
define('NA_SHOP_MENU', true);
require_once './_common.php';

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

if (isset($_POST['mode']) && $_POST['mode'] === 'save') {

	check_demo();
	
	check_admin_token();

	// 이전 메뉴정보 삭제
	$sql = " delete from {$g5['na_menu']} ";
	sql_query($sql);

	$group_code = null;
	$primary_code = null;
	$second_code = null;
	$count = isset($_POST['code']) ? count($_POST['code']) : 0;

	for ($i=0; $i<$count; $i++) {

		$_POST = array_map_deep('trim', $_POST);

		if (preg_match('/^javascript/i', preg_replace('/[ ]{1,}|[\t]/', '', $_POST['me_link'][$i]))) {
			$_POST['me_link'][$i] = G5_URL;
		}

		$_POST['me_link'][$i] = is_array($_POST['me_link']) ? clean_xss_tags(clean_xss_attributes(preg_replace('/[ ]{2,}|[\t]/', '', $_POST['me_link'][$i]), 1)) : '';
		$_POST['me_link'][$i] = html_purifier($_POST['me_link'][$i]);

		$code    = is_array($_POST['code']) ? strip_tags($_POST['code'][$i]) : '';
		$sub	 = is_array($_POST['sub']) ? strip_tags($_POST['sub'][$i]) : '';
		$me_name = is_array($_POST['me_name']) ? strip_tags($_POST['me_name'][$i]) : '';
		$me_link = (preg_match('/^javascript/i', $_POST['me_link'][$i]) || preg_match('/script:/i', $_POST['me_link'][$i])) ? G5_URL : strip_tags(clean_xss_attributes($_POST['me_link'][$i]));

		$_POST['me_link'][$i] = is_array($_POST['me_link']) ? clean_xss_tags($_POST['me_link'][$i], 1) : '';

		if(!$code || !$me_name || !$me_link)
			continue;

		// 메뉴코드
		$sub_code = '';
		if($group_code == $code) {
			if($sub) {
				$sql = " select MAX(SUBSTRING(me_code,3,2)) as max_me_code
							from {$g5['na_menu']}
							where SUBSTRING(me_code,1,2) = '$primary_code' ";
				$row = sql_fetch($sql);

				$sub_code = base_convert($row['max_me_code'], 36, 10);
				$sub_code += 36;
				$sub_code = base_convert($sub_code, 10, 36);

				$me_code = $primary_code.$sub_code;
				$second_code = $me_code;
			} else {
				$sql = " select MAX(SUBSTRING(me_code,5,2)) as max_me_code
							from {$g5['na_menu']}
							where SUBSTRING(me_code,1,4) = '$second_code' ";
				$row = sql_fetch($sql);

				$sub_code = base_convert($row['max_me_code'], 36, 10);
				$sub_code += 36;
				$sub_code = base_convert($sub_code, 10, 36);

				$me_code = $second_code.$sub_code;
			}
		} else {
			$sql = " select MAX(SUBSTRING(me_code,1,2)) as max_me_code
						from {$g5['na_menu']}
						where LENGTH(me_code) = '2' ";
			$row = sql_fetch($sql);

			$me_code = base_convert($row['max_me_code'], 36, 10);
			$me_code += 36;
			$me_code = base_convert($me_code, 10, 36);

			$group_code = $code;
			$primary_code = $me_code;
		}

		// 메뉴 등록
		$sql = " insert into {$g5['na_menu']}
					set me_code         = '" . $me_code . "',
						me_name         = '" . $me_name . "',
						me_link         = '" . $me_link . "',
						me_target       = '" . sql_real_escape_string(strip_tags($_POST['me_target'][$i])) . "',
						me_order        = '" . sql_real_escape_string(strip_tags($_POST['me_order'][$i])) . "',
						me_use          = '" . sql_real_escape_string(strip_tags($_POST['me_use'][$i])) . "',
						me_mobile_use   = '" . sql_real_escape_string(strip_tags($_POST['me_mobile_use'][$i])) . "' ";
		sql_query($sql);
	}

	run_event('admin_menu_list_update');

	goto_url('./menu_shop.php');

} // Save Mode

if(!sql_query(" DESCRIBE {$g5['na_menu']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['na_menu']}` (
                  `me_id` int(11) NOT NULL AUTO_INCREMENT,
                  `me_code` varchar(255) NOT NULL DEFAULT '',
                  `me_name` varchar(255) NOT NULL DEFAULT '',
                  `me_link` varchar(255) NOT NULL DEFAULT '',
                  `me_target` varchar(255) NOT NULL DEFAULT '0',
                  `me_order` int(11) NOT NULL DEFAULT '0',
                  `me_use` tinyint(4) NOT NULL DEFAULT '0',
                  `me_mobile_use` tinyint(4) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`me_id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}

$sql = " select * from {$g5['na_menu']} order by me_id ";
$result = sql_query($sql);

$g5['title'] = "쇼핑몰 메뉴설정";
require_once G5_ADMIN_PATH.'/admin.head.php';

$colspan = 8;
?>

<div class="local_desc01 local_desc">
    <p><strong>주의!</strong> 메뉴설정 작업 후 반드시 <strong>확인</strong>을 누르셔야 저장됩니다.</p>
</div>

<form name="fmenulist" id="fmenulist" method="post" action="./menu_shop.php" onsubmit="return fmenulist_submit(this);">
<input type="hidden" name="mode" value="save">
<input type="hidden" name="token" value="">

<style>
.td_category { width:300px; }
#menulist .sub_menu_class.sub_menu2{ padding-left:50px; background-position:27px 5px; }
</style>

<div id="menulist" class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">코드</th>
		<th scope="col">메뉴</th>
        <th scope="col">링크</th>
        <th scope="col">새창</th>
        <th scope="col">순서</th>
        <th scope="col">PC사용</th>
        <th scope="col">모바일사용</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $bg = 'bg'.($i%2);
        $sub_menu_class = $sub_menu_info = $sub_menu_ico = '';
        if(strlen($row['me_code']) === 4) {
            $sub_menu_class = ' sub_menu_class';
            $sub_menu_info = '<span class="sound_only">'.$row['me_name'].'의 서브</span>';
            $sub_menu_ico = '<span class="sub_menu_ico"></span>';
        } else if(strlen($row['me_code']) === 6) {
            $sub_menu_class = ' sub_menu_class sub_menu2';
            $sub_menu_info = '<span class="sound_only">'.$row['me_name'].'의 서브</span>';
            $sub_menu_ico = '<span class="sub_menu_ico"></span>';
		}

        $search  = array('"', "'");
        $replace = array('&#034;', '&#039;');
        $me_name = str_replace($search, $replace, $row['me_name']);
    ?>
    <tr class="<?php echo $bg; ?> menu_list menu_group_<?php echo substr($row['me_code'], 0, 2).$sub_class;?>">
        <td class="td_mngsmall">
			<?php echo (strlen($row['me_code']) === 2) ? $row['me_code'] : '&nbsp;'?>
		</td>
		<td class="td_category<?php echo $sub_menu_class; ?>">
            <input type="hidden" name="code[]" value="<?php echo substr($row['me_code'], 0, 2) ?>">
            <input type="hidden" name="sub[]" value="<?php echo (strlen($row['me_code']) === 4) ? '1' : ''; ?>">
			<label for="me_name_<?php echo $i; ?>" class="sound_only"><?php echo $sub_menu_info; ?> 메뉴<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="me_name[]" value="<?php echo get_sanitize_input($me_name); ?>" id="me_name_<?php echo $i; ?>" required class="required tbl_input full_input">
        </td>
        <td>
            <label for="me_link_<?php echo $i; ?>" class="sound_only">링크<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="me_link[]" value="<?php echo $row['me_link'] ?>" id="me_link_<?php echo $i; ?>" required class="required tbl_input full_input">
        </td>
        <td class="td_mng">
            <label for="me_target_<?php echo $i; ?>" class="sound_only">새창</label>
            <select name="me_target[]" id="me_target_<?php echo $i; ?>">
                <option value="self"<?php echo get_selected($row['me_target'], 'self', true); ?>>사용안함</option>
                <option value="blank"<?php echo get_selected($row['me_target'], 'blank', true); ?>>사용함</option>
            </select>
        </td>
        <td class="td_num">
            <label for="me_order_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="me_order[]" value="<?php echo $row['me_order'] ?>" id="me_order_<?php echo $i; ?>" class="tbl_input" size="5">
        </td>
        <td class="td_mng">
            <label for="me_use_<?php echo $i; ?>" class="sound_only">PC사용</label>
            <select name="me_use[]" id="me_use_<?php echo $i; ?>">
                <option value="1"<?php echo get_selected($row['me_use'], '1', true); ?>>사용함</option>
                <option value="0"<?php echo get_selected($row['me_use'], '0', true); ?>>사용안함</option>
            </select>
        </td>
        <td class="td_mng">
            <label for="me_mobile_use_<?php echo $i; ?>" class="sound_only">모바일사용</label>
            <select name="me_mobile_use[]" id="me_mobile_use_<?php echo $i; ?>">
                <option value="1"<?php echo get_selected($row['me_mobile_use'], '1', true); ?>>사용함</option>
                <option value="0"<?php echo get_selected($row['me_mobile_use'], '0', true); ?>>사용안함</option>
            </select>
        </td>
        <td class="td_mng">
            <?php if(strlen($row['me_code']) === 2) { ?>
	            <button type="button" class="btn_add_submenu btn_03 ">추가</button>
		        <button type="button" class="btn_del_menu btn_02">삭제</button>
			<?php } else if(strlen($row['me_code']) === 4) { ?>
	            <button type="button" class="btn_add_submenu2 btn_02 ">추가</button>
		        <button type="button" class="btn_del_submenu btn_02">삭제</button>
			<?php } else { ?>
		        <button type="button" class="btn_del_menu btn_02">삭제</button>
			<?php } ?>
		</td>
    </tr>
    <?php
    }

    if ($i==0)
        echo '<tr id="empty_menu_list"><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <button type="button" onclick="return add_menu();" class="btn btn_02">메뉴추가<span class="sound_only"> 새창</span></button>
    <input type="submit" name="act_button" value="확인" class="btn_submit btn ">
</div>
</form>

<script>
$(function() {
    $(document).on("click", ".btn_add_submenu", function() {
        var code = $(this).closest("tr").find("input[name='code[]']").val().substr(0, 2);
        add_submenu(code);
    });

    $(document).on("click", ".btn_add_submenu2", function() {
        var code = $(this).closest("tr").find("input[name='code[]']").val().substr(0, 2);
        add_submenu2(code);
    });

    $(document).on("click", ".btn_del_menu", function() {
        if (!confirm("메뉴를 삭제하시겠습니까?\n메뉴 삭제후 메뉴설정의 확인 버튼을 눌러 메뉴를 저장해 주세요."))
            return false;

        var $tr = $(this).closest("tr");
        if($tr.find("td.sub_menu_class").length > 0) {
            $tr.remove();
        } else {
            var code = $(this).closest("tr").find("input[name='code[]']").val().substr(0, 2);
            $("tr.menu_group_"+code).remove();
        }

        if($("#menulist tr.menu_list").length < 1) {
            var list = "<tr id=\"empty_menu_list\"><td colspan=\"<?php echo $colspan; ?>\" class=\"empty_table\">자료가 없습니다.</td></tr>\n";
            $("#menulist table tbody").append(list);
        } else {
            $("#menulist tr.menu_list").each(function(index) {
                $(this).removeClass("bg0 bg1")
                    .addClass("bg"+(index % 2));
            });
        }
    });

    $(document).on("click", ".btn_del_submenu", function() {
        if (!confirm("메뉴를 삭제하시겠습니까?\n메뉴 삭제후 메뉴설정의 확인 버튼을 눌러 메뉴를 저장해 주세요."))
            return false;

        var $tr = $(this).closest("tr");
        if($tr.find("td.sub_menu_class").length > 0) {
			for ($i=0; $i < 100; $i++) {
				if($tr.next("tr").find("td.sub_menu2").length > 0) {
					$tr.next("tr").remove();
				} else {
					break;
				}
			}
			$tr.remove();
		}

		$("#menulist tr.menu_list").each(function(index) {
			$(this).removeClass("bg0 bg1")
				.addClass("bg"+(index % 2));
		});
    });
});

function add_menu()
{
    var max_code = base_convert(0, 10, 36);
    $("#menulist tr.menu_list").each(function() {
        var me_code = $(this).find("input[name='code[]']").val().substr(0, 2);
        if(max_code < me_code)
            max_code = me_code;
    });

    var url = "<?php echo G5_ADMIN_URL ?>/menu_form.php?code="+max_code+"&new=new";
    window.open(url, "add_menu", "left=100,top=100,width=550,height=650,scrollbars=yes,resizable=yes");
    return false;
}

function add_submenu(code)
{
    var url = "<?php echo G5_ADMIN_URL ?>/menu_form.php?code="+code+"&sub=1";
    window.open(url, "add_menu", "left=100,top=100,width=550,height=650,scrollbars=yes,resizable=yes");
    return false;
}

function add_submenu2(code)
{
    var url = "<?php echo G5_ADMIN_URL ?>/menu_form.php?code="+code;
    window.open(url, "add_menu", "left=100,top=100,width=550,height=650,scrollbars=yes,resizable=yes");
    return false;
}

function base_convert(number, frombase, tobase) {
  //  discuss at: http://phpjs.org/functions/base_convert/
  // original by: Philippe Baumann
  // improved by: Rafał Kukawski (http://blog.kukawski.pl)
  //   example 1: base_convert('A37334', 16, 2);
  //   returns 1: '101000110111001100110100'

  return parseInt(number + '', frombase | 0)
    .toString(tobase | 0);
}

function fmenulist_submit(f)
{

    var me_links = document.getElementsByName('me_link[]');
    var reg = /^javascript/; 

	for (i=0; i<me_links.length; i++){
        
	    if( reg.test(me_links[i].value) ){ 
        
            alert('링크에 자바스크립트문을 입력할수 없습니다.');
            me_links[i].focus();
            return false;
        }
    }

    return true;
}
</script>

<?php
require_once G5_ADMIN_PATH.'/admin.tail.php';