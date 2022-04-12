<?php
    session_start();
    include("php/config.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    }
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $encomenda = $_GET['id'];
        $result = $pdo->prepare("SELECT * FROM encomenda WHERE id_encomenda = :encomenda");
        $result->execute(array('encomenda' => $encomenda));
        $row = $result->fetch();
        if ($result->rowCount()==0) {
            header("Location: encomendas.php");
        }
        $query = $pdo->prepare("UPDATE notificacao SET estado = 1 WHERE destino = :encomenda AND tipo = 3");
        $query->execute(array('encomenda' => $encomenda));
    } else {
        header("Location: encomendas.php");
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
                    <li class="menu-item active">
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
                    <li class="menu-item">
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
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Detalhes da Encomenda</h2>
                        <p>#<?= $row['referencia'];?></p>
                    </div>
                </div>

                <div class="card">
                    <header class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-3 col-6 me-auto mb-md-0 mb-3">
                                <small>Encomenda #<?= $row['referencia'];?></small><br>
                                <?php
                                    $data_encomenda = date_create($row['data_encomenda']);
                                ?>
                                <span><b><?= date_format($data_encomenda, "d/m/Y H:i");?></b></span>
                            </div>

                            <div class="col-md-3 col-6">
                                <select class="form-select d-inline-block mb-lg-0" id="estado" onchange="estadoEncomenda(<?= $encomenda;?>)">
                                    <option value="0">Alterar Estado</option>
                                    <option value="1">Aguarda Pagamento</option>
                                    <option value="2">Em Processamento</option>
                                    <option value="3">Enviada</option>
                                    <option value="4">Cancelada</option>
                                </select>
                            </div>
                        </div>
                    </header>

                    <div class="card-body">
                        <div class="row mb-50 mt-20 order-info-wrap">
                            <div class="col-md-4">
                                <article class="icontext align-items-start">
                                    <span class="icon icon-sm rounded-circle bg-primary-light">
                                        <i class="text-primary material-icons md-person" style="margin-top: -6px;"></i>
                                    </span>
                                    <div class="text box shadow-sm bg-light">
                                        <h6 class="mb-1">Cliente</h6>
                                        <?php
                                            $result_cliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :cliente");
                                            $result_cliente->execute(array('cliente' => $row['cliente']));
                                            $row_cliente = $result_cliente->fetch();
                                        ?>
                                        <p class="mb-1">
                                            <?= $row_cliente['nome'];?><br>
                                            <?= $row_cliente['email'];?><br>
                                            <?= $row_cliente['telefone'];?>
                                        </p>
                                        <a href="cliente.php?id=<?= $row_cliente['id_cliente'];?>">Ver Perfil</a>
                                    </div>
                                </article>
                            </div>

                            <div class="col-md-4">
                                <article class="icontext align-items-start">
                                    <span class="icon icon-sm rounded-circle bg-primary-light">
                                        <i class="text-primary material-icons md-description" style="margin-top: -6px;"></i>
                                    </span>
                                    <div class="text box shadow-sm bg-light">
                                        <h6 class="mb-1">Morada de Faturação</h6>
                                        <?php
                                            $result_morada = $pdo->prepare("SELECT * FROM morada WHERE id_morada = :morada");
                                            $result_morada->execute(array('morada' => $row['morada_faturacao']));
                                            $row_morada = $result_morada->fetch();
                                        ?>
                                        <p class="mb-1">
                                            <?= $row_morada['nome'];?><br>
                                            <?= $row_morada['rua'];?><br>
                                            <?= $row_morada['codigo_postal']." - ".$row_morada['localidade'];?><br>
                                            <?php
                                                $result_pais = $pdo->prepare("SELECT * FROM pais WHERE iso = :pais");
                                                $result_pais->execute(array('pais' => $row_morada['pais']));
                                                $row_pais = $result_pais->fetch();
                                                echo $row_pais['nome'];
                                            ?>
                                            <br>
                                            <?= $row_morada['nif'];?>
                                        </p>
                                    </div>
                                </article>
                            </div>

                            <div class="col-md-4">
                                <article class="icontext align-items-start">
                                    <span class="icon icon-sm rounded-circle bg-primary-light">
                                        <i class="text-primary material-icons md-place" style="margin-top: -6px;"></i>
                                    </span>
                                    <div class="text box shadow-sm bg-light">
                                        <h6 class="mb-1">Morada de Entrega</h6>
                                        <?php
                                            $result_morada = $pdo->prepare("SELECT * FROM morada WHERE id_morada = :morada");
                                            $result_morada->execute(array('morada' => $row['morada_entrega']));
                                            $row_morada = $result_morada->fetch();
                                        ?>
                                        <p class="mb-1">
                                            <?= $row_morada['nome'];?><br>
                                            <?= $row_morada['rua'];?><br>
                                            <?= $row_morada['codigo_postal']." - ".$row_morada['localidade'];?><br>
                                            <?php
                                                $result_pais = $pdo->prepare("SELECT * FROM pais WHERE iso = :pais");
                                                $result_pais->execute(array('pais' => $row_morada['pais']));
                                                $row_pais = $result_pais->fetch();
                                                echo $row_pais['nome'];
                                            ?>
                                        </p>
                                    </div>
                                </article>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="55%">Produto</th>
                                                <th width="15%">Preço Unitário</th>
                                                <th width="15%">Quantidade</th>
                                                <th width="15%" class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $subtotal = 0;
                                                $result_carrinho_produto = $pdo->prepare("SELECT * FROM carrinho_produto WHERE carrinho = :carrinho ORDER BY id_carrinho_produto ASC");
                                                $result_carrinho_produto->execute(array('carrinho' => $row['carrinho']));
                                                if ($result_carrinho_produto->rowCount()>0) {
                                                    $row_carrinho_produto = $result_carrinho_produto->fetch();
                                                    for ($i=1; $i<=$result_carrinho_produto->rowCount(); $i++) {
                                                        $result_produto = $pdo->prepare("SELECT * FROM produto WHERE id_produto = :produto");
                                                        $result_produto->execute(array('produto' => $row_carrinho_produto['produto']));
                                                        $row_produto = $result_produto->fetch();
                                                        if (strpos($row_produto['nome_pt'], "<br />") !== false) {
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
                                                        $preco = $row_carrinho_produto['preco'] * $row_carrinho_produto['quantidade'];
                                                        $subtotal += $preco;
                                                        echo '<tr>
                                                                <td>
                                                                    <div class="left align-middle" style="display: inline-block;"><img src="'.$url.'" width="40" height="40" class="img-xs" alt="'.$titulo.'"></div>
                                                                    <div class="info align-middle ml-15" style="display: inline-block;">'.$titulo.'<br>'.$row_produto['referencia'].'</div>
                                                                </td>
                                                                <td class="text-center" style="position: relative; top: -12px;">'.$row_carrinho_produto['preco'].'€</td>
                                                                <td class="text-center" style="position: relative; top: -12px;">'.$row_carrinho_produto['quantidade'].'</td>
                                                                <td class="text-end" style="position: relative; top: -12px;">'.number_format($preco, 2, '.', '').'€</td>
                                                              </tr>';
                                                        $row_carrinho_produto = $result_carrinho_produto->fetch();
                                                    }
                                                }
                                            ?>
                                            <tr>
                                                <td colspan="4">
                                                    <article class="float-end">
                                                        <dl class="dlist">
                                                            <dt>Subtotal:</dt>
                                                            <dd><?= number_format($subtotal, 2, '.', '');?>€</dd>
                                                        </dl>

                                                        <dl class="dlist">
                                                            <dt>Portes:</dt>
                                                            <dd><?= number_format($row['portes'], 2, '.', '');?>€</dd>
                                                        </dl>

                                                        <?php
                                                            $desconto = 0;
                                                            if (!is_null($row['voucher']) && $row['voucher']!="") {
                                                                $result_voucher = $pdo->prepare("SELECT * FROM voucher WHERE id_voucher = :voucher");
                                                                $result_voucher->execute(array('voucher' => $row['voucher']));
                                                                if ($result_voucher->rowCount()>0) {
                                                                    $row_voucher = $result_voucher->fetch();
                                                                    $passei = 1;
                                                                    if (!is_null($row_voucher['valor_minimo'] && $row_voucher['valor_minimo']!=0.00)) {
                                                                        if ($subtotal<$row_voucher['valor_minimo']) {
                                                                            $passei = 0;
                                                                        }
                                                                    }
                                                                    if (!is_null($row_voucher['limite_utilizacoes']) && $row_voucher['limite_utilizacoes']!=0) {
                                                                        if ($row_voucher['utilizacoes']>=$row_voucher['limite_utilizacoes']) {
                                                                            $passei = 0;
                                                                        }
                                                                    }
                                                                    if (!is_null($row_voucher['data_expiracao'])) {
                                                                        if (date("Y-m-d")>$row_voucher['data_expiracao']) {
                                                                            $passei = 0;
                                                                        }
                                                                    }
                                                                    if (!is_null($row_voucher['cliente']) && $row_voucher['cliente']!=0) {
                                                                        if ($_SESSION['cliente']!=$row_voucher['cliente']) {
                                                                            $passei = 0;
                                                                        }
                                                                    }
                                                                    if ($passei==1) {
                                                                        if ($row_voucher['tipo_desconto']==1) {
                                                                            $total_encomenda = $subtotal - $row_voucher['desconto'];
                                                                            $desconto = $subtotal - $total_encomenda;
                                                                        } else {
                                                                            $total_encomenda = $subtotal - ($subtotal * ($row_voucher['desconto'] / 100));
                                                                            $desconto = $subtotal - $total_encomenda;
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                $total_encomenda = $subtotal;
                                                            }
                                                        ?>
                                                        <dl class="dlist">
                                                            <dt>Desconto:</dt>
                                                            <dd>-<?= number_format($desconto, 2, '.', '');?>€</dd>
                                                        </dl>

                                                        <dl class="dlist">
                                                            <dt class="h5">Total:</dt>
                                                            <dd><b class="h5"><?= $row['total'];?>€</b></dd>
                                                        </dl>

                                                        <dl class="dlist">
                                                            <dt>Estado:</dt>
                                                            <?php
                                                                if ($row['estado']==1) {
                                                                    $estado = '<span class="badge rounded-pill alert-warning text-warning">Aguarda Pagamento</span>';
                                                                } else if ($row['estado']==2) {
                                                                    $estado = '<span class="badge rounded-pill alert-success text-success">Em Processamento</span>';
                                                                } else if ($row['estado']==3) {
                                                                    $estado = '<span class="badge rounded-pill alert-success text-success">Enviada</span>';
                                                                } else {
                                                                    $estado = '<span class="badge rounded-pill alert-danger text-danger">Cancelada</span>';
                                                                }
                                                            ?>
                                                            <dd><?= $estado;?></dd>
                                                        </dl>
                                                    </article>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="box shadow-sm bg-light">
                                    <h6 class="mb-15">Método de Pagamento</h6>
                                    <?php
                                        if ($row['metodo_pagamento']==1) {
                                            $pagamento = "Cartão de Crédito";
                                        } else if ($row['metodo_pagamento']==2) {
                                            $pagamento = "MB Way";
                                        } else if($row['metodo_pagamento']==3) {
                                            $pagamento = "Multibanco";
                                        } else {
                                            $pagamento = "PayPal";
                                        }
                                    ?>
                                    <p><?= $pagamento;?></p>
                                </div>

                                <div class="mt-20 box shadow-sm bg-light">
                                    <div class="mb-3">
                                        <h6 class="mb-15">Observações</h6>
                                        <p><?= $row['observacoes'];?></p>
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
        <script>
            function estadoEncomenda(encomenda) {
                var estado = $('#estado').val();
                var encomenda = encomenda;
                if (estado>0) {
                    $.ajax({
                        type: 'POST',
                        url: 'php/editar/alterar-estado-encomenda.php',
                        data: {'estado': estado, 'encomenda': encomenda},
                        cache: false,
                        success: function(response) {
                            if (response=='') {
                                Swal.fire(
                                    'Estado Alterado',
                                    'O estado da encomenda foi alterado com sucesso.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })  
                            }
                        }
                    });
                }
            }
        </script>
    </body>
</html>