<?php
	include("config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto']) && isset($_POST['produto_associado']) && !empty($_POST['produto_associado'])) {
		if (isset($_POST['editar']) && $_POST['editar']==1) {
			$result = $pdo->prepare("SELECT * FROM produto_associado WHERE produto = :produto AND produto_associado = :produto_associado");
			$result->execute(array('produto' => $_POST['produto'], 'produto_associado' => $_POST['produto_associado']));
			if ($result->rowCount()==0) {
				$result = $pdo->prepare("SELECT * FROM produto_associado WHERE produto = :produto ORDER BY ordem ASC");
				$result->execute(array('produto' => $_POST['produto']));
				$row = $result->fetch();
				if ($result->rowCount()>0) {
					for ($i=1; $i<=$result->rowCount(); $i++) {
						$query = $pdo->prepare("UPDATE produto_associado SET ordem = :ordem WHERE id_produto_associado = :produto_associado");
						$query->execute(array('ordem' => $i, 'produto_associado' => $row['id_produto_associado']));
						$row = $result->fetch();
					}
					$ordem = $result->rowCount() + 1;
				} else {
					$ordem = 1;
				}
				$query = $pdo->prepare("INSERT INTO produto_associado (produto, produto_associado, ordem) VALUES (:produto, :produto_associado, :ordem)");
				$query->execute(array('produto' => $_POST['produto'], 'produto_associado' => $_POST['produto_associado'], 'ordem' => $ordem));
			}
			echo "";
		} else {
			$result = $pdo->prepare("SELECT * FROM produto_associado_temp WHERE produto_temp = :produto AND produto_associado = :produto_associado");
			$result->execute(array('produto' => $_POST['produto'], 'produto_associado' => $_POST['produto_associado']));
			if ($result->rowCount()==0) {
				$result = $pdo->prepare("SELECT * FROM produto_associado_temp WHERE produto_temp = :produto ORDER BY ordem ASC");
				$result->execute(array('produto' => $_POST['produto']));
				$row = $result->fetch();
				if ($result->rowCount()>0) {
					for ($i=1; $i<=$result->rowCount(); $i++) {
						$query = $pdo->prepare("UPDATE produto_associado_temp SET ordem = :ordem WHERE id_produto_associado_temp = :produto_associado_temp");
						$query->execute(array('ordem' => $i, 'produto_associado_temp' => $row['id_produto_associado_temp']));
						$row = $result->fetch();
					}
					$ordem = $result->rowCount();
				} else {
					$ordem = 1;
				}
				$query = $pdo->prepare("INSERT INTO produto_associado_temp (produto_temp, produto_associado, ordem) VALUES (:produto, :produto_associado, :ordem)");
				$query->execute(array('produto' => $_POST['produto'], 'produto_associado' => $_POST['produto_associado'], 'ordem' => $ordem));
			}
			echo "";
		}
	} else {
		echo "erro";
	}
?>