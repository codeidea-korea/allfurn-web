-- 사용자 액션 history
(select count(*) from AF_user_require_action where response_user_id = and response_user_type = )
create table AF_user_require_action (
    idx int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    request_user_id int(10) NOT NULL default 0 comment '요청자(고객) 식별자',
    request_user_type char(1) NOT NULL default 'N' comment '요청자(고객) 식별 회사구분',
    response_user_id int(10) NOT NULL default 0 comment '요청받은자(대응해야하는) 식별자',
    response_user_type char(1) NOT NULL default 'W' comment '요청받은자(대응해야하는) 식별 회사구분',
    request_type tinyint(2) not null default 0 comment '구분 (1: 전화 / 2: 문의 / 3: 견적서 요청)',
    product_id int(10) NOT NULL default 0 comment '제품 식별자',
    created_at datetime default now()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

