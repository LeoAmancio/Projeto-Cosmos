<?php

    require("../Dao/daoUser.php");
    $daoUser = new daoUser();

    require("../Model/User.php");
    $user = new User();

    $user->setNome($_POST['name']);
    $user->setEmail($_POST['email']);
    $user->setCpf($_POST['cpf']);
    $user->setSexo($_POST['gender']);
    $user->setDataNasc($_POST['birthday']);
    $user->setCep($_POST['cep']);
    $user->setCidade($_POST['city']);
    $user->setEstado($_POST['estados-brasil']);
    $user->setRua($_POST['street']);
    $user->setNumero($_POST['number']);
    $user->setBairro($_POST['neighborhood']);
    $user->setComplemento($_POST['complement']);
    $user->setCelular($_POST['phone-number']);
    $user->setSenha($_POST['password']);
    $user->setLatitude($_POST['lat']);
    $user->setLongitude($_POST['lon']); 

    $daoUser->cadastrarUser($user);

?>


