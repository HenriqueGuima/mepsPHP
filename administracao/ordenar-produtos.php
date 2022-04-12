<?php
    session_start();
    include("php/config.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
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
                    <li class="menu-item has-submenu active">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-shopping_bag"></i>
                            <span class="text">Produtos</span>
                        </a>
                        <div class="submenu">
                            <a href="produtos.php" class="active">Produtos</a>
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
                        <h2 class="content-title card-title">Ordenar Produtos</h2>
                        <p>Aqui pode ordenar todos os produtos da sua loja.</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-3 col-6 me-auto mb-md-0 mb-3"></div>
                            <div class="col-md-3 col-6 text-end">
                                <a href="#" class="btn btn-primary btn-sm rounded" id="reordenar">Reordenar</a>
                            </div>
                        </div>
                    </header>

                    <div class="card-body" id="produtos">
                        <?php
                            $result = $pdo->prepare("SELECT * FROM produto ORDER BY ordem ASC");
                            $result->execute();
                            $row = $result->fetch();
                            if ($result->rowCount()>0) {
                                for ($i=1; $i<=$result->rowCount(); $i++) {
                                    if (strpos($row['nome_pt'], "<br />") !== false) {
                                        $array_titulo = explode("<br />", $row['nome_pt']);
                                        $titulo = $array_titulo[0]." ".$array_titulo[1];
                                    } else {
                                        $titulo = $row['nome_pt'];
                                    }
                                    if ($row['estado']==1) {
                                        $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                                    } else if ($row['estado']==2) {
                                        $estado = '<span class="badge rounded-pill alert-warning">Rascunho</span>';
                                    } else {
                                        $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                                    }
                                    $result_imagem_produto = $pdo->prepare("SELECT * FROM imagem_produto WHERE produto = :produto ORDER BY ordem ASC");
                                    $result_imagem_produto->execute(array('produto' => $row['id_produto']));
                                    $row_imagem_produto = $result_imagem_produto->fetch();
                                    if ($result_imagem_produto->rowCount()>0) {
                                        $url = '../produtos/'.$row['id_produto'].'/'.$row_imagem_produto['imagem'].'.jpg';
                                    } else {
                                        $url = 'assets/img/sem-imagem.jpg';
                                    }
                                    if (!is_null($row['categoria']) && !empty($row['categoria'])) {
                                        $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
                                        $result_categoria->execute(array('categoria' => $row['categoria']));
                                        $row_categoria = $result_categoria->fetch();
                                        $categoria = $row_categoria['nome_pt'];
                                    } else {
                                        $categoria = "";
                                    }
                                    echo '<article class="itemlist" id="'.$row['id_produto'].'">
                                            <div class="row align-items-center" id="int-produtos">
                                                <div class="col-sm-4 flex-grow-1 col-name">
                                                    <div class="itemside">
                                                        <div class="left"><img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'"></div>
                                                        <div class="info"><h6 class="mb-0">'.$titulo.'<br>'.$row['referencia'].'</h6></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-price"><span>'.$categoria.'</span></div>
                                                <div class="col-sm-2 col-price"><span>'.$row['preco'].'€</span></div>
                                                <div class="col-sm-2 col-status">'.$estado.'</div>
                                                <div class="col-sm-2 col-action text-end">
                                                    <a href="editar-produto.php?id='.$row['id_produto'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar</a>
                                                    <span class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminar('.$row['id_produto'].')"> <i class="material-icons md-delete_forever"></i> Eliminar</span>
                                                </div>
                                            </div>
                                          </article>';
                                    $row = $result->fetch();
                                }
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
            $(document).ready(function () {
                var dropIndex;
                $('#produtos').sortable({
                    update: function(event, ui) { 
                        dropIndex = ui.item.index();
                    }
                });
                $('#reordenar').click(function (e) {
                    var idsArray = [];
                    $('#produtos article').each(function (index) {
                        var id = $(this).attr('id');
                        idsArray.push(id);
                    });
                    $.ajax({
                        url: 'php/ordenar/ordenar-produtos.php',
                        type: 'post',
                        data: {'idsArray': idsArray},
                        success: function (response) {
                           Swal.fire(
                                'Produtos Reordenados',
                                'Os produtos foram reordenados com sucesso.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            })
                        }
                    });
                    e.preventDefault();
                });
            });

            function eliminar(produto) {
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
        </script>
    </body>
</html>