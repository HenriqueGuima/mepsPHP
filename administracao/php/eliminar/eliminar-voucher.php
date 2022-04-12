<?php
	include("../config.php");

	if (isset($_POST['voucher']) && !empty($_POST['voucher'])) {
		$query = $pdo->prepare("DELETE FROM voucher WHERE id_voucher = :voucher");
		$query->execute(array('voucher' => $_POST['voucher']));
		echo "";
	} else {
		echo "erro";
	}
?>