<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


/*  damoang-image-banner 위젯 데이터 파일 path */
// $wfile = (G5_IS_MOBILE) ? 'mo' : 'pc'; // the platform suffix of the widget data file name. 이미 이 변수가 세팅되어있어서 주석처리
// $widget_file = NA_DATA_PATH . '/widget/w-advertiser-adCollection-' . $wfile . '.php'; //현재 위젯 설정파일 path. 이미 이 변수가 세팅되어있어서 주석처리
$headBN_widget_file = NA_DATA_PATH . '/widget/w-damoang-image-banner-board-head-' . $wfile . '.php'; // damoang-image-banner 위젯 설정파일 path
$sideBN_widget_file = NA_DATA_PATH . '/widget/w-damoang-image-banner-side-banner-' . $wfile . '.php'; // damoang-image-banner 위젯 설정파일 path


/* setting the data sets of damoang-image-banner widget */
$wset_headBN = array(); // damoang-image-banner 위젯 설정파일 
$wset_sideBN = array(); // damoang-image-banner 위젯 설정파일 
$wset = array(); //현재 위젯 설정파일
if (is_file($headBN_widget_file))
    $wset_headBN = na_file_var_load($headBN_widget_file);
if (is_file($sideBN_widget_file))
    $wset_sideBN = na_file_var_load($sideBN_widget_file);
if (is_file($widget_file))
    $wset = na_file_var_load($widget_file);


/** damoang-image-banner 위젯의 긴배너 출력 */
function GetHeadBnHTML($wset_headBN)
{
    $banner_items = '';

    if (isset($wset_headBN['d']))
    {
        foreach ($wset_headBN['d']['img'] as $index => $img)
        {
            $link = $wset_headBN['d']['link'][$index];
            $alt = $wset_headBN['d']['alt'][$index];
            $target = $wset_headBN['d']['target'][$index];
            $action_name = isset($wset_headBN['action_name']) ? ' data-dd-action-name="' . htmlspecialchars($wset_headBN['action_name']) . '"' : '';

            $banner_items .= '<li class="list-group-item border-0">';
            $banner_items .= '<a href="' . htmlspecialchars($link) . '" target="' . htmlspecialchars($target) . '"' . $action_name . '>';
            $banner_items .= '<img src="' . htmlspecialchars($img) . '" alt="' . htmlspecialchars($alt) . '" class="mw-100">';
            $banner_items .= '</a>';
            $banner_items .= '</li>';
        }
    }

    $html = <<<EOT
<!-- 긴 배너 --------------------------------------------------------------- -->
<section class="container mb-5">
    <h3 class="border-bottom mb-4 pb-2">긴 배너</h3>
    <ul class="list-group row list-group-flush">
        $banner_items
    </ul>
</section>
EOT;

    return $html;
}

/** damoang-image-banner 위젯의 사이드배너 출력 */
function GetSideBnHTML($wset_sideBN)
{
    $banner_items = '';

    if (isset($wset_sideBN['d']))
    {
        foreach ($wset_sideBN['d']['img'] as $index => $img)
        {
            $link = $wset_sideBN['d']['link'][$index];
            $alt = $wset_sideBN['d']['alt'][$index];
            $target = $wset_sideBN['d']['target'][$index];
            $action_name = isset($wset_sideBN['action_name']) ? ' data-dd-action-name="' . $wset_sideBN['action_name'] . '"' : '';

            $banner_items .= '<li class="col list-group-item border-0">';
            $banner_items .= '<a href="' . htmlspecialchars($link) . '" target="' . htmlspecialchars($target) . '"' . $action_name . '>';
            $banner_items .= '<img src="' . htmlspecialchars($img) . '" alt="' . htmlspecialchars($alt) . '" class="mw-100">';
            $banner_items .= '</a>';
            $banner_items .= '</li>';
        }
    }

    $html = <<<EOT
<!-- 사이드 배너 ----------------------------------------------------------- -->
<section class="container my-5">
    <h3 class="border-bottom mb-4 pb-2">사이드 배너</h3>
    <ul class="text-center row row-cols-2 list-group list-group-horizontal list-group-flush">
        $banner_items
    </ul>
</section>
EOT;

    return $html;
}

/** (현재 위젯 데이터) 직접홍보 리스트 출력  */
function GetDirectAdvertisersHTML($wset)
{
    $advertiser_items = '';

    if (isset($wset['d']['names']))
    {
        foreach ($wset['d']['names'] as $name)
        {
            $advertiser_items .= '<li class="col list-group-item border-0">' . htmlspecialchars($name) . '</li>';
        }
    }

    $html = <<<EOT
<!-- 직접홍보 -------------------------------------------------------------- -->
<section class="container my-5">
    <h3 class="border-bottom mb-4 pb-2">
        직접홍보 게시판
        <small class="float-end"><a class="btn btn-sm btn-bd-light rounded-2" href="/promotion">🌻바로가기</a></small>
    </h3>
    <ul class="text-center row row-cols-2 row-cols-md-3 list-group list-group-horizontal list-group-flush" style="font-size: 0.875rem;">
        $advertiser_items
    </ul>
</section>
EOT;

    return $html;
}

/** 위젯 설정 Edit 버튼 */
function GetWidgetSettingsHTML($list, $list_cnt, $wset, $setup_href)
{
    $html = '';

    if ($list_cnt)
    {
        $link = $list[0]['link'] ? $list[0]['link'] : 'javascript:;';
        $target = $list[0]['target'];
        $img = $list[0]['img'];
        $action_name = isset($wset['action_name']) ? ' data-dd-action-name="' . $wset['action_name'] . '"' : '';

        $html .= <<<EOT
    <div class="mb-4">
        <a href="$link" target="$target"$action_name>
            <img src="$img" style="max-width: 100%;" />
        </a>
    </div>
EOT;
    }

    if ($setup_href)
    {
        $html .= <<<EOT
    <div class="btn-wset py-2">
        <button onclick="naClipView('$setup_href');" class="btn btn-basic btn-sm">
            <i class="bi bi-gear"></i> 광고주모음 위젯설정
        </button>
    </div>
EOT;
    }

    return $html;
}

/* HTML 출력 */
echo GetWidgetSettingsHTML($list, $list_cnt, $wset, $setup_href);
echo GetHeadBnHTML($wset_headBN);
echo GetSideBnHTML($wset_sideBN);
echo GetDirectAdvertisersHTML($wset);
