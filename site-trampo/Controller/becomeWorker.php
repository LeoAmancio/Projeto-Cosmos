<?php

    session_start();

    require '../Dao/daoUser.php';
    require '../Model/User.php';

    $dao_user = new daoUser();
    $user = new User();

    $error = false;

    if(isset($_POST['submit'])) {

        if(!isset($_POST['select_occupation'])) {
            echo "<p class='red-text'>Você deve declarar com o que trabalha!</p>";
            echo "<br>";
            $error = true;
        }

        if(empty($_POST['work_info'])) {
            echo "<p class='red-text'>É necessário descrever sobre seus serviços</p>";
            echo "<br>";
            $error = true;
        }

        if($_POST['work_agreement'] == "false") {
            echo "<p class='red-text'>Você deve aceitar os termos!</p>";
            $error = true;
        }

        if(!$error) {
            $dao_user->becomeWorker($_SESSION['email'], $_POST['select_occupation'], $_POST['work_info']);
        }
    }

?>

<script>
    var error = "<?php echo $error ?>";
    if(!error) {
        M.toast({html: 'Informações cadastradas!'});
        $("#submit-becomeWorker").addClass("disabled");
        setTimeout(function () {
            <?php setcookie("new_worker", true, time()+3600, '/'); ?>
            window.location.href = "../work/";
        }, 600);
    }
</script>