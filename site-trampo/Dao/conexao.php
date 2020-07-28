<?php

    header("content-type: text/html;charset=utf-8");

    $servidor = "127.0.0.1";
    $usuario = "root";
    $senha = "";
    $dbname = "trampo";
    
    //Criar a conexao
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }

    mysqli_query($conn,"SET NAMES 'utf8'");
    mysqli_query($conn,"SET character_set_connection=utf8");
    mysqli_query($conn,"SET character_set_client=utf8");
    mysqli_query($conn,"SET character_set_results=utf8");

?>