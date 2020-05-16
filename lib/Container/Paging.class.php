<?php
namespace Container;

/**
* @file lib/Container/Paging.class.php
* @brief 리스트 페이징처리를 위한 클래스
* @author 윤석태 (seknman123@naver.com)
*/
class paging 
{

	function __construct($root, $page, $lpp, $total_count)
	{
		$this->page = $page;
		$this->lpp = $lpp;
		$this->count = $total_count;

	}

	/**
	* @brief Page 가져오기
	* @return int
	*/
	private function getPage()
	{
		return $this->page;
	}

	/**
	* @brief list_per_page 가져오기
	* @return int
	*/
	private function getLpp()
	{
		return $this->lpp;
	}

	/**
	* @brief 페이지리스트 정보 가져오기
	* @param string $url
	* @param array $Parameters
	* @return array
	*/
	public function getPageList($url, $Parameters) 
	{
		$cur_page = $this->getPage();
		$total_page = floor(((int)$this->count - 1) / $this->getLPP()) + 1;

		$begin_page = floor(($cur_page - 1) / 10) * 10 + 1;
		$last_page = min($begin_page + 9, $total_page);

		for ($i = $begin_page; $i <= $last_page; $i++) {
			$Parameters["page_no"] = $i;
			$Item = array(
				"url" => $url,
				"parameter" => $Parameters
			);
			if ($i == $this->getPage())
				$Item["selected"] = "selected";
			else
				$Item["selected"] = "";
			$data [] = $Item;
		}

		return $data;
	}

	/**
	* @brief 첫페이지정보 가져오기
	* @param string $url
	* @param array $Parameters
	* @return array
	*/
	public function getPageFirst($url, $Parameters) 
	{
		$Parameters["page_no"] = 1;
		return array(
			"url" => $url,
			"parameter" => $Parameters
		);
	}

	/**
	* @brief 이전페이지정보 가져오기
	* @param string $url
	* @param array $Parameters
	* @return array
	*/
	public function getPagePrev($url, $Parameters) 
	{
		$cur_page = $this->getPage();
		$prev_page = max(1, $cur_page -1);
		$Parameters["page_no"] = $prev_page;
		return array(
			"url" => $url,
			"parameter" => $Parameters
		);
	}

	/**
	* @brief 다음페이지정보 가져오기
	* @param string $url
	* @param array $Parameters
	* @return array
	*/
	public function getPageNext($url, $Parameters) 
	{
		$total_page = floor(((int)$this->count - 1) / $this->getLPP()) + 1;
		$next_page = min($total_page, $this->getPage() + 1);

		$Parameters["page_no"] = $next_page;

		return array(
			"url" => $url,
			"parameter" => $Parameters
		);
	}

	/**
	* @brief 마지막페이지정보 가져오기
	* @param string $url
	* @param array $Parameters
	* @return array
	*/
	public function getPageLast($url, $Parameters) 
	{

		$Parameters["page_no"] = floor(((int)$this->count - 1) / $this->getLPP()) + 1;

		return array(
			"url" => $url,
			"parameter" => $Parameters
		);
	}

	/**
	* @brief 총 페이지정보 가져오기
	* @param string $url
	* @param array $Parameters
	* @return array
	*/
	public function getPageInfo($url, $Parameters = null) 
	{
		if ($Parameters == null)
			$Parameters = array();

		$data["first"] = $this->getPageFirst($url, $Parameters);
		$data["prev"] = $this->getPagePrev($url, $Parameters);
		$data["list"] = $this->getPageList($url, $Parameters);
		$data["next"] = $this->getPageNext($url, $Parameters);
		$data["last"] = $this->getPageLast($url, $Parameters);

		return $data;
	}
}
