<?php

// 전각 문자표
// ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ

return [
    [
        'title' => '다모앙',
        'items' => [
            '자유게시판' => [
                'url' => '/free',
                'icon' => 'bi-chat',
                'shortcut' => 'Ｆ',
            ],
            '질문과 답변' => [
                'url' => '/qa',
                // 'icon' => 'bi-question-circle',
                'shortcut' => 'Ｑ',
                'icon' => 'bi-question-circle',
            ],
            '앙지도' => [
                'url' => '/angmap',
                'shortcut' => 'Ｍ',
                'icon' => 'bi-geo-alt-fill',
                // bi-star-fill
                // Ａ단축키는 알림 링크에 사용됨
            ],
            '삐앙삐앙 🚨' => [
                'url' => '/angreport',
                'shortcut' => 'Ｘ',
                'icon' => 'bi-webcam-fill',

                // Ａ단축키는 알림 링크에 사용됨
            ],
            '직접홍보 🌻' => [
                'url' => '/promotion',
                // 'icon' => 'bi-cart-plus-fill',
                'shortcut' => 'Ｗ',
            ],
            '새소식' => [
                'url' => '/new',
                'icon' => 'bi-newspaper',
                'shortcut' => 'Ｎ',
            ],
            '사용기' => [
                'url' => '/tutorial',
                'icon' => 'bi-vector-pen',
                'shortcut' => 'Ｔ',
            ],
           '강좌/팁' => [
                'url' => '/lecture',
                'shortcut' => 'Ｌ',
            ],
            '갤러리' => [
                'url' => '/gallery',
                'icon' => 'bi-images',
                'shortcut' => 'Ｇ',
            ],
            '자료실' => [
                'url' => '/pds',
                'icon' => 'bi-person-heart',
                'shortcut' => 'P',
            ],
            '알뜰구매' => [
                'url' => '/economy',
                'icon' => 'bi-cash-coin',
                'shortcut' => 'Ｅ',
            ],
            '수익링크 게시판' => [
                'url' => '/referral',
                // 'icon' => 'bi-cart-plus-fill',
                'shortcut' => 'Ｏ',
            ],
            '앙상불-앙님들의 상상 공간' => [
                'url' => '/event',
                // 'icon' => 'bi-cart-plus-fill',
                'shortcut' => 'A',
            ],

        ]
    ],
    [
        'title' => '소모임',
        'items' => [
            '소모임' => [
                'url' => G5_BBS_URL . '/group.php?gr_id=group',
                'page_id' => G5_BBS_DIR . '-group-group',
                'icon' => 'bi-cart-plus-fill',
                'shortcut' => 'Ｓ',
                'items' => [
                    '모아보기' => G5_BBS_URL . '/group.php?gr_id=group',
                    'AI당' => '/ai',
                    'LOL당' => '/lol',
                    'OTT당' => '/ott',
                    'VR당' => '/vr',
                    'Youtube당' => '/youtube',
                    '가상화폐당' => '/cryptocurrency',
                    '개발한당' => '/development',
                    '게임한당' => '/game',
                    '경로당' => '/seniorcenter',
                    '골프당' => '/golf',
                    '굴러간당' => '/car',
                    '그림그린당' => '/drawing',
                    '나스당' => '/nas',
                    '낚시당' => '/fishing',
                    '날아간당' => '/fly',
                    '냐옹이당' => '/cat',
                    '달린당' => '/running',
                    '대구당' => '/daegu',
                    '동숲한당' => '/dongsup',
                    '등산한당' => '/hike',
                    '디아블로당' => '/diablo',
                    '땀흘린당' => '/gym',
                    '레고당' => '/lego',
                    '리눅서당' => '/linux',
                    '맥모앙' => '/macmoang',
                    '밀리터리당' => '/military',
                    '바다건너당' => '/overseas',
                    '방탄소년당' => '/bts',
                    '보드게임당' => '/boardgame',
                    '보러간당' => '/see',
                    '빵친당' => '/bread',
                    '서버당' => '/server',
                    '서피스당' => '/MSSurface',
                    '소셜게임한당' => '/socialgame',
                    '시계당' => '/watches',
                    '싸줄한당' => '/soccerline',
                    '안드로메당' => '/android',
                    '애플모앙' => '/applemoang',
                    '야구당' => '/baseball',
                    '영화본당' => '/movie',
                    '옵시디안당' => '/obsidang',
                    '와인마신당' => '/wine',
                    '요리당' => '/cooking',
                    '위스키당' => '/whiskey',
                    '육아당' => '/parenting',
                    '이륜차당' => '/mbike',
                    '일본산당' => '/japanlive',
                    '자전거당' => '/bicycle',
                    '재봉한당' => '/sewing',
                    '주식한당' => '/stock',
                    '지켜본당' => '/watchingyou',
                    '집짓는당' => '/homebuilding',
                    '찰칵찍당' => '/photo',
                    '책읽는당' => '/readingbooks',
                    '우주본당' => '/space',
                    '축구당' => '/soccer',
                    '캠핑간당' => '/camping',
                    '콘솔한당' => '/console',
                    '다바앙' => '/coffee',
                    '키보드당' => '/keyboard',
                    '탁구당' => '/tabletennis',
                    '패스오브엑자일당' => '/pathofexile',
                    '포뮬러당' => '/formula',
                    '포토샵당' => '/photoshop',
                    '퐁당퐁당' => '/swim',
                    '플레이모빌당' => '/playmobil',
                    '필기도구당' => '/stationery',
                ]
            ],
        ],
    ],
    [
        'title' => '운영게시판 (통폐합중)',
    
        'items' => [
            '공지사항' => [
                'url' => '/notice',
                'shortcut' => 'K',
                'icon' => 'bi-geo-alt-fill',
            ],
            '운영게시판' => [
                'url' => G5_BBS_URL . '/group.php?gr_id=admin',
                'page_id' => G5_BBS_DIR . '-group-group',
                'icon' => 'bi-cart-plus-fill',
                'shortcut' => '·',
                'items' => [
                    '알림사앙 🆕' => '/notice',
                    '릴리즈 노트' => '/release',
                    '유지관리' => '/bug',
                    '광고앙' => get_pretty_url('content', 'advertiser'),
                    '거버넌스' => '/governance',
                    '진실의 방' => '/truthroom',
                    '광고앙돼앙' => '/nope',
                    '레벨강등 열람' => '/disciplinelog',
                ],
            ],
        ],
    ],
    [
        'title' => '기타',
        'items' => ($member['mb_level'] >= 2) ? [
            'FAQ' => [
                'url' => G5_BBS_URL . '/faq.php',
                'page_id' => G5_BBS_DIR . '-page-faq',
                'icon' => 'bi-question-circle',
            ],
            '새글모음' => [
                'url' => G5_BBS_URL . '/new.php',
                'page_id' => G5_BBS_DIR . '-page-new',
                'icon' => 'bi-pencil',
            ],
            '태그모음' => [
                'url' => G5_BBS_URL . '/tag.php',
                'page_id' => G5_BBS_DIR . '-page-tag',
                'icon' => 'bi-tags',
            ],
            '게시물검색' => [
                'url' => G5_BBS_URL . '/search.php',
                'page_id' => G5_BBS_DIR . '-page-search',
                'icon' => 'bi-search',
            ],
        ] : [
            'FAQ' => [
                'url' => G5_BBS_URL . '/faq.php',
                'page_id' => G5_BBS_DIR . '-page-faq',
                'icon' => 'bi-question-circle',
            ],
            '새글모음' => [
                'url' => G5_BBS_URL . '/new.php',
                'page_id' => G5_BBS_DIR . '-page-new',
                'icon' => 'bi-pencil',
            ],
        ],
    ],
    [
        'title' => 'About us',
        'items' => [
            '사이트 소개' => [
                'url' => get_pretty_url('content', 'company'),
                'page_id' => G5_BBS_DIR . '-content-company',
                'icon' => 'bi-balloon-heart',
            ],
            '서비스 이용약관' => [
                'url' => get_pretty_url('content', 'provision'),
                'page_id' => G5_BBS_DIR . '-content-provision',
                'icon' => 'bi-check2-square',
            ],
            '개인정보 처리방침' => [
                'url' => get_pretty_url('content', 'privacy'),
                'page_id' => G5_BBS_DIR . '-content-privacy',
                'icon' => 'bi-person-lock',
            ],
        ],
    ],
];

