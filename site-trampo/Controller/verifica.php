<?php
    session_start();
    $usuario = $_SESSION['email'];
    $senha = $_SESSION['senha'];

    if(!isset($_SESSION['email']) || !isset($_SESSION['senha'])){
        header("Location: ../../../View/TelaLogin/");
    }
?>
