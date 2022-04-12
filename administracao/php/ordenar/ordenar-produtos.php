<?php
    include("../config.php");

    if (isset($_POST['idsArray']) && !empty($_POST['idsArray'])) {
        $idsArray = $_POST['idsArray'];
        $count = 1;
        foreach ($idsArray as $id) {
            $query = $pdo->prepare("UPDATE produto SET ordem = :ordem WHERE id_produto = :id");
            $query->execute(array('ordem' => $count, 'id' => $id));
            $count ++;
        }
    }
?>