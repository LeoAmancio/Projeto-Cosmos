<?php
    session_start();
    session_unset();
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    session_destroy();
    header("Location: ../View/TelaLogin");
?>