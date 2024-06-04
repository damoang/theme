<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가
global $is_member, $member, $is_admin;
?>

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
                    <button type="button" class="widget-setup btn btn-basic btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="위젯설정">
                    <i class="bi bi-magic"></i>
                    <span class="visually-hidden">위젯설정</span>
                    </button>
                </div>
                <div>
                    <a href="<?php echo correct_goto_url(G5_ADMIN_URL) ?>" class="btn btn-basic btn-sm" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="관리자">
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

        <div class="row gx-2 mt-2">
        <div class="col">
            <button class="btn btn-basic btn-sm w-100 py-1" data-bs-toggle="offcanvas" data-bs-target="#memberOffcanvas"
            aria-controls="memberOffcanvas" role="button">
            <i class="bi bi-grid"></i>
            마이메뉴
            </button>
        </div>
        <div class="col">
            <a href="<?php echo G5_BBS_URL ?>/logout.php" class="btn btn-basic btn-sm w-100 py-1" role="button">
            <i class="bi bi-power"></i>
            로그아웃
            </a>
        </div>
    </div>

<?php } else { ?>

    <a class="btn btn-primary w-100 py-2 mb-2" href="#memberOffcanvas" data-bs-toggle="offcanvas"
    data-bs-target="#memberOffcanvas" aria-controls="memberOffcanvas" role="button">
    로그인
    </a>

    <div class="row gx-2">
        <div class="col">
            <a href="<?php echo G5_BBS_URL ?>/register.php" class="btn btn-basic btn-sm w-100">
            <i class="bi bi-person-plus"></i>
            회원가입
            </a>
        </div>
        <div class="col">
            <a href="<?php echo G5_BBS_URL ?>/password_lost.php" class="btn btn-basic btn-sm w-100">
            <i class="bi bi-search"></i>
            정보찾기
            </a>
        </div>
    </div>
<?php } ?>
