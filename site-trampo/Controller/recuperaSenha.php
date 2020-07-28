<?php
    $email = $_GET['email'];
    $senha = $_GET['password'];

    require("../Dao/daoUser.php");
    $dao = new daoUser();
    
    if($daoContratante->verificaContaContratante($email) == "contratante"){
        require("../Model/Contratante.php");
        $contratante = new Contratante();
        
        $daoContratante->alteraSenha($email, $senha);
    }else{
        header("Location: ../View/Error/DadosInvalidos/index.html");
    }