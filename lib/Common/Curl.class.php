<?php
namespace Common;

/**
* @file lib/Common/Curl.class.php
* @brief REST API 서버간 통신을 위한 CURL 클래스
* @author 윤석태 (seknman123@naver.com)
*/
class Curl {

	private $target = "";
	private $method = "";
	private $data = [];
	private $curl;
	private $response;
	private $accept = "application/json";
	private $contentType = "application/json";

	function __construct() {}

	public function exec($CurlInfo) {

		$this->target = $CurlInfo['target'];
		$this->method = $CurlInfo['method'];
		$this->data = $CurlInfo['data'];
		
		$header = array("Accept:{$this->accept}", "Content-Type:{$this->contentType}");

		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($this->curl, CURLOPT_URL, $this->target);
		curl_setopt($this->curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->method);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->data));
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		$this->response = curl_exec($this->curl);
		curl_close($this->curl);
		
		
		return $this->response;
	}

}
