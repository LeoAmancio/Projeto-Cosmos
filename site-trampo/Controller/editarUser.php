<?php
require("../Dao/daoUser.php");
$daoUser = new daoUser();

require("../Model/User.php");
$user = new User();
require("verifica.php");

$user->setEmailAntigo($_SESSION['email']);

$user->setNome($_POST['name']);
$user->setEmail($_POST['email']);
$user->setCpf($_POST['cpf']);
$user->setSexo($_POST['gender']);
$user->setDataNasc($_POST['birth_date']);
$user->setCelular($_POST['phone_number']); 
$user->setCep($_POST['cep']);
$user->setEstado($_POST['state']);
$user->setRua($_POST['address']);
$user->setNumero($_POST['number']);
$user->setBairro($_POST['neighborhood']);
$user->setComplemento($_POST['adress_complement']);

$occupation = $_POST['select-occupation'];
$work_info = $_POST['work_info'];

$daoUser->editarUser($user, $occupation, $work_info);



?>