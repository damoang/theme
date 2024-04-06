$(function(){

	// 상단 네비바
    var is_scroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $("#header-navbar").outerHeight();

	$(window).on('scroll', function(){
        is_scroll = true;
    });

    setInterval(function() {
        if (is_scroll) {
            na_navbar();
            is_scroll = false;
        }
    }, 250); // 스크롤이 멈춘 후 동작이 실행되기 까지의 딜레이

	function na_navbar() {
		var nstv = $(this).scrollTop(); // 현재 window의 scrollTop 값

		// delta로 설정한 값보다 많이 스크롤 되어야 실행된다.
		if(Math.abs(lastScrollTop - nstv) <= delta)
			return;

		if (nstv > lastScrollTop && nstv > navbarHeight){
			// 스크롤을 내렸을 때
			$("#header-navbar").slideUp("fast"); // 숨기기
		} else {
			// 스크롤을 올렸을 때
			if(nstv + $(window).height() < $(document).height()) {
				$("#header-navbar").slideDown("fast"); // 보이기
			}
		}

		lastScrollTop = nstv; // 현재 멈춘 위치를 기준점으로 재설정
	}

	// 상단 진행바
	var pageProgress = '<div id="page-progress"></div>';

	$('body').append(pageProgress);

	$(window).on('scroll', function(){
		var currentPercentage = ($(window).scrollTop() / ($(document).outerHeight() - $(window).height())) * 100;
		$('#page-progress').width(currentPercentage+'%');

		if ($(this).scrollTop() > 150) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});

	// 상단 이동버튼
	$('#toTop a').on('click', function () {
		$('body, html').animate({ scrollTop: 0 }, 500);
		return false;
    });
});
