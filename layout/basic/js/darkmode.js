/*!
* Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
* Improved with fixes and enhancements as per discussion.
* Ensures proper handling of theme values in local storage without extra quotes.
* Includes inline script for pre-loading theme to prevent flicker.
*/


(() => {
  'use strict'

  // 문서가 로드되기 전에 선호하는 테마를 설정하는 인라인 스크립트를 초기에 실행합니다.
  var theme = localStorage.getItem('theme');
  if(!theme || theme == 'auto') theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  document.documentElement.setAttribute('data-bs-theme', theme);

  // 함수를 사용하여 로컬 스토리지에서 테마를 불러오고 따옴표를 처리합니다.
  const loadTheme = () => {
    let theme = localStorage.getItem('theme');
    // 저장된 테마 값에서 불필요한 따옴표를 제거합니다.
    if (theme) {
      theme = theme.replace(/^"(.*)"$/, '$1');
    }
    return theme;
  }

  const storedTheme = loadTheme();

  const getPreferredTheme = () => {
    if (storedTheme) {
      return storedTheme;
    } else {
      return 'auto';
    }
    //return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  const setTheme = function (theme) {
    if (theme === 'auto') {
      theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';//getPreferredTheme();
    }
    document.documentElement.setAttribute('data-bs-theme', theme);
  }

  // 페이지 로드 시 저장된 테마를 적용합니다.
  setTheme(getPreferredTheme());

  const showActiveTheme = theme => {
    const activeThemeIcon = document.querySelector('.theme-icon-active i');
    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`);
    if (btnToActive) {
      const svgOfActiveBtn = btnToActive.querySelector('span i').getAttribute('class');

      document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
        element.classList.remove('active');
      });

      btnToActive.classList.add('active');
      activeThemeIcon.setAttribute('class', svgOfActiveBtn);
    }
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    // 'auto' 테마를 사용할 때 시스템 테마 변경을 적절히 처리합니다.
    if (storedTheme === 'auto') {
      const newTheme = getPreferredTheme();
      setTheme(newTheme);
      showActiveTheme(newTheme);
    }
  })

  window.addEventListener('DOMContentLoaded', () => {
    showActiveTheme(getPreferredTheme());
    highlightTextInClass('#bo_list .list-group-item a', '투표');


    document.querySelectorAll('[data-bs-theme-value]').forEach(toggle => {
      toggle.addEventListener('click', () => {
        const theme = toggle.getAttribute('data-bs-theme-value');
        localStorage.setItem('theme', theme); // 따옴표를 제거하거나 추가하지 않도록 처리합니다.
        setTheme(theme);
        showActiveTheme(theme);
      })
    })
  })


  // 20240409 선거 투표 강조
  function highlightTextInClass(className, text) {
    const elements = document.querySelectorAll(className);

    elements.forEach(function(element) {
      const innerHTML = element.innerHTML;
      const regex = new RegExp(text, "g");
      const replacement = '<mark class="voting">' + text + '</mark>';
      element.innerHTML = innerHTML.replace(regex, replacement);
    });
  }


})();

