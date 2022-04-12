<?php
	include("../config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto'])) {
		$result = $pdo->prepare("SELECT * FROM produto WHERE id_produto = :produto");
		$result->execute(array('produto' => $_POST['produto']));
		$row = $result->fetch();
		if ($result->rowCount()>0) {
			$result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
			$result_imagem_produto->execute(array('produto' => $row['id_produto']));
			$row_imagem_produto = $result_imagem_produto->fetch();
			if ($result_imagem_produto->rowCount()>0) {
				$url = "../produtos/".$row_imagem_produto['produto']."/".$row_imagem_produto['imagem'].".jpg";
			} else {
				$url = "assets/img/sem-imagem.jpg";
			}
			echo '<img src="'.$url.'" alt="Imagem" width="500">';
		}
	}
?>