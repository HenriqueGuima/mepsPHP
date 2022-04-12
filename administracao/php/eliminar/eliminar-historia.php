<?php
	include("../config.php");

	if (isset($_POST['historia']) && !empty($_POST['historia'])) {
		$query = $pdo->prepare("DELETE FROM historia WHERE id_historia = :historia");
		$query->execute(array('historia' => $_POST['historia']));
		unlink("../../../assets/img/historia/".$_POST['historia'].".jpg");
		echo "";
    } else {
    	echo "erro";
    }
?>