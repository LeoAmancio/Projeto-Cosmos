<?php 
    $registered_user = false;
    if(isset($_COOKIE['registered_user'])) {
        $registered_user = true;
        setcookie("registered_user", false, time()+3600, '/');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/material.min.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Entrar</title>
</head>

<body>
    <img src="img/icons/right-top-desktop-background.png" alt="background" class="top-desktop-background">
    <img src="img/icons/top-mobile-background.png" alt="background" class="top-mobile-background">
    <header>
        <a href="../Home">
            <img src="img/logo/trampo_logo_normal.png" alt="trampo logo" width="100" class="normal-logo">
            <img src="img/logo/trampo_logo_white.png" alt="trampo logo" width="100" class="white-logo">
        </a>
    </header>
    <main>

        <div class="wrapper">
            <h1>Entrar</h1>
            <form action="../../Controller/logar.php" method="POST" class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="email" id="email" name="email">
                        <label class="mdl-textfield__label" for="email">E-mail</label>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="password" id="senha" minlength="8" maxlength="20"
                            name="senha">
                        <label class="mdl-textfield__label" for="senha">Senha</label>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--6-col"></div>
                <div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet">
                    <a href="../Home"><button type="button"
                            class="mdl-button mdl-js-button mdl-button--primary mdl-js-ripple-effect">Voltar</button></a>
                    <button type="submit "
                        class="mdl-button mdl-js-button mdl-button--raised mdl-button--primary mdl-js-ripple-effect "
                        action="../../Controller/logar.php" method="POST">Entrar</button>
                </div>
            </form>
        </div>

    </main>

    <div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>

    <img src="img/icons/bottom-desktop-background.png " alt="background " class="desktop-bottom-background ">

    <script type="text/javascript" src="js/main.js "></script>
    <script type="text/javascript" src="js/material.min.js "></script>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var service_register = "<?php echo $registered_user; ?>";
            if (service_register) {
                (function() {
                    'use strict';
                    var snackbarContainer = document.querySelector('#demo-toast-example');
                    var showToastButton = document.querySelector('#demo-show-toast');
                    'use strict';
                    var data = {
                        message: 'Cadastro realizado! Por favor, faça login. '
                    };
                    snackbarContainer.MaterialSnackbar.showSnackbar(data);
                }());
            }
        }, 400);
    });
    </script>
</body>

</html>