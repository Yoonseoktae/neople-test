<?php
	include "define.php";

	try {
		require VIEW . DS . "layout/normal.php";
	} catch(\exception $e) {
		var_dump($e);
	}
	