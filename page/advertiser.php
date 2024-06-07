<?php
if (!defined('_GNUBOARD_'))
    exit; //개별 페이지 접근 불가

/* 위젯 내용 순서대로 출력.
-긴배너
-사이드배너
-직접홍보
위젯코드: theme/basic/layout/basic/widget/advertiser */
echo na_widget('advertiser', 'adCollection'); ?>


<!-- 이전 광고  -------------------------------------------------------------- -->
<section class="container mb-5">

    <h3>다모앙에 도움을 주셨던 이전 광고주님</h3>
    <ul class="text-center row row-cols-2 row-cols-md-3 list-group list-group-horizontal list-group-flush" style="font-size: 0.875rem;">
        <!-- <li class="col list-group-item border-0">딩그린(베트남) 긴배너</li> -->
    </ul>

</section>