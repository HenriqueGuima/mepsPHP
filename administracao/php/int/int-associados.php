<?php
	include("../config.php");

	if (isset($_GET['produto']) && !empty($_GET['produto'])) {
		if ($_GET['editar']==1) {
			$result = $pdo->prepare("SELECT * FROM produto_associado WHERE produto = :produto ORDER BY ordem ASC");
			$result->execute(array('produto' => $_GET['produto']));
			$row = $result->fetch();
		} else {
			$result = $pdo->prepare("SELECT * FROM produto_associado_temp WHERE produto_temp = :produto ORDER BY id_produto_associado_temp ASC");
			$result->execute(array('produto' => $_GET['produto']));
			$row = $result->fetch();
		}
		if ($result->rowCount()>0) {
			for ($i=1; $i<=$result->rowCount(); $i++) {
				$produto = $row['produto_associado'];
				$result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
				$result_imagem_produto->execute(array('produto' => $produto));
				$row_imagem_produto = $result_imagem_produto->fetch();
				if ($result_imagem_produto->rowCount()>0) {
					$url = "../produtos/".$produto."/".$row_imagem_produto['imagem'].".jpg";
				} else {
					$url = "assets/img/sem-imagem.jpg";
				}
				echo '<div id="ass-img-'.$produto.'" class="brick">
						<a id="ass-a-'.$produto.'" class="delete md-trigger delete-produto-associado" onclick="eliminarProdutoAssociado('.$row['produto_associado'].')"><i class="fas fa-times"></i></a>
						<img src="'.$url.'" id="img-ass-'.$i.'" style="width: 100%; height: 100%; z-index: -10;">
					  </div>';
				$row = $result->fetch();
			}
		}
		echo "<script>
				$(document).ready(function() {
					return $('.gridly').gridly({'responsive': true});
				});
			  </script>";
	}
?>