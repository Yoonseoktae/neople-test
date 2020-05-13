<!DOCTYPE html> 
<html lang="ko">
<head>
<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>
	<!-- TODO: 경로 define 선언 -->
	<!-- gnb -->
	<?php require_once VIEW . "/layout/gnb.php" ?>
	<!-- content -->
	<?php require_once VIEW . "/content/{$this->route}.php" ?>
	<!-- fnb -->
	<?php require_once VIEW . "/layout/fnb.php" ?>
	
</body>
</html>
