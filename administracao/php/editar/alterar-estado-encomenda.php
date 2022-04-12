<?php
	include("../config.php");

	if (isset($_POST['encomenda']) && !empty($_POST['encomenda'])) {
		$query = $pdo->prepare("UPDATE encomenda SET estado = :estado WHERE id_encomenda = :encomenda");
		$query->execute(array('estado' => $_POST['estado'], 'encomenda' => $_POST['encomenda']));
		echo "";
	} else {
		echo "erro";
	}
?>