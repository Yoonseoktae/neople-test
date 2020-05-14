<?php
namespace Container;

class paging 
{

	function __construct($root, $page, $lpp, $total_count)
	{
		$this->page = $page;
		$this->lpp = $lpp;
		$this->count = $total_count;

	}

	private function getPage()
	{
		return $this->page;
	}

	private function getLpp()
	{
		return $this->lpp;
	}

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

	public function getPageFirst($url, $Parameters) 
	{
		$Parameters["page_no"] = 1;
		return array(
			"url" => $url,
			"parameter" => $Parameters
		);
	}

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

	public function getPageLast($url, $Parameters) 
	{

		$Parameters["page_no"] = floor(((int)$this->count - 1) / $this->getLPP()) + 1;

		return array(
			"url" => $url,
			"parameter" => $Parameters
		);
	}

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
