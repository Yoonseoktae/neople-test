<?php
namespace Common;

class RestApi 
{

	var $error_code;
	var $error_message;	
	var $http_method;
	var $input;
	var $curl;

	function __construct()
	{
		$this->http_method = ucfirst(strtolower( $_SERVER['REQUEST_METHOD'] ));

		$json = file_get_contents("php://input");
		$this->input = json_decode($json, true );
		
		$this->error_code = 0;
		$this->error_message = '';
		$this->curl = new Curl();
		
		$this->endpoint = $_SERVER["REQUEST_SCHEMA"].$_SERVER["HTTP_HOST"];

	}

	function throwError($code, $message, $Params = null)
	{
		$response_code = http_response_code();
		
		$this->setErrorCode($code, $message);
		$this->setErrorParams($Params);

		$Ret = array(
			"result" => false,
			"response_code" => $response_code,
			"error" => array(
				"code" => $this->error_code,
				"message" => $this->error_message,
				"params" => $this->error_params
			)
		);

		Header("Content-type: application/json");
		echo json_encode($Ret);
		exit(0);
	}

	function throwSuccess($Params = null)
	{
		$Ret = array(
			"result" => true,
			"data" => $Params
		);

		Header("Content-type: application/json");
		echo json_encode($Ret);
		exit(0);
	}

	function getRequest($key, $default = null)
	{
		$ret = isset($_REQUEST[$key])?$_REQUEST[$key]:null;
		if ($ret) return $ret;

		$ret = isset($this->input[$key])?$this->input[$key]:null;
		if ($ret) return $ret;

		if (!$ret) $ret = $default;
		
		return $ret;
	}

	function setErrorParams($Params)
	{
		$this->error_params = $Params;
	}
	
	function setErrorCode($code, $message)
	{
		$this->error_code = $code;
		$this->error_message = $message;
	}


}

