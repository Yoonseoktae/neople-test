<?php
spl_autoload_register("neopleAutoload");

/**
* @brief 클래스파일 오토로드
* @return object
*/
function neopleAutoload($class)
{
	$class_file = str_replace("\\", DS, $class);
	$file = HOME . DS. "lib" . DS . $class_file . ".class.php";
	include $file;
}



