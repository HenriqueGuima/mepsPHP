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
                <button class="btn btn-icon btn-aside-minimize"><i
                        class="text-muted material-icons md-menu_open"></i></button>
            </div>
        </div>

        <nav>
            <ul class="menu-aside">
                <li class="menu-item active">
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
                <!-- <li class="menu-item">
                    <a class="menu-link" href="encomendas.php">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Encomendas</span>
                    </a>
                </li> -->
                <!-- <li class="menu-item">
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
                    <h2 class="content-title card-title">Painel de Administração</h2>
                    <p>Todos os dados sobre o seu negócio.</p>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-3">
                    <div class="card card-body mb-4">
                        <article class="icontext">
                            <span class="icon icon-sm rounded-circle bg-warning-light"><i
                                    class="text-warning material-icons md-qr_code"></i></span>
                            <div class="text">
                                <h6 class="mb-1 card-title">Produtos</h6>
                                <?php
                                        $result_produto = $pdo->prepare("SELECT * FROM produto");
                                        $result_produto->execute();
                                        $result_categoria = $pdo->prepare("SELECT * FROM categoria");
                                        $result_categoria->execute();
                                    ?>
                                <span><?= $result_produto->rowCount();?></span>
                                <span class="text-sm">Em <?= $result_categoria->rowCount();?> categorias</span>
                            </div>
                        </article>
                    </div>
                </div>

            </div>


            <div class="row">


                <div class="col-lg-6">
                    <div class="card mb-4">
                        <article class="card-body">
                            <h5 class="card-title">Atividade Recente</h5>
                            <ul class="verti-timeline list-unstyled font-sm">
                                <?php
                                        $result_notificacao = $pdo->prepare("SELECT * FROM notificacao ORDER BY data DESC LIMIT 5");
                                        $result_notificacao->execute();
                                        $row_notificacao = $result_notificacao->fetch();
                                        if ($result_notificacao->rowCount()==0) {
                                            echo '<li>Não existe atividade recente.</li>';
                                        } else {
                                            for ($i=1; $i<=$result_notificacao->rowCount(); $i++) {
                                                if ($row_notificacao['tipo']==1) {
                                                    $destino = "cliente.php?id=".$row_notificacao['cliente'];
                                                } else if ($row_notificacao['tipo']==2) {
                                                    $destino = "cliente.php?id=".$row_notificacao['cliente'];
                                                } else if ($row_notificacao['tipo']==3) {
                                                    $destino = "encomenda.php?id=".$row_notificacao['destino'];
                                                } else if ($row_notificacao['tipo']==4) {
                                                    $destino = "encomenda.php?id=".$row_notificacao['destino'];
                                                } else if ($row_notificacao['tipo']==5) {
                                                    $destino = "mensagem.php?id=".$row_notificacao['destino'];
                                                } else if ($row_notificacao['tipo']==6) {
                                                    $destino = "newsletter.php";
                                                }
                                                $data_notificacao = date_create($row_notificacao['data']);
                                                echo '<li class="event-list">
                                                        <a href="'.$destino.'">
                                                            <div class="event-timeline-dot">
                                                                <i class="material-icons md-play_circle_outline font-xxl"></i>
                                                            </div>
                                                            <div class="media">
                                                                <div class="me-3">
                                                                    <h6><span>'.date_format($data_notificacao, 'd/m/Y H:i').'</span> <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i></h6>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div>'.$row_notificacao['texto'].'</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                      </li>';
                                                $row_notificacao = $result_notificacao->fetch();
                                            }
                                        }
                                    ?>
                            </ul>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <?php
                include("includes/footer.php");
            ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js"
        integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.3/perfect-scrollbar.min.js"
        integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
    <script src="assets/js/vendors/chart.min.js"></script>
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script>
    (function($) {
        'use strict';
        if ($('#myChart').length) {
            var ctx = document.getElementById('myChart').getContext('2d');
            $.ajax({
                type: 'POST',
                url: 'php/processa-grafico-vendas.php',
                data: {},
                success: function(data) {
                    var array = $.parseJSON(data);
                    var vendas = array[0];
                    var visitas = array[1];
                    var produtos = array[2];
                    var chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago',
                                'Set', 'Out', 'Nov', 'Dez'
                            ],
                            datasets: [{
                                    label: 'Vendas',
                                    tension: 0.3,
                                    fill: true,
                                    backgroundColor: 'rgba(44, 120, 220, 0.2)',
                                    borderColor: 'rgba(44, 120, 220)',
                                    data: vendas
                                },
                                {
                                    label: 'Visitas',
                                    tension: 0.3,
                                    fill: true,
                                    backgroundColor: 'rgba(4, 209, 130, 0.2)',
                                    borderColor: 'rgb(4, 209, 130)',
                                    data: visitas
                                },
                                {
                                    label: 'Produtos',
                                    tension: 0.3,
                                    fill: true,
                                    backgroundColor: 'rgba(380, 200, 230, 0.2)',
                                    borderColor: 'rgb(380, 200, 230)',
                                    data: produtos
                                }
                            ]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    labels: {
                                        usePointStyle: true,
                                    },
                                }
                            }
                        }
                    });
                },
            });
        }
    })(jQuery);
    </script>
</body>

</html>