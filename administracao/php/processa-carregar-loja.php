<?php
	$result_loja = $pdo->prepare("SELECT * FROM loja WHERE id_loja = 1");
	$result_loja->execute();
	$row_loja = $result_loja->fetch();
?>