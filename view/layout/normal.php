<!DOCTYPE html> 
<html lang="ko">
<head>
<title><?php echo $_TITLE?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>
	<!-- TODO: 경로 define 선언 -->
	<!-- gnb -->
	<?php include_once VIEW . "/layout/gnb.php" ?>
	<!-- content -->
	<?php include_once VIEW . "/content/{$_ROUTE}.php" ?>
	<!-- fnb -->
	<?php include_once VIEW . "/layout/fnb.php" ?>
	
</body>
</html>
