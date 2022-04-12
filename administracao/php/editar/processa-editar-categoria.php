<?php
	include("../config.php");
	include("../redimage.php");

	$msg = "";
	if (isset($_POST['nome']) && !empty($_POST['nome'])) {
		$nome = htmlentities($_POST['nome'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O nome em português não se encontra preenchido!<br>";
	}
	if (isset($_POST['slug']) && !empty($_POST['slug'])) {
		$slug = htmlentities($_POST['slug'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O slug não se encontra preenchido!<br>";
	}
	$estado = htmlentities($_POST['estado'], ENT_QUOTES, 'UTF-8');
	$tem_produtos = htmlentities($_POST['tem_produtos'], ENT_QUOTES, 'UTF-8');
	$categoria = $_POST['categoria'];

	if ($msg!="") {
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Erro!</strong><br>
				'.$msg.'
			  </div>';
	} else {
		$query = $pdo->prepare("UPDATE categoria SET nome = :nome, slug = :slug, estado = :estado, tem_produtos = :tem_produtos WHERE id_categoria = :categoria");
		$query->execute(array('nome' => $nome, 'slug' => $slug, 'estado' => $estado, 'tem_produtos' => $tem_produtos, 'categoria' => $categoria));

		
		if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
			$descricao = nl2br(htmlentities($_POST['descricao'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE categoria SET descricao = :descricao WHERE id_categoria = :categoria");
			$query->execute(array('descricao' => $descricao, 'categoria' => $categoria));
		}
		
		if (isset($_POST['categoria_pai']) && !empty($_POST['categoria_pai'])) {
			$categoria_pai = htmlentities($_POST['categoria_pai'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE categoria SET categoria_pai = :categoria_pai WHERE id_categoria = :categoria");
			$query->execute(array('categoria_pai' => $categoria_pai, 'categoria' => $categoria));
		}

		if (isset($_FILES['capa']) && $_FILES['capa']['size']>0) {
			if (file_exists("../../../assets/img/categorias/".$categoria.".jpg")) {
				unlink("../../../assets/img/categorias/".$categoria.".jpg");
			}
			$redimensionar = new abeManagement();
			move_uploaded_file($_FILES["capa"]["tmp_name"], "../../../assets/img/categorias/".$categoria.".jpg");
			$redimensionar->resizeImage(("../../../assets/img/categorias/".$categoria.".jpg"), 1200, 800);
			$redimensionar->cropImage(("../../../assets/img/categorias/".$categoria.".jpg"), 1200, 800);
		}
		echo '';
	}
?>