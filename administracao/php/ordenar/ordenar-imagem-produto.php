<?php
    include("../config.php");

    if (isset($_POST['idsArray']) && !empty($_POST['idsArray']) && isset($_POST['produto']) && !empty($_POST['produto'])) {
        $idsArray = $_POST['idsArray'];
        $produto = $_POST['produto'];
        $count = 1;
        foreach ($idsArray as $id) {
            $query = $pdo->prepare("UPDATE imagem_produto SET ordem = :ordem WHERE imagem = :id AND produto = :produto");
            $query->execute(array('ordem' => $count, 'id' => $id, 'produto' => $produto));
            $count ++;
        }
    }
?>