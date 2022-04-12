<?php
	include("../config.php");
	include("../redimage.php");

	$msg = "";
	if (isset($_POST['ano']) && !empty($_POST['ano'])) {
		$ano = htmlentities($_POST['ano'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O ano não se encontra preenchido!<br>";
	}
	if (isset($_POST['texto_pt']) && !empty($_POST['texto_pt'])) {
		$texto_pt = htmlentities($_POST['texto_pt'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O texto em português não se encontra preenchido!<br>";
	}
	if (!isset($_FILES['imagem']) || !($_FILES['imagem']['size']>0)) {
		$msg .= "A imagem não se encontra selecionada!<br>";
	}

	if ($msg!="") {
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Erro!</strong><br>
				'.$msg.'
			  </div>';
	} else {
		$result = $pdo->prepare("SELECT * FROM historia ORDER BY ordem ASC");
		$result->execute();
		$row = $result->fetch();
		if ($result->rowCount()>0) {
			for ($i=1; $i<=$result->rowCount(); $i++) {
				$query = $pdo->prepare("UPDATE historia SET ordem = :ordem WHERE id_historia = :historia");
				$query->execute(array('ordem' => $i, 'historia' => $row['id_historia']));
				$row = $result->fetch();
			}
			$ordem = $result->rowCount() + 1;
		} else {
			$ordem = 1;
		}

		$query = $pdo->prepare("INSERT INTO historia (ano, texto_pt, ordem) VALUES (:ano, :texto_pt, :ordem)");
		$query->execute(array('ano' => $ano, 'texto_pt' => $texto_pt, 'ordem' => $ordem));
		$historia = $pdo->lastInsertId();

		if (isset($_POST['texto_en']) && !empty($_POST['texto_en'])) {
			$texto_en = htmlentities($_POST['texto_en'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE historia SET texto_en = :texto_en WHERE id_historia = :historia");
			$query->execute(array('texto_en' => $texto_en, 'historia' => $historia));
		}
		if (isset($_POST['texto_es']) && !empty($_POST['texto_es'])) {
			$texto_es = htmlentities($_POST['texto_es'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE historia SET texto_es = :texto_es WHERE id_historia = :historia");
			$query->execute(array('texto_es' => $texto_es, 'historia' => $historia));
		}
		if (isset($_POST['texto_fr']) && !empty($_POST['texto_fr'])) {
			$texto_fr = htmlentities($_POST['texto_fr'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE historia SET texto_fr = :texto_fr WHERE id_historia = :historia");
			$query->execute(array('texto_fr' => $texto_fr, 'historia' => $historia));
		}

		$redimensionar = new abeManagement();
		move_uploaded_file($_FILES['imagem']['tmp_name'], "../../../assets/img/historia/".$historia.".jpg");
		$redimensionar->resizeImage(("../../../assets/img/historia/".$historia.".jpg"), 1200, 800);
		$redimensionar->cropImage(("../../../assets/img/historia/".$historia.".jpg"), 1200, 800);
		echo "";
	}
?>