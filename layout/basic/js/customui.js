(() => {
  'use strict'
  var body_opacity_init = false;
  var ui_custom_animation = false;

  function set_body_op_start() {
    body_opacity_init = true;
    if (document?.body != null) {
      document.body.classList.add('opacity-0');
      document.body.classList.remove('cu_init');
    }
  }

  function set_body_op_end() {
    if (body_opacity_init) {
      document.body.classList.remove('opacity-0');
      document.body.classList.add('cu_init');
    }
  }

  function remove_ui_custom_styles() {
    if (document.getElementById('user_ui_custom_styles') != null) {
      document.getElementById('user_ui_custom_styles').remove();
    }
  }

  function set_ui_custom() {
    var ui_custom_storage_str = localStorage.getItem("ui_custom");
    var ui_custom_style = "";
    ui_custom_animation = false;
    if (ui_custom_storage_str != null && ui_custom_storage_str != "") {
      var ui_obj = JSON.parse(ui_custom_storage_str);
      var ui_keys = Object.keys(ui_obj);
      var ui_root_style = "";
      var ui_media992_style = "";
      var ui_media768_style = "";

      if (ui_obj.ui_custom != null && ui_obj.ui_custom) {
        ui_custom_animation = !(ui_obj?.animation_off ?? false);
        //화면 너비 설정
        if (ui_obj.show_width != null) {
          ui_custom_style += ".container {max-width: " + ui_obj.show_width + "px !important;}\n";
          ui_custom_style += "#main-wrap div.order-1 a[data-dd-action-name='Boards Ads Banner'] > img {width:100%;}\n";
        }
        //메뉴 스크롤 적용
        if (ui_obj.menu_scroll != null && ui_obj.menu_scroll) {
          ui_custom_style += "#header-copy.header-copy {display: block;}\n";
          ui_custom_style += "#header-navbar.site-navbar {position: fixed !important;display: block !important; height: 64px !important;}\n";
          ui_custom_style += "#main-wrap .sticky-top {position: relative;}\n";
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
        if ((ui_obj.menu_off ?? false) && 1 == 0) {
          ui_custom_style += "#main-wrap .container div.order-2 {display:none;}\n";
          ui_media992_style += ".col-lg-9 {width: 100% !important;}\n";
        } else {
          if (ui_obj.left_menu != null && ui_obj.left_menu) {
            ui_media992_style += ".order-2 {order: 0 !important;}\n";
          }
          //메뉴바 크기 설정
          if (ui_obj.menu_width != null) {
            var content_width = 100 - ui_obj.menu_width;
            ui_media992_style += ".col-lg-9 {width: " + content_width + "% !important;}\n";
            ui_media992_style += ".col-lg-3 {width: " + ui_obj.menu_width + "% !important;}\n";
          }
        }
        //검색메뉴 항상 보임
        if (ui_obj.list_search != null && ui_obj.list_search) {
          ui_media992_style += "#boardSearch {display: block !important;}\n";
        }
        //추천수 강조
        if (!(ui_obj.thumbup_em_off ?? false)) {
          //ui_custom_style += "#bo_list div.col-1 {visibility: hidden;width:4em}\n";
          //ui_custom_style += "#bo_list .list-group-item > div{position:relative;}\n";
          //ui_custom_style += "#bo_list .list-group-item div.wr-num.order-3 {margin-top: -0.4em;padding-top: 0.4em;padding-left:0.3em;padding-right:0.3em;border-radius: 5%;}\n";
          if (ui_custom_animation) {
            ui_custom_style += "#bo_list li.list-group-item.da-link-block div.wr-num div.rcmd-box.cu_rv_1 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp10;}\n";
            ui_custom_style += "#bo_list li.list-group-item.da-link-block div.wr-num div.rcmd-box.cu_rv_2 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp15;}\n";
            ui_custom_style += "#bo_list li.list-group-item.da-link-block div.wr-num div.rcmd-box.cu_rv_3 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp20;}\n";
            ui_custom_style += "#bo_list li.list-group-item.da-link-block div.wr-num div.rcmd-box.cu_rv_4 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp25;}\n";
            ui_custom_style += "#bo_list li.list-group-item.da-link-block div.wr-num div.rcmd-box.cu_rv_5 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp25;}\n";

            ui_custom_style += "#bo_list li.list-group-item.da-link-block:hover div.wr-num div.rcmd-box.cu_rv_1 {animation-iteration-count: infinite;}\n";
            ui_custom_style += "#bo_list li.list-group-item.da-link-block:hover div.wr-num div.rcmd-box.cu_rv_2 {animation-iteration-count: infinite;}\n";
            ui_custom_style += "#bo_list li.list-group-item.da-link-block:hover div.wr-num div.rcmd-box.cu_rv_3 {animation-iteration-count: infinite;}\n";
            ui_custom_style += "#bo_list li.list-group-item.da-link-block:hover div.wr-num div.rcmd-box.cu_rv_4 {animation-iteration-count: infinite;}\n";
            ui_custom_style += "#bo_list li.list-group-item.da-link-block:hover div.wr-num div.rcmd-box.cu_rv_5 {animation-iteration-count: infinite;}\n";
          }
          //ui_media768_style += "#bo_list .list-group-item div.ms-md-auto > div > div:nth-child(3) {position:absolute;left:5px;width:2.3em;}\n";
          //ui_media768_style += "#bo_list .list-group-item div.wr-num.order-3 {position:absolute;left:5px;height: 2em;width: 2.3em;margin-top: -0.4em;padding-top: 0.4em;padding-left:0em;padding-right:0em;border-radius: 40%;}\n";
        }


        if (ui_root_style != "") {
          ui_custom_style += ":root {\n" + ui_root_style + "}\n";
        }
        if (ui_media992_style != "") {
          ui_custom_style += "@media (min-width: 992px) {\n" + ui_media992_style + "}\n";
        }
        if (ui_media768_style != "") {
          ui_custom_style += "@media (min-width: 768px) {\n" + ui_media768_style + "}\n";
        }
        if (body_opacity_init != null) {
          ui_custom_style += "body {opacity:0;}\n";
          ui_custom_style += "body.cu_init {\n" +
            "opacity:1;" +
            "animation-name: cu_body_op;" +
            "animation-duration: 0.1s;" +
            "animation-delay: 0s;" +
            "animation-iteration-count: 1;" +
            "animation-timing-function: linear;" +
            "animation-direction: alternate;\n}\n";
          ui_custom_style += "@keyframes cu_body_op {\n 0% {opacity: 0;} \n 50% {opacity: 70;} \n 100% {opacity: 1;}\n}\n";
        }
        if (ui_obj.expand_quick != null && ui_obj.expand_quick) {
          if (ui_obj.expand_quick_size != null) {
            ui_custom_style += "div#toTop a {font-size: " + ui_obj.expand_quick_size + "em !important;}\n";
          }
          //"div#toTop a.ui-custom-expand-hidden.d-block {transition: all 0.5s;height: 100%;}\n" +
          //"div#toTop a.ui-custom-expand-hidden.d-none {display: block !important;transition: all 0.3s;opacity: 0;transform: scale(0.5) rotate(0deg) translateY(200%);border-radius: 100%;}\n" +
          ui_custom_style += "div#toTop a.ui-custom-expand-hidden.d-none-start {display: block !important;opacity: 0;transform: scale(0.5) rotate(0deg) translateY(200%);border-radius: 100%;}\n" +
            "div#toTop a#ui-custom-expand-button:has(i.opacity-25) {transform: rotateX(-180deg) scale(1.2);}\n";

            if (ui_custom_animation) {
              ui_custom_style += "div#toTop a.ui-custom-expand-hidden.d-block.cu-animation {transition: all 0.5s;height: 100%;}\n" +
              "div#toTop a.ui-custom-expand-hidden.d-none.cu-animation {display: block !important;transition: all 0.3s;opacity: 0;transform: scale(0.5) rotate(0deg) translateY(200%);border-radius: 100%;}\n" +
              "div#toTop a#ui-custom-expand-button.cu-animation {transition: all 0.7s;}\n" +
              "div#toTop a#ui-custom-expand-button.cu-animation:has(i.opacity-25) {transition: all 0.5s;}\n";
            }
        }
      }
      //hide_nick(ui_obj);
    }
    if (ui_custom_animation) {
      //ui_custom_style += "#sidebar-site-menu .nav-item a.nav-link:hover i{animation-duration: 0.5s;animation-name: rightPop;}\n";
      ui_custom_style += "#sidebar-site-menu .nav-item a.nav-link:hover i::before{animation-duration: 0.5s;animation-name: smallTwistRight;}\n";
      ui_custom_style += "#sidebar-site-menu .nav-item a.nav-link:hover span.badge{animation-duration: 0.5s;animation-name: smallTwistLeftMargin;}\n";
      //ui_custom_style += "#sidebar-site-menu .nav-item a.nav-link:active i{animation-duration: 1s;animation-name: rightPop;}\n";
      //ui_custom_style += "#sidebar-site-menu .nav-item a.nav-link:active i::before{animation-duration: 1s;animation-name: smallTwist;}\n";

      ui_custom_style += "#bo_list li.da-link-block:hover {animation-duration: 0.5s;animation-name: popUp;}\n";
      ui_custom_style += "li.da-link-block.ui-custom-link-active {animation-duration: 1s;animation-name: linkPopSmall !important;animation-fill-mode: forwards}";
      ui_custom_style += "div.nav-item.ui-custom-link-active {animation-duration: 1s;animation-name: linkPop !important;animation-fill-mode: forwards}";
      //ui_custom_style += "#bo_list li.da-link-block:active {animation-duration: 1s;animation-name: popUpEnd10;animation-fill-mode: forwards;}\n";
      //ui_custom_style += "#bo_list li.da-link-block:has(a:active) {animation-duration: 1s;animation-name: popUpEnd10;animation-fill-mode: forwards;}\n";
      
      ui_custom_style += "@keyframes popUp {0% {transform: translateX(0%) scale(1);}20% {transform: translateX(1%) scale(1.02);}100% {transform: translateX(0%) scale(1);}}\n";
      ui_custom_style += "@keyframes linkPopSmall {0% {transform: translateY(0%) scale(1);}20% {transform: translateY(-3%) scale(1.03);}100% {transform: translateY(0%) scale(1);}}\n";
      ui_custom_style += "@keyframes linkPop {0% {transform: translateY(0%) scale(1);}20% {transform: translateY(-5%) scale(1.05);}100% {transform: translateY(0%) scale(1);}}\n";

      ui_custom_style += "@keyframes popUp05 {0% {transform: scale(1);}20% {transform: scale(1.05);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp10 {0% {transform: scale(1);}20% {transform: scale(1.1);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp15 {0% {transform: scale(1);}20% {transform: scale(1.15);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp20 {0% {transform: scale(1);}20% {transform: scale(1.2);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp25 {0% {transform: scale(1);}20% {transform: scale(1.25);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp30 {0% {transform: scale(1);}20% {transform: scale(1.3);}100% {transform: scale(1);}}\n";

      ui_custom_style += "@keyframes popUpEnd05 {0% {transform: scale(1);}20% {transform: scale(1.05);}100% {transform: scale(1.05);}}\n";
      ui_custom_style += "@keyframes popUpEnd10 {0% {transform: scale(1);}20% {transform: scale(1.1);}100% {transform: scale(1.1);}}\n";
      ui_custom_style += "@keyframes popUpEnd15 {0% {transform: scale(1);}20% {transform: scale(1.15);}100% {transform: scale(1.15);}}\n";
      ui_custom_style += "@keyframes popUpEnd20 {0% {transform: scale(1);}20% {transform: scale(1.2);}100% {transform: scale(1.2);}}\n";
      ui_custom_style += "@keyframes popUpEnd25 {0% {transform: scale(1);}20% {transform: scale(1.25);}100% {transform: scale(1.25);}}\n";
      ui_custom_style += "@keyframes popUpEnd30 {0% {transform: scale(1);}20% {transform: scale(1.3);}100% {transform: scale(1.3);}}\n";

      ui_custom_style += "@keyframes rightPop {0% {margin-right: 0em;}20% {margin-right: 0.4em;}100% {margin-right: 0em;}}\n";
      ui_custom_style += "@keyframes smallTwistLeft {0% {transform: rotateZ(0deg);}20% {transform: rotateZ(-30deg);} 55% {transform: rotateZ(15deg);}100% {transform: rotateZ(0deg);}}\n";
      ui_custom_style += "@keyframes smallTwistLeftMargin {0% {margin-right: 0em;transform: rotateZ(0deg);}20% {margin-right: 0.4em;transform: rotateZ(-30deg);} 55% {transform: rotateZ(15deg);}100% {margin-right: 0em;transform: rotateZ(0deg);}}\n";
      ui_custom_style += "@keyframes smallTwistRight {0% {transform: rotateZ(0deg);}20% {transform: rotateZ(30deg);} 55% {transform: rotateZ(-15deg);}100% {transform: rotateZ(0deg);}}\n";
    }

    remove_ui_custom_styles();
    if (ui_custom_style != "") {
      set_body_op_start();
      document.head.innerHTML += "<style id=\"user_ui_custom_styles\">\n" + ui_custom_style + "</style>";
    }
  }
  function ui_custom_value_view(){
    if (document.getElementById('ui_custom_json') != null) {
      document.getElementById('ui_custom_json').value = get_ui_custom_input_string();
    }
    set_ui_custom_value_btn(false);
  }
  function ui_custom_value_cancle(){
    set_ui_custom_value_btn(true);
  }
  function ui_custom_value_clear(){
    if (document.getElementById('ui_custom_json') != null) {
      document.getElementById('ui_custom_json').value = "";
      set_ui_custom_values(true);
    }
  }
  function ui_custom_value_reload(){
    set_ui_custom_input_clear();
    set_ui_custom_values(false);
  }
  function ui_custom_value_save(){
    if (set_ui_custom_values(true)) {
      set_ui_custom_value_btn(true);
      setTimeout(function(){
        alert("값이 정상적으로 입력되었습니다.");
      });
    }
  }
  function ui_custom_value_paste(){
    if (document.getElementById('ui_custom_json') != null) {    
      try{
        navigator.clipboard.readText().then((clipText) => {
          document.getElementById('ui_custom_json').value = clipText;
          ui_custom_value_save();
        });  
      } catch(e1) {
        try{
          document.getElementById('ui_custom_json').select();
          document.execCommand("paste");
          ui_custom_value_save();
        } catch(e2) {
          alert("클립보드의 내용을 가져올 수 없습니다.");
        }  
      }
    }
  }

  function ui_custom_value_copy(){
    if (document.getElementById('ui_custom_json') != null) {
      try {
        navigator.clipboard.writeText(document.getElementById('ui_custom_json').value);
        alert("클립보드에 저장 되었습니다.");
      } catch (err) {
        try {
          document.getElementById('ui_custom_json').select();
          document.execCommand("copy");  
        } catch(e2) {
          alert("클립보드 권한을 확인해보세요.");
        } 
      }
    }
  }

  function set_ui_custom_value_btn(default_mode){
    var default_el = Array.from(document.querySelectorAll("#user-ui-custom .ui-custom-btn-default"));
    var view_el = Array.from(document.querySelectorAll("#user-ui-custom .ui-custom-btn-view"));
    if (default_mode) {
      default_el.forEach((item)=>{
        item.classList.remove("d-none");
        item.classList.add("d-block");
      });
      view_el.forEach((item)=>{
        item.classList.remove("d-block");
        item.classList.add("d-none");
      });
    } else {
      default_el.forEach((item)=>{
        item.classList.add("d-none");
        item.classList.remove("d-block");
      });
      view_el.forEach((item)=>{
        item.classList.add("d-block");
        item.classList.remove("d-none");
      });

    }

  }

  var ui_custom_input = [
    "ui_custom"
    , "show_width"
    , "font_family"
    , "font_size"
    , "line_height"
    , "menu_width"
    , "back_button"
    , "animation_off"
    , "thumbup_em_off"

    , "left_menu"
    , "menu_off"
    , "left_menu_over"
    , "left_quick_button"

    , "expand_quick"
    , "expand_shortcut"
    , "expand_shortcut_1"
    , "expand_shortcut_2"
    , "expand_shortcut_3"
    , "expand_shortcut_4"
    , "expand_shortcut_5"
    , "expand_shortcut_6"
    , "expand_shortcut_7"
    , "expand_shortcut_8"
    , "expand_shortcut_9"
    , "expand_shortcut_0"
    , "expand_write"
    , "expand_mywr"
    , "expand_navigator"
    , "expand_quick_size"

    , "menu_scroll"
    , "list_search"
    , "list_toggle"
    , "hide_nick"

    , "hide_member_memo"
    , "hide_list_memo"
    , "memo_ip_track"

    , "mymenu_img"

    , "read_history"
    , "read_history_em"
    , "read_history_reply_cnt"
    , "read_history_noti"
    , "read_history_noti_reply"


    , "title_filtering"
    , "filtering_word"

    , "content_blur"
    , "content_blur_word"

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
  var ui_custom_default = { show_width: 1200, font_size: 1, line_height: 1.5, menu_width: 25, expand_quick_size: 2.5 };

  function set_ui_custom_input_clear(){
    ui_custom_input.forEach(function (reg) {
      var temp_input = $("#reg_" + reg)[0]
      if (temp_input != null) {
        if (temp_input.type == "checkbox") {
          temp_input.checked = (ui_custom_default[reg] ?? false);
        } else {
          temp_input.value = "";
        }
      }
    });
  }
  function get_ui_custom_input_string(){

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
    if (changed) {
      try{
        json_str = JSON.stringify(ui_custom_json);
      } catch(e) {
      }
    }
    return json_str;
  }

  function ui_custom_apply() {
    var item_key = "ui_custom";
    var json_str = get_ui_custom_input_string();
    if (json_str!="") {
      localStorage.setItem(item_key, json_str);
    } else {
      localStorage.removeItem(item_key)
    }

    if (document.getElementById('ui_custom_json') != null) document.getElementById('ui_custom_json').value = json_str;

    alert("변경사항이 적용되었습니다.");
    try {
      set_ui_custom();
      is_set_expand_button = false;
      setTimeout(function () {
        draw_ui_custom(true);
      }, 100);
    } catch (e) {
      console.error('Failed to initialize custom UI settings:', error);
    }
  }

  function set_ui_custom_values(text_area) {
    var ui_custom_storage_str;
    if (text_area ?? false) {
      if (document.getElementById('ui_custom_json') != null) {
        ui_custom_storage_str = document.getElementById('ui_custom_json').value;
      }
    } else {
      ui_custom_storage_str = localStorage.getItem("ui_custom");
    }
    var ui_custom_obj = null;
    var success = true;
    
    if (ui_custom_storage_str != null && ui_custom_storage_str != "") {
      ui_custom_storage_str = ui_custom_storage_str.trim();
    } else {
      ui_custom_storage_str = "{}"
    }
    try{
      ui_custom_obj = JSON.parse(ui_custom_storage_str);
      if (text_area) {
        set_ui_custom_input_clear();
      }
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
      if (!text_area) {
        if (document.getElementById('ui_custom_json') != null) document.getElementById('ui_custom_json').value = ui_custom_storage_str;
      }
    } catch(e){
      success = false;
    }

    if (success) {
      set_ui_custom_trigger();
    } else {
      alert("입력값이 잘못 되었습니다.");
    }
    return success;
  }

  function hide_nick(ui_obj, reload) {
    //console.debug("hide_nick start");
    if (reload == null) {
      reload = false;
    }
    if (ui_obj != null) {

      //본문 필터링
      if (ui_obj.content_blur ?? false) {
        check_content_blur(ui_obj?.content_blur_word);
      }
      //제목 필터링
      if (ui_obj.title_filtering ?? false) {
        set_title_filtering(ui_obj?.filtering_word);
      }
      //읽은 글 체크
      if (ui_obj.read_history ?? false) {
        check_read_history(ui_obj);
      }
      //단축키
      set_shortcut_custom(ui_obj);

      if (ui_obj.ui_custom != null && ui_obj.ui_custom) {
        if (!(ui_obj.thumbup_em_off ?? false)) {
          set_thumbup_em(reload);
        }
        //목록 감추기
        if (ui_obj.list_toggle != null && ui_obj.list_toggle) {
          set_list_toggle();
        }

        //닉네임 감추기
        if (ui_obj.hide_nick != null && ui_obj.hide_nick) {
          set_hide_nick();
        }


        //팝업메뉴 왼쪽으로
        set_left_menu_over((ui_obj.left_menu_over != null && ui_obj.left_menu_over));

        //백버튼 활성화
        set_back_button((ui_obj.back_button != null && ui_obj.back_button));

        // 회원메모 감추기
        if (ui_obj.hide_member_memo != null && ui_obj.hide_member_memo) {
          set_hide_member_memo();
        }

        // 메모목록 감추기
        if (ui_obj.hide_list_memo != null && ui_obj.hide_list_memo != "") {
          set_hide_list_memo(ui_obj.hide_list_memo);
        }

        //이미지 변경
        if (ui_obj.mymenu_img != null && ui_obj.mymenu_img) {
          set_change_mymenu_img(ui_obj?.hide_nick ?? false);
        }

        //단축버튼 왼쪽으로
        set_left_quick_button((ui_obj.left_quick_button != null && ui_obj.left_quick_button));
        //단축버튼 확장
        if ((ui_obj.expand_quick != null && ui_obj.expand_quick)) {
          if (!is_set_expand_button) {
            is_set_expand_button = true;
            if (reload) {
              if (ui_custom_animation) {
                set_expand_button_hide();
                setTimeout(function () {
                  set_expand_quick(ui_obj, reload);
                }, 550);  
              } else {
                set_expand_quick(ui_obj, reload);
              }
            } else {
              set_expand_quick(ui_obj, reload);
            }
          }
        } else if (reload ?? false) {
          var expand_button = document.getElementById("ui-custom-expand-button");
          if (expand_button != null) {
            expand_button.remove();
            var toTop = document.getElementById('toTop');
            if (toTop != null) {
              toTop.classList.remove("d-block");
            }
            var toTop_as = toTop.querySelector("#toTop a:has(i.bi-arrow-up-square-fill)");
            if (toTop_as != null) {
              toTop_as.classList.add("d-none");
              toTop_as.classList.add("d-sm-inline-block");
            }
          }
        }

        if (ui_custom_animation) {
          set_links_active_pop()
        }
        if (ui_obj.memo_ip_track ?? false) {
          start_memo_tracking();
        }
      }
      set_body_op_end();
    }
  }

  //함수 모음 시작
  function set_thumbup_em(reload){
    var cv_1,cv_2,cv_3,cv_4,cv_5;
    var rv_1,rv_2,rv_3;
    var cv_1=5, cv_2=10, cv_3=15, cv_4=20,cv_5=30;
    var rv_1=500, rv_2=1000,rv_3=5000;
    //var option_class = ["bg-danger","bg-success","bg-primary","bg-info","bg-secondary","bg-opacity-25","bg-opacity-10","bg-gradient","fw-bold","cu_rv_1","cu_rv_2","cu_rv_3"];
    var option_class = ["cu_rv_1","cu_rv_2","cu_rv_3","cu_rv_4","cu_rv_5"];
    Array.from(document.querySelectorAll("#bo_list .list-group-item.da-link-block:has(div.rcmd-box)")).forEach((item)=>{
      var thumb_up = item.querySelector("div.rcmd-box");
      if (thumb_up!=null) {
        if (reload) {
          option_class.forEach((tc)=>{
            thumb_up.classList.remove(tc);
          })  
        }
      
        var temp_num = thumb_up;
        if (temp_num==null) {
          temp_num = 0;
        } else {
          temp_num = Number(temp_num.innerText.split("\n")[0]);
        }
        var add_class_list = "";
        if (temp_num >= cv_5) {
          add_class_list = "cu_rv_5";
        } else if (temp_num > cv_4){
          add_class_list = "cu_rv_4";
        } else if (temp_num >= cv_3){
          add_class_list = "cu_rv_3";
        } else if (temp_num >= cv_2){
          add_class_list = "cu_rv_2";
        } else if (temp_num >= cv_1){
          add_class_list = "cu_rv_1";
        }
        /*
        var read_num = item.querySelector("div.wr-num.order-4");
        if (read_num==null) {
          read_num = 0;
        } else {
          read_num = Number(read_num.innerText.split("\n")[0]);
        }
        */
        if (add_class_list!="") {
          thumb_up.classList.add(add_class_list);
        }
      }
    });
  }
  
  function set_list_toggle() {
    var parent_write = document.getElementById(body_parent_id);
    if (parent_write != null) {
      var list_title = document.querySelector("#bo_list_wrap > div > div");
      var write_title = document.getElementById("bo_v_title");

      list_title.addEventListener("click", list_toggle_event);
      list_title.style.cursor = "pointer";

      write_title.addEventListener("click", list_toggle_event);
      write_title.style.cursor = "pointer";

      list_toggle(false);
    }
  }
  function list_toggle_event(e) {
    list_toggle();
  }

  function list_toggle(force_list_mode) {
    var parent_write = document.getElementById(body_parent_id);
    if (parent_write != null) {
      var view_mode = !parent_write.classList.contains("d-none");
      if (document.getElementById("bo_v_title").style.cursor == "pointer") {

        var info_write = document.getElementById(info_write_id);
        var view_comment = document.getElementById(view_comment_id);
        var write_comment = document.getElementById(write_comment_id);
        var board_list = document.getElementById(board_list_id);


        if (force_list_mode ?? view_mode) {
          //list mode로 변경
          if (parent_write) parent_write.classList.add("d-none");
          if (info_write) info_write.classList.add("d-none");
          if (view_comment) view_comment.classList.add("d-none");
          if (write_comment) write_comment.classList.add("d-none");
          if (board_list) board_list.classList.remove("d-none");

        } else {
          //view mode로 변경
          if (parent_write) parent_write.classList.remove("d-none");
          if (info_write) info_write.classList.remove("d-none");
          if (view_comment) view_comment.classList.remove("d-none");
          if (write_comment) write_comment.classList.remove("d-none");

          if (board_list) board_list.classList.add("d-none");

        }
      }
      if (force_list_mode == null) {
        location.replace(view_mode ? "#bo_list_wrap" : "#main-wrap");
      }
    }
  }

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
      case "blur100":
        filter_style = "blur(10em)"
        filter_text = "블러100";
        break;
      default:
        if (memo_state == "") {
          filter_text = "감추기";
        }
        break;
    }

    for (var i = 0; i < memo_list.length; i++) {
      if (memo_list[i] != null) {
        if (memo_state == "") {
          memo_list[i].classList.add('d-none');
        } else {
          memo_list[i].classList.remove('d-none');
        }
        var temp_em = memo_list[i].querySelectorAll('em.da-member-memo__memo');
        if (temp_em != null) {
          temp_em.forEach((e) => { e.style.filter = filter_style });
          //temp_em.addEventListener('click',toggle_hide_member_memo)
          //temp_em.style.filter = filter_style;
        }
      }
    }
    var button = document.getElementById("btn_memo_toggle");
    if (button != null) {
      button.innerHTML = filter_text;
    }
  }

  function set_hide_list_memo(memo_type) {
    var memo_class = "da-member-memo__memo"
    if (memo_type != "all") {
      memo_class = "da-memo-color--" + memo_type;
    }
    var memo_em_list = document.querySelectorAll("section#bo_list > ul > li.list-group-item .da-member-memo em." + memo_class);
    for (var i = 0; i < memo_em_list.length; i++) {
      var li = memo_em_list[i].closest("li.list-group-item");
      if (li != null) {
        li.classList.add("d-none");
      }
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
        change_state = "blur100"
        break;
      case "blur100":
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

  function set_left_quick_button(set_use) {
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

  var body_parent_id = "bo_v_atc";
  var body_con_id = "bo_v_con";
  var body_blur_id = "bo_v_con_blur";

  var info_write_id = "bo_v_info";
  var view_comment_id = "viewcomment";
  var write_comment_id = "bo_vc_w";
  var board_list_id = "bo_list";

  function remove_blur(e) {
    e.preventDefault();
    var body_con = document.getElementById(body_con_id)
    var blur_txt = document.getElementById(body_blur_id);
    if (body_con.style.filter != "") {
      body_con.style.removeProperty('transition');

      if (!ui_custom_animation) {

        body_con.style.removeProperty('filter');
        body_con.style.removeProperty('opacity');
        body_con.style.removeProperty('max-height');
        body_con.style.removeProperty('overflow');
        blur_txt.remove();
        document.getElementById(body_parent_id).style.removeProperty("position");

      }  else {
        var remove_transition = function(e){
          var blur_txt = document.getElementById(body_blur_id);
          if (blur_txt != null) {
            blur_txt.remove();
            document.getElementById(body_parent_id).style.removeProperty("position");
            }
          body_con.style.removeProperty('transition');
          body_con.removeEventListener('transitionend', remove_transition);
        };
        body_con.style.filter = "blur(5em)";
        body_con.style.opacity = "0.7";
        body_con.style.setProperty('transition', 'all 0.2s');
      
        setTimeout(function(){
          body_con.style.setProperty('transition', 'all 0.7s');
          body_con.addEventListener('transitionend', remove_transition);
          body_con.style.removeProperty('filter');
          body_con.style.removeProperty('opacity');
          body_con.style.removeProperty('max-height');
          body_con.style.removeProperty('overflow');
        },200);      
        body_con.removeEventListener("click", remove_blur);
        
        if (blur_txt != null) {
          blur_txt.style.setProperty('opacity', '0.5');
          var remove_blur_txt_transition = function(e){
            blur_txt.remove();
            document.getElementById(body_parent_id).style.removeProperty("position");
          };
          blur_txt.addEventListener('transitionend', remove_blur_txt_transition);
          setTimeout(function(){
            blur_txt.style.setProperty('transition', 'all 1s');
            blur_txt.style.setProperty('opacity', '0');          
          },100);
        }
      }
    }
  }
  function set_blur_padding() {
    var body_con = document.getElementById(body_con_id);
    var blur_txt = document.getElementById(body_blur_id);
    blur_txt.style.removeProperty("height");
    var paddingTB = ((body_con.offsetHeight - blur_txt.offsetHeight)) / 2;
    blur_txt.style.top = body_con.offsetTop + "px";
    blur_txt.style.paddingTop = paddingTB + "px";
    blur_txt.style.paddingBottom = paddingTB + "px";
  }

  function check_content_blur(word_list) {
    if (document.getElementById(body_con_id) != null) {
      word_list = (word_list ?? "").trim()
      var check_regex = /^[ㄱ-ㅎ가-힣a-zA-Z0-9\[\]\(\)]+$/;
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
          var title_text = document.getElementById("bo_v_title")?.innerText ?? "";
          if (re.test(title_text)) {
            set_content_blur();
          } else {
            if (ui_custom_animation) {
              var body_con = document.getElementById(body_con_id);
              body_con.style.filter = "blur(0.2em)";
              body_con.style.opacity = "0.1";
              var remove_transition = function(){
                this.removeEventListener('transitionend', remove_transition);
                body_con.style.removeProperty('transition');
                body_con.style.removeProperty('filter');
                body_con.style.removeProperty('opacity');
              }
              setTimeout(function(){
                body_con.style.setProperty('transition', 'all 0.4s');
                body_con.style.filter = "blur(0em)";      
                body_con.style.opacity = "1";
                body_con.addEventListener('transitionend', remove_transition);
              },100);  
            }
          }
        }
      }
    }
  }

  function set_content_blur() {
    var body_con = document.getElementById(body_con_id);
    body_con.style.filter = "blur(3em)";
    body_con.style.opacity = "0.7";
    body_con.style.maxHeight = "700px";
    body_con.style.overflow = "hidden";

    if (!ui_custom_animation) {
      body_con.style.filter = "blur(9em)";      
      body_con.style.opacity = "0.3";
  } else {
      body_con.style.filter = "blur(3em)";
      body_con.style.opacity = "0.7";
      setTimeout(function(){
        body_con.style.setProperty('transition', 'all 1s');
        body_con.style.filter = "blur(9em)";      
        body_con.style.opacity = "0.3";
      },300);

    }

    body_con.addEventListener("click", remove_blur);
    document.getElementById(body_parent_id).style.position = "relative";
    var blur_txt = document.createElement("div");
    blur_txt.id = body_blur_id;
    blur_txt.style.textAlign = "center";
    blur_txt.style.position = "absolute";
    blur_txt.style.width = body_con.offsetWidth + "px";
    blur_txt.style.fontSize = "2em";
    blur_txt.style.fontWeight = "800";
    blur_txt.style.cursor = "pointer";
    blur_txt.style.height = body_con.offsetHeight + "px";
    blur_txt.addEventListener("click", remove_blur);
    body_con.after(blur_txt);
    var blur_img = document.createElement("img");
    blur_img.src = "https://damoang.net//data/editor/b7767-664966b303898-9eea4d0b7513e8395986b5aa7c42d1854c10bc21.png";
    blur_img.style.maxWidth = "150px";
    blur_img.onload = set_blur_padding;
    blur_txt.append(blur_img);
  }

  function set_expand_quick(ui_obj, reload) {
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
        var tag_a_className = "ui-custom-expand-icon ui-custom-expand-hidden d-none-start fs-1 m-3 mb-1 mt-1 bg-secondary bg-opacity-25";
        var tag_a_id_prev = "ui-custom-expand-";
        toTop_as = toTop_as.parentElement;
        var ex_hrefs = ["menu", "go_write", "go_reply", "list_toggle", "list", "my_write", "my_reply", "memo_toggle", "forward", "back"];
        var ex_titles = ["팝업메뉴", "글쓰기", "댓글쓰기", "목록 토글", "목록으로", "내 글 - 현재 게시판", "내 댓글 - 현재 게시판", "메모 상태", "앞으로", "뒤로"];
        var ex_icons = ["list", "pencil-square", "r-square-fill", "square-half", "filter-square-fill", "chat-square-text-fill", "chat-square-quote-fill", "chat-square-dots-fill", "arrow-right-square-fill", "arrow-left-square-fill"];
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
              if ((ui_obj.expand_write ?? false) && (board_obj != null && board_obj.id != null && board_obj.board != null)) {
                tag_a = document.createElement("a");
                tag_a_href = "/" + board_obj.board + "/write";
              }
              break;
              break;
            case "go_reply":
              if ((ui_obj.expand_write ?? false) && (board_obj != null && board_obj.id != null && board_obj.board != null)) {
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
              if ((ui_obj.expand_mywr ?? false) && (board_obj != null && board_obj.id != null && board_obj.board != null)) {
                tag_a = document.createElement("a");
                tag_a_href = "/" + board_obj.board + "?sfl=mb_id%2C" + (ex_hrefs[i] == "my_write" ? 1 : 0) + "&stx=" + board_obj.id;
              }
              break;
            case "memo_toggle":
              if ((ui_obj.hide_member_memo ?? false)) {
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
            case "list_toggle":
              if ((ui_obj.list_toggle ?? false) && (location.pathname.match(/\//g)?.length ?? 0) > 1) {
                tag_a = document.createElement("a");
                tag_a.addEventListener("click", function (e) {
                  e.preventDefault();
                  list_toggle();
                });
              }
              break;
            case "forward":
              if ((ui_obj.expand_navigator ?? false) && (window?.navigation == null ? true : window?.navigation?.canGoForward)) {
                tag_a = document.createElement("a");
                tag_a.addEventListener("click", function (e) {
                  e.preventDefault();
                  history.forward();
                  //set_expand_quick();
                });
              }
              break;
            case "back":
              if ((ui_obj.expand_navigator ?? false) && (window?.navigation == null ? true : window?.navigation?.canGoBack)) {
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
            tag_a.className = tag_a_className;
            tag_a.id = tag_a_id_prev + ex_hrefs[i];
            tag_a.title  = ex_titles[i];
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

        if (ui_obj.shortcut_use && ui_obj.expand_shortcut) {
          for (var i = 1; i < 11; i++) {
            var check_i = (i<10 ? i:i - 10) + "";
            if ((ui_obj["expand_shortcut_" + check_i] ?? false) && shortcut_map[check_i]?.href != null ){
              var tag_a = document.createElement("a");
              tag_a.href = shortcut_map[check_i].href;
              tag_a.className = tag_a_className;
              tag_a.id = tag_a_id_prev + shortcut_map[check_i].code;
              tag_a.title  = shortcut_map[check_i].name;
              var tag_i = document.createElement("i");
              tag_i.className = "bi bi-" + check_i + "-square-fill";
              tag_a.appendChild(tag_i);
              toTop.insertBefore(tag_a, toTop_as);
              add_button = true;  
            }
          }
        }        

        if (add_button) {
          toTop.classList.add('d-block');

          toTop_as.classList.remove("d-sm-inline-block");
          toTop_as.classList.remove("d-block");

          toTop_as.classList.add("ui-custom-expand-hidden");
          toTop_as.classList.add("bg-secondary");
          toTop_as.classList.add("bg-opacity-25");

          toTop_as.classList.add("d-none-start");
          //toTop_as.style.setProperty('display', 'none', 'important');
          toTop_as.classList.add("mt-1");
          toTop_as.classList.add("mb-1");
          toTop_as.title = "맨 위로";

          var tag_a = document.createElement("a");
          tag_a.href = "javascript:;"; //"#" + ex_hrefs[i];
          tag_a.className = "ui-custom-expand-icon d-block fs-1 m-3 mt-1";
          tag_a.id = "ui-custom-expand-button";
          var tag_i = document.createElement("i");
          tag_i.id = "ui-custom-expand-button-i"
          tag_i.className = "bi bi-caret-down-square-fill opacity-25";
          tag_i.title = "확장버튼 감추기";
          tag_a.appendChild(tag_i);
          tag_a.addEventListener("click", toggle_expand_button);
          toTop.appendChild(tag_a);

          if (reload) {
            set_expand_button(false);
            //setTimeout(set_expand_button);
          } else {
            setTimeout(set_expand_button, 300);
          }

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

  function set_expand_button_hide(start) {
    var show_list = toTop.getElementsByClassName("ui-custom-expand-hidden");
    var start_str = "";
    if (start ?? false) {
      start_str = "start";
    }
    for (var i = 0; i < show_list.length; i++) {
      show_list[i].classList.add("d-none" + start_str);
    }
    var button = document.getElementById("ui-custom-expand-button-i");
    if (button != null) {
      button.classList.add("opacity-25");
      button.title = "확장버튼 보이기";
    }
  }

  var is_set_expand_button = false;
  var is_set_expand_button_ing = false;
  function set_expand_button(animation) {
    if (animation == null) animation = false;

    var expand_button_state = localStorage.getItem(expand_state_key);
    var b_show = (expand_button_state == "show");
    var button = document.getElementById("ui-custom-expand-button-i");
    if (button != null) {
      
      if (ui_custom_animation) {
        if (animation) {
          button.parentNode.classList.add("cu-animation");
        }
      } else {
        button.parentNode.classList.remove("cu-animation");        
      }

      if (b_show) {
        button.classList.remove("opacity-25");
        button.title = "확장버튼 감추기";
      } else {
        button.classList.add("opacity-25");
        button.title = "확장버튼 보이기";
      }
    }
    var show_list = toTop.getElementsByClassName("ui-custom-expand-hidden");
    var show_length = show_list.length;
    if (show_length == 0) {
      is_set_expand_button_ing = false;
    } else {
      for (var i = 0; i < show_length; i++) {
        var temp_show = show_list[i];
        var check_i = i;
        var is_final = (i + 1 == show_length);
        if (b_show) {
          check_i = show_length - i - 1;
        }

        var temp = temp_show;
        if (animation) {
          temp.classList.remove("d-none-start");
          temp.classList.add("cu-animation");          
          setTimeout(function(temp, is_final, b_show){
            if (b_show) {
              temp.classList.remove("d-none");
              temp.classList.add("d-block");
            } else {
              temp.classList.remove("d-block");
              //show_list[i].classList.remove("d-none-start");
              temp.classList.add("d-none");
            }
            if (is_final) {
              setTimeout(function(){
                is_set_expand_button_ing = false;
              },700);
            }
          },(check_i) * 30 + 10, temp_show, is_final, b_show);
        } else {
          temp.classList.remove("d-none-start");
          temp.classList.remove("cu-animation");

          if (b_show) {
            temp.classList.remove("d-none");
            temp.classList.add("d-block");
          } else {
            temp.classList.remove("d-block");
            //show_list[i].classList.remove("d-none-start");
            temp.classList.add("d-none");
          }

          temp.classList.remove("page-start");
        }      

      }
      if (!animation) {
        is_set_expand_button_ing = false;
      }        
    }      
  }
  
  function toggle_expand_button() {
    if (is_set_expand_button_ing) {
      return;
    } else {
      is_set_expand_button_ing = true;
      var expand_button_state = localStorage.getItem(expand_state_key);
      if (expand_button_state == "show") {
        localStorage.removeItem(expand_state_key)
      } else {
        localStorage.setItem(expand_state_key, "show");
      }
      set_expand_button(ui_custom_animation);      
    }
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
      var wr_id = null;
      var board_name_length = location.pathname.indexOf("/", 1);
      if (board_name_length == -1) {
        board_name_length = location.pathname.length;
      } else {
        wr_id = location.pathname.substring(board_name_length + 1);
      }
      var board_name = location.pathname.substring(1, board_name_length)
      if (link_map[board_name] != null) {
        link_obj = {};
        link_obj.board = board_name;
        if (wr_id != null) {
          link_obj.wr_id = wr_id;
        }
      }
    }

    var myw_link = link_map["_myw"]?.org ?? "";

    var myw_link_obj = document.querySelector("div#memberOffcanvas div.my-2 span.profile_img");
    if (myw_link_obj != null) {
      var temp_a = myw_link_obj.closest('a.sv_member');
      if (temp_a != null) {
        myw_link = temp_a.href
      }
    }

    if (myw_link.length > 0) {
      var p_n = "mb_id";
      if (myw_link.indexOf("sfl=" + p_n) > -1) {
        p_n = "stx";
      }
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
    }

    return link_obj;
  }

  function set_links_active_pop(){
    var sidebar_site_menu_links = document.querySelectorAll('#sidebar-site-menu div.nav-item:has(a.nav-link)');
    var list_menu_links = document.querySelectorAll("section#bo_list > ul > li.da-link-block:has(a.da-link-block)");
    Array.from(sidebar_site_menu_links).forEach(set_item_active_pop);
    Array.from(list_menu_links).forEach(set_item_active_pop);
  }
  function set_item_active_pop(item,index) {
    item.classList.remove("ui-custom-link-active");
    var a_tag = item.querySelector('a.da-link-block, a.nav-link')
    if (a_tag!=null) {
      a_tag.addEventListener("click",item_active_pop_event);
    } else {
      console.debug("a_tag is null");;
    }
  }
  function item_active_pop_event(e){
    console.debug(e.target);
    console.debug(this);
    var active_top = this.closest("div.nav-item , li.da-link-block");
    if (active_top != null) {
      active_top.classList.add("ui-custom-link-active");      
    } else {

    }
  }

  function set_shortcut_custom(ui_obj) {
    shortcut_map = {}

    if (ui_obj.hide_member_memo != null && ui_obj.hide_member_memo) {
      shortcut_map["U"] = {href:"javascript:toggle_hide_member_memo();",name:"메모",code:"memo"};
    }

    if (ui_obj?.list_toggle ?? false) {
      shortcut_map["D"] = {href:"javascript:list_toggle();",name:"목록토글",code:"list_toggle"};
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
          shortcut_link.innerHTML = '<span class="d-flex align-items-center gap-2 nav-link-title"><i class="' + temp_icon[i] + ' nav-icon"></i><span class="badge p-1 text-bg-secondary">·</span>' + temp_text[i] + "</span>";
          shortcut_div.appendChild(shortcut_link);
          sidebar_site_menu.insertBefore(shortcut_div, sidebar_site_menu_first);
          offcanvas_menu.insertBefore(shortcut_div.cloneNode(true), offcanvas_menu_first);
        }
      }

      var link_map = get_board_link_map();
      for (var i = 1; i < 11; i++) {
        var shortcut_i = i < 10 ? i : i - 10;
        var shortcut = (ui_obj["shortcut_" + shortcut_i] ?? "").trim();
        if (shortcut != "" && link_map[shortcut] != null) {
          var shortcut_div = document.createElement("div");
          shortcut_div.className = "nav-item shortcut_custom";
          var shortcut_link = document.createElement("a");
          shortcut_link.className = "nav-link shortcut_custom";
          shortcut_link.href = link_map[shortcut].org;
          shortcut_link.innerHTML = '<span class="d-flex align-items-center gap-2 nav-link-title"><i class="bi-list-stars nav-icon"></i> <span class="badge p-1 text-bg-secondary">' + shortcut_i + '</span>' + link_map[shortcut].name + "</span>";
          shortcut_div.appendChild(shortcut_link);
          sidebar_site_menu.insertBefore(shortcut_div, sidebar_site_menu_first);
          offcanvas_menu.insertBefore(shortcut_div.cloneNode(true), offcanvas_menu_first);
          shortcut_map[shortcut_i + ""] = {href:shortcut_link.href,name:link_map[shortcut].name,code:link_map[shortcut].link};
        }
      }
    }

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
    var key = (event?.code ?? "").replace(/Key|Digit|Numpad/, "");
    if (shortcut_map[key] != null) {
      switch (key) {
        case "U":
          toggle_hide_member_memo();
          break;
        case "D":
          list_toggle();
          break;
        default:
          window.location.href = shortcut_map[key].href;
          break;
      }
      return;
    } else {
      return;
    }
  }
  //함수 모음 끝

  //memo 추적 관련 기능 시작
  //indexedDB지원에 따라 UI표시 변경
  function check_indexDB() {
    var check_ui = document.querySelector(".ui-custom-memo-ip-check");
    if (check_ui != null) {
      var memo_check = document.getElementById('reg_memo_ip_track');
      if (window.indexedDB) {
        check_ui.classList.remove("d-none");
        if (memo_check != null) {
          memo_check.addEventListener("change", change_memo_tracking);
        }
      } else {
        if (memo_check != null && memo_check.checked) {
          memo_check.checked = false;
        }
        check_ui.classList.add("d-none");
      }
    }
  }

  //사용여부 변경에 따른 경고문구 표시
  function change_memo_tracking() {
    var memo_check = document.getElementById('reg_memo_ip_track');
    if (memo_check.checked) {
      var temp_obj = get_board_mb_id();
      check_memo_user_id(temp_obj?.id, null, null, function () {
        alert("빨간색 메모의 IP만 기록합니다.\n메모의 IP기록은 단순 참고만 하시기 바랍니다.");
      });
    }
  }

  //사용자 ID에 따른 DB체크 및 타 ID DB 삭제
  function check_memo_user_id(user_id, afterFn, checkedFn, notCheckedFn) {
    if (window.indexedDB) {
      window.indexedDB.databases().then(function (databases) {
        if (user_id != null && user_id != "") {
          var checked = false;
          if (databases.length > 0) {
            databases.forEach((database) => {
              if (database.name.indexOf(memoDBName) == 0) {
                if (database.name == (memoDBName + user_id)) {
                  checked = true
                } else {
                  window.indexedDB.deleteDatabase(database.name);
                }
              }
            })
          } else {
            //checked = true
          }
          if (checked) {
            if (checkedFn != null && (typeof checkedFn == 'function')) {
              checkedFn();
            }
          } else {
            if (notCheckedFn != null && (typeof notCheckedFn == 'function')) {
              notCheckedFn();
            }
          }
          if (afterFn != null && (typeof afterFn == 'function')) {
            afterFn();
          }
        }
      });
    }
  }

  function delete_memo_database() {
    if (window.indexedDB) {
      var temp_obj = get_board_mb_id();
      if (temp_obj != null && temp_obj.id) {
        try {
          if (confirm("기록을 삭제하시겠습니까?")) {
            window.indexedDB.databases().then(function (databases) {
              if (temp_obj.id != null && temp_obj.id != "") {
                if (databases.length > 0) {
                  databases.forEach((database) => {
                    if (database.name.indexOf(memoDBName) == 0) {
                      if (database.name == (memoDBName + temp_obj.id)) {
                        window.indexedDB.deleteDatabase(database.name);
                      }
                    }
                  });
                }
              }
            });
          }
        } catch (e) {
          console.debug(e);
        }
      }
    }
  }

  function get_write_info_list(board_obj) {
    if (board_obj == null) {
    }
    var check_list = [];
    var check_admin = /^admin$/;

    //글 작성자 정보
    if (document.querySelector("section#bo_v_info > div") != null) {
      var board_obj = get_board_mb_id();
      var write_divs = document.querySelector("section#bo_v_info > div").querySelectorAll("div");
      var write_info = {};
      if (write_divs.length > 1) {
        write_info.write_type = "write";
        var check_memo_em = write_divs[0].querySelector(".da-member-memo__memo.da-memo-color--red");
        if (check_memo_em != null) {
          write_info.memo_user = true;
        } else {
          write_info.memo_user = false;
        }
        var write_user_link = write_divs[0].querySelector("a.sv_member");
        if (write_user_link != null) {
          write_info.id = write_user_link.href.substring(write_user_link.href.indexOf("mb_id=") + 6);
          if (!check_admin.test(write_info.id) && board_obj?.id == null || board_obj.id != write_info.id) {
            var img_src = write_user_link.querySelector("span.profile_img img, img.mb-photo")?.src ?? "";
            var img_position = img_src.indexOf('/data/member_image');
            if (img_position > 0) {
              write_info.img = img_src.substring(img_position + 18);
            } else {
              write_info.img = null;
            }
            write_info.nick = write_user_link.text.trim();
            write_info.wr_id = board_obj?.wr_id;
            write_info.lastElementChild = write_divs[0].lastElementChild;
            write_info.ip = write_divs[0].lastElementChild.textContent;
            write_info.time = write_divs[1].lastChild.textContent.trim();
            if (write_info.time == "") {
              write_info.time = write_divs[1].lastElementChild.textContent.trim();
            }
            check_list.push(write_info);
          }
        }
      }
    }

    //코멘트 작성자 정보
    var c_list = document.querySelectorAll("#viewcomment #bo_vc > article");
    for (var i = 0; i < c_list.length; i++) {
      var c_item = c_list[i];
      var c_id = c_item.id;
      var c_divs = c_item.querySelectorAll("header > div >div")
      if (c_divs.length > 2) {
        var write_info = {};
        write_info.write_type = "comment";
        var check_memo_em = c_divs[0].querySelector(".da-member-memo__memo.da-memo-color--red");
        if (check_memo_em != null) {
          write_info.memo_user = true;
        } else {
          write_info.memo_user = false;
        }
        var write_user_link = c_divs[0].querySelector("a.sv_member");
        if (write_user_link != null) {
          write_info.id = write_user_link.href.substring(write_user_link.href.indexOf("mb_id=") + 6);
          if (!check_admin.test(write_info.id) && board_obj?.id == null || board_obj.id != write_info.id) {
            var img_src = write_user_link.querySelector("span.profile_img img, img.mb-photo")?.src ?? "";
            var img_position = img_src.indexOf('/data/member_image');
            if (img_position > 0) {
              write_info.img = img_src.substring(img_position + 18);
            } else {
              write_info.img = null;
            }
            write_info.nick = write_user_link.text.trim();
            write_info.wr_id = board_obj?.wr_id;
            write_info.c_id = c_id;
            write_info.lastElementChild = c_divs[0].lastChild;
            write_info.ip = c_divs[0].lastChild.textContent.trim().replace(/\(|\)/g, "");
            write_info.time = c_divs[2].lastChild.textContent.trim();
            if (write_info.time == "") {
              write_info.time = c_divs[2].lastElementChild.textContent.trim();
            }
            check_list.push(write_info);
          }
        }
      }
    }
    return check_list;
  }

  var memo_db_version = 1;
  var memoDBName = "memoTR_";
  var memoID = "memoID";
  var memoIP = "memoIP";
  var checkMultiClass = "ui-custom-check-multi-id";

  function memo_db_upgrade(event) {
    var db = event.target.result;
    // 메모ID용 스토어
    //{id:"",nick:"",img:"",last:"",access:"",ip:{ip:"",last:"", board:"",wr_id:"",c_id:""}}
    var idStore = db.createObjectStore(memoID, { keyPath: "id" });
    // 메모ID용 인덱스
    var idIndex = idStore.createIndex("by_id", "id");
    var idAccessIndex = idStore.createIndex("by_access", "access", { unique: false });

    // 메모IP용 스토어
    //{ip:"",id:{id:"",last:""}}}
    var ipStore = db.createObjectStore(memoIP, { keyPath: "ip" });
    // 메모IP용 인덱스
    var ipIndex = ipStore.createIndex("by_ip", "ip");
    var ipIdCntIndex = ipStore.createIndex("by_id_cnt", "id_cnt", { unique: false });
  }

  //데이터 정제
  function get_info_map_data(board_obj, info_list) {
    var info_map = {};
    info_map.info_list = info_list;
    info_map.memo_user_map = {};
    info_map.memo_ip_map = {};
    info_map.list_ip_map = {};
    for (var i = info_list.length - 1; i > -1; i--) {
      var temp = info_list[i];
      if (info_map.list_ip_map[temp.ip] == null) {
        info_map.list_ip_map[temp.ip] = { ip: temp.ip, p: [] };
      }
      info_map.list_ip_map[temp.ip].p.push(i);

      if (temp.memo_user) {
        if (temp.time != null) {
          if (temp.time.indexOf(":") == -1) {
            temp.time += " 00:00";
          }
          let today = new Date();
          if (temp.time.indexOf(".") == -1) {
            let month = today.getMonth() + 1;
            let date = today.getDate();
            temp.time = today.getFullYear() + "." + (month >= 10 ? month : '0' + month) + "." + (date >= 10 ? date : '0' + date) + " " + temp.time.trim();
          } else if (temp.time.lastIndexOf(".") == 2) {
            temp.time = today.getFullYear() + "." + temp.time.trim();
          } else if (temp.time.lastIndexOf(".") == 5) {
            temp.time = today.getFullYear().toString().substring(0, 2) + temp.time.trim();
          }
        }
        var temp_user_ip = { ip: temp.ip, last: temp.time, board: board_obj.board, wr_id: temp.wr_id, c_id: temp.c_id };

        var temp_ip = { ip: temp.ip };
        var temp_ip_user = { id: temp.id, nick: temp.nick, img: temp.img, board: board_obj.board, wr_id: temp.wr_id, c_id: temp.c_id, last: temp.time };
        temp_ip.id = {}
        temp_ip.id[temp.id] = temp_ip_user;

        if (info_map.memo_ip_map[temp.ip] != null) {
          if (info_map.memo_ip_map[temp.ip].id[temp.id] == null || info_map.memo_ip_map[temp.ip].id[temp.id].last < temp.time) {
            info_map.memo_ip_map[temp.ip].id[temp.id] = temp_ip_user;
          }
        } else {
          info_map.memo_ip_map[temp.ip] = temp_ip;
        }

        if (info_map.memo_user_map[temp.id] != null) {
          if (info_map.memo_user_map[temp.id].last < temp.time) {
            info_map.memo_user_map[temp.id].last = temp.time;
            info_map.memo_user_map[temp.id].nick = temp.nick;
            info_map.memo_user_map[temp.id].img = temp.img;
          }
          if (info_map.memo_user_map[temp.id].ip[temp.ip] != null) {
            if (info_map.memo_user_map[temp.id].ip[temp.ip].last < temp_user_ip.last) {
              info_map.memo_user_map[temp.id].ip[temp.ip] = temp_user_ip;
            }
          } else {
            info_map.memo_user_map[temp.id].ip[temp.ip] = temp_user_ip;
          }
        } else {
          var temp_id = { id: temp.id, nick: temp.nick, img: temp.img, last: temp.time };
          temp_id.ip = {};
          temp_id.ip[temp.ip] = temp_user_ip;
          info_map.memo_user_map[temp.id] = temp_id;
        }
      }
    }

    info_map.check_ids = Object.keys(info_map.memo_user_map);
    info_map.check_ips = Object.keys(info_map.memo_ip_map);
    info_map.list_ips = Object.keys(info_map.list_ip_map);
    info_map.now_stamp = Date.now();
    info_map.updated_id = false;
    info_map.updated_ip = false;
    return info_map;
  }

  function start_memo_tracking() {
    var removes = document.querySelectorAll("span." + checkMultiClass);
    if (removes != null && removes.length > 0) {
      for (var i = 0; i < removes.length; i++) {
        removes[i].remove();
      }
    }
    if (window.indexedDB) {
      var temp_obj = get_board_mb_id();
      if (temp_obj != null && temp_obj.id != null && temp_obj.wr_id != null) {
        check_memo_user_id(temp_obj.id);
        var info_list = get_write_info_list(temp_obj);
        if (info_list.length > 0) {
          //데이터 정제 시작
          var info_map = get_info_map_data(temp_obj, info_list);
          //데이터 정제 끝

          var memo_db_request = indexedDB.open(memoDBName + temp_obj.id, memo_db_version);
          memo_db_request.onupgradeneeded = memo_db_upgrade;
          memo_db_request.onsuccess = function (event) {
            var db = event.target.result;

            var update_complete = function () {
              if (info_map.updated_id && info_map.updated_ip) {
                remove_timeover_memo(db, function () {
                  show_check_ip_id(db, temp_obj, info_map);
                });
              }
            }

            //memo id 갱신
            update_memo_id(db, info_map, () => { info_map.updated_id = true; update_complete() });

            //memo ip 갱신
            update_memo_ip(db, info_map, () => { info_map.updated_ip = true; update_complete() });
          };
        }
      }
    }
  }

  function update_memo_id(db, info_map, complete) {
    var idStore = getDBObjectStore(db, memoID, "readwrite", complete);
    var checked_id = 0;
    info_map.check_ids.forEach((user_id) => {
      var temp_req = idStore.get(user_id);
      temp_req.onsuccess = function (e) {
        var result = e.target.result;
        var memo_user = info_map.memo_user_map[user_id];
        var ips = Object.keys(memo_user.ip);
        if (result == null) {
          memo_user.access = info_map.now_stamp;
          memo_user.ip_cnt = ips.length;
          ips.forEach((ip) => {
            memo_user.ip[ip].access = info_map.now_stamp;
          });
          idStore.add(memo_user)
          checked_id++;
        } else {
          var changed = false;
          if (result.last < memo_user.last) {
            result.nick = memo_user.nick;
            result.last = memo_user.last;
            result.img = memo_user.img;
            changed = true;
          } else {
            changed = true;
          }
          if (result.ip == null) {
            result.ip = {};
          }
          var result_ips = Object.keys(result.ip);
          ips.forEach((ip) => {
            var check_ip = memo_user.ip[ip];
            if (result.ip[ip] == null || result.ip[ip].last < check_ip.last) {
              if (result.ip[ip] == null) {
                result.ip_cnt = Object.keys(result.ip).length + 1;
              }
              result.ip[ip] = check_ip;
            }
            result.ip[ip].access = info_map.now_stamp;
            changed = true;
          });
          if (changed) {
            var check_access = info_map.now_stamp;
            result_ips.forEach((ip) => {
              if (result.ip[ip].access < check_access) {
                check_access = result.ip[ip].access;
              }
            });
            result.access = check_access;
            idStore.put(result);
            checked_id++;
          } else {
            checked_id++;
          }
        }
      };
      temp_req.onerror = function (e) {
        checked_id++;
      };
    });
  }

  function update_memo_ip(db, info_map, complete) {
    var checked_ip = 0;
    var ipStore = getDBObjectStore(db, memoIP, "readwrite", complete);

    //memo ip 갱신
    info_map.check_ips.forEach((user_ip) => {
      var temp_req = ipStore.get(user_ip);
      temp_req.onsuccess = function (e) {
        var result = e.target.result;
        var memo_ip = info_map.memo_ip_map[user_ip];
        var ids = Object.keys(memo_ip.id);

        if (result == null) {
          memo_ip.access = info_map.now_stamp;
          ids.forEach((id) => {
            memo_ip.id[id].access = info_map.now_stamp;
          });
          memo_ip.id_cnt = Object.keys(memo_ip.id).length;
          ipStore.add(memo_ip);
          checked_ip++;
        } else {
          var changed = false;
          if (result.id == null) {
            result.id = {};
          }
          ids.forEach((id) => {
            var check_id = memo_ip.id[id];
            if (result.id[id] == null || result.id[id].last < check_id.last) {
              if (result.id[id] == null) {
                result.id_cnt = Object.keys(result.id).length + 1;
              }
              result.id[id] = check_id;
            }
            result.id[id].access = info_map.now_stamp;
            changed = true;
          });

          if (changed) {
            result.access = info_map.now_stamp;
            ipStore.put(result);
            checked_ip++;
          } else {
          }
        }
      };
      temp_req.onerror = function (e) {
        checked_ip++;
      };
    });

  }

  function show_check_ip_id(db, board_obj, info_map, complete) {
    var listStore = getDBObjectStore(db, memoIP, "readonly", complete);
    info_map.list_ips.forEach((list_ip) => {
      var temp_req = listStore.get(list_ip);
      temp_req.onsuccess = function (e) {
        var result = e.target.result;
        if (result != null) {
          var ip_p = info_map.list_ip_map[list_ip].p;
          var ids = Object.keys(result.id);
          ip_p.forEach((p) => {
            var temp_info = info_map.info_list[p];
            var same_ip_ids = [];
            var same_ip_id_string = "";
            if (board_obj.id != temp_info.id) {
              ids.forEach((id) => {
                if (id != temp_info.id) {
                  same_ip_ids.push(result.id[id].nick);
                }
              });
            }

            if (same_ip_ids.length > 0) {
              var s = document.createElement('span');
              s.className = "ui-custom-check-multi-id da-member-memo";
              s.classList.add(checkMultiClass);
              s.innerHTML = "<span class='badge rounded-pill align-middle da-member-memo__memo da-memo-color--yellow'> 유사 IP 계정 </span>&nbsp;<em class='badge rounded-pill align-middle da-member-memo__memo da-memo-color--red'> " + same_ip_ids.join(" </em>&nbsp;<em class='badge rounded-pill align-middle da-member-memo__memo da-memo-color--red'> ") + " </em>";
              temp_info.lastElementChild.after(s);
            }
          });
        }
      };
    });
  }

  function remove_timeover_memo(db, complete) {
    var idStore = getDBObjectStore(db, memoID, "readwrite");
    var idAccessIndex = idStore.index("by_access");
    var limit_time = Date.now() - 30 * 24 * 60 * 60 * 1000; // 기간 최소 1달
    var access_req = idAccessIndex.openCursor(IDBKeyRange.upperBound(limit_time));
    var old_ips = {};
    access_req.onsuccess = function (e) {
      var cursor = e.target.result;
      if (cursor) {
        var temp_val = cursor.value;
        var changed = false;
        var check_access = null;
        Object.keys(temp_val.ip).forEach((ip) => {
          if (temp_val.ip[ip].access < limit_time) {
            if (old_ips[ip] == null) {
              old_ips[ip] = [];
            }
            old_ips[ip].push(cursor.primaryKey);
            delete temp_val.ip[ip];
            changed = true;
          } else {
            if (check_access == null || check_access > temp_val.ip[ip].access) {
              check_access = temp_val.ip[ip].access;
            }
          }
        });

        if (Object.keys(temp_val.ip).length > 0) {
          if (changed) {
            if (check_access != null) {
              temp_val.access = check_access;
            }
            idStore.put(temp_val);
          }
        } else {
          idStore.delete(cursor.primaryKey);
        }
        cursor.continue();
      } else {
        var ipStore = getDBObjectStore(db, memoIP, "readwrite", complete);
        Object.keys(old_ips).forEach((temp_ip) => {
          var ip_req = ipStore.get(temp_ip);
          ip_req.onsuccess = function (e) {
            var memo_ip = e.target.result;
            var ip_ids = old_ips[temp_ip];
            ip_ids.forEach((temp_id) => {
              if (memo_ip.id[temp_id] != null) {
                delete memo_ip.id[temp_id];
              }
            });
            memo_ip.id_cnt = Object.keys(memo_ip.id).length;
            if (memo_ip.id_cnt === 0) {
              ipStore.delete(memo_ip.ip);
            } else {
              ipStore.put(memo_ip);
            }
          }

        });
      }
    };
  }

  function getDBObjectStore(db, store_name, mode, complete) {
    var tx = db.transaction(store_name, mode);
    if (complete != null) {
      tx.oncomplete = complete;
    }
    return tx.objectStore(store_name);
  }

  //memo 추적 관련 기능 끝

  //글 방문 기록 기능 시작
  var read_db_version = 1;
  var readDBName = "readHT_";
  var readWrite = "write";
  //var readNoti = "noti";
  var readReplyCntClass = "ui-custom-read-reply-cnt";
  function read_db_upgrade(event) {
    var db = event.target.result;
    var key_str = "url";
    // 일반글용 스토어
    //{url:"",board:"",wr_id:0,noti:false,access:"",reply:0}
    var writeStore = db.createObjectStore(readWrite, { keyPath: key_str });
    // 일반글용 인덱스
    var writeIndex = writeStore.createIndex("by_" + key_str, key_str);
    var writeAccessIndex = writeStore.createIndex("by_access", "access", { unique: false });
    //var writeBoardIndex = writeStore.createIndex("by_board", "board",{ unique: false });
    var writeNotiIndex = writeStore.createIndex("by_noti", "noti", { unique: false });
  }

  //사용자 ID에 따른 방문 기록 DB체크 및 타 ID DB 삭제
  function check_read_user_id(user_id, afterFn, checkedFn, notCheckedFn) {
    if (window.indexedDB) {
      window.indexedDB.databases().then(function (databases) {
        if (user_id != null && user_id != "") {
          var checked = false;
          if (databases.length > 0) {
            databases.forEach((database) => {
              if (database.name.indexOf(readDBName) == 0) {
                if (database.name == (readDBName + user_id)) {
                  checked = true
                } else {
                  window.indexedDB.deleteDatabase(database.name);
                }
              }
            })
          } else {
            //checked = true
          }
          if (checked) {
            if (checkedFn != null && (typeof checkedFn == 'function')) {
              checkedFn();
            }
          } else {
            if (notCheckedFn != null && (typeof notCheckedFn == 'function')) {
              notCheckedFn();
            }
          }
          if (afterFn != null && (typeof afterFn == 'function')) {
            afterFn();
          }
        }
      });
    }
  }

  function delete_read_database() {
    if (window.indexedDB) {
      var temp_obj = get_board_mb_id();
      if (temp_obj != null && temp_obj.id) {
        try {
          if (confirm("방문 기록을 삭제하시겠습니까?")) {
            window.indexedDB.databases().then(function (databases) {
              if (temp_obj.id != null && temp_obj.id != "") {
                if (databases.length > 0) {
                  databases.forEach((database) => {
                    if (database.name.indexOf(readDBName) == 0) {
                      if (database.name == (readDBName + temp_obj.id)) {
                        window.indexedDB.deleteDatabase(database.name);
                      }
                    }
                  });
                }
              }
            });
          }
        } catch (e) {
          console.debug(e);
        }
      }
    }
  }
  function check_read_history(ui_obj) {
    var removes = document.querySelectorAll("span." + readReplyCntClass);
    if (removes != null && removes.length > 0) {
      for (var i = 0; i < removes.length; i++) {
        removes[i].remove();
      }
    }

    if (window.indexedDB) {
      var board_info = get_board_mb_id();
      if (board_info != null && board_info.id != null) {
        check_read_user_id(board_info.id);
        if (ui_obj?.read_history ?? false) {
          if (board_info.board != null) {
            board_info.now_stamp = Date.now();
            board_info.noti_list = document.querySelectorAll("section#bo_list > ul > li.da-link-block.bg-light-subtle a.da-link-block");
            board_info.write_list = document.querySelectorAll("section#bo_list > ul > li.da-link-block a.da-link-block");

            board_info.noti_ids = [];
            board_info.write_ids = [];
            Array.from(board_info.noti_list).forEach((item) => {
              var temp_str = item.href;
              temp_str = temp_str.substring(temp_str.indexOf(board_info.board));
              if (temp_str.indexOf("?") > 0) {
                temp_str = temp_str.substring(0, temp_str.indexOf("?"));
              }
              board_info.noti_ids.push(temp_str);
            });
            Array.from(board_info.write_list).forEach((item) => {
              var temp_str = item.href;
              temp_str = temp_str.substring(temp_str.indexOf(board_info.board));
              if (temp_str.indexOf("?") > 0) {
                temp_str = temp_str.substring(0, temp_str.indexOf("?"));
              }
              board_info.write_ids.push(temp_str);
            });

            var read_db_request = indexedDB.open(readDBName + board_info.id, read_db_version);
            read_db_request.onupgradeneeded = read_db_upgrade;
            read_db_request.onsuccess = function (event) {
              var db = event.target.result;
              //게시글 정보 업데이트
              update_read_history(db, board_info, function () {
                update_read_history_noti(db, board_info, ui_obj);
                set_read_history(db, board_info, ui_obj);
              });
            };
          }
        }
      }
    }
  }

  function update_read_history(db, board_info, complete) {
    var writeStore = getDBObjectStore(db, readWrite, "readwrite", complete);
    if (board_info.wr_id != null) {
      var reply_cnt = document.querySelector("#bo_v_info div.pe-2:has(i.bi-chat-dots)")?.innerText ?? "0\n댓글";
      if (reply_cnt.indexOf("댓글") > 0) {
        reply_cnt = Number(reply_cnt.replace("댓글", "").trim(), 0);
        var temp_url = board_info.board + "/" + board_info.wr_id;
        var temp_req = writeStore.get(temp_url);
        temp_req.onsuccess = function (e) {
          var result = e.target.result;
          if (result == null) {
            var temp_result = { url: temp_url, board: board_info.board, wr_id: board_info.wr_id, noti: 0, access: board_info.now_stamp, reply: reply_cnt }
            writeStore.add(temp_result);
          } else {
            result.access = board_info.now_stamp;
            result.reply = reply_cnt;
            writeStore.put(result);
          }
        }
      }
    }

    var urlAccessIndex = writeStore.index("by_access");
    var limit_time = board_info.now_stamp - 30 * 24 * 60 * 60 * 1000; // 기간 최소 1달
    var access_req = urlAccessIndex.openCursor(IDBKeyRange.upperBound(limit_time));
    access_req.onsuccess = function (e) {
      var cursor = e.target.result;
      if (cursor) {
        var temp_val = cursor.value;
        if (board_info.wr_id != null && temp_val.url != board_info.board + "/" + board_info.wr_id && temp_val.noti == 0) {
          writeStore.delete(cursor.primaryKey);
        }
        cursor.continue();
      }
    }
  }

  function update_read_history_noti(db, board_info, ui_obj, complete) {
    var run_complete = false;
    var list_animation = false;
    if (board_info.noti_ids.length > 0) {
      var writeStore = getDBObjectStore(db, readWrite, "readwrite", complete);
      var notiIndex = writeStore.index("by_noti");
      var noti_true_req = notiIndex.openCursor(IDBKeyRange.only(1));
      noti_true_req.onsuccess = function (e) {
        var cursor = e.target.result;
        if (cursor) {
          var temp_val = cursor.value;
          if (temp_val.board == board_info.board) {
            var ids = []
            if (!board_info.noti_ids.includes(temp_val.url)) {
              temp_val.noti = 0;
              writeStore.put(temp_val);
            }
          }
          cursor.continue();
        }
      };
      var diplay_cnt = 0;
      board_info.noti_ids.forEach((url, index) => {
        var noti_update_req = writeStore.get(url);
        noti_update_req.onsuccess = function (e) {
          var result = e.target.result;
          var display_important = false;
          if (result != null) {
            if (result.noti == 0) {
              result.noti = 1;
              writeStore.put(result);
            }
            if (ui_obj.read_history_noti_reply ?? false) {
              var a_link = board_info.noti_list[index];
              var parent_node = a_link.parentNode;
              var cnt = parent_node.querySelector("span.count-plus");
              if (cnt != null) {
                cnt = Number(cnt.innerText.trim());
              } else {
                cnt = 0;
              }
              var diff = cnt - result.reply;
              if (diff > 0) {
                display_important = true;
              }
            }
          } else {
            if (ui_obj.read_history_noti ?? false) {
              display_important = true;
            }
          }
          
          if (display_important) {
            var noti_item = board_info.noti_list[index].closest("li.bg-light-subtle");
            if (list_animation) {
              noti_item.style = "display : block !important;opacity:0.3;/*transform: rotateX(-30deg) translateY(-" + ((diplay_cnt+1)*5) + "0%);*/ filter:blur(0.5em);";
              setTimeout(function(noti_item, cnt){
                noti_item.style = "display : block !important;opacity:1; transition:all " + ((cnt+1)*0.1) + "s ease-in " + ((cnt+1)*0.05) + "s";
                noti_item.addEventListener('transitionend', transitionEndRemove);
              },100, noti_item, diplay_cnt);  
            } else {
              noti_item.style = "display : block !important;"
            }
            diplay_cnt++;
          }
        }
      });

    }
    if (!run_complete && complete != null && typeof complete == 'function') {
      complete();
    }
  }

  function set_read_history(db, board_info, ui_obj) {
    if (board_info.write_ids.length > 0) {
      var writeStore = getDBObjectStore(db, readWrite, "readonly");
      board_info.write_ids.forEach((url, index) => {
        if (url != board_info.board + "/" + board_info.wr_id) {
          var noti_update_req = writeStore.get(url);
          noti_update_req.onsuccess = function (e) {
            var result = e.target.result;
            if (result != null) {
              var a_link = board_info.write_list[index];
              var parent_node = a_link.parentNode;
              if (ui_obj.read_history_em != null) {
                switch (ui_obj.read_history_em) {
                  case "background":
                    var li_parent = parent_node.closest(".da-link-block");
                    li_parent.classList.add("bg-primary");
                    li_parent.classList.add("bg-opacity-10");
                    li_parent.classList.add("rounded-pill");
                    break;
                  case "bold":
                    a_link.classList.add("fw-bold");
                    break;
                  case "italic":
                    a_link.classList.add("fst-italic");
                    break;
                  case "underline":
                    a_link.classList.add("text-decoration-underline");
                    break;
                  case "linethrough":
                    a_link.classList.add("text-decoration-line-through");
                    break;
                  case "blur":
                    parent_node.style.filter = "blur(0.2em)";
                    break;
                  default: break;
                }
              }
              if (ui_obj.read_history_reply_cnt ?? false) {
                var cnt_node = parent_node.querySelector("span.count-plus");
                var cnt = 0;
                if (cnt_node != null) {
                  cnt = Number(cnt_node.innerText.trim());
                }
                var diff = cnt - result.reply;
                if (diff > 0) {
                  var float_end = parent_node.querySelector("span.float-end");
                  var diff_span = document.createElement("span");
                  diff_span.className = "count-plus ui-custom-read-reply-cnt text-primary ml-0"
                  diff_span.innerHTML = diff;
                  parent_node.insertBefore(diff_span, float_end);
                  
                  if (ui_custom_animation) {
                    cnt_node.style= "opacity:0.5;transform: translateX(40%);";
                    diff_span.style= "opacity:0;transform: translateX(-100%);";
                    cnt_node.addEventListener('transitionend', transitionEndClear);
                    diff_span.addEventListener('transitionend', transitionEndClear);
                    setTimeout(function(){
                      diff_span.style= "opacity:0.8;transition:all 1s;";
                      cnt_node.style = "opacity:1;transition:all 1s;";
                    },500);  
                  }
                  //diff_span.style.style
                }
              }
            }
          }
        }
      });
    }
  }
  function transitionEndClear(){
    this.style = "";
    this.removeEventListener('transitionend', transitionEndClear);
  }
  function transitionEndRemove(){
    this.style.removeProperty('transition');
    this.removeEventListener('transitionend', transitionEndRemove);
  }

  //글 방문 기록 기능 끝

  //화면 그리기
  function draw_ui_custom(reload) {
    var ui_custom_storage_str = localStorage.getItem("ui_custom");
    if (ui_custom_storage_str != null && ui_custom_storage_str != "") {
      var ui_obj = JSON.parse(ui_custom_storage_str);
      if (ui_obj) {
        hide_nick(ui_obj, reload);
      }
    }
  }


  function set_ui_custom_click_event() {
    try {
      //탭 클릭 이벤트 설정 시작
      Array.from(document.querySelectorAll("#user-ui-custom .ui-custom-tabs .ui-custom-tab a.nav-link")).forEach((click_item) => {
        click_item.addEventListener("click", function (e) {
          e.preventDefault();
          Array.from(document.querySelectorAll("#user-ui-custom .ui-custom-tabs .ui-custom-tab a.nav-link.active")).forEach((item) => {
            if (click_item != item) {
              document.querySelector(item.getAttribute('href')).classList.add("d-none");
              item.classList.remove("active");
            }
          });
          click_item.classList.add("active");
          document.querySelector(click_item.getAttribute('href')).classList.remove("d-none");
        });
      });

      Array.from(document.querySelectorAll("#user-ui-custom .ui-custom-ul-tabs .ui-custom-ul-tab a.nav-link")).forEach((click_item) => {
        click_item.addEventListener("click", function (e) {
          e.preventDefault();
          Array.from(document.querySelectorAll("#user-ui-custom .ui-custom-ul-tabs .ui-custom-ul-tab a.nav-link.active")).forEach((item) => {
            if (click_item != item) {
              document.querySelector(item.getAttribute('href')).classList.add("d-none");
              item.classList.remove("active");
            }
          });
          click_item.classList.add("active");
          document.querySelector(click_item.getAttribute('href')).classList.remove("d-none");
        });
      });
      //탭 클릭 이벤트 설정 끝
      
      //reg_expand_shortcut
      $("#reg_expand_shortcut").change(function () {
        set_ui_custom_expand();
      });

      $("#reg_expand_quick").change(function () {
        set_ui_custom_expand();
      });

      $("#reg_read_history").change(function () {
        set_ui_custom_read_history();
      });

      $("#reg_ui_custom").change(function () {
        if ($("#reg_ui_custom").is(":checked")) {
          $(".ui-custom-item").show();
          set_ui_custom_expand();
          set_ui_custom_read_history();
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
      $("#reg_content_blur").change(function () {
        if ($("#reg_content_blur").is(":checked")) {
          $(".ui-custom-content-blur").show();
        } else {
          $(".ui-custom-content-blur").hide();
        }
      });
      $("#reg_shortcut_use").change(function () {
        if ($("#reg_shortcut_use").is(":checked")) {
          $(".ui-custom-shortcut").show();
        } else {
          $(".ui-custom-shortcut").hide();
        }
        set_ui_custom_expand_shortcut();
      });
      $(".ui_custom_shortcut_items").change(function () {
        //console.debug(this)
        set_ui_custom_expand_shortcut();
      });
    } catch (error) {
      //console.error('Failed to initialize custom UI settings:', error);
    }
  }

  function set_ui_custom_expand_shortcut() {
    if ($("#reg_expand_quick").is(":checked") && $("#reg_shortcut_use").is(":checked") ) {
      $("#reg_expand_shortcut_li").show();
      if ($("#reg_expand_shortcut").is(":checked")) {
        $(".ui-custom-expand-shortcut").show();
        var link_map = get_board_link_map();
        Array.from(document.querySelectorAll(".ui-custom-expand-shortcut")).forEach((item)=>{
          var temp_input = item.querySelector("input");
          var temp_id = temp_input.id.replace("expand_","");
          var check_input = document.getElementById(temp_id);
          if ((check_input?.value ?? "") != "") {
            var temp_label = item.querySelector("label.col-form-label");
            temp_label.innerHTML = temp_id.substring(temp_id.length-1) +  " : " + link_map[check_input.value].name;
            $(item).show();
          } else {
            $(item).hide();
          }
        });
      } else {
        $(".ui-custom-expand-shortcut").hide();
      }
    } else {
      $("#reg_expand_shortcut_li").hide();
      $(".ui-custom-expand-shortcut").hide();
    }
  }

  function set_ui_custom_expand() {
    if ($("#reg_expand_quick").is(":checked")) {
      $(".ui-custom-expand-item").show();
    } else {
      $(".ui-custom-expand-item").hide();
    }
    set_ui_custom_expand_shortcut();
  }
  function set_ui_custom_read_history() {
    if ($("#reg_read_history").is(":checked")) {
      $(".ui-custom-read-history").show();
    } else {
      $(".ui-custom-read-history").hide();
    }
  }
  function set_ui_custom_trigger() {
    try {
      //$("#reg_expand_quick").trigger('change');
      $("#reg_ui_custom").trigger('change');

      $("#reg_title_filtering").trigger('change');
      $("#reg_content_blur").trigger('change');
      $("#reg_shortcut_use").trigger('change');

    } catch (error) {
      //console.error('Failed to initialize custom UI settings:', error);
    }
  }

  function set_ui_custom_onload() {
    draw_ui_custom();

    //개인설정 그리기
    set_board_link_option_html();
    check_indexDB();
    set_ui_custom_click_event();

    var btn_ui_apply = document.getElementById("btn_ui_apply");
    if (btn_ui_apply) {
      btn_ui_apply.addEventListener("click", ui_custom_apply);
    }

    var btn_ui_value_view = document.getElementById("btn_ui_value_view");
    if (btn_ui_value_view) {
      btn_ui_value_view.addEventListener("click", ui_custom_value_view);
    }
    var btn_ui_value_cancle = document.getElementById("btn_ui_value_cancle");
    if (btn_ui_value_cancle) {
      btn_ui_value_cancle.addEventListener("click", ui_custom_value_cancle);
    }
    var btn_ui_value_save = document.getElementById("btn_ui_value_save");
    if (btn_ui_value_save) {
      btn_ui_value_save.addEventListener("click", ui_custom_value_save);
    }
    var btn_ui_value_copy = document.getElementById("btn_ui_value_copy");
    if (btn_ui_value_copy) {
      btn_ui_value_copy.addEventListener("click", ui_custom_value_copy);
    }
    var btn_ui_value_paste = document.getElementById("btn_ui_value_paste");
    if (btn_ui_value_paste) {
      btn_ui_value_paste.addEventListener("click", ui_custom_value_paste);
    }
    var btn_ui_value_clear = document.getElementById("btn_ui_value_clear");
    if (btn_ui_value_clear) {
      btn_ui_value_clear.addEventListener("click", ui_custom_value_clear);
    }
    var btn_ui_value_reload = document.getElementById("btn_ui_value_reload");
    if (btn_ui_value_reload) {
      btn_ui_value_reload.addEventListener("click", ui_custom_value_reload);
    }

    var btn_memo_toggle = document.getElementById("btn_memo_toggle");
    if (btn_memo_toggle) {
      btn_memo_toggle.addEventListener("click", toggle_hide_member_memo);
    }
    var btn_memo_ip_clear = document.getElementById("btn_memo_ip_clear");
    if (btn_memo_ip_clear) {
      btn_memo_ip_clear.addEventListener("click", delete_memo_database);
    }
    var btn_read_history_clear = document.getElementById("btn_read_history_clear");
    if (btn_read_history_clear) {
      btn_read_history_clear.addEventListener("click", delete_read_database);
    }
    set_ui_custom_values();
  }

  function set_page_show(event) {
    //console.debug(event.eventPhase);
    if (event.persisted || (window.performance && window.performance.navigation.type == 2)) {
      draw_ui_custom(true);
    }
  }
  function set_page_hide(event) {
    //console.debug("hide_page");
    //set_expand_button_hide();  
    is_set_expand_button = false;
  }
  document.addEventListener("DOMContentLoaded", set_ui_custom_onload, { once: true });
  window.addEventListener("pageshow", set_page_show);
  window.addEventListener("pagehide", set_page_hide);
  try {
    set_ui_custom();
  } catch (error) {
    //console.error('Failed to initialize custom UI settings:', error);
  }
})();