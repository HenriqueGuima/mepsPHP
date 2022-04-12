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
                        <h2 class="content-title card-title">Encomendas</h2>
                        <p>Todas as encomendas da sua loja.</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-md-3 col-6 me-auto mb-md-0 mb-3"></div>
                            <div class="col-md-3 col-6">
                                <select class="form-select" name="estado" id="estado" onchange="filtrarRegistos(10, 1)">
                                    <option value="0" selected>Estado</option>
                                    <option value="1">Aguarda Pagamento</option>
                                    <option value="2">Em Processamento</option>
                                    <option value="3">Enviada</option>
                                    <option value="4">Cancelada</option>
                                </select>
                            </div>
                        </div>
                    </header>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
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
                                <tbody id="int-registos"></tbody>
                            </table>
                        </div>
                        <div class="pagination-area" id="int-paginacao"></div>
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
        <script src="assets/js/main.min.js"></script>
        <script>
            $(document).ready(function() {
                mostrarRegistos(10, 1);
            });

            function mostrarRegistos(registos, pagina) {
                $.ajax({
                    type: 'POST',
                    url: 'php/int/int-encomendas.php?mostrar=' + registos + '&pagina=' + pagina,
                    data: {},
                    cache: false,
                    success: function(response) {
                        $('#int-registos').html(response);
                        $.ajax({
                            type: 'POST',
                            url: 'php/int/paginacao-encomendas.php?mostrar=' + registos + '&pagina=' + pagina,
                            data: {},
                            cache: false,
                            success: function(response) {
                                $('#int-paginacao').html(response);
                            }
                        });
                    }
                });
            }

            function filtrarRegistos(registos, pagina) {
                var estado = $('#estado').val();
                var filtro = 1;
                $.ajax({
                    type: 'POST',
                    url: 'php/int/int-encomendas.php?mostrar=' + registos + '&pagina=' + pagina,
                    data: {'estado': estado, 'filtro': filtro},
                    cache: false,
                    success: function(response) {
                        $('#int-registos').html(response);
                        $.ajax({
                            type: 'POST',
                            url: 'php/int/paginacao-encomendas.php?mostrar=' + registos + '&pagina=' + pagina,
                            data: {'estado': estado, 'filtro': filtro},
                            cache: false,
                            success: function(response) {
                                $('#int-paginacao').html(response);
                            }
                        });
                    }
                });
            }
        </script>
    </body>
</html>