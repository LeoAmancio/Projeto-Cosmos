<?php

class daoUser
{

    public function cadastrarUser(User $user)
    {
        include 'conexao.php';
        $verifica = mysqli_query($conn, "SELECT email FROM user WHERE email = '" . $user->getEmail() . "' ");
        $linha = mysqli_num_rows($verifica);
        if ($linha > 0) {
            header("Location: ../View/Error/UsuarioJaCadastrado");
        } else {
            $query = "INSERT INTO user(full_name, email, password, birth_date,
                 gender, cpf, uf, city, address, neighborhood,
                  home_number, address_complement, cep,lat,lon, phone_number)
                            values('" . $user->getNome() . "', '" . $user->getEmail() . "',
                             '" . $user->getSenha() . "', '" . $user->getDataNasc() . "',
                              '" . $user->getSexo() . "', '" . $user->getCPF() . "',
                               '" . $user->getEstado() . "', '" . $user->getCidade() . "',
                                '" . $user->getRua() . "', '" . $user->getBairro() . "',
                                 '" . $user->getNumero() . "', '" . $user->getComplemento() . "', 
                                 '" . $user->getCep() . "',
                                 '" . $user->getLatitude() . "',
                                 '" . $user->getLongitude() . "',
                                 '" . $user->getCelular() . "')";

            $insert = mysqli_query($conn, $query);
            if ($insert) {
                setcookie("registered_user", true, time()+3600, '/');
                header("Location: ../View/TelaLogin/");
            } else {
                header("Location: ../View/Error/DadosInvalidos");
            }
        }
    }

    public function logarUser(User $user)
    {
        include 'conexao.php';
        $verifica = mysqli_query($conn, "SELECT email FROM user WHERE email = '" . $user->getEmail() . "' and password = '" . $user->getSenha() . "' ");
        $linha = mysqli_num_rows($verifica);
        if ($linha > 0) {
            session_start();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['senha'] = $user->getSenha();
            header("Location: ../View/Main/progress");
        } else {
            header("Location: ../View/Error/DadosInvalidos");
        }
    }

    public function editarUser(User $user, $occupation, $work_info)
    {
        include 'conexao.php';

        $editar = mysqli_query($conn, 
        "UPDATE user SET 
        full_name = '".$user->getNome()."',
        email = '".$user->getEmail()."',
        cpf = '".$user->getCPF()."',
        gender = '".$user->getSexo()."',
        birth_date = '".$user->getDatanasc()."',
        phone_number = '".$user->getCelular()."',
        cep = '".$user->getCep()."',
        uf = '".$user->getEstado()."',
        address = '".$user->getRua()."',
        home_number = '".$user->getNumero()."',
        neighborhood = '".$user->getBairro()."',
        address_complement = '".$user->getComplemento()."'
        WHERE email = '".$user->getEmailAntigo()."'
        ");

        $delete_occupation = mysqli_query($conn, 
        "DELETE FROM user_occupation 
        WHERE id_user IN (SELECT id FROM user WHERE email LIKE '".$user->getEmail()."')");
        $this->becomeWorker($user->getEmail(), $occupation, $work_info);
        

        if ($editar > 0) {
            unset($_SESSION['email']);
            $_SESSION['email'] = $user->getEmail();
            header("Location: ../View/Main/myAccount/?changed");
        } else {
            header("Location: ../View/TelaLogin");
        }
    }

    public function editarSenhaUser(User $user)
    {
        include 'conexao.php';
        $verifica = mysqli_query($conn, "SELECT password FROM user WHERE email = '" . $user->getEmail() . "' ");
        $linha = mysqli_fetch_assoc($verifica);
        if ($linha['password'] != $user->getSenhaAntiga()) {
            header("Location: ../View/userJaCadastrado/index.html");
        } else {
            $editar = mysqli_query($conn, "UPDATE user SET password = '" . $user->getSenha() . "' WHERE email = '" . $user->getemail() . "'");
            if ($editar > 0) {
                unset($_SESSION['senha']);
                $_SESSION['senha'] = $user->getSenha();
                header("Location: ../View/SISTEMA/PRESTADOR/");
            } else {
                header("Location: ../View/TelaLogin");
            }
        }
    }

    public function passwordRecovery($email, $senha)
    {
        include 'conexao.php';
        $editar = mysqli_query($conn, "UPDATE user SET password = '" .$senha. "' WHERE email = '" .$email. "'");
        if ($editar > 0) {
            unset($_SESSION['senha']);
            $_SESSION['senha'] = $user->getSenha();
            header("Location: ../View/SISTEMA/PRESTADOR/");
        } else {
            header("Location: ../View/TelaLogin");
        }
    }

    public function excluirUser(User $user)
    {
        include 'conexao.php';
        $excluir = mysqli_query($conn, "DELETE FROM user full_name email = '" . $user->getEmail() . "' ");

        if ($excluir > 0) {
            header("Location: ../View/TelaLogin/index.html");
        } else {
            echo ("Erro ao excluir nome ou senha incorretos");
        }
    }

    public function RecuperaSenha(User $user)
    {
        include 'conexao.php';
        $recuperar = mysqli_query($conn, "UPDATE user SET password = '{$user->getSenha()}' WHERE  email = '{$user->getEmail()}'");
        if ($recuperar > 0) {
            header("Location: ../View/TelaLogin/index.html");
        } else {
            echo ("Erro ao recuperar nome ou senha incorretos");
        }
    }

    public function verificaContaUser(string $email): string
    {
        include 'conexao.php';
        $verifica = mysqli_query($conn, "SELECT email FROM user WHERE email = '" . $email . "' ");
        $linha = mysqli_num_rows($verifica);
        if ($linha > 0) {
            $retorno = "user";
        } else {
            $retorno = "null";
        }

        return $retorno;
    }

    public function becomeWorker($email, $occupation_id, $work_info)
    {
        include 'conexao.php';
        $query = mysqli_query($conn, "SELECT id FROM user WHERE email LIKE '" . $email . "'");
        $row = mysqli_fetch_assoc($query);
        $user_id = $row['id'];
        foreach ($occupation_id as $occupation) {
            $query = mysqli_query($conn, "INSERT INTO user_occupation(description, id_occupation, id_user) VALUES('".$work_info."','" . $occupation . "', '" . $user_id . "')");
        }
    }
    
}
