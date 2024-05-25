<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
?>
<ul id="ui-custom-ul" class="p-0">
    <li class="list-group-item">
        <div class="row align-items-center">
            <label for="reg_ui_custom" class="col-form-label" style="width:100%;text-align:center;margin-top:40px;">개인화면설정</label>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row align-items-center">
            <label class="form-check-label">※ 현재 브라우저에만 저장됩니다.</label>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row align-items-center">
            <label for="reg_ui_custom" class="col-sm-5 col-form-label">UI 커스텀</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="ui_custom" value="1" role="switch" id="reg_ui_custom" data-gtm-form-interact-field-id="0">
                </div>
            </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row">
            <label for="reg_show_width" class="col-sm-5 col-form-label">화면너비(px)</label>
            <div class="col-sm-7">
                <input type="number" id="reg_show_width" name="show_width" placeholder="1200" class="form-control ui_custom_items" data-gtm-form-interact-field-id="1" value="1200" min="1000">
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row">
            <label for="reg_font_family" class="col-sm-5 col-form-label">글씨체</label>
            <div class="col-sm-7">
                <input type="text" id="reg_font_family" name="font_family" value="" class="form-control ui_custom_items ">
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row">
            <label for="reg_font_size" class="col-sm-5 col-form-label">글씨 크기(em)</label>
            <div class="col-sm-7">
                <input type="number" id="reg_font_size" name="font_size" class="form-control ui_custom_items" step="0.1" data-gtm-form-interact-field-id="0" placeholder="1" value="1" min="0.3">
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row">
            <label for="reg_line_height" class="col-sm-5 col-form-label">줄높이</label>
            <div class="col-sm-7">
                <input type="number" id="reg_line_height" name="line_height" class="form-control ui_custom_items" step="0.1" placeholder="1.5" value="1.5" min="0.1">
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row">
            <label for="reg_menu_width" class="col-sm-5 col-form-label">메뉴너비(%)</label>
            <div class="col-sm-7">
                <input type="number" id="reg_menu_width" name="menu_width" class="form-control ui_custom_items " step="0.1" placeholder="25" value="25" data-gtm-form-interact-field-id="2" min="10" max="50">
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_back_button" class="col-sm-5 col-form-label">뒤로 가기 버튼</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="back_button" value="1" role="switch" id="reg_back_button" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_left_menu" class="col-sm-5 col-form-label">좌측 메뉴</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="left_menu" value="1" role="switch" id="reg_left_menu" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_left_menu_over" class="col-sm-5 col-form-label">좌측 오버 메뉴</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="left_menu_over" value="1" role="switch" id="reg_left_menu_over" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_left_quick_button" class="col-sm-5 col-form-label">좌측 퀵버튼</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="left_quick_button" value="1" role="switch" id="reg_left_quick_button" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_expand_quick" class="col-sm-5 col-form-label">확장 퀵버튼</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="expand_quick" value="1" role="switch" id="reg_expand_quick" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item ui-custom-expand-item">
        <div class="row align-items-center">
            <label for="reg_expand_write" class="col-sm-5 col-form-label">확장 퀵버튼 사용 - 글 작성, 댓글 작성</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="expand_write" value="1" role="switch" id="reg_expand_write" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item ui-custom-expand-item">
        <div class="row align-items-center">
            <label for="reg_expand_mywr" class="col-sm-5 col-form-label">확장 퀵버튼 사용 - 내 글, 내 댓글</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="expand_mywr" value="1" role="switch" id="reg_expand_mywr" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item ui-custom-expand-item">
        <div class="row align-items-center">
            <label for="expand_navigator" class="col-sm-5 col-form-label">확장 퀵버튼 사용 - 앞으로, 뒤로</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="expand_navigator" value="1" role="switch" id="reg_expand_navigator" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>

    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_menu_scroll" class="col-sm-5 col-form-label">메뉴 스크롤</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="menu_scroll" value="1" role="switch" id="reg_menu_scroll" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_list_search" class="col-sm-5 col-form-label">목록 검색창</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="list_search" value="1" role="switch" id="reg_list_search" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_list_toggle" class="col-sm-5 col-form-label">목록 토글(D)</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="list_toggle" value="1"
                        role="switch" id="reg_list_toggle" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_hide_nick" class="col-sm-5 col-form-label">닉감추기</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="hide_nick" value="1" role="switch" id="reg_hide_nick" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_hide_member_memo" class="col-sm-5 col-form-label">회원메모 가리기</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="hide_member_memo" value="1" role="switch" id="reg_hide_member_memo" data-gtm-form-interact-field-id="0">
                    <button type="button" id="btn_memo_toggle" class="btn btn-primary btn-sm">토글</button>(M)
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_hide_list_memo" class="col-sm-5 col-form-label">메모목록 가리기</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="hide_list_memo" id="reg_hide_list_memo">
                    <option value="">사용안함</option>
                    <option value="all">전체</option>
                    <option value="yellow">노랑</option>
                    <option value="green">초록</option>
                    <option value="purple">보라</option>
                    <option value="red">빨강</option>
                    <option value="blue">파랑</option>
                </select>
                <!-- <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="hide_list_memo" value="1" role="switch" id="reg_hide_list_memo" data-gtm-form-interact-field-id="0">
                </div> -->
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item ui-custom-memo-ip-check d-none">
        <div class="row align-items-center">
            <label for="reg_memo_ip_track" class="col-sm-5 col-form-label">메모 유저 IP 체크</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="memo_ip_track" value="1" role="switch" id="reg_memo_ip_track" data-gtm-form-interact-field-id="0">
                    <button type="button" id="btn_memo_ip_clear" class="btn btn-primary btn-sm">삭제</button>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-item">
        <div class="row align-items-center">
            <label for="reg_mymenu_img" class="col-sm-5 col-form-label">마이메뉴 이미지</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="mymenu_img" value="1" role="switch" id="reg_mymenu_img" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>

    <!-- 읽은 글 기록 ------------------------------------------------------ -->
    <li class="list-group-item">
        <div class="row align-items-center">
            <label for="reg_read_history" class="col-sm-5 col-form-label">읽은 글 기록</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="read_history" value="1"
                        role="switch" id="reg_read_history" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-read-history">
        <div class="row align-items-center">
            <label for="reg_read_history_em" class="col-sm-5 col-form-label">읽은 글 강조</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="read_history_em" id="reg_read_history_em">
                    <option value="">사용안함</option>
                    <option value="background">배경색</option>
                    <option value="bold">굵은글씨</option>
                    <option value="italic">기울임</option>
                    <option value="underline">밑줄</option>
                    <option value="linethrough">취소선</option>
                    <option value="blur">블러</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-read-history">
        <div class="row align-items-center">
            <label for="reg_read_history_reply_cnt" class="col-sm-5 col-form-label">읽은 글 댓글 증감</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="read_history_reply_cnt" value="1"
                        role="switch" id="reg_read_history_reply_cnt" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-read-history">
        <div class="row align-items-center">
            <label for="reg_read_history_noti" class="col-sm-5 col-form-label">읽지 않은 공지</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="read_history_noti" value="1"
                        role="switch" id="reg_read_history_noti" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-read-history">
        <div class="row align-items-center">
            <label for="reg_read_history_noti_reply" class="col-sm-5 col-form-label">댓글 수 변경된 공지</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="read_history_noti_reply" value="1"
                        role="switch" id="reg_read_history_noti_reply" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>

    <li class="list-group-item ">
        <div class="row align-items-center">
            <label for="reg_title_filtering" class="col-sm-5 col-form-label">제목 필터링</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="title_filtering" value="1" role="switch" id="reg_title_filtering" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-filtering">
        <div class="row">
            <label for="reg_filtering_word" class="col-sm-5 col-form-label">예 : 후방,스포</label>
            <div class="col-sm-7">
                <input type="text" id="reg_filtering_word" name="filtering_word" value="" class="form-control ui_custom_items ">
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row align-items-center">
            <label for="reg_content_blur" class="col-sm-5 col-form-label">본문 흐림</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="content_blur" value="1" role="switch" id="reg_content_blur" data-gtm-form-interact-field-id="0">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-content-blur">
        <div class="row">
            <label for="reg_content_blur_word" class="col-sm-5 col-form-label">예 : 후방,스포</label>
            <div class="col-sm-7">
                <input type="text" id="reg_content_blur_word" name="content_blur_word" value="" class="form-control ui_custom_items ">
            </div>
        </div>
    </li>

    <!-- 숫자 단축키 ------------------------------------------------------- -->
    <li class="list-group-item">
        <div class="row align-items-center">
            <label for="reg_shortcut_use" class="col-sm-5 col-form-label">숫자 단축키</label>
            <div class="col-sm-7">
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="shortcut_use" value="1" role="switch" id="reg_shortcut_use">
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_1" class="col-sm-5 col-form-label">단축키 1</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_1" id="reg_shortcut_1">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_2" class="col-sm-5 col-form-label">단축키 2</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_2" id="reg_shortcut_2">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_3" class="col-sm-5 col-form-label">단축키 3</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_3" id="reg_shortcut_3">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_4" class="col-sm-5 col-form-label">단축키 4</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_4" id="reg_shortcut_4">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_5" class="col-sm-5 col-form-label">단축키 5</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_5" id="reg_shortcut_5">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_6" class="col-sm-5 col-form-label">단축키 6</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_6" id="reg_shortcut_6">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_7" class="col-sm-5 col-form-label">단축키 7</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_7" id="reg_shortcut_7">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_8" class="col-sm-5 col-form-label">단축키 8</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_8" id="reg_shortcut_8">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_9" class="col-sm-5 col-form-label">단축키 9</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_9" id="reg_shortcut_9">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item ui-custom-shortcut">
        <div class="row align-items-center">
            <label for="reg_shortcut_0" class="col-sm-5 col-form-label">단축키 0</label>
            <div class="col-sm-7">
                <select class="form-select ui_custom_items" name="shortcut_0" id="reg_shortcut_0">
                    <option value="">선택안함</option>
                </select>
            </div>
        </div>
    </li>

    <li class="list-group-item pt-3">
        <div class="row g-3 justify-content-center">
            <textarea id="ui_custom_json" style="display:none;"></textarea>
            <div class="col-6 col-sm-5 md-4 order-2">
                <button type="button" id="btn_ui_apply" accesskey="s" class="btn btn-primary btn-lg w-100">적용</button>
            </div>
        </div>
    </li>
</ul>
