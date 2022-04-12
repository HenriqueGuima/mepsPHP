<?php
	include("../config.php");

	if (isset($_POST['editar']) && !empty($_POST['editar'])) {
		$result = $pdo->prepare("SELECT * FROM categoria WHERE slug = :slug AND id_categoria != :categoria");
		$result->execute(array('slug' => $_POST['slug'], 'categoria' => $_POST['categoria']));
		echo $result->rowCount();
	} else {
		$result = $pdo->prepare("SELECT * FROM categoria WHERE slug = :slug");
		$result->execute(array('slug' => $_POST['slug']));
		echo $result->rowCount();
	}
?>