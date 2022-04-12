<?php
	include("config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto'])) {
		$query = $pdo->prepare("UPDATE produto SET categoria = NULL WHERE id_produto = :produto");
		$query->execute(array('produto' => $_POST['produto']));
		echo "";
	} else {
		echo "erro";
	}
?>