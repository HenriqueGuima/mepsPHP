<?php
	include("../config.php");

	if (isset($_POST['imagem']) && !empty($_POST['imagem'])) {
		$query = $pdo->prepare("DELETE FROM galeria WHERE id_galeria = :imagem");
		$query->execute(array('imagem' => $_POST['imagem']));
		unlink("../../../assets/img/galeria/".$_POST['imagem'].".jpg");
		echo "";
    } else {
    	echo "erro";
    }
?>