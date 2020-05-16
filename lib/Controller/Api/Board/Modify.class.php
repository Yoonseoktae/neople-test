<?php
namespace Controller\Api\Board;

use Common\RestApi;

use Container\Data\Board;

/**
* @file lib/Controller/Api/Board/Modify.class.php
* @brief 게시글 수정 관련 클래스
* @author 윤석태 (seknman123@naver.com)
*/
class Modify extends RestApi
{

	function __construct()
	{
		parent::__construct();
	}

	function run()
	{
		parent::run();
		
	}
	
	/**
	* @brief 게시글 상세내역 조회 Controller
	* @return object
	*/
	function onGet()
	{
		// Step 1. 변수 세팅
		$board_name = $this->getRequest("board_name");
		$board_id = $this->getRequest("board_id");

		$Res = [];

		// Step 2. 유효성 체크하기
		if (!$board_name) $this->throwError(1300001, "게시판명이 입력되지 않았습니다.");
		if (!$board_id) $this->throwError(1300002, "게시판 고유번호가 입력되지 않았습니다.");
		
		// Step 3. 게시판 정보 가져오기
		$board = new Board($this);
		$Res = $board->getBoardDetail($board_name, $board_id);
		if(!$Res) $this->throwError(1300003, "데이터 조회에 실패하였습니다." );
		
		$this->throwSuccess($Res);
	}

	/**
	* @brief 게시글 수정 Controller
	* @return object
	*/
	function onPut() 
	{
		// Step 1. 변수 세팅
		$board_name = $this->getRequest("board_name");
		$board_id = $this->getRequest("board_id");
		$subject = $this->getRequest("subject");
		$content = $this->getRequest("content");

		$Res = [];

		// Step 2. 유효성 체크하기
		if (!$board_name) $this->throwError(1302001, "게시판명이 입력되지 않았습니다.");
		if (!$board_id) $this->throwError(1302002, "게시판 고유번호가 입력되지 않았습니다.");
		if (!$subject) $this->throwError(1302003, "제목이 입력되지 않았습니다.");
		if (!$content) $this->throwError(1302004, "내용이 입력되지 않았습니다.");
		
		// Step 3. 게시판 정보 수정하기
		$board = new Board($this);
		$Res = $board->modBoard($board_name, $board_id, $subject, $content);
		if(!$Res) $this->throwError(1302005, "데이터 변경에 실패하였습니다." );
		
		$this->throwSuccess($Res);

	}
}




