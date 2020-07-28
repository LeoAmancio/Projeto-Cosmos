<?php

    require_once '../Dao/conexao.php';
    
    if(!empty($_POST['text_message'])) {
        $query = mysqli_query($conn, "INSERT INTO message (conversation, id_user_from, id_user_to, text) 
        VALUES (".$_POST['id_conversation'].", ".$_POST['id_user_from'].", ".$_POST['id_user_to'].",
        '".$_POST['text_message']."') ");
    }

?>

<script>
    document.querySelector(".conversation #text-message").value = "";
</script>