<?php
namespace Controller\Api\Board;

use Common\RestApi;

use Container\Data\Board;
use Container\Paging;

class Lists extends RestApi
{

	function __construct()
	{
		
	}

	function run()
	{
		
		// Step 1. 변수 세팅
		$url = $this->getRequest("url", $_SERVER["HTTP_REFERER"]);
		$board_name = $this->getRequest("board_name");
		$keyword = $this->getRequest("keyword", "");
		$page = $this->getRequest("page", 1);
		$lpp = $this->getRequest("lpp", 10);
		$Res = [];

		// Step 2. 유효성 체크하기
		if (!$board_name) $this->throwError(1100001, "게시판명이 입력되지 않았습니다.");
		
		// Step 3. 게시판 정보 가져오기
		$board = new Board($this);
		$List = $board->getBoardList($board_name, $keyword, $page, $lpp);
		$total_count = $board->getBoardCount($board_name, $keyword);

		// Step 4. 게시판 페이징 정보 가져오기
		$paging = new Paging($this, $page, $lpp, $total_count);
		$PageInfo = $paging->getPageInfo($url);

		$Res = [
			"board" => $List,
			"page" => $PageInfo
		];
		
		$this->throwSuccess($Res);
		
	}
}




