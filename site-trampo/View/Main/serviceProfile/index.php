<?php
    require("../../../Controller/verifica.php");
    include_once '../../../Dao/conexao.php';

    //check if there is cookie, then pass it to the javascript for the toast message
    $toast = "";
    if(isset($_COOKIE['registered_service_request'])) {
        $toast = "Proposta enviada!";
        setcookie("registered_service_request", false, time()+3600, '/');
    } else if(isset($_COOKIE['deleted_request'])) {
        $toast = "Proposta excluída!";
        setcookie("deleted_request", false, time()+3600, '/');
    } else if(isset($_COOKIE['accept_request'])) {
        $toast = "Prestador contratado!";
        setcookie("accept_request", false, time()+3600, '/');
    } else if(isset($_COOKIE['who_finish_service'])) {
        $toast = "Aguardando confirmação...";
        setcookie("who_finish_service", false, time()+3600, '/');
    } else if(isset($_COOKIE['finish_service'])) {
        $toast = "O serviço foi encerrado.";
        setcookie("finish_service", false, time()+3600, '/');
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
        <nav class="nav-extended z-depth-0">
            <div class="nav-wrapper">
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <a href="#!" class="brand-logo center">Serviço</a>
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

        <section class="section-hire">
            <div class="blue-background"></div>
            <div class="z-depth-1 padding container-extended">
                <div class="row">
                    <button onclick="window.history.back()" class="btn circle waves-effect waves-light">
                        <i class="material-icons">arrow_back</i>
                    </button>
                </div>

                <?php
                    $query = mysqli_query($conn, "SELECT service.id, service.description,service.id_request_accepted, service.who_finished, service.is_finished, service.time_remaining, service.title, service.id_user, service.picture, occupation.name, user.full_name, user.id id_user FROM `service` 
                    INNER JOIN occupation_subcategory
                    ON service.id_occupation_subcategory = occupation_subcategory.id
                    INNER JOIN occupation ON occupation_subcategory.id_occupation = occupation.id 
                    INNER JOIN user ON service.id_user = user.id
                    WHERE service.id = '".$_GET['id_service']."'");
                    $row = mysqli_fetch_assoc($query);
                    $who_finished = $row['who_finished'];
                    $is_finished = $row['is_finished'];
                    $confirm_finish_service = ($who_finished != null && $who_finished != $id_user)?true:false;
                ?>
                <h5 class="center-align"><strong>Detalhes do serviço</strong></h5>
                <div class="divider"></div>
                <div class="row center-align" style="padding: 2em 2em 1em">

                    <img src="<?php echo(!empty($row['picture']))?$row['picture']:'../_img/icon/no_service_image.png'; ?>"
                        alt="service picture" height="230" class="<?php echo(!empty($row['picture'])?'z-depth-3':'') ?>"
                        style="width:100%; max-width:230px; object-fit:cover">
                    <h5><?php echo $row['title']; ?></h5>
                    <div class="divider" style="margin-bottom:1em"></div>
                    <div class="col s12">
                        <h6>Informações do serviço</h6>
                    </div>
                    <div class="col s12 m2 left-align">
                        <p><b>Descrição: </b></p>
                    </div>
                    <div class="col s12 m10 left-align">
                        <p><?php echo $row['description']; ?></p>
                    </div>
                    <div class="col s12 m2 left-align">
                        <p><b>Categoria: </b></p>
                    </div>
                    <div class="col s12 m10 left-align">
                        <p><?php echo $row['name']; ?></p>
                    </div>
                    <div class="col s12 m2 left-align">
                        <p><b>Quando: </b></p>
                    </div>
                    <div class="col s12 m10 left-align">
                        <p><?php echo $row['time_remaining']; ?></p>
                    </div>
                    <div class="col s12 m2 left-align">
                        <p><b>Prestador: </b></p>
                    </div>
                    <div class="col s12 m10 left-align">
                        <p>
                            <a
                                href="../userProfile/?id_user=<?php echo $row['id_user'] ?>"><?php echo $row['full_name']; ?></a>
                        </p>
                    </div>
                </div>
                <div class="divider"></div>

                <?php 
                //load service requests

                    //variable to check if already there is a accepted request
                    $request_accepted = false;
                    
                     if($row['id_user'] == $id_user) {
                        //if it don't have a worker hired, show all the requests
                        if($row['id_request_accepted'] == null) {
                            $query = mysqli_query($conn, "SELECT service_request.*, user.full_name, user.id id_user, user.profile_picture FROM `service_request` 
                            INNER JOIN user ON service_request.id_user = user.id
                            WHERE service_request.id IN (SELECT MAX(id) FROM service_request WHERE id_service = '".$row['id']."' GROUP BY id_user) ORDER BY service_request.id DESC");
                            if(mysqli_num_rows($query) > 0) {
                ?>
                <div class="row">
                    <h6 class="center-align">Solicitações de trabalho</h6>
                </div>
                <?php
                            //load all the requests
                            while($row = mysqli_fetch_assoc($query)) {
                ?>

                <div class="row valign-wrapper z-depth-1" style="flex-wrap: wrap; padding:1.3em; border-radius:0.2em">
                    <a href="../userProfile/?id_user=<?php echo $row['id_user']; ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>&id_service=<?php echo $_GET['id_service'] ?>&service_profile"
                        class="col s12 m12 l3 center-align">
                        <img src="<?php echo $row['profile_picture'] ?>" alt="user profile" class="circle z-depth-2"
                            width="100" height="100" style="object-fit:cover">
                        <h6><?php echo $row['full_name'] ?></h6>
                    </a>
                    <div class="col s12 m12 l3 center-align">
                        <p><?php echo $row['description'] ?></p>
                    </div>
                    <div class="col s12 m12 l3 center-align">
                        <h5>R$ <?php echo(str_replace(".",",",$row['price'])) ?></h5>
                    </div>
                    <div class="col s12 m12 l3 center-align">
                        <a href="../chatMessage/?id_user_from=<?php echo $id_user ?>&id_user_to=<?php echo $row['id_user']; ?>&name_user_to=<?php echo $row['full_name']; ?>&hire_contact"
                            class="btn waves-effect waves-light tooltipped" data-position="top" data-tooltip="Entrar em contato"><i class="material-icons">chat</i></a>
                        <!-- talk to the worker-->
                        <a href="#modal-accept-service" class="btn green waves-effect modal-trigger tooltipped"
                        data-position="top" data-tooltip="Aceitar proposta"
                        onclick="accept_service_request(<?php echo $row['id']; ?>, <?php echo $_GET['id_service']; ?>,<?php echo $_GET['occupation_subcategory']; ?>)"><i
                                class="material-icons">done</i></a>
                        <!-- accept service-->
                        <a href="#modal-dismiss-service" class="btn red waves-effect modal-trigger tooltipped"
                        data-position="top" data-tooltip="Recusar proposta"
                        onclick="delete_service_request(<?php echo $row['id'] ?>, <?php echo $_GET['id_service']?>, <?php echo $_GET['occupation_subcategory'] ?>)"><i
                                class="material-icons">clear</i></a><!-- dismiss service-->
                    </div>
                </div>
                <?php
                            }
                ?>
                <div class="row" style="margin-top:4em">
                    <div class="col s6 left-align">
                        <a href="../editService/?id_service=<?php echo $_GET['id_service'] ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>" class="btn orange darken-3 tooltipped" data-position="right" data-tooltip="Editar serviço">
                            <i class="material-icons">edit</i>
                        </a>
                    </div>
                    <div class="col s6 right-align">
                        <a href="../workerList/?occupation_subcategory=<?php echo $_GET['occupation_subcategory']?>&id_service=<?php echo $_GET['id_service']; ?>"
                            class="btn waves-effect waves-light">Procurar por prestadores</a>
                    </div>
                </div>
                <?php
                        //if there is no request
                        }else {
                ?>
                <div class="row">
                    <p class="center-align"><strong>Solicitações de trabalho</strong></p>
                </div>
                <div class="row">
                    <h6 class="center-align">Não há solicitações para seu serviço!</h6>
                </div>
                <div class="row right-align" style="margin-top:4em">
                    <div class="col s6 left-align">
                        <a href="../editService/?id_service=<?php echo $_GET['id_service'] ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>" class="btn orange darken-3 tooltipped" data-position="right" data-tooltip="Editar serviço">
                            <i class="material-icons">edit</i>
                        </a>
                    </div>
                    <div class="col s6 right-align">
                        <a href="../workerList/?occupation_subcategory=<?php echo $_GET['occupation_subcategory']?>&id_service=<?php echo $_GET['id_service']; ?>"
                            class="btn waves-effect waves-light">Procurar por prestadores</a>
                    </div>
                </div>
                <?php
                        }
                //otherwise, if there is a hired worker, load the hired request    
                } else {
                        $request_accepted = true;
                        $query = mysqli_query($conn, "SELECT service_request.*, user.id id_user, user.full_name, user.profile_picture FROM service_request
                        INNER JOIN user ON service_request.id_user = user.id
                        WHERE service_request.id = '".$row['id_request_accepted']."'");
                        $row = mysqli_fetch_assoc($query);
                ?>
                <div class="row">
                    <h6 class="center-align"><strong>Prestador contratado</strong></h6>
                </div>
                <div class="row valign-wrapper z-depth-1" style="flex-wrap: wrap; padding:1.3em; border-radius:0.2em">
                    <a href="../userProfile/?id_user=<?php echo $row['id_user']; ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>&id_service=<?php echo $_GET['id_service'] ?>&service_profile"
                        class="col s12 m12 l3 center-align">
                        <img src="<?php echo $row['profile_picture'] ?>" alt="user profile" class="circle z-depth-2"
                            width="100" height="100" style="object-fit:cover">
                        <h6><?php echo $row['full_name'] ?></h6>
                    </a>
                    <div class="col s12 m12 l3 center-align">
                        <p><?php echo $row['description'] ?></p>
                    </div>
                    <div class="col s12 m12 l3 center-align">
                        <h5>R$ <?php echo(str_replace(".",",",$row['price'])) ?></h5>
                    </div>
                    <div class="col s12 m12 l3 center-align">
                        <a href="../chatMessage/?id_user_from=<?php echo $id_user ?>&id_user_to=<?php echo $row['id_user']; ?>&name_user_to=<?php echo $row['full_name']; ?>&hire_contact"
                            class="btn waves-effect waves-light tooltipped" 
                            data-position="top" data-tooltip="Entrar em contato"><i class="material-icons">chat</i></a>
                        <!-- talk to the worker-->
                    </div>
                </div>
                <div class="row right-align">
                    <a href="../report" class="btn waves-effect waves-light orange darken-4">
                        <i class="material-icons right">warning</i>
                        Relatar problema
                    </a>
                </div>
                <div class="row right-align">
                    <a href="#<?php echo($who_finished != null)?'modal-confirm-finish-service':'modal-finish-service'; ?>"
                        class="btn waves-effect waves-light green darken-4 modal-trigger <?php echo($who_finished == $id_user || $is_finished != 0)?'disabled':''; ?>">
                        <?php 
                        
                        if($who_finished == $id_user) {
                            echo 'Aguardando confirmação...';
                        } else if($who_finished != null) {
                            echo 'Confirmar finalização';
                        } else {
                            echo "Finalizar serviço <i class='material-icons right'>done</i>";
                        }
                        ?>
                    </a>
                </div>
                <?php
                    }
                ?>

                <?php
                //if the user is not the owner of the service    
                } else {
                        //check if the user can do the job/ is worker
                        $query = mysqli_query($conn, "SELECT id FROM user_occupation WHERE id_user = '".$id_user."'");
                        if(mysqli_num_rows($query) > 0) {
                            //check if already have sent a request
                            $query = mysqli_query($conn, "SELECT service_request.*, service.id_request_accepted, service.status, user.full_name, user.id id_user, user.profile_picture 
                            FROM `service_request` 
                            INNER JOIN user ON service_request.id_user = user.id
                            INNER JOIN service ON service_request.id_service = service.id
                            WHERE service_request.id_service = '".$_GET['id_service']."' AND service_request.id_user = '".$id_user."'
                            ");
                            $row = mysqli_fetch_assoc($query);
                            //if he is worker and already have sent a request, show the request with the form to a new one request
                            if(mysqli_num_rows($query) > 0 && $row['id_request_accepted'] == null && $row['status'] == 0) {
                ?>
                <div class="row">
                    <h5 class="center-align blue-text">Minha atual proposta</h5>
                </div>
                <div class="row valign-wrapper z-depth-1" style="flex-wrap: wrap; padding:1.3em; border-radius:0.2em">
                    <a href="../userProfile/?id_user=<?php echo $row['id_user'] ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>&id_service=<?php echo $_GET['id_service'] ?>&service_profile"
                        class="col s12 m12 l3 center-align">
                        <img src="<?php echo $row['profile_picture'] ?>" alt="user profile" class="circle z-depth-2"
                            width="100" height="100" style="object-fit:cover">
                        <h6><?php echo $row['full_name'] ?></h6>
                    </a>
                    <div class="col s12 m12 l3 center-align">
                        <p><?php echo $row['description'] ?></p>
                    </div>
                    <div class="col s12 m12 l3 center-align">
                        <h5>R$ <?php echo(str_replace(".",",",$row['price'])) ?></h5>
                    </div>
                    <div class="col s12 m12 l3 center-align">
                        <a href="#modal-dismiss-service" class="btn red waves-effect modal-trigger tooltipped"
                        data-position="top" data-tooltip="Deletar proposta"
                        onclick="delete_service_request(<?php echo $row['id'] ?>, <?php echo $_GET['id_service']?>, <?php echo $_GET['occupation_subcategory'] ?>)">
                            <i class="material-icons">clear</i>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <h5 class="center-align blue-text"><strong>Oferecer nova proposta</strong></h5>
                </div>
                <form
                    action="../../../Controller/insertServiceRequest.php/?occupation_subcategory=<?php echo $_GET['occupation_subcategory']; ?>&id_service=<?php echo $_GET['id_service'] ?>&id_user=<?php echo $id_user ?>"
                    method="POST" class="row">
                    <div class="input-field col s12 m12">
                        <i class="material-icons prefix">create</i>
                        <textarea class="materialize-textarea" data-length="200" maxlength="200"
                            id="service_request_description" name="description" required></textarea>
                        <label for="service_request_description">Proposta de serviço</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">attach_money</i>
                        <input type="text" id="service_request_price" name="price" placeholder="320,00" required>
                        <label for="service_request_price">Preço R$</label>
                    </div>
                    <div class="input-field col s12 right-align">
                        <button type="submit" class="btn waves-effect waves-light">Oferecer serviço</button>
                    </div>
                </form>

                <?php
                            // if the worker have sent a request and this is the accepted request
                            } else if(mysqli_num_rows($query) > 0 && $row['id_request_accepted'] == $row['id']) {
                ?>
                <div class="row">
                    <h6 class="center-align"><strong>Meu contrato</strong></h6>
                </div>
                <div class="row valign-wrapper z-depth-1" style="flex-wrap: wrap; padding:1.3em; border-radius:0.2em">
                    <a href="../userProfile/?id_user=<?php echo $row['id_user']; ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>&id_service=<?php echo $_GET['id_service'] ?>&service_profile"
                        class="col s12 m12 l3 center-align">
                        <img src="<?php echo $row['profile_picture'] ?>" alt="user profile" class="circle z-depth-2"
                            width="100" height="100" style="object-fit:cover">
                        <h6><?php echo $row['full_name'] ?></h6>
                    </a>
                    <div class="col s12 m12 l3 center-align">
                        <p><?php echo $row['description'] ?></p>
                    </div>
                    <div class="col s12 m12 l3 center-align">
                        <h5>R$ <?php echo(str_replace(".",",",$row['price'])) ?></h5>
                    </div>
                    <div class="col s12 m12 l3 center-align">
                        <button class="btn waves-effect waves-light disabled"><i
                                class="material-icons">chat</i></button>
                        <!-- talk to the worker-->
                    </div>
                </div>
                <div class="row right-align">
                    <a href="../report" class="btn waves-effect orange darken-4">
                        <i class="material-icons right">warning</i>
                        Relatar problema
                    </a>
                </div>

                <div class="row right-align">
                <!-- change to wich modal have to open -->
                    <a href="#<?php echo($who_finished != null)?'modal-confirm-finish-service':'modal-finish-service'; ?>"
                        class="btn waves-effect waves-light green darken-4 modal-trigger <?php echo($who_finished == $id_user || $is_finished != 0)?'disabled':''; ?>">
                        <?php 
                        
                        if($who_finished == $id_user) {
                            echo 'Aguardando confirmação...';
                        } else if($who_finished != null) {
                            echo 'Confirmar finalização';
                        } else {
                            echo "Finalizar serviço <i class='material-icons right'>done</i>";
                        }
                        ?>
                    </a>
                </div>

                <?php 
                            } else if($row['status'] == 0 && $row['is_finished'] == 0) {
                ?>
                <!-- the user have not sent a request for this service -->
                <div class="row">
                    <h5 class="center-align blue-text"><strong>Oferecer nova proposta</strong></h5>
                </div>
                <form
                    action="../../../Controller/insertServiceRequest.php/?occupation_subcategory=<?php echo $_GET['occupation_subcategory']; ?>&id_service=<?php echo $_GET['id_service'] ?>&id_user=<?php echo $id_user ?>"
                    method="POST" class="row">
                    <div class="input-field col s12 m12">
                        <i class="material-icons prefix">create</i>
                        <textarea class="materialize-textarea" data-length="200" maxlength="200"
                            id="service_request_description" name="description" required></textarea>
                        <label for="service_request_description">Proposta de serviço</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">attach_money</i>
                        <input type="text" id="service_request_price" name="price" placeholder="320,00" required>
                        <label for="service_request_price">Preço R$</label>
                    </div>
                    <div class="input-field col s12 right-align">
                        <button type="submit" class="btn waves-effect waves-light">Oferecer serviço</button>
                    </div>
                </form>
                <?php 
                            }
                ?>

                <?php
                        } else {
                ?>
                <div class="row">
                    <h5 class="center-align blue-text"><strong>Oferecer serviço</strong></h5>
                </div>
                <div class="row">
                    <h6 class="center-align">Você não pode prestar serviço, pois ainda não é prestador</h6>
                </div>
                <?php
                    }
                }
                ?>
                <?php 
                    if($is_finished != 0) {
                ?>
                <h5 class="center-align blue-text text-darken-4">Serviço encerrado.</h5>
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

    <!-- Modal accept service -->
    <div class="modal" id="modal-accept-service">
        <div class="modal-content">
            <div class="row">
                <h4 class="center-align">Tem certeza?</h4>
            </div>
            <div class="row">
                <h6 class="center-align">Clicando em aceitar, você irá <b>contratar</b> o prestador! </h6>
            </div>
        </div>
        <div class="modal-footer row">
            <div class="col s6 center-align">
                <button class="btn-flat modal-close">Cancelar</button>
            </div>
            <div class="col s6 center-align">
                <a href="#!" id="accept-service-request" class="btn waves-effect waves-light green">Aceitar</a>
            </div>
        </div>
    </div>

    <!-- Modal dismiss service -->
    <div class="modal" id="modal-dismiss-service">
        <div class="modal-content">
            <div class="row">
                <h4 class="center-align">Tem certeza?</h4>
            </div>
            <div class="row">
                <h6 class="center-align">Clicando em <span class="red-text"><b>excluir</b></span> a proposta, você não
                    poderá vê-la novamente!</h6>
            </div>
        </div>
        <div class="modal-footer row">
            <div class="col s6 center-align"><button class="btn-flat modal-close">Cancelar</button></div>
            <div class="col s6 center-align">
                <a href="#!" id="delete-service-request" class="btn waves-effect red">Excluir</a>
            </div>
        </div>
    </div>

    <!-- Modal dismiss hired user (NOT USING) -->
    <div class="modal" id="modal-dismiss-hired-user">
        <div class="modal-content">
            <div class="row">
                <h4 class="center-align">Tem certeza?</h4>
            </div>
            <div class="row">
                <h6 class="center-align">Clicando em <span class="red-text"><b>Dispensar prestador</b></span> você irá
                    dispensar o atual prestador, não há como retroceder!</h6>
            </div>
        </div>
        <div class="modal-footer row">
            <div class="col s6 center-align"><button class="btn-flat modal-close">Cancelar</button></div>
            <div class="col s6 center-align">
                <a href="#!" id="dismiss-hired-user" class="btn waves-effect red">Dispensar prestador</a>
            </div>
        </div>
    </div>

    <!-- modal finish service -->
    <div class="modal" id="modal-finish-service">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <h4 class="center-align">Tem certeza?</h4>
                </div>
            </div>
            <div class="row">
                <h6 class="justify-align">
                    Clicando em <span class="green-text text-darken-4"><b>Finalizar</b></span> você irá alertar que o
                    serviço
                    foi finalizado, e será enviado uma confirmação para o outro usuário indicar que está tudo certo,
                    caso haja conflitos, a moderação da plataforma <span class="blue-text"><b>trampo</b></span> irá
                    analisar o caso.
                </h6>
            </div>
        </div>
        <div class="modal-footer row">
            <div class="col s6 center-align">
                <button class="btn-flat waves-effect modal-close">Cancelar</button>
            </div>
            <div class="col s6 center-align">
                <a href="../../../Controller/finishService.php/?id_service=<?php echo $_GET['id_service'] ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>&id_user=<?php echo $id_user ?>&confirm_finish_service=<?php echo $confirm_finish_service; ?>"
                    class="btn waves-effect waves-light green darken-4">
                    Finalizar <i class="material-icons right">done</i>
                </a>
            </div>
        </div>
    </div>

    <!-- modal alert finished service -->
    <div class="modal" id="modal-alert-finish-service">
        <div class="modal-content">
            <div class="row">
                <h5 class="center-align">Confirmação de serviço finalizado</h5>
            </div>
            <div class="row">
                <h6 class="justify-align">
                    Foi notado uma confirmação de finalização pelo o outro usuário responsável
                    pelo serviço. Clique em <span class="green-text text-darken-3"><b>Confirmar</b></span>
                    para encerrar o serviço, ou caso haja algum conflito, clique em
                    <span class="red-text text-darken-1"><b>Cancelar</b></span> e logo após vá em
                    <span class="orange-text text-darken-4"><b>Relatar problema.</b></span>
                </h6>
            </div>
        </div>
        <div class="footer row center-align">
            <div class="col s6">
                <button class="btn waves-effect waves-light red modal-close">Cancelar</button>
            </div>
            <div class="col s6 center-align">
                <a href="../../../Controller/finishService.php/?id_service=<?php echo $_GET['id_service'] ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>&id_user=<?php echo $id_user ?>&confirm_finish_service=<?php echo $confirm_finish_service; ?>"
                    class="btn waves-effect waves-light green darken-3">Confirmar</a>
            </div>
        </div>
    </div>

    <!-- modal confirm finish service -->
    <div class="modal" id="modal-confirm-finish-service">
        <div class="modal-content">
            <div class="row">
                <h5 class="center-align">Confirmar finalização</h5>
            </div>
            <div class="row">
                <h6 class="justify-align">
                    Ao clicar em <span class="green-text text"><b>Confirmar</b></span>, o serviço
                    será encerrado, e você será solicitado para avaliar o outro usuário.
                </h6>
            </div>
        </div>
        <div class="footer row center-align">
            <div class="col s6">
                <button class="btn waves-effect waves-light red modal-close">Cancelar</button>
            </div>
            <div class="col s6">
                <a href="../../../Controller/finishService.php/?id_service=<?php echo $_GET['id_service'] ?>&occupation_subcategory=<?php echo $_GET['occupation_subcategory'] ?>&id_user=<?php echo $id_user ?>&confirm_finish_service=<?php echo $confirm_finish_service; ?>" class="btn waves-effect waves-light green darken-3">Confirmar</a>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../_js/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../_js/jquery/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../_js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="../_js/bin/main.js"></script>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var toast = "<?php echo $toast ?>";

        var confirm_finish_service = "<?php echo $confirm_finish_service ?>";

        var elem_modal_confirm_finish_service = document.querySelector("#modal-alert-finish-service");
        var instance_modal_confirm_finish_service = M.Modal.init(elem_modal_confirm_finish_service);

        if (toast != "") {
            M.toast({
                html: toast
            });
        }

        if (confirm_finish_service) {
            instance_modal_confirm_finish_service.open();
        }
    });
    </script>
</body>

</html>