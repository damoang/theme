document.addEventListener('DOMContentLoaded', function () {
  // 상단 네비바
  var is_scroll;
  var lastScrollTop = 0;
  var delta = 5;
  var navbar = document.getElementById('header-navbar');
  var navbarHeight = navbar.offsetHeight;

  window.addEventListener('scroll', function () {
    if (is_scroll) return;
    is_scroll = true;
    setTimeout(function () {
      is_scroll = false;
      na_navbar();
    }, 500);
  });

  function na_navbar() {
    var nst = window.pageYOffset; // 현재 window의 scrollTop 값

    // delta로 설정한 값보다 많이 스크롤 되어야 실행된다.
    if (Math.abs(lastScrollTop - nst) <= delta) return;

    if (nst > lastScrollTop && nst > navbarHeight) {
      // 스크롤을 내렸을 때
      navbar.style.display = 'none'; // 숨기기
    } else {
      // 스크롤을 올렸을 때
      if (nst + window.innerHeight < document.body.scrollHeight) {
        navbar.style.display = 'block'; // 보이기
      }
    }

    lastScrollTop = nst; // 현재 멈춘 위치를 기준점으로 재설정
  }

  // 상단 이동버튼
  var toTop = document.getElementById('toTop');
  window.addEventListener('scroll', function () {
    if (window.pageYOffset > 150) {
      toTop.style.display = 'block';
    } else {
      toTop.style.display = 'none';
    }
  });

  document.querySelector('#toTop a').addEventListener('click', function (e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
});

$(function ($) {
  // 소셜로그인 로그인 유지 쿠키
  if (get_cookie('sociallogin_remeber') === 'true') {
    document.cookie = 'sociallogin_remeber=false; path=/; max-age=0;';
  }
  $('.sociallogin_remeber').on('change', function (e) {
    const checked = $(e.target).prop('checked');
    $('.sociallogin_remeber').prop('checked', checked);
    if (checked) {
      document.cookie = 'sociallogin_remeber=true; path=/; secure';
      if (window.g5_cookie_domain) {
        document.cookie += `domain=${window.g5_cookie_domain};`;
      }
    } else {
      document.cookie = 'sociallogin_remeber=false; path=/; max-age=0;';
    }
    $('.social-remember-alert').toggleClass('alert-light alert-danger');
  });
});
