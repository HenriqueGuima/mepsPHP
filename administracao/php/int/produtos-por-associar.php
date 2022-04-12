<?php
	include("../config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto'])) {
		echo '<option value="0">Selecione o Produto</option>';
		if (isset($_POST['editar']) && $_POST['editar']==1) {
			$result = $pdo->prepare("SELECT * FROM produto WHERE id_produto != :produto ORDER BY nome_pt ASC");
		    $result->execute(array('produto' => $_POST['produto']));
		    $row = $result->fetch();
		    if ($result->rowCount()>0) {
		        for ($i=1; $i<=$result->rowCount(); $i++) {
		            $result_associado = $pdo->prepare("SELECT * FROM produto_associado WHERE produto = :produto AND produto_associado = :produto_associado");
		            $result_associado->execute(array('produto' => $_POST['produto'], 'produto_associado' => $row['id_produto']));
		            if ($result_associado->rowCount()==0) {
		                echo '<option value="'.$row['id_produto'].'">'.$row['nome_pt'].'</option>';
		            }
		            $row = $result->fetch();
		        }
		    }
		} else {
			$result = $pdo->prepare("SELECT * FROM produto ORDER BY nome_pt ASC");
			$result->execute();
			$row = $result->fetch();
			if ($result->rowCount()>0) {
				for ($i=1; $i<=$result->rowCount(); $i++) {
					$result_associado = $pdo->prepare("SELECT * FROM produto_associado_temp WHERE produto_temp = :produto AND produto_associado = :produto_associado");
					$result_associado->execute(array('produto' => $_POST['produto'], 'produto_associado' => $row['id_produto']));
					if ($result_associado->rowCount()==0) {
						echo '<option value="'.$row['id_produto'].'">'.$row['nome_pt'].'</option>';
					}
					$row = $result->fetch();
				}
			}
		}
	}
?>