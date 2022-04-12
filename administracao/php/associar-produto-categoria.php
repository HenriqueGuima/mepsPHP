<?php
	include("config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto']) && isset($_POST['categoria']) && !empty($_POST['categoria'])) {
		$query = $pdo->prepare("UPDATE produto SET categoria = :categoria WHERE id_produto = :produto");
		$query->execute(array('categoria' => $_POST['categoria'], 'produto' => $_POST['produto']));
		echo "";
	} else {
		echo "erro";
	}
?>