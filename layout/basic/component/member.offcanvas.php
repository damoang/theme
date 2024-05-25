<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
#memberOffcanvas .offcanvas-title .btn-member {
display: none;
}
</style>
<div class="offcanvas offcanvas-end" tabindex="-1" id="memberOffcanvas" aria-labelledby="memberOffcanvasLabel">
<div class="offcanvas-header">
    <h5 class="offcanvas-title ps-3" id="memberOffcanvasLabel">
    <?php echo $offcanvas_buttons ?>
    </h5>
    <button type="button" class="btn-close nofocus" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body pt-0">
    <div class="px-3">
    <?php if($is_member) { ?>
        <div class="d-flex align-items-center my-2">
            <div class="pe-2">
            <a href="<?php echo G5_BBS_URL ?>/myphoto.php" target="_blank" class="win_memo" title="내 사진 관리">
                <img src="<?php echo na_member_photo($member['mb_id']); ?>" class="rounded-circle" style="max-width:60px;">
            </a>
            </div>
            <div class="flex-grow-1 ps-1">
            <div class="d-flex gap-1">
                <div>
                <h4 class="fs-5 lh-base mb-0 fw-bold hide-profile-img" style="letter-spacing:-1px;">
                    <?php echo str_replace('sv_member', 'sv_member ellipsis-1', $member['sideview']) ?>
                </h4>
                </div>
                <?php if ($is_admin === 'super') { ?>
                <div class="ms-auto">
                <button type="button" class="widget-setup btn btn-basic btn-sm" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="위젯설정">
                    <i class="bi bi-magic"></i>
                    <span class="visually-hidden">위젯설정</span>
                </button>
                </div>
                <div>
                <a href="<?php echo correct_goto_url(G5_ADMIN_URL) ?>" class="btn btn-basic btn-sm"
                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="관리자">
                    <i class="bi bi-gear"></i>
                    <span class="visually-hidden">관리자</span>
                </a>

                </div>
                <?php } ?>
            </div>
            <span class="small">
                <?php echo ($member['mb_grade']) ? $member['mb_grade'] : $member['mb_level'].'등급'; ?>
            </span>
            </div>
        </div>
        <?php
            $member['as_max'] = (isset($member['as_max']) && $member['as_max'] > 0) ? $member['as_max'] : 1;
            $per = (int)(($member['as_exp'] / $member['as_max']) * 100);
        ?>
        <!-- <div class="d-flex justify-content-between mb-1 small">
            <div>Lv.<?php echo $member['as_level'] ?></div>
            <div>
                <a href="<?php echo G5_BBS_URL ?>/exp.php" target="_blank" class="win_point">
                    Exp <?php echo number_format($member['as_exp']) ?>
                </a>
            </div>
        </div>

        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Next <?php echo number_format($member['as_max'] - $member['as_exp']) ?>">
            <div class="progress" role="progressbar" aria-label="Exp" aria-valuenow="<?php echo $per ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-striped progress-bar-animated small" style="width: <?php echo $per ?>%"><?php echo $per ?>%</div>
            </div>
        </div> -->

        <a href="<?php echo G5_BBS_URL ?>/logout.php" class="btn btn-primary btn-lg w-100 my-2" role="button">
            <i class="bi bi-power"></i>
            로그아웃
        </a>

        <?php if($config['cf_use_point']) { ?>
        <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="win_point btn btn-basic w-100 py-2 mb-2">
            <i class="ms-1 bi bi-database"></i>
            <?php echo number_format($member['mb_point']) ?> 포인트
        </a>
        <?php } ?>

        <div class="row g-2 mb-3">
            <div class="col-3">
            <a href="<?php echo G5_BBS_URL ?>/memo.php" class="win_memo btn btn-basic btn-sm w-100 pb-2 pt-1">
                <i class="bi bi-envelope fs-3"></i>
                <span class="d-block text-truncate small">
                <?php if ($member['mb_memo_cnt']) { ?>
                <div class="spinner-grow" role="status" style="--bs-spinner-width: 0.7rem; --bs-spinner-height: 0.7rem;">
                    <span class="visually-hidden">미확인 쪽지 <?php echo $member['mb_memo_cnt'] ?>통이 있습니다.</span>
                </div>
                <?php } ?>
                쪽지
                </span>
            </a>
        </div>
        <div class="col-3">
            <a href="<?php echo G5_BBS_URL ?>/noti.php" data-bs-toggle="offcanvas" data-bs-target="#notiOffcanvas"
                aria-controls="notiOffcanvas" class="memo btn btn-basic btn-sm w-100 pb-2 pt-1">
                <i class="bi bi bi-bell fs-3"></i>
                <span class="d-block text-truncate small">
                <?php if ($member['as_noti']) { ?>
                <div class="spinner-grow" role="status" style="--bs-spinner-width: 0.7rem; --bs-spinner-height: 0.7rem;">
                    <span class="visually-hidden">미확인 알림 <?php echo $member['as_noti'] ?>개가 있습니다.</span>
                </div>
                <?php } ?>
                알림
                </span>
            </a>
        </div>
        <?php
        $iRow = array();
        $iRow[] = array('bi-bookmark-star', '스크랩', 'col-3', 'win_scrap ', G5_BBS_URL.'/scrap.php');
        $iRow[] = array('bi-eye-slash', '신고글', 'col-3', 'win_memo ', G5_BBS_URL.'/singo.php');
        $iRow[] = array('bi-person-slash', '차단회원', 'col-3', 'win_memo ', G5_BBS_URL.'/chadan.php');
        $iRow[] = array('bi-person-circle', '회원사진', 'col-3', 'win_memo ', G5_BBS_URL.'/myphoto.php');
        $iRow[] = array('bi-person-gear', '정보수정', 'col-3', '', G5_BBS_URL.'/member_confirm.php?url=register_form.php');
        $iRow[] = array('bi-box-arrow-right', '회원탈퇴', 'col-3', '', G5_BBS_URL.'/member_confirm.php?url=member_leave.php');

        for ($i=0; $i < count($iRow); $i++) {
        ?>
            <div class="<?php echo $iRow[$i][2] ?>">
                <a href="<?php echo $iRow[$i][4] ?>" class="<?php echo $iRow[$i][3] ?>btn btn-basic btn-sm w-100 pb-2 pt-1">
                    <i class="bi <?php echo $iRow[$i][0] ?> fs-3"></i>
                    <span class="d-block text-truncate small">
                    <?php echo $iRow[$i][1] ?>
                    </span>
                </a>
            </div>
        <?php } ?>
    </div>

    <?php
    // 커스텀UI
    include __DIR__ . '/member.offcanvas-customui.php';
    ?>

    <?php } else { ?>
        <?php
        // 개발환경에서 아이디로 로그인 활성화
        if (
            in_array($_ENV['APP_ENV'] ?? 'prod', ['dev', 'rc', 'stage', 'local'])
            || ($_ENV['DA_ID_LOGIN'] ?? 'false') === 'true'
        ) { ?>
            <form id="memberLogin" class="pt-1" name="memberLogin" method="post" action="<?php echo G5_HTTPS_BBS_URL ?>/login_check.php" autocomplete="off">
                <input type="hidden" name="url" value="<?php echo $urlencode; ?>">
                <div class="input-group mb-2">
                    <span class="input-group-text">
                        <i class="bi bi-person text-muted"></i>
                    </span>
                    <div class="form-floating">
                        <input type="text" name="mb_id" id="memberId" class="form-control required nofocus" placeholder="아이디">
                        <label for="mb_id100">아이디</label>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="bi bi-shield-lock text-muted"></i>
                    </span>
                    <div class="form-floating">
                        <input type="password" name="mb_password" id="memberPw" class="form-control required nofocus" placeholder="비밀번호">
                        <label for="mb_pw100">비밀번호</label>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-3">
                    <div>
                        <a href="<?php echo G5_BBS_URL ?>/register.php" class="btn btn-basic py-2">
                            <i class="bi bi-person-plus"></i>
                            회원가입
                        </a>
                    </div>
                    <div class="flex-grow-1">
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            로그인
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="form-check form-check-inline form-switch">
                            <input class="form-check-input auto-login" type="checkbox" name="auto_login" role="switch" id="memberAutoLogin">
                            <label class="form-check-label" for="memberAutoLogin">자동로그인</label>
                        </div>
                    </div>
                    <div>
                        <a href="<?php echo G5_BBS_URL ?>/password_lost.php">
                            <i class="bi bi-search"></i>
                            아이디/비밀번호 찾기
                        </a>
                    </div>
                </div>
            </form>
        <?php } ?>

        <?php
        // 소셜로그인 사용시 소셜로그인 버튼
        @include_once(get_social_skin_path().'/social_login.offcanvas.php');
        ?>
    <?php } ?>
    </div>
</div>
</div>
