# MSA구조로 진행하려했으나 시간안에 모든 구조 및 기능을 개발하기 어려워 일단 간단하게 개발하였습니다.

PHP 개발내용
	1. MVC 방식 처리
		- CORE ROOT			: /lib/Common
		- MODEL ROOT		: /lib/Container
		- VIEW ROOT 		: /view
		- CONTROLLER ROOT	: /lib/controller
	2. Route
	3. RESTFUL API
	4. mysqli 사용, binding 방식
	5. Class 기반.
	6. CURL 도입 실패.
		- ROUTER -> CONTROLLER -> CURL -> API호출 프로세스 도입실패
		- AJAX -> CONTROLLER -> API호출 -> Json2Html 프로세스로 변경.
	

Jquery 사용한 기능
	- ajax
		1. GET, POST, PUT, DELETE 방식 Method 사용
	- json2html
		2. ajax를 response json데이터를 기반으로 layout구성용 사용.

Database
	- AWS RDS 프리티어 Mysql 구성 

Database DDL
	CREATE TABLE `board` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '고유값',
	`board_name` varchar(32) DEFAULT NULL COMMENT '게시판명',
	`subject` varchar(256) NOT NULL COMMENT '제목',
	`content` mediumtext COMMENT '내용',
	`view_count` int(11) DEFAULT '0' COMMENT '조회수',
	`is_delete` int(11) DEFAULT '0' COMMENT '삭제여부',
	`reg_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '작성일',
	`mod_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '최종수정일',
	PRIMARY KEY (`id`),
	KEY `table_name` (`board_name`),
	KEY `reg_date` (`mod_date`),
	KEY `mod_date` (`mod_date`)
	) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='네오플 게시판 테이블';



	CREATE TABLE `user` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '고객번호',
	`email` varchar(128) NOT NULL COMMENT 'E-mail 주소',
	`pw` varchar(128) NOT NULL COMMENT '비밀번호',
	`error_count` int(11) DEFAULT '0' COMMENT '비밀번호 오류횟수',
	`status` enum('ban','active','left') DEFAULT 'active' COMMENT '회원 상태',
	`reg_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
	`mod_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '최종수정일',
	PRIMARY KEY (`id`),
	UNIQUE KEY `email` (`email`),
	KEY `email_pw` (`email`,`pw`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='유저 테이블';

	CREATE TABLE `access_token` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '고유값',
	`access_token` varchar(192) NOT NULL COMMENT '접근 access_token',
	`user_id` bigint(20) DEFAULT NULL COMMENT '사용자 ID',
	`expire_date` datetime DEFAULT NULL COMMENT '유효시간',
	`reg_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
	PRIMARY KEY (`id`),
	KEY `access_token` (`access_token`),
	KEY `expire_date` (`expire_date`),
	KEY `user_id` (`user_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='인증 Token 정보';



