<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="px-3 mb-4">
  <?php echo na_widget('outlogin'); // 외부로그인 ?>
</div>

<div class="na-menu">
  <div class="nav nav-pills nav-vertical">



    <div id="sidebar-site-menu" class="mb-3">
    <?php
if (!empty($config['cf_9'])) {
    ?>
      <div class="nav-item">
        <a class="nav-link" href="<?php echo $config['cf_9'];?>" data-placement="left" target="_blank">
          <i class="bi-youtube nav-icon"></i>
          <span class="nav-link-title">
                [♥] 다모앙 라방 (가칭 : 사랑방)
          </span>
        </a>
      </div>
    <?php
}
?>

      <div class="nav-item">
        <a class="nav-link" href="/bbs/noti.php" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [A] 알림보기 
          </span>
        </a>
      </div>
      <div class="nav-item">

      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/notice" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [K] 공지사항
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/free" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [F] 자유게시판
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/qa" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [Q] 질문과 답변
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/hello" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [I] 가입인사
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/new" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [N] 새소게(새소식)
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/tutorial" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [T] 사용기
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/lecture" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [L] 강좌
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/pds" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [P] 자료실
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/economy" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [E] 알뜰구매
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/gallery" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [G] 갤러리
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link dropdown-toggle collapsed collapsed" href="#sidebar-sub-s8" role="button"
          data-bs-toggle="collapse" data-bs-target="#sidebar-sub-s8" aria-expanded="false"
          aria-controls="sidebar-sub-s8">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title" onclick="na_href('https://damoang.net/bbs/group.php?gr_id=group','_self');">
            [S] 소모임
          </span>
        </a>
        <div id="sidebar-sub-s8" class="nav-collapse collapse" data-bs-parent="#sidebar-site-menu">
          <a class="nav-link" href="https://damoang.net/ai" target="_self">
            AI당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/android" target="_self">
            안드로메당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/applewatch" target="_self">
            애플워치당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/baseball" target="_self">
            야구당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/bicycle" target="_self">
            자전거당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/bread" target="_self">
            빵친당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/camping" target="_self">
            캠핑간당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/car" target="_self">
            굴러간당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/cat" target="_self">
            냐옹이당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/coffee" target="_self">
            클다방 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/console" target="_self">
            콘솔한당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/cooking" target="_self">
            요리당 </a>
          <a class="nav-link" href="https://damoang.net/cryptocurrency" target="_self">
            가상화폐당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/daegu" target="_self">
            대구당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/development" target="_self">
            개발한당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/diablo" target="_self">
            디아블로당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/dongsup" target="_self">
            동숲한당 </a>
          <a class="nav-link" href="https://damoang.net/drawing" target="_self">
            그림그린당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/fishing" target="_self">
            낙시당 </a>
          <a class="nav-link" href="https://damoang.net/fly" target="_self">
            날아간당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/formula" target="_self">
            포물러당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/game" target="_self">
            게임한당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/golf" target="_self">
            골프당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/gym" target="_self">
            땀흘린당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/homebuilding" target="_self">
            집짓는당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/iphone" target="_self">
            아이포니앙 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/japanlive" target="_self">
            일본산당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/keyboard" target="_self">
            키보드당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/lego" target="_self">
            레고당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/linux" target="_self">
            리눅서당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/MaClien" target="_self">
            MaClien <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/mbike" target="_self">
            이륜차당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/military" target="_self">
            밀리터리당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/movie" target="_self">
            영화본당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>

          <a class="nav-link" href="https://damoang.net/photo" target="_self">
            찰칵찍당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/photoshop" target="_self">
            포토샵당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/nas" target="_self">
            나스당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/ott" target="_self">
            OTT당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/overseas" target="_self">
            바다건너당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/parenting" target="_self">
            육아당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/playmobil" target="_self">
            플레이모빌당 </a>
          <a class="nav-link" href="https://damoang.net/youtube" target="_self">
            Youtube 당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/wine" target="_self">
            와인마신당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/whiskey" target="_self">
            위스키당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/pathofexile" target="_self">
            패스오브엑자일당 </a>
          <a class="nav-link" href="https://damoang.net/running" target="_self">
            달린당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/server" target="_self">
            서버당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/watches" target="_self">
            시계당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/seniorcenter" target="_self">
            경로당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/vr" target="_self">
            VR당 </a>
          <a class="nav-link" href="https://damoang.net/soccer" target="_self">
            축구당 </a>
          <a class="nav-link" href="https://damoang.net/soccerline" target="_self">
            싸줄한당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/socialgame" target="_self">
            소셜게임한당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/stationery" target="_self">
            필구도구당 </a>
          <a class="nav-link" href="https://damoang.net/stock" target="_self">
            주식한당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/swim" target="_self">
            퐁당퐁당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
          <a class="nav-link" href="https://damoang.net/tabletennis" target="_self">
            탁구당 <span class="small">
              <b class="badge bg-primary rounded-pill fw-normal"></b>
            </span>
          </a>
        </div>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/governance" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [V] 거버넌스
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/bbs/group.php?gr_id=community" data-placement="left"
          target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [C] 커뮤니티
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/bug" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [B] 유지관리
          </span>
        </a>
      </div>
      <div class="nav-item">
        <a class="nav-link" href="https://damoang.net/truthroom" data-placement="left" target="_self">
          <i class="bi-clipboard nav-icon"></i>
          <span class="nav-link-title">
            [J] 진실의 방으로
          </span>
        </a>
      </div>
    </div>


    <div class="dropdown-header">
      Miscellaneous
    </div>

    <div id="sidebar-misc-menu" class="mb-3">
      <?php
			// 현재접속자


			$iRow = array();
			$iRow[] = array(G5_BBS_DIR.'-page-faq', 'bi-question-circle', 'FAQ', G5_BBS_URL.'/faq.php');
			$iRow[] = array(G5_BBS_DIR.'-page-new', 'bi-pencil', '새글모음', G5_BBS_URL.'/new.php');
			$iRow[] = array(G5_BBS_DIR.'-page-search', 'bi-search', '게시물검색', G5_BBS_URL.'/search.php');

			for ($i=0; $i < count($iRow); $i++) { 
		?>
      <div class="nav-item">
        <a class="nav-link<?php echo ($page_id == $iRow[$i][0]) ? ' active' : ''; ?>" href="<?php echo $iRow[$i][3] ?>"
          data-placement="left">
          <i class="<?php echo $iRow[$i][1] ?> nav-icon"></i>
          <span class="nav-link-title"><?php echo $iRow[$i][2] ?></span>
        </a>
      </div>
      <?php } ?>
    </div>

    <div class="dropdown-header">
      About us
    </div>

    <div id="sidebar-misc-menu" class="mb-3">
      <?php
				$iRow = array();
				$iRow[] = array(G5_BBS_DIR.'-content-company', 'bi-balloon-heart', '사이트 소개', get_pretty_url('content', 'company'));
				$iRow[] = array(G5_BBS_DIR.'-content-provision', 'bi-check2-square', '서비스 이용약관', get_pretty_url('content', 'provision'));
				$iRow[] = array(G5_BBS_DIR.'-content-privacy', 'bi-person-lock', '개인정보 처리방침', get_pretty_url('content', 'privacy'));

				for ($i=0; $i < count($iRow); $i++) { 
			?>
      <div class="nav-item">
        <a class="nav-link<?php echo ($page_id == $iRow[$i][0]) ? ' active' : ''; ?>" href="<?php echo $iRow[$i][3] ?>"
          data-placement="left">
          <i class="<?php echo $iRow[$i][1] ?> nav-icon"></i>
          <span class="nav-link-title"><?php echo $iRow[$i][2] ?></span>
        </a>
      </div>
      <?php } ?>

      <?php if (IS_YC) { ?>
      <div class="nav-item">
        <a class="nav-link" href="<?php echo (IS_SHOP) ? G5_URL : G5_SHOP_URL; ?>" data-placement="left">
          <i class="bi-door-open nav-icon"></i>
          <span class="nav-link-title">
            <?php if(IS_SHOP) { ?>
            <?php echo $config['cf_title'] ?>
            <?php } else { ?>
            <?php echo (isset($nariya['seo_shop_title']) && $nariya['seo_shop_title']) ? $nariya['seo_shop_title'] : '쇼핑몰'; ?>
            <?php } ?>
          </span>
        </a>
      </div>
      <?php } ?>

      <div class="nav-item">
        <a class="nav-link" href="<?php echo get_device_change_url() ?>" data-placement="left">
          <i class="<?php echo (G5_IS_MOBILE) ? 'bi-pc-display' : 'bi-tablet'; ?> nav-icon"></i>
          <span class="nav-link-title"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일'; ?> 버전</span>
        </a>
      </div>
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6922133409882969"
        crossorigin="anonymous"></script>
      <!-- sub -->
      <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6922133409882969" data-ad-slot="3231235128"
        data-ad-format="auto" data-full-width-responsive="true"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>

    </div>
  </div>
</div><!-- end .na-menu -->
