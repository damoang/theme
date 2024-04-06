<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);

if ($config['cf_cert_use'] && ($config['cf_cert_simple'] || $config['cf_cert_ipin'] || $config['cf_cert_hp']))
    add_javascript('<script src="'.G5_JS_URL.'/certify.js?v='.G5_JS_VER.'"></script>', 0);
?>
<!-- 기존 회원 본인인증 시작 { -->
<div class="max-600 mx-auto py-md-5 mb-4">
    <form name="fcertrefreshform" id="member_cert_refresh" action="<?php echo $action_url ?>" onsubmit="return fcertrefreshform_submit(this);" method="POST" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="url" value="<?php echo $urlencode ?>">
	<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="mb_id" value="<?php echo $member['mb_id']; ?>">
    <input type="hidden" name="mb_hp" value="<?php echo $member['mb_hp']; ?>">
    <input type="hidden" name="mb_name" value="<?php echo $member['mb_name']; ?>">
	<input type="hidden" name="cert_no" value="">

	<h3 class="px-3 py-2 mb-0 fs-4">
		<i class="bi bi-check2-square"></i>
		추가 개인정보처리방침 안내
	</h3>		
	<ul class="list-group list-group-flush line-top mb-4">
		<li class="list-group-item py-0">
			<table class="table mb-0">
			<thead>
			<tr class="bg-light">
				<th class="text-center">구분</th>
				<th class="text-center">내용</th>
			</tr>
			</thead>
			<tbody class="table-group-divider">
			<tr>
				<td>목적</td>
				<td>이용자 식별 및 본인여부 확인</td>
			</tr>
			<tr>
				<td>항목</td>
				<td>생년월일<?php echo (empty($member['mb_dupinfo']))? ", 휴대폰 번호(아이핀 제외)" : ""; ?>, 암호화된 개인식별부호(CI)</td>
			</tr>
			<tr>
				<td class="border-bottom-0 text-nowrap">보유기간</td>
				<td class="border-bottom-0">회원 탈퇴 시까지</td>
			</tr>
			</tbody>
			</table>
		</li>
		<li class="list-group-item">
			<div class="form-check form-switch mb-0">
				<input class="form-check-input" type="checkbox" role="switch" id="agree21" name="agree2" value="1" >
				<label class="form-check-label" for="agree21">(필수)추가 개인정보처리방침에 동의합니다.</label>
			</div>
		</li>
	</ul>

	<h3 class="px-3 my-2 fs-4">
		<i class="bi bi-check2-square"></i>
		인증수단 선택하기
	</h3>		
	<ul class="list-group list-group-flush line-top mb-4">
		<li class="list-group-item" id="find_info">
            <?php
            if ($config['cf_cert_use']) {
                if ($config['cf_cert_simple'])
                    echo '<button type="button" id="win_sa_kakao_cert" class="btn btn-primary win_sa_cert my-1 me-2" data-type="">간편인증</button>';
                if ($config['cf_cert_hp'])
                    echo '<button type="button" id="win_hp_cert" class="btn btn-primary my-1 me-2">휴대폰 본인확인</button>';
                if ($config['cf_cert_ipin'])
                    echo '<button type="button" id="win_ipin_cert" class="btn btn-primary my-1">아이핀 본인확인</button>';
            }
            ?>
			<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>
        </li>
	</ul>
    </form>

    <script>
        $(function() {
            var pageTypeParam = "pageType=register";
            var f = document.fcertrefreshform;

            <?php if ($config['cf_cert_use'] && $config['cf_cert_simple']) { ?>
                // 이니시스 간편인증
                var url = "<?php echo G5_INICERT_URL; ?>/ini_request.php";
                var type = "";
                var params = "";
                var request_url = "";

                $(".win_sa_cert").click(function() {
                    if (!fcertrefreshform_submit(f)) return false;
                    type = $(this).data("type");
                    params = "?directAgency=" + type + "&" + pageTypeParam;
                    request_url = url + params;
                    call_sa(request_url);
                });
            <?php } ?>

            <?php if ($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
                // 아이핀인증
                var params = "";
                $("#win_ipin_cert").click(function() {
                    if (!fcertrefreshform_submit(f)) return false;
                    params = "?" + pageTypeParam;
                    var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php" + params;
                    certify_win_open('kcb-ipin', url);
                    return;
                });
            <?php } ?>

            <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                // 휴대폰인증
                var params = "";
                $("#win_hp_cert").click(function() {
                    if (!fcertrefreshform_submit(f)) return false;
                    params = "?" + pageTypeParam;
                    <?php
                    switch ($config['cf_cert_hp']) {
                        case 'kcb':
                            $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                            $cert_type = 'kcb-hp';
                            break;
                        case 'kcp':
                            $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                            $cert_type = 'kcp-hp';
                            break;
                        case 'lg':
                            $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                            $cert_type = 'lg-hp';
                            break;
						default:
							$cert_url = '';
							$cert_type = '';
							break;
					}

					if(!$cert_url) {
					?>
						na_alert('기본환경설정에서 휴대폰 본인확인 설정을 해주십시오.');
						return false;
					<?php } ?>

                    certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>" + params);
                    return;
                });
            <?php } ?>
        });
        
        function fcertrefreshform_submit(f) {
            if (!f.agree2.checked) {
				na_alert('추가 개인정보처리방침에 동의하셔야 인증을 진행하실 수 있습니다.', function() {
	                f.agree2.focus();
				});
                return false;
            }
            return true;
        }
    </script>
</div>
<!-- } 기존 회원 본인인증 끝 -->