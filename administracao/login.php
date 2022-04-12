<?php
    session_start();
    include("php/config.php");

    if (isset($_SESSION['admin'])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-pt">
    <head>
        <meta charset="utf-8" />
        <title><?= $row_loja['nome'];?> | Painel de Administração</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/Logo_MEPS_sticker_icon.png">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>

    <body>
        <main>
            <header class="main-header style-2 navbar">
                <div class="col-brand" style="margin: 0 auto;">
                    <img src="assets/img/Logo_MEPS.png" class="logo" alt="<?= $row_loja['nome'];?>">
                </div>
            </header>

            <section class="content-main mt-80 mb-80">
                <div class="card mx-auto card-login">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Iniciar sessão</h4>
                        <form action="php/processa-login.php" method="post" id="form-login">
                            <div id="message"></div>
                            <div class="mb-3">
                                <input class="form-control" placeholder="Username" type="text" name="username" id="username">
                            </div>
                            <div class="mb-3">
                                <input class="form-control" placeholder="Password" type="password" name="password" id="password">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary w-100">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

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
            var erro = getUrlParameter('er');
            $(window).on('load', function() {
                if (erro==1) {
                    $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert"> <strong>Erro!</strong> O username ou a password não podem estar vazios.</div>');
                }
                if (erro==2) {
                    $('#message').html('<div class="alert alert-danger alert-dismissible" role="alert"> <strong>Erro!</strong> O username e a password que inseriu não correspondem. Por favor verifique os seus dados e tente novamente.</div>');
                }
            });

            $(document).ready(function() {
                $('#form-login').validate({
                    rules: {
                        username: 'required',
                        password: 'required',
                        username: {
                            required: true,
                            minlength: 2
                        },
                        password: {
                            required: true,
                            minlength: 5
                        }
                    },
                    messages: {
                        username: 'Por favor introduza o username',
                        password: 'Por favor introduza a password'
                    },
                    errorElement: 'em',
                    errorPlacement: function(error, element) {
                        error.addClass('help-block');
                        if (element.prop('type')==='checkbox') {
                            error.insertAfter(element.parent('label'));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).parents('.form-group').addClass('has-error').removeClass('has-success');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).parents('.form-group').addClass('has-success').removeClass('has-error');
                    }
                });
            });
        </script>
    </body>
</html>