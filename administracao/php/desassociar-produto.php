<?php
	include("config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto']) && isset($_POST['produto_associado']) && !empty($_POST['produto_associado'])) {
		if (isset($_POST['editar'] && $_POST['editar']==1) {
			$result = $pdo->prepare("SELECT * FROM produto_associado WHERE produto = :produto AND produto_associado = :produto_associado");
			$result->execute(array('produto' => $_POST['produto'], 'produto_associado' => $_POST['produto_associado']));
			if ($result->rowCount()>0) {
				$query = $pdo->prepare("DELETE FROM produto_associado WHERE produto = :produto AND produto_associado = :produto_associado");
				$query->execute(array('produto' => $_POST['produto'], 'produto_associado' => $_POST['produto_associado']));
			}
		} else {
			$result = $pdo->prepare("SELECT * FROM produto_associado_temp WHERE produto_temp = :produto AND produto_associado = :produto_associado");
			$result->execute(array('produto' => $_POST['produto'], 'produto_associado' => $_POST['produto_associado']));
			if ($result->rowCount()>0) {
				$query = $pdo->prepare("DELETE FROM produto_associado_temp WHERE produto_temp = :produto AND produto_associado = :produto_associado");
				$query->execute(array('produto' => $_POST['produto'], 'produto_associado' => $_POST['produto_associado']));
			}
		}
	}
?>