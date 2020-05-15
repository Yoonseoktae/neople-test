<?php
namespace Controller\Api\Board;

use Common\RestApi;

use Container\Data\Board;

class Detail extends RestApi
{

	function __construct()
	{
		parent::__construct();

	}

	public function run()
	{
		parent::run();
	}

	public function onGet() {
		// Step 1. 변수 세팅
		$board_name = $this->getRequest("board_name");
		$board_id = $this->getRequest("board_id");

		$Res = [];

		// Step 2. 유효성 체크하기
		if (!$board_name) $this->throwError(1200001, "게시판명이 입력되지 않았습니다.");
		if (!$board_id) $this->throwError(1200002, "게시판 고유번호가 입력되지 않았습니다.");

		// Step 3. 게시판 정보 가져오기
		$board = new Board($this);
		$Res = $board->getBoardDetail($board_name, $board_id);
		if(!$Res) $this->throwError(1200003, "데이터 조회에 실패하였습니다." );

		$this->throwSuccess($Res);
	}

	

	
}




