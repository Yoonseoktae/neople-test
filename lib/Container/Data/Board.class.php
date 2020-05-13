<?php
namespace Container\Data;

use Common\Model;

class Board extends Model
{

	function __construct() 
	{
		parent::__construct();
	}

	function getBoardList($board_name, $keyword, $page, $lpp)
	{
		$limit = ($page-1) * $lpp;

		$sql = "SELECT * FROM neople.board WHERE board_name = ? AND is_delete = 0";
		if($keyword != "") {
			$sql .= " AND `subject` like \'% ".$keyword."%\'";
			$sql .= " AND content like \'% ".$keyword."%\'";
		}
		$sql .= " ORDER BY id DESC LIMIT ?, ?";

		return $this->getResult($sql, $board_name, $page, $limit);
	}

	function getBoardCount($board_name, $keyword)
	{
		$sql = "SELECT count(*) as `total_count` FROM neople.board WHERE board_name = ? AND is_delete = 0";
		if($keyword != "") {
			$sql .= " AND `subject` like \'% ".$keyword."%\'";
			$sql .= " AND content like \'% ".$keyword."%\'";
		}

		return $this->getResult($sql, $board_name);
	}

	function setBoard()
	{

	}

	function modBoard()
	{

	}

	function delBoard()
	{

	}

}




