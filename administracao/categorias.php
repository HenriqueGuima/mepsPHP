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
                    <h2 class="content-title card-title">Categorias</h2>
                    <p>Adicione, edite ou elimine uma categoria</p>
                </div>
                <div>
                    <a href="inserir-categoria.php" class="btn btn-primary btn-sm rounded mr-15">Inserir Categoria</a>
                    <span class="btn btn-primary btn-sm rounded" id="reordenar">Reordenar</span>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody id="categorias">
                                        <?php
                                                $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE categoria_pai IS NULL ORDER BY ordem ASC");
                                                $result_categoria->execute();
                                                $row_categoria = $result_categoria->fetch();
                                                if ($result_categoria->rowCount()>0) {
                                                    for ($i=1; $i<=$result_categoria->rowCount(); $i++) {
                                                        if ($row_categoria['estado']==1) {
                                                            $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                                                        } else {
                                                            $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                                                        }
                                                        if ($row_categoria['tem_produtos']==0) {
                                                            $ver = "";
                                                        } else {
                                                            $ver = '<a href="categoria.php?id='.$row_categoria['id_categoria'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="fas fa-eye"></i> Ver</a>';
                                                        }
                                                        echo '<tr id="categoria-'.$row_categoria['id_categoria'].'">
                                                                <td><img src="../assets/img/categorias/'.$row_categoria['id_categoria'].'.jpg" width="80" alt="Imagem"></td>
                                                                <td>'.$row_categoria['nome'].'</td>
                                                                <td>'.$estado.'</td>
                                                                <td class="text-end">
                                                                    '.$ver.'
                                                                    <a href="editar-categoria.php?id='.$row_categoria['id_categoria'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar</a>
                                                                    <span class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminar('.$row_categoria['id_categoria'].')"> <i class="material-icons md-delete_forever"></i> Eliminar</a>
                                                                </td>
                                                              </tr>';

                                                        $result_sub = $pdo->prepare("SELECT * FROM categoria WHERE categoria_pai = :categoria ORDER BY ordem ASC");
                                                        $result_sub->execute(array('categoria' => $row_categoria['id_categoria']));
                                                        $row_subcategoria = $result_sub->fetch();
                                                        if ($result_sub->rowCount()>0) {
                                                            for ($x=1; $x<=$result_sub->rowCount(); $x++) {
                                                                if ($row_subcategoria['estado']==1) {
                                                                    $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                                                                } else {
                                                                    $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                                                                }
                                                                if ($row_subcategoria['tem_produtos']==0) {
                                                                    $ver = "";
                                                                } else {
                                                                    $ver = '<a href="categoria.php?id='.$row_subcategoria['id_categoria'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="fas fa-eye"></i> Ver</a>';
                                                                }
                                                                echo '<tr id="categoria-'.$row_subcategoria['id_categoria'].'">
                                                                        <td class="pl-60"><img src="../assets/img/categorias/'.$row_subcategoria['id_categoria'].'.jpg" width="80" alt="categoria"></td>
                                                                        <td>'.$row_subcategoria['nome'].'</td>
                                                                        <td>'.$estado.'</td>
                                                                        <td class="text-end">
                                                                            '.$ver.'
                                                                            <a href="editar-categoria.php?id='.$row_subcategoria['id_categoria'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar</a>
                                                                            <span class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminar('.$row_subcategoria['id_categoria'].')"> <i class="material-icons md-delete_forever"></i> Eliminar</a>
                                                                        </td>
                                                                      </tr>';
                                                                $row_subcategoria = $result_sub->fetch();
                                                            }
                                                        }
                                                        $row_categoria = $result_categoria->fetch();
                                                    }
                                                }
                                            ?>
                                    </tbody>
                                </table>
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

    $(document).ready(function() {
        var dropIndex;
        $('#categorias').sortable({
            update: function(event, ui) {
                dropIndex = ui.item.index();
            }
        });
        $('#reordenar').click(function(e) {
            var idsArray = [];
            $('#categorias tr').each(function(index) {
                var id = $(this).attr('id');
                var split_id = id.split('-');
                idsArray.push(split_id[1]);
            });
            $.ajax({
                url: 'php/ordenar/ordenar-categorias.php',
                type: 'post',
                data: {
                    'idsArray': idsArray
                },
                success: function(response) {
                    Swal.fire(
                        'Categorias Reorganizadas',
                        'As categorias foram reorganizadas com sucesso.',
                        'success'
                    )
                }
            });
            e.preventDefault();
        });
    });

    function eliminar(categoria) {
        var categoria = categoria;
        if (categoria != '') {
            Swal.fire({
                title: 'Eliminar Categoria',
                text: 'Tem a certeza que pretende eliminar esta categoria? Todas as suas subcategorias serão eliminadas.',
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
                        url: 'php/eliminar/eliminar-categoria.php',
                        data: {
                            'categoria': categoria
                        },
                        cache: false,
                        success: function(response) {
                            if (response == '') {
                                Swal.fire(
                                    'Categoria Eliminada',
                                    'A Categoria foi eliminada com sucesso.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'categorias.php';
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

    var erro = getUrlParameter('er');
    var inserir = getUrlParameter('i');
    var editar = getUrlParameter('e');
    $(window).on('load', function() {
        if (inserir == 1) {
            Swal.fire(
                'Categoria Inserida',
                'A categoria foi introduzida com sucesso.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'categorias.php';
                }
            })
        }
        if (editar == 1) {
            Swal.fire(
                'Categoria Editada',
                'A categoria foi editada com sucesso.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'categorias.php';
                }
            })
        }
        if (editar == 2) {
            Swal.fire(
                'Categoria Eliminada',
                'A categoria foi eliminada com sucesso.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'categorias.php';
                }
            })
        }
        if (erro == 1) {
            Swal.fire(
                'Erro',
                'Houve um erro de leitura dos dados. Por favor tente novamente.',
                'error'
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'categorias.php';
                }
            })
        }
    });
    </script>
</body>

</html>