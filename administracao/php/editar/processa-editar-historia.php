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
	$texto_en = htmlentities($_POST['texto_en'], ENT_QUOTES, 'UTF-8');
	$texto_es = htmlentities($_POST['texto_es'], ENT_QUOTES, 'UTF-8');
	$texto_fr = htmlentities($_POST['texto_fr'], ENT_QUOTES, 'UTF-8');
	$historia = $_POST['historia'];

	if ($msg!="") {
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Erro!</strong><br>
				'.$msg.'
			  </div>';
	} else {
		$query = $pdo->prepare("UPDATE historia SET ano = :ano, texto_pt = :texto_pt, texto_en = :texto_en, texto_es = :texto_es, texto_fr = :texto_fr WHERE id_historia = :historia");
		$query->execute(array('ano' => $ano, 'texto_pt' => $texto_pt, 'texto_en' => $texto_en, 'texto_es' => $texto_es, 'texto_fr' => $texto_fr, 'historia' => $historia));

		if (isset($_FILES['imagem']) && $_FILES['imagem']['size']>0) {
			if (file_exists("../../../assets/img/historia/".$historia.".jpg")) {
				unlink("../../../assets/img/historia/".$historia.".jpg");
			}
			$redimensionar = new abeManagement();
			move_uploaded_file($_FILES['imagem']['tmp_name'], "../../../assets/img/historia/".$historia.".jpg");
			$redimensionar->resizeImage(("../../../assets/img/historia/".$historia.".jpg"), 1200, 800);
			$redimensionar->cropImage(("../../../assets/img/historia/".$historia.".jpg"), 1200, 800);
		}
		echo "";
	}
?>