<?php
    require("../../../Controller/verifica.php");
    include_once '../../../Dao/conexao.php';

    //check if there is not missing the required variables
    if(!isset($_GET['id_user_from'], $_GET['id_user_to'], $_GET['id_service'])) {
        header("Location: ../progress");
    }

    //check if there is cookie, then pass it to the javascript for the toast message
    $toast = null;
    if(isset($_COOKIE['failed_evaluation'])) {
        $toast = "É obrigatório preencher todas as informações!";
        setcookie("failed_evaluation", false, time()+3600, '/');
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
        
        //avoid the user to rate himself
        if(isset($_GET['id_user_from'], $_GET['id_user_to']) && $_GET['id_user_from'] == $_GET['id_user_to']) {
            header("Location: ../progress");
        }
        
    ?>

    <header>
        <nav class="nav-extended z-depth-0">
            <div class="nav-wrapper">
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <a href="#!" class="brand-logo center">Avaliar</a>
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

                <h5 class="center-align">Avaliar o prestador</h5>
                <div class="row">
                    <div class="divider"></div>
                </div>
                <form action="../../../Controller/registerEvaluation.php?id_user_from=<?php echo $_GET['id_user_from'] ?>&id_user_to=<?php echo $_GET['id_user_to'] ?>&id_service=<?php echo $_GET['id_service'] ?>" class="row" method="POST">
                    <div class="input-field col s12">
                        <strong class="grey-text text-darken-1">O serviço foi realizado como você gostaria?</strong>
                        <select name="answer_1">
                            <option value="0" disabled selected>Selecione uma opção</option>
                            <option value="1" data-icon="../_img/icon/high_satisfaction.svg">Sim, totalmente</option>
                            <option value="2" data-icon="../_img/icon/medium_satisfaction.svg">Parcialmente</option>
                            <option value="3" data-icon="../_img/icon/low_satisfaction.svg">Não</option>
                        </select>
                    </div>

                    <div class="input-field col s12">
                        <strong class="grey-text text-darken-1">O prestador manteve ética durante o trabalho?</strong>
                        <select name="answer_2">
                            <option value="0" disabled selected>Selecione uma opção</option>
                            <option value="1" data-icon="../_img/icon/high_satisfaction.svg">Sim, totalmente</option>
                            <option value="2" data-icon="../_img/icon/medium_satisfaction.svg">Parcialmente</option>
                            <option value="3" data-icon="../_img/icon/low_satisfaction.svg">Não</option>
                        </select>
                    </div>

                    <div class="input-field col s12">
                        <strong class="grey-text text-darken-1">Você ficou satisfeito com o trabalho?</strong>
                        <select name="answer_3">
                            <option value="" disabled selected>Selecione uma opção</option>
                            <option value="1" data-icon="../_img/icon/high_satisfaction.svg">Sim, totalmente</option>
                            <option value="2" data-icon="../_img/icon/medium_satisfaction.svg">Parcialmente</option>
                            <option value="3" data-icon="../_img/icon/low_satisfaction.svg">Não</option>
                        </select>
                    </div>

                    <div class="input-field col s12">
                        <textarea id="textarea1" class="materialize-textarea" name="further_information"></textarea>
                        <label for="textarea1">Relatos adicionais (Opcional)</label>
                    </div>

                    <!-- Getting hirer's information -->
                    <?php 
                    
                    $query = mysqli_query($conn, "SELECT user.full_name, user.profile_picture FROM user 
                    WHERE user.id = '".$_GET['id_user_to']."'");
                    $row = mysqli_fetch_assoc($query);

                    ?>

                    <div class="row">
                        <h6 class="center-align">
                            De 1 a 5, qual a sua <span class="yellow-text text-darken-4">avaliação</span> total
                            para <?php echo $row['full_name'] ?>?
                        </h6>
                    </div>

                    <div class="row valign-wrapper" style="flex-wrap:wrap">
                        <div class="col s12 m6 center-align">
                            <img src="<?php echo $row['profile_picture'] ?>" alt="user picture"
                                class="circle z-depth-2" style="object-fit:cover" width="130" height="130">
                            <h6><?php echo $row['full_name'] ?></h6>
                        </div>

                        <div class="col s12 m6 center-align">
                            <div class="rating-buttons-wrapper" style="display:table; margin:auto">
                                <a href="#!" class="btn waves-effect waves-light grey lighten-1 rating-button" style="margin-top:0.5em"><i
                                        class="material-icons md-24">star</i></a>
                                <a href="#!" class="btn waves-effect waves-light grey lighten-1 rating-button" style="margin-top:0.5em"><i
                                        class="material-icons md-24">star</i></a>
                                <a href="#!" class="btn waves-effect waves-light grey lighten-1 rating-button" style="margin-top:0.5em"><i
                                        class="material-icons md-24">star</i></a>
                                <a href="#!" class="btn waves-effect waves-light grey lighten-1 rating-button" style="margin-top:0.5em"><i
                                        class="material-icons md-24">star</i></a>
                                <a href="#!" class="btn waves-effect waves-light grey lighten-1 rating-button" style="margin-top:0.5em"><i
                                        class="material-icons md-24">star</i></a>
                            </div>
                            <!-- rating description -->
                            <h6 style="margin-top:1em" id="rating-description"> Não avaliado</h6>

                            <!-- total rating -->
                            <input type="hidden" id="stars-rating" name="stars_rating">
                        </div>
                    </div>
                    <div class="row right-align">
                        <button type="submit" class="btn waves-effect waves-light">Confirmar <i class="material-icons right">done</i></button>
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
    var rating_buttons = document.querySelectorAll(".rating-button");
    var rating_description = document.querySelector("#rating-description");
    var rated = null;

    for (let i = 0; i < Object.keys(rating_buttons).length; i++) {

        rating_buttons[i].addEventListener('mouseenter', function() {
            deselectRatingButtons();
            for (let j = i; j >= 0; j--) {
                rating_buttons[j].classList.remove('grey');
                rating_buttons[j].classList.add('yellow', 'darken-4');
            }
            changeRatingDescription(i)
            
        });


        rating_buttons[i].parentElement.addEventListener('mouseleave', function() {
            if(rated == null) { 
                deselectRatingButtons();
                changeRatingDescription();
            } else {
                deselectRatingButtons();
                changeRatingDescription(rated);
                for (let j = rated; j >= 0; j--) {
                    rating_buttons[j].classList.remove('grey');
                    rating_buttons[j].classList.add('yellow', 'darken-4');
                }
            }
        });


        rating_buttons[i].addEventListener('click', function() {
            rated = i;
            document.querySelector("#stars-rating").value = i+1;
        });

    }

    function deselectRatingButtons() {
        for (btn of rating_buttons) {
            btn.classList.remove('yellow', 'darken-4');
            btn.classList.add('grey');
        }
    }

    function changeRatingDescription(index) {
        $(rating_description).fadeOut(150, function() {
                $(this).html(
                    (index == 0) ? 'Insatisfeito'
                    : (index == 1) ? 'Pouco satisfeito'
                    : (index == 2) ? 'Mediano'
                    : (index == 3) ? 'Bom'
                    : (index == 4) ? 'Excelente!'
        : 'Não avaliado').fadeIn(150);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var toast = "<?php echo $toast ?>";
        if(toast) {
            M.toast({
                html: toast
            });
        }
    });

    </script>
</body>

</html>