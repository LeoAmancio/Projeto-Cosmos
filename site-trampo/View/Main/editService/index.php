<?php
    require("../../../Controller/verifica.php");
    include_once '../../../Dao/conexao.php';

    //check if there is cookie, then pass it to the javascript for the toast message
    $toast = null;
    if(isset($_COOKIE['successful_edit'])) {
        $toast = "Serviço editado com sucesso!";
        setcookie("successful_edit", false, time()+3600, '/');
    } else if(isset($_COOKIE['failed_edit'])) {
        $toast = "É obrigatório preencher todos os dados!";
        setcookie("failed_edit", false, time()+3600, '/');
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

    <!-- verify the required variables  -->
    <?php
        if(!isset($_GET['occupation_subcategory'], $_GET['id_service'])) {
            header("Location: ../hire");
        }

    ?>

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
                <a href="#!" class="brand-logo center">Editar</a>
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

        <?php
        //get service information
        $query = mysqli_query($conn, "SELECT * FROM service WHERE service.id = '".$_GET['id_service']."'");
        $row = mysqli_fetch_assoc($query);
        if($row['id_user'] != $id_user) {header("Location: ../progress");}
        ?>

        <section class="section-hire">
            <div class="blue-background"></div>
            <div class="container z-depth-1">
                <form
                    action="../../../Controller/editService.php/?id_occupation_subcategory=<?php echo $_GET['occupation_subcategory'];?>&id_service=<?php echo $row['id'] ?>"
                    method="POST" class="row padding white" enctype="multipart/form-data" autocomplete="off">
                    <a href="../hire" class="btn circle waves-effect waves-light"><i
                            class="material-icons">arrow_back</i></a>
                    <div class="col s12">
                        <br class="hide-on-med-and-up">
                        <h5 class="center-align">Alterar meu serviço</h5>
                    </div>

                    <!-- get occupation name -->
                    <?php
                        $query_occupation = mysqli_query($conn, "SELECT name FROM occupation_subcategory WHERE id = '".$_GET['occupation_subcategory']."'");
                        $row_occupation = mysqli_fetch_assoc($query_occupation); 
                    ?>


                    <div class="input-field col s12">
                        <input disabled type="text" id="professional" value="<?php echo $row_occupation['name'] ?>"
                            name="professional">
                        <label for="professional">Serviço</label>
                    </div>
                    <div class="input-field col s12">
                        <select name="time-remaining" id="time-remaining">
                            <option value="O quanto antes" <?php echo ($row['time_remaining'] == "O quanto antes")?'selected':'' ?> >O quanto antes</option>
                            <option value="A próxima semana" <?php echo ($row['time_remaining'] == "A próxima semana")?'selected':'' ?>>A próxima semana</option>
                            <option value="Duas semanas" <?php echo ($row['time_remaining'] == "Duas semanas")?'selected':'' ?>>Duas semanas</option>
                            <option value="Sem previsão" <?php echo ($row['time_remaining'] == "Sem previsão")?'selected':'' ?>>Sem previsão</option>
                        </select>
                        <label>Para quando é o serviço?*</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" id="service-title" name="service-title" required value="<?php echo $row['title'] ?>">
                        <label for="service-title">Título do serviço*</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="service-description" class="materialize-textarea" data-length="200"
                            maxlength="200" name="service-description" required><?php echo $row['description'] ?></textarea>
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
                                    placeholder="Clique para alterar a foto (200x200)">
                            </div>
                        </div>
                    </div>
                    <!-- inserir onchange function -->
                    <div class="col s12 m6 offset-m3 center-align">
                        <img src="<?php echo ($row['picture'])?$row['picture']:'../_img/icon/tools.png' ?>" class="center-align z-depth-2" id="demo-service-picture">
                    </div>

                    <div class="input-field col s12">
                        <p>
                            <label>
                                <input type="checkbox" id="visible-agreement" name="visible-agreement" <?php echo ($row['is_visible'])?'checked':'' ?>>
                                <span class="black-text">Permitir que meu pedido seja visto por prestadores (Poderei
                                    receber propostas)</span>
                            </label>
                        </p>
                    </div>
                    <div id="form-message"></div>
                    <div class="input-field col s6">
                        <a href="#modal-delete-service" class="btn waves-effect waves-light red modal-trigger">
                            <i class="material-icons">delete</i>
                        </a>
                    </div>
                    <div class="input-field col s6 right-align">
                        <button type="submit" class="btn waves-effect waves-light">Salvar alterações</button>
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

    <!-- Modal delete service -->
    <div class="modal" id="modal-delete-service">
        <div class="modal-content row">
            <div class="col s12">
                <h4 class="center-align hide-on-small-only">Tem certeza?</h4>
                <h5 class="center-align hide-on-med-and-up"><strong>Tem certeza?</strong></h5>
            </div>
            <div class="col s12">
                <h6 class="justify-align">
                    Clicando em <span class="red-text text-darken-3"><b>Excluir</b></span> você irá deletar
                    permanentemente o seu serviço, e não haverá forma de recuperar, será necessário
                    criar outro. Tenha total certeza antes.
                </h6>
            </div>
        </div>
        <div class="modal-footer row">
            <div class="col s6 center-align">
                <button class="modal-close btn-flat waves-effect waves-light">Cancelar</button>
            </div>
            <div class="col s6 center-align">
                <a href="../../../Controller/deleteService.php/?id_service=<?php echo $row['id']; ?>" 
                class="btn waves-effect waves-light red">
                    Excluir
                </a>
            </div>
        </div>
    </div>



    <script type="text/javascript" src="../_js/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../_js/jquery/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../_js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="../_js/bin/main.js"></script>
    <script type="text/javascript">
    var toast = "<?php echo $toast; ?>";

    document.addEventListener('DOMContentLoaded', function() {
        if(toast) {
            M.toast({
                html: toast
            });
        }
    });
    </script>
</body>

</html>