<?php
    session_start();
    include("php/config.php");
    include("php/eliminar/eliminar-produtos-temp.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    }
    $query = $pdo->prepare("INSERT INTO produto_temp (data) VALUES (:data)");
    $query->execute(array('data' => date('Y-m-d H:i:s')));
    $result_produto_temp = $pdo->prepare("SELECT * FROM produto_temp ORDER BY id_produto_temp DESC LIMIT 1");
    $result_produto_temp->execute();
    $row_produto_temp = $result_produto_temp->fetch();
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

        <form id="form-inserir-produto">
            <section class="content-main">
                <div class="row">
                    <div class="col-12">
                        <div class="content-header">
                            <h2 class="content-title">Adicionar Novo Produto</h2>
                            <div>
                                <button class="btn btn-md rounded font-sm hover-up" type="submit">Guardar</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Informação Básica</h4>
                            </div>
                            <div class="card-body">
                                <div id="message-inserir"></div>
                                <div class="tabs">


                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="portugues">
                                            <div class="mb-4">
                                                <label class="form-label">Nome *</label>
                                                <textarea placeholder="Insira o nome do produto" class="form-control"
                                                    rows="4" name="nome"></textarea>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Descrição</label>
                                                <textarea placeholder="Insira a descrição do produto"
                                                    class="form-control" rows="4" name="descricao"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label for="slug" class="form-label">Slug *</label>
                                            <div class="row gx-2">
                                                <input placeholder="Insira o slug do produto" type="text"
                                                    class="form-control" name="slug" id="slug"
                                                    onchange="verificarSlug()">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Organização</h4>
                            </div>
                            <div class="card-body">
                                <div class="row gx-2">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-select" name="estado">
                                            <option value="0">Inativo</option>
                                            <option value="1" selected>Ativo</option>
                                            <option value="2">Rascunho</option>
                                        </select>
                                    </div>

                                    <div hidden class="col-md-3 mb-3">
                                        <label class="form-label">Loja</label>
                                        <select class="form-select" name="loja">
                                            <option value="0">Não</option>
                                            <option value="1" selected>Sim</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Produtos</label>
                                        <select class="form-select" name="produtos">
                                            <option value="0">Não</option>
                                            <option value="1" selected>Sim</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Categoria</label>
                                        <select class="form-control form-select" name="categoria">
                                            <option value="0">Selecione uma categoria</option>
                                            <?php
                                                    $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE tem_produtos = 1 ORDER BY nome ASC");
                                                    $result_categoria->execute();
                                                    $row_categoria = $result_categoria->fetch();
                                                    if ($result_categoria->rowCount()>0) {
                                                        for ($i=1; $i<=$result_categoria->rowCount(); $i++) {
                                                            echo '<option value="'.$row_categoria['id_categoria'].'">'.$row_categoria['nome'].'</option>';
                                                            $row_categoria = $result_categoria->fetch();
                                                        }
                                                    }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Imagens</h4>
                            </div>
                            <div class="card-body">
                                <div class="espaco_imgs">
                                    <div id="grid" class="gridly"></div>
                                    <div class="clear"></div>
                                </div>
                                <input type="hidden" id="id-ap-img">
                                <div class="btn btn-md rounded font-sm hover-up"
                                    onclick="toggleModal('modal-carregar-imagem')">Inserir Imagem</div>
                                <div class="btn btn-md rounded font-sm hover-up ml-15" id="reordenar-imagens">Reordenar
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <input type="hidden" id="id-produto-temp" name="id_produto_temp"
                value="<?= $row_produto_temp['id_produto_temp'];?>">
        </form>

        <?php
                include("includes/footer.php");
            ?>
    </main>

    <div class="modal custom-modal" id="modal-carregar-imagem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Carregar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="hideModal()"></button>
            </div>
            <div class="modal-body">
                <div class="upload"
                    data-upload-options='{"action": "php/upload/upload-target.php?produto=<?= $row_produto_temp['id_produto_temp'];?>"}'>
                </div>
                <div class="filelists">
                    <h5>Completos</h5>
                    <ol class="filelist complete"></ol>
                    <h5 class="mt-15">Listados</h5>
                    <ol class="filelist queue"></ol>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    onclick="hideModal()">Fechar</button>
            </div>
        </div>
    </div>

    <div class="modal custom-modal" id="modal-eliminar-imagem" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="hideModal()"></button>
            </div>
            <div class="modal-body">
                <p>Está prestes a eliminar definitivamente esta imagem.<br>Tem a certeza de que o pretende fazer?</p>
                <input type="hidden" id="id-eliminar-imagem">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    onclick="hideModal()">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="elimarImagem()">Eliminar</button>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal" id="modal-associar-produto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Associar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="hideModal()"></button>
            </div>
            <div class="modal-body">
                <label for="selecionar-produto" class="form-label">Selecionar Produto</label>
                <select id="selecionar-produto" name="selecionar_produto" onchange="mudarProduto()">
                    <option value="0">Selecione o Produto</option>
                    <?php
                            $result_produto = $pdo->prepare("SELECT * FROM produto ORDER BY nome ASC");
                            $result_produto->execute();
                            $row_produto = $result_produto->fetch();
                            if ($result_produto->rowCount()>0) {
                                for ($i=1; $i<=$result_produto->rowCount(); $i++) {
                                    echo '<option value="'.$row_produto['id_produto'].'">'.$row_produto['nome'].'</option>';
                                    $row_produto = $result_produto->fetch();
                                }
                            }
                        ?>
                </select>
                <div id="dados-produtos">
                    <div id="conteudo">
                        Selecione um produto para adicionar.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    onclick="hideModal()">Fechar</button>
                <button type="button" class="btn btn-primary" id="btn-associar-produto"
                    onclick="associarProduto()">Associar Produto</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js"
        integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.3/perfect-scrollbar.min.js"
        integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.gridly@1.3.0/javascripts/jquery.gridly.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/upload/upload.js"></script>
    <script src="assets/js/upload/upload-script.js"></script>
    <script src="assets/js/inserir-produto.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
    $(document).ajaxStart(function() {
        $('.screen-overlay').show();
    });
    $(document).ajaxStop(function() {
        $('.screen-overlay').hide();
    });

    function verificarSlug() {
        var slug = $('#slug').val();
        $.ajax({
            type: 'POST',
            url: 'php/verificar/verificar-slug-produto.php',
            data: {
                'slug': slug
            },
            cache: false,
            success: function(response) {
                if (response > 0) {
                    Swal.fire(
                        'Erro',
                        'Já existe um produto com o slug introduzido.',
                        'error'
                    ).then((result) => {
                        $('#slug').val('');
                    })
                }
            }
        });
    }

    var dropIndex;
    $('#grid').sortable({
        update: function(event, ui) {
            dropIndex = ui.item.index();
        }
    });
    $('#reordenar-imagens').click(function(e) {
        var idsArray = [];
        var produto = $('#id-produto-temp').val();
        $('#grid .brick').each(function(index) {
            var id = $(this).attr('id');
            var split_id = id.split('-');
            idsArray.push(split_id[2]);
        });
        $.ajax({
            url: 'php/ordenar/ordenar-imagem-produto-temp.php',
            type: 'post',
            data: {
                'idsArray': idsArray,
                'produto': produto
            },
            success: function(response) {
                Swal.fire(
                    'Imagens Reordenadas',
                    'As imagens foram reordenadas com sucesso.',
                    'success'
                )
            }
        });
        e.preventDefault();
    });

    var dropIndex2;
    $('#grid2').sortable({
        update: function(event, ui) {
            dropIndex2 = ui.item.index();
        }
    });
    $('#reordenar-produtos').click(function(e) {
        var idsArray = [];
        var produto = $('#id-produto-temp').val();
        $('#grid2 .brick').each(function(index) {
            var id = $(this).attr('id');
            var split_id = id.split('-');
            idsArray.push(split_id[2]);
        });
        $.ajax({
            url: 'php/ordenar/ordenar-produtos-associados-temp.php',
            type: 'post',
            data: {
                'idsArray': idsArray,
                'produto': produto
            },
            success: function(response) {
                Swal.fire(
                    'Produtos Reordenados',
                    'Os produtos foram reordenados com sucesso.',
                    'success'
                )
            }
        });
        e.preventDefault();
    });

    $(document).ready(function() {
        var optionsInserir = {
            target: '#message-inserir',
            success: showResponseInserir,
            url: 'php/inserir/processa-inserir-produto.php',
            type: 'post',
            clearForm: 0,
            resetForm: 0
        };
        $('#form-inserir-produto').ajaxForm(optionsInserir);

        function showResponseInserir(msg) {
            if (msg == '') {
                window.location.href = 'produtos.php?i=1';
            } else {
                $(this).html(msg);
                $('html, body').animate({
                    scrollTop: 0
                }, 600);
            }
        }
    });

    $('.nav-tabs a').click(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $(this).tab('show');
    });
    </script>
</body>

</html>