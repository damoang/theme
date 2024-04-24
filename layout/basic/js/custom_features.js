(() => {
  'use strict'
  const keyID = 'custom_features';

  const setConf = (obj) => {
    if(obj.length > 0) {
      localStorage.setItem(keyID, JSON.stringify(obj));
    } else {
      localStorage.removeItem(keyID);
    }

    return obj;
  }

  const getConf = () => {
    return JSON.parse(localStorage.getItem(keyID)) ?? [];
  }

  document.addEventListener("DOMContentLoaded", function() {
    let myConf = getConf();
    let icon = $('#hide_notice_icon');
    let notices = $('span:contains("공지")').parents('.bg-light-subtle');

    if(typeof(myConf[0]?.hideNotice) == 'undefined') {
      myConf[0] = {hideNotice:false};
    }
    
    if(myConf[0]?.hideNotice == true) {
      notices.attr('style', 'display:none !important;');
      icon.css('color', 'var(--bs-tertiary-color)');
    } else {
      icon.css('color', 'var(--bs-danger-text-emphasis)');
    }

    $('#hide_notice').click(function(e){
      e.preventDefault();
      
      if(notices.css('display') == 'none') {
        notices.css('display', 'table-row');
        icon.css('color', 'var(--bs-danger-text-emphasis)');
        myConf[0].hideNotice = false;
      } else {
        notices.css('display', 'none');
        icon.css('color', 'var(--bs-tertiary-color)');
        myConf[0].hideNotice = true;
      }
      setConf(myConf);
    });

  }, { once: true });
})();