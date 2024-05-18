(() => {
  'use strict'
  const keyID = 'custom_features';

  const setConf = (obj) => {
    localStorage.setItem(keyID, JSON.stringify(obj ?? {}));

    return obj;
  }

  const getConf = () => {
    let data = JSON.parse(localStorage.getItem(keyID)) ?? {};

    if (data instanceof Array) {
      data = {};
    }

    return data;
  }

  // 게시판 공지사항 보기 설정
  $(function () {
    const hideTrigger = $('#hide_notice');
    if (!hideTrigger.length) {
      return;
    }

    const myConf = getConf();
    const icon = $('#hide_notice_icon');

    myConf.hideNotice = myConf?.hideNotice ?? false;

    if (myConf.hideNotice) {
      toggleNoticeHide();
    }

    // 아이콘 클릭 시 상태 토글
    $('#hide_notice').on('click', function (e) {
      e.preventDefault();

      myConf.hideNotice = !myConf.hideNotice;
      setConf(myConf);

      toggleNoticeHide();
    });

    /**
     * 공지 보이기/감추기 토글
     */
    function toggleNoticeHide() {
      icon.toggleClass('bi-megaphone-fill bi-megaphone');

      let notices = $('#bo_list .bg-light-subtle span:contains("공지")').closest('.list-group-item');

      notices.toggleClass('d-none');
    }
  });
})();
