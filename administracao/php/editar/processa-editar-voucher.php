<?php
	include("../config.php");

	$msg = "";
	if (isset($_POST['codigo']) && !empty($_POST['codigo'])) {
		$codigo = htmlentities($_POST['codigo'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O código não se encontra preenchido!<br>";
	}
	if (isset($_POST['tipo_desconto']) && !empty($_POST['tipo_desconto'])) {
		$tipo_desconto = htmlentities($_POST['tipo_desconto'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O tipo de desconto não se encontra preenchido!<br>";
	}
	if (isset($_POST['desconto']) && !empty($_POST['desconto'])) {
		$desconto = htmlentities($_POST['desconto'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O desconto não se encontra preenchido!<br>";
	}
	if (isset($_POST['estado'])) {
		$estado = htmlentities($_POST['estado'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O estado não se encontra selecionado!<br>";
	}
	$voucher = $_POST['voucher'];

	if ($msg!="") {
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Erro!</strong><br>
				'.$msg.'
			  </div>';
	} else {
		$query = $pdo->prepare("UPDATE voucher SET codigo = :codigo, tipo_desconto = :tipo_desconto, desconto = :desconto, estado = :estado WHERE id_voucher = :voucher");
		$query->execute(array('codigo' => $_POST['codigo'], 'tipo_desconto' => $_POST['tipo_desconto'], 'desconto' => $_POST['desconto'], 'estado' => $_POST['estado'], 'voucher' => $_POST['voucher']));

		if (isset($_POST['valor_minimo']) && !empty($_POST['valor_minimo'])) {
			$valor_minimo = nl2br(htmlentities($_POST['valor_minimo'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE voucher SET valor_minimo = :valor_minimo WHERE id_voucher = :voucher");
			$query->execute(array('valor_minimo' => $valor_minimo, 'voucher' => $voucher));
		}
		if (isset($_POST['limite_utilizacoes']) && !empty($_POST['limite_utilizacoes'])) {
			$limite_utilizacoes = nl2br(htmlentities($_POST['limite_utilizacoes'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE voucher SET limite_utilizacoes = :limite_utilizacoes WHERE id_voucher = :voucher");
			$query->execute(array('limite_utilizacoes' => $limite_utilizacoes, 'voucher' => $voucher));
		}
		if (isset($_POST['data_expiracao']) && !empty($_POST['data_expiracao'])) {
			$data_expiracao = $_POST['data_expiracao'];
			$query = $pdo->prepare("UPDATE voucher SET data_expiracao = :data_expiracao WHERE id_voucher = :voucher");
			$query->execute(array('data_expiracao' => $data_expiracao, 'voucher' => $voucher));
		}
		if (isset($_POST['cliente']) && !empty($_POST['cliente'])) {
			$cliente = nl2br(htmlentities($_POST['cliente'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE voucher SET cliente = :cliente WHERE id_voucher = :voucher");
			$query->execute(array('cliente' => $cliente, 'voucher' => $voucher));
		}
		echo '';
	}
?>