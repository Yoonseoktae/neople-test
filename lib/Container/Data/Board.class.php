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

		$sql = "SELECT id, board_name, `subject`, writer, view_count 
				FROM neople.board 
				WHERE board_name = ? 
				AND is_delete = 0";

		if($keyword != "") {
			$sql .= " AND `subject` like \'% ".$keyword."%\'";
			$sql .= " AND content like \'% ".$keyword."%\'";
		}
		$sql .= " ORDER BY id DESC LIMIT ?, ?";

		return $this->getList($sql, $board_name, $limit, $lpp);
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

	function getBoardDetail($board_name, $board_id)
	{
		$sql = "SELECT id, board_name, `subject`, writer, view_count 
				FROM neople.board
				WHERE id = ?
				AND board_name = ?
				AND is_delete = 0";

		return $this->getResult($sql, $board_id, $board_name);
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




