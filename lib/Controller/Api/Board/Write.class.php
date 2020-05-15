<?php
namespace Controller\Api\Board;

use Common\RestApi;

use Container\Data\Board;

class Write extends RestApi
{

	function __construct()
	{
		parent::__construct();
	}

	function run()
	{
		parent::run();
		
	}
	
	function onPost() 
	{
		// Step 1. 변수 세팅
		$board_name = $this->getRequest("board_name");
		$writer = $this->getRequest("writer");
		$subject = $this->getRequest("subject");
		$content = $this->getRequest("content");
		$pw = $this->getRequest("pw", "");

		$Res = [];

		// Step 2. 유효성 체크하기
		if (!$board_name) $this->throwError(1500001, "게시판명이 입력되지 않았습니다.");
		if (!$subject) $this->throwError(1500002, "제목이 입력되지 않았습니다.");
		if (!$writer) $this->throwError(1500003, "작성자명이 입력되지 않았습니다.");
		if (!$content) $this->throwError(1500004, "내용이 입력되지 않았습니다.");
		
		// Step 3. 게시판 정보 수정하기
		$board = new Board($this);
		$Res = $board->setBoard($board_name, $subject, $content, $writer, $pw);
		if(!$Res) $this->throwError(1500005, "데이터 입력에 실패하였습니다." );
		
		$this->throwSuccess($Res);

	}
}




