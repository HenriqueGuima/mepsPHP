<?php
	include("../config.php");
	include("../redimage.php");

	if (isset($_FILES['imagem']) && ($_FILES['imagem']['size']>0)) {
		unlink("../../../assets/img/mobile.jpg");
		$caminho = "../../../assets/img/mobile.jpg";
		$redimensionar = new abeManagement();
		move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
		$redimensionar->resizeImage($caminho, 480, 736);
		$redimensionar->cropImage($caminho, 480, 735);
	}
	header("Location: ../../home.php");
?>