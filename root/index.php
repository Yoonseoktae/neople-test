<?php
	include "define.php";

	try {

		$R = new Common\App();

		$RESULT = $R->initApp();
		$R->render($RESULT);

		
	} catch(\Exception $e) {
		var_dump($e);
	}
	