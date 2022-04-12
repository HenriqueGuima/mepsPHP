<?php
    include("../config.php");

    if (isset($_POST['idsArray']) && !empty($_POST['idsArray']) && isset($_POST['produto']) && !empty($_POST['produto'])) {
        $idsArray = $_POST['idsArray'];
        $produto = $_POST['produto'];
        $count = 1;
        foreach ($idsArray as $id) {
            $query = $pdo->prepare("UPDATE produto_associado_temp SET ordem = :ordem WHERE produto_associado = :id AND produto_temp = :produto");
            $query->execute(array('ordem' => $count, 'id' => $id, 'produto' => $produto));
            $count ++;
        }
    }
?>