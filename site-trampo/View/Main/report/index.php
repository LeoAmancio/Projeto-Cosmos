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
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

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
                <a href="#!" class="brand-logo center">Reportar</a>
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

                <h5 class="center-align"><strong>Reportar problema </strong></h5>
                <div class="row">
                    <div class="divider"></div>
                </div>
                <form action="#" class="row">
                    <div class="input-field col s12">
                        <select>
                            <option value="" disabled selected>Escolha o assunto</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                        </select>
                        <label>Assunto</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="textarea1" class="materialize-textarea"></textarea>
                        <label for="textarea1">Descreva o problema</label>
                    </div>
                    <div class="input-field col s12 right-align">
                        <a href="#!" class="btn waves-effect waves-light red darken-2">
                            Reportar
                            <i class="material-icons right">warning</i>
                        </a>
                    </div>
                    <div class="row">
                        <p class="col s12">
                            <b>OBS:</b> Após reportar o problema, um moderador irá entrar em contato <br> com você 
                            por meio do chat, fique atento.
                        </p>
                    </div>
                </form>

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
                <a href="#!" class="btn waves-effect waves-light green darken-4">
                    Finalizar <i class="material-icons right">done</i>
                </a>
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
        if (toast != "") {
            M.toast({
                html: toast
            });
        }
    });
    </script>
</body>

</html>