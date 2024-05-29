<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="naClip" aria-labelledby="naClipLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="naClipLabel">&nbsp;</h5>
        <button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body overflow-y-hidden py-0">
        <div class="container">
            <div id="naClipView"></div>
        </div>
    </div>
</div>
<?php
include_once(LAYOUT_PATH.'/tail.sub.php');

echo na_seo(html_end()); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다.

if($is_admin == 'super' && isset($begin_time) && isset($page_id)) {
    echo PHP_EOL.'<!-- PAGE ID : '.$page_id.' -->';
    echo PHP_EOL.'<!-- RUN TIME : '.(get_microtime() - $begin_time).' -->';
}
