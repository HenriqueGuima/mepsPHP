<?php
	include("../config.php");

	if (isset($_POST['categoria']) && !empty($_POST['categoria'])) {
		$query = $pdo->prepare("DELETE FROM categoria WHERE id_categoria = :categoria");
		$query->execute(array('categoria' => $_POST['categoria']));
		$query = $pdo->prepare("DELETE FROM categoria WHERE categoria_pai = :categoria");
		$query->execute(array('categoria' => $_POST['categoria']));
		$query = $pdo->prepare("UPDATE produto SET categoria = NULL WHERE categoria = :categoria");
		$query->execute(array('categoria' => $_POST['categoria']));
		if (file_exists("../../../assets/img/categorias/".$_POST['categoria'].".jpg")) {
			unlink("../../../assets/img/categorias/".$_POST['categoria'].".jpg");
		}
		echo "";
	} else {
		echo "erro";
	}
?>