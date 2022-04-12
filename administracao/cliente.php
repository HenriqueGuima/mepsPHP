<?php
    session_start();
    include("php/config.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    }
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $cliente = $_GET['id'];
        $result = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :cliente");
        $result->execute(array('cliente' => $cliente));
        $row = $result->fetch();
        if ($result->rowCount()==0) {
            header("Location: clientes.php");
        }
        $query = $pdo->prepare("UPDATE notificacao SET estado = 1 WHERE cliente = :cliente AND (tipo = 1 OR tipo = 2)");
        $query->execute(array('cliente' => $cliente));
    } else {
        header("Location: clientes.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-pt">
    <head>
        <meta charset="utf-8">
        <title><?= $row_loja['nome'];?> | Painel de Administração</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/Logo_MEPS_sticker_icon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>

    <body>
        <div class="screen-overlay"></div>
        <aside class="navbar-aside" id="offcanvas_aside">
            <div class="aside-top">
                <a href="index.php" class="brand-wrap">
                    <img src="assets/img/Logo_MEPS.png" class="logo" alt="<?= $row_loja['nome'];?>">
                </a>
                <div>
                    <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
                </div>
            </div>

            <nav>
                <ul class="menu-aside">
                    <li class="menu-item">
                        <a class="menu-link" href="index.php">
                            <i class="icon material-icons md-home"></i>
                            <span class="text">Painel de Administração</span>
                        </a>
                    </li>
                    <li class="menu-item has-submenu">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-shopping_bag"></i>
                            <span class="text">Produtos</span>
                        </a>
                        <div class="submenu">
                            <a href="produtos.php">Produtos</a>
                            <a href="categorias.php">Categorias</a>
                        </div>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="encomendas.php">
                            <i class="icon material-icons md-shopping_cart"></i>
                            <span class="text">Encomendas</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-euro_symbol"></i>
                            <span class="text">Pagamentos</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="vouchers.php">
                            <i class="icon material-icons md-monetization_on"></i>
                            <span class="text">Vouchers</span>
                        </a>
                    </li>
                    <li class="menu-item active">
                        <a class="menu-link" href="clientes.php">
                            <i class="icon material-icons md-person"></i>
                            <span class="text">Clientes</span>
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="menu-aside">
                    <li class="menu-item">
                        <a class="menu-link" href="mensagens.php">
                            <i class="icon material-icons md-message"></i>
                            <span class="text">Mensagens</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="pontos-venda.php">
                            <i class="icon fas fa-store"></i>
                            <span class="text">Pontos de Venda</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="home.php">
                            <i class="icon fas fa-home"></i>
                            <span class="text">Personalizar Home</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-wrap">
            <?php
                include("includes/barra-topo.php");
            ?>

            <section class="content-main">
                <div class="row">
                    <div class="col-12">
                        <div class="content-header">
                            <h2 class="content-title"><?= $row['nome'];?></h2>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Informação Básica</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-4">
                                            <label class="form-label">Nome</label>
                                            <input type="text" class="form-control" value="<?= $row['nome'];?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-4">
                                            <label class="form-label">Rua</label>
                                            <input type="text" class="form-control" value="<?= $row['rua'];?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <label class="form-label">Código-Postal</label>
                                            <input type="text" class="form-control" value="<?= $row['codigo_postal'];?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <label class="form-label">Localidade</label>
                                            <input type="text" class="form-control" value="<?= $row['localidade'];?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <label class="form-label">Distrito</label>
                                            <input type="text" class="form-control" value="<?= $row['distrito'];?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <label class="form-label">País</label>
                                            <?php
                                                if (!is_null($row['pais']) && $row['pais']!="") {
                                                    $result_pais = $pdo->prepare("SELECT * FROM pais WHERE iso = :pais");
                                                    $result_pais->execute(array('pais' => $row['pais']));
                                                    $row_pais = $result_pais->fetch();
                                                    $pais = $row_pais['nome'];
                                                } else {
                                                    $pais = "";
                                                }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $pais;?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">E-mail</label>
                                            <input type="text" class="form-control" value="<?= $row['email'];?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">Telefone</label>
                                            <input type="text" class="form-control" value="<?= $row['telefone'];?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">NIF</label>
                                            <input type="text" class="form-control" value="<?= $row['nif'];?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">Data de Nascimento</label>
                                            <?php
                                                if (is_null($row['nascimento'])) {
                                                    $data_nascimento = "";
                                                } else {
                                                    $nascimento = date_create($row['nascimento']);
                                                    $data_nascimento = date_format($nascimento, 'd/m/Y');
                                                }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $data_nascimento;?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">Data de Registo</label>
                                            <?php
                                                $data_registo = date_create($row['data_registo']);
                                            ?>
                                            <input type="text" class="form-control" value="<?= date_format($data_registo, 'd/m/Y');?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label">Língua</label>
                                            <?php
                                                if ($row['lingua']=="pt") {
                                                    $lingua = "Português";
                                                } else if ($row['lingua']=="en") {
                                                    $lingua = "Inglês";
                                                } else if ($row['lingua']=="es") {
                                                    $lingua = "Espanhol";
                                                } else if ($row['lingua']=="fr") {
                                                    $lingua = "Francês";
                                                } else {
                                                    $lingua = "Português";
                                                }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $lingua;?>" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Morada de Faturação</label>
                                            <?php
                                                if (isset($row['morada_faturacao']) && $row['morada_faturacao']!="") {
                                                    $result_morada = $pdo->prepare("SELECT * FROM morada WHERE id_morada = :morada");
                                                    $result_morada->execute(array('morada' => $row['morada_faturacao']));
                                                    $row_morada = $result_morada->fetch();
                                                    if (!is_null($row_morada['pais']) && $row_morada['pais']!="") {
                                                        $result_pais = $pdo->prepare("SELECT * FROM pais WHERE iso = :pais");
                                                        $result_pais->execute(array('pais' => $row_morada['pais']));
                                                        $row_pais = $result_pais->fetch();
                                                        $pais = $row_pais['nome'];
                                                    } else {
                                                        $pais = "";
                                                    }
                                                    $morada = $row_morada['nome'].'&#13;&#10;'.$row_morada['rua'].'&#13;&#10;'.$row_morada['codigo_postal'].' - '.$row_morada['localidade'].'&#13;&#10;'.$pais;
                                                } else {
                                                    $morada = "O cliente não definiu uma morada de faturação.";
                                                }
                                            ?>
                                            <textarea class="form-control" style="resize: none;" disabled><?= $morada;?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label>Morada de Entrega</label>
                                            <?php
                                                if (isset($row['morada_entrega']) && $row['morada_entrega']!="") {
                                                    $result_morada = $pdo->prepare("SELECT * FROM morada WHERE id_morada = :morada");
                                                    $result_morada->execute(array('morada' => $row['morada_entrega']));
                                                    $row_morada = $result_morada->fetch();
                                                    if (!is_null($row_morada['pais']) && $row_morada['pais']!="") {
                                                        $result_pais = $pdo->prepare("SELECT * FROM pais WHERE iso = :pais");
                                                        $result_pais->execute(array('pais' => $row_morada['pais']));
                                                        $row_pais = $result_pais->fetch();
                                                        $pais = $row_pais['nome'];
                                                    } else {
                                                        $pais = "";
                                                    }
                                                    $morada = $row_morada['nome'].'&#13;&#10;'.$row_morada['rua'].'&#13;&#10;'.$row_morada['codigo_postal'].' - '.$row_morada['localidade'].'&#13;&#10;'.$pais;
                                                } else {
                                                    $morada = "O cliente não definiu uma morada de entrega.";
                                                }
                                            ?>
                                            <textarea class="form-control" style="resize: none;" disabled><?= $morada;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Carrinho</h4>
                            </div>
                            <div class="card-body">
                                <div class="row gx-2">
                                    <div class="col-md-12 mb-3">
                                        <?php
                                            $result_carrinho = $pdo->prepare("SELECT * FROM carrinho WHERE cliente = :cliente AND encomendado = 0");
                                            $result_carrinho->execute(array('cliente' => $cliente));
                                            $row_carrinho = $result_carrinho->fetch();
                                            if ($result_carrinho->rowCount()>0) {
                                                $result_carrinho_produto = $pdo->prepare("SELECT * FROM carrinho_produto WHERE carrinho = :carrinho ORDER BY id_carrinho_produto ASC");
                                                $result_carrinho_produto->execute(array('carrinho' => $row_carrinho['id_carrinho']));
                                                $row_carrinho_produto = $result_carrinho_produto->fetch();
                                                if ($result_carrinho_produto->rowCount()>0) {
                                                    for ($i=1; $i<=$result_carrinho_produto->rowCount(); $i++)  {
                                                        $result_produto = $pdo->prepare("SELECT * FROM produto WHERE id_produto = :produto");
                                                        $result_produto->execute(array('produto' => $row_carrinho_produto['produto']));
                                                        $row_produto = $result_produto->fetch();
                                                        if (strpos($row_produto['nome_pt'], "<br />")!==false) {
                                                            $array_titulo = explode("<br />", $row_produto['nome_pt']);
                                                            $titulo = $array_titulo[0]." ".$array_titulo[1];
                                                        } else {
                                                            $titulo = $row_produto['nome_pt'];
                                                        }
                                                        $result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
                                                        $result_imagem_produto->execute(array('produto' => $row_produto['id_produto']));
                                                        $row_imagem_produto = $result_imagem_produto->fetch();
                                                        if ($result_imagem_produto->rowCount()>0) {
                                                            $url = '../produtos/'.$row_produto['id_produto'].'/'.$row_imagem_produto['imagem'].'.jpg';
                                                        } else {
                                                            $url = 'assets/img/sem-imagem.jpg';
                                                        }
                                                        echo '<article class="itemlist">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-4 col-4 flex-grow-1 col-name">
                                                                        <div class="itemside">
                                                                            <div class="left">
                                                                                <img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'">
                                                                            </div>
                                                                            <div class="info">
                                                                                <h6 class="mb-0">'.$titulo.'<br>'.$row_produto['referencia'].'</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2 col-sm-2 col-4 col-price text-end"><span>'.$row_produto['preco'].'€</span></div>
                                                                </div>
                                                              </article>';
                                                        $row_carrinho_produto = $result_carrinho_produto->fetch();
                                                    }
                                                } else {
                                                    echo '<p>O cliente não tem produtos no carrinho.</p>';
                                                }
                                            } else {
                                                echo '<p>O cliente não tem produtos no carrinho.</p>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Wishlist</h4>
                            </div>
                            <div class="card-body">
                                <div class="row gx-2">
                                    <div class="col-md-12 mb-3">
                                        <?php
                                            $result_wishlist = $pdo->prepare("SELECT * FROM wishlist WHERE cliente = :cliente ORDER BY id_wishlist ASC");
                                            $result_wishlist->execute(array('cliente' => $cliente));
                                            $row_wishlist = $result_wishlist->fetch();
                                            if ($result_wishlist->rowCount()>0) {
                                                for ($i=1; $i<=$result_wishlist->rowCount(); $i++)  {
                                                    $result_produto = $pdo->prepare("SELECT * FROM produto WHERE id_produto = :produto");
                                                    $result_produto->execute(array('produto' => $row_wishlist['produto']));
                                                    $row_produto = $result_produto->fetch();
                                                    if (strpos($row_produto['nome_pt'], "<br />")!==false) {
                                                        $array_titulo = explode("<br />", $row_produto['nome_pt']);
                                                        $titulo = $array_titulo[0]." ".$array_titulo[1];
                                                    } else {
                                                        $titulo = $row_produto['nome_pt'];
                                                    }
                                                    $result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
                                                    $result_imagem_produto->execute(array('produto' => $row_produto['id_produto']));
                                                    $row_imagem_produto = $result_imagem_produto->fetch();
                                                    if ($result_imagem_produto->rowCount()>0) {
                                                        $url = '../produtos/'.$row_produto['id_produto'].'/1.jpg';
                                                    } else {
                                                        $url = 'assets/img/sem-imagem.jpg';
                                                    }
                                                    echo '<article class="itemlist">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4 col-sm-4 col-4 flex-grow-1 col-name">
                                                                    <div class="itemside">
                                                                        <div class="left">
                                                                            <img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'">
                                                                        </div>
                                                                        <div class="info">
                                                                            <h6 class="mb-0">'.$titulo.'<br>'.$row_produto['referencia'].'</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-2 col-4 col-price text-end"><span>'.$row_produto['preco'].'€</span></div>
                                                            </div>
                                                          </article>';
                                                    $row_wishlist = $result_wishlist->fetch();
                                                }
                                            } else {
                                                echo '<p>O cliente não tem produtos na wishlist.</p>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Encomendas</h4>
                            </div>
                            <div class="card-body">
                                <div class="row gx-2">
                                    <div class="col-md-12 mb-3">
                                        <?php
                                            $result_encomenda = $pdo->prepare("SELECT * FROM encomenda WHERE cliente = :cliente ORDER BY id_encomenda DESC");
                                            $result_encomenda->execute(array('cliente' => $cliente));
                                            $row_encomenda = $result_encomenda->fetch();
                                            if ($result_encomenda->rowCount()>0) {
                                                echo '<div class="table-responsive">
                                                        <table class="table align-middle table-nowrap mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th class="align-middle" scope="col">Referência</th>
                                                                    <th class="align-middle" scope="col">Data</th>
                                                                    <th class="align-middle" scope="col">Total</th>
                                                                    <th class="align-middle" scope="col">Estado de Encomenda</th>
                                                                    <th class="align-middle" scope="col">Método de Pagamento</th>
                                                                    <th class="align-middle text-end" scope="col">Ver Detalhes</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                for ($i=1; $i<= $result_encomenda->rowCount(); $i++) {
                                                    $data_encomenda = date_create($row_encomenda['data_encomenda']);
                                                    if ($row_encomenda['estado']==1) {
                                                        $estado = '<span class="badge badge-pill badge-soft-warning">Aguarda Pagamento</span>';
                                                    } else if ($row_encomenda['estado']==2) {
                                                        $estado = '<span class="badge badge-pill badge-soft-success">Em Processamento</span>';
                                                    } else if ($row_encomenda['estado']==3) {
                                                        $estado = '<span class="badge badge-pill badge-soft-success">Enviada</span>';
                                                    } else {
                                                        $estado = '<span class="badge badge-pill badge-soft-danger">Anulada</span>';
                                                    }
                                                    if ($row_encomenda['metodo_pagamento']==1) {
                                                        $pagamento = "Cartão de Crédito";
                                                    } else if ($row_encomenda['metodo_pagamento']==2) {
                                                        $pagamento = "MB Way";
                                                    } else if ($row_encomenda['metodo_pagamento']==3) {
                                                        $pagamento = "Multibanco";
                                                    } else {
                                                        $pagamento = "PayPal";
                                                    }
                                                    echo '<tr class="itemlist">
                                                            <td><a href="encomenda.php?id='.$row_encomenda['id_encomenda'].'" class="fw-bold">#'.$row_encomenda['referencia'].'</a></td>
                                                            <td>'.date_format($data_encomenda, 'd/m/Y').'</td>
                                                            <td>'.$row_encomenda['total'].'€</td>
                                                            <td>'.$estado.'</td>
                                                            <td><i class="material-icons md-payment font-xxl text-muted mr-5"></i> '.$pagamento.'</td>
                                                            <td class="text-end"><a href="encomenda.php?id='.$row_encomenda['id_encomenda'].'" class="btn btn-xs"> Detalhes</a></td>
                                                          </tr>';
                                                }
                                                echo '</tbody>
                                                    </table>
                                                </div>';
                                            } else {
                                                echo '<p>O cliente ainda não realizou encomendas.</p>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
                include("includes/footer.php");
            ?>
        </main>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js" integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.3/perfect-scrollbar.min.js" integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="assets/js/main.min.js"></script>
        <script src="assets/js/scripts.js"></script>
    </body>
</html>