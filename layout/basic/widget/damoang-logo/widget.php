<?php
if (!defined('_GNUBOARD_'))
    exit; //개별 페이지 접근 불가

$list = array();

$n = 0;
//print_r($wset['d']['img']);
if (isset($wset['d']['img']) && is_array($wset['d']['img'])) {
    $data_cnt = count($wset['d']['img']);
    for ($i = 0; $i < $data_cnt; $i++) {
        if (isset($wset['d']['img'][$i]) && $wset['d']['img'][$i]) {
            $list[$n]['img'] = na_url($wset['d']['img'][$i]);
            $list[$n]['alt'] = isset($wset['d']['alt'][$i]) ? get_text($wset['d']['alt'][$i]) : '';
            $list[$n]['height'] = isset($wset['d']['height'][$i]) ? get_text($wset['d']['height'][$i]) : '';
            $n++;
        }
    }
}

$list_cnt = $n;

// 랜덤
shuffle($list);
$id = 'carousel_' . na_rid();
?>

<?php if ($list_cnt) { ?>
    <a href="/" class="fs-2 fw-bold" title="다모앙">
        <img src="<?php echo $list[0]['img'] ?>" alt="다모앙" height="<?php echo ($list[0]['height'])?$list[0]['height']:48 ?>" />
    </a> <?php echo $list[0]['alt'] ?>
<?php } ?>

<?php if ($setup_href) { ?>
    <button onclick="naClipView('<?php echo $setup_href ?>');" class="btn btn-basic btn-sm btn-wset">
        <i class="bi bi-gear"></i>
        위젯설정
    </button>
<?php } ?>
