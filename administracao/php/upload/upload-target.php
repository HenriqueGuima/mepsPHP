<?php
	include("../config.php");
	include("../redimage.php");

	foreach ($_POST as $key => $val) {
		echo $key.": ".$val."\n";
	}
	if (isset($_GET['produto']) && !empty($_GET['produto'])) {
		$produto = $_GET['produto'];

		if (isset($_GET['editar']) && !empty($_GET['editar'])) {
			if (!file_exists("../../../produtos/".$produto)) {
				mkdir("../../../produtos/".$produto, 0777, true);
			}

			$result = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
			$result->execute(array('produto' => $produto));
			$row = $result->fetch();
			if ($result->rowCount()>0) {
				for ($i=1; $i<=$result->rowCount(); $i++) {
					$query = $pdo->prepare("UPDATE imagem_produto SET ordem = :ordem WHERE id_imagem_produto = :imagem_produto");
					$query->execute(array('ordem' => $i, 'imagem_produto' => $row['id_imagem_produto']));
					$row = $result->fetch();
				}
				$ordem = $result->rowCount() + 1;
			} else {
				$ordem = 1;
			}

			$result = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY imagem DESC");
			$result->execute(array('produto' => $produto));
			$row = $result->fetch();
			if ($result->rowCount()>0) {
				$imagem = $row['imagem'] + 1;
			} else {
				$imagem = 1;
			}

			$caminho = "../../../produtos/".$produto."/".$imagem.".jpg";
			$redimensionar = new abeManagement();
			move_uploaded_file($_FILES['file']['tmp_name'], $caminho);
			$redimensionar->resizeImage($caminho, 1100, 1100);
			$redimensionar->cropImage($caminho, 1100, 1100);

			$query = $pdo->prepare("INSERT INTO imagem_produto (imagem, produto, ordem) VALUES (:imagem, :produto, :ordem)");
			$query->execute(array('imagem' => $imagem, 'produto' => $produto, 'ordem' => $ordem));
			$error = false;
		} else {
			if (!file_exists("../../../produtos/temp/".$produto)) {
				mkdir("../../../produtos/temp/".$produto, 0777, true);
			}

			$result = $pdo->prepare("SELECT * FROM imagem_produto_temp WHERE produto = :produto ORDER BY ordem ASC");
			$result->execute(array('produto' => $produto));
			$row = $result->fetch();
			if ($result->rowCount()>0) {
				for ($i=1; $i<=$result->rowCount(); $i++) {
					$query = $pdo->prepare("UPDATE imagem_produto_temp SET ordem = :ordem WHERE id_imagem_produto_temp = :imagem_produto");
					$query->execute(array('ordem' => $i, 'imagem_produto' => $row['id_imagem_produto_temp']));
					$row = $result->fetch();
				}
				$ordem = $result->rowCount() + 1;
			} else {
				$ordem = 1;
			}

			$result = $pdo->prepare("SELECT * FROM imagem_produto_temp WHERE produto = :produto ORDER BY imagem DESC");
			$result->execute(array('produto' => $produto));
			$row = $result->fetch();
			if ($result->rowCount()>0) {
				$imagem = $row['imagem'] + 1;
			} else {
				$imagem = 1;
			}

			$caminho = "../../../produtos/temp/".$produto."/".$imagem.".jpg";
			$redimensionar = new abeManagement();
			move_uploaded_file($_FILES['file']['tmp_name'], $caminho);
			$redimensionar->resizeImage($caminho, 1100, 1100);
			$redimensionar->cropImage($caminho, 1100, 1100);

			$query = $pdo->prepare("INSERT INTO imagem_produto_temp (imagem, produto, ordem) VALUES (:imagem, :produto, :ordem)");
			$query->execute(array('imagem' => $imagem, 'produto' => $produto, 'ordem' => $ordem));
			$error = false;
		}

		if ($error) {
			die("Error: ".$error);
		} else {
			die("File: ".$file);
		}
	}
?>