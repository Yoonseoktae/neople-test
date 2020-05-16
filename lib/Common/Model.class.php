<?php
namespace Common;

/**
* @file lib/Common/Model.class.php
* @brief Mysql 연결하기위한 모델관련 클래스
* @author 윤석태 (seknman123@naver.com)
*/
class Model
{
	var $mysqli;
	var $result;
	var $rs;

	var $connected;

	var $connection_id;
	var $insert_id;
	var $config;
	var $db;

	function __construct()
	{
		GLOBAL $_CONFIG;
		
		$this->insert_id = 0;
		$this->config = $_CONFIG;
	}

	function __destruct()
	{
		
	}

	/**
	* @brief Mysqli DB연결 함수
	* @return void
	*/
	function connect()
	{
		$host = $this->config["database"]["host"];
		$id = $this->config["database"]["id"];
		$password = $this->config["database"]["password"];
		$schema = $this->config["database"]["schema"];
		$port = $this->config["database"]["port"];

		if (!$host || !$id || !$password || !$schema || !$port) {
			throw new \Exception("Database Info not found.");
		}
		
		try {
			$this->mysqli = new \mysqli($host, $id, $password, $schema, $port);
			$this->connected = true;
		} catch (\Exception $e) {
			$this->connected = false;
		}
	}

	/**
	* @brief 바인딩 타입설정
	* @param array $Args
	* @return string
	*/
	function getBindType($Args)
	{
		$bind_types = "";
		foreach($Args as $Arg) {
			if (is_numeric($Arg) && is_double($Arg)) $bind_types .= "s";
			else if (is_numeric($Arg)) $bind_types .= "s";
			else $bind_types .= "s"; 
		}

		return $bind_types;
	}

	/**
	* @brief 쿼리 준비 후 전달받은 매개변수로 바인딩처리
	* @param string $query
	* @param array $Args
	* @return array
	*/
	function prepare($query, $Args)
	{
		$result = null;

		if (!$this->mysqli) {
			$this->connect();
			$this->mysqli->set_charset("utf8");
		}
		if (!$this->connected) return;

		$stmt = $this->mysqli->prepare($query);

		if ($stmt) {

			if (count($Args) == 1) {
				$stmt->bind_param("s", $Args[0]); 
				$result = $stmt->execute();
				
			} else if (count($Args) > 0) {

				$bind_names[] = $this->getBindType($Args);
				for ($i=0; $i<count($Args);$i++) {
					$bind_name = 'bind' . $i;
					$$bind_name = $Args[$i];
					$bind_names[] = &$$bind_name;
				}

				$bind_param = call_user_func_array(array($stmt, 'bind_param'), $bind_names);
				if (!$bind_param) {
					throw new \Exception($this->mysqli->error, $this->mysqli->errno);
				} 
				$result = $stmt->execute();
				

			} else {
				$result = $stmt->execute();
			}
		}
		$Ret["stmt"] = $stmt;
		$Ret["result"] = $result;
		
		return $Ret;
	}

	/**
	* @brief INSERT, UPDATE, DELETE같은 단일실행 쿼리처리함수.
	* @param string $query
	* @return array
	*/
	function execute($query)
	{
		$args = func_get_args();
		$Args = array();

		for($i=1; $i<count($args); $i++) {
			$arg = $args[$i];
			$Args = array_merge($Args, array($arg));
		}

		$Res = $this->prepare($query, $Args);
		$stmt = $Res["stmt"];
		$this->insert_id = $stmt->insert_id;
		$this->affected_rows = $stmt->affected_rows;
		
		if ($stmt && $stmt->errno == 0) {
			return $Res["result"];
		} else {
			$this->StmtInfo[ $this->connection_id ] = array(
				"affected_rows" => $stmt->affected_rows,
				"insert_id" => $stmt->insert_id,
				"num_rows" => $stmt->num_rows,
				"param_count" => $stmt->param_count,
				"field_count" => $stmt->field_count,
				"errno" => $stmt->errno,
				"error" => $stmt->error,
				"state" => $stmt->error_list[0]["sqlstate"]
			);
		}

	}


	/**
	* @brief SELECT row가 1행일 경우 쿼리처리함수.
	* @param string $query
	* @return array
	*/
	function getResult($query)
	{

		$args = func_get_args();
		$Args = array();

		for($i=1; $i<count($args); $i++) {
			$arg = $args[$i];
			$Args = array_merge($Args, array($arg));
		}

		$Res = $this->prepare($query, $Args);
		$stmt = $Res["stmt"];

		if ($stmt && $stmt->errno == 0) {

			$result = $stmt->get_result();
			$row = $result->fetch_array(MYSQLI_ASSOC);

			return $row;
		} else {
			$this->StmtInfo[ $this->connection_id ] = array(
				"affected_rows" => $stmt->affected_rows,
				"insert_id" => $stmt->insert_id,
				"num_rows" => $stmt->num_rows,
				"param_count" => $stmt->param_count,
				"field_count" => $stmt->field_count,
				"errno" => $stmt->errno,
				"error" => $stmt->error,
				"state" => $stmt->error_list[0]["sqlstate"]
			);

		}

	}


	/**
	* @brief SELECT 여러행 조회일 경우 key value방식 쿼리처리함수.
	* @param string $query
	* @return array
	*/
	function getList($query)
	{
		$args = func_get_args();
		$Args = array();

		for($i=1; $i<count($args); $i++) {
			$arg = $args[$i];
			$Args = array_merge($Args, array($arg));
		}

		$Res = $this->prepare($query, $Args);
		$stmt = $Res["stmt"];

		if ($stmt && $stmt->errno == 0) {
			$result = $stmt->get_result();

			$rs = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$rs[] = $row; 
			}

			return $rs;
		} else {
			$this->StmtInfo[ $this->connection_id ] = array(
				"affected_rows" => $stmt->affected_rows,
				"insert_id" => $stmt->insert_id,
				"num_rows" => $stmt->num_rows,
				"param_count" => $stmt->param_count,
				"field_count" => $stmt->field_count,
				"errno" => $stmt->errno,
				"error" => $stmt->error,
				"state" => $stmt->error_list[0]["sqlstate"]
			);

		}
	}

	/**
	* @brief 마지막 삽입한 primary key값 가져오는 함수
	* @return int
	*/
	function insert_id()
	{
		return  $this->mysqli->insert_id;
	}

}








