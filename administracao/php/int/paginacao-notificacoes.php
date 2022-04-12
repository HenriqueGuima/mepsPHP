<?php
	include("../config.php");

	if (isset($_GET['pagina'])) {
        $pagina = $_GET['pagina'];
    } else {
        $pagina = 1;
    }
    $limite_pagina = ($_GET['mostrar'] <> "" && is_numeric($_GET['mostrar'])) ? intval($_GET['mostrar']) : 50;

    $result_total_registos = $pdo->prepare("SELECT * FROM notificacao");
    $result_total_registos->execute();
    $total_paginas = ceil($result_total_registos->rowCount() / $limite_pagina);
    $limite_inferior = ($pagina - 1) * $limite_pagina;

    echo '<nav>
    		<ul class="pagination justify-content-start">';
    for ($i=1; $i<=$total_paginas; $i++) {
	  	if ($i==$pagina) {
			echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
		} else {
			echo '<li class="page-item" onclick="mostrarRegistos('.$limite_pagina.', '.$i.');"><a class="page-link" href="#">'.$i.'</a></li>';
	  	}
	}
	echo '</ul>
		</nav>';
?>