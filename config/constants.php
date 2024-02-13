<?php
return [
    'ORDER' => [
        'STATUS' => [
            'S' => [ // seller - 판매자
                'N' => '신규 주문',
                'R' => '상품 준비중',
                'D' => '발송중',
                'W' => '구매 확정 대기',
                'F' => '거래 완료',
                'C' => '거래 취소',
            ],
            'P' => [ // purchase - 구매자
                'N' => '주문 완료',
                'R' => '거래 확정',
                'D' => '배송중',
                'W' => '구매 확정 대기',
                'F' => '거래 완료',
                'C' => '주문 취소',
            ]
        ]
    ],
    'REGIONS' => [
        'KR' => [
            '서울', '부산', '대구', '인천', '광주', '대전', '울산', '세종', '경기', '강원', '충청', '전라', '경상', '제주',
        ],
    ],
    'GLOBAL_DOMESTIC' => [
        '아시아', '아프리카', '북아메리카', '남아메리카', '유럽', '오세아니아', '그 외'
    ],
    'PRODUCT_STATUS' => [
        'W' => '승인대기',
        'S' => '판매중',
        'O' => '품절',
        'H' => '숨김',
        'C' => '판매중지',
        'R' => '반려',
//        'N' => '신상품',
    ],
    'ALLFURN' => [
        'CALL_NUMBER' => '031-813-5588',
        'PROFILE_IMAGE' => '/images/allfurn-defult_thumnail.png',
        'OPERATION_TIME' => '평일 09:00 - 18:00',
        'NAME' => '올펀',
    ],
    'MESSAGE' => [
        'ORDER' => [
            'COMPLETE' => [
                'TITLE' => '주문번호: ',
                'TEXT' => '주문이 완료되었습니다.<br/>감사합니다.',
            ],
            'DEAL_COMP' => [
                'TITLE' => '주문번호: ',
                'TEXT' =>'거래가 확정되었습니다.<br/>상품이 준비 중이니 기다려주세요!'
            ],
            'START_SHIPPING' => [
                'TITLE' => '주문번호: ',
                'TEXT' => '배송이 시작되었습니다.',
            ],
            'CONFIRM' => [
                'TITLE' => '주문번호: ',
                'TEXT' => '상품은 잘 받아보셨나요?<br/>구매 확정 버튼을 눌러 구매를 확정해주세요.',
            ],
            'CANCEL' => [
                'TITLE' => '주문번호: ',
                'TEXT' => '주문이 취소되었습니다.<br/>주문 상세에서 취소된 상품을 확인해주세요.',
            ],
        ],
        'CS' => [
            'WELCOME' => [
                'TITLE' => '올펀 가입을 축하드립니다.',
                'TEXT' => '더 편리한 서비스 이용을 위해 가이드를 확인해보세요!'
            ],
            'CS' => [
                'TITLE' => '올펀 고객센터',
                'TEXT' => '',
            ]
        ],
    ],
    'ALARM' => [
        'ORDER' => [
            'S' => [ // 거래 seller (dealer)
                'READY' => [
                    'TITLE' => '상품 준비중 안내',
                    'CONTENT' => "[{VAR1}] 주문 건이 상품 준비 중 상태로 변경되었습니다.", // 거래 완료
                ],
                'DELIVERY' => [
                    'TITLE' => '발송 중 안내',
                    'CONTENT' => "[{VAR1}] 주문 건이 발송 중 상태로 변경되었습니다.", // 발송
                ],
                'WAITING' => [
                    'TITLE' => '구매 확정 대기 안내',
                    'CONTENT' => "[{VAR1}] 주문 건이 구매 확정 대기 상태로 변경되었습니다.", // 발송완료
                ],
                'FINISH' => [
                    'TITLE' => '거래 완료 안내',
                    'CONTENT' => "거래 완료 안내", // 구매 완료
                ],
                'CANCEL' => [
                    'TITLE' => '주문 취소 안내',
                    'CONTENT' => "[{VAR1}] 상품 주문이 취소되었습니다.", // 취소
                ],
            ],
            'P' => [ // 주문 purchase (purchase)
                'READY' => [
                    'TITLE' => '거래 확정 안내',
                    'CONTENT' => "[{VAR1}] 상품 주문이 확정되었습니다.", // 거래 완료
                ],
                'DELIVERY' => [
                    'TITLE' => '배송 중 안내',
                    'CONTENT' => "[{VAR1}] 상품의 배송이 시작되었습니다.", // 발송
                ],
                'WAITING' => [
                    'TITLE' => '구매 확정 요청 안내',
                    'CONTENT' => "[{VAR1}] 상품 구매를 확정해주세요.", // 발송완료
                ],
                'FINISH' => [
                    'TITLE' => '거래 완료 안내',
                    'CONTENT' => "[{VAR1}] 상품 거래가 완료되었습니다.", // 구매 완료
                ],
                'CANCEL' => [
                    'TITLE' => '거래 취소 안내',
                    'CONTENT' => "[{VAR1}] 상품 거래가 취소되었습니다.", // 취소
                ],
            ],
        ],
        'ACTIVE' => [
            'TALK' => [
                'TALK' => [
                    'TITLE' => '메시지 알림',
                    'CONTENT' => ''
                ],
            ],
            'ARTICLE' => [
                'SUBSCRIBE' => [
                    'TITLE' => "올펀 게시글 알림",
                    'CONTENT' => "구독한({VAR1})에 새 글이 등록되었습니다.",
                ],
                'REPLY' => [
                    'TITLE' => "올펀 게시글 알림",
                    'CONTENT' => "작성한 게시글에 댓글이 작성되었습니다."
                ],
                'RE_REPLY' => [
                    'TITLE' => "올펀 게시글 알림",
                    'CONTENT' => "작성한 댓글에 답글이 작성되었습니다."
                ],
            ],
        ],
    ],
    'POPUP' => [
        'TYPE' => [
            'PRODUCT' => '/product/detail/', // 상품
            'WHOLESALE' => '/wholesaler/detail/', // 업체
            'COMMUNITY' => '/community/detail/', // 커뮤니티
            'NOTICE' => '/help/notice/', // 공지사항
        ]
    ]
];
