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
    ?>
    <input type="hidden" value="<?php echo $row['id'] ?>" id="id_user">

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
                    <a href="#user"><img class="circle z-depth-1" src="<?php echo $row['profile_picture']; ?>" alt="user profile picture"></a>
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
            <li class="active"><a href="" class="waves-effect"><i class="material-icons">chat</i>Chat</a>
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
            <h5 class="center-align">Conversas recentes</h5>
            <div class="conversations">
            <?php
            //who is the people that the users session is talking
            $id_user_to = null;

            $query = mysqli_query($conn, "SELECT * FROM message m JOIN conversation c ON c.id = m.conversation WHERE m.id IN ( SELECT MAX(ID) FROM message WHERE m.id_user_from = '".$row['id']."' OR m.id_user_to = '".$row['id']."' GROUP BY conversation) GROUP BY m.conversation");

            if(mysqli_num_rows($query) > 0){
                while($row_message = mysqli_fetch_assoc($query)){
                    if($row_message['id_user_1'] != $row['id']) {
                        $id_user_to = $row_message['id_user_1'];
                    } else {
                        $id_user_to = $row_message['id_user_2'];
                    };
                    $query_user_to = mysqli_query($conn, "SELECT id, full_name FROM user WHERE id = '".$id_user_to."'");
                    $row_user_to = mysqli_fetch_assoc($query_user_to);
                    echo "
                    <a href='../chatMessage?id_user_from=".$row['id']."&id_user_to=".$row_user_to['id']."&name_user_to=".$row_user_to['full_name']."&id_conversation=".$row_message['conversation']."' class='black-text'>
                    <div class='divider'></div>
                        <div class='boxConversation waves-effect'>
                            <div>
                                <p>";
                                echo $row_user_to['full_name'];
                                echo "
                                </p>
                                <h6>"; echo(strpos($row_message['text'], "</a>") !== false)?'Olá, gostaria de lhe contratar! Clique aqui para acessar meu serviço':$row_message['text']; echo " </h6>
                            </div>
                        </div>
                    </a>
                    ";
                }
            } else {
                echo "
                <div class='divider'></div>
                <br><br>
                <div class='row center-align'>
                    <div class='col s12 m6 offset-m3'>
                        <img src='../_img/icon/dislike.svg' width='100'>
                    </div>
                    <div class='col s12 m6 offset-m3'><h6>Você não tem nenhuma conversa, <a href='../hire'>contrate</a> ou <a href='../work'>preste um serviço</a> para iniciar uma conversa</h6></div>
                </div>
                ";
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


    <script type="text/javascript" src="../_js/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../_js/jquery/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../_js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="../_js/bin/main.js"></script>
</body>

</html>