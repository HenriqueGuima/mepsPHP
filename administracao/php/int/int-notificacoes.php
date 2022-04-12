<?php
	include("../config.php");

    if (isset($_GET['pagina'])) {
        $pagina = $_GET['pagina'];
    } else {
        $pagina = 1;
    }
    $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 50;

    $result_total_registos = $pdo->prepare("SELECT * FROM notificacao");
    $result_total_registos->execute();
    if ($result_total_registos->rowCount()==0) {
        echo 'Não foram encontradas notificações.';
    } else {
        $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
        $limite_inferior = ($pagina - 1) * $limite_pagina;

        $result = $pdo->prepare("SELECT * FROM notificacao ORDER BY id_notificacao DESC LIMIT :limite_inferior, :limite_pagina");
        $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
        $row = $result->fetch();
        for ($i=1; $i<=$result->rowCount(); $i++) {
            if ($row['tipo']==1) {
                $destino = "cliente.php?id=".$row['cliente'];
            } else if ($row['tipo']==2) {
                $destino = "cliente.php?id=".$row['cliente'];
            } else if ($row['tipo']==3) {
                $destino = "encomenda.php?id=".$row['destino'];
            } else if ($row['tipo']==4) {
                $destino = "encomenda.php?id=".$row['destino'];
            } else if ($row['tipo']==5) {
                $destino = "mensagem.php?id=".$row['destino'];
            } else if ($row['tipo']==6) {
                $destino = "newsletter.php";
            }
            $data_notificacao = date_create($row['data']);
            if ($row['estado']==0) {
                $nova = "*";
            } else {
                $nova = "";
            }
            echo '<a href="'.$destino.'">
                    <div class="media">
                        <div class="me-3">
                            <h6><span>'.date_format($data_notificacao, 'd/m/Y H:i').'</span> <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i></h6>
                        </div>
                        <div class="media-body">
                            <div>'.$row['texto'].$nova.'</div>
                        </div>
                    </div>
                  </a>';
            $row = $result->fetch();
        }
    }
?>