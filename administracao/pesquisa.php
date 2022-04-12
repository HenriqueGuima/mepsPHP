<?php
    session_start();
    include("php/config.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    }
    if (!isset($_GET['termo']) || $_GET['termo']=="") {
        header("Location: index.php");
    } else {
        $termo = htmlentities($_GET['termo'], ENT_QUOTES, 'UTF-8');
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
                        <h2 class="content-title card-title">Pesquisa</h2>
                        <p>Resultados de <?= $termo;?>.</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <header class="card-header">
                        <div class="col-md-12 col-12 me-auto mb-md-0">
                            <h5 class="card-title mb-0">Produtos</h5>
                        </div>
                    </header>
                    <div class="card-body">
                        <?php
                            $result_produto = $pdo->prepare("SELECT * FROM produto WHERE nome_pt LIKE :termo ORDER BY nome_pt ASC");
                            $result_produto->execute(array('termo' => "%".$termo."%"));
                            $row_produto = $result_produto->fetch();
                            if ($result_produto->rowCount()>0) {
                                for ($i=1; $i<=$result_produto->rowCount(); $i++) {
                                    if (strpos($row_produto['nome_pt'], "<br />") !== false) {
                                        $array_titulo = explode("<br />", $row_produto['nome_pt']);
                                        $titulo = $array_titulo[0]." ".$array_titulo[1];
                                    } else {
                                        $titulo = $row_produto['nome_pt'];
                                    }
                                    if ($row_produto['estado']==1) {
                                        $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                                    } else if ($row_produto['estado']==2) {
                                        $estado = '<span class="badge rounded-pill alert-warning">Rascunho</span>';
                                    } else {
                                        $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                                    }
                                    $result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto");
                                    $result_imagem_produto->execute(array('produto' => $row_produto['id_produto']));
                                    $row_imagem_produto = $result_imagem_produto->fetch();
                                    if ($result_imagem_produto->rowCount()>0) {
                                        $url = '../produtos/'.$row_produto['id_produto'].'/'.$row_imagem_produto['imagem'].'.jpg';
                                    } else {
                                        $url = 'assets/img/sem-imagem.jpg';
                                    }
                                    if (!is_null($row_produto['categoria']) && !empty($row_produto['categoria'])) {
                                        $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
                                        $result_categoria->execute(array('categoria' => $row_produto['categoria']));
                                        $row_categoria = $result_categoria->fetch();
                                        $categoria = $row_categoria['nome_pt'];
                                    } else {
                                        $categoria = "";
                                    }
                                    echo '<article class="itemlist">
                                            <div class="row align-items-center" id="int-produtos">
                                                <div class="col-sm-4 flex-grow-1 col-name">
                                                    <div class="itemside">
                                                        <div class="left"><img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'"></div>
                                                        <div class="info"><h6 class="mb-0">'.$titulo.'<br>'.$row_produto['referencia'].'</h6></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-price"><span>'.$categoria.'</span></div>
                                                <div class="col-sm-2 col-price"><span>'.$row_produto['preco'].'€</span></div>
                                                <div class="col-sm-2 col-status">'.$estado.'</div>
                                                <div class="col-lg-2 col-sm-2 col-4 col-action text-end">
                                                    <a href="editar-produto.php?id='.$row_produto['id_produto'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar</a>
                                                    <a href="#" class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminarProduto('.$row_produto['id_produto'].')"> <i class="material-icons md-delete_forever"></i> Eliminar</a>
                                                </div>
                                            </div>
                                          </article>';
                                    $row_produto = $result_produto->fetch();
                                }
                            } else {
                                echo '<p>Não foram encontrados resultados.</p>';
                            }
                        ?>
                    </div>
                </div>

                <div class="card mb-4">
                    <header class="card-header">
                        <div class="col-md-12 col-12 me-auto mb-md-0">
                            <h5 class="card-title mb-0">Encomendas</h5>
                        </div>
                    </header>
                    <div class="card-body">
                        <?php
                            $result_encomenda = $pdo->prepare("SELECT * FROM encomenda WHERE referencia LIKE :termo ORDER BY referencia ASC");
                            $result_encomenda->execute(array('termo' => "%".$termo."%"));
                            $row_encomenda = $result_encomenda->fetch();
                            if ($result_encomenda->rowCount()>0) {
                                echo '<div class="table-responsive">
                                        <table class="table align-middle table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="align-middle" scope="col">Referência</th>
                                                    <th class="align-middle" scope="col">Nome</th>
                                                    <th class="align-middle" scope="col">Data</th>
                                                    <th class="align-middle" scope="col">Total</th>
                                                    <th class="align-middle" scope="col">Estado da Encomenda</th>
                                                    <th class="align-middle" scope="col">Método de Pagamento</th>
                                                    <th class="align-middle text-end" scope="col">Ver Detalhes</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                for ($i=1; $i<=$result_encomenda->rowCount(); $i++) {
                                    if ($row_encomenda['estado']==1) {
                                        $estado = '<span class="badge badge-pill badge-soft-warning">Aguarda Pagamento</span>';
                                    } else if ($row_encomenda['estado']==2) {
                                        $estado = '<span class="badge badge-pill badge-soft-success">Em Processamento</span>';
                                    } else if ($row_encomenda['estado']==3) {
                                        $estado = '<span class="badge badge-pill badge-soft-success">Enviada</span>';
                                    } else {
                                        $estado = '<span class="badge badge-pill badge-soft-danger">Cancelada</span>';
                                    }
                                    $result_cliente = $pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :cliente");
                                    $result_cliente->execute(array('cliente' => $row_encomenda['cliente']));
                                    $row_cliente = $result_cliente->fetch();
                                    $nome_completo = explode(" ", $row_cliente['nome']);
                                    $nome = $nome_completo[0];
                                    $apelido = $nome_completo[count($nome_completo)-1];
                                    $data_encomenda = date_create($row_encomenda['data_encomenda']);
                                    if ($row_encomenda['metodo_pagamento']==1) {
                                        $pagamento = "Cartão de Crédito";
                                    } else if ($row_encomenda['metodo_pagamento']==2) {
                                        $pagamento = "MB Way";
                                    } else if ($row_encomenda['metodo_pagamento']==3) {
                                        $pagamento = "Multibanco";
                                    } else {
                                        $pagamento = "PayPal";
                                    }
                                    echo '<tr>
                                            <td><a href="encomenda.php?id='.$row_encomenda['id_encomenda'].'" class="fw-bold">#'.$row_encomenda['referencia'].'</a></td>
                                            <td>'.$nome.' '.$apelido.'</td>
                                            <td>'.date_format($data_encomenda, 'd/m/Y H:i').'</td>
                                            <td>'.$row_encomenda['total'].'€</td>
                                            <td>'.$estado.'</td>
                                            <td><i class="material-icons md-payment font-xxl text-muted mr-5"></i> '.$pagamento.'</td>
                                            <td class="text-end"><a href="encomenda.php?id='.$row_encomenda['id_encomenda'].'" class="btn btn-xs"> Detalhes</a></td>
                                          </tr>';
                                    $row_encomenda = $result_encomenda->fetch();
                                }
                                echo '</tbody>
                                    </table>
                                  </div>';
                            } else {
                                echo '<p>Não foram encontrados resultados.</p>';
                            }
                        ?>
                    </div>
                </div>

                <div class="card mb-4">
                    <header class="card-header">
                        <div class="col-md-12 col-12 me-auto mb-md-0">
                            <h5 class="card-title mb-0">Vouchers</h5>
                        </div>
                    </header>
                    <div class="card-body">
                        <?php
                            $result_voucher = $pdo->prepare("SELECT * FROM voucher WHERE codigo LIKE :termo ORDER BY codigo ASC");
                            $result_voucher->execute(array('termo' => "%".$termo."%"));
                            $row_voucher = $result_voucher->fetch();
                            if ($result_voucher->rowCount()==0) {
                                echo '<p>Não foram encontrados resultados.</p>';
                            } else {
                                echo '<div class="table-responsive">
                                        <table class="table align-middle table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="align-middle" scope="col">Código</th>
                                                    <th class="align-middle" scope="col">Desconto</th>
                                                    <th class="align-middle" scope="col">Data</th>
                                                    <th class="align-middle" scope="col">Data de Expiração</th>
                                                    <th class="align-middle" scope="col">utilizacoes</th>
                                                    <th class="align-middle" scope="col">Limite de Utilizações</th>
                                                    <th class="align-middle" scope="col">Estado</th>
                                                    <th class="align-middle text-end" scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                for ($i=1; $i<=$result_voucher->rowCount(); $i++) {
                                    if ($row_voucher['tipo_desconto']==1) {
                                        $desconto = $row_voucher['desconto']."€";
                                    } else {
                                        $desconto = intval($row_voucher['desconto'])."%";
                                    }
                                    $data = date_create($row_voucher['data']);
                                    if ($row_voucher['estado']==1) {
                                        $estado = '<span class="badge badge-pill badge-soft-success">Ativo</span>';
                                    } else if ($row_voucher['estado']==2) {
                                        $estado = '<span class="badge badge-pill badge-soft-danger">Inativo</span>';
                                    } else if ($row_voucher['estado']==3) {
                                        $estado = '<span class="badge badge-pill badge-soft-danger">Expirado</span>';
                                    }
                                    if (!is_null($row_voucher['data_expiracao']) && $row_voucher['data_expiracao']!="") {
                                        if ($row_voucher['data_expiracao']<date("Y-m-d")) {
                                            $query = $pdo->prepare("UPDATE voucher SET estado = 3 WHERE id_voucher = :voucher");
                                            $query->execute(array('voucher' => $row_voucher['id_voucher']));
                                            $estado = '<span class="badge badge-pill badge-soft-danger">Expirado</span>';
                                        }
                                        $data_expiracao = date_create($row_voucher['data_expiracao']);
                                        $data_expiracao_mostrar = date_format("d/m/Y");
                                    } else {
                                        $data_expiracao_mostrar = "";
                                    }
                                    echo '<tr>
                                            <td>'.$row_voucher['codigo'].'</td>
                                            <td>'.$desconto.'</td>
                                            <td>'.date_format($data, "d/m/Y").'</td>
                                            <td>'.$data_expiracao_mostrar.'</td>
                                            <td>'.$row_voucher['utilizacoes'].'</td>
                                            <td>'.$row_voucher['limite_utilizacoes'].'</td>
                                            <td>'.$estado.'</td>
                                            <td class="text-end">
                                                <a href="editar-voucher.php?id='.$row_voucher['id_voucher'].'" class="btn btn-xs"> Editar</a>
                                                <span onclick="eliminarVoucher('.$row_voucher['id_voucher'].')" class="btn btn-xs"> Eliminar</span>
                                            </td>
                                          </tr>';
                                    $row_voucher = $result_voucher->fetch();
                                }
                                echo '</tbody>
                                    </table>
                                  </div>';
                            }
                        ?>
                    </div>
                </div>

                <div class="card mb-4">
                    <header class="card-header">
                        <div class="col-md-12 col-12 me-auto mb-md-0">
                            <h5 class="card-title mb-0">Clientes</h5>
                        </div>
                    </header>
                    <div class="card-body">
                        <?php
                            $result_cliente = $pdo->prepare("SELECT * FROM cliente WHERE nome LIKE :nome OR email LIKE :email OR telefone LIKE :telefone OR nif LIKE :nif ORDER BY nome ASC");
                            $result_cliente->execute(array('nome' => "%".$termo."%", 'email' => "%".$termo."%", 'telefone' => "%".$termo."%", 'nif' => "%".$termo."%"));
                            $row_cliente = $result_cliente->fetch();
                            if ($result_cliente->rowCount()==0) {
                                echo '<p>Não foram encontrados resultados.</p>';
                            } else {
                                echo '<div class="table-responsive">
                                        <table class="table align-middle table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="align-middle" scope="col">Nome</th>
                                                    <th class="align-middle" scope="col">E-mail</th>
                                                    <th class="align-middle" scope="col">Data de Registo</th>
                                                    <th class="align-middle" scope="col">Encomendas</th>
                                                    <td class="align-middle" scope="col">Estado</td>
                                                    <th class="align-middle text-end" scope="col">Ver Detalhes</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                for ($i=1; $i<=$result_cliente->rowCount(); $i++) {
                                    $nome_completo = explode(" ", $row_cliente['nome']);
                                    $nome = $nome_completo[0];
                                    $apelido = $nome_completo[count($nome_completo)-1];
                                    $data_registo = date_create($row_cliente['data_registo']);
                                    if ($row_cliente['estado']==1) {
                                        $estado = '<span class="badge badge-pill badge-soft-success">Ativo</span>';
                                    } else if ($row_cliente['estado']==2) {
                                        $estado = '<span class="badge badge-pill badge-soft-danger">Bloqueado</span>';
                                    } else {
                                        $estado = '<span class="badge badge-pill badge-soft-warning">Não Verificado</span>';
                                    }
                                    $result_encomenda = $pdo->prepare("SELECT * FROM encomenda WHERE cliente = :cliente");
                                    $result_encomenda->execute(array('cliente' => $row_cliente['id_cliente']));
                                    echo '<tr>
                                            <td>'.$nome.' '.$apelido.'</td>
                                            <td>'.$row_cliente['email'].'</td>
                                            <td>'.date_format($data_registo, 'd/m/Y').'</td>
                                            <td>'.$result_encomenda->rowCount().'</td>
                                            <td>'.$estado.'</td>
                                            <td class="text-end"><a href="cliente.php?id='.$row_cliente['id_cliente'].'" class="btn btn-xs"> Detalhes</a></td>
                                          </tr>';
                                    $row_cliente = $result_cliente->fetch();
                                }
                                echo '</tbody>
                                    </table>
                                  </div>';
                            }
                        ?>
                    </div>
                </div>
            </section>

            <?php
                include("includes/footer.php");
            ?>
        </main>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js" integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.3/perfect-scrollbar.min.js" integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="assets/js/core.min.js"></script>
        <script src="assets/js/main.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        <script>
            function eliminarProduto(produto) {
                var produto = produto;
                if (produto!='') {
                    Swal.fire({
                        title: 'Eliminar Produto',
                        text: 'Tem a certeza que pretende eliminar este produto?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: 'php/eliminar/eliminar-produto.php',
                                data: {'produto': produto},
                                cache: false,
                                success: function(response) {
                                    if (response=='') {
                                        Swal.fire(
                                            'Produto Eliminado',
                                            'O produto foi eliminado com sucesso.',
                                            'success'
                                        ).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })                     
                                    } else {
                                        Swal.fire(
                                            'Erro',
                                            response,
                                            'error'
                                        )
                                    }
                                },
                            });
                        }
                    })
                } else {
                    Swal.fire('Ocorreu um erro. Por favor tente novamente');
                }
            }

            function eliminarVoucher(voucher) {
                var voucher = voucher;
                if (voucher!='') {
                    Swal.fire({
                        title: 'Eliminar Voucher',
                        text: 'Tem a certeza que pretende eliminar este voucher?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: 'php/eliminar/eliminar-voucher.php',
                                data: {'voucher': voucher},
                                cache: false,
                                success: function(response) {
                                    if (response=='') {
                                        Swal.fire(
                                            'Voucher Eliminado',
                                            'O voucher foi eliminado com sucesso.',
                                            'success'
                                        ).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                    } else {
                                        Swal.fire(
                                            'Erro',
                                            response,
                                            'error'
                                        ).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                    }
                                },
                            }); 
                        }
                    })
                } else {
                    Swal.fire('Ocorreu um erro. Por favor tente novamente');
                }
            }
        </script>
    </body>
</html>