# README


Github 

	URI
	- https://github.com/Yoonseoktae/neople-test
	Repository Clone Address (public)
	- https://github.com/Yoonseoktae/neople-test.git


REST API URL (mode=api를 매개변수로 전달필수.)
	
	게시글 목록 조회
	- {GET} {site_url}/board/list?mode=api&board_name=neople

	게시글 상세정보 조회
	- {GET} {site_url}/board/detail?mode=api&board_id={board_id}&board_name=neople

	게시글 작성하기
	- {POST} {site_url}/board/write?mode=api
	- data : 	{
				"board_name" : "neople",
				"subject" : {subject},
				"content" : {content},
				"writer" : {writer},
				"pw" : {password}
			};

	게시글 수정하기
	- {GET} {site_url}/board/modify?mode=api&board_id={board_id}&board_name=neople
	- {PUT} {site_url}/board/list?mode=api
	- data = 	{
				"mode" : "api",
				"board_name" : "neople",
				"board_id" : {board_id}
			};

	게시글 삭제하기
	- {DELETE} /board/list?mode=api
	- data = 	{
				"board_name" : "neople",
				"board_id" : {board_id}
			};
				

REST API ERROR-CODE


	"BOARD" : {
		"LISTS" : {
			"1100001":"게시판명이 입력되지않았습니다.",
		},
		"DETAIL" : {
			"1200001":"게시판명이 입력되지않았습니다.",
			"1200002":"게시판 고유번호가 입력되지 않았습니다.",
			"1200003":"데이터 조회에 실패하였습니다.",
		},
		"MODIFY" : {
			"1300001":"게시판명이 입력되지 않았습니다.",
			"1300002":"게시판 고유번호가 입력되지 않았습니다.",
			"1300003":"데이터 조회에 실패하였습니다.",

			"1302001":"게시판명이 입력되지 않았습니다.",
			"1302002":"게시판 고유번호가 입력되지 않았습니다.",
			"1302003":"제목이 입력되지 않았습니다.",
			"1302004":"내용이 입력되지 않았습니다.",
			"1302005":"데이터 변경에 실패하였습니다.",
		},
		"DELETE" : {
			"1400001":"게시판명이 입력되지 않았습니다.",
			"1400002":"게시판 고유번호가 입력되지 않았습니다.",
			"1400003":"데이터 삭제에 실패하였습니다.",
		},
		"WRITE" : {
			"1500001":"게시판명이 입력되지 않았습니다.",
			"1500002":"제목이 입력되지 않았습니다.",
			"1500003":"작성자명이 입력되지 않았습니다.",
			"1500004":"내용이 입력되지 않았습니다.",
			"1500005":"데이터 입력에 실패하였습니다.",
		}
	}


PHP 개발내용

	1. MVC 방식 처리
		- CORE ROOT		: /lib/Common
		- MODEL ROOT		: /lib/Container
		- VIEW ROOT 		: /view
		- CONTROLLER ROOT	: /lib/controller
	2. Route
	3. RESTFUL API 및 JAVASCRIPT callback처리
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

CSS, HTML 참고 및 사용 출처

	- https://m.blog.naver.com/PostList.nhn?blogId=bgpoilkj


Database

	- AWS RDS 프리티어 Mysql 구성 (접속정보 config/config.php 명세)

Database Table DDL

	CREATE TABLE `board` (
	`id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '고유값',
	`board_name` varchar(32) DEFAULT NULL COMMENT '게시판명',
	`subject` varchar(256) NOT NULL COMMENT '제목',
	`content` mediumtext COMMENT '내용',
	`writer` varchar(64) DEFAULT NULL COMMENT '작성자',
	`pw` varchar(128) DEFAULT '' COMMENT '게시글 비밀번호',
	`is_delete` int(11) DEFAULT '0' COMMENT '삭제여부',
	`reg_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '작성일',
	`mod_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '최종수정일',
	PRIMARY KEY (`id`),
	KEY `table_name` (`board_name`),
	KEY `reg_date` (`mod_date`),
	KEY `mod_date` (`mod_date`)
	) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='네오플 게시판 테이블';
