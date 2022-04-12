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

            $result_total_registos = $pdo->prepare("SELECT * FROM voucher WHERE estado = :estado");
            $result_total_registos->execute(array('estado' => $estado));
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontrados registos.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM voucher WHERE estado = :estado ORDER BY id_voucher DESC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('estado' => $estado, 'limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    if ($row['tipo_desconto']==1) {
                        $desconto = $row['desconto']."€";
                    } else {
                        $desconto = intval($row['desconto'])."%";
                    }
                    $data = date_create($row['data']);
                    if (!is_null($row['data_expiracao']) && $row['data_expiracao']!="") {
                        if ($row['data_expiracao']<date("Y-m-d")) {
                            $query = $pdo->prepare("UPDATE voucher SET estado = 3 WHERE id_voucher = :voucher");
                            $query->execute(array('voucher' => $row['id_voucher']));
                            $estado = '<span class="badge badge-pill badge-soft-danger">Expirado</span>';
                        }
                        $data_expiracao = date_create($row['data_expiracao']);
                        $data_expiracao_mostrar = date_format("d/m/Y");
                    } else {
                        $data_expiracao_mostrar = "";
                    }
                    if ($row['estado']==1) {
                        $estado = '<span class="badge badge-pill badge-soft-success">Ativo</span>';
                    } else if ($row['estado']==2) {
                        $estado = '<span class="badge badge-pill badge-soft-danger">Inativo</span>';
                    } else if ($row['estado']==3) {
                        $estado = '<span class="badge badge-pill badge-soft-danger">Expirado</span>';
                    }
                    echo '<tr>
                            <td>'.$row['codigo'].'</td>
                            <td>'.$desconto.'</td>
                            <td>'.date_format($data, "d/m/Y").'</td>
                            <td>'.$data_expiracao_mostrar.'</td>
                            <td>'.$row['utilizacoes'].'</td>
                            <td>'.$row['limite_utilizacoes'].'</td>
                            <td>'.$estado.'</td>
                            <td>
                                <a href="editar-voucher.php?id='.$row['id_voucher'].'" class="btn btn-xs mr-15"> Editar</a>
                                <a href="#" onclick="eliminar('.$row['id_voucher'].')" class="btn btn-xs"> Eliminar</a>
                            </td>
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

            $result_total_registos = $pdo->prepare("SELECT * FROM voucher");
            $result_total_registos->execute();
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontrados registos.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM voucher ORDER BY id_voucher DESC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    if ($row['tipo_desconto']==1) {
                        $desconto = $row['desconto']."€";
                    } else {
                        $desconto = intval($row['desconto'])."%";
                    }
                    $data = date_create($row['data']);
                    if (!is_null($row['data_expiracao']) && $row['data_expiracao']!="") {
                        if ($row['data_expiracao']<date("Y-m-d")) {
                            $query = $pdo->prepare("UPDATE voucher SET estado = 3 WHERE id_voucher = :voucher");
                            $query->execute(array('voucher' => $row['id_voucher']));
                            $estado = '<span class="badge badge-pill badge-soft-danger">Expirado</span>';
                        }
                        $data_expiracao = date_create($row['data_expiracao']);
                        $data_expiracao_mostrar = date_format("d/m/Y");
                    } else {
                        $data_expiracao_mostrar = "";
                    }
                    if ($row['estado']==1) {
                        $estado = '<span class="badge badge-pill badge-soft-success">Ativo</span>';
                    } else if ($row['estado']==2) {
                        $estado = '<span class="badge badge-pill badge-soft-danger">Inativo</span>';
                    } else if ($row['estado']==3) {
                        $estado = '<span class="badge badge-pill badge-soft-danger">Expirado</span>';
                    }
                    echo '<tr>
                            <td>'.$row['codigo'].'</td>
                            <td>'.$desconto.'</td>
                            <td>'.date_format($data, "d/m/Y").'</td>
                            <td>'.$data_expiracao_mostrar.'</td>
                            <td>'.$row['utilizacoes'].'</td>
                            <td>'.$row['limite_utilizacoes'].'</td>
                            <td>'.$estado.'</td>
                            <td>
                                <a href="editar-voucher.php?id='.$row['id_voucher'].'" class="btn btn-xs mr-15"> Editar</a>
                                <a href="#" onclick="eliminar('.$row['id_voucher'].')" class="btn btn-xs"> Eliminar</a>
                            </td>
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

        $result_total_registos = $pdo->prepare("SELECT * FROM voucher");
        $result_total_registos->execute();
        if ($result_total_registos->rowCount()==0) {
            echo 'Não foram encontrados registos.';
        } else {
            $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
            $limite_inferior = ($pagina - 1) * $limite_pagina;

            $result = $pdo->prepare("SELECT * FROM voucher ORDER BY id_voucher DESC LIMIT :limite_inferior, :limite_pagina");
            $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
            $row = $result->fetch();
            for ($i=1; $i<=$result->rowCount(); $i++) {
                if ($row['tipo_desconto']==1) {
                    $desconto = $row['desconto']."€";
                } else {
                    $desconto = intval($row['desconto'])."%";
                }
                $data = date_create($row['data']);
                if (!is_null($row['data_expiracao']) && $row['data_expiracao']!="") {
                    if ($row['data_expiracao']<date("Y-m-d")) {
                        $query = $pdo->prepare("UPDATE voucher SET estado = 3 WHERE id_voucher = :voucher");
                        $query->execute(array('voucher' => $row['id_voucher']));
                        $estado = '<span class="badge badge-pill badge-soft-danger">Expirado</span>';
                    }
                    $data_expiracao = date_create($row['data_expiracao']);
                    $data_expiracao_mostrar = date_format("d/m/Y");
                } else {
                    $data_expiracao_mostrar = "";
                }
                if ($row['estado']==1) {
                    $estado = '<span class="badge badge-pill badge-soft-success">Ativo</span>';
                } else if ($row['estado']==2) {
                    $estado = '<span class="badge badge-pill badge-soft-danger">Inativo</span>';
                } else if ($row['estado']==3) {
                    $estado = '<span class="badge badge-pill badge-soft-danger">Expirado</span>';
                }
                echo '<tr>
                        <td>'.$row['codigo'].'</td>
                        <td>'.$desconto.'</td>
                        <td>'.date_format($data, "d/m/Y").'</td>
                        <td>'.$data_expiracao_mostrar.'</td>
                        <td>'.$row['utilizacoes'].'</td>
                        <td>'.$row['limite_utilizacoes'].'</td>
                        <td>'.$estado.'</td>
                        <td>
                            <a href="editar-voucher.php?id='.$row['id_voucher'].'" class="btn btn-xs mr-15"> Editar</a>
                            <a href="#" onclick="eliminar('.$row['id_voucher'].')" class="btn btn-xs"> Eliminar</a>
                        </td>
                      </tr>';
                $row = $result->fetch();
            }
        }
	}
?>