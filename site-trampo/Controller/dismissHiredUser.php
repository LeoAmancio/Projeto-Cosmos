<?php 
    require '../Dao/conexao.php';
    
    //delete accepted request from table service
    mysqli_query($conn, "UPDATE service SET id_request_accepted = null WHERE service.id = '".$_GET['id_service']."'");

    //delete users request
    mysqli_query($conn, "DELETE FROM service_request WHERE id = '".$_GET['id_service_request']."'");

    setcookie("dismiss_hired_user", true, time()+3600, '/');
    header("Location: ../../View/Main/serviceProfile/?occupation_subcategory=".$_GET['occupation_subcategory']."&id_service=".$_GET['id_service']);
?>