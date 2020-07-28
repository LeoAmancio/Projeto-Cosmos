<?php
    session_start();
    require_once '../Dao/conexao.php';
    echo exec('whoami');
    $upload_image = $_FILES["image"]["name"];//image name
    $folder_move_file = "../View/Main/_img/user_profile_picture/";
    $folder_database = "../_img/user_profile_picture/";
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if($uploadOk == 1) {
            move_uploaded_file($_FILES["image"]["tmp_name"],"$folder_move_file".$upload_image);
            $query = mysqli_query($conn, "UPDATE user SET profile_picture = '".$folder_database.$upload_image."' WHERE email = '".$_SESSION['email']."'");
        }
    }

    header("Location: ../View/Main/myAccount/?profile_picture");

?>



