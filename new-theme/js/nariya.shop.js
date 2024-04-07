var option_plus = false;
var supply_plus = false;
var is_Android = (navigator.userAgent.toLowerCase().indexOf("android") > -1);
var is_Safari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

$(function() {
    // 선택옵션
    /* 가상커서 ctrl keyup 이베트 대응 */
    /*
    $(document).on("keyup", "select.item_option", function(e) {
        var sel_count = $("select.item_option").length;
        var idx = $("select.item_option").index($(this));
        var code = e.keyCode;
        var val = $(this).val();

        option_plus = false;
        if(code == 17 && sel_count == idx + 1) {
            if(val == "")
                return;

            cart_sel_option_process(true);
        }
    });
    */

    /* 키보드 접근 후 옵션 선택 Enter keydown 이벤트 대응 */
    $(document).on("keydown", "select.item_option", function(e) {
        var sel_count = $("select.item_option").length;
        var idx = $("select.item_option").index($(this));
        var code = e.keyCode;
        var val = $(this).val();

        option_plus = false;
        if(code == 13 && sel_count == idx + 1) {
            if(val == "")
                return;

            cart_sel_option_process(true);
        }
    });

    if(is_Android) {
        $(document).on("touchend mouseup", "select.item_option", function() {
            option_plus = true;
        });
    } else {
        var item_option_events = is_Safari ? "mousedown" : "mouseup";

        $(document).on(item_option_events, "select.item_option", function(e) {
            option_plus = true;
        });
    }

    $(document).on("change", "select.item_option", function() {
        var sel_count = $("select.item_option").length,
            idx = $("select.item_option").index($(this)),
            val = $(this).val(),
            it_id = $("input[name='it_id[]']").val(),
            post_url = (typeof g5_shop_url !== "undefined") ? g5_shop_url+"/itemoption.php" : "./itemoption.php",
            $this = $(this),
            op_0_title = $this.find("option:eq(0)").text();

        // 선택값이 없을 경우 하위 옵션은 disabled
        if(val == "") {
            $("select.item_option:gt("+idx+")").val("").attr("disabled", true);
            return;
        }

        $this.trigger("select_item_option_change", [$this]);

        // 하위선택옵션로드
        if(sel_count > 1 && (idx + 1) < sel_count) {
            var opt_id = "";

            // 상위 옵션의 값을 읽어 옵션id 만듬
            if(idx > 0) {
                $("select.item_option:lt("+idx+")").each(function() {
                    if(!opt_id)
                        opt_id = $(this).val();
                    else
                        opt_id += cart_chr(30)+$(this).val();
                });

                opt_id += cart_chr(30)+val;
            } else if(idx == 0) {
                opt_id = val;
            }

            $.post(
                post_url,
                { it_id: it_id, opt_id: opt_id, idx: idx, sel_count: sel_count, op_title : op_0_title },
                function(data) {
                    $("select.item_option").eq(idx+1).empty().html(data).attr("disabled", false);

                    // select의 옵션이 변경됐을 경우 하위 옵션 disabled
                    if(idx+1 < sel_count) {
                        var idx2 = idx + 1;
                        $("select.item_option:gt("+idx2+")").val("").attr("disabled", true);
                    }

                    $this.trigger("select_item_option_post", [$this, idx, sel_count, data]);
                }
            );
        } else if((idx + 1) == sel_count) { // 선택옵션처리
            if(option_plus && val == "")
                return;

            var info = val.split(",");
            // 재고체크
            if(parseInt(info[2]) < 1) {
				na_alert('선택하신 선택옵션상품은 재고가 부족하여 구매할 수 없습니다.');
                return false;
            }

            if(option_plus)
                cart_sel_option_process(true);
        }
    });

    // 추가옵션
    /* 가상커서 ctrl keyup 이베트 대응 */
    /*
    $(document).on("keyup", "select.item_supply", function(e) {
        var $el = $(this);
        var code = e.keyCode;
        var val = $(this).val();

        supply_plus = false;
        if(code == 17) {
            if(val == "")
                return;

            cart_sel_supply_process($el, true);
        }
    });
    */

    /* 키보드 접근 후 옵션 선택 Enter keydown 이벤트 대응 */
    $(document).on("keydown", "select.item_supply", function(e) {
        var $el = $(this);
        var code = e.keyCode;
        var val = $(this).val();

        supply_plus = false;
        if(code == 13) {
            if(val == "")
                return;

            cart_sel_supply_process($el, true);
        }
    });

    if(is_Android) {
        $(document).on("touchend mouseup", "select.item_supply", function() {
            supply_plus = true;
        });
    } else {
        var item_supply_events = is_Safari ? "mousedown" : "mouseup";
        
        $(document).on(item_supply_events, "select.item_supply", function(e) {
            supply_plus = true;
        });
    }

    $(document).on("change", "select.item_supply", function() {
        var $el = $(this);
        var val = $(this).val();

        if(val == "")
            return;

        if(supply_plus)
            cart_sel_supply_process($el, true);
    });

    // 수량변경 및 삭제
    $(document).on("click", "#cart_sel_option li button", function() {
        var $this = $(this),
            mode = $this.val(),
            this_qty, max_qty = 9999, min_qty = 1,
            $el_qty = $(this).closest("li").find("input[name^=ct_qty]"),
            stock = parseInt($(this).closest("li").find("input.io_stock").val());

        switch(mode) {
            case "1":
                this_qty = parseInt($el_qty.val().replace(/[^0-9]/, "")) + 1;
                if(this_qty > stock) {
					na_alert('재고수량 보다 많은 수량을 구매할 수 없습니다.');
                    this_qty = stock;
                }

                if(this_qty > max_qty) {
                    this_qty = max_qty;
					na_alert('최대 구매수량은 '+number_format(String(max_qty))+' 입니다.');
                }

                $el_qty.val(this_qty);
                $this.trigger("cart_sel_option_success", [$this, mode, this_qty]);
                cart_price_calculate();
                break;

            case "2":
                this_qty = parseInt($el_qty.val().replace(/[^0-9]/, "")) - 1;
                if(this_qty < min_qty) {
                    this_qty = min_qty;
					na_alert('최소 구매수량은 '+number_format(String(min_qty))+' 입니다.');
                }
                $el_qty.val(this_qty);
                $this.trigger("cart_sel_option_success", [$this, mode, this_qty]);
                cart_price_calculate();
                break;

            case "3":
				na_confirm('선택하신 옵션항목을 삭제하시겠습니까?', function() {
					var $el = $this.closest("li");
					var del_exec = true;

					if($("#cart_sel_option .cart_spl_list").length > 0) {
						// 선택옵션이 하나이상인지
						if($el.hasClass("cart_opt_list")) {
							if($(".cart_opt_list").length <= 1)
								del_exec = false;
						}
					}

					if(del_exec) {
						// 지우기전에 호출해야 trigger 를 호출해야 합니다.
						$this.trigger("cart_sel_option_success", [$this, mode, ""]);
						$el.closest("li").remove();
						cart_price_calculate();
					} else {
						na_alert('선택옵션은 하나이상이어야 합니다.');
						return false;
					}
				});
				return false;
                break;

            default:
				na_alert('올바른 방법으로 이용해 주십시오.');
                break;
        }
    });

    // 수량직접입력
    $(document).on("keyup", "input[name^=ct_qty]", function() {
        var $this = $(this),
            val= $this.val(),
            force_val = 0;

        if(val != "") {
            if(val.replace(/[0-9]/g, "").length > 0) {
				na_alert('수량은 숫자만 입력해 주십시오.');
                force_val = 1;
                $(this).val(force_val);
            } else {
                var d_val = parseInt(val);
                if(d_val < 1 || d_val > 9999) {
					na_alert('수량은 1에서 9999 사이의 값으로 입력해 주십시오.');
                    force_val = 1;
                    $(this).val(force_val);
                } else {
                    var stock = parseInt($(this).closest("li").find("input.io_stock").val());
                    if(d_val > stock) {
						na_alert('재고수량 보다 많은 수량을 구매할 수 없습니다.');
                        force_val = stock;
                        $(this).val(force_val);
                    }
                }
            }
            
            $this.trigger("cart_change_option_qty", [$this, val, force_val]);

            cart_price_calculate();
        }
    });
});

// 선택옵션 추가처리
function cart_sel_option_process(add_exec)
{
    var item_price = parseInt($("input#item_price").val());
    var id = "";
    var value, info, sel_opt, item, price, stock, run_error = false;
    var option = sep = "";
    info = $("select.item_option:last").val().split(",");

    $("select.item_option").each(function(index) {

        value = $(this).val();
        item = $(this).closest(".get_item_options").length ? $(this).closest(".get_item_options").find("label[for^=item_option]").text() : "";
        
        if( !item ){
            item = $(this).closest("tr").length ? $(this).closest("tr").find("th label").text() : "";
        }

        if(!value) {
            run_error = true;
            return false;
        }

        // 옵션선택정보
        sel_opt = value.split(",")[0];

        if(id == "") {
            id = sel_opt;
        } else {
            id += cart_chr(30)+sel_opt;
            sep = " / ";
        }

        option += sep + item + ":" + sel_opt;
    });

    if(run_error) {
		na_alert(item+'을(를) 선택해 주십시오.');
        return false;
    }

    price = info[1];
    stock = info[2];

    // 금액 음수 체크
    if(item_price + parseInt(price) < 0) {
		na_alert('구매금액이 음수인 상품은 구매할 수 없습니다.');
        return false;
    }

    if(add_exec) {
        if(cart_same_option_check(option))
            return;

        cart_add_sel_option(0, id, option, price, stock);
    }
}

// 추가옵션 추가처리
function cart_sel_supply_process($el, add_exec)
{
    if( $el.triggerHandler( 'shop_cart_sel_supply_process',{add_exec:add_exec} ) !== false ){
        var val = $el.val();
        var item = $el.closest(".get_item_supply").length ? $el.closest(".get_item_supply").find("label[for^=item_supply]").text() : "";
        
        if( !item ){
            item = $el.closest("tr").length ? $el.closest("tr").find("th label").text() : "";
        }

        if(!val) {
			na_alert(item+'을(를) 선택해 주십시오.');
            return;
        }

        var info = val.split(",");

        // 재고체크
        if(parseInt(info[2]) < 1) {
			na_alert(info[0]+'은(는) 재고가 부족하여 구매할 수 없습니다.');
            return false;
        }

        var id = item+cart_chr(30)+info[0];
        var option = item+":"+info[0];
        var price = info[1];
        var stock = info[2];

        // 금액 음수 체크
        if(parseInt(price) < 0) {
			na_alert('구매금액이 음수인 상품은 구매할 수 없습니다.');
            return false;
        }

        if(add_exec) {
            if(cart_same_option_check(option))
                return;

            cart_add_sel_option(1, id, option, price, stock);
        }
    }
}

// 선택된 옵션 출력
function cart_add_sel_option(type, id, option, price, stock)
{
    var item_code = $("input[name='it_id[]']").val();
    var opt = "";
    var li_class = "cart_opt_list";
    if(type)
        li_class = "cart_spl_list";

    var opt_prc;
    if(parseInt(price) >= 0)
        opt_prc = "(+"+number_format(String(price))+"원)";
    else
        opt_prc = "("+number_format(String(price))+"원)";

    opt += "<li class=\"list-group-item "+li_class+"\">";
    opt += "<input type=\"hidden\" name=\"io_type["+item_code+"][]\" value=\""+type+"\">";
    opt += "<input type=\"hidden\" name=\"io_id["+item_code+"][]\" value=\""+id+"\">";
    opt += "<input type=\"hidden\" name=\"io_value["+item_code+"][]\" value=\""+option+"\">";
    opt += "<input type=\"hidden\" class=\"io_price\" value=\""+price+"\">";
    opt += "<input type=\"hidden\" class=\"io_stock\" value=\""+stock+"\">";
    opt += "<span class=\"cart_opt_subj\">"+option+"</span>";
    opt += "<span class=\"cart_opt_prc\">"+opt_prc+"</span>";
    opt += "<div class=\"input-group mt-1\"><input type=\"text\" name=\"ct_qty["+item_code+"][]\" value=\"1\" class=\"form-control\">";
    opt += "<button type=\"button\" class=\"btn btn-basic cart_qty_plus\" title=\"증가\" value=\"1\"><i class=\"bi bi-plus-lg\"></i></button>";
    opt += "<button type=\"button\" class=\"btn btn-basic cart_qty_minus\" title=\"감소\" value=\"2\"><i class=\"bi bi-dash-lg\"></i></button>";
    opt += "<button type=\"button\" class=\"btn btn-basic cart_opt_del\" title=\"삭제\" value=\"3\"><i class=\"bi bi-x-lg\"></i></button></div>";
    opt += "</li>";

    if($("#cart_sel_option > ul").length < 1) {
        $("#cart_sel_option").html("<ul id=\"cart_opt_added\" class=\"list-group list-group-flush border-bottom\"></ul>");
        $("#cart_sel_option > ul").html(opt);
    } else{
        if(type) {
            if($("#cart_sel_option .cart_spl_list").length > 0) {
                $("#cart_sel_option .cart_spl_list:last").after(opt);
            } else {
                if($("#cart_sel_option .cart_opt_list").length > 0) {
                    $("#cart_sel_option .cart_opt_list:last").after(opt);
                } else {
                    $("#cart_sel_option > ul").html(opt);
                }
            }
        } else {
            if($("#cart_sel_option .cart_opt_list").length > 0) {
                $("#cart_sel_option .cart_opt_list:last").after(opt);
            } else {
                if($("#cart_sel_option .cart_spl_list").length > 0) {
                    $("#cart_sel_option .cart_spl_list:first").before(opt);
                } else {
                    $("#cart_sel_option > ul").html(opt);
                }
            }
        }
    }

    cart_price_calculate();

    $("#cart_sel_option").trigger("add_cart_sel_option", [opt]);
}

// 동일선택옵션있는지
function cart_same_option_check(val)
{
    var result = false;
    $("input[name^=io_value]").each(function() {
        if(val == $(this).val()) {
            result = true;
            return false;
        }
    });

    if(result)
		na_alert(val+'은(는) 이미 추가하신 옵션상품입니다.');

    return result;
}

// 가격계산
function cart_price_calculate() {
    var item_price = parseInt($("input#item_price").val());

    if(isNaN(item_price))
        return;

    var $el_prc = $("input.io_price");
    var $el_qty = $("input[name^=ct_qty]");
    var $el_type = $("input[name^=io_type]");
    var price, type, qty, total = 0;

    $el_prc.each(function(index) {
        price = parseInt($(this).val());
        qty = parseInt($el_qty.eq(index).val());
        type = $el_type.eq(index).val();

        if(type == "0") { // 선택옵션
            total += (item_price + price) * qty;
        } else { // 추가옵션
            total += price * qty;
        }
    });

    $("#cart_tot_price").empty().html("총 금액 : <strong>"+number_format(String(total))+"</strong> 원");

    $("#cart_tot_price").trigger("cart_price_calculate", [total]);
}

// php cart_chr() 대응
function cart_chr(code) {
    return String.fromCharCode(code);
}

// 위시리스트
function na_wishlist(it_id) {

	if(!g5_is_member || !it_id) {
		na_alert('회원만 가능합니다.');
		return false;
	}

	var	href = na_url + '/shop.wishlist.php?it_id=' + it_id;

	na_confirm('위시리스트에 등록하시겠습니까?', function() {
		$.post(href, function(data) {
			if(data.error) {
				na_alert(data.error);
			} else if(data.success) {
				na_alert(data.success, function() { 
					const myWishOffcanvas = new bootstrap.Offcanvas('#wishlistOffcanvas');
					myWishOffcanvas.show();
				});
			}
		}, "json");
	});

	return false;
}

// 장바구니
function na_cart(it_id) {

	$.ajax({
		url: na_url + "/shop.cartbuy.php",
		type: "POST",
		data: { "it_id" : it_id },
		dataType: "json",
		async: true,
		cache: false,
		success: function(data, textStatus) {
			if(data.error) {
				na_alert(data.error);
				return false;
			} else {
				$("#cartFormOffcanvasContent").html(data.html);
				
				cart_price_calculate();

				$('#cartFormOffcanvas').offcanvas('show');
			}
		},
		error : function(request, status, error){
			let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
			na_alert(msg);
		}
	});

	return false;
}

function fcartItem_check(f, pressed) {

    if (pressed == "1") {
        f.sw_direct.value = 0;
    } else { // 바로구매
        f.sw_direct.value = 1;
    }

    // 판매가격이 0 보다 작다면
    if (document.getElementById("item_price").value < 0) {
		na_alert('전화로 문의해 주시면 감사하겠습니다.');
        return false;
    }

    if($(".cart_opt_list").length < 1) {
		na_alert('상품의 선택옵션을 선택해 주십시오.');
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(document.getElementById("item_min_qty").value);
    var max_qty = parseInt(document.getElementById("item_max_qty").value);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
			na_alert('수량을 입력해 주십시오.');
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
			na_alert('수량은 숫자로 입력해 주십시오.');
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
			na_alert('수량은 1이상 입력해 주십시오.');
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
		na_alert('선택옵션 개수 총합 '+number_format(String(min_qty))+'개 이상 주문해 주십시오.');
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
		na_alert('선택옵션 개수 총합 '+number_format(String(max_qty))+'개 이하로 주문해 주십시오.');
        return false;
    }

    if (pressed == "1") {

		f.action.value = 'cart_update';

		$.ajax({
            url: g5_shop_url + '/ajax.action.php',
            type: "POST",
            data: $("#fcartForm").serialize(),
            dataType: "json",
            async: true,
            cache: false,
            success: function(data, textStatus) {
                if(data.error) {
					na_alert(data.error);
					return false;
				} else {
					na_alert('상품을 장바구니에 담았습니다.');
				}
            },
            error : function(request, status, error){
				let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
				na_alert(msg);
			}
        });

	    return false;
	} else {
	    f.action = g5_shop_url + "/cartupdate.php";
	    f.target = "";
		f.submit();
	}

    return false;
}