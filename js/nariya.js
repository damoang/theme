/* 
2019-01-15 Version 0.2 Mady by Vorfeed 
https://sir.kr/g5_plugin/5184
Modified by Graysmile
*/

function youtube(t) {
    //var e = [/<a [^>]*?href="(https?:\/\/youtu.be\/([a-zA-Z0-9\-_\/\?\=\&\&amp;]+))"[^>]*>/gi, /<a [^>]*?href="(https?:\/\/www.youtube.com\/watch\?v=([a-zA-Z0-9\-_\/\?\=\&\&amp;]+))"[^>]*>/gi];
    // for (var i in e) {
    //     for (var a = t.$element.html();;) {
	// 		//var o = e[i].exec(a);
    //         // if (null == (o = e[i].exec(a))) {}
	// 		// 	break;
	// 		var o;
    //         if (null == (o = e[i].exec(a))) 
	// 			break;
    //         var r = o[1];
    //         a = a.replace(o[0], "")
    //     }
    //     t.$element.html(a)
    // }
	auto_link_del(t, /<a [^>]*?href="(https?:\/\/youtu.be\/([a-zA-Z0-9\-_\/\?\=\&\&amp;]+))"[^>]*>/gi);
	auto_link_del(t, /<a [^>]*?href="(https?:\/\/www.youtube.com\/watch\?v=([a-zA-Z0-9\-_\/\?\=\&\&amp;]+))"[^>]*>/gi);
    
    var n = [/https?:\/\/youtu.be\/([a-zA-Z0-9\-_\/\?\=\&\&amp;]+)/gi, /https?:\/\/www.youtube.com\/watch\?v=([a-zA-Z0-9\-_\/\?\=\&\&amp;]+)/gi],
        l = '<div class="ratio ratio-16x9"><iframe src="//www.youtube.com/embed/#[CODE]" frameborder="0" width="640" height="360" allowfullscreen></iframe></div>';
    for (var i in n) {
        for (a = t.$element.html();;) {
            var o;
            if (null == (o = n[i].exec(a))) 
				break;
            r = o[1];
			r= r.replace('t=','start=');
            a = a.replace(o[0], l.replace("#[CODE]", r))
        }
        t.$element.html(a)
    }
}

function instargram(t) {
    auto_link_del(t, /<a [^>]*?href="(https?:\/\/www\.)?instagram\.com(\/p\/\w+\/?)"[^>]*>/gi);
    for (var e = /(https?:\/\/www\.)?instagram\.com(\/p\/\w+\/?)/gi, i = (t.$element.html().match(e) || []).length, a = t.$element.html(), r = '<blockquote width="510" height="315" class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instargram.com#[CODE]" data-instgrm-version="8"></blockquote>', n = 0; n < i; n++) {
        var l = e.exec(a);
        if (null == l) break;
        var o = l[2];
        a = a.replace(l[0], r.replace("#[CODE]", o)), t.$element.html(a + '<script async defer src="//www.instagram.com/embed.js"><\/script>')
    }
}

function KakaoPot(t) {
    auto_link_del(t, /<a [^>]*?href="(https?:\/\/|www\.)tv.kakao.com\/channel\/[0-9]+\/(livelink|cliplink)\/([A-Za-z0-9]+)"[^>]*>/gi);
    for (var e = /(https?:\/\/|www\.)tv.kakao.com\/channel\/[0-9]+\/(livelink|cliplink)\/([A-Za-z0-9]+)/gi, i = (t.$element.html().match(e) || []).length, a = t.$element.html(), r = '<div class="ratio ratio-16x9"><iframe width="604" height="360" src="https://tv.kakao.com/embed/player/#[CODE]?width=640&height=360&service=kakao_tv" frameborder="0" scrolling="no" ></iframe></div>', n = 0; n < i; n++) {
        var l = e.exec(a);
        if (null == l) break;
        var o = l[2] + "/" + l[3];
        a = a.replace(l[0], r.replace("#[CODE]", o)), t.$element.html(a)
    }
}

function Twitter(t) {
    auto_link_del(t, /<a [^>]*?href="http(s)?:\/\/(.*\.)?(twitter|x)\.com\/(\w+)\/?status\/(\w+)"[^>]*>/gi);
    for (var e = /http(s)?:\/\/(.*\.)?(twitter|x)\.com\/(\w+)\/?status\/(\w+)/gi, i = (t.$element.html().match(e) || []).length, a = t.$element.html(), r = 0; r < i; r++) {
        var n = e.exec(a),
            l = n[4] + "/status/" + n[5];
        a = a.replace(n[0], "<blockquote class='twitter-tweet' data-lang='ko'><a href='//twitter.com/#[CODE]' style='text-decoration:none;'><span style='font-size:15px;text-decoration:none;'></blockquote>".replace("#[CODE]", l))
		t.$element.html(a + "<script async src='//platform.twitter.com/widgets.js' charset='utf-8'><\/script>")
	}
}

function Vimeo(t) {
    auto_link_del(t, /<a [^>]*?href="(https?:\/\/|www\.)vimeo.com\/([A-Za-z0-9]+)"[^>]*>/gi);
    for (var e = /(https?:\/\/|www\.)vimeo.com\/([A-Za-z0-9]+)/gi, i = (t.$element.html().match(e) || []).length, a = t.$element.html(), r = '<div class="ratio ratio-16x9"><iframe src="https://player.vimeo.com/video/#[CODE]" width="717" height="403" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>', n = 0; n < i; n++) {
        var l = e.exec(a),
            o = l[2];
        a = a.replace(l[0], r.replace("#[CODE]", o))
    }
}

function Dailymotion(t) {
    auto_link_del(t, /<a [^>]*?href="(https?:\/\/www\.)dailymotion.com\/video\/([A-Za-z0-9]+)"[^>]*>/gi);
    for (var e = /(https?:\/\/www\.)dailymotion.com\/video\/([A-Za-z0-9]+)/gi, i = (t.$element.html().match(e) || []).length, a = t.$element.html(), r = '<div class="ratio ratio-16x9"><iframe frameborder="0" width="640" height="360" src="//www.dailymotion.com/embed/video/#[CODE]" allowfullscreen="" allow="autoplay"></iframe></div>', n = 0; n < i; n++) {
        var l = e.exec(a),
            o = l[2];
        a = a.replace(l[0], r.replace("#[CODE]", o))
	}
}

function auto_link_del(t, e) {
    for (var i = t.$element.html(), a = (i.match(e) || []).length, r = 0; r < a*2; r++) {
        var n = e.exec(i);
		if(n == null || n[0] == null) continue;
        i = i.replace(n[0], "")
    }
    t.$element.html(i)
}! function(i) {
    var e = "naGnuView",
        a = { youtube: !0, instargram: !0, kakao: !0, twitter: !0, vimeo: !0, dailymotion: !0 };

    function r(t, e) {
        this.element = t, this.$element = i(t), this.settings = i.extend({}, a, e), this.init()
    }
    i.extend(r.prototype, {
        init: function() {
            this.settings.youtube && youtube(this), 
			this.settings.instargram && instargram(this), 
			this.settings.kakao && KakaoPot(this), 
			this.settings.twitter && Twitter(this), 
			this.settings.vimeo && Vimeo(this), 
			this.settings.dailymotion && Dailymotion(this)
        }
    }), i[e] = i.fn[e] = function(t) {
        return this.each(function() {
            i.data(this, "plugin_" + e) || i.data(this, "plugin_" + e, new r(this, t))
        })
    }, i.fn[e].defaults = a
}(jQuery, window, document), $(function() {
    $(".na-convert").naGnuView();
});

// SweetAlert2 Check Text
var na_br = function (text) {
	return text.replace(/(?:\r\n|\r|\n)/g, '<br>');
}

// SweetAlert2 Alert Dialog
var na_alert = function (text, callback, time = 0) {
	Swal.fire({
		html: na_br(text),
		timer: time,
		backdrop: false,
		allowOutsideClick: false,
		didClose: () => {
			if (callback) { callback(); }
		}
	});
};

// SweetAlert2 Confirm Dialog
var na_confirm = function (text, callback, fallback) {
	Swal.fire({
		html: na_br(text),
		backdrop: false,
		showCancelButton: true,
		allowOutsideClick: false,
	}).then(function (result) {
		if (result.isConfirmed) {
			if (callback) { callback(); }
		} else if (result.isDismissed) {
			if (fallback) { fallback(); }
		}
	});
};

// Submit 할 때 폼속성 검사
function na_wrestSubmit(f) {
    wrestMsg = "";
    wrestFld = null;

    var attr = null;

    // 해당폼에 대한 요소의 개수만큼 돌려라
    for (var i=0; i<f.elements.length; i++) {
        var el = f.elements[i];

        // Input tag 의 type 이 text, file, password 일때만
        // 셀렉트 박스일때도 필수 선택 검사합니다. select-one
        if (el.type=="text" || el.type=="hidden" || el.type=="file" || el.type=="password" || el.type=="select-one" || el.type=="textarea") {
            if (el.getAttribute("required") != null) {
                wrestRequired(el);
            }

            if (el.getAttribute("minlength") != null) {
                wrestMinLength(el);
            }

            var array_css = el.className.split(" "); // class 를 공백으로 나눔

            el.style.backgroundColor = wrestFldDefaultColor;

            // 배열의 길이만큼 돌려라
            for (var k=0; k<array_css.length; k++) {
                var css = array_css[k];
                switch (css) {
                    case "required"     : wrestRequired(el); break;
                    case "trim"         : wrestTrim(el); break;
                    case "email"        : wrestEmail(el); break;
                    case "hangul"       : wrestHangul(el); break;
                    case "hangul2"      : wrestHangul2(el); break;
                    case "hangulalpha"  : wrestHangulAlpha(el); break;
                    case "hangulalnum"  : wrestHangulAlNum(el); break;
                    case "nospace"      : wrestNospace(el); break;
                    case "numeric"      : wrestNumeric(el); break;
                    case "alpha"        : wrestAlpha(el); break;
                    case "alnum"        : wrestAlNum(el); break;
                    case "alnum_"       : wrestAlNum_(el); break;
                    case "telnum"       : wrestTelNum(el); break; // 김선용 2006.3 - 전화번호 형식 검사
                    case "imgext"       : wrestImgExt(el); break;
                    default :
                        if (/^extension\=/.test(css)) {
                            wrestExtension(el, css); break;
                        }
                } // switch (css)
            } // for (k)
        } // if (el)
    } // for (i)

    // 필드가 null 이 아니라면 오류메세지 출력후 포커스를 해당 오류 필드로 옮김
    // 오류 필드는 배경색상을 바꾼다.
    if (wrestFld != null) {
        // 경고메세지 출력
		na_alert(wrestMsg, 0, function() {
			if (wrestFld.style.display != "none") {
				var id = wrestFld.getAttribute("id");

				// 오류메세지를 위한 element 추가
				var msg_el = document.createElement("strong");
				msg_el.id = "msg_"+id;
				msg_el.className = "msg_sound_only";
				msg_el.innerHTML = wrestMsg;
				wrestFld.parentNode.insertBefore(msg_el, wrestFld);

				var new_href = document.location.href.replace(/#msg.+$/, "")+"#msg_"+id;

				document.location.href = new_href;

				//wrestFld.style.backgroundColor = wrestFldBackColor;
				if (typeof(wrestFld.select) != "undefined")
					wrestFld.select();
				wrestFld.focus();
			}
		});

		return false;
    }

    return true;
}

// 오프캔버스
function naClipClose() {
	$('#naClip').offcanvas('hide');
}

function naClipHeight() {
	let naClipContent = document.getElementById('naClipContent');
	if(naClipContent) {
		let height = $('#naClip').height() - $('#naClip .offcanvas-header').height() - 60;
		naClipContent.style.height = height + "px";
	}
}

function naClipView(url) {

	$("#naClipView").html('<iframe id="naClipContent" src="'+url+'" class="w-100 overflow-x-hidden overflow-y-auto" frameborder="0">');

	$('#naClip').offcanvas('show');

	naClipHeight();
}

// 추천
function na_good(bo_table, wr_id, act, id, opt) {

	var	href = na_url + '/good.php?bo_table=' + bo_table + '&wr_id=' + wr_id + '&good=' + act;
	if(opt) {
		href += '&opt=1';
	}
	$.post(href, function(data) {
		if(data.error) {
			na_alert(data.error, function(){}, 2500);
			return false;
		} else if(data.success) {
			//na_alert(data.success, function(){
				$("#"+id).text(number_format(String(data.count)));
				if($("."+id+'_cnt').length) {
					$("."+id+'_cnt').text(number_format(String(data.count)));
				}

				if ($("#"+id).parent().hasClass('btn-basic')) {
					$("#"+id).parent().removeClass('btn-basic').addClass('btn-primary');
				} else {
					$("#"+id).parent().removeClass('btn-primary').addClass('btn-basic');
				}
			//}, 2500);
		}
	}, "json");
}

function na_page(id, url, opt) {

	$("#" + id).load(url, function() {
		if(typeof is_SyntaxHighlighter != 'undefined'){
			Prism.highlightAll();
		}

		$(".na-convert").naGnuView();
	});

	if(typeof(window["comment_box"]) == "function"){
		switch(id) {
			case 'itemcomment'	: comment_box('', 'c'); break;
			case 'viewcomment'	: comment_box('', 'c'); break;
		}

		document.getElementById("btn_submit").disabled = false;
	}

	if(opt) {
	   $('html, body').animate({
			scrollTop: $("#" + id).offset().top - 60
		}, 500);
	}
}

// 새로운 댓글 체크
function na_comment_new(id, url, count) {
	var href = url + '&count=' + count + '&cnew=1';
	$.post(href, function(data) {
		if(data) {
			//  댓글 새로 고침
			// na_alert(data);
			return false;
		} else {
			na_page(id, url);
		}
	});
}

// 댓글 삭제
function na_delete(id, href, url) {

	let msg = '한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?';

	na_confirm(msg, function() {
		$.post(href, function(data) {
			if(data) {
				na_alert(data);
			} else {
				na_page(id, url); 
			}
		});
	});
	return false;
}

// 페이징 댓글
function na_comment(id) {
	var str;
	var c_url;
	if(id == 'viewcomment') {
		c_url = na_url + '/comment.write.php';
	} else {
		c_url = na_url + '/comment.item.write.php';
	}

	var f = document.getElementById("fviewcomment");
	var url = document.getElementById("comment_url").value;

	if(na_wrestSubmit(f)) {
		if (fviewcomment_submit(f)) {
			$.ajax({
				url : c_url,
				type : 'POST',
				cache : false,
				data : $("#fviewcomment").serialize(),
				dataType : "html",
				success : function(data) {
					if(data) {
						na_alert(data);
						return false;
					} else {
						if(url) {
							na_page(id, url);
						}

						document.getElementById("btn_submit").disabled = false;

						document.getElementById("wr_content").value = "";
						if(!g5_is_member) {
							$("#captcha_reload").trigger("click");
							$("#captcha_key").val('');
						}
					}
				},
				error : function(request,status,error){
					let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
					na_alert(msg);
					return false;
				}
			});
		}
	}
}

// 페이징 댓글 submit
function na_comment_submit() {
	var f = document.getElementById("fviewcomment");
	if (na_wrestSubmit(f)) {
		if (fviewcomment_submit(f)) {
			$("#fviewcomment").submit();
			if(!g5_is_member) {
				$("#captcha_reload").trigger("click");
				$("#captcha_key").val('');
			}
		}
	}

	return false;
}

function na_comment_onKeyDown(opt) {
	if(event.keyCode == 13) {
		if(opt) {
			na_comment('viewcomment');
		} else {
			na_comment_submit();
		}
	}
}

// 페이징 댓글 정렬
function na_comment_sort(id, url, sort) {
	var href = url + '&page=0&cob=' + sort;

	na_page(id, href);
}

// 차단
function na_chadan(mb_id) {

	if(!g5_is_member || !mb_id) {
		na_alert('회원만 차단할 수 있습니다.');
		return false;
	}

	let	href = na_url + '/chadan.php?mb=' + mb_id;

	let msg = '해당 회원을 차단하시겠습니까?\n\n차단시 게시판에서 해당 회원의 게시물과 쪽지는 자신에게 노출되지 않습니다.';

	na_confirm(msg, function() {
		$.post(href, function(data) {
			if(data.error) {
				na_alert(data.error);
			} else if(data.success) {
				na_alert(data.error, function() {
					location.reload(true);					
				});
			}
		}, "json");
	});

	return false;
}

// 신고
function na_singo(sg_table, sg_id, sg_flag, sg_hid) {

	if(g5_is_member) {
		singoModal.show();
		document.getElementById("sg_table").value	= sg_table;
		document.getElementById("sg_id").value		= sg_id;
		document.getElementById("sg_flag").value	= sg_flag;
		document.getElementById("sg_hid").value		= sg_hid;
		document.getElementById("sg_type").value	= '';
	} else {
		na_alert('로그인한 회원만 신고할 수 있습니다.');
	}

	return false;
}

function na_singo_submit() {

	var f = document.getElementById("fsingoForm");

	if (f.sg_type.value == '') {
		na_alert('신고 사유를 선택해 주세요.', function() {
			f.sg_type.focus();
		});
	} else {
		$.ajax({
			url : na_url + '/singo.php',
			type : 'POST',
			cache : false,
			data : $("#fsingoForm").serialize(),
			dataType : "json",
			success : function(data) {
				if(data.error) {
					na_alert(data.error);
				} else if(data.success) {
					na_alert(data.success, function() {

						singoModal.hide();

						var sg_hid = $('#sg_hid').val();

						if(sg_hid) {
							$('#'+sg_hid).hide();
						} else {
							location.reload(true);
						}						
					});
				}
			},
			error : function(request,status,error){
				let msg = "code:"+request.status+"<br>"+"message:"+request.responseText+"<br>"+"error:"+error;
				na_alert(msg);
			}
		});
	}
	return false;
}

// SNS
function na_sns(id, url) {
	switch(id) {
		case 'facebook'		: window.open(url, "win_facebook", "menubar=0,resizable=1,width=600,height=400"); break;
		case 'twitter'		: window.open(url, "win_twitter", "menubar=0,resizable=1,width=600,height=400"); break;
		case 'naverband'	: window.open(url, "win_naverband", "menubar=0,resizable=1,width=410,height=540"); break;
		case 'naver'		: window.open(url, "win_naver", "menubar=0,resizable=1,width=450,height=540"); break;
		case 'tumblr'		: window.open(url, "win_tumblr", "menubar=0,resizable=1,width=540,height=600"); break;
		case 'pinterest'	: window.open(url, "win_pinterest", "menubar=0,resizable=1,width=800,height=500"); break;
	}
    return false;
}

// 페이지 이동
function na_href(url, target) {
	if(target == '' || target == '_self') {
		window.location.href = url;
	} else {
		window.open(url);
	}
	return false;
}

function na_sns_share(text, url, image) {

	// 태그, 따옴표 제거
	text.replace(/<[^>]*>?/g, '');
	text.replace(/\"/gi, '');
	text.replace(/\'/gi, '');

	var sns_href;
	var sns_send  = na_url + '/sns.php?longurl='+encodeURIComponent(url)+'&amp;title='+encodeURIComponent(text)+'&amp;img='+encodeURIComponent(image);
	var sns_icon = na_url + '/img/sns';

	var sns_type = ['facebook', 'twitter', 'kakaotalk', 'naverband', 'naver', 'tumblr', 'pinterest'];
	var sns_name = ['페이스북', '트위터', '카카오톡', '네이버밴드', '네이버', '텀블러', '핀트레스트']; 

	var sns_str = '';
	for (var i = 0; i < sns_type.length; i++) {

		sns_href = sns_send + '&amp;sns=' + sns_type[i];
		
		if(sns_type[i] == 'kakaotalk') {
			//if (typeof(Kakao) != "undefined") {
			if (window.Kakao && (kakao_javascript_apikey !== undefined)) {
				sns_str += '<a href="' + sns_href + '" onclick="kakaolink_send(\'' + text + '\',\'' + url + '\',\'' + image + '\'); return false;" target="_blank">';
				sns_str += '<img src="' + sns_icon + '/' + sns_type[i] + '.png" alt="' + sns_name[i] + '" class="rounded-circle mx-1"></a>';
			}
		} else {
			sns_str += '<a href="' + sns_href + '" onclick="na_sns(\'' + sns_type[i] + '\',\'' + sns_href + '\'); return false;" target="_blank">';
			sns_str += '<img src="' + sns_icon + '/' + sns_type[i] + '.png" alt="' + sns_name[i] + '" class="rounded-circle m-1"></a>';
		}
	}

	$("#snsIconModalContent").html(sns_str);
	$("#snsUrlModal").val(url);

	snsIconModal.show();

	return false;
}

$(function(){

	var snsClipBoard = new ClipboardJS('.sns-copy');

	snsClipBoard.on('success', function() {
		let msg = '주소 복사가 되었으니 Ctrl + V 를 눌러 붙여넣기해 주세요.'; 
		na_alert(msg, function() {
			$('#snsIconModal').modal('hide');
		});
	});

	snsClipBoard.on('error', function() {
		let msg = '주소 복사가 안되었으니 Ctrl + C 를 눌러 복사해 주세요.'; 
		na_alert(msg);
	});

	$(document).on('click', '.widget-setup', function() {
		var wsetup = $('.btn-wset');
		if(wsetup.is(":visible")){
			wsetup.hide();
		} else {
			wsetup.show();
		}

		return false;
	});

	$(document).on('click', '.auto-login', function(){

		if($('.auto-login').is(":checked")) {

			let msg = "자동로그인을 사용하시면 다음부터 회원아이디와 패스워드를 입력하실 필요가 없습니다.\n그러나 공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?";

			na_confirm(msg, function() {
				$('.auto-login').prop('checked',true);
			});
			return false;
		}
    });

	$(document).on('click', 'a.view_image', function(){
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

	$('[data-bs-toggle="popover"]').popover();

	$('[data-bs-toggle="tooltip"]').tooltip();

	if(g5_is_mobile) {
		
		$('[data-bs-toggle="tooltip"]').tooltip('disable');

	} else if (0) {
		let debounceTimeout;
		function debounce(func, delay) {
			clearTimeout(debounceTimeout);
			debounceTimeout = setTimeout(func, delay);
		}

		$('[data-bs-toggle="popover-img"]:not([data-popover-initialized])').hover(function () {

			var $element = $(this);
			if ($element.data('bs-popover-disabled')) {
				return;
			}
			debounce(function() {
				$element.attr('data-popover-initialized', true);
				$element.popover({
					html: true,
					trigger: 'hover',
					placement: 'left',
					content: function () {
						return '<div class="rounded overflow-hidden" style="max-height:200px;">' +
							'<img src="' + $element.data('img') + '" class="w-100"/></div>';
					}
				}).popover('show');
			}, 500); //썸네일 뜨는 시간 ms
		});

		$(document).on("mouseleave", '[data-bs-toggle="popover-img"]', function () {
			clearTimeout(debounceTimeout);
		});
	}

	window.addEventListener("resize", naClipHeight);

	document.getElementById('naClip').addEventListener('hide.bs.offcanvas', event => {
		$("#naclipView").html('');
	});
});
