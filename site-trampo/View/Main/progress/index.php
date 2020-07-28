<?php
    require "../../../Controller/verifica.php";
    require '../../../Dao/conexao.php';

    $toast = null;
    $pending_evaluation = false;
    
    //wich page to go when go to the evaluation
    $page_evaluation = null;

    $is_hirer = null;

    if(isset($_COOKIE['successful_evaluation'])) {
        setcookie("successful_evaluation", false, time()+3600, '/');
        $toast = "Avaliação registrada com sucesso!";
    } else if(isset($_COOKIE['successful_deleted'])) {
        $toast = "O serviço foi excluído";
        setcookie("successful_deleted", false, time()+3600, '/');
    } else if(isset($_COOKIE['failed_deleted'])) {
        $toast = "Erro ao excluir o serviço";
        setcookie("failed_deleted", false, time()+3600, '/');
    }

    //check if there is hires by this user
    $query = mysqli_query($conn,
    "SELECT id id_service, title FROM service WHERE service.id_user IN 
    (SELECT id FROM user WHERE user.email LIKE '".$_SESSION['email']."') AND service.is_finished = 1");

    while ($row = mysqli_fetch_assoc($query)) {

        $query_evaluation = mysqli_query($conn, "SELECT * FROM evaluation WHERE evaluation.id_service IN 
        (SELECT service.id FROM service WHERE service.id = '".$row['id_service']."'
         AND service.is_finished = 1) AND evaluation.id_user_from IN 
         (SELECT user.id FROM user WHERE user.email LIKE '".$_SESSION['email']."') 
         AND evaluation.id_user_to NOT IN (SELECT user.id FROM user WHERE user.email LIKE '".$_SESSION['email']."')");
    
        if(!mysqli_num_rows($query_evaluation) > 0) {
            $pending_evaluation = true;
            $page_evaluation = "workerRating";
            $is_hirer = true;
            $service_id = $row['id_service'];
            $service_title = $row['title'];
        } 
    }



    //check if there is any service that he did 
    $query = mysqli_query($conn, 
    "SELECT id id_service, title FROM service WHERE service.id_request_accepted IN 
     (SELECT id FROM service_request WHERE service_request.id_user IN 
      (SELECT id FROM user WHERE user.email LIKE '".$_SESSION['email']."')) AND service.is_finished = 1");
    
    while($row = mysqli_fetch_assoc($query)) {
        

        $query_evaluation = mysqli_query($conn, 
        "SELECT id FROM evaluation WHERE evaluation.id_service IN 
         (SELECT id FROM service WHERE service.id = '".$row['id_service']."') AND evaluation.id_user_from IN
          (SELECT id FROM user WHERE user.email = '".$_SESSION['email']."') 
         AND evaluation.id_user_to NOT IN (SELECT id FROM user WHERE user.email = '".$_SESSION['email']."')");

        if(!mysqli_num_rows($query_evaluation) > 0) {
            $pending_evaluation = true;
            $page_evaluation = "hirerRating";
            $is_hirer = false;
            $service_id = $row['id_service'];
            $service_title = $row['title'];
        }
        
    }

    
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../_sass/materialize.css">
    <title>trampo</title>
</head>

<body>
    <?php 
        $consulta = "SELECT * FROM user WHERE email = '".$_SESSION['email']."'";
        $res = mysqli_query($conn,$consulta);
        $row = mysqli_fetch_assoc($res);
        $id_user = $row['id'];
    ?>

    <header>
        <nav class="nav-extended">
            <div class="nav-wrapper">
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <a href="#!" class="brand-logo center">Progresso</a>
            </div>
            <div class="nav-content">
                <ul class="tabs tabs-transparent tabs-fixed-width">
                    <li class="tab"><a href="#hires" id="tab2" class="waves-effect waves-light">Contratos</a></li>
                    <li class="tab"><a href="#services" id="tab1" class="waves-effect waves-light">Serviços</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- padding top due the fixed navbar -->
    <main style="padding-top: 8em;">
        <ul id="slide-out" class="sidenav sidenav-fixed">
            <img src="../_img/logo/trampo_logo_normal.png" alt="trampo logo" width="90" style="display:block; margin:auto">
            <li>
                <div class="user-view">
                    <a href="#user"><img class="circle z-depth-1" src="<?php echo $row['profile_picture']; ?>"
                            alt="user profile picture"></a>
                    <div class="user-info">
                        <a href="#name"><span class="black-text name"><?php echo $row['full_name'] ?></span></a>
                        <a href="#email"><span class="black-text email"><?php echo $row['email'] ?></span></a>
                    </div>
                </div>
            </li>
            <li class="active"><a href="" class="waves-effect"><i class="material-icons">cached</i>Em
                    progresso</a></li>
            <li><a href="../hire" class="waves-effect"><i class="material-icons">assignment_ind</i>Contratar</a></li>
            <li><a href="../work" class="waves-effect"><i class="material-icons">build</i>Trabalhar</a>
            </li>
            <li><a href="../chatList" class="waves-effect"><i class="material-icons">chat</i>Chat</a>
            </li>
            <li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a class="subheader">Configurações</a></li>
            <li><a href="../myAccount" class="waves-effect">Minha conta</a></li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a href="#modalLeave" class="waves-effect modal-trigger"><i
                        class="material-icons">power_settings_new</i>Sair</a></li>
        </ul>


        <!-- Section progress and yours tabs -->
        <section class="section-progress">

            <div id="hires">

                <?php
                    $query = mysqli_query($conn, "SELECT * FROM service WHERE 
                    service.id_user = '".$id_user."'");
                    if(mysqli_num_rows($query) > 0) {
                ?>

                <h5 class="center-align grey-text" style="margin-bottom:0 !important">Contratos que você disponibilizou
                </h5>
                <div class="wrapper-content">
                    <?php
                        while($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <div class="card hoverable col s12 m4 l3">
                        <a
                            href="../serviceProfile/?occupation_subcategory=<?php echo $row['id_occupation_subcategory']?>&id_service=<?php echo $row['id'] ?>&progress">
                            <div class="card-image">
                                <div class="title-over-image">
                                    <h5><?php echo $row['title'] ?> </h5>
                                </div>
                                <?php 
                                    if(!empty($row['picture'])) {
                                ?>
                                <img src="<?php echo $row['picture'] ?>" alt="card-image">
                                <?php
                                    }
                                ?>
                            </div>
                        </a>
                        <div class="card-content">
                            <!-- Check service status -->
                            <?php
                            // check if the service is pendente 
                                if($row['status'] == 0) {
                            ?>

                            <span class="card-title activator orange-text text-darken-4">
                                Pendente
                                <i class="material-icons md-18">schedule</i>
                                <i class="material-icons right grey-text text-darken-3">keyboard_arrow_up</i>
                            </span>

                            <?php
                            // check if the service is in progress
                                } else if ($row['status'] == 1){
                            ?>

                            <span class="card-title activator green-text text-darken-4"
                                style="font-size:1.3em !important">
                                Em progresso
                                <i class="material-icons md-18">autorenew</i>
                                <!-- change icon -->
                                <i class="material-icons right grey-text text-darken-3">keyboard_arrow_up</i>
                            </span>

                            <?php 
                            // check if the service is done
                                } else if ($row['status'] == 2){
                            ?>

                            <span class="card-title activator grey-text text-darken-4">
                                Encerrado
                                <i class="material-icons md-18">done</i>
                                <!-- change icon -->
                                <i class="material-icons right grey-text text-darken-3">keyboard_arrow_up</i>
                            </span>

                            <?php 
                                }
                            ?>

                        </div>
                        <div class="card-reveal">
                            <div class="card-title">
                                <i class="material-icons right">close</i>
                            </div>
                            <span class="card-title">
                                <strong> <?php echo $row['title'] ?> </strong>
                            </span>
                            <p>
                                <?php echo $row['description'] ?>
                            </p>
                            <p><a href="../serviceProfile/?occupation_subcategory=<?php echo $row['id_occupation_subcategory']?>&id_service=<?php echo $row['id'] ?>&progress"
                                    class="valign-wrapper">Ver mais <i
                                        class="material-icons">keyboard_arrow_right</i></a></p>
                        </div>
                    </div>

                    <?php
                        }
                    ?>

                </div>

                <?php
                    } else {
                ?>
                <div class="container center-align no-work">
                    <div class="row">
                        <div class="col s12">
                            <img src="../_img/icon/dislike.svg" alt="dislike icon" width="130">
                        </div>
                        <div class="col s12">
                            <h4>Ops!</h4>
                            <h6>Você não tem nenhum serviço <a href="../hire">contratado</a>. Clique na aba <a
                                    href="../hire">contratar</a><br> e comece a contratar
                                agora mesmo!</h6>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                ?>

            </div>


            <div id="services">


                <?php
                    $query = mysqli_query($conn, "SELECT * FROM service WHERE service.id IN (SELECT id_service FROM service_request WHERE 
                    service_request.id_user  = '".$id_user."')");
                    if(mysqli_num_rows($query) > 0) {
                ?>
                <h5 class="center-align grey-text" style="margin-bottom:0 !important">Serviços que você propôs</h5>
                <div class="wrapper-content">
                    <?php
                        while($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <div class="card hoverable col s12 m4 l3">
                        <a
                            href="../serviceProfile/?occupation_subcategory=<?php echo $row['id_occupation_subcategory']?>&id_service=<?php echo $row['id'] ?>">
                            <div class="card-image">
                                <div class="title-over-image">
                                    <h5><?php echo $row['title'] ?> </h5>
                                </div>
                                <?php 
                                    if(!empty($row['picture'])) {
                                ?>
                                <img src="<?php echo $row['picture'] ?>" alt="card-image">
                                <?php
                                    }
                                ?>
                            </div>
                        </a>
                        <div class="card-content">
                            <!-- Check service status -->
                            <?php
                            // check if the service is pendente 
                                if($row['status'] == 0) {
                            ?>

                            <span class="card-title activator orange-text text-darken-4">
                                Pendente
                                <i class="material-icons md-18">schedule</i>
                                <i class="material-icons right grey-text text-darken-3">keyboard_arrow_up</i>
                            </span>

                            <?php
                            // check if the service is in progress
                                } else if ($row['status'] == 1){
                            ?>

                            <span class="card-title activator green-text text-darken-4"
                                style="font-size:1.3em !important">
                                Em progresso
                                <i class="material-icons md-18">autorenew</i>
                                <!-- change icon -->
                                <i class="material-icons right grey-text text-darken-3">keyboard_arrow_up</i>
                            </span>

                            <?php 
                            // check if the service is done
                                } else if ($row['status'] == 2){
                            ?>

                            <span class="card-title activator grey-text text-darken-4">
                                Encerrado
                                <i class="material-icons md-18">done</i>
                                <!-- change icon -->
                                <i class="material-icons right grey-text text-darken-3">keyboard_arrow_up</i>
                            </span>

                            <?php 
                                }
                            ?>

                        </div>
                        <div class="card-reveal">
                            <div class="card-title">
                                <i class="material-icons right">close</i>
                            </div>
                            <span class="card-title">
                                <strong> <?php echo $row['title'] ?> </strong>
                            </span>
                            <p>
                                <?php echo $row['description'] ?>
                            </p>
                            <p><a href="../serviceProfile/?occupation_subcategory=<?php echo $row['id_occupation_subcategory']?>&id_service=<?php echo $row['id'] ?>"
                                    class="valign-wrapper">Ver mais <i
                                        class="material-icons">keyboard_arrow_right</i></a></p>
                        </div>
                    </div>

                    <?php
                        }
                ?>

                </div>

                <?php
                    } else {
                ?>
                <div class="container center-align no-work">
                    <div class="row">
                        <div class="col s12">
                            <img src="../_img/icon/tools_black_and_white.png" alt="dislike icon" width="130">
                        </div>
                        <div class="col s12">
                            <h4>Ops!</h4>
                            <h6>Você não tem nenhum <a href="../work">serviço</a> realizado ou em andamento. Clique na
                                aba <a href="../work">trabalhar</a><br> e comece a trabalhar
                                agora mesmo!</h6>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                ?>

            </div>

        </section>

    </main>

    <!-- Modal leave -->
    <div id="modalLeave" class="modal">
        <div class="modal-content">
            <h4 class="center-align">Deseja sair?</h4>
        </div>
        <div class="modal-footer">
            <a href="../../../Controller/logout.php" class="modal-close waves-effect btn-flat">Sim</a>
            <button class="modal-close waves-effect waves-light btn">Não</button>
        </div>
    </div>

    <div class="modal" id="modal-evaluation">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <h5 class="center-align">Você possui avaliações pendentes</h5>
                </div>
            </div>
            <div class="row">
            
            
                <div class="col s12 center-align">
                    <!-- get the worker info -->
                    <?php
                        if($pending_evaluation) {
                            if($is_hirer) {
                                $query = mysqli_query($conn, 
                                "SELECT user.id, user.full_name, user.profile_picture FROM user WHERE user.id IN 
                                (SELECT service_request.id_user FROM service_request WHERE service_request.id IN 
                                (SELECT service.id_request_accepted FROM service 
                                WHERE service.id = '".$service_id."'))");
                            } else if(!$is_hirer){
                                $query = mysqli_query($conn, 
                                "SELECT user.id, user.full_name, user.profile_picture FROM user WHERE user.id IN  
                                    (SELECT service.id_user FROM service WHERE service.id = '".$service_id."')");
                            }


                            $row = mysqli_fetch_assoc($query);
                    ?>
                    <img src="<?php echo $row['profile_picture'] ?>" alt="user profile picture" 
                    class="circle z-depth-3" width="130" height="130" style="object-fit:cover">
                    <h6>Usuario: <span class="blue-text text-darken-3"><?php echo $row['full_name'] ?></span> </h6>
                    <h6>Serviço: <span class="blue-text text-darken-3"><?php echo $service_title ?></span></h6>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="modal-footer row">
            <div class="col s6 center-align"><button class="btn-flat modal-close">Fechar</button></div>
            <div class="col s6 center-align">
                <a href="../<?php echo $page_evaluation?>/?id_user_from=<?php echo $id_user ?>&id_user_to=<?php echo $row['id'] ?>&id_service=<?php echo $service_id ?>" class="btn yellow darken-4">Avaliar</a>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="../_js/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../_js/jquery/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../_js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="../_js/bin/main.js"></script>
    <script type="text/javascript">
    //init modal to alert the user about the evaluation
    var elem_modal_evaluation = document.querySelector('#modal-evaluation');
    var instance_modal_evaluation = M.Modal.init(elem_modal_evaluation, {
        dismissible: false
    });

    var toast = "<?php echo $toast ?>";
    if(toast) {
        M.toast({
            html: toast
        });
    }

    document.addEventListener('DOMContentLoaded', function() {

        if("<?php echo $pending_evaluation ?>") {
            setTimeout(function() {
                instance_modal_evaluation.open();
            }, 800);
        }

    }, false);

    </script>
</body>

</html>