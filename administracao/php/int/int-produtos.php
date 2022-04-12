<?php
	include("../config.php");

	if (isset($_POST['filtro']) && !empty($_POST['filtro'])) {
        $categoria = $_POST['categoria'];
        $estado = $_POST['estado'];

        if ($categoria>0 && $estado!="") {
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina = 1;
            }
            $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

            $result_total_registos = $pdo->prepare("SELECT * FROM produto WHERE categoria = :categoria AND estado = :estado");
            $result_total_registos->execute(array('categoria' => $categoria, 'estado' => $estado));
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontrados registos.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM produto WHERE categoria = :categoria AND estado = :estado ORDER BY nome ASC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('categoria' => $categoria, 'estado' => $estado, 'limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    if (strpos($row['nome'], "<br />") !== false) {
                        $array_titulo = explode("<br />", $row['nome']);
                        $titulo = $array_titulo[0]." ".$array_titulo[1];
                    } else {
                        $titulo = $row['nome'];
                    }
                    if ($row['estado']==1) {
                        $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                    } else if ($row['estado']==2) {
                        $estado = '<span class="badge rounded-pill alert-warning">Rascunho</span>';
                    } else {
                        $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                    }
                    if (file_exists('../../../produtos/'.$row['id_produto'].'/1.jpg')) {
                        $url = '../produtos/'.$row['id_produto'].'/1.jpg';
                    } else if (file_exists('../../../produtos/'.$row['id_produto'].'/1.JPG')) {
                        $url = '../produtos/'.$row['id_produto'].'/1.JPG';
                    } else {
                        $url = 'assets/img/sem-imagem.jpg';
                    }
                    if (!is_null($row['categoria']) && $row['categoria']!="" && $row['categoria']!=0) {
                        $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
                        $result_categoria->execute(array('categoria' => $row['categoria']));
                        $row_categoria = $result_categoria->fetch();
                        $categoria = $row_categoria['nome'];
                    } else {
                        $categoria = "";
                    }
                    echo '<article class="itemlist">
                            <div class="row align-items-center" id="int-produtos">
                                <div class="col-lg-4 col-sm-4 col-4 flex-grow-1 col-name">
                                    <div class="itemside">
                                        <div class="left">
                                            <img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'">
                                        </div>
                                        <div class="info">
                                            <h6 class="mb-0">'.$titulo.'</h6>
                                        </div>
                                    </div>
                                </div><div class="col-lg-1 col-sm-1 col-2 col-price"><span>'.$categoria.'</span></div>
                                <div class="col-lg-1 col-sm-1 col-3 col-status">'.$estado.'</div>
                                <div class="col-lg-4 col-sm-4 col-4 col-action text-end">
                                    <a href="editar-produto.php?id='.$row['id_produto'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar </a>
                                    <a href="#" class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminar('.$row['id_produto'].')"> <i class="material-icons md-delete_forever"></i> Eliminar </a>
                                </div>
                            </div>
                          </article>';
                    $row = $result->fetch();
                }
            }
        } else if ($categoria>0 && $estado=="") {
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina = 1;
            }
            $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

            $result_total_registos = $pdo->prepare("SELECT * FROM produto WHERE categoria = :categoria");
            $result_total_registos->execute(array('categoria' => $categoria));
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontrados registos.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM produto WHERE categoria = :categoria ORDER BY nome ASC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('categoria' => $categoria, 'limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    if (strpos($row['nome'], "<br />") !== false) {
                        $array_titulo = explode("<br />", $row['nome']);
                        $titulo = $array_titulo[0]." ".$array_titulo[1];
                    } else {
                        $titulo = $row['nome'];
                    }
                    if ($row['estado']==1) {
                        $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                    } else if ($row['estado']==2) {
                        $estado = '<span class="badge rounded-pill alert-warning">Rascunho</span>';
                    } else {
                        $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                    }
                    if (file_exists('../../../produtos/'.$row['id_produto'].'/1.jpg')) {
                        $url = '../produtos/'.$row['id_produto'].'/1.jpg';
                    } else if (file_exists('../../../produtos/'.$row['id_produto'].'/1.JPG')) {
                        $url = '../produtos/'.$row['id_produto'].'/1.JPG';
                    } else {
                        $url = 'assets/img/sem-imagem.jpg';
                    }
                    if (!is_null($row['categoria']) && $row['categoria']!="" && $row['categoria']!=0) {
                        $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
                        $result_categoria->execute(array('categoria' => $row['categoria']));
                        $row_categoria = $result_categoria->fetch();
                        $categoria = $row_categoria['nome'];
                    } else {
                        $categoria = "";
                    }
                    echo '<article class="itemlist">
                            <div class="row align-items-center" id="int-produtos">
                                <div class="col-lg-4 col-sm-4 col-4 flex-grow-1 col-name">
                                    <div class="itemside">
                                        <div class="left">
                                            <img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'">
                                        </div>
                                        <div class="info">
                                            <h6 class="mb-0">'.$titulo.'</h6>
                                        </div>
                                    </div>
                                </div><div class="col-lg-1 col-sm-1 col-2 col-price"><span>'.$categoria.'</span></div>
                                <div class="col-lg-1 col-sm-1 col-3 col-status">'.$estado.'</div>
                                <div class="col-lg-4 col-sm-4 col-4 col-action text-end">
                                    <a href="editar-produto.php?id='.$row['id_produto'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar </a>
                                    <a href="#" class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminar('.$row['id_produto'].')"> <i class="material-icons md-delete_forever"></i> Eliminar </a>
                                </div>
                            </div>
                          </article>';
                    $row = $result->fetch();
                }
            }
        } else if ($estado!="" && $categoria==0) {
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina = 1;
            }
            $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

            $result_total_registos = $pdo->prepare("SELECT * FROM produto WHERE estado = :estado");
            $result_total_registos->execute(array('estado' => $estado));
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontrados registos.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM produto WHERE estado = :estado ORDER BY nome ASC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('estado' => $estado, 'limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    if (strpos($row['nome'], "<br />") !== false) {
                        $array_titulo = explode("<br />", $row['nome']);
                        $titulo = $array_titulo[0]." ".$array_titulo[1];
                    } else {
                        $titulo = $row['nome'];
                    }
                    if ($row['estado']==1) {
                        $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                    } else if ($row['estado']==2) {
                        $estado = '<span class="badge rounded-pill alert-warning">Rascunho</span>';
                    } else {
                        $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                    }
                    if (file_exists('../../../produtos/'.$row['id_produto'].'/1.jpg')) {
                        $url = '../produtos/'.$row['id_produto'].'/1.jpg';
                    } else if (file_exists('../../../produtos/'.$row['id_produto'].'/1.JPG')) {
                        $url = '../produtos/'.$row['id_produto'].'/1.JPG';
                    } else {
                        $url = 'assets/img/sem-imagem.jpg';
                    }
                    if (!is_null($row['categoria']) && $row['categoria']!="" && $row['categoria']!=0) {
                        $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
                        $result_categoria->execute(array('categoria' => $row['categoria']));
                        $row_categoria = $result_categoria->fetch();
                        $categoria = $row_categoria['nome'];
                    } else {
                        $categoria = "";
                    }
                    echo '<article class="itemlist">
                            <div class="row align-items-center" id="int-produtos">
                                <div class="col-lg-4 col-sm-4 col-4 flex-grow-1 col-name">
                                    <div class="itemside">
                                        <div class="left">
                                            <img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'">
                                        </div>
                                        <div class="info">
                                            <h6 class="mb-0">'.$titulo.'</h6>
                                        </div>
                                    </div>
                                </div><div class="col-lg-1 col-sm-1 col-2 col-price"><span>'.$categoria.'</span></div>
                                <div class="col-lg-1 col-sm-1 col-3 col-status">'.$estado.'</div>
                                <div class="col-lg-4 col-sm-4 col-4 col-action text-end">
                                    <a href="editar-produto.php?id='.$row['id_produto'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar </a>
                                    <a href="#" class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminar('.$row['id_produto'].')"> <i class="material-icons md-delete_forever"></i> Eliminar </a>
                                </div>
                            </div>
                          </article>';
                    $row = $result->fetch();
                }
            }
        } else {
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina = 1;
            }
            $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

            $result_total_registos = $pdo->prepare("SELECT * FROM produto");
            $result_total_registos->execute();
            if ($result_total_registos->rowCount()==0) {
                echo 'Não foram encontrados registos.';
            } else {
                $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
                $limite_inferior = ($pagina - 1) * $limite_pagina;

                $result = $pdo->prepare("SELECT * FROM produto ORDER BY nome ASC LIMIT :limite_inferior, :limite_pagina");
                $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
                $row = $result->fetch();
                for ($i=1; $i<=$result->rowCount(); $i++) {
                    if (strpos($row['nome'], "<br />") !== false) {
                        $array_titulo = explode("<br />", $row['nome']);
                        $titulo = $array_titulo[0]." ".$array_titulo[1];
                    } else {
                        $titulo = $row['nome'];
                    }
                    if ($row['estado']==1) {
                        $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                    } else if ($row['estado']==2) {
                        $estado = '<span class="badge rounded-pill alert-warning">Rascunho</span>';
                    } else {
                        $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                    }
                    if (file_exists('../../../produtos/'.$row['id_produto'].'/1.jpg')) {
                        $url = '../produtos/'.$row['id_produto'].'/1.jpg';
                    } else if (file_exists('../../../produtos/'.$row['id_produto'].'/1.JPG')) {
                        $url = '../produtos/'.$row['id_produto'].'/1.JPG';
                    } else {
                        $url = 'assets/img/sem-imagem.jpg';
                    }
                    if (!is_null($row['categoria']) && $row['categoria']!="" && $row['categoria']!=0) {
                        $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
                        $result_categoria->execute(array('categoria' => $row['categoria']));
                        $row_categoria = $result_categoria->fetch();
                        $categoria = $row_categoria['nome'];
                    } else {
                        $categoria = "";
                    }
                    echo '<article class="itemlist">
                            <div class="row align-items-center" id="int-produtos">
                                <div class="col-lg-4 col-sm-4 col-4 flex-grow-1 col-name">
                                    <div class="itemside">
                                        <div class="left">
                                            <img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'">
                                        </div>
                                        <div class="info">
                                            <h6 class="mb-0">'.$titulo.'</h6>
                                        </div>
                                    </div>
                                </div><div class="col-lg-1 col-sm-1 col-2 col-price"><span>'.$categoria.'</span></div>
                                <div class="col-lg-1 col-sm-1 col-3 col-status">'.$estado.'</div>
                                <div class="col-lg-4 col-sm-4 col-4 col-action text-end">
                                    <a href="editar-produto.php?id='.$row['id_produto'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar </a>
                                    <a href="#" class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminar('.$row['id_produto'].')"> <i class="material-icons md-delete_forever"></i> Eliminar </a>
                                </div>
                            </div>
                          </article>';
                    $row = $result->fetch();
                }
            }
        }
	} else {
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina = 1;
        }
        $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

        $result_total_registos = $pdo->prepare("SELECT * FROM produto");
        $result_total_registos->execute();
        if ($result_total_registos->rowCount()==0) {
            echo 'Não foram encontrados registos.';
        } else {
            $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
            $limite_inferior = ($pagina - 1) * $limite_pagina;

            $result = $pdo->prepare("SELECT * FROM produto ORDER BY nome ASC LIMIT :limite_inferior, :limite_pagina");
            $result->execute(array('limite_inferior' => $limite_inferior, 'limite_pagina' => $limite_pagina));
            $row = $result->fetch();
            for ($i=1; $i<=$result->rowCount(); $i++) {
                if (strpos($row['nome'], "<br />") !== false) {
                    $array_titulo = explode("<br />", $row['nome']);
                    $titulo = $array_titulo[0]." ".$array_titulo[1];
                } else {
                    $titulo = $row['nome'];
                }
                if ($row['estado']==1) {
                    $estado = '<span class="badge rounded-pill alert-success">Ativo</span>';
                } else if ($row['estado']==2) {
                    $estado = '<span class="badge rounded-pill alert-warning">Rascunho</span>';
                } else {
                    $estado = '<span class="badge rounded-pill alert-danger">Inativo</span>';
                }
                if (file_exists('../../../produtos/'.$row['id_produto'].'/1.jpg')) {
                    $url = '../produtos/'.$row['id_produto'].'/1.jpg';
                } else if (file_exists('../../../produtos/'.$row['id_produto'].'/1.JPG')) {
                    $url = '../produtos/'.$row['id_produto'].'/1.JPG';
                } else {
                    $url = 'assets/img/sem-imagem.jpg';
                }
                if (!is_null($row['categoria']) && $row['categoria']!="" && $row['categoria']!=0) {
                    $result_categoria = $pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :categoria");
                    $result_categoria->execute(array('categoria' => $row['categoria']));
                    $row_categoria = $result_categoria->fetch();
                    $categoria = $row_categoria['nome'];
                } else {
                    $categoria = "";
                }
                echo '<article class="itemlist">
                        <div class="row align-items-center" id="int-produtos">
                            <div class="col-lg-4 col-sm-4 col-4 flex-grow-1 col-name">
                                <div class="itemside">
                                    <div class="left">
                                        <img src="'.$url.'" class="img-sm img-thumbnail" alt="'.$titulo.'">
                                    </div>
                                    <div class="info">
                                        <h6 class="mb-0">'.$titulo.'</h6>
                                    </div>
                                </div>
                            </div><div class="col-lg-1 col-sm-1 col-2 col-price"><span>'.$categoria.'</span></div>
                            <div class="col-lg-1 col-sm-1 col-3 col-status">'.$estado.'</div>
                            <div class="col-lg-4 col-sm-4 col-4 col-action text-end">
                                <a href="editar-produto.php?id='.$row['id_produto'].'" class="btn btn-sm font-sm rounded btn-brand line-height-inherit mr-15"> <i class="material-icons md-edit"></i> Editar </a>
                                <a href="#" class="btn btn-sm font-sm btn-light rounded line-height-inherit" onclick="eliminar('.$row['id_produto'].')"> <i class="material-icons md-delete_forever"></i> Eliminar </a>
                            </div>
                        </div>
                      </article>';
                $row = $result->fetch();
            }
        }
	}
?>