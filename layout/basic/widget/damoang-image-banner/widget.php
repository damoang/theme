<?php
if (!defined('_GNUBOARD_'))
    exit; //개별 페이지 접근 불가

$list = array();

$n = 0;
if (isset($wset['d']['img']) && is_array($wset['d']['img'])) {
    $data_cnt = count($wset['d']['img']);
    for ($i = 0; $i < $data_cnt; $i++) {
        if (isset($wset['d']['img'][$i]) && $wset['d']['img'][$i]) {
            $list[$n]['img'] = na_url($wset['d']['img'][$i]);
            $list[$n]['link'] = isset($wset['d']['link'][$i]) ? na_url($wset['d']['link'][$i]) : '';
            $list[$n]['alt'] = isset($wset['d']['alt'][$i]) ? get_text($wset['d']['alt'][$i]) : '';
            $list[$n]['target'] = isset($wset['d']['target'][$i]) ? $wset['d']['target'][$i] : '_self';
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
    <div class="mb-4">
        <a href="<?php echo ($list[0]['link']) ? $list[0]['link'] : 'javascript:;'; ?>" target="<?php echo $list[0]['target'] ?>" <?php if ($wset['action_name'] ?? '') { ?>data-dd-action-name="<?= $wset['action_name'] ?>" <?php } ?>>
            <img src="<?php echo $list[0]['img'] ?>" style="max-width: 100%;" />
        </a>
    </div>
<?php } ?>

<?php if ($setup_href) { ?>
    <div class="btn-wset py-2">
        <button onclick="naClipView('<?php echo $setup_href ?>');" class="btn btn-basic btn-sm">
            <i class="bi bi-gear"></i>
            위젯설정
        </button>
    </div>
<?php } ?>
