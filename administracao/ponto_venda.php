<?php
    session_start();
    include("php/config.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    }
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $result = $pdo->prepare("SELECT * FROM ponto_venda WHERE id_ponto_venda = :ponto_venda");
        $result->execute(array('ponto_venda' => $_GET['id']));
        $row = $result->fetch();
        if ($result->rowCount()==0) {
            header("Location: pontos_venda.php");
        }
    } else {
        header("Location: pontos_venda.php");
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
                <li class="menu-item ">
                    <a class="menu-link" href="mensagens.php">
                        <i class="icon material-icons md-message"></i>
                        <span class="text">Mensagens</span>
                    </a>
                </li>
                <li class="menu-item active">
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
                        <h2 class="content-title">Ponto de Venda - <?= $row['nome'];?></h2>
                        <div>
                            <?php
                                    // if (!is_null($row['cliente'])) {
                                    //     echo '<a href="cliente.php?id='.$row['cliente'].'"><button class="btn btn-md rounded font-sm hover-up">Ver Cliente</button></a>';
                                    // }
                                ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Ponto de Venda</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label class="form-label">Nome</label>
                                        <input type="text" class="form-control" value="<?= $row['nome'];?>" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label class="form-label">Morada</label>
                                        <input type="text" class="form-control" value="<?= $row['morada'];?>" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control" value="<?= $row['email'];?>" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Cod-Postal</label>
                                        <input type="text" class="form-control" value="<?= $row['codigo_postal'];?>"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Localidade</label>
                                        <input type="text" class="form-control" value="<?= $row['localidade'];?>"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Telefone</label>
                                        <input type="text" class="form-control" value="<?= $row['telefone'];?>"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Estado</label>
                                        <input type="text" class="form-control" value="<?= $row['estado'];?>" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Latitude</label>
                                        <input type="text" class="form-control" value="<?= $row['latitude'];?>"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Longitude</label>
                                        <input type="text" class="form-control" value="<?= $row['longitude'];?>"
                                            disabled>
                                    </div>
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