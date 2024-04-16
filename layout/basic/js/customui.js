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

                hide_nick(ui_obj);
            }
        }
    }
      
    function ui_custom_apply(){
        var ui_custom_input = ["ui_custom","show_width","font_family","font_size","line_height","menu_width","left_menu","menu_scroll","list_search","img_preview","hide_nick"];
        var ui_custom_default = {show_width : 1200, font_size:1,line_height:1.5,menu_width:25};
        var ui_custom_json = {};
        var changed = false;

        ui_custom_input.forEach(function(reg){
            var temp_input = $("#reg_"+reg)[0]
            if (temp_input!=null) {
                var temp_value = temp_input.value;
                if (temp_value != null && temp_value !="" ) {
                    temp_value = temp_value.trim()
                    var save = true;
                    if (temp_input.type=="checkbox") {
                        save = temp_input.checked;
                        temp_value = true;
                    } else {
                        if (ui_custom_default[reg] !=null ) {
                            if (temp_value == ui_custom_default[reg]) {
                                save = false;
                            }
                        }
                    }
                    if (save) {
                        changed = true;
                        if (temp_input.type=="number") {
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
            localStorage.setItem(item_key,json_str);
        } else {
            localStorage.removeItem(item_key)
        }
        document.getElementById('ui_custom_json').value = json_str;
        alert("변경사항이 적용되었습니다.");

        try{
            set_ui_custom();
        } catch{
            console.error('Failed to initialize custom UI settings:', error);
        }
    }

    function get_ui_custom_values(){
        var ui_custom_storage_str = localStorage.getItem("ui_custom");
        if (ui_custom_storage_str !=null && ui_custom_storage_str != "") {
            var ui_custom_obj = JSON.parse(ui_custom_storage_str);
            var ui_custom_keys = Object.keys(ui_custom_obj);
            ui_custom_keys.forEach(function(reg){
                var temp_input = document.getElementById("reg_"+reg);
                if (temp_input != null) {
                    if (temp_input.type=="checkbox") {
                        if (ui_custom_obj[reg] == true) {
                            temp_input.checked = true;
                        } else {
                            temp_input.checked = false;
                        }
                    } else {
                        temp_input.value = ui_custom_obj[reg];
                    }
                }
            })
            document.getElementById('ui_custom_json').value = ui_custom_storage_str;
            return ui_custom_obj;
        }
    }

    function hide_nick(ui_obj) {
         //닉네임 감추기
         if (ui_obj.hide_nick != null && ui_obj.hide_nick) {
            var profiles = document.getElementsByClassName('sv_member ellipsis-1');
            for(var i = 0; i < profiles.length; i++) {
                var profile_html = profiles[i].innerHTML;
                profiles[i].innerHTML = profile_html.substr(0, profile_html.indexOf("/span>") + 6) + " 회원님"
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        var btn_ui_apply = document.getElementById("btn_ui_apply");
        if (btn_ui_apply) {
            btn_ui_apply.addEventListener("click", function(e) {
                ui_custom_apply();
            });
        }
        var ui_obj = get_ui_custom_values();
        hide_nick(ui_obj);
    }, { once: true });

    try{
        set_ui_custom();
    } catch{
        console.error('Failed to initialize custom UI settings:', error);
    }

})();

