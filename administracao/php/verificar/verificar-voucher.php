<?php
	include("config.php");

	if (isset($_POST['voucher']) && !empty($_POST['voucher'])) {
		$result = $pdo->prepare("SELECT * FROM voucher WHERE codigo = :codigo AND id_voucher != :voucher");
		$result->execute(array('codigo' => $_POST['codigo'], 'voucher' => $_POST['voucher']));
		echo $result->rowCount();
	} else {
		$result = $pdo->prepare("SELECT * FROM voucher WHERE codigo = :codigo");
		$result->execute(array('codigo' => $_POST['codigo']));
		echo $result->rowCount();
	}
?>