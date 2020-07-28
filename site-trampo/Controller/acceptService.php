<?php 
    require '../Dao/conexao.php';

    mysqli_query($conn, "UPDATE service SET id_request_accepted = '".$_GET['id_service_request']."', service.status = 1 WHERE service.id = '".$_GET['id_service']."'");
    setcookie("accept_request", true, time()+3600, '/');
    header("Location: ../../View/Main/serviceProfile/?occupation_subcategory=".$_GET['occupation_subcategory']."&id_service=".$_GET['id_service']);
?>