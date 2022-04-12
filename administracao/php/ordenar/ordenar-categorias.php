<?php
    require_once("../config.php");

    if (isset($_POST['idsArray']) && !empty($_POST['idsArray'])) {
        $idsArray = $_POST['idsArray'];
        $count = 1;
        foreach ($idsArray as $id) {
            $query = $pdo->prepare("UPDATE categoria SET ordem = :ordem WHERE id_categoria = :id");
            $query->execute(array('ordem' => $count, 'id' => $id));
            $count ++;
        }
    }
?>