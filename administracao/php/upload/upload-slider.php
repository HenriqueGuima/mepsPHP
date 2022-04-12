<?php
	include("../config.php");
	include("../redimage.php");

	if (isset($_FILES['imagem']) && ($_FILES['imagem']['size']>0)) {
		$result = $pdo->prepare("SELECT * FROM slider ORDER BY ordem ASC");
		$result->execute();
		$row = $result->fetch();
		if ($result->rowCount()>0) {
			for ($i=1; $i<=$result->rowCount(); $i++) {
				$query = $pdo->prepare("UPDATE slider SET ordem = :ordem WHERE id_slider = :slider");
				$query->execute(array('ordem' => $i, 'slider' => $row['id_slider']));
				$row = $result->fetch();
			}
			$ordem = $result->rowCount() + 1;
		} else {
			$ordem = 1;
		}

		$query = $pdo->prepare("INSERT INTO slider (ordem) VALUES (:ordem)");
		$query->execute(array('ordem' => $ordem));
		$slider = $pdo->lastInsertId();

		$caminho = "../../../assets/img/slider/".$slider.".jpg";
		$redimensionar = new abeManagement();
		move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
		$redimensionar->resizeImage($caminho, 1920, 1080);
		$redimensionar->cropImage($caminho, 1920, 1080);
	}
	header("Location: ../../home.php");
?>