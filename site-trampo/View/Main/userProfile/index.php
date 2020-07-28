<?php
    require("../../../Controller/verifica.php");
    include_once '../../../Dao/conexao.php';
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
        
    ?>

    <header>
        <nav class="nav-extended z-depth-0">
            <div class="nav-wrapper">
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <a href="#!" class="brand-logo center">Perfil</a>
            </div>
        </nav>
    </header>

    <!-- padding top due the fixed navbar -->
    <main style="padding-top: 4em;">
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
            <li><a href="../progress" class="waves-effect"><i class="material-icons">cached</i>Em
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

        <!-- Section HIRE and yours tabs -->

        <section class="section-hire">
            <div class="blue-background"></div>
            <div class="z-depth-1 padding container-extended">
                <div class="row">
                    <button onclick="window.history.back()" class="btn circle waves-effect waves-light">
                        <i class="material-icons">arrow_back</i>
                    </button>
                </div>

                <?php
                    $query = mysqli_query($conn, 
                    "SELECT user.*, AVG(evaluation.stars_rating) avg_evaluation FROM user 
                    INNER JOIN evaluation ON user.id = evaluation.id_user_to
                    WHERE user.id = '".$_GET['id_user']."'");
                    $row_worker = mysqli_fetch_assoc($query);
                ?>
                <h5 class="center-align"><strong>Perfil do usuário</strong></h5>
                <div class="row">
                    <div class="divider"></div>
                </div>
                <div class="row" style="max-width:900px">
                    <div class="col s12 m4 center-align">
                        <img src="<?php echo $row_worker['profile_picture']; ?>" style="object-fit:cover"
                            class="z-depth-3 circle" height="200" width="200">
                    </div>
                    <div class="col s12 m7 offset-m1">
                        <h5><?php echo $row_worker['full_name']; ?></h5>
                        <h6 class="yellow-text text-darken-3"><b>Avaliação:</b> <?php echo ($row_worker['avg_evaluation'] <= 0)?'Não avaliado':number_format($row_worker['avg_evaluation'],1); ?></h6>
                        <h6><b>Cidade:</b> <?php echo $row_worker['city'] ?></h6>
                        <h6><b>Bairro: </b><?php echo $row_worker['neighborhood']; ?></h6>
                        <h6>
                            <b>Trabalha com: </b>
                            <?php 
                            
                            $query = mysqli_query($conn, 
                            "SELECT occupation.name FROM occupation 
                            INNER JOIN user_occupation ON user_occupation.id_occupation = occupation.id
                            WHERE id_user = '".$row_worker['id']."'");
                            if(mysqli_num_rows($query) > 0) {
                                while($row_occupation = mysqli_fetch_assoc($query)){
                                    echo $row_occupation['name']."; ";
                                }
                            } else {
                                echo 'Não disponível';
                            }

                            ?>
                        </h6>
                        <div class="row" style="margin-top:2em">
                            <div class="col s12">
                                <a href="../chatMessage/?id_user_from=<?php echo $row['id']; ?>&id_user_to=<?php echo $_GET['id_user']; ?>&name_user_to=<?php echo $row_worker['full_name']; ?>&hire_contact"
                                    class="btn waves-effect waves-light"
                                    <?php echo($_GET['id_user'] == $row['id'])?'disabled':''; ?>>
                                    <i class="material-icons right">chat</i>
                                    Entrar em contato
                                </a>
                                <a href="../report" class="btn red darken-4 waves-effect waves-light tooltipped"
                                data-position="right" data-tooltip="Denunciar"
                                <?php echo($_GET['id_user'] == $row['id'])?'disabled':''; ?>>
                                    <i class="material-icons">warning</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                    <h6 class="center-align">Serviços pendentes de <?php echo $row_worker['full_name']; ?>:</h6>
                </div>
                <div class="user-profile">

                    <div class="wrapper-content" style="padding: 1em 1em;">
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM service WHERE 
                        service.id_user = '".$_GET['id_user']."'");
                        if(mysqli_num_rows($query) > 0) {
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
                    <p class="center-align">Não há serviços deste usuário disponível</p>
                    <?php 
                    }
                    ?>
                </div>
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


    <script type="text/javascript" src="../_js/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../_js/jquery/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../_js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="../_js/bin/main.js"></script>
</body>

</html>