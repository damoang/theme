<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 배너 높이
$wset['height'] = (isset($wset['height']) && $wset['height']) ? $wset['height'] : '100';
$wset['min_height'] = (isset($wset['min_height']) && $wset['min_height']) ? $wset['min_height'] : '200';

// 배너 위치
$wset['position'] = (isset($wset['position']) && $wset['position']) ? $wset['position'] : '메인';

// 배너 추출
$list = na_shop_banner_rows($wset);

// 에러 발생시
if(isset($list['error'])) {
    echo $list['error'];
    return;
}

// 데모설정
if(empty($list)) {
    $bn_img = (IS_SHOP) ? LAYOUT_URL.'/img/title-shop.jpg' : LAYOUT_URL.'/img/title-bbs.jpg';
    $bn_alt = '배너관리에서 메인 배너 등록 후 위젯설정';
    $bn_url = G5_ADMIN_URL.'/shop_admin/bannerlist.php';
    $list[] = array('bn_img'=>$bn_img, 'bn_alt'=>$bn_alt, 'bn_url'=>$bn_url, 'bn_new_win'=>'', 'bn_border'=>'');
    $list[] = array('bn_img'=>$bn_img, 'bn_alt'=>$bn_alt, 'bn_url'=>$bn_url, 'bn_new_win'=>'', 'bn_border'=>'');
    $list[] = array('bn_img'=>$bn_img, 'bn_alt'=>$bn_alt, 'bn_url'=>$bn_url, 'bn_new_win'=>'', 'bn_border'=>'');

}

$list_cnt = count($list);

// 랜덤 아이디
$id = 'banner-'.na_rid();

// 캐러셀 내 컨텐츠 위치
$align = (isset($wset['align']) && $wset['align']) ? $wset['align'] : 'order';

$is_order = false;
if($align == 'rand' || $align == 'order') {
    $is_order = true;
    $aligns = array('text-start', 'text-center', 'text-end');
    if($align == 'rand')
        shuffle($aligns);
} else {
    $aligns[0] = $align;
}

?>
<style>
#<?php echo $id ?> .container {
    height: <?php echo $wset['height'] ?>vh !important; min-height: <?php echo $wset['min_height'] ?>px !important; }
</style>
<div id="<?php echo $id ?>" class="carousel slide bg-secondary" data-bs-ride="carousel">
    <?php if($list_cnt > 1) { ?>
        <div class="carousel-indicators">
        <?php for ($i=0; $i < $list_cnt; $i++) { ?>
            <button type="button" data-bs-target="#<?php echo $id ?>" data-bs-slide-to="<?php echo $i ?>" aria-label="<?php echo $list[$i]['bn_alt'] ?>"<?php echo ($i) ? '' : ' class="active" aria-current="true"';?>></button>
        <?php } ?>
        </div>
    <?php } ?>
    <div class="carousel-inner">
    <?php for ($i=0; $i < $list_cnt; $i++) {

        $row = $list[$i];

        if($is_order) {
            $n = ($i%3 == 0) ? 0 : $n;
        } else {
            $n = 0;
        }
    ?>
        <div class="carousel-item bg-cover<?php echo ($i) ? '' : ' active';?>" style="background-image: url('<?php echo $row['bn_img'] ?>');">
            <?php if (!$row['bn_border']) { ?>
                <div class="bg-raster position-absolute w-100 h-100"></div>
            <?php } ?>
            <div class="container position-relative d-flex align-items-center text-white" style="z-index:1;">
                <div class="<?php echo $aligns[$n] ?> px-5 w-100">
                    <h2 class="lh-base fs-1"><?php echo $row['bn_alt'] ?></h2>
                    <?php if($row['bn_url']) { ?>
                        <div class="pt-3">
                            <a class="btn btn-lg btn-outline-light py-2" href="<?php echo $row['bn_url'] ?>"<?php echo ($row['bn_new_win']) ? ' target="_blank"' : ''; ?>>
                                View more
                                <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php $n++; } ?>
    </div>
    <?php if($list_cnt > 1) { ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $id ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $id ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    <?php } ?>
</div>

<?php if($setup_href) { ?>
    <div class="btn-wset py-2">
        <button onclick="naClipView('<?php echo $setup_href ?>');" class="btn btn-basic btn-sm">
            <i class="bi bi-gear"></i>
            위젯설정
        </button>
    </div>
<?php } ?>
