<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div class="text-center">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-basic" onclick="btnClip('emo', '<?php echo $is_dhtml_editor ?>');" title="이모티콘">
            <i class="bi bi-emoji-smile"></i>
            <span class="visually-hidden">이모티콘</span>
        </button>
        <button type="button" class="btn btn-basic" onclick="btnClip('icon', '<?php echo $is_dhtml_editor ?>');" title="아이콘">
            <i class="bi bi-ui-radios-grid"></i>
            <span class="visually-hidden">아이콘</span>
        </button>
        <button type="button" class="btn btn-basic" onclick="btnClip('video', '<?php echo $is_dhtml_editor ?>');" title="동영상">
            <i class="bi bi-camera-video"></i>
            <span class="visually-hidden">동영상</span>
        </button>
        <?php if(isset($boset['code']) && $boset['code']) { ?>
            <button type="button" class="btn btn-basic" onclick="btnClip('code', '<?php echo $is_dhtml_editor ?>');" title="코드">
                <i class="bi bi-code-slash"></i>
                <span class="visually-hidden">코드</span>
            </button>
        <?php } ?>
        <?php if(isset($nariya['kakaomap_key']) && $nariya['kakaomap_key']) { ?>
            <button type="button" class="btn btn-basic" onclick="btnClip('map', '<?php echo $is_dhtml_editor ?>');" title="지도">
                <i class="bi bi-geo-alt-fill"></i>
                <span class="visually-hidden">지도</span>
            </button>
        <?php } ?>
        <?php if ($is_member) { // 임시 저장된 글 기능 ?>
            <button type="button" id="btn_autosave" class="btn btn-basic" data-bs-toggle="offcanvas" data-bs-target="#autoSave" aria-controls="autoSave" title="임시 저장글">
                <i class="bi bi-save"></i>
                <span class="visually-hidden">임시저장글</span>
                <span id="autosave_count" class="orangered"><?php echo $autosave_count; ?></span>
            </button>
        <?php } ?>
    </div>
</div>

<?php if ($is_member) { // 임시 저장된 글 기능 ?>
    <script src="<?php echo G5_THEME_URL; ?>/js/autosave.js"></script>
    <?php
    if($editor_content_js)
        echo $editor_content_js;
    ?>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="autoSave" aria-labelledby="autoSaveLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="autoSaveLabel">임시 저장글 목록</h5>
            <button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div id="autosave_pop">
                <ul class="list-group list-group-flush border-top border-bottom"></ul>
            </div>
        </div>
    </div>
<?php } ?>

<script>
function btnClip(id, clip) {

    let url = '<?php echo G5_THEME_URL ?>/app/clip.' + id + '.php';

    if(clip)
        url += '?clip=1';

    naClipView(url);
}
</script>
