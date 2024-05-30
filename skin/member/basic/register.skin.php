<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

// 소셜 로그인 가입
ob_start();
include_once(get_social_skin_path().'/social_register.skin.php');
$reg_social_login = ob_get_contents();
ob_end_clean();

?>

<form class="w-75 mx-auto py-md-5" name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

    <h3 class="px-3 py-2 mb-0 fs-4">
        <i class="bi bi-check2-square"></i>
        이용약관
    </h3>
    다모앙 웹사이트 운영자(이하 “운영자”)는 정보주체의 권리 보호를 위해 『개인정보 보호법』 및 관계 법령에 따라 개인정보를 수집·이용 합니다. 다음의 사항을 확인 후 동의하여 주시기 바랍니다.
    <ul class="list-group list-group-flush line-top border-bottom mb-4">
        <li class="list-group-item bg-body-tertiary">
            <div class="form-check form-check-inline form-switch">
                <input class="form-check-input" type="checkbox" name="chk_all" value="1" id="chk_all">
                <label class="form-control-label" for="chk_all"><b>이용약관 전체 동의</b></label>
            </div>
        </li>
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" name="agree" value="1" id="agree11">
                        <label class="form-check-label" for="agree11">(필수)회원가입약관 동의</label>
                    </div>
                </div>
                <div>
                    <a href="#none" data-bs-toggle="collapse" data-bs-target="#provision" aria-expanded="false" aria-controls="provision">
                        <i class="bi bi-chevron-down"></i>
                        <span class="d-none d-sm-inline-block">전문</span>
                    </a>
                </div>
            </div>
            <div class="collapse" id="provision">
                <div class="border my-2">
                    <?php if(is_file(G5_THEME_PATH.'/page/provision.php')) { ?>
                        <div class="overflow-auto py-3" style="height:calc(var(--bs-body-font-size)*10);">
                            <?php @include_once (G5_THEME_PATH.'/page/provision.php'); ?>
                        </div>
                    <?php } else { ?>
                        <textarea class="form-control border-0" rows="8" readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
                    <?php } ?>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" name="agree2" value="1" id="agree21">
                        <label class="form-check-label" for="agree21">(필수)개인정보 처리방침 동의</label>
                    </div>
                </div>
                <div>
                    <a href="#none" data-bs-toggle="collapse" data-bs-target="#privacy" aria-expanded="false" aria-controls="privacy">
                        <i class="bi bi-chevron-down"></i>
                        <span class="d-none d-sm-inline-block">전문</span>
                    </a>
                </div>
            </div>
            <div class="collapse" id="privacy">
                <div class="my-2">
                    <?php if(is_file(G5_THEME_PATH.'/page/privacy.php')) { ?>
                        <div class="border border-top-0">
                            <div class="overflow-auto py-3" style="height:calc(var(--bs-body-font-size)*10);">
                                <?php @include_once (G5_THEME_PATH.'/page/privacy.php'); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </li>

    </ul>
    <h3 class="px-3 py-2 mb-0 fs-4">
        <i class="bi bi-pencil-square"></i>
    (필수) 개인정보 수집 동의
    </h3>
    <ul class="list-group list-group-flush line-top border-bottom mb-4">


    <li class="list-group-item">

        <div class="my-2">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr class="bg-light">
                            <th class="text-center"> 개인정보 수집·이용 목적</th>
                            <th class="w-25 text-center"> 개인정보 항목</th>
                            <th class="w-25 text-center"> 보유 및 이용 기간</th>
                        </tr>
                        <tr>
                            <td>회원 관리 (이용자 식별 및 본인여부 확인)</td>
                            <td>
                                이름, 로그인 아이디(ID), 비밀번호, 이메일, 간편가입정보
                                <?php echo ($config['cf_cert_use'])? ", 암호화된 개인식별부호(CI)" : ""; ?>
                            </td>
                            <td>이용 종료 시점(회원 탈퇴 시) 까지 ※ 부정이용 방지를 위한 기록은 탈퇴 후 3년간 보유</td>
                        </tr>
                        <tr>
                            <td>회원 관리 및 상담 (서비스 이용에 관한 통지, CS대응을 위한 이용자 식별)</td>
                            <td>연락처 (이메일)</td>
                            <td>회원 탈퇴 시 까지 ※ 단, 관계 법령에 따라 보관이 필요한 기록은 탈퇴 후 법령이 정한 기한까지 보관합니다</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        ▶ 개인정보 수집 및 이용 동의를 거부할 권리가 있습니다. 단, 동의를 거부할 경우 다모앙 웹사이트 회원 가입이 제한됩니다.

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input" type="checkbox" name="agree2" value="1" id="agree21">
                    <label class="form-check-label" for="agree21">	(필수) 개인정보 수집 동의</label>
                </div>
            </div>

        </div>
    </ul>

    <h3 class="px-3 py-2 mb-0 fs-4">
        <i class="bi bi-pencil-square"></i>
        가입방법
    </h3>
    <ul class="list-group list-group-flush mb-4">
        <li class="list-group-item line-top">
<!--			<div class="row g-2 align-items-center">-->
<!--				<div class="col-sm-4 col-md-6">-->
<!--					<i class="bi bi-person"></i>-->
<!--					아이디로 가입-->
<!--				</div>-->
<!--				<div class="col-sm-8 col-md-6">-->
<!--					<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary w-100">-->
<!--						신규계정 생성-->
<!--						<i class="bi bi-arrow-right-circle"></i>-->
<!--					</button>-->
<!--				</div>-->
<!--			</div>-->
        </li>
        <?php if($reg_social_login) { ?>
        <li class="list-group-item">
            <?php echo $reg_social_login; ?>
        </li>
        <?php } ?>
        <li class="list-group-item text-center pt-3">
            <div class="row g-3 justify-content-center">
                <div class="col-6 col-sm-5 md-4 col-xl-3">
                    <a href="<?php echo G5_URL ?>" class="btn btn-basic btn-lg w-100">취소</a>
                </div>
            </div>
        </li>
    </ul>
</form>

<script>
    function fregister_submit(f) {
        if (!f.agree.checked) {
            na_alert('회원가입약관에 동의하셔야 회원가입 하실 수 있습니다.', function() {
                f.agree.focus();
            });
            return false;
        }

        if (!f.agree2.checked) {
            na_alert('개인정보 처리방침 안내에 동의하셔야 회원가입 하실 수 있습니다.', function() {
                f.agree2.focus();
            });
            return false;
        }

        return true;
    }

    $(function($){

        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });

        $("#sns-register .sns-wrap a").on("click", function() {
            if (!$("#agree11").is(":checked")) {
                na_alert('회원가입약관에 동의하셔야 회원가입 하실 수 있습니다.', function() {
                    $("#agree11").focus();
                });
                return false;
            };

            if (!$("#agree21").is(":checked")) {
                na_alert('개인정보 처리방침 안내에 동의하셔야 회원가입 하실 수 있습니다.', function() {
                    $("#agree21").focus();
                });
                return false;
            };
        });
    });
</script>
