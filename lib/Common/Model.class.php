<?php
namespace Common;

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
	 * 데이테베이스의 결과를 모두 가져와서 list에 넣는다.
	 *
	 * @param [type] $query
	 * @return void
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

	function insert_id()
	{
		return  $this->mysqli->insert_id;
	}

}








