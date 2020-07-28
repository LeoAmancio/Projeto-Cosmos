<?php
    require "../Dao/daoUser.php";
    $dao = new daoUser();

    require "../Model/User.php";
    $u = new User();
    $u->setEmail($_GET['email']);
    $u->setSenha($_GET['password']);
    $dao->RecuperaSenha($u);