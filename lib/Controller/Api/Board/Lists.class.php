<?php
namespace Controller\Api\Board;

use Common\RestApi;

use Container\Data\Board;
use Container\Paging;

/**
* @file lib/Controller/Api/Board/Lists.class.php
* @brief 게시글 리스트 조회 관련 클래스
* @author 윤석태 (seknman123@naver.com)
*/
class Lists extends RestApi
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
	* @brief 게시글 리스트 조회 Controller
	* @return object
	*/
	function onGet() {
		// Step 1. 변수 세팅
		$url = $this->getRequest("url", "");
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
		$total_count = ($board->getBoardCount($board_name, $keyword))["total_count"];

		// Step 4. 게시판 페이징 정보 가져오기
		$paging = new Paging($this, $page, $lpp, $total_count);
		$PageInfo = $paging->getPageInfo($url);

		$Res = [
			"board" => $List,
			"page" => $PageInfo,
			"total_count" => $total_count
		];
		
		$this->throwSuccess($Res);
	}
}




