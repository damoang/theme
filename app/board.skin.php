<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 설정 기본 값
const DEFAULT_CATEGORY_MOVE_MESSAGE = '{{auth_member}}가 {{src_cat}}에서 {{dest_cat}}으로 이동시켰습니다.';

$boset['check_only_permit'] = $boset['check_only_permit'] ?? '0';
$boset['member_only_permit'] = $boset['member_only_permit'] ?? 'admin_only';
$boset['category_move_permit'] = $boset['category_move_permit'] ?? 'admin_only';
$boset['category_move_message'] = trim($boset['category_move_message'] ?? "");
// 기본값과 같으면 PLACEHOLDER 표시하기 위해
$boset['category_move_message'] = $boset['category_move_message'] == DEFAULT_CATEGORY_MOVE_MESSAGE ? "" : $boset['category_move_message'];
?>
<style>
    html, body {
        height: auto !important; }
</style>

<h2 class="fs-4 px-3 line-bottom pb-2 mb-0">
    <?php echo $board['bo_subject'] ?> 스킨 설정
</h2>

<?php
if(is_file($board_skin_path.'/setup.skin.php'))
    @include_once ($board_skin_path.'/setup.skin.php');
?>
<ul class="list-group list-group-flush">
    <li class="list-group-item bg-body-tertiary">
        <b>기능 설정</b>
    </li>
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">추가 관리자</label>
            <div class="col-md-10">
                <textarea id="idCheck<?php echo $idn; $idn++; ?>" rows="2" class="form-control" name="boset[bo_admin]"><?php echo isset($boset['bo_admin']) ? $boset['bo_admin'] : ''; ?></textarea>
                <div class="form-text">
                    회원 아이디를 콤마(,)로 구분하여 복수 회원 등록 가능
                </div>
            </div>
        </div>
    </li>

    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">새글 알림</label>
            <div class="col-md-10">
                <textarea rows="2" type="text" id="idCheck<?php echo $idn; $idn++; ?>" class="form-control" name="boset[noti_mb]"><?php echo isset($boset['noti_mb']) ? $boset['noti_mb'] : ''; ?></textarea>
                <div class="form-text">
                    새글 알림을 받을 회원 아이디를 콤마(,)로 구분하여 복수 회원 등록 가능
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">모바일 에디터</label>
            <div class="col-md-4">
                <select id="idCheck<?php echo $idn; $idn++; ?>" name="boset[editor_mo]" class="form-select">
                <option value="">기본 에디터 사용</option>
                <?php
                    $boset['editor_mo'] = isset($boset['editor_mo']) ? $boset['editor_mo'] : '';
                    $skinlist = na_dir_list(G5_EDITOR_PATH);
                    for ($k=0; $k<count($skinlist); $k++) {
                        echo '<option value="'.$skinlist[$k].'"'.get_selected($skinlist[$k], $boset['editor_mo']).'>'.$skinlist[$k].'</option>'.PHP_EOL;
                    }
                ?>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">태그 등록</label>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text col-4" id="idHead<?php echo $idn; ?>">회원 등급</span>
                    <?php $boset['tag'] = isset($boset['tag']) ? $boset['tag'] : ''; ?>
                    <select id="idSelect<?php echo $idn; ?>" name="boset[tag]" class="form-select">
                        <?php echo na_grade_options($boset['tag']); ?>
                    </select>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">경험치 적립</label>
            <div class="col-md-4">
                <div class="input-group mb-2">
                    <span class="input-group-text col-4" id="idAdd<?php echo $idn; ?>">글 쓰기</span>
                    <input type="text" name="boset[xp_write]" value="<?php echo isset($boset['xp_write']) ? $boset['xp_write'] : ''; ?>" aria-describedby="idAdd<?php echo $idn; ?>" id="idCheck<?php echo $idn; ?>" class="form-control">
                    <span class="input-group-text" id="idTail<?php echo $idn; $idn++; ?>">점</span>
                </div>

                <div class="input-group">
                    <span class="input-group-text col-4" id="idAdd<?php echo $idn; ?>">댓글 쓰기</span>
                    <input type="text" name="boset[xp_comment]" value="<?php echo isset($boset['xp_comment']) ? $boset['xp_comment'] : ''; ?>" aria-describedby="idAdd<?php echo $idn; ?>" id="idCheck<?php echo $idn; ?>" class="form-control">
                    <span class="input-group-text" id="idTail<?php echo $idn; $idn++; ?>">점</span>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label">부가 기능</label>
            <div class="col-md-10">
                <div class="form-check form-switch mb-2">
                    <?php $boset['post_convert'] = isset($boset['post_convert']) ? $boset['post_convert'] : ''; ?>
                    <input type="checkbox" name="boset[post_convert]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['post_convert'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">글 내용의 플랫폼 주소 자동 변환 사용안함</label>
                    <div class="form-text">
                        유튜브, 비메오, 카카오TV, 트위터, 인스타그램 등 주소 자동 변환 적용
                    </div>
                </div>

                <div class="form-check form-switch mb-2">
                    <?php $boset['video_attach'] = isset($boset['video_attach']) ? $boset['video_attach'] : ''; ?>
                    <input type="checkbox" name="boset[video_attach]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['video_attach'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">첨부 동영상 자동 출력안함</label>
                    <div class="form-text">
                        동일 파일명의 이미지 첨부시 표지 이미지 자동 적용
                    </div>
                </div>

                <div class="form-check form-switch mb-2">
                    <?php $boset['video_link'] = isset($boset['video_link']) ? $boset['video_link'] : ''; ?>
                    <input type="checkbox" name="boset[video_link]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['video_link'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">링크 동영상 자동 출력안함</label>
                    <div class="form-text">
                        관련 링크에 등록된 유튜브, 비메오 등 공유 주소
                    </div>
                </div>

                <div class="form-check form-switch mb-2">
                    <?php $boset['video_auto'] = isset($boset['video_auto']) ? $boset['video_auto'] : ''; ?>
                    <input type="checkbox" name="boset[video_auto]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['video_auto'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">동영상 자동 실행</label>
                    <div class="form-text">
                        복수 출력시 문제될 수 있으며, 크롬 등 브라우저에 따라 안될 수 있음
                    </div>
                </div>

                <div class="form-check form-switch mb-2">
                    <?php $boset['code'] = isset($boset['code']) ? $boset['code'] : ''; ?>
                    <input type="checkbox" name="boset[code]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['code'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">코드 하이라이터 사용</label>
                    <div class="form-text">
                        [code]...[/code]를 이용한 HTML, PHP 등 코드 등록
                    </div>
                </div>

                <div class="form-check form-switch mb-2">
                    <?php $boset['save_image'] = isset($boset['save_image']) ? $boset['save_image'] : ''; ?>
                    <input type="checkbox" name="boset[save_image]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['save_image'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">외부 이미지 서버 저장</label>
                    <div class="form-text">
                        게시물 본문에 있는 외부 이미지를 자동으로 서버에 저장
                    </div>
                </div>

                <div class="form-check form-switch mb-2">
                    <?php $boset['noti_no'] = isset($boset['noti_no']) ? $boset['noti_no'] : ''; ?>
                    <input type="checkbox" name="boset[noti_no]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['noti_no'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">알림 사용안함</label>
                    <div class="form-text">
                        답글/댓글/추천 등 알림 기능 끄기
                    </div>
                </div>

                <!-- 글쓰기 사용자 제한 -->
                <div class="form-check form-switch">
                    <?php $boset['check_write_permit'] = isset($boset['check_write_permit']) ? $boset['check_write_permit'] : ''; ?>
                    <input type="checkbox" name="boset[check_write_permit]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['check_write_permit'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">글쓰기 사용자 제한</label>
                    <div class="form-text">
                        허용된 회원만 글쓰기 가능
                    </div>
                </div>

                <!-- 회원만 보기 -->
                <div class="form-check form-switch">
                    <?php $boset['check_member_only'] = isset($boset['check_member_only']) ? $boset['check_member_only'] : ''; ?>
                    <input type="checkbox" name="boset[check_member_only]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['check_member_only'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">회원만 보기</label>
                    <div class="form-text">
                        글을 회원만 볼 수 있도록 제한하는 옵션 제공
                    </div>
                </div>

                <!-- 카테고리 이동 -->
                <div class="form-check form-switch">
                    <?php $boset['check_category_move'] = isset($boset['check_category_move']) ? $boset['check_category_move'] : ''; ?>
                    <input type="checkbox" name="boset[check_category_move]" id="idCheckCategoryMove<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['check_category_move'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheckCategoryMove<?php echo $idn; $idn++; ?>">카테고리 이동</label>
                    <div class="form-text">
                        권한이 있는 사용자만 카테고리를 이동할 수 있도록 제한하는 옵션 제공
                    </div>
                </div>
            </div>
        </div>
    </li>

    <li class="list-group-item bg-body-tertiary write_permit">
        <b>글쓰기 제한 추가 설정</b>
    </li>
    <li class="list-group-item write_permit">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">글쓰기 허용 아이디(1일 1개)</label>
            <div class="col-md-10">
                <textarea id="idCheck<?php echo $idn; $idn++; ?>" rows="2" class="form-control" name="boset[bo_write_allow_one]"><?php echo isset($boset['bo_write_allow_one']) ? $boset['bo_write_allow_one'] : ''; ?></textarea>
                <div class="form-text">
                    회원 아이디를 콤마(,)로 구분하여 복수 회원 등록 가능
                </div>
            </div>
        </div>
    </li>

    <li class="list-group-item write_permit">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">글쓰기 허용 아이디(1일 3개)</label>
            <div class="col-md-10">
                <textarea id="idCheck<?php echo $idn; $idn++; ?>" rows="2" class="form-control" name="boset[bo_write_allow_three]"><?php echo isset($boset['bo_write_allow_three']) ? $boset['bo_write_allow_three'] : ''; ?></textarea>
                <div class="form-text">
                    회원 아이디를 콤마(,)로 구분하여 복수 회원 등록 가능
                </div>
            </div>
        </div>
    </li>


    <li class="list-group-item bg-body-tertiary member_only">
        <b>회원만 보기 추가 설정</b>
    </li>
    <li class="list-group-item member_only">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">허용 대상</label>
            <div class="col-md-10">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="boset[member_only_permit]" id="inlineRadio1" value="admin_only" <?php echo get_checked('admin_only', $boset['member_only_permit'])?>>
                    <label class="form-check-label" for="inlineRadio1">관리자만 허용</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="boset[member_only_permit]" id="inlineRadio2" value="all" <?php echo get_checked('all', $boset['member_only_permit'])?>>
                    <label class="form-check-label" for="inlineRadio2">회원에게 허용</label>
                </div>
            </div>
        </div>
    </li>

    <li class="list-group-item bg-body-tertiary category_move">
        <b>카테고리 이동 추가 설정</b>
    </li>
    <li class="list-group-item category_move">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">허용 대상</label>
            <div class="col-md-10">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="boset[category_move_permit]" id="inlineRadio1" value="admin_only" <?php echo get_checked('admin_only', $boset['category_move_permit'])?>>
                    <label class="form-check-label" for="inlineRadio1">관리자만 허용</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="boset[category_move_permit]" id="inlineRadio2" value="admin_and_member" <?php echo get_checked('admin_and_member', $boset['category_move_permit'])?>>
                    <label class="form-check-label" for="inlineRadio2">글쓴이에게 허용</label>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item category_move">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="message_format">메세지 형식</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="message_format" name="boset[category_move_message]"
                       value="<?php echo $boset['category_move_message'] ?? ""; ?>"
                       placeholder="<?php echo DEFAULT_CATEGORY_MOVE_MESSAGE; ?>">
            </div>
        </div>
    </li>

    <li class="list-group-item bg-body-tertiary ">
        <b>댓글 설정</b>
    </li>
    <li class="list-group-item">
        <div class="row gx-2 align-items-center">
            <label class="col-md-2 col-form-label">댓글 이미지 용량 제한</label>
            <div class="col-md-10">
                <div class="form-check form-switch mb-2">
                    <?php $boset['comment_image_limit'] = isset($boset['comment_image_limit']) ? $boset['comment_image_limit'] : ''; ?>
                    <input type="checkbox" name="boset[comment_image_limit]" id="idCommentImageLimit" value="1"<?php echo get_checked('1', $boset['comment_image_limit'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCommentImageLimit">댓글 이미지 용량 제한 사용</label>
                </div>
                <div id="commentImageLimitSize" class="row" style="display: none;">
                    <div class="col-md-4">
                        <div class="input-group">
                            <?php $boset['comment_image_size'] = isset($boset['comment_image_size']) ? $boset['comment_image_size'] : ''; ?>
                            <input type="number" name="boset[comment_image_size]" value="<?php echo $boset['comment_image_size'] ?>" class="form-control">
                            <span class="input-group-text">bytes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2 align-items-center">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">댓글 변환</label>
            <div class="col-md-10">
                <div class="form-check form-switch">
                    <?php $boset['comment_convert'] = isset($boset['comment_convert']) ? $boset['comment_convert'] : ''; ?>
                    <input type="checkbox" name="boset[comment_convert]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['comment_convert'])?> class="form-check-input" role="switch">
                    <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">댓글 내용의 플랫폼 주소 자동 변환 사용안함</label>
                    <div class="form-text">
                        유튜브, 비메오, 카카오TV, 트위터, 인스타그램 등 주소 자동 변환 적용
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2 align-items-center">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">댓글 추천</label>
            <div class="col-md-10">
                <div class="d-flex gap-3">
                    <div class="form-check form-switch mb-0">
                        <?php $boset['comment_good'] = isset($boset['comment_good']) ? $boset['comment_good'] : ''; ?>
                        <input type="checkbox" name="boset[comment_good]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['comment_good'])?> class="form-check-input" role="switch">
                        <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">댓글 추천 사용</label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <?php $boset['comment_nogood'] = isset($boset['comment_nogood']) ? $boset['comment_nogood'] : ''; ?>
                        <input type="checkbox" name="boset[comment_nogood]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['comment_nogood'])?> class="form-check-input" role="switch">
                        <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">댓글 비추천 사용</label>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">페이징 댓글</label>
            <div class="col-md-4">
                <div class="input-group">
                    <?php $boset['comment_sort'] = isset($boset['comment_sort']) ? $boset['comment_sort'] : ''; ?>
                    <select id="idSelect<?php echo $idn; ?>" name="boset[comment_sort]" class="form-select">
                        <option value="old"<?php echo get_selected('old', $boset['comment_sort']) ?>>과거순</option>
                        <option value="new"<?php echo get_selected('new', $boset['comment_sort']) ?>>최신순</option>
                        <option value="good"<?php echo get_selected('good', $boset['comment_sort']) ?>>추천순</option>
                        <option value="nogood"<?php echo get_selected('nogood', $boset['comment_sort']) ?>>비추천순</option>
                    </select>
                    <span class="input-group-text" id="idHead<?php echo $idn; ?>">목록수</span>
                    <input type="text" name="boset[comment_rows]" value="<?php echo isset($boset['comment_rows']) ? $boset['comment_rows'] : ''; ?>" aria-describedby="idAdd<?php echo $idn; ?>" id="idCheck<?php echo $idn; ?>" class="form-control">
                    <span class="input-group-text" id="idAdd<?php echo $idn; $idn++; ?>">개</span>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">럭키 포인트</label>
            <div class="col-md-4">
                <div class="input-group mb-2">
                    <span class="input-group-text col-4" id="idTail<?php echo $idn; ?>">당첨 점수</span>
                    <input type="text" name="boset[lucky_point]" value="<?php echo isset($boset['lucky_point']) ? $boset['lucky_point'] : ''; ?>" aria-describedby="idAdd<?php echo $idn; ?>" id="idCheck<?php echo $idn; ?>" class="form-control">
                    <span class="input-group-text" id="idAdd<?php echo $idn; $idn++; ?>">점</span>
                </div>
                <div class="input-group">
                    <span class="input-group-text col-4" id="idTail<?php echo $idn; ?>">당첨 확률</span>
                    <input type="text" name="boset[lucky_dice]" value="<?php echo isset($boset['lucky_dice']) ? $boset['lucky_dice'] : ''; ?>" aria-describedby="idTail<?php echo $idn; ?>" id="idCheck<?php echo $idn; ?>" class="form-control">
                    <span class="input-group-text" id="idHead<?php echo $idn; ?>">분의 1</span>
                </div>
                <div class="form-text">
                    당첨 점수와 1/n의 당첨 확률을 모두 설정해야 작동됨
                </div>
            </div>
        </div>
    </li>
    <?php if(IS_EXTEND) { // 확장팩 ?>
    <li class="list-group-item bg-body-tertiary">
        <b>멤버십 설정</b>
    </li>
    <li class="list-group-item">
        <div class="row gx-2">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">멤버십 칼럼</label>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="idAdd<?php echo $idn; ?>">회원정보 DB 테이블의</span>
                    <input type="text" name="boset[mb_db]" value="<?php echo isset($boset['mb_db']) ? $boset['mb_db'] : ''; ?>" aria-describedby="idAdd<?php echo $idn; ?>" id="idCheck<?php echo $idn; ?>" class="form-control">
                    <span class="input-group-text" id="idTail<?php echo $idn; $idn++; ?>">칼럼</span>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row gx-2 align-items-center">
            <label class="col-md-2 col-form-label" for="idCheck<?php echo $idn; ?>">멤버십 대상</label>
            <div class="col-md-10">
                <div class="d-flex gap-3">
                    <div class="form-check form-switch mb-0">
                        <?php $boset['mbs_list'] = isset($boset['mbs_list']) ? $boset['mbs_list'] : ''; ?>
                        <input type="checkbox" name="boset[mbs_list]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['mbs_list'])?> class="form-check-input" role="switch">
                        <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">목록</label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <?php $boset['mbs_view'] = isset($boset['mbs_view']) ? $boset['mbs_view'] : ''; ?>
                        <input type="checkbox" name="boset[mbs_view]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['mbs_view'])?> class="form-check-input" role="switch">
                        <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">읽기</label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <?php $boset['mbs_write'] = isset($boset['mbs_write']) ? $boset['mbs_write'] : ''; ?>
                        <input type="checkbox" name="boset[mbs_write]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['mbs_write'])?> class="form-check-input" role="switch">
                        <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">쓰기</label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <?php $boset['mbs_downlaod'] = isset($boset['mbs_downlaod']) ? $boset['mbs_downlaod'] : ''; ?>
                        <input type="checkbox" name="boset[mbs_downlaod]" id="idCheck<?php echo $idn ?>" value="1"<?php echo get_checked('1', $boset['mbs_downlaod'])?> class="form-check-input" role="switch">
                        <label class="form-check-label" for="idCheck<?php echo $idn; $idn++; ?>">다운로드</label>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <?php } ?>
</ul>

<div class="sticky-bottom p-3 bg-body border-top">
    <div class="row justify-content-center g-3">
        <div class="col col-sm-4 col-md-3 col-lgx-2">
            <button type="submit" class="btn btn-danger w-100" onclick="document.pressed='reset'">초기화</button>
        </div>
        <div class="col col-sm-4 col-md-3 col-lgx-2">
            <button type="submit" class="btn btn-primary w-100" onclick="document.pressed='save'">저장하기</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // 글쓰기 사용자 제한 설정
        $("input[name='boset[check_write_permit]'").change(function() {
            if($(this).is(":checked")) {
                $("li.write_permit").slideDown();
            } else {
                $("li.write_permit").slideUp();
            }
        });
        $("input[name='boset[check_write_permit]'").triggerHandler('change');

        // 회원만 보기 설정
        $("input[name='boset[check_member_only]'").change(function() {
            if($(this).is(":checked")) {
                $("li.member_only").slideDown();
            } else {
                $("li.member_only").slideUp();
            }
        });
        $("input[name='boset[check_member_only]'").triggerHandler('change');

        // 카테고리 이동 설정
        $("input[name='boset[check_category_move]'").change(function() {
            if($(this).is(":checked")) {
                $("li.category_move").slideDown();
            } else {
                $("li.category_move").slideUp();
            }
        });
        $("input[name='boset[check_category_move]'").triggerHandler('change');
        // 댓글 용량 제한 설정
        $("#idCommentImageLimit").change(function() {
            if($(this).is(":checked")) {
                $("#commentImageLimitSize").slideDown();
            } else {
                $("#commentImageLimitSize").slideUp();
            }
        });
        $("#idCommentImageLimit").trigger('change');
    });

    function fsetup_submit(f) {
        if (document.pressed == "save") {
            var messageFormat = f.elements['boset[category_move_message]'].value;
            var allowedVariables = ['auth_member', 'src_cat', 'dest_cat'];
            var doubleBracePattern = /{{(.*?)}}/g;
            var invalidVariables = [];
            var hasBraceErrors = false;

            messageFormat = messageFormat.replace(doubleBracePattern, function(match, variable) {
                if (allowedVariables.includes(variable)) {
                    return '';
                } else {
                    invalidVariables.push(match);
                    return '';
                }
            });

            if (invalidVariables.length > 0) {
                var errorMessage = '메세지 형식에 올바르지 않은 변수가 사용되었습니다.\n\n';
                errorMessage += '허용된 변수: ' + allowedVariables.join(', ') + '\n\n';
                errorMessage += '잘못된 변수: ' + invalidVariables.join(', ') + '\n\n';
                na_alert(errorMessage, function() {
                    f.elements['boset[category_move_message]'].focus();
                });
                return false;
            }

            if (/[{}]/.test(messageFormat)) {
                na_alert('올바른 메세지 형식이 아닙니다.', function() {
                    f.elements['boset[category_move_message]'].focus();
                });
                return false;
            }

            // 설정 저장 확인
            na_confirm('PC/모바일 동일 설정값을 적용하시겠습니까?\n\n취소시 현재 모드의 설정값만 저장됩니다.', function() {
                var catMoveMSG = f.elements['boset[category_move_message]'];
                catMoveMSG.value = catMoveMSG.value === "" ? "<?php echo DEFAULT_CATEGORY_MOVE_MESSAGE; ?>" : catMoveMSG.value;
                f.both.value = 1;
                f.submit();
            }, function() {
                f.submit();
            });
        }

        if(document.pressed == "reset") {
            na_confirm('정말 초기화 하시겠습니까?\n\nPC/모바일 설정 모두 초기화 되며, 이전 설정값으로 복구할 수 없습니다.', function() {
                f.freset.value = 1;
                f.submit();
            });
        }

        return false;
    }
</script>

