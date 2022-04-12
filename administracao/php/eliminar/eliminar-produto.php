<?php
	include("../config.php");

	if (isset($_POST['produto']) && !empty($_POST['produto'])) {
		$produto = $_POST['produto'];

			$result = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
			$result->execute(array('produto' => $produto));
			$row = $result->fetch();
			if ($result->rowCount()>0) {
				for ($i=1; $i<=$result->rowCount(); $i++) {
					if (file_exists("../../../produtos/".$produto."/".$row['imagem'].".jpg")) {
						unlink("../../../produtos/".$produto."/".$row['imagem'].".jpg");
					}
					$row = $result->fetch();
				}
			}
			rmdir("../../../produtos/".$produto);
			$query = $pdo->prepare("DELETE FROM imagem_produto WHERE produto = :produto");
			$query->execute(array('produto' => $produto));
			$query = $pdo->prepare("DELETE FROM produto WHERE id_produto = :produto");
			$query->execute(array('produto' => $produto));
			echo "";

	}
?>