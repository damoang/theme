(() => {
    'use strict'

    function set_ui_custom() {
        try {
            document.getElementById('user_ui_custom_styles').remove();
        } catch {
        }
        var ui_custom_storage_str = localStorage.getItem("ui_custom");
        if (ui_custom_storage_str != null && ui_custom_storage_str != "") {
            var ui_obj = JSON.parse(ui_custom_storage_str);
            var ui_keys = Object.keys(ui_obj);
            var ui_custom_style = "";
            var ui_root_style = "";
            var ui_media992_style = "";
            if (ui_obj.ui_custom != null && ui_obj.ui_custom) {
                //화면 너비 설정
                if (ui_obj.show_width != null) {
                    ui_custom_style += ".container {max-width: " + ui_obj.show_width + "px !important;}\n";
                }
                //메뉴 스크롤 적용
                if (ui_obj.menu_scroll != null && ui_obj.menu_scroll) {
                    ui_custom_style += "#header-copy.header-copy {display: none;}\n";
                    ui_custom_style += "#header-navbar.site-navbar {position: relative !important;display: block !important; height: 64px !important;}\n";
                    ui_custom_style += "#main-wrap .sticky-top {position: relative;}\n";
                }

                //미리보기창 끄기
                if (ui_obj.img_preview != null && ui_obj.img_preview) {
                    ui_custom_style += "div.popover.bs-popover-auto.fade.show {display: none !important;}\n";
                }

                //root style 글씨체 및 크기
                if (ui_obj.font_family != null) {
                    ui_root_style += "--bs-body-font-family:" + ui_obj.font_family + " !important;\n";
                }
                if (ui_obj.font_size != null) {
                    ui_root_style += "--bs-body-font-size:" + ui_obj.font_size + "em !important;\n";
                }
                if (ui_obj.line_height != null) {
                    ui_root_style += "--bs-body-line-height:" + ui_obj.line_height + " !important;\n";
                }

                //media 992px 이상
                //왼쪽 메뉴 적용
                if (ui_obj.left_menu != null && ui_obj.left_menu) {
                    ui_media992_style += ".order-2 {order: 0 !important;}\n";
                }
                //메뉴바 크기 설정
                if (ui_obj.menu_width != null) {
                    var content_width = 100 - ui_obj.menu_width;
                    ui_media992_style += ".col-lg-9 {width: " + content_width + "% !important;}\n";
                    ui_media992_style += ".col-lg-3 {width: " + ui_obj.menu_width + "% !important;}\n";
                }
                //검색메뉴 항상 보임
                if (ui_obj.list_search != null && ui_obj.list_search) {
                    ui_media992_style += "#boardSearch {display: block !important;}\n";
                }

                if (ui_root_style != "") {
                    ui_custom_style += ":root {\n" + ui_root_style + "}\n";
                }
                if (ui_media992_style != "") {
                    ui_custom_style += "@media (min-width: 992px) {\n" + ui_media992_style + "}\n";
                }
                if (ui_custom_style != "") {
                    document.head.innerHTML += "<style id=\"user_ui_custom_styles\">\n" + ui_custom_style + "</style>";
                }

            }

            hide_nick(ui_obj);

        }
    }

    function ui_custom_apply() {
        var ui_custom_input = [
            "ui_custom"
            , "show_width"
            , "font_family"
            , "font_size"
            , "line_height"
            , "menu_width"
            , "back_button"
            , "left_menu"
            , "left_menu_over"
            , "left_quick_button"
            , "expand_quick"
            , "expand_write"
            , "expand_mywr"
            , "expand_navigator"
            , "menu_scroll"
            , "list_search"
            , "img_preview"
            , "hide_nick"
            , "hide_member_memo"
            , "mymenu_img"
            , "title_filtering"
            , "filtering_word"
            , "shortcut_use"
            , "shortcut_1"
            , "shortcut_2"
            , "shortcut_3"
            , "shortcut_4"
            , "shortcut_5"
            , "shortcut_6"
            , "shortcut_7"
            , "shortcut_8"
            , "shortcut_9"
            , "shortcut_0"
        ];

        var ui_custom_default = { show_width: 1200, font_size: 1, line_height: 1.5, menu_width: 25 };
        var ui_custom_json = {};
        var changed = false;

        ui_custom_input.forEach(function (reg) {
            var temp_input = $("#reg_" + reg)[0]
            if (temp_input != null) {
                var temp_value = temp_input.value;
                if (temp_value != null && temp_value != "") {
                    temp_value = temp_value.trim()
                    var save = true;
                    if (temp_input.type == "checkbox") {
                        save = temp_input.checked;
                        temp_value = true;
                    } else {
                        if (ui_custom_default[reg] != null) {
                            if (temp_value == ui_custom_default[reg]) {
                                save = false;
                            }
                        }
                    }
                    if (save) {
                        changed = true;
                        if (temp_input.type == "number") {
                            ui_custom_json[reg] = Number(temp_value);
                        } else {
                            ui_custom_json[reg] = temp_value;
                        }

                    }
                }
            }
        });

        var json_str = "";
        var item_key = "ui_custom";
        if (changed) {
            json_str = JSON.stringify(ui_custom_json);
            localStorage.setItem(item_key, json_str);
        } else {
            localStorage.removeItem(item_key)
        }

        if (document.getElementById('ui_custom_json') != null) document.getElementById('ui_custom_json').value = json_str;

        alert("변경사항이 적용되었습니다.");

        try {
            set_ui_custom();
        } catch {
            //console.error('Failed to initialize custom UI settings:', error);
        }
    }

    function get_ui_custom_values() {
        var ui_custom_storage_str = localStorage.getItem("ui_custom");
        if (ui_custom_storage_str != null && ui_custom_storage_str != "") {
            var ui_custom_obj = JSON.parse(ui_custom_storage_str);
            var ui_custom_keys = Object.keys(ui_custom_obj);
            ui_custom_keys.forEach(function (reg) {
                var temp_input = document.getElementById("reg_" + reg);
                if (temp_input != null) {
                    if (temp_input.type == "checkbox") {
                        if (ui_custom_obj[reg] == true) {
                            temp_input.checked = true;
                        } else {
                            temp_input.checked = false;
                        }
                    } else {
                        temp_input.value = ui_custom_obj[reg];
                    }
                }
            });

            if (document.getElementById('ui_custom_json') != null) document.getElementById('ui_custom_json').value = ui_custom_storage_str;

            set_ui_custom_trigger();
            return ui_custom_obj;
        }
    }

    function hide_nick(ui_obj) {
        if (ui_obj != null) {
            if (ui_obj.ui_custom != null && ui_obj.ui_custom) {
                //닉네임 감추기
                if (ui_obj.hide_nick != null && ui_obj.hide_nick) {
                    set_hide_nick();
                }

                // 회원메모 감추기
                if (ui_obj.hide_member_memo != null && ui_obj.hide_member_memo) {
                    set_hide_member_memo();
                }

                //이미지 변경
                if (ui_obj.mymenu_img != null && ui_obj.mymenu_img) {
                    set_change_mymenu_img(ui_obj?.hide_nick ?? false);
                }

                //팝업메뉴 왼쪽으로
                set_left_menu_over((ui_obj.left_menu_over != null && ui_obj.left_menu_over));

                //퀵버튼 왼쪽으로
                set_left_quick_button((ui_obj.left_quick_button != null && ui_obj.left_quick_button));
                //백버튼 활성화
                set_back_button((ui_obj.back_button != null && ui_obj.back_button));

                //확장버튼
                if (ui_obj.expand_quick != null && ui_obj.expand_quick) {
                    set_expand_quick(ui_obj);
                }

            }
            //단축키
            set_shortcut_custom(ui_obj);

            //제목 필터링
            if (ui_obj.title_filtering ?? false) {
                set_title_filtering(ui_obj?.filtering_word);
            }
        }
    }

    //함수 모음 시작
    function set_hide_nick() {
        var profiles = document.getElementsByClassName('sv_member ellipsis-1');
        for (var i = 0; i < profiles.length; i++) {
            var profile_html = profiles[i].innerHTML;
            profiles[i].innerHTML = profile_html.substr(0, profile_html.indexOf("/span>") + 6) + " 회원님"
        }
        var profile_img = document.querySelectorAll(".pe-2 .win_memo img");
        var profile_img_txt = document.querySelectorAll(".pe-2 .win_memo span.img_replace_txt");
        if (profile_img_txt != null && profile_img_txt.length > 0) {
            while (profile_img_txt.length > 0) {
                profile_img[0].remove();
            }
        }
        if (profile_img != null && profile_img.length > 0) {
            for (var i = 0; i < profile_img.length; i++) {
                var after_span = document.createElement("span");
                after_span.clasName = "img_replace_txt"
                after_span.innerHTML = "사진관리";
                profile_img[i].after(after_span);
                profile_img[i].style.display = "none";
            }
        }
    }

    // 회원메모 가리기
    var memo_state_key = "ui_custom_memo_state";

    function set_hide_member_memo() {
        $('.da-member-memo').toggleClass('d-none');
        var memo_list = document.querySelectorAll(".da-member-memo");
        var memo_state = localStorage.getItem(memo_state_key) ?? "";
        var filter_style = "";
        var filter_text = "보이기";
        switch (memo_state) {
            case "blur1":
                filter_style = "blur(0.1em)"
                filter_text = "블러1";
                break;
            case "blur2":
                filter_style = "blur(0.2em)"
                filter_text = "블러2";
                break;
            case "blur5":
                filter_style = "blur(0.5em)"
                filter_text = "블러5";
                break;
            default:
                if (memo_state == "") {
                    filter_text = "감추기";
                }
                break;
        }

        for(var i=0;i<memo_list.length;i++) {
            if (memo_list[i] != null) {
                if (memo_state == "") {
                    memo_list[i].classList.add('d-none');
                } else {
                    memo_list[i].classList.remove('d-none');
                }
                var temp_em = memo_list[i].querySelector('em');
                if (temp_em != null) {
                    //temp_em.addEventListener('click',toggle_hide_member_memo)
                    temp_em.style.filter = filter_style;
                }
            }
        }
        var button = document.getElementById("btn_memo_toggle");
        if (button != null) {
            button.innerHTML = filter_text;
        }
    }

    function toggle_hide_member_memo() {
        var memo_state = localStorage.getItem(memo_state_key) ?? "";
        var change_state = null;
        switch (memo_state) {
            case "show":
                change_state = "blur1"
                break;
            case "blur1":
            //     change_state = "blur2"
            //     break;
            // case "blur2":
                change_state = "blur5"
                break;
            case "blur5":
                break;
            default:
                change_state = "show"
                break;
        }
        if (change_state == null) {
            localStorage.removeItem(memo_state_key)
        } else {
            localStorage.setItem(memo_state_key, change_state);
        }
        set_hide_member_memo();
    }


    function set_change_mymenu_img(is_hide_nick) {
        var person_menu = document.querySelector("header .bi-person-circle");
        var person_menu_img = document.querySelector("#my_menu_img");

        if (person_menu != null && person_menu_img != null) {
            person_menu.style.display = "";
            person_menu_img.remove();
        }
        var person_img = document.querySelector("#main-wrap .container .my-2 .pe-2 a.win_memo img");
        if (person_menu != null && person_img != null) {
            person_menu.style.display = "none";
            var after_img = document.createElement("img");
            after_img.className = "rounded-circle";
            after_img.id = "my_menu_img";
            after_img.style.verticalAlign = "top";
            after_img.style.maxWidth = "14.4px";
            after_img.style.maxHeight = "14.4px";
            after_img.src = person_img.src;
            if (is_hide_nick) {
                after_img.style.opacity = 0.1;
            }
            person_menu.after(after_img);
        }
    }

    function set_back_button(set_use) {
        var menu_div = document.querySelector("header#header-navbar .container .d-flex");
        if (menu_div != null) {
            var removes = menu_div.getElementsByClassName("ui-custom-back-button");
            if (removes != null && removes.length > 0) {
                while (removes.length > 0) {
                    removes[0].remove();
                }
            }
            if (set_use) {
                var menu_div_first = document.querySelector("header#header-navbar .container .d-flex > div");
                if (menu_div_first != null) {
                    var back_div = document.createElement("div");
                    back_div.classList.add("ui-custom-back-button");
                    back_div.innerHTML = '<a href="#goBack" data-bs-toggle="goBack" data-bs-target="#goBack" aria-controls="goBack"><span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="뒤로"><i class="bi bi-chevron-left fs-4"></i><span class="visually-hidden">뒤로</span></span></a>';
                    back_div.addEventListener("click", function (e) {
                        e.preventDefault();
                        history.back();
                        //set_expand_quick()
                    });
                    menu_div.insertBefore(back_div, menu_div_first);
                }
                }
        }
    }

    function set_left_menu_over(set_use) {
        var menuOffcanvas = document.getElementById('menuOffcanvas');
        if (menuOffcanvas != null) {
            if (set_use) {
                menuOffcanvas.classList.remove('offcanvas-end');
                menuOffcanvas.classList.add('offcanvas-start');
                var menu_div_list = document.querySelectorAll("header#header-navbar .container .d-flex > div");
                var menuOffcanvas_tag = null;
                if (menu_div_list.length > 1) {
                    for (var i = 1; i < menu_div_list.length; i++) {
                        var temp_target = menu_div_list[i].querySelector("a")?.dataset?.bsTarget;
                        if (temp_target != null && temp_target == '#menuOffcanvas') {
                            menuOffcanvas_tag = menu_div_list[i];
                            break;
                        }
                    }
                    if (menuOffcanvas_tag != null) {
                        var menu_div = document.querySelector("header#header-navbar .container .d-flex");
                        menu_div.insertBefore(menuOffcanvas_tag, menu_div_list[0]);
                    }
                }
            } else {
                menuOffcanvas.classList.add('offcanvas-end');
                menuOffcanvas.classList.remove('offcanvas-start');
            }
            }
    }

    function set_left_quick_button(set_use){
        var toTop = document.getElementById('toTop');
        if (toTop != null) {
            if (set_use) {
                toTop.classList.remove('end-0');
                toTop.classList.add('start-0');
            } else {
                toTop.classList.add('end-0');
                toTop.classList.remove('start-0');
            }
        }
    }

    function set_title_filtering(word_list) {
        word_list = (word_list ?? "").trim()
        var check_regex = /^[ㄱ-ㅎ가-힣a-zA-Z0-9]+$/;
        var word_regex = "";
        if (word_list != "") {
            var word_arr = word_list.split(",");
            word_arr.forEach(function (word) {
                word = word.trim();
                if (word != "" && check_regex.test(word)) {
                    if (word_regex != "") {
                        word_regex += "|";
                    }
                    word_regex += word;
                }
            });

            if (word_regex != "") {
                var re = new RegExp(word_regex, "i");
                var title_list = document.querySelectorAll("#bo_list ul li div > a");
                for (var i = 0; i < title_list.length; i++) {
                    var li_a = title_list[i];
                    if ((title_list[i].parentElement.getElementsByTagName("span").length ?? 0) > 0) {
                        var li_text = li_a.text.trim();
                        if (re.test(li_text)) {
                            var li = li_a.closest("li.list-group-item");
                            li.classList.add("d-none");
                        }
                    }
                }
            }
        }

    }

    function set_expand_quick(ui_obj) {
        var toTop = document.getElementById('toTop');
        if (toTop != null) {
            toTop.classList.remove('d-block');

            var removes = toTop.getElementsByClassName("ui-custom-expand-icon");
            if (removes != null && removes.length > 0) {
                while (removes.length > 0) {
                    removes[0].remove();
                }
            }

            var board_obj = get_board_mb_id();
            var toTop_as = toTop.querySelector("a i.bi-arrow-up-square-fill");
            if (toTop_as != null) {
                toTop_as = toTop_as.parentElement;
                var ex_hrefs = ["menu", "go_write", "go_reply", "list", "my_write", "my_reply", "memo_toggle", "forward", "back"];
                var ex_titles = ["팝업메뉴", "글쓰기", "댓글쓰기", "목록으로", "내 글 - 현재 게시판", "내 댓글 - 현재 게시판", "메모 상태", "앞으로", "뒤로"];
                var ex_icons = ["list", "pencil-square", "r-square-fill", "filter-square-fill", "chat-square-text-fill", "chat-square-quote-fill", "chat-square-dots-fill", "arrow-right-square-fill", "arrow-left-square-fill"];
                var add_button = false;
                for (var i = 0; i < ex_hrefs.length; i++) {
                    // var check_add = add_button;
                    var tag_a = null;
                    var tag_a_href = null;
                    switch (ex_hrefs[i]) {
                        case "menu":
                            tag_a = document.createElement("a");
                            tag_a.addEventListener("click", function (e) {
                                e.preventDefault();
                                var menu_div_list = document.querySelectorAll("header#header-navbar .container .d-flex > div");
                                var menuOffcanvas_tag = null;
                                if (menu_div_list.length > 0) {
                                    for (var i = 0; i < menu_div_list.length; i++) {
                                        var temp_target = menu_div_list[i].querySelector("a")?.dataset?.bsTarget;
                                        if (temp_target != null && temp_target == '#menuOffcanvas') {
                                            menuOffcanvas_tag = menu_div_list[i].querySelector("a");
                                            break;
                                        }
                                    }

                                    if (menuOffcanvas_tag != null) {
                                        menuOffcanvas_tag.click();
                                    }
                                }
                            });
                            break;
                        case "go_write":
                            if ((ui_obj.expand_write ?? false ) &&  (board_obj != null && board_obj.id != null && board_obj.board != null)) {
                                tag_a = document.createElement("a");
                                tag_a_href = "/" + board_obj.board + "/write";
                            }
                            break;
                            break;
                        case "go_reply":
                            if ((ui_obj.expand_write ?? false ) &&  (board_obj != null && board_obj.id != null && board_obj.board != null))  {
                                var reply_area = document.getElementById("wr_content")
                                if (reply_area != null) {
                                    tag_a = document.createElement("a");
                                    tag_a.addEventListener("click", function (e) {
                                        e.preventDefault();
                                        var reply_area = document.getElementById("wr_content")
                                        if (reply_area != null) {
                                            reply_area.focus();
                                        }
                                    });
                                    }
                                }
                        break;
                        case "my_write":
                        case "my_reply":
                            if ((ui_obj.expand_mywr ?? false ) &&  (board_obj != null && board_obj.id != null && board_obj.board != null) ) {
                                tag_a = document.createElement("a");
                                tag_a_href = "/" + board_obj.board + "?sfl=mb_id%2C" + (ex_hrefs[i] == "my_write" ? 1 : 0) + "&stx=" + board_obj.id;
                            }
                            break;
                        case "memo_toggle":
                            if ((ui_obj.hide_member_memo ?? false )) {
                                tag_a = document.createElement("a");
                                tag_a.addEventListener("click", function (e) {
                                    e.preventDefault();
                                    toggle_hide_member_memo();
                                });
                            }
                            break;
                        case "list":
                            if ((location.pathname.match(/\//g)?.length ?? 0) > 1) {
                                tag_a = document.createElement("a");
                                tag_a.addEventListener("click", function (e) {
                                    e.preventDefault();
                                    location.href = location.pathname.substring(0, location.pathname.indexOf("/", 1)) + (location.search ?? "")
                                });
                            }
                            break;
                        case "forward":
                            if ((ui_obj.expand_navigator ?? false ) && (window?.navigation == null ? true : window?.navigation?.canGoForward) ) {
                                tag_a = document.createElement("a");
                                tag_a.addEventListener("click", function (e) {
                                    e.preventDefault();
                                    history.forward();
                                    //set_expand_quick();
                                });
                            }
                            break;
                        case "back":
                            if ((ui_obj.expand_navigator ?? false ) && (window?.navigation == null ? true : window?.navigation?.canGoBack) ) {
                                tag_a = document.createElement("a");
                                tag_a.addEventListener("click", function (e) {
                                    e.preventDefault();
                                    history.back();
                                    //set_expand_quick()
                                });
                            }
                            break;
                        default:
                            tag_a = document.createElement("a");
                            break;
                    }

                    if (tag_a != null) {
                        if (tag_a_href == null) {
                            tag_a.href = "#" + ex_hrefs[i];
                        } else {
                            tag_a.href = tag_a_href;
                        }
                        tag_a.className = "ui-custom-expand-icon ui-custom-expand-hidden d-block fs-1 m-3 mb-1 mt-1 bg-secondary bg-opacity-25";
                        tag_a.id = "ui-custom-expand-" + ex_hrefs[i];
                        tag_a.title = ex_titles[i];
                        // if (check_add != add_button) {
                        //     tag_a.classList.remove("mt-0");
                        // }
                        var tag_i = document.createElement("i");
                        tag_i.className = "bi bi-" + ex_icons[i] + "";
                        tag_a.appendChild(tag_i);
                        toTop.insertBefore(tag_a, toTop_as);
                        add_button = true;
                    }
                }

                if (add_button) {
                    toTop.classList.add('d-block');

                    toTop_as.classList.remove("d-sm-inline-block");
                    toTop_as.classList.remove("d-none");

                    toTop_as.classList.add("ui-custom-expand-hidden");
                    toTop_as.classList.add("bg-secondary");
                    toTop_as.classList.add("bg-opacity-25");

                    toTop_as.classList.add("d-block");
                    toTop_as.classList.add("mt-1");
                    toTop_as.classList.add("mb-1");
                    toTop_as.title = "맨 위로";

                    var tag_a = document.createElement("a");
                    tag_a.href = "javascript:;"; //"#" + ex_hrefs[i];
                    tag_a.className = "ui-custom-expand-icon d-block fs-1 m-3 mt-1";
                    tag_a.id = "ui-custom-expand-button";
                    var tag_i = document.createElement("i");
                    tag_i.id = "ui-custom-expand-button-i"
                    tag_i.className = "bi bi-caret-down-square-fill";
                    tag_i.title = "확장버튼 감추기";
                    tag_a.appendChild(tag_i);
                    tag_a.addEventListener("click", toggle_expand_button);
                    toTop.appendChild(tag_a);


                    set_expand_button();
                    //toTop_as.classList.add("d-sm-block");
                } else {
                    toTop_as.classList.remove("ui-custom-expand-hidden");
                    toTop_as.classList.remove("mt-1");
                    toTop_as.classList.remove("mb-0");
                    toTop_as.classList.remove("bg-secondary");
                    toTop_as.classList.remove("bg-opacity-25");

                    toTop_as.classList.add("d-none");
                    toTop_as.classList.add("d-sm-inline-block");
                }
            }
        }
    }

    var expand_state_key = "ui_custom_expand_button";

    function set_expand_button() {
        var expand_button_state = localStorage.getItem(expand_state_key);
        var b_show = (expand_button_state == "show");
        var button = document.getElementById("ui-custom-expand-button-i");
        if (b_show) {
            button.classList.remove("bi-caret-up-square-fill");
            button.classList.remove("opacity-25");
            button.classList.add("bi-caret-down-square-fill");
            button.title = "확장버튼 감추기";
            b_show = true;
        } else {
            button.classList.remove("bi-caret-down-square-fill");
            button.classList.add("bi-caret-up-square-fill");
            button.classList.add("opacity-25");
            button.title = "확장버튼 보이기";
        }
        var show_list = toTop.getElementsByClassName("ui-custom-expand-hidden");
        for (var i = 0; i < show_list.length; i++) {
            if (b_show) {
                show_list[i].classList.add("d-block");
                show_list[i].classList.remove("d-none");
            } else {
                show_list[i].classList.remove("d-block");
                show_list[i].classList.add("d-none");
            }
        }
    }
    function toggle_expand_button() {
        var expand_button_state = localStorage.getItem(expand_state_key);
        if (expand_button_state == "show") {
            localStorage.removeItem(expand_state_key)
        } else {
            localStorage.setItem(expand_state_key, "show");
        }
        set_expand_button();
    }

    function get_board_link_map() {
        var list = get_board_link_list();
        var list_map = {};
        list.forEach(function (item) {
            list_map[item.link] = item;
        });
        return list_map;
    }

    function get_board_link_list() {
        var links = $("#sidebar-site-menu div.nav-item > a").not("a.shortcut_custom");
        var link_exp = /^[^0-9][a-z0-9_.=]+$/i;
        var link_list = [];
        for (var i = 0; i < links.length; i++) {
            var temp_link_obj = $(links[i]);
            var temp_link = temp_link_obj.prop('href').trim();
            var temp_link_org = temp_link;
            var temp_span = temp_link_obj.find('span');
            if (temp_link.length > 0) {
                var temp_name;
                if (temp_span.length > 0) {
                    temp_name = temp_span.html();
                } else {
                    temp_name = temp_link_obj.html();
                }
                temp_name = temp_name.replace(/[<].+[>].*[<\/].*[>]/gi, '').trim();
                switch (temp_name) {
                    case "내 글":
                        temp_link = "_myw";
                        break;
                    case "내 댓글":
                        temp_link = "_myr";
                        break;
                    default:
                        temp_link = temp_link.substr(temp_link.lastIndexOf('/') + 1);
                        break;
                }
                if (temp_link_org.indexOf(location.hostname) > 0 && link_exp.test(temp_link)) {
                    link_list.push({ link: temp_link, org: temp_link_org, name: temp_name });
                } else {

                }
            }
        }

        links = $("#sidebar-site-menu .da-menu--bbs-group-group").find("div > a");
        for (var i = 0; i < links.length; i++) {
            var temp_link_obj = $(links[i]);
            var temp_name = temp_link_obj.html().trim();
            var temp_link = temp_link_obj.prop('href').trim();
            var temp_link_org = temp_link;
            if (temp_link.length > 0) {
                temp_link = temp_link.substr(temp_link.lastIndexOf('/') + 1);
                link_list.push({ link: temp_link, org: temp_link_org, name: temp_name });
            }
        }

        return link_list;
    }

    function set_board_link_option_html() {
        var links_html = "<option value=''>선택안함</option>";
        var link_list = get_board_link_list();
        link_list.forEach(function (item) {
            links_html += "\n<option value='" + item.link + "'>" + item.name + "</option>";
        });
        for (var i = 0; i < 10; i++) {
            var selector = $("#reg_shortcut_" + i);
            if (selector.length > 0) {
                $("#reg_shortcut_" + i + " option").remove();
                selector.append(links_html);
            }
        }
    }


    var shortcut_map = {};

    function get_board_mb_id() {
        var link_obj = null;
        var link_map = get_board_link_map();
        if ((location.pathname.match(/\//g)?.length ?? 0) > 0) {
            var board_name_length = location.pathname.indexOf("/", 1);
            if (board_name_length == -1) {
                board_name_length = location.pathname.length;
            }
            var board_name = location.pathname.substring(1, board_name_length)
            if (link_map[board_name] != null) {
                link_obj = {};
                link_obj.board = board_name;
            }
        }
        var p_n = "mb_id";
        var myw_link = link_map._myw.org
        var q_s = myw_link.indexOf(p_n + "=");
        var q_e = myw_link.indexOf("&", q_s);

        if (q_s > -1) {
            q_s += p_n.length + 1;
            if (link_obj == null) {
                link_obj = {};
            }

            if (q_e == -1) {
                link_obj.id = myw_link.substring(q_s);
            } else {
                link_obj.id = myw_link.substring(q_s, q_e);
            }
        }

        return link_obj;
    }

    function set_shortcut_custom(ui_obj) {
        shortcut_map = {}

        if (ui_obj.hide_member_memo != null && ui_obj.hide_member_memo ) {
            shortcut_map["M"] = "javascript:toggle_hide_member_memo();"
        }

        var removes = document.querySelectorAll('div.shortcut_custom');
        if (removes != null && removes.length > 0) {
            for (var i = 0; i < removes.length; i++) {
                removes[i].remove();
            }
        }

        if (ui_obj.shortcut_use ?? false) {
            var sidebar_site_menu = document.getElementById('sidebar-site-menu');
            var sidebar_site_menu_first = document.querySelector('#sidebar-site-menu > div');
            var offcanvas_menu_first = document.querySelector('.offcanvas-body .na-menu div.nav-item');
            var offcanvas_menu = document.querySelector('.offcanvas-body .na-menu div.nav');
    
    
            var board_obj = get_board_mb_id();
            if (board_obj != null && board_obj.id != null && board_obj.board != null) {
                var temp_icon = ["bi-reply-all", "bi-pencil-square"];
                var temp_text = ["내 댓글 - 현재 게시판", "내 글 - 현재 게시판"]
                for (var i = 1; i > -1; i--) {
                    var shortcut_div = document.createElement("div");
                    shortcut_div.className = "nav-item shortcut_custom";
                    var shortcut_link = document.createElement("a");
                    shortcut_link.className = "nav-link shortcut_custom";
                    shortcut_link.href = "/" + board_obj.board + "?sfl=mb_id%2C" + i + "&stx=" + board_obj.id;
                    shortcut_link.innerHTML = '<i class="' + temp_icon[i] + ' nav-icon"></i>&nbsp;' + temp_text[i];
                    shortcut_div.appendChild(shortcut_link);
                    sidebar_site_menu.insertBefore(shortcut_div, sidebar_site_menu_first);
                    offcanvas_menu.insertBefore(shortcut_div.cloneNode(true), offcanvas_menu_first);
                }
            }
    
            var link_map = get_board_link_map();
            for (var i = 0; i < 10; i++) {
                var shortcut = (ui_obj["shortcut_" + i] ?? "").trim();
                if (shortcut != "" && link_map[shortcut] != null) {
                    var shortcut_div = document.createElement("div");
                    shortcut_div.className = "nav-item shortcut_custom";
                    var shortcut_link = document.createElement("a");
                    shortcut_link.className = "nav-link shortcut_custom";
                    shortcut_link.href = link_map[shortcut].org;
                    shortcut_link.innerHTML = '<i class="bi-list-stars nav-icon"></i> <span class="badge text-bg-secondary">' + i + '</span>&nbsp;' + link_map[shortcut].name;
                    shortcut_div.appendChild(shortcut_link);
                    sidebar_site_menu.insertBefore(shortcut_div, sidebar_site_menu_first);
                    offcanvas_menu.insertBefore(shortcut_div.cloneNode(true), offcanvas_menu_first);
                    shortcut_map[i + ""] = shortcut_link.href;
                }
            }        }

        if (Object.keys(shortcut_map).length > 0) {
            window.removeEventListener('keypress', handleShortCutKeyPress);
            window.addEventListener('keypress', handleShortCutKeyPress);
        }
        //console.debug(shortcut_map)
    }

    function isShortCutInputElement(element) {
        return ['INPUT', 'TEXTAREA', 'SELECT'].includes(element.tagName);
    }

    function isShortCutKeyCombination(event) {
        return event.ctrlKey || event.shiftKey || event.altKey || event.metaKey;
    }

    function isShortCutContentEditableElement(element) {
        while (element) {
            if (element.contentEditable === 'true') {
                return true;
            }
            element = element.parentElement;
        }
        return false;
    }

    function handleShortCutKeyPress(event) {
        if (isShortCutInputElement(event.target) || isShortCutKeyCombination(event) || isShortCutContentEditableElement(event.target)) {
            return;
        }
        var key = (event?.code ?? "").replace(/Key|Digit/, "");
        if (shortcut_map[key] != null) {
            if (key == "M") {
                toggle_hide_member_memo();
            } else {
                window.location.href = shortcut_map[key];
            }
            return;
        } else {
            console.debug(key);
            return;
        }
    }
    //함수 모음 끝

    function set_ui_custom_click_event() {
        try {
            $("#reg_expand_quick").change(function () {
                set_ui_custom_expand();
            });

            $("#reg_ui_custom").change(function () {
                if ($("#reg_ui_custom").is(":checked")) {
                    $(".ui-custom-item").show();
                    set_ui_custom_expand();
                } else {
                    $(".ui-custom-item").hide();
                }
            });
            $("#reg_title_filtering").change(function () {
                if ($("#reg_title_filtering").is(":checked")) {
                    $(".ui-custom-filtering").show();
                } else {
                    $(".ui-custom-filtering").hide();
                }
            });
            $("#reg_shortcut_use").change(function () {
                if ($("#reg_shortcut_use").is(":checked")) {
                    $(".ui-custom-shortcut").show();
                } else {
                    $(".ui-custom-shortcut").hide();
                }
            });

        } catch (error) {
            //console.error('Failed to initialize custom UI settings:', error);
        }
    }
    function set_ui_custom_expand() {
        if ($("#reg_shortcut_use").is(":checked")) {
            $(".ui-custom-expand-item").show();
        } else {
            $(".ui-custom-expand-item").hide();
        }
    }
    function set_ui_custom_trigger() {
        try {
            //$("#reg_expand_quick").trigger('change');
            $("#reg_ui_custom").trigger('change');

            $("#reg_title_filtering").trigger('change');
            $("#reg_shortcut_use").trigger('change');

        } catch (error) {
            //console.error('Failed to initialize custom UI settings:', error);
        }
    }

    function set_ui_custom_onload() {
        set_board_link_option_html();
        set_ui_custom_click_event();
        var btn_ui_apply = document.getElementById("btn_ui_apply");
        if (btn_ui_apply) {
            btn_ui_apply.addEventListener("click", ui_custom_apply);
        }

        var btn_memo_toggle = document.getElementById("btn_memo_toggle");
        if (btn_memo_toggle) {
            btn_memo_toggle.addEventListener("click", toggle_hide_member_memo);
        }
        
        var ui_obj = get_ui_custom_values();
        if (ui_obj) hide_nick(ui_obj);

    }
    document.addEventListener("DOMContentLoaded", set_ui_custom_onload, { once: true });

    try {
        set_ui_custom();
    } catch (error) {
        console.error('Failed to initialize custom UI settings:', error);
    }
})();