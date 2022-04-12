<?php
	include("../config.php");

	if (isset($_POST['filtro']) && !empty($_POST['filtro'])) {
        $distrito = $_POST['distrito'];
        if ($distrito!="0") {
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina = 1;
            }
            $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

            $result_total_registos = $pdo->prepare("SELECT * FROM cliente WHERE distrito = :distrito");
            $result_total_registos->execute(array('distrito' => $distrito));
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontrados registos.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM cliente WHERE distrito = :distrito ORDER BY id_cliente DESC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('distrito' => $distrito, 'limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    $nome_completo = explode(" ", $row['nome']);
                    $nome = $nome_completo[0];
                    $apelido = $nome_completo[count($nome_completo)-1];
                    $data_registo = date_create($row['data_registo']);
                    $result_encomenda = $pdo->prepare("SELECT * FROM encomenda WHERE cliente = :cliente");
                    $result_encomenda->execute(array('cliente' => $row['id_cliente']));
                    echo '<tr>
                            <td>'.$nome.' '.$apelido.'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.date_format($data_registo, 'd/m/Y').'</td>
                            <td>'.$result_encomenda->rowCount().'</td>
                            <td class="text-end"><a href="cliente.php?id='.$row['id_cliente'].'" class="btn btn-xs"> Detalhes</a></td>
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

            $result_total_registos = $pdo->prepare("SELECT * FROM cliente");
            $result_total_registos->execute();
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontrados registos.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM cliente ORDER BY id_cliente DESC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    $nome_completo = explode(" ", $row['nome']);
                    $nome = $nome_completo[0];
                    $apelido = $nome_completo[count($nome_completo)-1];
                    $data_registo = date_create($row['data_registo']);
                    $result_encomenda = $pdo->prepare("SELECT * FROM encomenda WHERE cliente = :cliente");
                    $result_encomenda->execute(array('cliente' => $row['id_cliente']));
                    echo '<tr>
                            <td>'.$nome.' '.$apelido.'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.date_format($data_registo, 'd/m/Y').'</td>
                            <td>'.$result_encomenda->rowCount().'</td>
                            <td class="text-end"><a href="cliente.php?id='.$row['id_cliente'].'" class="btn btn-xs"> Detalhes</a></td>
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

        $result_total_registos = $pdo->prepare("SELECT * FROM cliente");
        $result_total_registos->execute();
        if ($result_total_registos->rowCount()==0) {
            echo 'Não foram encontrados registos.';
        } else {
            $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
            $limite_inferior = ($pagina - 1) * $limite_pagina;

            $result = $pdo->prepare("SELECT * FROM cliente ORDER BY id_cliente DESC LIMIT :limite_inferior, :limite_pagina");
            $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
            $row = $result->fetch();
            for ($i=1; $i<=$result->rowCount(); $i++) {
                $nome_completo = explode(" ", $row['nome']);
                $nome = $nome_completo[0];
                $apelido = $nome_completo[count($nome_completo)-1];
                $data_registo = date_create($row['data_registo']);
                $result_encomenda = $pdo->prepare("SELECT * FROM encomenda WHERE cliente = :cliente");
                $result_encomenda->execute(array('cliente' => $row['id_cliente']));
                echo '<tr>
                        <td>'.$nome.' '.$apelido.'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.date_format($data_registo, 'd/m/Y').'</td>
                        <td>'.$result_encomenda->rowCount().'</td>
                        <td class="text-end"><a href="cliente.php?id='.$row['id_cliente'].'" class="btn btn-xs"> Detalhes</a></td>
                      </tr>';
                $row = $result->fetch();
            }
        }
	}
?>