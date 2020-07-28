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
        $res = mysqli_query($conn, $consulta);
        $row = mysqli_fetch_assoc($res);
    ?>

    <header>
        <nav class="nav-extended">
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
                    <a href="#user"><img class="circle z-depth-1" src="<?php echo $row['profile_picture']; ?>" alt="user profile picture"></a>
                    <div class="user-info">
                        <a href="#name"><span class="black-text name"><?php echo $row['full_name'] ?></span></a>
                        <a href="#email"><span class="black-text email"><?php echo $row['email'] ?></span></a>
                    </div>
                </div>
            </li>
            <li><a href="../progress" class="waves-effect"><i class="material-icons">cached</i>Em
                    progresso</a></li>
            <li class="active"><a href="" class="waves-effect"><i
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

        <!-- Section HIRE and yours tabs -->

        <section class="section-hire">
            <div class="container">
                <div class="search-service">
                    <form action="#" id="form-search">
                        <br>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">search</i>
                                <input type="text" id="search-bar">
                                <label for="search-bar" class="noselect" id="label-search-bar">Digite o serviço que procura</label>
                                <div class="collection z-depth-2">
                                    <?php
                                        $query = mysqli_query($conn, "SELECT id, name FROM occupation_subcategory");
                                        while($row = mysqli_fetch_assoc($query)) {
                                            echo "<a href='../requestService?occupation_subcategory=".$row['id']."' class='collection-item'>".$row['name']."</a> ";
                                        }
                                    ?>
                                    <a href="#" class="collection-item">Pedido personalizado</a>
                                </div>

                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <h4 class="center-align hire-title grey-text text-darken-3">Serviços Populares</h4>
                    </div>
                    <div class="row popular-services">
                        <a href="../requestService?occupation_subcategory=43">
                            <div class="col s12 m4 l4">
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="../_img/workers/fretes.webp" alt="card image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title black-text">Fretes</span>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="../requestService?occupation_subcategory=46">
                            <div class="col s12 m4 l4">
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="../_img/workers/confeiteira.jpg" alt="card image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title black-text">Confeitaria</span>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="../requestService?occupation_subcategory=24">
                            <div class="col s12 m4 l4">
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="../_img/workers/encanador.jpg" alt="card image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title black-text">Encanador</span>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="../requestService?occupation_subcategory=47">
                            <div class="col s12 m4 l4">
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="../_img/workers/pedreiro.jpg" alt="card image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title black-text">Pedreiro</span>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="../requestService?occupation_subcategory=15">
                            <div class="col s12 m4 l4">
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="../_img/workers/eletricista.jpg" alt="card image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title black-text">Eletricista</span>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="../requestService?occupation_subcategory=48">
                            <div class="col s12 m4 l4">
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="../_img/workers/mecanico.jpg" alt="card image">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title black-text">Mecânico</span>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </a>

                    <div class="row result"></div>

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