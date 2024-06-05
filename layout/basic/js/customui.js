(() => {
  'use strict'
  var body_opacity_init = false;
  var ui_custom_animation = false;

  var ip_mark_regex = /^([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.(♡|[0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(\.(♡|[0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])){2}$/;

  var ui_custom_input = [
    "ui_custom"
    , "show_detail"
    , "show_width"
    , "font_family"
    , "font_size"
    , "line_height"
    , "menu_width"
    , "back_button"
    , "animation_off"
    , "thumbup_em_off"
    , "bbs_group_recommend_off"
    , "bbs_shortcut_recommend_off"

    , "rcmd_color_set"
    , "rcmd_color_step1"
    , "rcmd_color_step2"
    , "rcmd_color_step3"
    , "rcmd_color_step4"
    , "rcmd_color_step1_value"
    , "rcmd_color_step2_value"
    , "rcmd_color_step3_value"
    , "rcmd_color_step4_value"
    , "rcmd_font_color"
    , "rcmd_font_color_self"
    , "rcmd_font_color_1"
    , "rcmd_font_color_2"
    , "rcmd_font_color_3"
    , "rcmd_font_color_4"

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
    , "expand_gesture"
    , "expand_gesture_tap2"
    , "expand_gesture_tap3"
    , "expand_gesture_swipe"
    , "expand_gesture_swipe_minx"
    , "expand_gesture_swipe_maxy"
    , "expand_gesture_start_term"
    , "expand_gesture_click_term"

    , "menu_scroll"
    , "list_search"
    , "list_toggle"
    , "hide_nick"

    , "hide_member_memo"
    , "hide_list_memo"
    , "blur_contents_memo"
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
  var ui_custom_default = { show_width: 1200, font_size: 1, line_height: 1.5, menu_width: 25, expand_quick_size: 2.5 , expand_gesture_swipe_minx : 50, expand_gesture_swipe_maxy : 30, expand_gesture_start_term : 400, expand_gesture_click_term : 250};


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
          ui_custom_style += "#header-navbar.site-navbar {position: fixed !important;display: block !important;}\n";
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
          //ui_custom_style += "#bo_list li.list-group-item.da-link-block div.wr-num div.rcmd-box {margin-top: -0.5em;margin-bottom: -0.5em;height: 2em;width: 2.3em;vertical-align: middle;padding-top: 0.4em;border-radius: 45%;}\n";

          if (ui_custom_animation) {
            ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box.step1 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp10;}\n";
            ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box.step2 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp15;}\n";
            ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box.step3 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp20;}\n";
            ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box.step4 {animation-delay: 1s;animation-duration: 1s;animation-name: popUp25;}\n";

            ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block:hover .rcmd-box.step1 {animation-iteration-count: infinite;}\n";
            ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block:hover .rcmd-box.step2 {animation-iteration-count: infinite;}\n";
            ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block:hover .rcmd-box.step3 {animation-iteration-count: infinite;}\n";
            ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block:hover .rcmd-box.step4 {animation-iteration-count: infinite;}\n";
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
          ui_custom_style += "div#toTop a {font-size: " + (ui_obj.expand_quick_size ?? 2.5) + "em !important;}\n";
          
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
        if ((ui_obj.rcmd_font_color ?? "") != "") {
          var font_color = "";
          var rcmd_color_set = (ui_obj.rcmd_color_set ?? "");
          if (rcmd_color_set != "self" && rcmd_color_set != "") {
            rcmd_color_set = "-" + rcmd_color_set
          } else {
            rcmd_color_set = ""
          }
          switch (ui_obj.rcmd_font_color ?? "") {
            case "gray":
              font_color = "#dddddd";
              break;
            case "black":
              font_color = "#000000";
              break;
            case "white":
              font_color = "#ffffff";
              break;
            case "self":
              if ((ui_obj.rcmd_font_color_self ?? "") != "") font_color = ui_obj.rcmd_font_color_self;
              break;
            case "step":
              if ((ui_obj.rcmd_font_color_1 ?? "") != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box" + rcmd_color_set + ".step1 {color : " + ui_obj.rcmd_font_color_1 + " !important}\n";
              if ((ui_obj.rcmd_font_color_2 ?? "") != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box" + rcmd_color_set + ".step2 {color : " + ui_obj.rcmd_font_color_2 + " !important}\n";
              if ((ui_obj.rcmd_font_color_3 ?? "") != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box" + rcmd_color_set + ".step3 {color : " + ui_obj.rcmd_font_color_3 + " !important}\n";
              if ((ui_obj.rcmd_font_color_4 ?? "") != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box" + rcmd_color_set + ".step4 {color : " + ui_obj.rcmd_font_color_4 + " !important}\n";
              break;
          }
          if (font_color != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box" + rcmd_color_set + " {color : " + font_color + " !important}\n";
        }

        if ((ui_obj.rcmd_color_set ?? "") == "self") {
          var rcmd_color_step1 = ui_obj.rcmd_color_step1 ?? "";
          var rcmd_color_step2 = ui_obj.rcmd_color_step2 ?? "";
          var rcmd_color_step3 = ui_obj.rcmd_color_step3 ?? "";
          var rcmd_color_step4 = ui_obj.rcmd_color_step4 ?? "";

          if (rcmd_color_step1 != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box.step1 {background-color : " + rcmd_color_step1 + " !important;}\n";
          if (rcmd_color_step2 != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box.step2 {background-color : " + rcmd_color_step2 + " !important;}\n";
          if (rcmd_color_step3 != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box.step3 {background-color : " + rcmd_color_step3 + " !important;}\n";
          if (rcmd_color_step4 != "") ui_custom_style += "div.order-1 ul.list-group li.list-group-item.da-link-block .rcmd-box.step4 {background-color : " + rcmd_color_step4 + " !important;}\n";
        }
      }
      //hide_nick(ui_obj);
    }
    if (ui_custom_animation) {
      ui_custom_style += "#sidebar-site-menu .nav-item a.nav-link:hover i::before{animation-duration: 0.5s;animation-name: smallTwistRight;}\n";
      ui_custom_style += "#sidebar-site-menu .nav-item a.nav-link:hover span.badge{animation-duration: 0.5s;animation-name: smallTwistLeftMargin;}\n";
      ui_custom_style += "#menuOffcanvas .nav-item a.nav-link:hover i::before{animation-duration: 0.5s;animation-name: smallTwistRight;}\n";
      ui_custom_style += "#menuOffcanvas .nav-item a.nav-link:hover span.badge{animation-duration: 0.5s;animation-name: smallTwistLeftMargin;}\n";

      ui_custom_style += "div.order-1 ul.list-group li.da-link-block:hover {animation-duration: 0.5s;animation-name: popUp;}\n";
      ui_custom_style += "div.order-1 ul.list-group li.li.da-link-block.ui-custom-link-active {animation-duration: 1s;animation-name: linkPopSmall !important;animation-fill-mode: forwards}\n";
      ui_custom_style += "div.nav-item.ui-custom-link-active {animation-duration: 1s;animation-name: linkPop !important;animation-fill-mode: forwards}\n";

      ui_custom_style += "@keyframes popUp {0% {transform: translateX(0%) scale(1);}20% {transform: translateX(0.5%) scale(1.01);}100% {transform: translateX(0%) scale(1);}}\n";
      ui_custom_style += "@keyframes linkPopSmall {0% {transform: translateY(-0.5%%) scale(1.005);}20% {transform: translateY(-1.5%) scale(1.015);}100% {transform: translateY(0%) scale(1);}}\n";
      ui_custom_style += "@keyframes linkPop {0% {transform: translateY(-3%) scale(1.03);}20% {transform: translateY(-5%) scale(1.05);}100% {transform: translateY(0%) scale(1);}}\n";

      ui_custom_style += "@keyframes popUp05 {0% {transform: scale(1);}20% {transform: scale(1.05);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp10 {0% {transform: scale(1);}20% {transform: scale(1.1);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp15 {0% {transform: scale(1);}20% {transform: scale(1.15);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp20 {0% {transform: scale(1);}20% {transform: scale(1.2);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp25 {0% {transform: scale(1);}20% {transform: scale(1.25);}100% {transform: scale(1);}}\n";
      ui_custom_style += "@keyframes popUp30 {0% {transform: scale(1);}20% {transform: scale(1.3);}100% {transform: scale(1);}}\n";
      ui_custom_style += "button.bbs_shortcut_recommend:hover {animation-iteration-count: infinite;animation-duration: 2s;animation-name: popUpPin15;}\n";
      ui_custom_style += "@keyframes popUpPin15 {0% {transform: scale(1);}10% {transform: scale(1.15);}12% {transform: scale(1.145);}30% {transform: scale(1);}100% {transform: scale(1);}}\n";

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
      setTimeout(function () {
        set_body_op_end()
      }, 1500);
    }
  }
  function ui_custom_value_view() {
    if (document.getElementById('ui_custom_json') != null) {
      document.getElementById('ui_custom_json').value = get_ui_custom_input_string();
    }
    set_ui_custom_value_btn(false);
  }
  function ui_custom_value_cancle() {
    set_ui_custom_value_btn(true);
  }
  function ui_custom_value_clear() {
    if (document.getElementById('ui_custom_json') != null) {
      document.getElementById('ui_custom_json').value = "";
      set_ui_custom_values(true);
    }
  }
  function ui_custom_value_reload() {
    set_ui_custom_input_clear();
    set_ui_custom_values(false);
  }
  function ui_custom_value_save() {
    if (set_ui_custom_values(true)) {
      set_ui_custom_value_btn(true);
      setTimeout(function () {
        alert("값이 정상적으로 입력되었습니다.");
      });
    }
  }
  function ui_custom_value_paste() {
    if (document.getElementById('ui_custom_json') != null) {
      try {
        navigator.clipboard.readText().then((clipText) => {
          document.getElementById('ui_custom_json').value = clipText;
          ui_custom_value_save();
        });
      } catch (e1) {
        try {
          document.getElementById('ui_custom_json').select();
          document.execCommand("paste");
          ui_custom_value_save();
        } catch (e2) {
          alert("클립보드의 내용을 가져올 수 없습니다.");
        }
      }
    }
  }

  function ui_custom_value_copy() {
    if (document.getElementById('ui_custom_json') != null) {
      try {
        navigator.clipboard.writeText(document.getElementById('ui_custom_json').value);
        alert("클립보드에 저장 되었습니다.");
      } catch (err) {
        try {
          document.getElementById('ui_custom_json').select();
          document.execCommand("copy");
          alert("클립보드에 저장 되었습니다.");
        } catch (e2) {
          alert("클립보드 권한을 확인해보세요.");
          return false;
        }
      }
    }
    return true;
  }

  function set_ui_custom_value_btn(default_mode) {
    var default_el = Array.from(document.querySelectorAll("#user-ui-custom .ui-custom-btn-default"));
    var view_el = Array.from(document.querySelectorAll("#user-ui-custom .ui-custom-btn-view"));
    if (default_mode) {
      default_el.forEach((item) => {
        item.classList.remove("d-none");
        item.classList.add("d-inline-block");
      });
      view_el.forEach((item) => {
        item.classList.remove("d-inline-block");
        item.classList.add("d-none");
      });
    } else {
      default_el.forEach((item) => {
        item.classList.add("d-none");
        item.classList.remove("d-inline-block");
      });
      view_el.forEach((item) => {
        item.classList.add("d-inline-block");
        item.classList.remove("d-none");
      });
    }
  }
  
  function set_ui_custom_input_clear() {
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
  function get_ui_custom_input_string() {

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
      try {
        json_str = JSON.stringify(ui_custom_json);
      } catch (e) {
      }
    }
    return json_str;
  }

  function ui_custom_apply() {
    var item_key = "ui_custom";
    var json_str = get_ui_custom_input_string();
    if (json_str != "") {
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
    try {
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
    } catch (e) {
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
    if (reload == null) {
      reload = false;
    }

    //추천 컬러 변경
    set_thumbup_em(ui_obj, reload);
    set_bbs_group_recommend(ui_obj, reload);

    if (ui_obj != null) {
      //본문 필터링
      if ((ui_obj.content_blur ?? false) || ((ui_obj?.ui_custom ?? false) && (ui_obj?.blur_contents_memo ?? "") != "")) {
        check_content_blur(ui_obj?.content_blur_word, (ui_obj?.blur_contents_memo ?? ""));
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

        set_touch_gesture(ui_obj);

        if (ui_custom_animation) {
          set_links_active_pop()
        }
        if (ui_obj.memo_ip_track ?? false) {
          start_memo_tracking();
        }
      }
    }
    set_body_op_end();
  }

  //함수 모음 시작
  function set_thumbup_em(ui_obj, reload) {
    if (ui_obj == null) ui_obj = {};

    var cv_1 = Number(ui_obj.rcmd_color_step1_value ?? 0);
    var cv_2 = Number(ui_obj.rcmd_color_step2_value ?? 6);
    var cv_3 = Number(ui_obj.rcmd_color_step3_value ?? 11);
    var cv_4 = Number(ui_obj.rcmd_color_step4_value ?? 51);
    var change_step_value = ((ui_obj.rcmd_color_step1_value !=null)) || (ui_obj.rcmd_color_step2_value != null) || (ui_obj.rcmd_color_step3_valu != null) || (ui_obj.rcmd_color_step4_value != null);
    if (change_step_value) {
      if (cv_2 < cv_1) cv2 = cv_1;
      if (cv_3 < cv_2) cv3 = cv_2;
      if (cv_4 < cv_3) cv4 = cv_3;
      console.debug(cv_1,cv_2,cv_3,cv_4);
    }
    var rv_1 = 500, rv_2 = 1000, rv_3 = 5000;
    //var option_class = ["bg-danger","bg-success","bg-primary","bg-info","bg-secondary","bg-opacity-25","bg-opacity-10","bg-gradient","fw-bold","cu_rv_1","cu_rv_2","cu_rv_3"];
    var option_class = ["cu_rv_1", "cu_rv_2", "cu_rv_3", "cu_rv_4", "cu_rv_5"];
    var custom_class = ["gray", "forest", "yellow", "colorful", "none", "self"];
    var step_class = ["step0","step1", "step2", "step3", "step4"];
    var color_set = ui_obj.rcmd_color_set ?? "";
    if (color_set != "") {
      color_set = "rcmd-box-" + color_set;
    }

    var custom_set = null;

    Array.from(document.querySelectorAll("div.order-1 ul.list-group li.list-group-item.da-link-block:has(.rcmd-box)")).forEach((item) => {
      var thumb_up = item.querySelector(".rcmd-box");
      var thumb_up_m = item.querySelectorAll(".rcmd-mb .rcmd-box");
      var thumb_up_m_batch = {
        add: (el) => {
          thumb_up_m.forEach((e) => {
            e.classList.add(el);
          });
        },
        remove: (el) => {
          thumb_up_m.forEach((e) => {
            e.classList.remove(el);
          });
        }
      };

      if (thumb_up != null) {
        if (reload) {
          option_class.forEach((tc) => {
            thumb_up.classList.remove(tc);
            if (thumb_up_m != null) thumb_up_m_batch.remove(tc);
          });
          if (custom_set == null) {
            custom_class.some((tc) => {
              if (thumb_up.classList.contains("rcmd-box-" + tc)) {
                custom_set = "rcmd-box-" + tc;
                return true;
              } else {
                return false;
              }
            });
          } else {
            if (thumb_up_m != null) thumb_up_m_batch.add(custom_set);
          }
        } else {
          step_class.some((tc) => {
            if (thumb_up.classList.contains(tc)) {
              if (thumb_up_m != null) thumb_up_m_batch.add(tc);
              return true;
            } else {
              return false;
            }
          });
        }

        var temp_num = thumb_up;
        if (temp_num == null) {
          temp_num = 0;
        } else {
          temp_num = Number(temp_num.innerText.split("\n")[0]);
        }
        var add_class_list = "";

        if (change_step_value) {
          step_class.forEach((tc) => {
            thumb_up.classList.remove(tc);
            if (thumb_up_m != null) thumb_up_m_batch.remove(tc);
          });

          if (temp_num >= cv_4) {
            add_class_list = "step4 cu_rv_4";
          } else if (temp_num >= cv_3) {
            add_class_list = "step3 cu_rv_3";
          } else if (temp_num >= cv_2) {
            add_class_list = "step2 cu_rv_2";
          } else if (temp_num >= cv_1) {
            add_class_list = "step1 cu_rv_1";
          } else {
            add_class_list = "step0";
          }

        }
        if (add_class_list != "") {
          add_class_list.split(" ").forEach((cl) => {
            thumb_up.classList.add(cl);
            if (thumb_up_m != null) thumb_up_m_batch.add(cl);
          });
        }
        if (color_set != "") {
          thumb_up.classList.add(color_set);
          if (thumb_up_m != null) thumb_up_m_batch.add(color_set);
        } else {
          if (thumb_up_m != null) thumb_up_m_batch.add("rcmd-box");
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
      after_img.style = "vertical-align: middle;max-width: 1.3em;max-height: 1.3em;margin-top: -0.3em;";
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

      } else {
        var remove_transition = function (e) {
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

        setTimeout(function () {
          body_con.style.setProperty('transition', 'all 0.7s');
          body_con.addEventListener('transitionend', remove_transition);
          body_con.style.removeProperty('filter');
          body_con.style.removeProperty('opacity');
          body_con.style.removeProperty('max-height');
          body_con.style.removeProperty('overflow');
        }, 200);
        body_con.removeEventListener("click", remove_blur);

        if (blur_txt != null) {
          blur_txt.style.setProperty('opacity', '0.5');
          var remove_blur_txt_transition = function (e) {
            blur_txt.remove();
            document.getElementById(body_parent_id).style.removeProperty("position");
          };
          blur_txt.addEventListener('transitionend', remove_blur_txt_transition);
          setTimeout(function () {
            blur_txt.style.setProperty('transition', 'all 1s');
            blur_txt.style.setProperty('opacity', '0');
          }, 100);
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

  function check_content_blur(word_list, blur_contents_memo) {
    if (document.getElementById(body_con_id) != null) {
      var content_blur = false;

      if (blur_contents_memo != "" && !content_blur) {
        var em = document.querySelector("#bo_v_info em.da-member-memo__memo");
        if (em != null) {
          if (blur_contents_memo == "all" || em.classList.contains("da-memo-color--" + blur_contents_memo)) {
            content_blur = true;
          }
        }
      }

      word_list = (word_list ?? "").trim()
      if (word_list != "" && !content_blur) {
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
            content_blur = re.test(title_text);
          }
        }
      }

      if (content_blur) {
        set_content_blur();
      } else {
        if (ui_custom_animation) {
          var body_con = document.getElementById(body_con_id);
          body_con.style.filter = "blur(0.2em)";
          body_con.style.opacity = "0.1";
          var remove_transition = function () {
            this.removeEventListener('transitionend', remove_transition);
            body_con.style.removeProperty('transition');
            body_con.style.removeProperty('filter');
            body_con.style.removeProperty('opacity');
          }
          setTimeout(function () {
            body_con.style.setProperty('transition', 'all 0.4s');
            body_con.style.filter = "blur(0em)";
            body_con.style.opacity = "1";
            body_con.addEventListener('transitionend', remove_transition);
          }, 100);
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
      setTimeout(function () {
        body_con.style.setProperty('transition', 'all 1s');
        body_con.style.filter = "blur(9em)";
        body_con.style.opacity = "0.3";
      }, 300);

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

        if (ui_obj.shortcut_use && ui_obj.expand_shortcut) {
          for (var i = 1; i < 11; i++) {
            var check_i = (i < 10 ? i : i - 10) + "";
            if ((ui_obj["expand_shortcut_" + check_i] ?? false) && shortcut_map[check_i]?.href != null) {
              var tag_a = document.createElement("a");
              tag_a.href = shortcut_map[check_i].href;
              tag_a.className = tag_a_className;
              tag_a.id = tag_a_id_prev + shortcut_map[check_i].code;
              tag_a.title = shortcut_map[check_i].name;
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
          setTimeout(function (temp, is_final, b_show) {
            if (b_show) {
              temp.classList.remove("d-none");
              temp.classList.add("d-block");
            } else {
              temp.classList.remove("d-block");
              //show_list[i].classList.remove("d-none-start");
              temp.classList.add("d-none");
            }
            if (is_final) {
              setTimeout(function () {
                is_set_expand_button_ing = false;
              }, 700);
            }
          }, (check_i) * 30 + 10, temp_show, is_final, b_show);
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
    var links = $("#sidebar-site-menu div.nav-item > a").not("a.shortcut_custom").not("a.bbs_group_recommend");
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

  function set_links_active_pop() {
    var sidebar_site_menu_links = document.querySelectorAll('#sidebar-site-menu div.nav-item:has(a.nav-link)');
    var off_menu_links = document.querySelectorAll('#menuOffcanvas div.nav-item:has(a.nav-link)');
    var list_menu_links = document.querySelectorAll("section#bo_list > ul > li.da-link-block:has(a.da-link-block)");
    Array.from(sidebar_site_menu_links).forEach(set_item_active_pop);
    Array.from(off_menu_links).forEach(set_item_active_pop);
    Array.from(list_menu_links).forEach(set_item_active_pop);
  }
  function set_item_active_pop(item, index) {
    item.classList.remove("ui-custom-link-active");
    var a_tag = item.querySelector('a.da-link-block, a.nav-link')
    if (a_tag != null) {
      a_tag.addEventListener("click", item_active_pop_event);
    } else {
    }
  }
  function item_active_pop_event(e) {
    var active_top = this.closest("div.nav-item , li.da-link-block");
    if (active_top != null) {
      active_top.classList.add("ui-custom-link-active");
    }
  }

  function set_shortcut_custom(ui_obj) {
    shortcut_map = {}

    if (ui_obj.hide_member_memo != null && ui_obj.hide_member_memo) {
      shortcut_map["U"] = { href: "javascript:toggle_hide_member_memo();", name: "메모", code: "memo" };
    }

    if (ui_obj?.list_toggle ?? false) {
      shortcut_map["D"] = { href: "javascript:list_toggle();", name: "목록토글", code: "list_toggle" };
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
          shortcut_link.innerHTML = '<span class="d-flex align-items-center gap-2 nav-link-title"><span class="badge p-1 text-bg-secondary">·</span>' + temp_text[i] + "</span>";//<i class="' + temp_icon[i] + ' nav-icon"></i>
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
          shortcut_link.innerHTML = '<span class="d-flex align-items-center gap-2 nav-link-title"></i> <span class="badge p-1 text-bg-secondary">' + shortcut_i + '</span>' + link_map[shortcut].name + "</span>";//<i class="bi-list-stars nav-icon">
          shortcut_div.appendChild(shortcut_link);
          sidebar_site_menu.insertBefore(shortcut_div, sidebar_site_menu_first);
          offcanvas_menu.insertBefore(shortcut_div.cloneNode(true), offcanvas_menu_first);
          shortcut_map[shortcut_i + ""] = { href: shortcut_link.href, name: link_map[shortcut].name, code: link_map[shortcut].link };
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

  function handleClearSettingKeyPress(event) {
    if (isShortCutInputElement(event.target) || isShortCutContentEditableElement(event.target)) {
      return;
    }
    var key = (event?.code ?? "").replace(/Key|Digit|Numpad/, "");

    if (event.shiftKey && event.altKey) {
      switch (key) {
        case "U":
          if (confirm("개인화면 설정값을 모두 삭제 하시 겠습니까? 설정값은 클립보드에 복사 됩니다.")) {
            if (document.getElementById('ui_custom_json') != null) {
              document.getElementById('ui_custom_json').value = localStorage.getItem("ui_custom") ?? "";
              ui_custom_value_copy();
            }
            localStorage.removeItem("ui_custom");
            alert("개인화면 설정값이 삭제되었습니다.");
            set_ui_custom();
            draw_ui_custom();
            ui_custom_value_clear();
          }
          break;
        default:
          break;
      }
      return;
    } else {
      return;
    }
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
          Array.from(document.querySelectorAll(".ui-custom-ip-memo-default")).forEach((item) => { item.classList.remove('d-none') });
        }
      } else {
        if (memo_check != null && memo_check.checked) {
          memo_check.checked = false;
        }
        check_ui.classList.add("d-none");
        Array.from(document.querySelectorAll(".ui-custom-ip-memo-sub")).forEach((item) => { item.classList.add('d-none') });
      }
    }
  }

  //사용여부 변경에 따른 경고문구 표시
  function change_memo_tracking() {
    document.getElementById("load_ip_memo_list").checked = false;
    var memo_check = document.getElementById('reg_memo_ip_track');
    if (memo_check.checked) {
      var temp_obj = get_board_mb_id();
      check_memo_user_id(temp_obj?.id, null, null, function () {
        alert("빨간색 메모의 IP만 기록합니다.\n메모의 IP기록은 단순 참고만 하시기 바랍니다.");
      });
      Array.from(document.querySelectorAll(".ui-custom-ip-memo-default")).forEach((item) => { item.classList.remove('d-none') });
    } else {
      Array.from(document.querySelectorAll(".ui-custom-ip-memo-sub")).forEach((item) => { item.classList.add('d-none') });
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
          var desc = result.desc;
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

            if (same_ip_ids.length > 0 || desc != null) {
              var s = document.createElement('span');
              s.className = "ui-custom-check-multi-id da-member-memo";
              s.classList.add(checkMultiClass);
              var change_string;
              s.innerHTML = "<span class='badge rounded-pill align-middle da-member-memo__memo da-memo-color--yellow'> " + (desc ?? "유사 IP 계정") + " </span>" + (same_ip_ids.length == 0 ? "" : "&nbsp;<em class='badge rounded-pill align-middle da-member-memo__memo da-memo-color--red'> " + same_ip_ids.join(" </em>&nbsp;<em class='badge rounded-pill align-middle da-member-memo__memo da-memo-color--red'> ") + " </em>");
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
              noti_item.style = "display : block !important;opacity:0.3;/*transform: rotateX(-30deg) translateY(-" + ((diplay_cnt + 1) * 5) + "0%);*/ filter:blur(0.5em);";
              setTimeout(function (noti_item, cnt) {
                noti_item.style = "display : block !important;opacity:1; transition:all " + ((cnt + 1) * 0.1) + "s ease-in " + ((cnt + 1) * 0.05) + "s";
                noti_item.addEventListener('transitionend', transitionEndRemove);
              }, 100, noti_item, diplay_cnt);
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
                    cnt_node.style = "opacity:0.5;transform: translateX(40%);";
                    diff_span.style = "opacity:0;transform: translateX(-100%);";
                    cnt_node.addEventListener('transitionend', transitionEndClear);
                    diff_span.addEventListener('transitionend', transitionEndClear);
                    setTimeout(function () {
                      diff_span.style = "opacity:0.8;transition:all 1s;";
                      cnt_node.style = "opacity:1;transition:all 1s;";
                    }, 500);
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
  function transitionEndClear() {
    this.style = "";
    this.removeEventListener('transitionend', transitionEndClear);
  }
  function transitionEndRemove() {
    this.style.removeProperty('transition');
    this.removeEventListener('transitionend', transitionEndRemove);
  }

  //글 방문 기록 기능 끝

  //IP메모 기능 시작
  function set_ip_memo_edit_mode() {
    var edit_mode = true;
    //li 처리
    Array.from(document.querySelectorAll(".ui-custom-ip-memo-sub-editor")).forEach((item) => { item.classList.remove("d-block"); item.classList.add("d-none") });
    //버튼 처리
    Array.from(document.querySelectorAll(".ip_memo_edit_btns")).forEach((item) => { item.classList.add("d-none") });
    Array.from(document.querySelectorAll(".ip_memo_close_btns")).forEach((item) => { item.classList.remove("d-none") });

    var add_mode = document.getElementById("ip_memo_add_mode");
    var start_add_mode = add_mode.value;

    switch (this.id) {
      case "btn_ip_memo_add":
        var add_name = document.getElementById('ip_memo_add_name');
        var add_check = document.getElementById('btn_ip_memo_add_check');
        Array.from(document.querySelectorAll(".ui-custom-ip-memo-add")).forEach((item) => { item.classList.add("d-block"); item.classList.remove("d-none"); });
        add_name.disable = false;
        if (add_mode.value == "list") {
          add_mode.value = "list_add";
        } else if (add_mode.value == "list_add") {
        } else if (add_mode.value == "list_edit") {
          add_name.disable = true;
          window.getComputedStyle(add_name).backgroundColor
        } else {
          add_mode.value = "add";
        }
        if (add_name.disable) {
          add_check.style.backgroundColor = window.getComputedStyle(add_name).backgroundColor;
        } else {
          add_check.style.removeProperty('background-color');
        }
        break;
      case "btn_ip_memo_list":
        show_ip_memo_list();
        break;
      case "btn_ip_memo_edit":
        Array.from(document.querySelectorAll(".ui-custom-ip-memo-edit")).forEach((item) => { item.classList.add("d-block"); item.classList.remove("d-none"); });
        add_mode.value = "edit";
        get_ip_memo_list(add_mode.value);
        break;
      case "btn_ip_memo_close":
        //그냥 닫을때
        clear_ip_memo_editor();
        if (start_add_mode == "list_add" || start_add_mode == "list_edit") {
          show_ip_memo_list();
        } else {
          if (!document.getElementById("load_ip_memo_list").checked) {
            clear_ip_memo_list();
          }
          Array.from(document.querySelectorAll(".ip_memo_edit_btns")).forEach((item) => { item.classList.remove("d-none") });
          Array.from(document.querySelectorAll(".ip_memo_close_btns")).forEach((item) => { item.classList.add("d-none") });
        }
        break;
    }
  }
  function click_ip_memo_editor_btn() {
    var success = false;
    var add_mode = document.getElementById("ip_memo_add_mode");
    switch (this.id) {
      case "btn_ip_memo_add_save":
        var ip_name = (document.getElementById("ip_memo_add_name")?.value ?? "").trim();
        var ip_desc = (document.getElementById("ip_memo_add_desc")?.value ?? "").trim();
        if (ip_desc == "") {
          alert("메모 내용을 입력해 주세요.");
        } else {
          if (ip_mark_regex.test(ip_name)) {
            var ip_map = {};
            ip_map[ip_name] = { ip: ip_name, desc: ip_desc };
            edit_ip_memo_list(ip_map, function () {
              alert("저장되었습니다.");
              create_ip_memo_list(ip_name, ip_desc, true);
              document.getElementById("btn_ip_memo_close").click();
            });
            success = false;
          } else {
            alert("IP 주소를 확인해 주세요.");
          }
        }
        break;
      case "btn_ip_memo_list_edit":
        var li = this.closest("li.list-group-item");
        document.getElementById("ip_memo_add_mode").value = "list_edit";
        document.getElementById("ip_memo_add_name").value = li.querySelector("#ip_memo_list_name")?.innerText ?? "";
        document.getElementById("ip_memo_add_desc").value = li.querySelector("#ip_memo_list_desc")?.value ?? "";
        document.getElementById("btn_ip_memo_add").click();
        success = false;
        break;
      case "btn_ip_memo_list_delete":
        var li = this.closest("li.list-group-item");
        var ip = li.querySelector("#ip_memo_list_name").innerText.trim();
        if (ip_mark_regex.test(ip)) {
          var ip_map = {};
          ip_map[ip] = { ip: ip };
          edit_ip_memo_list(ip_map, function () {
            li.remove();
          });
        } else {
          alert(ip + " - 삭제할 수 없습니다.");
        }
        success = false;
        break;
      case "btn_ip_memo_edit_save":
        var editor = document.getElementById("ui_custom_ip_memo_editor").value.trim();
        if (editor != "") {
          var line_list = editor.split("\n");
          var ip_map = {};
          line_list.forEach((line) => {
            line = line.trim();
            var line_arr = line.split(",");
            var ip = line_arr[0];
            if (ip_mark_regex.test(ip)) {
              ip_map[ip] = { ip: ip }
              if (line_arr.length > 1) {
                var desc = line_arr.splice(1).join(",").trim();
                if (desc != "") {
                  ip_map[ip].desc = desc;
                }
              }
            }
          });

          edit_ip_memo_list(ip_map, function () {
            document.getElementById("load_ip_memo_list").checked = false;
            document.getElementById("btn_ip_memo_close").click();
          });
        }
        success = false;
        break;
    }
    if (success) {
      document.getElementById("btn_ip_memo_close").click();
    }
    //console.debug("end editor - " + add_mode.value);
  }

  function show_ip_memo_list(reload) {
    var add_mode = document.getElementById("ip_memo_add_mode");
    add_mode.value = "list";
    if (document.getElementById("load_ip_memo_list").checked) {
      var data_empty = true;
      Array.from(document.querySelectorAll(".ui-custom-ip-memo-list-data")).forEach((item, index) => {
        data_empty = false;
        item.classList.add("d-block");
        item.classList.remove("d-none");
      });

      Array.from(document.querySelectorAll(".ui-custom-ip-memo-list-zero")).forEach((item, index) => {
        if (data_empty) {
          item.classList.add("d-block");
          item.classList.remove("d-none");
        } else {
          item.classList.remove("d-block");
          item.classList.add("d-none");
        }
      });
      document.getElementById("btn_ip_memo_add").classList.remove("d-none");
    } else {
      if (!(reload ?? false)) {
        document.getElementById("load_ip_memo_list").checked = true;
        get_ip_memo_list(add_mode.value, function () {
          show_ip_memo_list(true);
        })
      }
    }
  }

  function create_ip_memo_list(ip, desc, edit_mode) {
    if ((ip ?? "").trim() == "") return;
    var li_position = null
    var li_add = true;
    if (edit_mode) {
      Array.from(document.querySelectorAll(".ui-custom-ip-memo-list")).some((item, index) => {
        if (index != 0) {
          var li_ip = item.querySelector("#ip_memo_list_name")?.innerText ?? "";
          if (li_ip == ip) {
            item.querySelector("#ip_memo_list_desc").value = desc;
            li_add = false;
            return true;
          } else if (li_ip < ip) {
            li_position = item;
            return true;
          } else {
            return false;
          }
        }
      });
    }

    if (li_add) {
      var li_list = document.querySelectorAll(".ui-custom-ip-memo-list");
      var li_first = document.querySelector(".ui-custom-ip-memo-list-default");
      var li_last = li_list.length > 0 ? li_list[li_list.length - 1] : li_first;
      var li_new = document.createElement('li');
      li_new.className = li_first.className;
      li_new.innerHTML = li_first.innerHTML;
      li_new.classList.add("ui-custom-ip-memo-list-data");
      li_new.querySelector("#ip_memo_list_name").innerText = ip;
      li_new.querySelector("#ip_memo_list_desc").value = desc;
      li_new.querySelector("#ip_memo_list_desc").title = desc;
      setBtnGroupClickEvent(li_new, ".ip_memo_editor_btns", click_ip_memo_editor_btn);
      if (li_position != null) {
        li_position.parentNode.insertBefore(li_new, li_position);
      } else {
        li_last.parentNode.insertBefore(li_new, li_last.nextSibling);
      }
    }
  }

  function clear_ip_memo_editor() {
    document.getElementById("ip_memo_add_mode").value = "";
    document.getElementById("ip_memo_add_name").value = ".♡..";
    document.getElementById("ip_memo_add_desc").value = "";
    document.getElementById("ui_custom_ip_memo_editor").value = ".♡..,\r\n.♡..,";
  }
  function clear_ip_memo_list() {
    Array.from(document.querySelectorAll(".ui-custom-ip-memo-list-data")).forEach((item, index) => { item.remove() });
  }

  function get_ip_memo_list(list_mode, complete) {
    if (window.indexedDB) {
      var temp_obj = get_board_mb_id();
      if (temp_obj != null && temp_obj.id != null) {
        check_memo_user_id(temp_obj.id);

        var memo_db_request = indexedDB.open(memoDBName + temp_obj.id, memo_db_version);
        memo_db_request.onupgradeneeded = memo_db_upgrade;
        memo_db_request.onsuccess = function (event) {
          var db = event.target.result;

          var checked_ip = 0;
          var ipStore = getDBObjectStore(db, memoIP, "readonly", complete);
          var ipIndex = ipStore.index("by_ip");
          var access_req = ipIndex.openCursor();
          var memo_list = [];
          //memo ip 갱신
          access_req.onsuccess = function (e) {
            var cursor = e.target.result;
            if (cursor) {
              var temp_val = cursor.value;
              if (temp_val.desc != null) {
                var nick_list = [];
                if (temp_val.ip != null) {
                  Object.keys(temp_val.ip).forEach((ip) => {
                    nick_list.push(temp_val.ip[ip].nick);
                  });
                }
                memo_list.push({ ip: temp_val.ip, desc: temp_val.desc, nick_list: nick_list });
              }
              cursor.continue();
            } else {
              switch (list_mode) {
                case "edit":
                  var edit_string = "";
                  memo_list.forEach((item, index) => {
                    if (index != 0) {
                      edit_string += "\n";
                    }
                    edit_string += item.ip + "," + item.desc + "";
                  });
                  document.getElementById("ui_custom_ip_memo_editor").value = edit_string;
                  break;
                default:
                  memo_list.forEach((item) => {
                    create_ip_memo_list(item.ip, item.desc, false);
                  });
                  break;
              }
            }
          };
        };
      }
    }
  }

  function edit_ip_memo_list(ip_map, complete) {
    if (window.indexedDB) {
      var temp_obj = get_board_mb_id();
      if (temp_obj != null && temp_obj.id != null) {
        check_memo_user_id(temp_obj.id);

        var memo_db_request = indexedDB.open(memoDBName + temp_obj.id, memo_db_version);
        memo_db_request.onupgradeneeded = memo_db_upgrade;
        memo_db_request.onsuccess = function (event) {
          var db = event.target.result;
          var checked_ip = 0;
          var ipStore = getDBObjectStore(db, memoIP, "readwrite", complete);
          var now_stamp = Date.now();
          var ips = Object.keys(ip_map);
          ips.forEach((memo_ip) => {
            var temp_req = ipStore.get(memo_ip);
            temp_req.onsuccess = function (e) {
              var result = e.target.result;
              var memo_desc = ip_map[memo_ip].desc;
              if (result != null) {
                if (memo_desc == null) {
                  delete result.desc;
                  if (result.id_cnt == 0) {
                    ipStore.delete(memo_ip);
                  } else {
                    delete result.desc;
                    result.access = now_stamp;
                    ipStore.put(result);
                  }
                } else {
                  if (result.desc != memo_desc) {
                    result.desc = memo_desc;
                    result.access = now_stamp;
                    ipStore.put(result);
                  }
                }
              } else {
                ipStore.add({ ip: memo_ip, id: {}, access: now_stamp, id_cnt: 0, desc: memo_desc });
              }
            };
          });
        }
      }
    }
  }
  //IP메모 기능 끝

  //터치 이벤트 기록용 시작
  var tlog = null;
  var tges = {};
  function set_touch_gesture(ui_obj) {
    close_offcanvas();
    if (ui_obj != null && ui_obj.expand_gesture) {
      tges = {};
      tges.swipe = ui_obj.expand_gesture_swipe;
      tges.swipe_minx = ui_obj.expand_gesture_swipe_minx ?? 50;
      tges.swipe_maxy = ui_obj.expand_gesture_swipe_maxy ?? 30;
      tges.tap2 = ui_obj.expand_gesture_tap2;
      tges.tap3 = ui_obj.expand_gesture_tap3;
      tges.left_menu_over = (ui_obj.left_menu_over ?? false);
      tges.start_term = ui_obj.expand_gesture_start_term ?? 400;
      tges.click_term = ui_obj.expand_gesture_click_term ?? 250;

      if (tges.tap3 != null) {
        tges.maxTap = 4;
      } else if (tges.tag2 != null) {
        tges.maxTap = 3;
      } else {
        tges.maxTap = 0;
      }
      set_touch_event();  
    }
  }
  var stt = null
  function set_touch_event(term) {
    var touch_list = ["touchstart", "touchmove", "touchend", "touchcancle"];
    touch_list.forEach((touch) => {
      window.removeEventListener(touch, get_touch_event, false);
    });
    if (term != null) {
      if (stt!=null) {
        clearTimeout(stt);
      }
      stt = setTimeout(function(){
        touch_list.forEach((touch) => {
          window.addEventListener(touch, get_touch_event, false);
        });
      },term);
    } else {
      touch_list.forEach((touch) => {
        window.addEventListener(touch, get_touch_event, false);
      });
  
    }
}
  function get_touch_event(e, parent_name) {
    var now = Date.now();
    var term = null;
    if (tlog?.summary?.last_event != null) {
      term = now - tlog.summary.last_event;
    } else {
      term = 0;
    }
    if (tlog == null || (term != null && term > 1000)) {
      tlog = { summary: { start: 0, end: 0, move: 0, start_time: now }, list: [] };
    } else {
      tlog.summary.start_term = now - tlog.summary.start_time;
    }
    if (tsev != null) {
      clearTimeout(tsev);
    }
    var pageX, pageY;
    if ((e.touches?.length ?? 0) > 0) {
      pageX = e.touches[0].pageX;
      pageY = e.touches[0].pageY;
      if (pageX) {
        if (tlog.summary.pageX != null) {
          tlog.summary.moveX = pageX - tlog.summary.pageX;
        } else {
          delete tlog.summary.moveX;
        }
        if (tlog.summary.startX != null) tlog.summary.totalX = pageX - tlog.summary.startX;
        tlog.summary.pageX = pageX;
      }
      if (pageY) {
        if (tlog.summary.pageY != null) {
          tlog.summary.moveY = pageY - tlog.summary.pageY;
        } else {
          delete tlog.summary.moveY;
        }
        if (tlog.summary.startY != null) tlog.summary.totalY = pageY - tlog.summary.startY;
        tlog.summary.pageY = pageY;
      }
    }

    tlog.summary.last_event = now;
    tlog.summary.term = term;
    tlog.summary.target = e.target;

    switch (e?.type) {
      case "touchstart":
        if (pageX != null) tlog.summary.startX = pageX;
        if (pageY != null) tlog.summary.startY = pageY;
        tlog.summary.start++;
        tlog.list.push(e);
        break;

      case "touchmove":
        tlog.summary.move++;
        tlog.list.push(e);
        //if (tlog.summary.start_term < 300) {
          //e.preventDefault();
        //}
        break;

      case "touchend":
      case "touchcancle":
        tlog.summary.end++;
        tlog.list.push(e);
        if ( !(isShortCutInputElement(e.target)) && tlog.summary.move < 3 && tlog.summary.end < tges.maxTap && (tlog.summary.start_term < (tlog.summary.end + 1) * tges.click_term)) {
          e.preventDefault();
          tsev = setTimeout(check_touch_event, tges.click_term);
        } else if (tlog.summary.start_term < tges.start_term || tlog.summary.move > 5) {
            check_touch_event();
        } else {
          clearTimeout(tsev);
          tlog = null;
        }
        break;
    }
  }

  var tsev = null;
  function check_touch_event() {
    var m = (tlog.summary.move > 0);
    var md = "";
    var ax = 0;
    var ay = 0;

    var t_type;
    var t_value;

    if (tges != null) {
      if (m) {
        ax = Math.abs(tlog.summary.totalX)
        ay = Math.abs(tlog.summary.totalY);
        if (((tges.swipe ?? "") != "") && ax > (tges.swipe_minx ?? 50) && ay < (tges.swipe_maxy ?? 30) && (ax/ay) >= 3) {
          t_type = tges?.swipe;
          if (tlog.summary.totalX > 0) {
            t_value = "r";
          } else {
            t_value = "l";
          }
        }
      } else {
        var tc = tlog.summary.end;
        switch (tc) {
          case 3:
            t_type = tges.tap3;
            break;
          case 2:
            t_type = tges.tap2;
            break;
          case 1:
            //set_touch_event(500)
            tlog.summary.target.dispatchEvent(tlog.list[tlog.list.length-1]);
            tlog.summary.target.click();
            break;
        }
      }
      run_touch_gesture(t_type, t_value);
    }
    clearTimeout(tsev);
    tlog = null;
  }
  function run_touch_gesture(t_type, t_value) {
    var sidemenu_o = document.getElementById("menuOffcanvas").classList.contains("show");
    var mymenu_o = document.getElementById("memberOffcanvas").classList.contains("show");
    if (t_value != null) {
      switch (t_type) {
        case "history":
          if (t_value == "r") {
            t_type = "goBack";
          } else {
            t_type = "goForward";
          }
          break;
        case "menuOpen":
          if (tges.left_menu_over) {
            if (sidemenu_o) {
              if (t_value == "r") {
                t_type = "goBack"; //작동안함
              } else {
                t_type = "sideMenuOff";
              }
            } else if (mymenu_o) {
              if (t_value == "r") {
                t_type = "myMenuOff";
              } else {
                t_type = "goForward"; //작동안함
              }
            } else {
              if (t_value == "r") {
                t_type = "sideMenu";
              } else {
                t_type = "myMenu";
              }
            }
          } else {
            if (sidemenu_o) {
              if (t_value == "r") {
                t_type = "sideMenuOff"; //작동안함
              } else {
                t_type = "myMenu";
              }
            } else if (mymenu_o) {
              if (t_value == "r") {
                t_type = "myMenuOff";
              } else {
                t_type = "sideMenu"; //작동안함
              }
            } else {
              if (t_value == "r") {
                t_type = "goBack"; //작동안함
              } else {
                t_type = "sideMenu";
              }
            }
          }
          break;
      }
    }
    if (t_type != null) {
      var term = 10;
      switch (t_type) {
        case "refresh": //새로고침
          window.location.reload();
          break;
        case "toList": //목록으로이동
          var bl = document.getElementById('bo_list_wrap');
          var bc = document.getElementById('bo_v');
          var sy = window.scrollY || document.documentElement.scrollTop;
          var sh = screen.height;
          var hn = document.getElementById('header-navbar');
          if (bc == null) {
            if ( sy <= (bl.offsetTop + 100)) {
              window.scrollTo(0,bl.offsetTop + bl.offsetHeight - sh + hn.offsetHeight + 60);
            } else {
              window.location.replace("#bo_list_wrap");
            }
          } else {
            if ( sy <= (bc.offsetTop + 100)) {
              window.location.replace("#bo_list_wrap");
            } else if ( sy <= (bl.offsetTop + 100)) {
              window.scrollTo(0,bl.offsetTop + bl.offsetHeight - sh + hn.offsetHeight + 60);
            } else {
              window.location.replace("#bo_v");
            }
          }
          break;
        case "sideMenu": //게시판메뉴
        case "sideMenuOff": //게시판메뉴
          document.querySelector("a[data-bs-target='#menuOffcanvas']").click();
          document.querySelector("a[data-bs-target='#menuOffcanvas']").blur();
          break;
        case "myMenu": //마이메뉴
        case "myMenuOff": //마이메뉴
          document.querySelector("a[data-bs-target='#memberOffcanvas']").click();
          document.querySelector("a[data-bs-target='#memberOffcanvas']").blur();
          break;
          break;
        case "toTop": //위아래로이동
          var sy = window.scrollY || document.documentElement.scrollTop;
          var bh = document.body.scrollHeight;
          var sh = screen.height;
          if (sy < sh * 1.5) {
            window.scrollTo(0, bh - sh);
          } else {
            window.location.replace("#top");
          }
          break;
        case "goBack": //뒤로이동
          //term = close_offcanvas();
          history.back();
          break;
        case "goForward": //앞으로이동  
          //term = close_offcanvas();
          history.forward();
          break;
    }
    }
  }
  function close_offcanvas(){
    var term = 10;
    if (document.getElementById("menuOffcanvas") != null && document.getElementById("menuOffcanvas").classList.contains("show")) {
      document.querySelector("a[data-bs-target='#menuOffcanvas']").click();
      document.querySelector("a[data-bs-target='#menuOffcanvas']").blur();
      term += 250;
    }
    if (document.getElementById("memberOffcanvas") != null && document.getElementById("memberOffcanvas").classList.contains("show")) {
      document.querySelector("a[data-bs-target='#memberOffcanvas']").click();
      document.querySelector("a[data-bs-target='#memberOffcanvas']").blur();
      term += 250;
    }
    return term;
  }
  //터치 이벤트 기록용 끝

  //소모임 추천 및 단축키 등록 유도 시작
  function set_bbs_group_recommend(ui_obj, reload){
    if (reload) {
      var removes = document.querySelectorAll('div.nav-item.bbs_group_recommend');
      removes.forEach((item)=>{
        item.remove();
      });  
    }
    var board_obj = null;
    if (!(ui_obj?.bbs_shortcut_recommend_off ?? false)) {
      board_obj = get_board_mb_id();
    }
    var user_regs = [];
    for(var i=0;i<10;i++) {
      var temp_short = (ui_obj["shortcut_" + i] ?? "");

      if (temp_short != "") {
        user_regs.push(temp_short);        
      }
    }
    var bbs_group = [];
    var menu_div = document.querySelectorAll("div.na-menu div.nav");
    menu_div.forEach((item)=>{
      var dropdown = item.querySelector("div.nav-item div.nav-item:has(a.nav-link.dropdown-toggle)");
      if (dropdown!=null) {
        bbs_group.push(dropdown);
      }
    });
    //var bbs_group = document.querySelectorAll("div.na-menu div.nav div.nav-item div.nav-item:has(a.nav-link.dropdown-toggle)");
    var link_list = [];
    var links = document.querySelectorAll("#sidebar-site-menu .da-menu--bbs-group-group div >  a");
    links.forEach((temp)=> {
      var regex = /^[a-zA-Z]+$/;
      var temp_link_obj = temp;
      var temp_name = temp_link_obj.innerHTML.trim();
      var temp_link = temp_link_obj.href.trim();
      var temp_link_org = temp_link;
      if (temp_link.length > 0) {
        temp_link = temp_link.substr(temp_link.lastIndexOf('/') + 1);
        if (regex.test(temp_link)) {
          if (board_obj != null && board_obj.board == temp_link) {
            board_obj.board_name = temp_name;
          }
          if (user_regs.length > 0 && user_regs.includes(temp_link)) {

          } else {
            link_list.push({ link: temp_link, org: temp_link_org, name: temp_name });
          }
        }
      }
    });
    if (board_obj?.board_name != null) {
      set_bbs_shortcut_recommend(ui_obj, board_obj, reload);
    }

    if (ui_obj?.bbs_group_recommend_off ?? false) {
      return;
    }
   
    var recommend_count = 3;
    var recommend_group = [];
    console.trace();
    for(var i=0;i<recommend_count;i++) {
      if (link_list.length>0) {
        var temp = Math.floor(Math.random() * link_list.length);
        recommend_group.push(link_list[temp]);
        link_list.splice(temp,1);
      } else {
        break;
      }
    }
    recommend_group.push({ link: "recommend_off", org: "#recommend_off", name: "소모임 추천끄기"});
    
    bbs_group.forEach((group)=>{
      var parent = group.parentNode;
      var nextSibling = group.nextSibling;
      var header = document.createElement("div");
      header.className = "dropdown-header bbs_group_recommend fst-italic";
      header.innerHTML = "소모임 추천";
      parent.insertBefore(header, nextSibling);  

      recommend_group.forEach((link)=>{
        var shortcut_div = document.createElement("div");
        shortcut_div.className = "nav-item bbs_group_recommend opacity-75 fst-italic";
        var shortcut_link = document.createElement("a");
        shortcut_link.className = "nav-link bbs_group_recommend";
        shortcut_link.href = link.org;
        shortcut_link.innerHTML = '<span class="d-flex align-items-center gap-2 nav-link-title"><span class="badge p-1 text-bg-secondary">·</span>' + link.name + "</span>";//<i class="bi-list-stars nav-icon">//
        if (link.org=="#recommend_off") {
          shortcut_link.addEventListener('click',set_bbs_group_recommend_off);
        }
        shortcut_div.appendChild(shortcut_link);
        parent.insertBefore(shortcut_div, nextSibling);  
      });
    });
  }

  function set_bbs_group_recommend_off(){
    if (confirm("소모임 추천을 하지 않겠습니까?\n마이메뉴 -> 개인화면설정 -> 추천에서 설정을 바꾸실 수 있습니다.")){
      remove_bbs_group_recommend();
      var ui_obj = get_ui_obj(true);
      ui_obj.bbs_group_recommend_off = true;
      set_ui_obj(ui_obj);
      alert('앞으로 소모임 추천 기능을 하지 않습니다.');
      set_ui_custom_values();
    }
  }

  function remove_bbs_group_recommend(){
    var removes = document.querySelectorAll('div.nav-item.bbs_group_recommend');
    removes.forEach((item)=>{
      item.remove();
    });    
  }

  function set_bbs_shortcut_recommend(ui_obj, board_obj, reload){
    if (reload) {
      remove_bbs_shortcut_reg();
    }
    if (ui_obj?.bbs_shortcut_recommend_off ?? false) {
      return;
    } else {
      if (board_obj != null && board_obj.board_name != null) {
        var reged = false;
        var fulled = true;
        for(var i=1;i<11;i++) {
          var check_i = i<10 ? i : i-10;
          var temp_short = (ui_obj["shortcut_" + check_i] ?? "");
          if (temp_short == board_obj.board) {
            reged = true;
            break;
          } else if (temp_short == ""){
            fulled = false;
          }
        }
        if (reged || fulled) {
          return;
        }
      }  
    }
    var title_a = document.querySelector("div.page-title a");
    var button = document.createElement('button');
    button.setAttribute("type","button");
    button.className = "btn btn-link btn-lg p-0 bbs_shortcut_recommend";
    button.style = "font-size: 1.3em;margin: -0.5em 0em -0.3em;";
    button.title = "소모임 단축키를 등록해 봅시다.";
    button.innerHTML = '<i class="bi bi-keyboard ms-3"></i>';
    button.addEventListener('click',set_bbs_shortcut_reg);
    title_a.parentNode.insertBefore(button,title_a.nextSibling);
  }

  function set_bbs_shortcut_reg(){
    var board_obj = get_board_mb_id();
    if ((board_obj?.board ?? "") == "" ) {
      remove_bbs_shortcut_reg();
      return;
    }
    var title_a = document.querySelector("div.page-title a");
    var board_title = title_a.innerText.trim();
    var ui_obj = get_ui_obj(true);
    var shortcut_arr = [];
    var first_num = null;
    var check_board = false;
    if (ui_obj != null) {
      for(var i=1;i<11;i++) {
        var check_i = i<10 ? i : i-10;
        var temp_short = (ui_obj["shortcut_" + check_i] ?? "");
        if (temp_short == "") {
          if (first_num == null) {
            first_num = check_i;
          }
        } else {
          if (temp_short == board_obj?.board) {
            check_board = true;
          }
          shortcut_arr.push(check_i);
        }
      }
    }    
    if (first_num == null) {
      alert("단축키가 모두 등록되어 있습니다.");
    } else if (check_board) {
      alert("이미 등록된 단축키 입니다.");
    }else {
      if (confirm(board_title + "의 단축키를 " + first_num + "번으로 등록하시겠습니까?")){
        ui_obj.shortcut_use = true;
        ui_obj["shortcut_"+first_num] = board_obj.board;
        set_ui_obj(ui_obj);
        alert(board_title+"의 단축키가 " + first_num + "번으로 등록되었습니다.");
        set_ui_custom_values();
      } else {
        if (shortcut_arr.length > 2) {
          setTimeout(function(){
            if (confirm("소모임의 단축키 등록 표시를 그만 보시겠습니까?\n마이메뉴 -> 개인화면설정 -> 추천에서 설정을 바꾸실 수 있습니다.")) {  
              ui_obj.bbs_shortcut_recommend_off = true;
              set_ui_obj(ui_obj);
              set_ui_custom_values();
              alert("앞으로 소모임의 단축키 등록 버튼을 표시하지 않습니다.");
            }  
          },700);  
        }
      }
    }
  }

  function remove_bbs_shortcut_reg(){
    var removes = document.querySelectorAll('button.bbs_shortcut_recommend');
      removes.forEach((item)=>{
        item.remove();
      });  
  }
 
  function get_ui_obj(not_null){
    var ui_custom_storage_str = localStorage.getItem("ui_custom");
    var ui_obj = null;
    if (ui_custom_storage_str != null && ui_custom_storage_str != "") {
      try {
        ui_obj = JSON.parse(ui_custom_storage_str);
      } catch(e) {
      }
    }
    if (ui_obj == null && (not_null ?? false)) {
      ui_obj = {};
    }
    return ui_obj;
  }
  function set_ui_obj(ui_obj){
    var json_str = "";
    if (ui_obj == null) {
      json_str = "";
    } else if (typeof ui_obj == "string") {
      json_str = ui_obj
    } else {
      try {
        json_str = JSON.stringify(ui_obj);
      } catch(e) {
        json_str = "";
      }
    }
    json_str = json_str.trim();
    if (json_str != "") {
      localStorage.setItem("ui_custom", json_str);
    } else {
      localStorage.removeItem("ui_custom")
    }    
  }
  //소모임 추천 및 단축키 등록 유도 끝


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
      $("#reg_show_detail").change(function () {
        var container = document.querySelector("#user-ui-custom div.ui-custom-container");
        if (container!=null){
          if ($("#reg_show_detail").is(":checked")) {
            container.classList.add("show-detail");
          } else {
            container.classList.remove("show-detail");  
          }  
        }
        $("#reg_ui_custom").trigger('change');

        $("#reg_title_filtering").trigger('change');
        $("#reg_content_blur").trigger('change');
        $("#reg_shortcut_use").trigger('change');  
      });      

      //reg_expand_shortcut
      $("#reg_expand_shortcut").change(function () {
        set_ui_custom_expand();
      });

      $("#reg_rcmd_font_color").change(function () {
        switch (this.value) {
          case "self":
            $("#reg_rcmd_font_color_self").removeClass('d-none');
            $(".rcmd_font_steps").addClass('d-none');
            break;
          case "step":
            $("#reg_rcmd_font_color_self").addClass('d-none');
            $(".rcmd_font_steps").removeClass('d-none');
            break;
          default:
            $("#reg_rcmd_font_color_self").addClass('d-none');
            $(".rcmd_font_steps").addClass('d-none');
            break;
        }
        set_ui_rcmd_steps_class();
      });

      $("#reg_rcmd_color_set").change(function () {
        if (this.value == "self") {
          $(".rcmd_color_steps").removeClass('d-none');
        } else {
          $(".rcmd_color_steps").addClass('d-none');
        }
        set_ui_rcmd_steps_class();
      });

      $("#reg_expand_quick").change(function () {
        set_ui_custom_expand();
      });

      $("#reg_read_history").change(function () {
        set_ui_custom_read_history();
      });

      $("#reg_ui_custom").change(function () {
        if ($("#reg_ui_custom").is(":checked")) {
          $(".ui-custom-item").removeClass('d-none');
          $("#reg_rcmd_font_color").trigger('change');
          $("#reg_rcmd_color_set").trigger('change');
          set_ui_custom_expand();
          set_ui_custom_read_history();
        } else {
          $(".ui-custom-item").addClass('d-none');
        }
      });
      $("#reg_title_filtering").change(function () {
        if ($("#reg_title_filtering").is(":checked")) {
          $(".ui-custom-filtering").removeClass('d-none');
        } else {
          $(".ui-custom-filtering").addClass('d-none');
        }
      });
      $("#reg_content_blur").change(function () {
        if ($("#reg_content_blur").is(":checked")) {
          $(".ui-custom-content-blur").removeClass('d-none');
        } else {
          $(".ui-custom-content-blur").addClass('d-none');
        }
      });
      $("#reg_shortcut_use").change(function () {
        if ($("#reg_shortcut_use").is(":checked")) {
          $(".ui-custom-shortcut").removeClass('d-none');
        } else {
          $(".ui-custom-shortcut").addClass('d-none');
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
  function set_ui_rcmd_steps_class(){
    if ($("#reg_rcmd_color_set").val() == "self" || $("#reg_rcmd_font_color").val()) {
      $(".ui-custom-rcmd-steps").removeClass("ui-custom-detail");
    } else {
      $(".ui-custom-rcmd-steps").addClass("ui-custom-detail");
    }
  }

  function set_ui_custom_expand_shortcut() {
    if ($("#reg_expand_quick").is(":checked") && $("#reg_shortcut_use").is(":checked")) {
      $("#reg_expand_shortcut_li").removeClass('d-none');
      if ($("#reg_expand_shortcut").is(":checked")) {
        $(".ui-custom-expand-shortcut").removeClass('d-none');
        var link_map = get_board_link_map();
        Array.from(document.querySelectorAll(".ui-custom-expand-shortcut")).forEach((item) => {
          var temp_input = item.querySelector("input");
          var temp_id = temp_input.id.replace("expand_", "");
          var check_input = document.getElementById(temp_id);
          if ((check_input?.value ?? "") != "") {
            var temp_label = item.querySelector("label.col-form-label");
            temp_label.innerHTML = temp_id.substring(temp_id.length - 1) + " : " + link_map[check_input.value].name;
            $(item).removeClass('d-none');
          } else {
            $(item).addClass('d-none');
          }
        });
      } else {
        $(".ui-custom-expand-shortcut").addClass('d-none');
      }
    } else {
      $("#reg_expand_shortcut_li").addClass('d-none');
      $(".ui-custom-expand-shortcut").addClass('d-none');
    }
  }

  function set_ui_custom_expand() {
    if ($("#reg_expand_quick").is(":checked")) {
      $(".ui-custom-expand-item").removeClass('d-none');
    } else {
      $(".ui-custom-expand-item").addClass('d-none');
    }
    set_ui_custom_expand_shortcut();
  }
  function set_ui_custom_read_history() {
    if ($("#reg_read_history").is(":checked")) {
      $(".ui-custom-read-history").removeClass('d-none');
      document.getElementById("btn_ip_memo_close").click();
    } else {
      $(".ui-custom-read-history").addClass('d-none');
    }
  }
  function set_ui_custom_trigger() {
    try {
      //$("#reg_expand_quick").trigger('change');
      $("#reg_show_detail").trigger('change');
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

    setBtnClickEvent("btn_ui_apply", ui_custom_apply);
    setBtnClickEvent("btn_ui_value_view", ui_custom_value_view);
    setBtnClickEvent("btn_ui_value_cancle", ui_custom_value_cancle);
    setBtnClickEvent("btn_ui_value_save", ui_custom_value_save);
    setBtnClickEvent("btn_ui_value_copy", ui_custom_value_copy);
    setBtnClickEvent("btn_ui_value_paste", ui_custom_value_paste);
    setBtnClickEvent("btn_ui_value_clear", ui_custom_value_clear);
    setBtnClickEvent("btn_ui_value_reload", ui_custom_value_reload);
    setBtnClickEvent("btn_memo_toggle", toggle_hide_member_memo);
    setBtnClickEvent("btn_memo_ip_clear", delete_memo_database);
    setBtnClickEvent("btn_read_history_clear", delete_read_database);

    setBtnGroupClickEvent(document, ".ip_memo_btns", set_ip_memo_edit_mode);
    setBtnGroupClickEvent(document, ".ip_memo_editor_btns", click_ip_memo_editor_btn);

    set_ui_custom_values();
  }

  function setBtnClickEvent(id, event) {
    var btn = document.getElementById(id);
    if (btn != null) btn.addEventListener("click", event);
  }
  function setBtnGroupClickEvent(el, cssQuery, event) {
    if (el == null) el = document;
    Array.from(el.querySelectorAll(cssQuery)).forEach((item) => { item.addEventListener("click", event) });
  }


  function set_page_show(event) {
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
  window.removeEventListener('keypress', handleClearSettingKeyPress);
  window.addEventListener('keypress', handleClearSettingKeyPress);

  try {
    set_ui_custom();
  } catch (error) {
    //console.error('Failed to initialize custom UI settings:', error);
  }
})();