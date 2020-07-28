<?php
    require("../../../Controller/verifica.php");
    include_once '../../../Dao/conexao.php';
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
        $res = mysqli_query($conn, $consulta);
        $row = mysqli_fetch_assoc($res);

        if(!isset($_GET['id_user_from']) || !isset($_GET['id_user_to'])) {
            header("Location: ../chatList");
        } else {
            if(isset($_GET['hire_contact'])) {
                $query  = mysqli_query($conn, "SELECT id FROM conversation WHERE id_user_1 = '".$_GET['id_user_from']."' AND id_user_2 = '".$_GET['id_user_to']."' OR id_user_1 = '".$_GET['id_user_to']."' AND id_user_2 = '".$_GET['id_user_from']."'");
                if(mysqli_num_rows($query) == 0) {
                    mysqli_query($conn, "INSERT INTO conversation (id_user_1, id_user_2) VALUES ('".$_GET['id_user_from']."', '".$_GET['id_user_to']."') ");
                    $query = mysqli_query($conn, "SELECT * FROM conversation WHERE id_user_1 = '".$_GET['id_user_from']."' AND id_user_2 = '".$_GET['id_user_to']."'");
                }
                $id_conversation = mysqli_fetch_assoc($query);
            }
        }
    ?>


    <input type="hidden" value="<?php echo $_GET['id_user_from'] ?>" id="id_user_from">
    <input type="hidden" value="<?php echo $_GET['id_user_to'] ?>" id="id_user_to">
    <input type="hidden"
        value="<?php echo (isset($id_conversation['id']))?$id_conversation['id']:$_GET['id_conversation'] ?>"
        id="id_conversation">


    <header>
        <nav class="nav-extended">
            <div class="nav-wrapper">
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <a href="#!" class="brand-logo center">Chat</a>
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
            <li><a href="../hire" class="waves-effect"><i class="material-icons">assignment_ind</i>Contratar</a>
            </li>
            <li><a href="../work" class="waves-effect"><i class="material-icons">build</i>Trabalhar</a>
            </li>
            <li class="active"><a href="../chatList" class="waves-effect"><i class="material-icons">chat</i>Chat</a>
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


        <section class="chat z-depth-1">
            <div class="conversation">

                <div class="header row valign-wrapper left-align">
                    <div class="col">
                        <a href="../chatList" class="btn-flat waves-effect white-text">
                            <i class="material-icons">
                                arrow_back
                            </i>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="../userProfile/?id_user=<?php echo $_GET['id_user_to']; ?>">
                            <h5 class="white-text"><?php echo $_GET['name_user_to']; ?></h5>
                        </a>
                    </div>
                </div>

                <div class="conversation-content">
                </div>
                <div class="send-message">
                    <form action="#" id="form-chat" class="row valign-wrapper" autocomplete="off">
                        <div class="col s10">
                            <input type="text" class="browser-default" id="text-message"
                                placeholder="Digite uma mensagem">
                        </div>
                        <div class="col s2">
                            <button class="btn waves-effect waves-light"><i class="material-icons">send</i></button>
                        </div>
                        <div id="form-chat-result"></div>
                        <input type="hidden" id="new_message">
                    </form>
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

    <div class="modal" id="modal-conversation-already-started">
        <div class="modal-content">
            <h4 class="center-align">Você já iniciou uma conversa!</h4>
        </div>
        <div class="modal-footer center-align row">
            <button class="modal-close waves-effect waves-light btn col s4 offset-2 green">Ok</button>
        </div>
    </div>


    <script type="text/javascript" src="../_js/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../_js/jquery/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../_js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="../_js/bin/main.js"></script>
</body>

</html>