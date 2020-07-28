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

    <!-- verify if there is occupation in URL  -->
    <?php
        if(!isset($_GET['occupation_subcategory'])) {
            header("Location: ../hire");
        }

        //check if its the first time the user at requesting a service
        $first_time_hiring = false;

        $query = mysqli_query($conn, 
        "SELECT service.id FROM service WHERE service.id_user IN 
         (SELECT user.id FROM user WHERE user.email = '".$_SESSION['email']."')");
        if(!mysqli_num_rows($query) > 0) {
            $first_time_hiring = true;
        }
    ?>

    <?php 
        $consulta = "SELECT * FROM user WHERE email = '".$_SESSION['email']."'";
        $res = mysqli_query($conn,$consulta);
        $row = mysqli_fetch_assoc($res);
    ?>

    <header>
        <nav class="nav-extended z-depth-0">
            <div class="nav-wrapper">
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <a href="#!" class="brand-logo center">Contratar</a>
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
            <li class="active"><a href="../hire" class="waves-effect"><i
                        class="material-icons">assignment_ind</i>Contratar</a></li>
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

        <!-- Section HIRE-->

        <section class="section-hire">
            <div class="blue-background"></div>
            <div class="container z-depth-1">
                <form
                    action="../../../Controller/cadastrarService.php/?id_occupation_subcategory=<?php echo $_GET['occupation_subcategory'];?>"
                    method="POST" class="row padding white" enctype="multipart/form-data" autocomplete="off">
                    <a href="../hire" class="btn circle waves-effect waves-light"><i
                            class="material-icons">arrow_back</i></a>
                    <div class="col s12">
                        <br class="hide-on-med-and-up">
                        <h5 class="center-align">Descrever serviço</h5>
                    </div>

                    <!-- get occupation name -->
                    <?php
                        $query = mysqli_query($conn, "SELECT name FROM occupation_subcategory WHERE id = '".$_GET['occupation_subcategory']."'");
                        $row = mysqli_fetch_assoc($query); 
                    ?>


                    <div class="input-field col s12">
                        <input disabled type="text" id="professional" value="<?php echo $row['name'] ?>"
                            name="professional">
                        <label for="professional">Serviço</label>
                    </div>
                    <div class="input-field col s12">
                        <select name="time-remaining" id="time-remaining">
                            <option value="O quanto antes">O quanto antes</option>
                            <option value="A próxima semana">A próxima semana</option>
                            <option value="Duas semanas">Duas semanas</option>
                            <option value="Sem previsão">Sem previsão</option>
                        </select>
                        <label>Para quando é o serviço?</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" id="service-title" name="service-title" required>
                        <label for="service-title">Título do serviço*</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="service-description" class="materialize-textarea" data-length="200"
                            maxlength="200" name="service-description" required></textarea>
                        <label for="service-description">Digite uma descrição do serviço*</label>
                    </div>
                    <div class="input-field col s12">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Foto</span>
                                <input type="file" name="service-picture" accept="image/*"
                                    onchange="document.getElementById('demo-service-picture').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text"
                                    placeholder="Se quiser, mostre uma foto do serviço (200x200)">
                            </div>
                        </div>
                    </div>
                    <!-- inserir onchange function -->
                    <div class="col s12 m6 offset-m3 center-align">
                        <img src="../_img/icon/tools.png" class="center-align z-depth-1" id="demo-service-picture">
                    </div>
                    <div class="col s12" style="margin-top:1.5em">
                        <h6 class="center-align"><strong>Quais os próximos passos?</strong></h6>
                    </div>
                    <div class="col s12 m6 step">
                        <div class="center-align">
                            <img src="../_img/icon/smartphone-text-icon.svg" alt="smartphone icon" width="70">
                            <h6 class="center-align">Logo abaixo, você pode escolher se deseja receber propostas para o
                                seu serviço
                            </h6>
                        </div>
                    </div>
                    <div class="col s12 m6 step">
                        <div class="center-align">
                            <img src="../_img/icon/search-people.svg" alt="" width="70">
                            <h6 class="center-align">Em seguida, você verá profissionais qualificados para o seu serviço
                            </h6>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <p>
                            <label>
                                <input type="checkbox" id="visible-agreement" name="visible-agreement" />
                                <span class="black-text">Permitir que meu pedido seja visto por prestadores (Poderei
                                    receber propostas)</span>
                            </label>
                        </p>
                    </div>
                    <div id="form-message"></div>
                    <div class="input-field col s12 right-align">
                        <button class="btn waves-effect waves-light">Continuar</button>
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

    <!-- Modal warning -->
    <div class="modal" id="modal-warning">
        <div class="modal-content">
            <h4 class="center-align">Cuidado!</h4>
            <div class="row center-align">
                <img src="../_img/icon/warning.svg" alt="warning icon" width="80">
                <h6>Não forneça informações pessoais, tais como seu <b>telefone, Whatsapp ou e-mail</b> para os
                    profissionais. Para ter direito a garantia, é necessário que toda negociação fique registrado no
                    chat do trampo</h6>
            </div>
            <div class="switch valign-wrapper">
                <label>
                    <input type="checkbox" id="warning-agreement">
                    <span class="lever"></span>
                </label>
                <span>Li, entendi e concordo</span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn modal-close waves-effect waves-light warning-btn disabled">Continuar</button>
        </div>
    </div>


    <script type="text/javascript" src="../_js/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../_js/jquery/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../_js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="../_js/bin/main.js"></script>
    <script type="text/javascript">
    //init warning modal

    var elem_modal_warning = document.querySelector('#modal-warning');
    var instance_modal_warning = M.Modal.init(elem_modal_warning, {
        dismissible: false
    });
    var btn_warning = document.querySelector(".warning-btn");
    var warning_agreement = document.querySelector("#warning-agreement");

    var first_time_hiring = "<?php echo $first_time_hiring; ?>";
    document.addEventListener('DOMContentLoaded', function() {

        if(first_time_hiring) {
                setTimeout(function() {
                instance_modal_warning.open();
            }, 800);
        }

    }, false);

    warning_agreement.addEventListener('click', function() {
        if (!warning_agreement.checked) {
            btn_warning.classList.toggle("disabled");
        } else {
            btn_warning.classList.toggle("disabled");
        }
    });
    </script>
</body>

</html>