<header class="main-header navbar">
    <div class="col-search">
        <form class="searchform" action="pesquisa.php" method="get">
            <div class="input-group">
                <input type="text" name="termo" class="form-control" placeholder="Pesquisa..." required>
                <button class="btn btn-light bg" type="submit" id="btn-search"><i
                        class="material-icons md-search"></i></button>
            </div>
        </form>
    </div>

    <div class="col-nav">
        <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i
                class="material-icons md-apps"></i></button>
        <ul class="nav">


            <li class="dropdown nav-item">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount"
                    aria-expanded="false">
                    <img class="img-xs rounded-circle" src="assets/img/Logo_MEPS_sticker_icon.png" alt="<?= $row_loja['nome'];?>">
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                    <a class="dropdown-item text-danger" href="php/processa-logout.php"><i
                            class="material-icons md-exit_to_app"></i>Sair</a>
                </div>
            </li>
        </ul>
    </div>
</header>