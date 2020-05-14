<!DOCTYPE html> 
<html lang="ko">
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<!-- css 가져오기 -->
	<link rel="stylesheet" type="text/css" href="/coco/resources/semantic.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/json2html/1.2.0/json2html.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.json2html/1.2.0/jquery.json2html.min.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
	<script type="text/javascript" src="/js/callback.js"></script>
	<script type="text/javascript" src="/js/board.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/board.css">
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
