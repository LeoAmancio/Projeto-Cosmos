<?php
    require "../../../Controller/verifica.php";
    require '../../../Dao/conexao.php';
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
        $changed = false;
        $profile_picture = false;

        if(isset($_GET['changed'])) {
            $changed = true;
        }

        if(isset($_GET['profile_picture'])) {
            $profile_picture = true;
        }


    ?>

    <?php 
        $consulta = "SELECT * FROM user WHERE email = '".$_SESSION['email']."'";
        $res = mysqli_query($conn,$consulta);
        $row = mysqli_fetch_assoc($res);
    ?>


    <header>
        <nav class="nav-extended">
            <div class="nav-wrapper">
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <a href="#!" class="brand-logo center">Conta</a>
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
                <div class="divider"></div>
            </li>
            <li><a class="subheader">Configurações</a></li>
            <li class="active"><a href="" class="waves-effect">Minha conta</a></li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a href="#modalLeave" class="waves-effect modal-trigger"><i
                        class="material-icons">power_settings_new</i>Sair</a></li>
        </ul>


        <!-- Section myAccount -->
        <section class="section-myAccount">
            <form action="../../../Controller/editarUser.php" method="POST">
                <div class="row z-depth-1" style="background:#1e88e54b">
                    <!-- <img class="user-background" src="../_img/user-background.jpg" alt="user background"> -->
                    <div class="user-view">
                        <div class="profile-picture">
                            <img class="circle z-depth-3" src="<?php echo $row['profile_picture']; ?>"
                                alt="user profile picture">
                            <a href="#modalProfilePicture" class="waves-effect waves-light btn modal-trigger"><i
                                    class="material-icons">photo_camera</i></a>
                        </div>
                        <div class="user-info z-depth-2">
                            <h5><?php echo $row['full_name'] ?></h5>
                            <h5><?php echo $row['email'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="row z-depth-1">
                    <div class="col s12">
                        <h5 class="center-align">Informações pessoais</h5>
                    </div>
                    <div class="input-field col s12 m5">
                        <input type="text" id="full_name" value="<?php echo $row['full_name'] ?>" name="name">
                        <label for="full_name">Nome Completo</label>
                    </div>
                    <div class="input-field col s12 m5 offset-m2">
                        <input type="email" id="email" class="validate" value="<?php echo $row['email'] ?>" name="email">
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <input type="text" id="cpf" value="<?php echo $row['cpf'] ?>" name="cpf" readonly="true">
                        <label for="cpf">CPF</label>
                    </div>

                    <div class="input-field col s12 m7 offset-m2">
                        <p>
                            Sexo:
                            <label>
                                <input class="with-gap" type="radio" name="gender" value="M"
                                    <?php echo($row['gender'] == 'M')?'checked':'' ?>>
                                <span>Masculino</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input class="with-gap" type="radio" name="gender" value="F"
                                    <?php echo($row['gender'] == 'F')?'checked':'' ?>>
                                <span>Feminino</span>
                            </label>
                        </p>
                    </div>

                    <div class="col s12 m8 l7">
                        Data de nascimento:
                        <div class="input-field inline">
                            <input type="date" max="1999-12-31" class="center-align"
                                value="<?php echo $row['birth_date'] ?>" name="birth_date">
                        </div>
                    </div>
                    <div class="input-field col s12 m3 offset-m1">
                        <input type="text" id="phone_number" value="<?php echo $row['phone_number'] ?>" name="phone_number">
                        <label for="phone_number">Celular</label>
                    </div>
                </div>
                <div class="row z-depth-1">
                    <div class="col s12">
                        <h5 class="center-align">Endereço</h5>
                    </div>
                    <div class="input-field col s12 m2">
                        <input type="text" id="cep" value="<?php echo $row['cep'] ?>" name="cep">
                        <label for="cep">CEP</label>
                    </div>
                    <div class="input-field col s12 m5 l4 offset-m1 offset-l1">
                        <select id="states" name="state">
                            <option value="<?php echo $row['uf'] ?>" selected><?php echo $row['uf']?> </option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>
                    <div class="input-field col s12 m3 l4 offset-m1 offset-l1">
                        <input type="text" id="street" value="<?php echo $row['address'] ?>" name="address">
                        <label for="street">Rua</label>
                    </div>
                    <div class="input-field col s12 m2 l2">
                        <input type="text" id="number" value="<?php echo $row['home_number'] ?>" name="number">
                        <label for="number">Número</label>
                    </div>
                    <div class="input-field col s12 m5 l4 offset-m1 offset-l1">
                        <input type="text" id="neighborhood" value="<?php echo $row['neighborhood'] ?>" name="neighborhood">
                        <label for="neighborhood">Bairro</label>
                    </div>
                    <div class="input-field col s12 m3 l4 offset-m1 offset-l1">
                        <input type="text" id="adress_complement" value="<?php echo $row['address_complement'] ?>" name="adress_complement">
                        <label for="adress_complement">Complemento</label>
                    </div>
                    
                    <?php
                        $query = mysqli_query($conn, "SELECT id FROM user_occupation WHERE id_user = '".$row['id']."'");
                        $is_worker = false;
                        if(mysqli_num_rows($query) > 0) {
                            $is_worker = true;
                        }

                        if(!$is_worker) {
                    ?>
                    <div class="col s12"></div>
                    <div class="input-field col s6 m1 l1">
                        <a href="#modalDesactiveAccount" class="waves-effect waves-light btn modal-trigger red"><i
                                class="material-icons">delete</i></a>
                    </div>
                    <div class="input-field col s6 m5 l4 offset-m0 offset-l0 center-align">
                        <a href="#modalPassword" class="waves-effect waves-light btn modal-trigger">Alterar senha</a>
                    </div>
                    <div class="input-field col s12 m2 l2 offset-m4 offset-l5 right-align">
                        <button type="submit" class="waves-effect waves-light btn">Salvar</button>
                    </div>
                    <?php
                        }
                    ?>
                </div>

                <?php
                    if($is_worker) {
                ?>
                <div class="row z-depth-1">
                    <div class="col s12">
                        <h5 class="center-align">Informações de trabalho</h5>
                    </div>
                    <div class="input-field col s12 m5">
                        <select multiple id="select-occupation" name="select-occupation[]">
                            <?php 
                                    // select all occupations
                                    $query = mysqli_query($conn, "SELECT * FROM occupation");

                                    //create an array to get the users occupations and an variable to description
                                    $row_check = array();
                                    $description = "";
                                    $query_check = mysqli_query($conn, "SELECT * FROM user_occupation WHERE id_user = '".$row['id']."'"); 
                                    

                                    //add values to the array
                                    while($row = mysqli_fetch_assoc($query_check)) {
                                        array_push($row_check, $row['id_occupation']);
                                        if(!empty($row['description'])) {
                                            $description = $row['description'];
                                        }

                                    }
                                    
                                    //check if the available occupations match the users occupations
                                    $i = 0;
                                    while($row = mysqli_fetch_assoc($query)) {
                                        if(in_array($row['id'], $row_check)) {
                                            echo "<option value='".$row['id']."' selected>".$row['name']."</option>";
                                        } else {
                                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                        }
                                        $i++;
                                    }
                                ?>
                        </select>
                        <label>Atuo com/como:</label>
                    </div>

                    <div class="input-field col s12 m5 offset-m2">
                        <textarea class="materialize-textarea" id="work-info" name="work_info"><?php echo $description ?></textarea>
                        <label for="work-info">Informações adicionais</label>
                    </div>
                    <div class="col s12"></div>
                    <div class="input-field col s6 m1 l1">
                        <a href="#modalDesactiveAccount" class="waves-effect waves-light btn modal-trigger red"><i
                                class="material-icons">delete</i></a>
                    </div>
                    <div class="input-field col s6 m5 l4 offset-m0 offset-l0 center-align">
                        <a href="#modalPassword" class="waves-effect waves-light btn modal-trigger">Alterar senha</a>
                    </div>
                    <div class="input-field col s12 m2 l2 offset-m4 offset-l5 right-align">
                        <button type="submit" class="waves-effect waves-light btn">Salvar</button>
                    </div>
                </div>
                <?php
                    }
                ?>
            </form>
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

    <!-- Modal password -->
    <div class="modal" id="modalPassword">
        <div class="modal-content">
            <h4 class="center-align hide-on-small-only">Alterar senha</h4>
            <h5 class="center-align hide-on-med-and-up">Alterar senha</h5>
            <br>
            <form action="#" class="row">
                <div class="input-field col s12">
                    <input type="password" id="old-password">
                    <label for="old-password">Senha atual</label>
                </div>
                <div class="input-field col s12">
                    <input type="password" id="new-password">
                    <label for="old-password">Nova senha</label>
                </div>
                <div class="input-field col s12">
                    <input type="password" id="confirm-password">
                    <label for="confirm-password">Confirmar senha</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col s12 m3 l2 offset-m6 offset-l7 center-align">
                    <a href="#!" class="btn-flat modal-close waves-light">Cancelar</a>
                </div>
                <div class="col s12 m3 center-align">
                    <a href="#!" class="btn modal-close waves-effect waves-light">Salvar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- modal desactive account -->
    <div class="modal" id="modalDesactiveAccount">
        <div class="modal-content">
            <h5 class="center-align hide-on-med-and-up">Deseja desativar sua conta?</h5>
            <h4 class="center-align hide-on-small-only">Deseja desativar sua conta?</h4>
        </div>
        <div class="modal-footer">
            <a href="#" class="modal-close waves-effect btn-flat">Sim</a>
            <button class="modal-close waves-effect btn">Não</button>
        </div>
    </div>

    <!-- Modal profile picture -->
    <div class="modal" id="modalProfilePicture">
        <div class="modal-content">
            <h5 class="center-align">Alterar foto do perfil</h5>
            <div class="divider"></div>
            <br>
            <form action="../../../Controller/storeImage.php" method="POST" enctype="multipart/form-data"
                id="form-profilePicture">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Enviar</span>
                        <input type="file" accept="image/*"
                            onchange="document.getElementById('demo-user-profile-picture').src = window.URL.createObjectURL(this.files[0])"
                            name="image" id="img-profilePicture" required>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <h6 class="center-align">Para que a sua foto de perfil fique ajustada, é necessário um tamanho de
                    200x200</h6>
                <br>
                <div class="row center-align">
                    <img src="../_img/background/placeholder-200x200.png" class="center-align circle z-depth-1"
                        id="demo-user-profile-picture">
                </div>
                <div class="row">
                    <div class="col s12 m6 center-align">
                        <button type="button" class="btn-flat waves-effect modal-close">Fechar</button>
                    </div>
                    <div class="col s12 space hide-on-med-and-up"></div>
                    <div class="col s12 m6 center-align">
                        <button type="submit" class="btn waves-effect waves-light" name="submit">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="../_js/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../_js/jquery/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../_js/bin/materialize.min.js"></script>
    <script type="text/javascript" src="../_js/bin/main.js"></script>
    <script type="text/javascript">

    document.addEventListener('DOMContentLoaded', function() {
        var changed = "<?php echo $changed ?>";
        var profile_picture = "<?php echo $profile_picture ?>";
        if (changed) {
            M.toast({html: 'Alterações salvas!'});
        }

        if (profile_picture) {
            M.toast({html: 'Foto alterada!'});
        }

    }, false);

    </script>
</body>

</html>