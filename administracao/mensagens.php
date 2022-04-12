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
                <li class="menu-item active">
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
                    <h2 class="content-title card-title">Mensagens</h2>
                    <p>Todos as mensagens recebidas pela sua loja.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col">Nome</th>
                                    <th class="align-middle" scope="col">E-mail</th>
                                    <th class="align-middle" scope="col">Assunto</th>
                                    <th class="align-middle" scope="col">Data</th>
                                    <th class="align-middle text-end" scope="col">Ver</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                        $result_mensagem = $pdo->prepare("SELECT * FROM mensagem ORDER BY id_mensagem DESC");
                                        $result_mensagem->execute();
                                        $row_mensagem = $result_mensagem->fetch();
                                        if ($result_mensagem->rowCount()>0) {
                                            for ($i=1; $i<=$result_mensagem->rowCount(); $i++) {
                                                $data = date_create($row_mensagem['data']);
                                                echo '<tr>
                                                        <td>'.$row_mensagem['nome'].'</td>
                                                        <td>'.$row_mensagem['email'].'</td>
                                                        <td>'.$row_mensagem['assunto'].'</td>
                                                        <td>'.date_format($data, 'd/m/Y H:i').'</td>
                                                        <td class="text-end"><a href="mensagem.php?id='.$row_mensagem['id_mensagem'].'" class="btn btn-xs"> Detalhes</a></td>
                                                      </tr>';
                                                $row_mensagem = $result_mensagem->fetch();
                                            }
                                        }
                                    ?>
                            </tbody>
                        </table>
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
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.3/perfect-scrollbar.min.js"
        integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/main.min.js"></script>
</body>

</html>