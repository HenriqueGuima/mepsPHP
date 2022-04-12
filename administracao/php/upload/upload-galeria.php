<?php
	include("../config.php");
	include("../redimage.php");

	$result = $pdo->prepare("SELECT * FROM galeria ORDER BY ordem ASC");
	$result->execute();
	$row = $result->fetch();
	if ($result->rowCount()>0) {
		for ($i=1; $i<=$result->rowCount(); $i++) {
			$query = $pdo->prepare("UPDATE galeria SET ordem = :ordem WHERE id_galeria = :galeria");
			$query->execute(array('ordem' => $i, 'galeria' => $row['id_galeria']));
			$row = $result->fetch();
		}
		$ordem = $result->rowCount() + 1;
	} else {
		$ordem = 1;
	}

	$query = $pdo->prepare("INSERT INTO galeria (ordem) VALUES (:ordem)");
	$query->execute(array('ordem' => $ordem));
	$galeria = $pdo->lastInsertId();

	$caminho = "../../../assets/img/galeria/".$galeria.".jpg";
	$redimensionar = new abeManagement();
	move_uploaded_file($_FILES['file']['tmp_name'], $caminho);
	$redimensionar->resizeImage($caminho, 1200, 800);
	$redimensionar->cropImage($caminho, 1200, 800);
?>