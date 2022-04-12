<?php
	include("../config.php");
	include("../redimage.php");

	$msg = "";
	if (isset($_POST['nome_pt']) && !empty($_POST['nome_pt'])) {
		$nome_pt = htmlentities($_POST['nome_pt'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O nome em português não se encontra preenchido!<br>";
	}
	if (isset($_POST['slug']) && !empty($_POST['slug'])) {
		$slug = htmlentities($_POST['slug'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O slug não se encontra preenchido!<br>";
	}
	if (isset($_POST['estado'])) {
		$estado = htmlentities($_POST['estado'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O estado não se encontra selecionado!<br>";
	}
	if (isset($_POST['tem_produtos'])) {
		$tem_produtos = htmlentities($_POST['tem_produtos'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O tem produtos não se encontra selecionado!<br>";
	}
	if (!isset($_FILES['imagem']) || !($_FILES['imagem']['size']>0)) {
		$msg .= "A imagem de capa não se encontra selecionada!<br>";
	}

	if ($msg!="") {
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Erro!</strong><br>
				'.$msg.'
			  </div>';
	} else {
		$result = $pdo->prepare("SELECT * FROM categoria ORDER BY ordem ASC");
		$result->execute();
		$row = $result->fetch();
		if ($result->rowCount()>0) {
			for ($i=1; $i<=$result->rowCount(); $i++) {
				$query = $pdo->prepare("UPDATE categoria SET ordem = :ordem WHERE id_categoria = :categoria");
				$query->execute(array('ordem' => $i, 'categoria' => $row['id_categoria']));
				$row = $result->fetch();
			}
			$ordem = $result->rowCount() + 1;
		} else {
			$ordem = 1;
		}

		$query = $pdo->prepare("INSERT INTO categoria (nome_pt, slug, estado, tem_produtos, ordem) VALUES (:nome_pt, :slug, :estado, :tem_produtos, :ordem)");
		$query->execute(array('nome_pt' => $nome_pt, 'slug' => $slug, 'estado' => $estado, 'tem_produtos' => $tem_produtos, 'ordem' => $ordem));
		$categoria = $pdo->lastInsertId();

		if (isset($_POST['nome_en']) && !empty($_POST['nome_en'])) {
			$nome_en = htmlentities($_POST['nome_en'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE categoria SET nome_en = :nome_en WHERE id_categoria = :categoria");
			$query->execute(array('descricao' => $descricao, 'categoria' => $categoria));
		}
		if (isset($_POST['nome_es']) && !empty($_POST['nome_es'])) {
			$nome_es = htmlentities($_POST['nome_es'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE categoria SET nome_es = :nome_es WHERE id_categoria = :categoria");
			$query->execute(array('nome_es' => $nome_es, 'categoria' => $categoria));
		}
		if (isset($_POST['nome_fr']) && !empty($_POST['nome_fr'])) {
			$nome_fr = htmlentities($_POST['nome_fr'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE categoria SET nome_fr = :nome_fr WHERE id_categoria = :categoria");
			$query->execute(array('nome_fr' => $nome_fr, 'categoria' => $categoria));
		}
		if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
			$descricao = nl2br(htmlentities($_POST['descricao'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE categoria SET descricao = :descricao WHERE id_categoria = :categoria");
			$query->execute(array('descricao' => $descricao, 'categoria' => $categoria));
		}
		if (isset($_POST['descricao_en']) && !empty($_POST['descricao_en'])) {
			$descricao_en = nl2br(htmlentities($_POST['descricao_en'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE categoria SET descricao_en = :descricao_en WHERE id_categoria = :categoria");
			$query->execute(array('descricao_en' => $descricao_en, 'categoria' => $categoria));
		}
		if (isset($_POST['descricao_es']) && !empty($_POST['descricao_es'])) {
			$descricao_es = nl2br(htmlentities($_POST['descricao_es'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE categoria SET descricao_es = :descricao_es WHERE id_categoria = :categoria");
			$query->execute(array('descricao_es' => $descricao_es, 'categoria' => $categoria));
		}
		if (isset($_POST['descricao_fr']) && !empty($_POST['descricao_fr'])) {
			$descricao_fr = nl2br(htmlentities($_POST['descricao_fr'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE categoria SET descricao_fr = :descricao_fr WHERE id_categoria = :categoria");
			$query->execute(array('descricao_fr' => $descricao_fr, 'categoria' => $categoria));
		}
		if (isset($_POST['categoria_pai']) && !empty($_POST['categoria_pai'])) {
			$categoria_pai = htmlentities($_POST['categoria_pai'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE categoria SET categoria_pai = :categoria_pai WHERE id_categoria = :categoria");
			$query->execute(array('categoria_pai' => $categoria_pai, 'categoria' => $categoria));
		}

		$redimensionar = new abeManagement();
		move_uploaded_file($_FILES['imagem']['tmp_name'], "../../../assets/img/categorias/".$categoria.".jpg");
		$redimensionar->resizeImage(("../../../assets/img/categorias/".$categoria.".jpg"), 1200, 800);
		$redimensionar->cropImage(("../../../assets/img/categorias/".$categoria.".jpg"), 1200, 800);
		echo "";
	}
?>