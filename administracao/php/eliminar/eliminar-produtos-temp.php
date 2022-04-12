<?php
	$result = $pdo->prepare("SELECT * FROM produto_temp WHERE data < :hoje");
	$result->execute(array('hoje' => date("Y-m-d")));
	$row = $result->fetch();
	if ($result->rowCount()>0) {
		for ($i=1; $i<=$result->rowCount(); $i++) {
			$produto = $row['id_produto_temp'];

			$result_imagem_produto_temp = $pdo->prepare("SELECT * FROM imagem_produto_temp WHERE produto = :produto ORDER BY ordem ASC");
			$result_imagem_produto_temp->execute(array('produto' => $produto));
			$row_imagem_produto_temp = $result_imagem_produto_temp->fetch();
			if ($result_imagem_produto_temp->rowCount()>0) {
				for ($x=1; $x<=$result_imagem_produto_temp->rowCount(); $x++) {
					if (file_exists("../../../produtos/temp/".$produto."/".$row_imagem_produto_temp['imagem'].".jpg")) {
						unlink("../../../produtos/temp/".$produto."/".$row_imagem_produto_temp['imagem'].".jpg");
					}
					$row_imagem_produto_temp = $result_imagem_produto_temp->fetch();
				}
			}
			$pasta = "../../produtos/temp/".$produto;
			if (is_dir($pasta)) {
			 	rmdir($pasta);
			}

			$query = $pdo->prepare("DELETE FROM produto_associado_temp WHERE produto_temp = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE FROM imagem_produto_temp WHERE produto = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE FROM produto_temp WHERE id_produto_temp = :produto");
			$query->execute(array('produto' => $produto));

			$row = $result->fetch();
		}
	}
?>