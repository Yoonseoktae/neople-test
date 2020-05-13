<?php
namespace Common;

class App
{
	function __construct() {}

	function getRoute() {
		$request_uri = trim($_SERVER['REQUEST_URI'], "/");
		$RequestURI = explode("?", $request_uri);
		
		if (!$RequestURI[0]) $Route = array("index");
		else $Route = explode("/", $RequestURI[0]);
		
		return implode(DS , $Route);
	}

	function initApp()
	{
		$URL = parse_url($_SERVER["REQUEST_URI"]);
		$__URL_PATH = substr($URL["path"], 1);
		$this->Menu = explode("/", $__URL_PATH);
		if (!$this->Menu[0]) $this->Menu[0] = "index";

		$Menu = $this->Menu;
		
		if ( isset($_REQUEST["mode"]) && ( $_REQUEST["mode"] == "api") ) {
			array_unshift($Menu, "Api");
			array_unshift($Menu, "Controller");
		} else {
			array_unshift($Menu, "Web");
		}
		
		foreach($Menu as &$m) { $m = ucfirst($m); }
		
		$class_name = implode("\\", $Menu);
		
		if (!class_exists($class_name)) {
			throw new \Exception("Class {$class_name} not exists", 999000);
		}

		$this->class_name = $class_name;


		$R = new $class_name($this);

		return $R->run();

	}

	function render($RESULT)
	{
		$this->Result = $RESULT;
		$this->route = $this->getRoute();

		require VIEW . DS . "layout/normal.php";
		
	}

	

	
}