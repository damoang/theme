<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
    html, body {
        height: auto !important; }
</style>
<h2 class="px-3 my-2 fs-4">
    위젯 설정
</h2>
<ul class="list-group list-group-flush line-top border-bottom">
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label">
                위젯 정보
            </label>
            <div class="col-md-10">
                <div class="row align-items-center gx-2">
                    <label class="col-md-2 col-form-label">위젯 아이디</label>
                    <div class="col-md-10">
                        <?php echo $wid ?>
                    </div>
                </div>

                <div class="row align-items-center gx-2">
                    <label class="col-md-2 col-form-label">위젯 위치</label>
                    <div class="col-md-10">
                        <?php echo str_replace(G5_PATH, "", $widget_path) ?>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>
<?php
    $widget = '';
    if(is_file($widget_path.'/widget.setup.php'))
        @include_once ($widget_path.'/widget.setup.php');

    if($widget == 'board')
        @include_once (G5_THEME_PATH.'/app/widget.board.php');
    else if($widget == 'member')
        @include_once (G5_THEME_PATH.'/app/widget.member.php');
    else if($widget == 'item')
        @include_once (G5_THEME_PATH.'/app/widget.item.php');
    else if($widget == 'recommend')
        @include_once (G5_THEME_PATH.'/app/widget.recommend.php');
?>
<div class="sticky-bottom p-3 bg-body border-top">
    <div class="row justify-content-center g-3">
        <div class="col col-sm-4 col-md-3 col-lgx-2">
            <button type="submit" onclick="document.pressed='save'" class="btn btn-primary w-100">저장하기</button>
        </div>
        <div class="col col-sm-4 col-md-3 col-lgx-2 ms-5">
            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="document.pressed='reset'">초기화</button>
        </div>
    </div>
</div>

<script>
function fsetup_submit(f) {
    if(document.pressed == "reset") {
        na_confirm('정말 초기화 하시겠습니까?\n\nPC/모바일 설정 모두 초기화 되며, 이전 설정값으로 복구할 수 없습니다.', function() {
            f.freset.value = 1;
            f.submit();
        });
        return false;
    }  else {
        f.freset.value = null;
    }
}
</script>
