<?php
    session_start();
    include("php/config.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    }
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $categoria = $_GET['id'];
        $result = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
        $result->execute(array('categoria' => $categoria));
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

        <form id="form-editar-categoria">
            <section class="content-main">
                <div class="row">
                    <div class="col-12">
                        <div class="content-header">
                            <h2 class="content-title">Editar Categoria - <?= $row['nome'];?></h2>
                            <div>
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Informação Básica</h4>
                            </div>
                            <div class="card-body">
                                <div id="message-editar"></div>
                                <input type="hidden" name="categoria" id="categoria" value="<?= $categoria;?>">
                                <div class="tabs">
                                    <!-- <ul class="nav nav-tabs mb-4">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#portugues" data-toggle="tab"
                                                id="toggle-portugues">Português *</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#ingles" data-toggle="tab"
                                                id="toggle-ingles">Inglês</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#espanhol" data-toggle="tab"
                                                id="toggle-espanhol">Espanhol</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#frances" data-toggle="tab"
                                                id="toggle-frances">Francês</a>
                                        </li>
                                    </ul> -->

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="portugues">
                                            <div class="mb-4">
                                                <label class="form-label">Nome *</label>
                                                <input type="text" placeholder="Insira o nome da categoria"
                                                    class="form-control" name="nome" value="<?= $row['nome'];?>">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Descrição</label>
                                                <textarea placeholder="Insira a descrição da categoria"
                                                    class="form-control"
                                                    name="descricao"><?= str_replace('<br />', "", $row['descricao']);?></textarea>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <label for="slug" class="form-label">Slug *</label>
                                            <div class="row gx-2">
                                                <input placeholder="Insira o slug da categoria" type="text"
                                                    class="form-control" name="slug" id="slug"
                                                    value="<?= $row['slug'];?>" onchange="verificarSlug()">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <label class="form-label">Categoria Pai</label>
                                            <select class="form-control form-select" name="categoria_pai">
                                                <option value="0">Selecione uma categoria</option>
                                                <?php
                                                        $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE categoria_pai IS NULL AND id_categoria != :categoria ORDER BY nome ASC");
                                                        $result_categoria->execute(array('categoria' => $categoria));
                                                        $row_categoria = $result_categoria->fetch();
                                                        if ($result_categoria->rowCount()>0) {
                                                            for ($i=1; $i<=$result_categoria->rowCount(); $i++) {
                                                                if ($row['categoria_pai']==$row_categoria['id_categoria']) {
                                                                    $selected = " selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                                echo '<option value="'.$row_categoria['id_categoria'].'"'.$selected.'>'.$row_categoria['nome'].'</option>';
                                                                $row_categoria = $result_categoria->fetch();
                                                            }
                                                        }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <label class="form-label">Estado *</label>
                                            <select class="form-control form-select" name="estado">
                                                <?php
                                                        $ativo = "";
                                                        $inativo = "";
                                                        if ($row['estado']==1) {
                                                            $ativo = " selected";
                                                        }
                                                        if ($row['estado']==0) {
                                                            $inativo = " selected";
                                                        }
                                                    ?>
                                                <option value="1" <?= $ativo;?>>Ativo</option>
                                                <option value="0" <?= $inativo;?>>Inativo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-4">
                                            <label class="form-label">Tem Produtos? *</label>
                                            <select class="form-control form-select" name="tem_produtos">
                                                <?php
                                                        $nao = "";
                                                        $sim = "";
                                                        if ($row['tem_produtos']==0) {
                                                            $nao = " selected";
                                                        }
                                                        if ($row['tem_produtos']==1) {
                                                            $sim = " selected";
                                                        }
                                                    ?>
                                                <option value="0" <?= $nao;?>>Não</option>
                                                <option value="1" <?= $sim;?>>Sim</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label>Imagem de Capa</label>
                                            <div class="fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview" data-trigger="fileinput"
                                                    style="width: 200px; height: 137px;">
                                                    <img class="img-fluid"
                                                        src="../assets/img/categorias/<?= $categoria;?>.jpg"
                                                        alt="Imagem">
                                                </div>
                                                <span class="btn btn-primary btn-file">
                                                    <span class="fileinput-new">Selecionar</span>
                                                    <span class="fileinput-exists">Alterar</span>
                                                    <input type="file" id="capa" name="capa" accept=".jpg, .jpeg"
                                                        onchange="readURL(this)">
                                                </span>
                                                <a href="#" class="btn btn-danger fileinput-exists"
                                                    data-dismiss="fileinput">Eliminar</a>
                                            </div>
                                            <small class="text-muted">A imagem deve estar em formato jpg. Esta deve ter
                                                a dimensão de 1200x800 pixeis.</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <button class="btn btn-primary" type="submit">Guardar</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js"
        integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.3/perfect-scrollbar.min.js"
        integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.gridly@1.3.0/javascripts/jquery.gridly.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script>
    $(document).ajaxStart(function() {
        $('.screen-overlay').show();
    });
    $(document).ajaxStop(function() {
        $('.screen-overlay').hide();
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.fileinput-preview').html('<img class="img-fluid" src="' + e.target.result + '" alt="Imagem">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('.nav-tabs a').click(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $(this).tab('show');
    });

    function verificarSlug() {
        var categoria = $('#categoria').val();
        var slug = $('#slug').val();
        $.ajax({
            type: 'POST',
            url: 'php/verificar/verificar-slug-categoria.php',
            data: {
                'categoria': categoria,
                'slug': slug,
                'editar': '1'
            },
            cache: false,
            success: function(response) {
                if (response > 0) {
                    Swal.fire(
                        'Erro',
                        'Já existe uma categoria com o slug introduzido.',
                        'error'
                    ).then((result) => {
                        $('#slug').val('');
                    })
                }
            }
        });
    }

    $(document).ready(function() {
        var optionsEditar = {
            target: '#message-editar',
            success: showResponseEditar,
            url: 'php/editar/processa-editar-categoria.php',
            type: 'post',
            clearForm: 0,
            resetForm: 0
        };
        $('#form-editar-categoria').ajaxForm(optionsEditar);

        function showResponseEditar(msg) {
            if (msg == '') {
                window.location.href = 'categorias.php?e=1';
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