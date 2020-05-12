<?php
spl_autoload_register("neopleAutoload");
/** TODO:: doxygen 주석달기 */
function neopleAutoload($class)
{
	$class_file = str_replace("\\", DS, $class);
	$file = HOME . DS. "lib" . DS . $class_file . ".class.php";
	include $file;
}



