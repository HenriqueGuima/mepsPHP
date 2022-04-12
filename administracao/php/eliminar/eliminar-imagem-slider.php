<?php
	include("../config.php");

	if (isset($_POST['imagem']) && !empty($_POST['imagem'])) {
		$query = $pdo->prepare("DELETE FROM slider WHERE id_slider = :imagem");
		$query->execute(array('imagem' => $_POST['imagem']));
		unlink("../../../assets/img/slider/".$_POST['imagem'].".jpg");
		echo "";
    } else {
    	echo "erro";
    }
?>