<?php
	include("config.php");

	$vendas = array();
	$visitas = array();
	$produtos = array();

	for ($i=1; $i<=12; $i++) {
		if ($i<10) {
			$mes = "0".$i;
		} else {
			$mes = $i;
		}

		$result_venda = $pdo->prepare("SELECT * FROM encomenda WHERE MONTH(data_encomenda) = :mes AND YEAR(data_encomenda) = :ano AND estado != 3");
		$result_venda->execute(array('mes' => $mes, 'ano' => date("Y")));
		$row_venda = $result_venda->fetch();
		array_push($vendas, $result_venda->rowCount());

		$result_visita = $pdo->prepare("SELECT * FROM visita_global WHERE mes = :mes AND ano = :ano");
		$result_visita->execute(array('mes' => $mes, 'ano' => date("Y")));
		$row_visita = $result_visita->fetch();
		if ($result_visita->rowCount()>0) {
			$quantidade = $row_visita['quantidade'];
		} else {
			$quantidade = 0;
		}
		array_push($visitas, $quantidade);

		$produtos_comprados = 0;
		if ($result_venda->rowCount()>0) {
			for ($x=1; $x<=$result_venda->rowCount(); $x++) {
				$result_carrinho_produto = $pdo->prepare("SELECT * FROM carrinho_produto WHERE carrinho = :carrinho");
				$result_carrinho_produto->execute(array('carrinho' => $row_venda['carrinho']));
				$produtos_comprados += $result_carrinho_produto->rowCount();
				$row_venda = $result_venda->fetch();
			}
		}
		array_push($produtos, $produtos_comprados);
	}

	$array = array($vendas, $visitas, $produtos);
	echo json_encode($array);
?>