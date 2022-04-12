<?php
	include("../config.php");

	if (isset($_POST['filtro']) && !empty($_POST['filtro'])) {
        $estado = $_POST['estado'];

        if ($estado!="") {
        	if (isset($_GET['pagina'])) {
	            $pagina = $_GET['pagina'];
	        } else {
	            $pagina = 1;
	        }
	        $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

	        $result_total_registos = $pdo->prepare("SELECT * FROM voucher WHERE estado = :estado");
	        $result_total_registos->execute(array('estado' => $estado));
	        $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
	        $limite_inferior = ($pagina - 1) * $limite_pagina;

	        echo '<nav>
	        		<ul class="pagination justify-content-start">';
	        for ($i=1; $i<=$total_paginas; $i++) {
			  	if ($i==$pagina) {
					echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
				} else {
					echo '<li class="page-item" onclick="filtrarRegistos('.$limite_pagina.', '.$i.');"><a class="page-link" href="#">'.$i.'</a></li>';
			  	}
			}
			echo '</ul>
				</nav>';
		} else {
			if (isset($_GET['pagina'])) {
	            $pagina = $_GET['pagina'];
	        } else {
	            $pagina = 1;
	        }
	        $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

	        $result_total_registos = $pdo->prepare("SELECT * FROM voucher");
	        $result_total_registos->execute();
	        $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
	        $limite_inferior = ($pagina - 1) * $limite_pagina;

	        echo '<nav>
	        		<ul class="pagination justify-content-start">';
	        for ($i=1; $i<=$total_paginas; $i++) {
			  	if ($i==$pagina) {
					echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
				} else {
					echo '<li class="page-item" onclick="filtrarRegistos('.$limite_pagina.', '.$i.');"><a class="page-link" href="#">'.$i.'</a></li>';
			  	}
			}
			echo '</ul>
				</nav>';
		}
	} else {
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina = 1;
        }
        $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 10;

        $result_total_registos = $pdo->prepare("SELECT * FROM voucher");
        $result_total_registos->execute();
        $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
        $limite_inferior = ($pagina - 1) * $limite_pagina;

        echo '<nav>
        		<ul class="pagination justify-content-start">';
        for ($i=1; $i<=$total_paginas; $i++) {
		  	if ($i==$pagina) {
				echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
			} else {
				echo '<li class="page-item" onclick="filtrarRegistos('.$limite_pagina.', '.$i.');"><a class="page-link" href="#">'.$i.'</a></li>';
		  	}
		}
		echo '</ul>
			</nav>';
	}
?>