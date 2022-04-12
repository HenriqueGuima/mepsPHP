<?php
	include("../config.php");

	if (isset($_GET['produto']) && !empty($_GET['produto'])) {
		$produto = $_GET['produto'];
		if (isset($_GET['editar']) && $_GET['editar']==1) {
			$result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
			$result_imagem_produto->execute(array('produto' => $produto));
			$row_imagem_produto = $result_imagem_produto->fetch();
			if ($result_imagem_produto->rowCount()>0) {
				for ($i=1; $i<=$result_imagem_produto->rowCount(); $i++) {
					echo '<div id="img-e-'.$row_imagem_produto['imagem'].'" class="brick">
							<a id="img-a-'.$row_imagem_produto['imagem'].'" class="btn-delete-imagem delete md-trigger" data-modal="modal-2" onclick="apagarImagem('.$row_imagem_produto['imagem'].')"><i class="fas fa-times"></i></a>
							<img src="../produtos/'.$produto.'/'.$row_imagem_produto['imagem'].'.jpg" id="img-'.$row_imagem_produto['imagem'].'" class="preload" alt="A carregar..." style="width: 100%; height: 100%; z-index:-10;">
						  </div>';
					$row_imagem_produto = $result_imagem_produto->fetch();
				}
				echo "<script>
						$(document).ready(function() {
							return $('.gridly').gridly({'responsive': true});
						});
					  </script>";
			}
		} else {
			$result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto_temp WHERE produto = :produto ORDER BY ordem ASC");
			$result_imagem_produto->execute(array('produto' => $produto));
			$row_imagem_produto = $result_imagem_produto->fetch();
			if ($result_imagem_produto->rowCount()>0) {
				for ($i=1; $i<=$result_imagem_produto->rowCount(); $i++) {
					echo '<div id="img-e-'.$row_imagem_produto['imagem'].'" class="brick">
							<a id="img-a-'.$row_imagem_produto['imagem'].'" class="btn-delete-imagem delete md-trigger" data-modal="modal-2" onclick="apagarImagem('.$row_imagem_produto['imagem'].')"><i class="fas fa-times"></i></a>
							<img src="../produtos/temp/'.$produto.'/'.$row_imagem_produto['imagem'].'.jpg" id="img-'.$row_imagem_produto['imagem'].'" class="preload" alt="A carregar..." style="width: 100%; height: 100%; z-index: -10;">
						  </div>';
					$row_imagem_produto = $result_imagem_produto->fetch();
				}
				echo "<script>
						$(document).ready(function() {
							return $('.gridly').gridly({'responsive': true});
						});
					  </script>";
			}
		}
	}
?>