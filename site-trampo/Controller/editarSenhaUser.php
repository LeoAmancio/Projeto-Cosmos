<?php
require("../Dao/daoUser.php");
$daoPrestador = new daoPrestador();

require("../Model/User.php");
$prestador = new Prestador();
require("verifica.php");

$prestador->setSenhaAntiga($_POST['senha']);

$prestador->setEmail($_SESSION['email']);
$prestador->setSenha($_POST['senhaNova']);  

$daoPrestador->editarSenhaPrestador($prestador);



?>