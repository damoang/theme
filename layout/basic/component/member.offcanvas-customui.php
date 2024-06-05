<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
?>
<section id="user-ui-custom" class="p-0" style="font-size: 0.875rem;">
    <style>
        #user-ui-custom .ui-custom-ul-subs {border-top-left-radius: 0px;border-top-right-radius: 0px;}
        #user-ui-custom .ui-custom-ul-subs li{border-left:0px;border-right:0px;}
        #user-ui-custom .ui-custom-ul-tabs {border-bottom:0px;}
        #user-ui-custom .ui-custom-ul-tabs .ui-custom-ul-tab a{border-top-left-radius: 0px;border-top-right-radius: 0px;border-top: 0px;padding:1em 1.2em}
        #user-ui-custom .ui-custom-ul-tabs .ui-custom-ul-tab a.active{color: var(--bs-card-cap-color);background-color: var(--bs-card-cap-bg);}
        #user-ui-custom li.ui-custom-li-expand {color: var(--bs-card-cap-color);background-color: var(--bs-card-cap-bg);}
        #user-ui-custom #ui-custom-list-ul ul {border-top-right-radius: 0px;border-top-left-radius: 0px;border: 0px;}
        #user-ui-custom #ui-custom-list-ul ul li {border-left:0px;border-right:0px;}
        #user-ui-custom #ui-custom-list-ul ul li:first-child {border-top:0px;}
        #user-ui-custom #ui-custom-rcmd-ul ul {border-top-right-radius: 0px;border-top-left-radius: 0px;border: 0px;}
        #user-ui-custom #ui-custom-rcmd-ul ul li {border-left:0px;border-right:0px;}
        #user-ui-custom #ui-custom-rcmd-ul ul li:first-child {border-top:0px;}
        #user-ui-custom ul li:last-child {border-bottom:0px;}
        #user-ui-custom .input-group .input-group-text {min-width: 3.3em;text-align: center;display: inline-block;}
        #user-ui-custom div.ui-custom-container {transition:all 1s;}
        #user-ui-custom div.ui-custom-container .ui-custom-detail {display:none !important}
        #user-ui-custom div.ui-custom-container .ui-custom-detail.d-block {display:none !important}
        #user-ui-custom div.ui-custom-container .ui-custom-detail.d-inline-block {display:none !important}
        #user-ui-custom div.ui-custom-container.show-detail .ui-custom-detail {display:block !important}
        #user-ui-custom div.ui-custom-container.show-detail .ui-custom-detail.d-none {display:none !important}
        #user-ui-custom div.ui-custom-container.show-detail .ui-custom-detail.d-block {display:block !important}
        #user-ui-custom div.ui-custom-container.show-detail .ui-custom-detail.d-inline-block {display:inline-block !important}

        .vh-50 {height: 50vh;}
        .vh-30 {height: 30vh;}
        .w-33 {width: 32%;}
    </style>
    <div class="align-items-center mt-5">
        <label class="btn btn-basic w-100 py-2 mb-2" style="text-align:center;" title="※ 현재 브라우저에만 저장됩니다.">개인화면설정</label>
    </div>
    <div class="ui-custom-btn-default ui-custom-container w-100">

        <div id="ui-custom-show-detail" class="card mb-2" >
            <div class="card-header d-flex justify-content-between align-items-center">
                <label for="reg_show_detail" class="col-sm-5 col-form-label" title="상세설정도 보여줍니다..">상세설정보기</label>
                <div class="form-check form-switch">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="show_detail" value="1" role="switch" id="reg_show_detail">
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs ui-custom-tabs" style="border-bottom:0px;">
            <li class="nav-item ui-custom-tab">
                <a class="nav-link active" aria-current="page" href="#ui-custom-short-cut-ul">
                    단축키
                </a>
            </li>
            <li class="nav-item ui-custom-tab">
                <a class="nav-link" aria-current="page" href="#ui-custom-default">
                    UI
                </a>
            </li>
            <li class="nav-item ui-custom-tab">
                <a class="nav-link" aria-current="page" href="#ui-custom-list-ul">
                    목록
                </a>
            </li>
            <li class="nav-item ui-custom-tab">
                <a class="nav-link" aria-current="page" href="#ui-custom-rcmd-ul">
                    추천
                </a>
            </li>
        </ul>

        <!-- 숫자 단축키 ------------------------------------------------------- -->
        <div id="ui-custom-short-cut-ul" class="card" style="border-top-left-radius: 0px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <label for="reg_shortcut_use" class="col-sm-5 col-form-label" title="숫자 단축키를 사용합니다. 활성화시 게시판의 내 글, 댓글 검색하기 버튼도 추가 됩니다.">숫자 단축키</label>
                <div class="form-check form-switch">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="shortcut_use" value="1" role="switch" id="reg_shortcut_use">
                </div>
            </div>

            <ul class="list-group ui-custom-uls list-group-flush">
                <li class="list-group-item ui-custom-shortcut">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_1" class="col-sm-5 col-form-label">단축키 1</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_1" id="reg_shortcut_1">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_2" class="col-sm-5 col-form-label">단축키 2</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_2" id="reg_shortcut_2">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_3" class="col-sm-5 col-form-label">단축키 3</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_3" id="reg_shortcut_3">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_4" class="col-sm-5 col-form-label">단축키 4</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_4" id="reg_shortcut_4">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_5" class="col-sm-5 col-form-label">단축키 5</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_5" id="reg_shortcut_5">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_6" class="col-sm-5 col-form-label">단축키 6</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_6" id="reg_shortcut_6">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_7" class="col-sm-5 col-form-label">단축키 7</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_7" id="reg_shortcut_7">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_8" class="col-sm-5 col-form-label">단축키 8</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_8" id="reg_shortcut_8">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_9" class="col-sm-5 col-form-label">단축키 9</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_9" id="reg_shortcut_9">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-shortcut">
                    <div class="row align-items-center">
                        <label for="reg_shortcut_0" class="col-sm-5 col-form-label">단축키 0</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items ui_custom_shortcut_items" name="shortcut_0" id="reg_shortcut_0">
                                <option value="">선택안함</option>
                            </select>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div id="ui-custom-default" class="card ui-custom-uls d-none">
            <div class="card-header d-flex justify-content-between align-items-center">
                <label for="reg_ui_custom" class="col-sm-5 col-form-label" title="UI 커스텀을 활성화 합니다.">UI 커스텀</label>
                <div class="form-check form-switch">
                    <input class="form-check-input ui_custom_items" type="checkbox" name="ui_custom" value="1" role="switch" id="reg_ui_custom">
                </div>
            </div>
            <div class="ui-custom-item">
                <ul class="nav nav-tabs ui-custom-ul-tabs">
                    <li class="nav-item ui-custom-ul-tab">
                        <a class="nav-link active" aria-current="page" href="#ui-custom-ul-setting" style="border-left:0px;">
                            설정
                        </a>
                    </li>
                    <li class="nav-item ui-custom-ul-tab">
                        <a class="nav-link" aria-current="page" href="#ui-custom-ul-menu">
                            메뉴
                        </a>
                    </li>
                    <li class="nav-item ui-custom-ul-tab">
                        <a class="nav-link" aria-current="page" href="#ui-custom-ul-memo">
                            메모
                        </a>
                    </li>
                    <li class="nav-item ui-custom-ul-tab">
                        <a class="nav-link" aria-current="page" href="#ui-custom-ul-quick">
                            단축
                        </a>
                    </li>
                </ul>
                <ul id="ui-custom-ul-setting" class="p-0 list-group ui-custom-ul-subs">
                    <li class="list-group-item ui-custom-item">
                        <div class="row">
                            <label for="reg_show_width" class="col-sm-5 col-form-label" title="최대 화면 너비를 설정합니다. 단위는 px입니다. 최소 값은1000px 입니다. ">화면 너비</label>
                            <div class="col-sm-7">
                            <div class="input-group col-sm-7">
                                <input type="number" id="reg_show_width" name="show_width" placeholder="1200" class="form-control ui_custom_items" data-gtm-form-interact-field-id="1" min="1000">
                                <span class="input-group-text">px</span>
                            </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-detail">
                        <div class="row">
                            <label for="reg_menu_width" class="col-sm-5 col-form-label" title="메뉴의 너비 비율을 설정합니다. 10%에서 50%까지 설정할 수 있습니다.">메뉴 너비</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="number" id="reg_menu_width" name="menu_width" class="form-control form-control-sm ui_custom_items " step="0.1" placeholder="25" value="25" data-gtm-form-interact-field-id="2" min="10" max="50">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item">
                        <div class="row">
                            <label for="reg_font_size" class="col-sm-5 col-form-label" title="화면 기본 글씨크기를 설정합니다. 최소값은 0.3em입니다.">글씨 크기</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="number" id="reg_font_size" name="font_size" class="form-control form-control-sm ui_custom_items" step="0.1" data-gtm-form-interact-field-id="0" placeholder="1" min="0.3">
                                    <span class="input-group-text"">em</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item">
                        <div class="row">
                            <label for="reg_line_height" class="col-sm-5 col-form-label" title="화면 기본 글씨 높이를 설정합니다. 최소값은 0.1입니다.">줄 높이</label>
                            <div class="col-sm-7">
                                <input type="number" id="reg_line_height" name="line_height" class="form-control form-control-sm ui_custom_items" step="0.1" placeholder="1.5" min="0.1">
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-detail">
                        <div class="row">
                            <label for="reg_font_family" class="col-sm-5 col-form-label" title="화면 기본 글씨체를 설정합니다.">글씨체</label>
                            <div class="col-sm-7">
                                <input type="text" id="reg_font_family" name="font_family" value="" class="form-control form-control-sm ui_custom_items ">
                            </div>
                        </div>
                    </li>                    
                    <li class="list-group-item ui-custom-item">
                        <div class="row align-items-center">
                            <label for="reg_animation_off" class="col-sm-5 col-form-label" title="커스텀 UI의 에니메이션을 끕니다.">애니메이션 끄기</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="animation_off" value="1" role="switch" id="reg_animation_off">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul id="ui-custom-ul-menu" class="list-group p-0 ui-custom-ul-subs d-none">
                    <li class="list-group-item ui-custom-item">
                        <div class="row align-items-center">
                            <label for="reg_left_menu" class="col-sm-5 col-form-label" title="메뉴를 왼쪽으로 설정합니다.">왼쪽 메뉴</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="left_menu" value="1" role="switch" id="reg_left_menu">
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- <li class="list-group-item ui-custom-item">
                        <div class="row align-items-center">
                            <label for="reg_menu_off" class="col-sm-5 col-form-label" title="메인 화면의 메뉴를 표시하지 않습니다.">메뉴 끄기</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="menu_off" value="1" role="switch" id="reg_menu_off">
                                </div>
                            </div>
                        </div>
                    </li> -->
                    <li class="list-group-item ui-custom-item ui-custom-detail">
                        <div class="row align-items-center">
                            <label for="reg_left_menu_over" class="col-sm-5 col-form-label" title="상단의 호출 메뉴를 왼쪽으로 설정합니다.">왼쪽 호출메뉴</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="left_menu_over" value="1" role="switch" id="reg_left_menu_over">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-detail">
                        <div class="row align-items-center">
                            <label for="reg_menu_scroll" class="col-sm-5 col-form-label" title="상단메뉴를 고정합니다.">상단메뉴 고정</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="menu_scroll" value="1" role="switch" id="reg_menu_scroll">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-detail">
                        <div class="row align-items-center">
                            <label for="reg_back_button" class="col-sm-5 col-form-label" title="상단 메뉴에 뒤로가기 버튼을 추가합니다.">뒤로 가기 버튼</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="back_button" value="1" role="switch" id="reg_back_button">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-detail">
                        <div class="row align-items-center">
                            <label for="reg_hide_nick" class="col-sm-5 col-form-label" title="회원 별명을 회원님으로 변경하고 프로필 이미지를 숨깁니다.">별명감추기</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="hide_nick" value="1" role="switch" id="reg_hide_nick">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item">
                        <div class="row align-items-center">
                            <label for="reg_mymenu_img" class="col-sm-5 col-form-label" title="마이메뉴 아이콘을 내 이미지로 변경합니다. 상단메뉴에서 로그인 상태를 확인할 수 있습니다.">마이메뉴 내이미지</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="mymenu_img" value="1" role="switch" id="reg_mymenu_img">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item">
                        <div class="row align-items-center">
                            <label for="reg_list_search" class="col-sm-5 col-form-label" title="목록 검색창을 항상 보이게 합니다. 폭 1000px 이상에서만 활성화 됩니다.">목록 검색창 고정</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="list_search" value="1" role="switch" id="reg_list_search">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-detail">
                        <div class="row align-items-center">
                            <label for="reg_list_toggle" class="col-sm-5 col-form-label" title="게시글 화면에서 목록을 감춰줍니다. D를 누르거나 확장 버튼을 사용하면 게시글이 감춰지고 목록이 나타납니다.">목록 감추기(D)</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="list_toggle" value="1"
                                        role="switch" id="reg_list_toggle">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul id="ui-custom-ul-memo" class="list-group p-0 ui-custom-ul-subs d-none">
                    <li class="list-group-item ui-custom-item">
                        <div class="row align-items-center">
                            <label for="reg_hide_member_memo" class="col-sm-5 col-form-label" title="회원 메모를 감춰줍니다. U을 누르면 흐려집니다.">메모 가리기(U)</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch p-0">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="hide_member_memo" value="1" role="switch" id="reg_hide_member_memo">
                                    <button type="button" id="btn_memo_toggle" class="btn btn-basic btn-sm">토글</button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-memo-ip-check d-none ui-custom-detail">
                        <div class="row align-items-center">
                            <label for="reg_memo_ip_track" class="col-sm-5 col-form-label" title="빨간색 메모 유저의 IP를 기록해서 동일한 IP 사용된 글에서 표시해줍니다.">유저IP 기록</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch p-0">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="memo_ip_track" value="1" role="switch" id="reg_memo_ip_track">
                                    <button type="button" id="btn_memo_ip_clear" class="btn btn-basic btn-sm"><i class="bi bi-trash align-middle"></i></button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-memo-ip-check ui-custom-ip-memo-sub ui-custom-ip-memo-default d-none ui-custom-detail">
                        <div class="row align-items-center">
                            <label class="col-sm-5 col-form-label" title="특정 IP에 메모를 남깁니다.">메모IP 관리</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch p-0">
                                    <input class="form-check-input ui_custom_items float-end mt-2 d-none" type="checkbox" name="load_ip_memo_list" value="1" role="switch" id="load_ip_memo_list">

                                    <button type="button" id="btn_ip_memo_list" class="btn btn-basic ip_memo_btns ip_memo_edit_btns btn-sm"><i class="bi bi-list-stars align-middle"></i></button>
                                    <button type="button" id="btn_ip_memo_edit" class="btn btn-basic ip_memo_btns ip_memo_edit_btns btn-sm"><i class="bi bi-textarea-resize align-middle"></i></button>
                                    <button type="button" id="btn_ip_memo_add" class="btn btn-basic ip_memo_btns ip_memo_edit_btns btn-sm float-end"><i class="bi bi-file-earmark-plus align-middle"></i></button>
                                    <button type="button" id="btn_ip_memo_close" class="btn btn-basic ip_memo_btns ip_memo_close_btns btn-sm float-end d-none"><i class="bi bi-x-lg align-middle"></i></button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-memo-ip-check ui-custom-ip-memo-sub ui-custom-ip-memo-sub-editor ui-custom-ip-memo-add ui-custom-detail d-none">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <button type="button" id="btn_ip_memo_add_check" class="btn btn-basic btn-sm" style="max-width: 0.1em;border-right: 0;padding-left: 0;overflow: hidden;"><i class="bi bi-at align-middle" style="opacity:0;"></i></button>
                                    <input type="text" id="ip_memo_add_mode" name="p_memo_add_mode" value="" class="form-control form-control-sm ui_custom_items d-none">
                                    <input type="text" id="ip_memo_add_name" name="p_memo_add_name" placeholder="IP : 1.♡.1.1" value=".♡.." class="form-control form-control-sm ui_custom_items ">                                
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="text" id="ip_memo_add_desc" name="ip_memo_add_desc" placeholder="내용 : 필수" value="" class="form-control form-control-sm ui_custom_items ">
                                    <button type="button" id="btn_ip_memo_add_save" class="btn btn-basic btn-sm ip_memo_editor_btns"><i class="bi bi-floppy align-middle"></i></button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li id="ui-custom-ip-memo-list-zero" class="list-group-item ui-custom-item ui-custom-memo-ip-check ui-custom-ip-memo-sub ui-custom-ip-memo-sub-editor ui-custom-ip-memo-list ui-custom-ip-memo-list-zero ui-custom-detail d-none">
                        <div class="row align-items-center text-center">
                            <label class="col-sm-5 col-form-label w-100" title="IP메모가 없습니다.">IP메모가 없습니다.</label>
                        </div>
                    </li>
                    <li id="ui-custom-ip-memo-list-default" class="list-group-item ui-custom-item ui-custom-memo-ip-check ui-custom-ip-memo-sub ui-custom-ip-memo-sub-editor ui-custom-ip-memo-list ui-custom-ip-memo-list-default ui-custom-detail d-none">
                        <div class="row align-items-center">
                            <label id="ip_memo_list_name" class="col-sm-5 col-form-label" title="특정 IP에 메모를 남깁니다.">IP</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="text" id="ip_memo_list_desc" name="ip_memo_list_desc" value="" class="form-control form-control-sm ui_custom_items" disabled>
                                    <button type="button" id="btn_ip_memo_list_edit" class="btn btn-basic btn-sm ip_memo_editor_btns"><i class="bi bi-pen align-middle"></i></button>
                                    <button type="button" id="btn_ip_memo_list_delete" class="btn btn-danger btn-sm ip_memo_editor_btns"><i class="bi bi-trash align-middle"></i></button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-memo-ip-check ui-custom-ip-memo-sub ui-custom-ip-memo-sub-editor ui-custom-ip-memo-edit ui-custom-detail d-none">
                        <div class="row align-items-center">
                            <textarea id="ui_custom_ip_memo_editor" class="ui-custom-btn-view form-control lh-base vh-30" placeholder="1.♡.1.1,메모내용1&#13;&#10;.1♡.3.4,메모내용2"></textarea>
                            <button type="button" id="btn_ip_memo_edit_save" class="btn btn-primary w-100 mt-3 ip_memo_editor_btns">저장</button>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item">
                        <div class="row align-items-center">
                            <label for="reg_hide_list_memo" class="col-sm-5 col-form-label" title="전체 또는 선택한 색 메모 회원의 글을 목록에서 감춰줍니다.">메모목록 가리기</label>
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
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item">
                        <div class="row align-items-center">
                            <label for="reg_blur_contents_memo" class="col-sm-5 col-form-label" title="전체 또는 선택한 색 메모 회원의 글 내용을 흐리게 해줍니다..">메모내용 흐리게</label>
                            <div class="col-sm-7">
                                <select class="form-select ui_custom_items" name="blur_contents_memo" id="reg_blur_contents_memo">
                                    <option value="">사용안함</option>
                                    <option value="all">전체</option>
                                    <option value="yellow">노랑</option>
                                    <option value="green">초록</option>
                                    <option value="purple">보라</option>
                                    <option value="red">빨강</option>
                                    <option value="blue">파랑</option>
                                </select>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul id="ui-custom-ul-quick" class="list-group p-0 ui-custom-ul-subs d-none ">
                    <li class="list-group-item ui-custom-item ui-custom-detail">
                        <div class="row align-items-center">
                            <label for="reg_left_quick_button" class="col-sm-5 col-form-label" title="위로 가기 단축 버튼을 왼쪽으로 이동합니다.">왼쪽 단축버튼</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="left_quick_button" value="1" role="switch" id="reg_left_quick_button">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-li-expand">
                        <div class="row align-items-center">
                            <label for="reg_expand_quick" class="col-sm-5 col-form-label" title="위로 가기 단축 버튼에 기타 단축 버튼을 추가합니다.">단축버튼 추가</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_quick" value="1" role="switch" id="reg_expand_quick">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-detail">
                        <div class="row">
                            <label for="reg_expand_quick_size" class="col-sm-5 col-form-label" title="단축 버튼 크기를 설정합니다. 1em에서 3em까지 가능합니다.">단축 버튼 크기</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="number" id="reg_expand_quick_size" name="expand_quick_size" class="form-control form-control-sm ui_custom_items" step="0.1" data-gtm-form-interact-field-id="0" placeholder="2.5" placeholder="1" min="1" max="3">
                                    <span class="input-group-text">em</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item">
                        <div class="row align-items-center">
                            <label for="reg_expand_write" class="col-sm-5 col-form-label" title="글 작성, 댓글 작성(게시물에서) 단축 버튼을 추가합니다.">글, 댓글 작성</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_write" value="1" role="switch" id="reg_expand_write">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item">
                        <div class="row align-items-center">
                            <label for="reg_expand_mywr" class="col-sm-5 col-form-label" title="게시판에서 내 글, 내 댓글 검색 단축 버튼을 추가합니다.">내 글, 내 댓글 검색</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_mywr" value="1" role="switch" id="reg_expand_mywr">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-detail">
                        <div class="row align-items-center">
                            <label for="expand_navigator" class="col-sm-5 col-form-label" title="앞, 뒤 단축 버튼을 추가합니다.">앞으로, 뒤로</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_navigator" value="1" role="switch" id="reg_expand_navigator">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li id="reg_expand_shortcut_li" class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-li-expand">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut" class="col-sm-5 col-form-label" title="숫자 단축 버튼을 추가합니다.">숫자 단축키</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut" value="1" role="switch" id="reg_expand_shortcut">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_1" class="col-sm-5 col-form-label" title="단축 버튼 1을 추가합니다."">단축키 1</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_1" value="1" role="switch" id="reg_expand_shortcut_1">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_2" class="col-sm-5 col-form-label" title="단축 버튼 2를 추가합니다.">단축키 2</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_2" value="1" role="switch" id="reg_expand_shortcut_2">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_3" class="col-sm-5 col-form-label" title="단축 버튼 3을 추가합니다.">단축키 3</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_3" value="1" role="switch" id="reg_expand_shortcut_3">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_4" class="col-sm-5 col-form-label" title="단축 버튼 4를 추가합니다.">단축키 4</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_4" value="1" role="switch" id="reg_expand_shortcut_4">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_5" class="col-sm-5 col-form-label" title="단축 버튼 5를 추가합니다.">단축키 5</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_5" value="1" role="switch" id="reg_expand_shortcut_5">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_6" class="col-sm-5 col-form-label" title="단축 버튼 6을 추가합니다.">단축키 6</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_6" value="1" role="switch" id="reg_expand_shortcut_6">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_7" class="col-sm-5 col-form-label" title="단축 버튼 7을 추가합니다.">단축키 7</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_7" value="1" role="switch" id="reg_expand_shortcut_7">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_8" class="col-sm-5 col-form-label" title="단축 버튼 8을 추가합니다.">단축키 8</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_8" value="1" role="switch" id="reg_expand_shortcut_8">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_9" class="col-sm-5 col-form-label" title="단축 버튼 9를 추가합니다.">단축키 9</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_9" value="1" role="switch" id="reg_expand_shortcut_9">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-expand-shortcut">
                        <div class="row align-items-center">
                            <label for="reg_expand_shortcut_0" class="col-sm-5 col-form-label" title="단축 버튼 0을 추가합니다.">단축키 0</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_shortcut_0" value="1" role="switch" id="reg_expand_shortcut_0">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-li-expand">
                        <div class="row align-items-center">
                            <label for="reg_expand_gesture" class="col-sm-5 col-form-label" title="터치 제스처를 사용합니다.">제스처</label>
                            <div class="col-sm-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="expand_gesture" value="1" role="switch" id="reg_expand_gesture">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item">
                        <div class="row align-items-center">
                            <label for="reg_expand_gesture_swipe" class="col-sm-5 col-form-label" title="터치 제스처를 사용합니다.">양옆으로</label>
                            <div class="col-sm-7">
                                <select class="form-select ui_custom_items" name="read_expand_gesture_swipe" id="reg_expand_gesture_swipe">
                                    <option value="">사용안함</option>
                                    <option value="history">앞뒤이동</option>
                                    <option value="menuOpen">메뉴호출</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-detail">
                        <div class="row">
                            <label for="reg_expand_gesture_start_term" class="col-sm-5 col-form-label" title="양옆으로 제스처시 인식 시간을 설정합니다. 길수록 길게움직여도 됩니다.">최대 인식 시간</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="number" id="reg_expand_gesture_start_term" name="expand_gesture_start_term" class="form-control form-control-sm ui_custom_items" step="10" placeholder="400" min="250" min="600"">
                                    <span class="input-group-text">ms</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-detail">
                        <div class="row">
                            <label for="reg_expand_gesture_swipe_minx" class="col-sm-5 col-form-label" title="양옆으로 제스처 인식시 최소 범위를 설정합니다.">가로 이동 범위</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="number" id="reg_expand_gesture_swipe_minx" name="expand_gesture_swipe_minx" class="form-control form-control-sm ui_custom_items" step="10" placeholder="50" min="30">
                                    <span class="input-group-text">최소</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-detail">
                        <div class="row">
                            <label for="reg_expand_gesture_swipe_maxy" class="col-sm-5 col-form-label" title="양옆으로 제스처 인식시 최소 범위를 설정합니다.">세로 이동 범위</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="number" id="reg_expand_gesture_swipe_maxy" name="expand_gesture_swipe_maxy" class="form-control form-control-sm ui_custom_items" step="10" placeholder="30" max="60">
                                    <span class="input-group-text">최대</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item">
                        <div class="row align-items-center">
                            <label for="reg_expand_gesture_tap2" class="col-sm-5 col-form-label" title="한손가락으로 두번 누릅니다..">두번 두드림</label>
                            <div class="col-sm-7">
                                <select class="form-select ui_custom_items" name="expand_gesture_tap2" id="reg_expand_gesture_tap2">
                                    <option value="">사용안함</option>
                                    <option value="refresh">새로고침</option>
                                    <option value="toList">목록으로이동</option>
                                    <option value="sideMenu">게시판메뉴</option>
                                    <option value="myMenu">마이메뉴</option>
                                    <option value="toTop">위아래로이동</option>
                                    <option value="goBack">뒤로이동</option>
                                    <option value="goForward">앞으로이동</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item">
                        <div class="row align-items-center">
                            <label for="reg_expand_gesture_tap3" class="col-sm-5 col-form-label" title="한손가락으로 세번 누릅니다..">세번 두드림</label>
                            <div class="col-sm-7">
                                <select class="form-select ui_custom_items" name="read_expand_gesture_tap3" id="reg_expand_gesture_tap3">
                                    <option value="">사용안함</option>
                                    <option value="refresh">새로고침</option>
                                    <option value="toList">목록으로이동</option>
                                    <option value="sideMenu">게시판메뉴</option>
                                    <option value="myMenu">마이메뉴</option>
                                    <option value="toTop">위아래로이동</option>
                                    <option value="goBack">뒤로이동</option>
                                    <option value="goForward">앞으로이동</option>
                                </select>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-item ui-custom-expand-item ui-custom-detail">
                        <div class="row">
                            <label for="reg_expand_gesture_click_term" class="col-sm-5 col-form-label" title="두드림 제스처시 두드림 회수에 따른 인식 시간을 설정합니다. 길수록 천천히 눌러도 됩니다.">두드림 간격</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="number" id="reg_expand_gesture_click_term" name="expand_gesture_click_term" class="form-control form-control-sm ui_custom_items" step="25" placeholder="250" min="200" min="400">
                                    <span class="input-group-text">ms</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ui-custom-li-expand">
                        <div class="d-flex justify-content-between align-items-center">
                            * 두드림 제스처 사용시 터치가 문제가 있을수 있습니다.
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="ui-custom-list-ul" class="card ui-custom-uls d-none">
            <div class="card-header d-flex justify-content-between align-items-center" style="padding:1.2em;">
                컨텐츠 필터
            </div>
            <ul class="list-group">
                <li class="list-group-item ui-custom-li-expand">
                    <div class="row align-items-center">
                        <label for="reg_title_filtering" class="col-sm-5 col-form-label" title="목록에서 제목 필터링 기능을 활성화 합니다.">제목 필터링</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="title_filtering" value="1" role="switch" id="reg_title_filtering">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-filtering">
                    <div class="row">
                        <label for="reg_filtering_word" class="col-sm-5 col-form-label" title="한글, 영어, 숫자만 적용 됩니다.">예 : 후방,스포</label>
                        <div class="col-sm-7">
                            <input type="text" id="reg_filtering_word" name="filtering_word" value="" class="form-control ui_custom_items ">
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-li-expand">
                    <div class="row align-items-center">
                        <label for="reg_content_blur" class="col-sm-5 col-form-label" title="제목에 설정한 문구가 들어간 글의 본문을 흐리게 처리합니다. 본문을 클릭하면 내용을 보실 수 있습니다.">본문 흐림</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="content_blur" value="1" role="switch" id="reg_content_blur">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-content-blur">
                    <div class="row">
                        <label for="reg_content_blur_word" class="col-sm-5 col-form-label" title="한글, 영어, 숫자, [], ()만 적용 됩니다.">예 : [후방],스포</label>
                        <div class="col-sm-7">
                            <input type="text" id="reg_content_blur_word" name="content_blur_word" value="" class="form-control ui_custom_items ">
                        </div>
                    </div>
                </li>

                <!-- 읽은 글 기록 ------------------------------------------------------ -->
                <li class="list-group-item ui-custom-li-expand ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_read_history" class="col-sm-5 col-form-label" title="방문한 글 목록을 기록합니다.">읽은 글 기록</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch p-0">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="read_history" value="1"
                                    role="switch" id="reg_read_history">
                                    <button type="button" id="btn_read_history_clear" class="btn btn-basic btn-sm"><i class="bi bi-trash align-middle"></i></button>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-read-history ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_read_history_reply_cnt" class="col-sm-5 col-form-label" title="방문한 글 목록의 댓글 수 변경시 목록에 표시 해 줍니다.">댓글 변경 표시</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="read_history_reply_cnt" value="1"
                                    role="switch" id="reg_read_history_reply_cnt">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-read-history ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_read_history_noti" class="col-sm-5 col-form-label" title="목록에서 공지 사항을 표시하지 않더라도 읽지 않은 공지가 있는 경우 표시해 줍니다.">읽지 않은 공지</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="read_history_noti" value="1"
                                    role="switch" id="reg_read_history_noti">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-read-history ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_read_history_noti_reply" class="col-sm-5 col-form-label" title="목록에서 공지 사항을 표시하지 않더라도 공지의 댓글이 추가된 경우 표시해 줍니다.">댓글 변경 공지</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="read_history_noti_reply" value="1"
                                    role="switch" id="reg_read_history_noti_reply">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-read-history ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_read_history_em" class="col-sm-5 col-form-label" title="방문한 글 목록을 선택한 방식으로 강조해 줍니다.">읽은 글 강조</label>
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
            </ul>
        </div>
        <div id="ui-custom-rcmd-ul" class="card ui-custom-uls d-none">
            <div class="card-header d-flex justify-content-between align-items-center" style="padding:1.2em;">
                추천 모양 설정
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_color_set" class="col-sm-5 col-form-label" title="목록의 추천 배경 색상을 설정합니다.">목록추천 배경색</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items" name="rcmd_color_set" id="reg_rcmd_color_set">
                                <option value="">기본</option>
                                <option value="gray">잿빛</option>
                                <option value="forest">숲속</option>
                                <option value="yellow">노랑</option>
                                <option value="colorful">다앙</option>
                                <option value="none">없음</option>
                                <option value="self">설정</option>
                            </select>
                        </div>
                    </div>
                </li>
                <!-- <li class="list-group-item ui-custom-item rcmd_color_steps">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_color_step1" class="col-sm-5 col-form-label" title="목록의 추천 1단계의 배경 색상을 설정합니다.">1단계색</label>
                        <div class="col-sm-7">
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-item rcmd_color_steps">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_color_step2" class="col-sm-5 col-form-label" title="목록의 추천 2단계의 배경 색상을 설정합니다.">2단계색</label>
                        <div class="col-sm-7">
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-item rcmd_color_steps">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_color_step3" class="col-sm-5 col-form-label" title="목록의 추천 3단계의 배경 색상을 설정합니다.">3단계색</label>
                        <div class="col-sm-7">
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-item rcmd_color_steps">
                    <div class="row align-items-center">
                        <label for="rcmd_color_step4" class="col-sm-5 col-form-label" title="목록의 추천 4단계의 배경 색상을 설정합니다.">4단계색</label>
                        <div class="col-sm-7">
                        </div>
                    </div>
                </li> -->
                <li class="list-group-item ">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_font_color" class="col-sm-5 col-form-label" title="목록의 추천 글씨 색상을 설정합니다.">목록추천 글자색</label>
                        <div class="col-sm-7">
                            <select class="form-select ui_custom_items" name="rcmd_font_color" id="reg_rcmd_font_color">
                                <option value="">기본</option>
                                <option value="gray">잿빛</option>
                                <option value="black">검정</option>
                                <option value="white">흰색</option>
                                <option value="self">설정</option>
                                <option value="step">단계별</option>
                            </select>
                            <input type="color" id="reg_rcmd_font_color_self" name="rcmd_font_color_self" value="#ffffff" placeholder="" class="form-control form-control-sm ui_custom_items">
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-rcmd-steps ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="" class="col-sm-5 col-form-label" title="목록의 추천 글씨 색상을 설정합니다.">구분</label>
                        <div class="col-sm-7">
                        <div class="input-group col-sm-7">
                        <input type="text" id="rcmd_step_value" name="rcmd_step_value" value="" placeholder="시작" class="form-control form-control-sm ui_custom_items text-center rcmd_color_step_values ui-custom-detail" disabled>
                        <input type="text" id="rcmd_color_step" name="rcmd_color_step" value="" placeholder="배경" class="form-control form-control-sm ui_custom_items text-center rcmd_color_steps" disabled>
                        <input type="text" id="rcmd_font_color" name="rcmd_font_color" value="" placeholder="글자" class="form-control form-control-sm ui_custom_items text-center rcmd_font_steps" disabled>
                        </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-rcmd-steps ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_color_step1_value" class="col-sm-5 col-form-label" title="목록의 추천 1단계의 시작 값을 설정합니다.">추천1</label>
                        <div class="col-sm-7">
                        <div class="input-group col-sm-7">
                            <input type="number" id="reg_rcmd_color_step1_value" name="rcmd_color_step1_value" value="" placeholder="0" class="form-control form-control-sm ui_custom_items rcmd_color_step_values ui-custom-detail" step="1" max="100 ">
                            <input type="color" id="reg_rcmd_color_step1" name="rcmd_color_step1" value="#f2f2f2" defaultValue="#f2f2f2" placeholder="1단계 : #f2f2f2" class="form-control form-control-sm ui_custom_items rcmd_color_steps">
                            <input type="color" id="reg_rcmd_font_color_1" name="rcmd_font_color_1" value="#ffffff" placeholder="" class="form-control form-control-sm ui_custom_items rcmd_font_steps">
                        </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-rcmd-steps ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_color_step2_value" class="col-sm-5 col-form-label" title="목록의 추천 2단계의 시작 값을 설정합니다.">추천2</label>
                        <div class="col-sm-7">
                        <div class="input-group col-sm-7">
                            <input type="number" id="reg_rcmd_color_step2_value" name="rcmd_color_step2_value" value="" placeholder="6" class="form-control form-control-sm ui_custom_items rcmd_color_step_values ui-custom-detail" step="1" max="100">
                            <input type="color" id="reg_rcmd_color_step2" name="rcmd_color_step2" value="#d9d9d9" defaultValue="#d9d9d9" placeholder="1단계 : #d9d9d9" class="form-control form-control-sm ui_custom_items rcmd_color_steps">
                            <input type="color" id="reg_rcmd_font_color_2" name="rcmd_font_color_2" value="#ffffff" placeholder="" class="form-control form-control-sm ui_custom_items rcmd_font_steps">
                        </div>
                    </div>
                </div>
                </li>
                <li class="list-group-item ui-custom-rcmd-steps ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_color_step3_value" class="col-sm-5 col-form-label" title="목록의 추천 3단계의 시작 값을 설정합니다.">추천3</label>
                        <div class="col-sm-7">
                            <div class="input-group col-sm-7">
                            <input type="number" id="reg_rcmd_color_step3_value" name="rcmd_color_step3_value" value="" placeholder="11" class="form-control form-control-sm ui_custom_items rcmd_color_step_values ui-custom-detail" step="1" max="100">
                            <input type="color" id="reg_rcmd_color_step3" name="rcmd_color_step3" value="#bfbfbf" defaultValue="#bfbfbf" placeholder="3단계 : #bfbfbf" class="form-control form-control-sm ui_custom_items rcmd_color_steps">
                            <input type="color" id="reg_rcmd_font_color_3" name="rcmd_font_color_3" value="#ffffff" placeholder="" class="form-control form-control-sm ui_custom_items rcmd_font_steps">
                        </div>
                    </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-rcmd-steps ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_rcmd_color_step4_value" class="col-sm-5 col-form-label" title="목록의 추천 4단계의 시작 값을 설정합니다.">추천4</label>
                        <div class="col-sm-7">
                            <div class="input-group col-sm-7">
                            <input type="number" id="reg_rcmd_color_step4_value" name="rcmd_color_step4_value" value="" placeholder="51" class="form-control form-control-sm ui_custom_items rcmd_color_step_values ui-custom-detail" step="1 max="100"">
                            <input type="color" id="reg_rcmd_color_step4" name="rcmd_color_step4" value="#a6a6a6" defaultValue="#a6a6a6" placeholder="4단계 : #a6a6a6" class="form-control form-control-sm ui_custom_items rcmd_color_steps">
                            <input type="color" id="reg_rcmd_font_color_4" name="rcmd_font_color_4" value="#ffffff" placeholder="" class="form-control form-control-sm ui_custom_items rcmd_font_steps">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item ui-custom-detail">
                    <div class="row align-items-center">
                        <label for="reg_thumbup_em_off" class="col-sm-5 col-form-label" title="추천 애니메이션 효과를 제거합니다.">추천 동작 끄기</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="thumbup_em_off" value="1" role="switch" id="reg_thumbup_em_off">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <label for="reg_bbs_group_recommend_off" class="col-sm-5 col-form-label" title="메뉴에 소모임 추천 링크를 보여주지 않습니다.">소모임 추천 끄기</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="bbs_group_recommend_off" value="1" role="switch" id="reg_bbs_group_recommend_off">
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <label for="reg_bbs_shortcut_recommend_off" class="col-sm-5 col-form-label" title="소모임 타이틀에 단축키 등록 링크를 보여주지 않습니다.">단축키 추천 끄기</label>
                        <div class="col-sm-7">
                            <div class="form-check form-switch">
                                <input class="form-check-input ui_custom_items float-end mt-2" type="checkbox" name="bbs_shortcut_recommend_off" value="1" role="switch" id="reg_bbs_shortcut_recommend_off">
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="justify-content-center text-center">
        <button type="button" id="btn_ui_value_view" class="ui-custom-btn-default btn btn-secondary w-33 mt-3 d-inline-block">편집기</button>
        <button type="button" id="btn_ui_value_clear" class="ui-custom-btn-default btn btn-danger w-33 mt-3 d-inline-block">기본값</button>
        <button type="button" id="btn_ui_value_reload" class="ui-custom-btn-default btn btn-success w-33 mt-3 d-inline-block">저장값</button>
        <button type="button" id="btn_ui_apply" class="ui-custom-btn-default btn btn-primary w-100 mt-3 d-inline-block">화면 적용</button>
        <textarea id="ui_custom_json" class="ui-custom-btn-view form-control lh-base d-none vh-50"></textarea>
        <button type="button" id="btn_ui_value_cancle" class="ui-custom-btn-view btn btn-danger w-33 mt-3 d-none">닫기</button>
        <button type="button" id="btn_ui_value_copy" class="ui-custom-btn-view btn btn-primary w-33 mt-3 d-none">복사</button>
        <button type="button" id="btn_ui_value_paste" class="ui-custom-btn-view btn btn-warning w-33 mt-3 d-none">붙임</button>
        <button type="button" id="btn_ui_value_save" class="ui-custom-btn-view btn btn-success w-100 mt-3 d-none">입력</button>
    </div>
</section>