<?php
	include("../config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto']) && isset($_POST['imagem']) && !empty($_POST['imagem'])) {
		if (isset($_POST['editar']) && $_POST['editar']==1) {
			$pasta = "../../../produtos/".$_POST['produto'];
			if (file_exists($pasta)) {
				$caminho = "../../../produtos/".$_POST['produto']."/".$_POST['imagem'].".jpg";
				if (file_exists($caminho)) {
					unlink($caminho);
					$query = $pdo->prepare("DELETE FROM imagem_produto WHERE imagem = :imagem AND produto = :produto");
					$query->execute(array('imagem' => $_POST['imagem'], 'produto' => $_POST['produto']));

					$result = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
					$result->execute(array('produto' => $_POST['produto']));
					$row = $result->fetch();
					if ($result->rowCount()>0) {
						$query = $pdo->prepare("UPDATE imagem_produto SET ordem = :ordem WHERE id_imagem_produto = :imagem_produto");
						$query->execute(array('ordem' => $i, 'imagem_produto' => $row['id_imagem_produto']));
						$row = $result->fetch();
					}
				}
			}
			echo "";
		} else {
			$pasta = "../../../produtos/temp/".$_POST['produto'];
			if (file_exists($pasta)) {
				$caminho = "../../../produtos/temp/".$_POST['produto']."/".$_POST['imagem'].".jpg";
				if (file_exists($caminho)) {
					unlink($caminho);
					$query = $pdo->prepare("DELETE FROM imagem_produto_temp WHERE imagem = :imagem AND produto = :produto");
					$query->execute(array('imagem' => $_POST['imagem'], 'produto' => $_POST['produto']));

					$result = $pdo->prepare("SELECT * FROM imagem_produto_temp WHERE produto = :produto ORDER BY ordem ASC");
					$result->execute(array('produto' => $id));
					$row = $result->fetch();
					if ($result->rowCount()>0) {
						for ($i=1; $i<=$result->rowCount(); $i++) {
							$query = $pdo->prepare("UPDATE imagem_produto_temp SET ordem = :ordem WHERE id_imagem_produto_temp = :imagem_produto_temp");
							$query->execute(array('ordem' => $i, 'imagem_produto_temp' => $row['id_imagem_produto_temp']));
							$row = $result->fetch();
						}
					}
				}
			}
			echo "";
		}
    } else {
    	echo "erro";
    }
?>