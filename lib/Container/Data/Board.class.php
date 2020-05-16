<?php
namespace Container\Data;

use Common\Model;

/**
* @file lib/Container/Board.class.php
* @brief 게시판 관련 DB 데이타처리 모음 클래스
* @author 윤석태 (seknman123@naver.com)
*/
class Board extends Model
{

	function __construct() 
	{
		parent::__construct();
	}

	/**
	* @brief 게시글 리스트 조회
	* @param string $board_name
	* @param string $keyword
	* @param int $page
	* @param int $lpp
	* @return array
	*/
	function getBoardList($board_name, $keyword, $page, $lpp)
	{
		$limit = ($page-1) * $lpp;

		$sql = "SELECT id, board_name, `subject`, writer, reg_date
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

	/**
	* @brief 게시글 총 개수 조회
	* @param string $board_name
	* @param string $keyword
	* @return array
	*/
	function getBoardCount($board_name, $keyword)
	{
		$sql = "SELECT count(*) as `total_count` FROM neople.board WHERE board_name = ? AND is_delete = 0";
		if($keyword != "") {
			$sql .= " AND `subject` like \'% ".$keyword."%\'";
			$sql .= " AND content like \'% ".$keyword."%\'";
		}

		return $this->getResult($sql, $board_name);
	}

	/**
	* @brief 게시글 상세정보 조회
	* @param string $board_name
	* @param int $board_id
	* @return array
	*/
	function getBoardDetail($board_name, $board_id)
	{
		$sql = "SELECT id, board_name, `subject`, `content`, writer, reg_date, pw 
				FROM neople.board
				WHERE id = ?
				AND board_name = ?
				AND is_delete = 0";

		return $this->getResult($sql, $board_id, $board_name);
	}

	/**
	* @brief 게시글 작성하기
	* @param string $board_name
	* @param string $subject
	* @param string $content
	* @param string $writer
	* @param string $pw
	* @return boolean
	*/
	function setBoard($board_name, $subject, $content, $writer, $pw)
	{
		$sql = "INSERT INTO neople.board (`board_name`, `subject`, `content`, `writer`, `pw`)
		VALUES (?, ?, ?, ?, ?)";
		
		return $this->execute($sql, $board_name, $subject, $content, $writer, $pw);
	}

	/**
	* @brief 게시글 수정하기
	* @param string $board_name
	* @param int $board_id
	* @param string $subject
	* @param string $content
	* @return boolean
	*/
	function modBoard($board_name, $board_id, $subject, $content)
	{
		$sql = "UPDATE neople.board
				SET `subject` = ?, `content` = ?
				WHERE id = ?
				AND board_name = ?";

		return $this->execute($sql, $subject, $content, $board_id, $board_name);
	}

	/**
	* @brief 게시글 삭제처리하기
	* @param string $board_name
	* @param int $board_id
	* @return boolean
	*/
	function delBoard($board_name, $board_id)
	{
		$sql = "UPDATE neople.board
				SET is_delete = 1
				WHERE id = ?
				AND board_name = ?";

		return $this->execute($sql, $board_id, $board_name);
	}

}




