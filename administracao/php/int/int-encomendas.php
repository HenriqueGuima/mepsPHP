<?php
	include("../config.php");

	if (isset($_POST['filtro']) && !empty($_POST['filtro'])) {
        $estado = $_POST['estado'];
        if ($estado!="") {
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina = 1;
            }
            $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

            $result_total_registos = $pdo->prepare("SELECT * FROM encomenda WHERE estado = :estado");
            $result_total_registos->execute(array('estado' => $estado));
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontradas encomendas.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM encomenda WHERE estado = :estado ORDER BY id_encomenda DESC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('estado' => $estado, 'limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    if ($row['estado']==1) {
                        $estado = '<span class="badge badge-pill badge-soft-warning">Aguarda Pagamento</span>';
                    } else if ($row['estado']==2) {
                        $estado = '<span class="badge badge-pill badge-soft-success">Em Processamento</span>';
                    } else if ($row['estado']==3) {
                        $estado = '<span class="badge badge-pill badge-soft-success">Enviada</span>';
                    } else {
                        $estado = '<span class="badge badge-pill badge-soft-danger">Cancelada</span>';
                    }
                    $result_cliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :cliente");
                    $result_cliente->execute(array('cliente' => $row['cliente']));
                    $row_cliente = $result_cliente->fetch();
                    $nome_completo = explode(" ", $row_cliente['nome']);
                    $nome = $nome_completo[0];
                    $apelido = $nome_completo[count($nome_completo)-1];
                    $data_encomenda = date_create($row['data_encomenda']);
                    if ($row['metodo_pagamento']==1) {
                        $pagamento = "Cartão de Crédito";
                    } else if ($row['metodo_pagamento']==2) {
                        $pagamento = "MB Way";
                    } else if ($row['metodo_pagamento']==3) {
                        $pagamento = "Multibanco";
                    } else {
                        $pagamento = "PayPal";
                    }
                    echo '<tr>
                            <td><a href="encomenda.php?id='.$row['id_encomenda'].'" class="fw-bold">#'.$row['referencia'].'</a></td>
                            <td>'.$nome.' '.$apelido.'</td>
                            <td>'.date_format($data_encomenda, 'd/m/Y H:i').'</td>
                            <td>'.$row['total'].'€</td>
                            <td>'.$estado.'</td>
                            <td><i class="material-icons md-payment font-xxl text-muted mr-5"></i> '.$pagamento.'</td>
                            <td class="text-end"><a href="encomenda.php?id='.$row['id_encomenda'].'" class="btn btn-xs"> Detalhes</a></td>
                          </tr>';
                    $row = $result->fetch();
                }
            }
        } else {
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina = 1;
            }
            $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

            $result_total_registos = $pdo->prepare("SELECT * FROM encomenda");
            $result_total_registos->execute();
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontradas encomendas.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM encomenda ORDER BY id_encomenda DESC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    if ($row['estado']==1) {
                        $estado = '<span class="badge badge-pill badge-soft-warning">Aguarda Pagamento</span>';
                    } else if ($row['estado']==2) {
                        $estado = '<span class="badge badge-pill badge-soft-success">Em Processamento</span>';
                    } else if ($row['estado']==3) {
                        $estado = '<span class="badge badge-pill badge-soft-success">Enviada</span>';
                    } else {
                        $estado = '<span class="badge badge-pill badge-soft-danger">Cancelada</span>';
                    }
                    $result_cliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :cliente");
                    $result_cliente->execute(array('cliente' => $row['cliente']));
                    $row_cliente = $result_cliente->fetch();
                    $nome_completo = explode(" ", $row_cliente['nome']);
                    $nome = $nome_completo[0];
                    $apelido = $nome_completo[count($nome_completo)-1];
                    $data_encomenda = date_create($row['data_encomenda']);
                    if ($row['metodo_pagamento']==1) {
                        $pagamento = "Cartão de Crédito";
                    } else if ($row['metodo_pagamento']==2) {
                        $pagamento = "MB Way";
                    } else if ($row['metodo_pagamento']==3) {
                        $pagamento = "Multibanco";
                    } else {
                        $pagamento = "PayPal";
                    }
                    echo '<tr>
                            <td><a href="encomenda.php?id='.$row['id_encomenda'].'" class="fw-bold">#'.$row['referencia'].'</a></td>
                            <td>'.$nome.' '.$apelido.'</td>
                            <td>'.date_format($data_encomenda, 'd/m/Y H:i').'</td>
                            <td>'.$row['total'].'€</td>
                            <td>'.$estado.'</td>
                            <td><i class="material-icons md-payment font-xxl text-muted mr-5"></i> '.$pagamento.'</td>
                            <td class="text-end"><a href="encomenda.php?id='.$row['id_encomenda'].'" class="btn btn-xs"> Detalhes</a></td>
                          </tr>';
                    $row = $result->fetch();
                }
            }
        }
	} else {
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina = 1;
        }
        $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

        $result_total_registos = $pdo->prepare("SELECT * FROM encomenda");
        $result_total_registos->execute();
        if ($result_total_registos->rowCount()==0) {
            echo 'Não foram encontradas encomendas.';
        } else {
            $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
            $limite_inferior = ($pagina - 1) * $limite_pagina;

            $result = $pdo->prepare("SELECT * FROM encomenda ORDER BY id_encomenda DESC LIMIT :limite_inferior, :limite_pagina");
            $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
            $row = $result->fetch();
            for ($i=1; $i<=$result->rowCount(); $i++) {
                if ($row['estado']==1) {
                    $estado = '<span class="badge badge-pill badge-soft-warning">Aguarda Pagamento</span>';
                } else if ($row['estado']==2) {
                    $estado = '<span class="badge badge-pill badge-soft-success">Em Processamento</span>';
                } else if ($row['estado']==3) {
                    $estado = '<span class="badge badge-pill badge-soft-success">Enviada</span>';
                } else {
                    $estado = '<span class="badge badge-pill badge-soft-danger">Cancelada</span>';
                }
                $result_cliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :cliente");
                $result_cliente->execute(array('cliente' => $row['cliente']));
                $row_cliente = $result_cliente->fetch();
                $nome_completo = explode(" ", $row_cliente['nome']);
                $nome = $nome_completo[0];
                $apelido = $nome_completo[count($nome_completo)-1];
                $data_encomenda = date_create($row['data_encomenda']);
                if ($row['metodo_pagamento']==1) {
                    $pagamento = "Cartão de Crédito";
                } else if ($row['metodo_pagamento']==2) {
                    $pagamento = "MB Way";
                } else if ($row['metodo_pagamento']==3) {
                    $pagamento = "Multibanco";
                } else {
                    $pagamento = "PayPal";
                }
                echo '<tr>
                        <td><a href="encomenda.php?id='.$row['id_encomenda'].'" class="fw-bold">#'.$row['referencia'].'</a></td>
                        <td>'.$nome.' '.$apelido.'</td>
                        <td>'.date_format($data_encomenda, 'd/m/Y H:i').'</td>
                        <td>'.$row['total'].'€</td>
                        <td>'.$estado.'</td>
                        <td><i class="material-icons md-payment font-xxl text-muted mr-5"></i> '.$pagamento.'</td>
                        <td class="text-end"><a href="encomenda.php?id='.$row['id_encomenda'].'" class="btn btn-xs"> Detalhes</a></td>
                      </tr>';
                $row = $result->fetch();
            }
        }
	}
?>