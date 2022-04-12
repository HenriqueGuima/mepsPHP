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
	if (isset($_POST['estado']) && !empty($_POST['estado'])) {
		$estado = htmlentities($_POST['estado'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O estado não se encontra selecionado!<br>";
	}

	if ($msg!="") {
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Erro!</strong><br>
				'.$msg.'
			  </div>';
	} else {
		$query = $pdo->prepare("INSERT INTO voucher (codigo, tipo_desconto, desconto, estado) VALUES (:codigo, :tipo_desconto, :desconto, :estado)");
		$query->execute(array('codigo' => $_POST['codigo'], 'tipo_desconto' => $_POST['tipo_desconto'], 'desconto' => $_POST['desconto'], 'estado' => $_POST['estado']));

		$result = $pdo->prepare("SELECT * FROM voucher ORDER BY id_voucher DESC");
		$result->execute();
		$row = $result->fetch();

		if (isset($_POST['valor_minimo']) && $_POST['valor_minimo']!="") {
			$query = $pdo->prepare("UPDATE voucher SET valor_minimo = :valor_minimo WHERE id_voucher = :voucher");
			$query->execute(array('valor_minimo' => $_POST['valor_minimo'], 'voucher' => $row['id_voucher']));
		}

		if (isset($_POST['limite_utilizacoes']) && $_POST['limite_utilizacoes']!="") {
			$query = $pdo->prepare("UPDATE voucher SET limite_utilizacoes = :limite_utilizacoes WHERE id_voucher = :voucher");
			$query->execute(array('limite_utilizacoes' => $_POST['limite_utilizacoes'], 'voucher' => $row['id_voucher']));
		}

		if (isset($_POST['data_expiracao']) && $_POST['data_expiracao']!="") {
			$query = $pdo->prepare("UPDATE voucher SET data_expiracao = :data_expiracao WHERE id_voucher = :voucher");
			$query->execute(array('data_expiracao' => $_POST['data_expiracao'], 'voucher' => $row['id_voucher']));
		}

		if (isset($_POST['cliente']) && $_POST['cliente']!="") {
			$query = $pdo->prepare("UPDATE voucher SET cliente = :cliente WHERE id_voucher = :voucher");
			$query->execute(array('cliente' => $_POST['cliente'], 'voucher' => $row['id_voucher']));
		}
		echo "";
	}
?>