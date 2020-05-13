<?php
namespace Web\Board;

use Common\RestApi;

class Lists extends RestApi
{

	function __construct() 
	{
		parent::__construct();
	}

	function run() 
	{

		$data["target"] = $this->endpoint . "/board/lists";
		$data["method"] = "GET";
		$data["data"] = array(
			"board_name" => $this->getRequest("board_name")
		); 

		echo '1';
		var_dump($data);
		echo '1';
		die();

		$Res = json_decode($this->curl->exec($data), true);
	
		return $Res;
	}

}

