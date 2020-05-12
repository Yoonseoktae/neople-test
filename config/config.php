<?php

global $_CONFIG, $_ROUTE;
/** TODO:: doxygen 주석달기 */
function getRoute() {
	$request_uri = trim($_SERVER['REQUEST_URI'], "/");
	$RequestURI = explode("?", $request_uri);
	
	if (!$RequestURI[0]) $Route = array("index");
	else $Route = explode("/", $RequestURI[0]);
	
	return implode(DS , $Route);
}

$_ROUTE = getRoute();

$_CONFIG = array(
	"title" => "네오플 인프라개발팀 웹부분 지원자 윤석태 과제",
	"version" => "1.0.0",
	"database" => array(
		"host" => "",
		"user" => "root",
		"password" => ""
	)
);


