<?php
	include("../config.php");

	if (isset($_POST['editar']) && !empty($_POST['editar'])) {
		$result = $pdo->prepare("SELECT * FROM produto WHERE slug = :slug AND id_produto != :produto");
		$result->execute(array('slug' => $_POST['slug'], 'produto' => $_POST['produto']));
		echo $result->rowCount();
	} else {
		$result = $pdo->prepare("SELECT * FROM produto WHERE slug = :slug");
		$result->execute(array('slug' => $_POST['slug']));
		echo $result->rowCount();
	}
?>