<?php
    session_start();

    require '../Dao/DaoService.php';
    require '../Model/Service.php';
    require '../Dao/conexao.php';

    $dao_service = new DaoService();
    $service = new Service();

    $query = mysqli_query($conn, "SELECT id FROM user WHERE email = '".$_SESSION['email']."'");
    $row = mysqli_fetch_assoc($query);
    $id_user = $row['id'];

    if(($_GET['id_occupation_subcategory'] && $_POST['time-remaining'] && $_POST['service-title'] && $_POST['service-description'])!= null) {
        $service->setIdOccupationSubcategory($_GET['id_occupation_subcategory']);
        $service->setTimeRemaining($_POST['time-remaining']);
        $service->setTitle($_POST['service-title']);
        $service->setDescription($_POST['service-description']);

        //upload image to the databse
        if(is_uploaded_file($_FILES['service-picture']['tmp_name']) || file_exists($_FILES['service-picture']['tmp_name'])) {
            $upload_image = $_FILES["service-picture"]["name"];//image name
            $folder_move_file = "../View/Main/_img/service_picture/";
            $folder_database = "../_img/service_picture/";
            move_uploaded_file($_FILES["service-picture"]["tmp_name"],"$folder_move_file".$upload_image);
            $service->setPicture($folder_database.$upload_image);
        }

        if(isset($_POST['visible-agreement'])) {
            $service->setIsVisible("true");
        }else {
            $service->setIsVisible("false");
        }
        $service->setIdUser($id_user);
        //mark it as pending
        $service->setStatus(0);
        $dao_service->cadastrarService($service);
        $last_id = $dao_service->getLastRegisteredId();
        setcookie("form_submitted", true, time()+3600, '/');
        header("Location: ../../View/Main/workerList/?occupation_subcategory=".$_GET['id_occupation_subcategory']."&id_service=".$last_id['MAX(id)']);
    } else {
        header("Location: ../../View/Main/requestService/?occupation_subcategory=".$_GET['id_occupation_subcategory']);
    }

?>
