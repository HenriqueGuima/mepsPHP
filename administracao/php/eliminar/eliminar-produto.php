<?php
	include("../config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto'])) {
		$produto = $_POST['produto'];
		$result_carrinho = $pdo->prepare("SELECT * FROM carrinho_produto WHERE produto = :produto");
		$result_carrinho->execute(array('produto' => $produto));
		$row_carrinho = $result_carrinho->fetch();
		$checkout = 0;
		if ($result_carrinho->rowCount()>0) {
			for ($i=1; $i<=$result->rowCount(); $i++) {
				$result_encomenda = $pdo->prepare("SELECT * FROM encomenda WHERE carrinho = :carrinho AND (estado = 0 OR estado = 1)");
				$result_encomenda->execute(array('carrinho' => $row_carrinho['id_carrinho']));
				$row_encomenda = $result_encomenda->fetch();
				if ($result_encomenda->rowCount()>0) {
					$checkout = 1;
				}
				$row_carrinho = $result_carrinho->fetch();
			}
		}

		if ($checkout==0) {
			$query = $pdo->prepare("DELETE FROM carrinho_produto_temp WHERE produto = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE from carrinho_produto WHERE produto = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE FROM wishlist WHERE produto = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE FROM visita_produto WHERE produto = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE FROM produto_associado WHERE produto_associado = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE FROM produto_associado WHERE produto = :produto");
			$query->execute(array('produto' => $produto));

			$result = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
			$result->execute(array('produto' => $produto));
			$row = $result->fetch();
			if ($result->rowCount()>0) {
				for ($i=1; $i<=$result->rowCount(); $i++) {
					if (file_exists("../../../produtos/".$produto."/".$row['imagem'].".jpg")) {
						unlink("../../../produtos/".$produto."/".$row['imagem'].".jpg");
					}
					$row = $result->fetch();
				}
			}
			rmdir("../../../produtos/".$produto);
			$query = $pdo->prepare("DELETE FROM imagem_produto WHERE produto = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE FROM produto WHERE id_produto = :produto");
			$query->execute(array('produto' => $produto));
			echo "";
		} else {
			echo "O produto não pode ser eliminado pois está em encomendas em processamento.";
		}
	} else {
		echo "Ocorreu um erro de processamento. Tente novamente.";
	}
?>