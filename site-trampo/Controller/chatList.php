<?php
    require_once '../Dao/conexao.php';

    $id_user = $_POST['id_user'];
    
    //who is the people that the users session is talking
    $id_user_to = null;

    $query = mysqli_query($conn, "SELECT * FROM message m JOIN conversation c ON c.id = m.conversation WHERE m.id IN ( SELECT MAX(ID) FROM message WHERE m.id_user_from = '".$id_user."' OR m.id_user_to = '".$id_user."' GROUP BY conversation) GROUP BY m.conversation");

    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            if($row['id_user_1'] != $id_user) {
                $id_user_to = $row['id_user_1'];
            } else {
                $id_user_to = $row['id_user_2'];
            };
            $query_user_to = mysqli_query($conn, "SELECT id, full_name FROM user WHERE id = '".$id_user_to."'");
            $row_user_to = mysqli_fetch_assoc($query_user_to);
            echo "
            <a href='../chatMessage?id_user_from=".$id_user."&id_user_to=".$row_user_to['id']."&name_user_to=".$row_user_to['full_name']."&id_conversation=".$row['conversation']."' class='black-text'>
                <div class='divider'></div>
                <div class='boxConversation waves-effect'>
                    <div>
                        <p>";
                        echo $row_user_to['full_name'];
                        echo "
                        </p>
                        <h6>"; echo(strpos($row['text'], "</a>") !== false)?'Olá, gostaria de lhe contratar! Clique aqui para acessar meu serviço':$row['text']; echo "</h6>
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