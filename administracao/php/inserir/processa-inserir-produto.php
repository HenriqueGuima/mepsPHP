<?php
	include("../config.php");

	$msg = "";
	if (isset($_POST['nome']) && !empty($_POST['nome'])) {
		$nome = nl2br(htmlentities($_POST['nome'], ENT_QUOTES, 'UTF-8'));
	} else {
		$msg .= "O nome em português não se encontra preenchido!<br>";
	}
	if (isset($_POST['slug']) && !empty($_POST['slug'])) {
		$slug = htmlentities($_POST['slug'], ENT_QUOTES, 'UTF-8');
	} else {
		$msg .= "O slug não se encontra preenchido!<br>";
	}
	$estado = htmlentities($_POST['estado'], ENT_QUOTES, 'UTF-8');
	$loja = htmlentities($_POST['loja'], ENT_QUOTES, 'UTF-8');
	$produtos = htmlentities($_POST['produtos'], ENT_QUOTES, 'UTF-8');
	$produto_temp = $_POST['id_produto_temp'];

	if ($msg!="") {
		echo '<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Erro!</strong><br>
				'.$msg.'
			  </div>';
	} else {
		$result = $pdo->prepare("SELECT * FROM produto ORDER BY ordem ASC");
		$result->execute();
		$row = $result->fetch();
		if ($result->rowCount()>0) {
			for ($i=1; $i<=$result->rowCount(); $i++) {
				$query = $pdo->prepare("UPDATE produto SET ordem = :ordem WHERE id_produto = :produto");
				$query->execute(array('ordem' => $i, 'produto' => $row['id_produto']));
				$row = $result->fetch();
			}
			$ordem = $result->rowCount() + 1;
		} else {
			$ordem = 1;
		}
		$query = $pdo->prepare("INSERT INTO produto (nome, slug, estado, loja, produtos, ordem) VALUES (:nome, :slug, :estado, :loja, :produtos, :ordem)");
		$query->execute(array('nome' => $nome, 'slug' => $slug, 'estado' => $estado, 'loja' => $loja, 'produtos' => $produtos, 'ordem' => $ordem));
		$produto = $pdo->lastInsertId();

		if (isset($_POST['nome_en']) && !empty($_POST['nome_en'])) {
			$nome_en = nl2br(htmlentities($_POST['nome_en'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET nome_en = :nome_en WHERE id_produto = :produto");
			$query->execute(array('nome_en' => $nome_en, 'produto' => $produto));
		}
		if (isset($_POST['nome_es']) && !empty($_POST['nome_es'])) {
			$nome_es = nl2br(htmlentities($_POST['nome_es'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET nome_es = :nome_es WHERE id_produto = :produto");
			$query->execute(array('nome_es' => $nome_es, 'produto' => $produto));
		}
		if (isset($_POST['nome_fr']) && !empty($_POST['nome_fr'])) {
			$nome_fr = nl2br(htmlentities($_POST['nome_fr'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET nome_fr = :nome_fr WHERE id_produto = :produto");
			$query->execute(array('nome_fr' => $nome_fr, 'produto' => $produto));
		}
		if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
			$descricao = nl2br(htmlentities($_POST['descricao'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET descricao = :descricao WHERE id_produto = :produto");
			$query->execute(array('descricao' => $descricao, 'produto' => $produto));
		}
		if (isset($_POST['descricao_en']) && !empty($_POST['descricao_en'])) {
			$descricao_en = nl2br(htmlentities($_POST['descricao_en'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET descricao_en = :descricao_en WHERE id_produto = :produto");
			$query->execute(array('descricao_en' => $descricao_en, 'produto' => $produto));
		}
		if (isset($_POST['descricao_es']) && !empty($_POST['descricao_es'])) {
			$descricao_es = nl2br(htmlentities($_POST['descricao_es'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET descricao_es = :descricao_es WHERE id_produto = :produto");
			$query->execute(array('descricao_es' => $descricao_es, 'produto' => $produto));
		}
		if (isset($_POST['descricao_fr']) && !empty($_POST['descricao_fr'])) {
			$descricao_fr = nl2br(htmlentities($_POST['descricao_fr'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET descricao_fr = :descricao_fr WHERE id_produto = :produto");
			$query->execute(array('descricao_fr' => $descricao_fr, 'produto' => $produto));
		}
		if (isset($_POST['carateristicas_pt']) && !empty($_POST['carateristicas_pt'])) {
			$carateristicas_pt = nl2br(htmlentities($_POST['carateristicas_pt'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET carateristicas_pt = :carateristicas_pt WHERE id_produto = :produto");
			$query->execute(array('carateristicas_pt' => $carateristicas_pt, 'produto' => $produto));
		}
		if (isset($_POST['carateristicas_en']) && !empty($_POST['carateristicas_en'])) {
			$carateristicas_en = nl2br(htmlentities($_POST['carateristicas_en'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET carateristicas_en = :carateristicas_en WHERE id_produto = :produto");
			$query->execute(array('carateristicas_en' => $carateristicas_en, 'produto' => $produto));
		}
		if (isset($_POST['carateristicas_es']) && !empty($_POST['carateristicas_es'])) {
			$carateristicas_es = nl2br(htmlentities($_POST['carateristicas_es'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET carateristicas_es = :carateristicas_es WHERE id_produto = :produto");
			$query->execute(array('carateristicas_es' => $carateristicas_es, 'produto' => $produto));
		}
		if (isset($_POST['carateristicas_fr']) && !empty($_POST['carateristicas_fr'])) {
			$carateristicas_fr = nl2br(htmlentities($_POST['carateristicas_fr'], ENT_QUOTES, 'UTF-8'));
			$query = $pdo->prepare("UPDATE produto SET carateristicas_fr = :carateristicas_fr WHERE id_produto = :produto");
			$query->execute(array('carateristicas_fr' => $carateristicas_fr, 'produto' => $produto));
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
		if (isset($_POST['categoria']) && $_POST['categoria']!="0") {
			$categoria = htmlentities($_POST['categoria'], ENT_QUOTES, 'UTF-8');
			$query = $pdo->prepare("UPDATE produto SET categoria = :categoria WHERE id_produto = :produto");
			$query->execute(array('categoria' => $categoria, 'produto' => $produto));
		}

		if (!file_exists('../../../produtos/'.$produto)) {
			mkdir('../../../produtos/'.$produto, 0777, true);
		}
		$result_imagem_produto_temp = $pdo->prepare("SELECT * FROM imagem_produto_temp WHERE produto = :produto_temp ORDER BY ordem ASC");
		$result_imagem_produto_temp->execute(array('produto_temp' => $produto_temp));
		$row_imagem_produto_temp = $result_imagem_produto_temp->fetch();
		if ($result_imagem_produto_temp->rowCount()>0) {
			for ($i=1; $i<=$result_imagem_produto_temp->rowCount(); $i++) {
				if (file_exists("../../../produtos/temp/".$produto_temp."/".$row_imagem_produto_temp['imagem'].".jpg")) {
					$rename = rename("../../../produtos/temp/".$produto_temp."/".$row_imagem_produto_temp['imagem'].".jpg", "../../../produtos/".$produto."/".$i.".jpg");
					$query = $pdo->prepare("INSERT INTO imagem_produto (imagem, produto, ordem) VALUES (:imagem, :produto, :ordem)");
					$query->execute(array('imagem' => $i, 'produto' => $produto, 'ordem' => $i));
				}
				$row_imagem_produto_temp = $result_imagem_produto_temp->fetch();
			}
			rmdir("../../../produtos/temp/".$produto_temp);
			$query = $pdo->prepare("DELETE FROM imagem_produto_temp WHERE produto = :produto_temp");
			$query->execute(array('produto_temp' => $produto_temp));
		}

		$result_produto_associado = $pdo->prepare("SELECT * FROM produto_associado_temp WHERE produto_temp = :produto_temp ORDER BY ordem ASC");
		$result_produto_associado->execute(array('produto_temp' => $produto_temp));
		$row_produto_associado = $result_produto_associado->fetch();
		if ($result_produto_associado->rowCount()>0) {
			for ($i=1; $i<=$result_produto_associado->rowCount(); $i++) {
				$query = $pdo->prepare("INSERT INTO produto_associado (produto_associado, produto, ordem) VALUES (:produto_associado, :produto, :ordem)");
				$query->execute(array('produto_associado' => $row_produto_associado['produto_associado'], 'produto' => $produto, 'ordem' => $i));
				$row_produto_associado = $result_produto_associado->fetch();
			}
			$query = $pdo->prepare("DELETE FROM produto_associado_temp WHERE produto_temp = :produto");
			$query->execute(array('produto' => $produto_temp));
		}

		$query = $pdo->prepare("DELETE FROM produto_temp WHERE id_produto_temp = :produto");
		$query->execute(array('produto' => $produto_temp));
		echo "";
	}
?>