<?php
    session_start();
    include("php/config.php");

    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
    }

    function get_words($sentence, $count=10) {
        preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
        return $matches[0];
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
                <li class="menu-item active">
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
                        <h2 class="content-title">Personalizar Home</h2>
                    </div>
                </div>

                <!-- <div class="col-md-9">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Slider</h4>
                        </div>
                        <div class="card-body">
                            <div class="row" id="imagens-slider">
                                <?php
                                        // $result_slider = $pdo->prepare("SELECT * FROM slider ORDER BY ordem ASC");
                                        // $result_slider->execute();
                                        // $row_slider = $result_slider->fetch();
                                        // if ($result_slider->rowCount()>0) {
                                        //     for ($i=1; $i<=$result_slider->rowCount(); $i++) {
                                        //         echo '<div id="imagem-slider-'.$row_slider['id_slider'].'" class="col-md-3 relative imagem-slider">
                                        //                 <a class="btn-delete-imagem delete" onclick="eliminarImagemSlider('.$row_slider['id_slider'].')" style="top: 5px; right: 20px;">
                                        //                     <i class="fas fa-times"></i>
                                        //                 </a>
                                        //                 <img src="../assets/img/slider/'.$row_slider['id_slider'].'.jpg" alt="Imagem">
                                        //               </div>';
                                        //         $row_slider = $result_slider->fetch();
                                        //     }
                                        // }
                                    ?>
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary btn-sm rounded mt-15" data-bs-toggle="modal"
                                    data-bs-target="#modal-carregar-imagem-slider">Adicionar Imagem</a>
                                <a href="#" class="btn btn-primary btn-sm rounded mt-15 ml-15"
                                    id="reordenar">Reordenar</a>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Imagem Mobile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="../assets/img/mobile.jpg" alt="Imagem">
                                </div>
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary btn-sm rounded mt-15" data-bs-toggle="modal"
                                    data-bs-target="#modal-carregar-imagem-mobile">Alterar Imagem</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>A Nossa História</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                        // $result_historia = $pdo->prepare("SELECT * FROM historia ORDER BY ordem ASC");
                                        // $result_historia->execute();
                                        // $row_historia = $result_historia->fetch();
                                        // if ($result_historia->rowCount()==0) {
                                        //     echo '<p>Ainda não possui datas na história.</p>';
                                        // } else {
                                        //     echo '<div class="table-responsive">
                                        //             <table class="table table-hover">
                                        //                 <tbody id="historias">';
                                        //     for ($i=1; $i<=$result_historia->rowCount(); $i++) {
                                        //         echo '      <tr id="data-'.$row_historia['id_historia'].'">
                                        //                         <td>'.$row_historia['ano'].'</td>
                                        //                         <td>'.get_words(html_entity_decode($row_historia['texto_pt']), 20).'...</td>
                                        //                         <td class="text-end">
                                        //                             <span class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15" onclick="editarData('.$row_historia['id_historia'].')"> <i class="material-icons md-edit"></i> Editar</span>
                                        //                             <span class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminarData('.$row_historia['id_historia'].')"> <i class="material-icons md-delete_forever"></i> Eliminar</span>
                                        //                         </td>
                                        //                     </tr>';
                                        //         $row_historia = $result_historia->fetch();
                                        //     }
                                        //     echo '      </tbody>
                                        //             </table>
                                        //           </div>';
                                        // }
                                    ?>
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary btn-sm rounded mt-15" data-bs-toggle="modal"
                                    data-bs-target="#modal-inserir-data">Inserir Data</a>
                                <div class="btn btn-primary btn-sm rounded mt-15 ml-15" id="reordenar-historia">
                                    Reordenar</div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Galeria</h4>
                        </div>
                        <div class="card-body">
                            <div class="row" id="imagens-galeria">
                                <?php
                                        $result_galeria = $pdo->prepare("SELECT * FROM galeria ORDER BY ordem ASC");
                                        $result_galeria->execute();
                                        $row_galeria = $result_galeria->fetch();
                                        if ($result_galeria->rowCount()>0) {
                                            for ($i=1; $i<=$result_galeria->rowCount(); $i++) {
                                                echo '<div id="imagem-galeria-'.$row_galeria['id_galeria'].'" class="col-md-3 relative imagem-galeria mb-20">
                                                        <a class="btn-delete-imagem delete" onclick="eliminarImagemGaleria('.$row_galeria['id_galeria'].')" style="top: 5px; right: 20px;">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                        <img src="../assets/img/galeria/'.$row_galeria['id_galeria'].'.jpg" alt="Imagem">
                                                      </div>';
                                                $row_galeria = $result_galeria->fetch();
                                            }
                                        }
                                    ?>
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary btn-sm rounded mt-15" data-bs-toggle="modal"
                                    data-bs-target="#modal-carregar-imagem-galeria">Adicionar Imagem</a>
                                <a href="#" class="btn btn-primary btn-sm rounded mt-15 ml-15"
                                    id="reordenar-galeria">Reordenar</a>
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

    <div class="modal custom-modal" id="modal-carregar-imagem-slider" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Carregar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-inserir-imagem-slider" method="post" action="php/upload/upload-slider.php"
                    enctype="multipart/form-data">
                    <div class="fs-upload-element fs-upload">
                        <div class="fs-upload-target">
                            Selecione a sua imagem em jpg.<br>
                            Dimensão: 1920 por 1080px. Tamanho Máximo: 5MB.
                        </div>
                        <span class="btn btn-primary btn-file mt-15">
                            <span class="fileinput-new">Selecionar</span>
                            <input type="file" name="imagem" accept=".jpg, .jpeg"
                                onchange="submitForm('#form-inserir-imagem-slider')">
                        </span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>

    <div class="modal custom-modal" id="modal-carregar-imagem-mobile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Carregar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-alterar-imagem-mobile" method="post" action="php/upload/upload-mobile.php"
                    enctype="multipart/form-data">
                    <div class="fs-upload-element fs-upload">
                        <div class="fs-upload-target">
                            Selecione a sua imagem em jpg.<br>
                            Dimensão: 480px por 736px. Tamanho Máximo: 5MB.
                        </div>
                        <span class="btn btn-primary btn-file mt-15">
                            <span class="fileinput-new">Selecionar</span>
                            <input type="file" name="imagem" accept=".jpg, .jpeg"
                                onchange="submitForm('#form-alterar-imagem-mobile')">
                        </span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>

    <div class="modal custom-modal" id="modal-inserir-data" tabindex="-1" aria-hidden="true">
        <form id="form-inserir-data" enctype="multipart/form-data">
            <div class="modal-dialog">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="mensagem-inserir-data"></div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Imagem *</label>
                                <div class="fs-upload-element fs-upload">
                                    <div class="fs-upload-target">
                                        Selecione a sua imagem em jpg.<br>
                                        Dimensão: 1200px por 800px. Tamanho Máximo: 5MB.
                                    </div>
                                    <div class="fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview" data-trigger="fileinput"
                                            style="width: 200px; height: 137px;"></div>
                                        <span class="btn btn-primary btn-file">
                                            <span class="fileinput-new">Selecionar</span>
                                            <input type="file" name="imagem" accept=".jpg, .jpeg"
                                                onchange="imagemInserirData(this)">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Ano *</label>
                                <input type="text" name="ano" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Texto em Português *</label>
                                <textarea name="texto_pt" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Texto em Inglês</label>
                                <textarea name="texto_en" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Texto em Espanhol</label>
                                <textarea name="texto_es" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Texto em Francês</label>
                                <textarea name="texto_fr" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Inserir</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal custom-modal" id="modal-editar-data" tabindex="-1" aria-hidden="true">
        <form id="form-editar-data" enctype="multipart/form-data"></form>
    </div>

    <div class="modal custom-modal" id="modal-carregar-imagem-galeria" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Carregar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="upload-galeria" data-upload-options='{"action": "php/upload/upload-galeria.php"}'></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js"
        integrity="sha512-mULnawDVcCnsk9a4aG1QLZZ6rcce/jSzEGqUkeOLy0b6q0+T6syHrxlsAGH7ZVoqC93Pd0lBqd6WguPWih7VHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.gridly@1.3.0/javascripts/jquery.gridly.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.3/perfect-scrollbar.min.js"
        integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/upload/upload-galeria.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
    $(document).ready(function() {
        var dropIndex;
        $('#imagens-slider').sortable({
            update: function(event, ui) {
                dropIndex = ui.item.index();
            }
        });
        $('#reordenar').click(function(e) {
            var idsArray = [];
            $('#imagens-slider .imagem-slider').each(function(index) {
                var id = $(this).attr('id');
                var split_id = id.split('-');
                idsArray.push(split_id[2]);
            });
            $.ajax({
                url: 'php/ordenar/ordenar-slider.php',
                type: 'post',
                data: {
                    'idsArray': idsArray
                },
                success: function(response) {
                    Swal.fire(
                        'Slider Reordenado',
                        'O slider foi reordenado com sucesso.',
                        'success'
                    ).then((result) => {
                        location.reload();
                    })
                }
            });
            e.preventDefault();
        });

        var dropIndexHistoria;
        $('#historias').sortable({
            update: function(event, ui) {
                dropIndexHistoria = ui.item.index();
            }
        });
        $('#reordenar-historia').click(function(e) {
            var idsArray = [];
            $('#historias tr').each(function(index) {
                var id = $(this).attr('id');
                var split_id = id.split('-');
                idsArray.push(split_id[1]);
            });
            $.ajax({
                url: 'php/ordenar/ordenar-historias.php',
                type: 'post',
                data: {
                    'idsArray': idsArray
                },
                success: function(response) {
                    Swal.fire(
                        'Datas Reordenadas',
                        'As datas foram reordenadas com sucesso.',
                        'success'
                    ).then((result) => {
                        location.reload();
                    })
                }
            });
            e.preventDefault();
        });

        var dropIndexGaleria;
        $('#imagens-galeria').sortable({
            update: function(event, ui) {
                dropIndexGaleria = ui.item.index();
            }
        });
        $('#reordenar-galeria').click(function(e) {
            var idsArray = [];
            $('#imagens-galeria .imagem-galeria').each(function(index) {
                var id = $(this).attr('id');
                var split_id = id.split('-');
                idsArray.push(split_id[2]);
            });
            $.ajax({
                url: 'php/ordenar/ordenar-galeria.php',
                type: 'post',
                data: {
                    'idsArray': idsArray
                },
                success: function(response) {
                    Swal.fire(
                        'Galeria Reordenada',
                        'A galeria foi reordenada com sucesso.',
                        'success'
                    ).then((result) => {
                        location.reload();
                    })
                }
            });
            e.preventDefault();
        });
    });

    function eliminarImagemSlider(imagem) {
        var imagem = imagem;
        if (imagem != '') {
            Swal.fire({
                title: 'Eliminar Imagem',
                text: 'Tem a certeza que pretende eliminar esta imagem?',
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
                        url: 'php/eliminar/eliminar-imagem-slider.php',
                        data: {
                            'imagem': imagem
                        },
                        cache: false,
                        success: function(response) {
                            if (response == '') {
                                Swal.fire(
                                    'Imagem Eliminada',
                                    'A imagem foi eliminada com sucesso.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
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

    function eliminarImagemGaleria(imagem) {
        var imagem = imagem;
        if (imagem != '') {
            Swal.fire({
                title: 'Eliminar Imagem',
                text: 'Tem a certeza que pretende eliminar esta imagem?',
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
                        url: 'php/eliminar/eliminar-imagem-galeria.php',
                        data: {
                            'imagem': imagem
                        },
                        cache: false,
                        success: function(response) {
                            if (response == '') {
                                Swal.fire(
                                    'Imagem Eliminada',
                                    'A imagem foi eliminada com sucesso.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
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

    function imagemInserirData(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#modal-inserir-data .fileinput-preview').html('<img class="img-fluid" src="' + e.target.result +
                    '" alt="Imagem">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function editarData(historia) {
        var historia = historia;
        $.ajax({
            type: 'POST',
            url: 'php/int/int-editar-historia.php',
            data: {
                'historia': historia
            },
            cache: false,
            success: function(response) {
                $('#form-editar-data').html(response);
                $('#modal-editar-data').modal('show');
            }
        });
    }

    function imagemEditarHistoria(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagem-editar-historia').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function eliminarData(historia) {
        var historia = historia;
        if (historia != '') {
            Swal.fire({
                title: 'Eliminar Data',
                text: 'Tem a certeza que pretende eliminar esta data?',
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
                        url: 'php/eliminar/eliminar-historia.php',
                        data: {
                            'historia': historia
                        },
                        cache: false,
                        success: function(response) {
                            if (response == '') {
                                Swal.fire(
                                    'Data Eliminada',
                                    'A data foi eliminada com sucesso.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
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

    function submitForm(form) {
        $(form).submit();
    }

    $(document).ready(function() {
        var optionsInserirData = {
            target: '#mensagem-inserir-data',
            success: showResponseInserirData,
            url: 'php/inserir/processa-inserir-historia.php',
            type: 'post',
            clearForm: 0,
            resetForm: 0
        };
        $('#form-inserir-data').ajaxForm(optionsInserirData);

        function showResponseInserirData(msg) {
            if (msg == '') {
                Swal.fire(
                    'Data Inserida',
                    'A data foi inserida com sucesso.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            } else {
                $(this).html(msg);
            }
        }

        var optionsEditarData = {
            target: '#mensagem-editar-data',
            success: showResponseEditarData,
            url: 'php/editar/processa-editar-historia.php',
            type: 'post',
            clearForm: 0,
            resetForm: 0
        };
        $('#form-editar-data').ajaxForm(optionsEditarData);

        function showResponseEditarData(msg) {
            if (msg == '') {
                Swal.fire(
                    'Data Editada',
                    'A data foi editada com sucesso.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
            } else {
                $(this).html(msg);
            }
        }
    });
    </script>
</body>

</html>