<?php
    session_start();
    include("php/config.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    }
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $result = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
        $result->execute(array('categoria' => $_GET['id']));
        $row = $result->fetch();
        if ($result->rowCount()==0) {
            header("Location: categorias.php");
        }
    } else {
        header("Location: categorias.php");
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
                <button class="btn btn-icon btn-aside-minimize"><i
                        class="text-muted material-icons md-menu_open"></i></button>
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
                <li class="menu-item has-submenu active">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Produtos</span>
                    </a>
                    <div class="submenu">
                        <a href="produtos.php">Produtos</a>
                        <a href="categorias.php" class="active">Categorias</a>
                    </div>
                </li>
                <!-- <li class="menu-item">
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
                </li> -->
            </ul>
            <hr>
            <ul class="menu-aside">
                <li class="menu-item">
                    <a class="menu-link" href="mensagens.php">
                        <i class="icon material-icons md-message"></i>
                        <span class="text">Mensagens</span>
                    </a>
                </li>
                <!-- <li class="menu-item">
                    <a class="menu-link" href="pontos-venda.php">
                        <i class="icon fas fa-store"></i>
                        <span class="text">Pontos de Venda</span>
                    </a>
                </li> -->
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
                    <h2 class="content-title card-title"><?= $row['nome'];?></h2>
                    <p>Todos os produtos em <?= $row['nome'];?>.</p>
                </div>
                <div><span href="#" class="btn btn-primary btn-sm rounded" onclick="associarProduto()">Associar
                        Produto</span></div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <?php
                            $result_produto = $pdo->prepare("SELECT * FROM produto WHERE categoria = :categoria ORDER BY ordem ASC");
                            $result_produto->execute(array('categoria' => $row['id_categoria']));
                            $row_produto = $result_produto->fetch();
                            if ($result_produto->rowCount()>0) {
                                for ($i=1; $i<=$result_produto->rowCount(); $i++) {
                                    if (strpos($row['nome'], "<br />") !== false) {
                                        $array_titulo = explode("<br />", $row_produto['nome']);
                                        $titulo = $array_titulo[0]." ".$array_titulo[1];
                                    } else {
                                        $titulo = $row_produto['nome'];
                                    }
                                    if ($row_produto['estado']==1) {
                                        $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                                    } else if ($row_produto['estado']==2) {
                                        $estado = '<span class="badge rounded-pill alert-warning">Rascunho</span>';
                                    } else {
                                        $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                                    }
                                    $result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
                                    $result_imagem_produto->execute(array('produto' => $row_produto['id_produto']));
                                    $row_imagem_produto = $result_imagem_produto->fetch();
                                    if ($result_imagem_produto->rowCount()>0) {
                                        $url = "../produtos/".$row_produto['id_produto']."/".$row_imagem_produto['imagem'].".jpg";
                                    } else {
                                        $url = "assets/img/sem-imagem.jpg";
                                    }
                                    echo '<article class="itemlist">
                                            <div class="row align-items-center">
                                                <div class="col-sm-6 flex-grow-1 col-name">
                                                    <div class="itemside">
                                                        <div class="left"><img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'"></div>
                                                        <div class="info"><h6 class="mb-0">'.$titulo.'</h6></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-status">'.$estado.'</div>
                                                <div class="col-sm-2 col-action text-end">
                                                    <span class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="desassociarProdutoCategoria('.$row_produto['id_produto'].')"> <i class="material-icons md-delete_forever"></i> Desassociar</span>
                                                </div>
                                            </div>
                                          </article>';
                                    $row_produto = $result_produto->fetch();
                                }
                            } else {
                                echo '<p>Não existem produtos associados a esta categoria.</p>';
                            }
                        ?>
                </div>
            </div>
        </section>

        <?php
                include("includes/footer.php");
            ?>
    </main>

    <div class="modal fade custom-modal" id="modal-associar-produto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Associar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="selecionar-produto" class="form-label">Selecionar Produto</label>
                <select class="form-control form-select" id="selecionar-produto" onchange="mudarProduto()">
                    <option value="0">Selecione o Produto</option>
                    <?php
                            $result_produto = $pdo->prepare("SELECT * FROM produto WHERE categoria IS NULL OR categoria != :categoria ORDER BY nome ASC");
                            $result_produto->execute(array('categoria' => $row['id_categoria']));
                            $row_produto = $result_produto->fetch();
                            if ($result_produto->rowCount()>0) {
                                for ($i=1; $i<=$result_produto->rowCount(); $i++) {
                                    echo '<option value="'.$row_produto['id_produto'].'">'.$row_produto['nome'].'</option>';
                                    $row_produto = $result_produto->fetch();
                                }
                            }
                        ?>
                </select>
                <div id="dados-produtos" class="mt-30">
                    <div id="conteudo">
                        Selecione um produto para associar.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btn-associar-produto"
                    onclick="associarProdutoCategoria()">Associar Produto</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js"
        integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.3/perfect-scrollbar.min.js"
        integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
    $(document).ajaxStart(function() {
        $('.screen-overlay').show();
    });
    $(document).ajaxStop(function() {
        $('.screen-overlay').hide();
    });

    function associarProduto() {
        $('#btn-associar-produto').css('display', 'none');
        $('#selecionar-produto').val('0')
        $('#dados-produtos #conteudo').html('Selecione um produto para associar.');
        $('#modal-associar-produto').modal('show');
    }

    function mudarProduto() {
        var produto = $('#selecionar-produto').val();
        if (produto == '0') {
            $('#btn-associar-produto').css('display', 'none');
            $('#dados-produtos #conteudo').html('Selecione um produto para associar.');
        } else {
            $.ajax({
                type: 'POST',
                url: 'php/carregar-produtos.php',
                data: {
                    'produto': produto
                },
                cache: false,
                success: function(response) {
                    if (response != '') {
                        $('#dados-produtos #conteudo').html(response);
                        $('#btn-associar-produto').css('display', 'inline-block');
                        $('#btn-associar-produto').attr('onclick', 'associarProdutoCategoria(' + $(
                            '#selecionar-produto').val() + ')');
                    } else {
                        $('#btn-associar-produto').css('display', 'none');
                        $('#dados-produtos #conteudo').html(
                            'Não foi possível carregar o produto selecionado. Por favor tente novamente.'
                        );
                    }
                }
            });
        }
    }

    function associarProdutoCategoria(produto) {
        var produto = produto;
        var categoria = $('#categoria').val();
        $.ajax({
            type: 'POST',
            url: 'php/associar-produto-categoria.php',
            data: {
                'produto': produto,
                'categoria': categoria
            },
            cache: false,
            success: function(response) {
                $('#modal-associar-produto').modal('hide');
                if (response == '') {
                    Swal.fire(
                        'Produto Associado',
                        'O produto foi associado com sucesso.',
                        'success'
                    ).then((result) => {
                        location.reload();
                    })
                } else {
                    Swal.fire(
                        'Erro',
                        'Ocorreu um erro. Tente novamente.',
                        'error'
                    )
                }
            }
        });
    }

    function desassociarProdutoCategoria(produto) {
        var produto = produto;
        if (produto != '') {
            Swal.fire({
                title: 'Desassociar Produto',
                text: 'Tem a certeza que pretende desassociar este produto?',
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
                        url: 'php/desassociar-produto-categoria.php',
                        data: {
                            'produto': produto
                        },
                        cache: false,
                        success: function(response) {
                            alert(response);
                            if (response == '') {
                                Swal.fire(
                                    'Produto Desassociado',
                                    'O produto foi desassociado com sucesso.',
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                })
                            } else {
                                Swal.fire(
                                    'Erro',
                                    'Ocorreu um erro. Tente novamente.',
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
    </script>
</body>

</html>