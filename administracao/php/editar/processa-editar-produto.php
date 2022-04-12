<?php
	include("../config.php");

	$msg = "";
	if (isset($_POST['nome']) && !empty($_POST['nome'])) {
		$nome = nl2br(htmlentities($_POST['nome'], ENT_QUOTES, 'UTF-8'));
	} else {
		$msg .= "O nome não se encontra preenchido!<br>";
	}
	if (isset($_POST['slug']) && !empty($_POST['slug'])) {
		$slug = htmlentities($_POST['slug'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O slug não se encontra preenchido!<br>";
	}
	$estado = htmlentities($_POST['estado'], ENT_QUOTES, 'UTF-8');
	$produtos = htmlentities($_POST['produtos'], ENT_QUOTES, 'UTF-8');
	$produto = $_POST['produto'];

	if ($msg!="") {
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Erro!</strong><br>
				'.$msg.'
			  </div>';
	} else {
		$query = $pdo->prepare("UPDATE produto SET nome = :nome, slug = :slug, estado = :estado, produtos = :produtos WHERE id_produto = :produto");
		$query->execute(array('nome' => $nome, 'slug' => $slug, 'estado' => $estado, 'produtos' => $produtos, 'produto' => $produto));

		if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
			$descricao = nl2br(htmlentities($_POST['descricao'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET descricao = :descricao WHERE id_produto = :produto");
			$query->execute(array('descricao' => $descricao, 'produto' => $produto));
		}
		if (isset($_POST['carateristicas_pt']) && !empty($_POST['carateristicas_pt'])) {
			$carateristicas_pt = nl2br(htmlentities($_POST['carateristicas_pt'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET carateristicas_pt = :carateristicas_pt WHERE id_produto = :produto");
			$query->execute(array('carateristicas_pt' => $carateristicas_pt, 'produto' => $produto));
		}
		if (isset($_POST['tags']) && !empty($_POST['tags'])) {
			$tags = nl2br(htmlentities($_POST['tags'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET tags = :tags WHERE id_produto = :produto");
			$query->execute(array('tags' => $tags, 'produto' => $produto));
		}
		if (isset($_POST['referencia']) && !empty($_POST['referencia'])) {
			$referencia = htmlentities($_POST['referencia'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE produto SET referencia = :referencia WHERE id_produto = :produto");
			$query->execute(array('referencia' => $referencia, 'produto' => $produto));
		}
		if (isset($_POST['preco']) && !empty($_POST['preco'])) {
			$preco = htmlentities($_POST['preco'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE produto SET preco = :preco WHERE id_produto = :produto");
			$query->execute(array('preco' => $preco, 'produto' => $produto));
		}
		if (isset($_POST['categoria']) && !empty($_POST['categoria'])) {
			$categoria = htmlentities($_POST['categoria'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE produto SET categoria = :categoria WHERE id_produto = :produto");
			$query->execute(array('categoria' => $categoria, 'produto' => $produto));
		} else {
			$categoria = "";
			$query = $pdo->prepare("UPDATE produto SET categoria = :categoria WHERE id_produto = :produto");
			$query->execute(array('categoria' => $categoria, 'produto' => $produto));
		}

		if (isset($_FILES['capa']) && $_FILES['capa']['size']>0) {
			if (file_exists("../../../assets/img/produtos/".$produto.".jpg")) {
				unlink("../../../assets/img/produtos/".$produto.".jpg");
			}
			$redimensionar = new abeManagement();
			move_uploaded_file($_FILES["capa"]["tmp_name"], "../../../assets/img/produtos/".$produto.".jpg");
			$redimensionar->resizeImage(("../../../assets/img/produtos/".$produto.".jpg"), 1200, 800);
			$redimensionar->cropImage(("../../../assets/img/produtos/".$produto.".jpg"), 1200, 800);
		}
		echo '';
	}
?>