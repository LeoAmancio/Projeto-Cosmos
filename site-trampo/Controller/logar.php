<?php
    require("../Dao/daoUser.php");
    $daoUser = new daoUser();
    
    $email = $_POST['email'];
    if($daoUser->verificaContaUser($_POST['email']) == "user"){
        require("../Model/User.php");
        $prestador = new User();
        
        $prestador->setEmail($_POST['email']);
        $prestador->setSenha($_POST['senha']);   
        $daoUser->logarUser($prestador);
    }else{
        header("Location: ../View/Error/DadosInvalidos");
    }
?>