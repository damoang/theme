<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="modal fade" id="singoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form name="fsingoForm" id="fsingoForm">
                <input type="hidden" id="sg_table" name="sg_table" value="">
                <input type="hidden" id="sg_id" name="sg_id" value="">
                <input type="hidden" id="sg_flag" name="sg_flag" value="">
                <input type="hidden" id="sg_hid" name="hid" value="">
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="singo-text">신고 사유</span>
                        <select id="sg_type" name="sg_type" class="form-select" aria-describedby="singo-text">
                            <option value="">선택해 주세요.</option>
                            <?php
                                // 신고 항목
                                for($i=0; $i<count($singo_type);$i++) {
                                    if(!isset($singo_type[$i]) || !$singo_type[$i])
                                        continue;
                            ?>
                                <option value="<?php echo $i ?>"><?php echo $singo_type[$i] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-text mb-2">
                        <i class="bi bi-info-circle"></i>
                        명예훼손/저작권침해/기타와 같이 추가 내용이 필요한 경우 입력해 주세요.
                    </div>

                    <textarea class="form-control" name="sg_desc" rows="3" id="sg_desc"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                    <span class="visually-hidden">닫기</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="na_singo_submit();">
                    <i class="bi bi-eye-slash"></i>
                    신고하기
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="snsIconModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">

                <?php na_script('kakaotalk') ?>

                <div id="snsIconModalContent"></div>

                <div class="input-group mt-3">
                    <input type="text" id="snsUrlModal" class="form-control nofocus" aria-describedby="copy-sns" value="" readonly>
                    <button class="btn btn-primary sns-copy nofocus" type="button" id="copy-sns" data-clipboard-target="#snsUrlModal">
                        복사
                    </button>
                    <button type="button" class="btn btn-basic nofocus" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var singoModal = new bootstrap.Modal(document.getElementById('singoModal'));
var snsIconModal = new bootstrap.Modal(document.getElementById('snsIconModal'));
</script>
