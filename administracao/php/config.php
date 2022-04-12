<?php
	$pdo = new PDO("mysql:dbname=meps;host=localhost;charset=utf8", "root", "");
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	include("processa-carregar-loja.php");
?>