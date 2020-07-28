<?php
    $email = $_GET['email'];
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
    <title>Nova senha</title>
</head>

<body>
    <img src="img/icons/right-top-desktop-background.png" alt="background" class="top-desktop-background">
    <img src="img/icons/top-mobile-background.png" alt="background" class="top-mobile-background">
    <header>
        <a href="../../../View/Home/index.html">
            <h2>Trampo</h2>
        </a>
    </header>
    <main>

        <div class="wrapper">
            <h1>Nova senha</h1>
            <form action="../../../Controller/novaSenha.php" method="GET" class="mdl-grid">
                <input type="hidden" value=<?=$email?> name="email">
                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="password" id="password" minlength="8" name="password">
                        <label class="mdl-textfield__label" for="password">Senha</label>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="password_confirm_wrapper">
                        <input class="mdl-textfield__input" type="password" id="password_confirm" minlength="8" name="password_confirm">
                        <label class="mdl-textfield__label" for="password_confirm">Confirmar senha</label>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--6-col"></div>
                <div class="mdl-cell mdl-cell--6-col mdl-cell--12-col-tablet">
                    <a href="../../../View/Home/index.html"><button type="button" class="mdl-button mdl-js-button mdl-button--primary mdl-js-ripple-effect">Cancelar</button></a>
                    <button type="submit " class="mdl-button mdl-js-button mdl-button--raised mdl-button--primary mdl-js-ripple-effect " action="../../../Controller/novaSenha.php" method="GET">Salvar</button>
                </div>
            </form>
        </div>

    </main>
    <img src="img/icons/bottom-desktop-background.png " alt="background " class="desktop-bottom-background ">
    <script src="js/main.js "></script>
    <script src="js/material.min.js ">
    </script>
</body>

</html>