<?php 
    require '../Dao/conexao.php';

    $query = mysqli_query($conn, "SELECT who_finished FROM service WHERE service.id = '".$_GET['id_service']."'");
    $row = mysqli_fetch_assoc($query);

    if($row['who_finished'] != null && $_GET['confirm_finish_service'] == true) {
        mysqli_query($conn, "UPDATE service SET service.who_finished = null, service.is_finished = 1, service.status = 2
        WHERE service.id = '".$_GET['id_service']."'");
        setcookie("finish_service", true, time()+3600, '/');

        //check if the user is the hirer of the service
        $query = mysqli_query($conn, "SELECT id FROM service 
        WHERE service.id = '".$_GET['id_service']."' AND service.id_user = '".$_GET['id_user']."'");
        if(mysqli_num_rows($query) > 0) {
            header("Location: ../../View/Main/workerRating/?id_user_from=".$_GET['id_user']."&id_user_to=".$row['who_finished']."&id_service=".$_GET['id_service']);
        } else {
            header("Location: ../../View/Main/hirerRating/?id_user_from=".$_GET['id_user']."&id_user_to=".$row['who_finished']."&id_service=".$_GET['id_service']);
        }

    } else {
        mysqli_query($conn, "UPDATE service SET service.who_finished = '".$_GET['id_user']."' 
        WHERE service.id = '".$_GET['id_service']."'");
        setcookie("who_finish_service", true, time()+3600, '/');
        header("Location: ../../View/Main/serviceProfile/?occupation_subcategory=".$_GET['occupation_subcategory']."&id_service=".$_GET['id_service']);
    }

?>