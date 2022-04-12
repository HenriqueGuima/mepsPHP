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
                    <li class="menu-item active">
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

            <form id="form-inserir-voucher">
                <section class="content-main">
                    <div class="row">
                        <div class="col-12">
                            <div class="content-header">
                                <h2 class="content-title">Adicionar Novo Voucher</h2>
                                <div>
                                    <button class="btn btn-md rounded font-sm hover-up" type="submit">Guardar</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4>Informação Básica</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="message-inserir"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-4">
                                                <label for="codigo" class="form-label">Código *</label>
                                                <div class="row gx-2" style="position: relative;">
                                                    <input placeholder="Insira o código" type="text" class="form-control" name="codigo" id="codigo" onblur="verificarCodigo()">
                                                    <label style="position: absolute; left: calc(100% - 30px); top: 13px; width: 30px;" onclick="gerarCodigo()"><i class="fas fa-key-"></i></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-4">
                                                <label for="tipo" class="form-label">Tipo de Desconto</label>
                                                <div class="row gx-2">
                                                    <select name="tipo_desconto" id="tipo" class="form-control form-select">
                                                        <option value="1">Valor (€)</option>
                                                        <option value="2">Percentagem (%)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-4">
                                                <label for="valor" class="form-label">Desconto (€ ou %) *</label>
                                                <div class="row gx-2">
                                                    <input type="number" name="desconto" id="valor" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-4">
                                                <label for="valor-minimo" class="form-label">Valor Mínimo de Compra</label>
                                                <div class="row gx-2">
                                                    <input type="number" name="valor_minimo" id="valor-minimo" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-4">
                                                <label for="limite-utilizacoes" class="form-label">Número Limite de Utilizações</label>
                                                <div class="row gx-2">
                                                    <input type="number" name="limite_utilizacoes" id="limite-utilizacoes" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-4">
                                                <label for="data-expiracao" class="form-label">Data de Expiração</label>
                                                <div class="row gx-2">
                                                    <input type="date" name="data_expiracao" id="data-expiracao" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-4">
                                                <label for="estado" class="form-label">Estado</label>
                                                <div class="row gx-2">
                                                    <select name="estado" id="estado" class="form-control form-select">
                                                        <option value="1">Ativo</option>
                                                        <option value="0">Inativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-4">
                                                <label for="cliente" class="form-label">Destinado apenas a um Cliente</label>
                                                <div class="row gx-2">
                                                    <select name="cliente" id="cliente" class="form-control form-select">
                                                        <option>Selecione um Cliente</option>
                                                        <?php
                                                            $result_cliente = $pdo->prepare("SELECT * FROM cliente WHERE estado = 1 ORDER BY nome ASC");
                                                            $result_cliente->execute();
                                                            $row_cliente = $result_cliente->fetch();
                                                            if ($result_cliente->rowCount()>0) {
                                                                for ($i=1; $i<=$result_cliente->rowCount(); $i++) {
                                                                    echo '<option value="'.$row_cliente['id_cliente'].'">'.$row_cliente['nome'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>

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
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="assets/js/core.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="assets/js/main.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        <script>
            function verificarCodigo() {
                var codigo = $('#codigo').val();
                $.ajax({
                    type: 'POST',
                    url: 'php/verificar/verificar-voucher.php',
                    data: {'codigo': codigo},
                    cache: false,
                    success: function(response) {
                        if (response>0) {
                            Swal.fire(
                                'Código Inválido',
                                'Já possui um voucher com o código inserido.',
                                'error'
                            ).then((result) => {
                                $('#codigo').val('');
                            })
                        }
                    }
                });
            }

            function gerarCodigo() {
                var codigo = makeCodigo();
                $('#codigo').val(codigo);
            }

            function makeCodigo() {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i=0; i<10; i++) {
                  result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }

            $(document).ready(function() {
                var optionsInserir = {
                    target: '#message-inserir',
                    success: showResponseInserir,
                    url: 'php/inserir/processa-inserir-voucher.php',
                    type: 'post',
                    clearForm: 0,
                    resetForm: 0
                };
                $('#form-inserir-voucher').ajaxForm(optionsInserir);

                function showResponseInserir(msg) {
                    if (msg=='') {
                        window.location.href = 'vouchers.php?i=1';
                    } else {
                        $(this).html(msg);
                        $('html, body').animate({
                            scrollTop: 0
                        }, 600);
                    }
                }
            });
        </script>
    </body>
</html>