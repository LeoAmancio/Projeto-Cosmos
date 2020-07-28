<?php
    require_once '../Dao/conexao.php';
    
    $new_message = 0;

    $query = mysqli_query($conn, "SELECT * FROM message WHERE conversation = '".$_POST['id_conversation']."'");
    
    $num_rows = mysqli_num_rows($query);

    if(empty($_POST['new_message'])) {
        $new_message = $num_rows;
    } else if($new_message < $num_rows) {
        $new_message = $num_rows;
    }

    while ($row = mysqli_fetch_assoc($query)) {
        if($row['id_user_from'] == $_POST['id_user_from']) {
            echo "<div class='message message-right z-depth-2'>".$row['text']."</div>";
        } else {
            echo "<div class='message message-left z-depth-2'>".$row['text']."</div>";
        }
    }
    
?>

<script>
    var new_message = <?php echo $new_message; ?>;
    if(new_message > document.querySelector("#new_message").value) {
        var elem = document.querySelector(".conversation .conversation-content");
        elem.scrollTop = elem.scrollHeight;
        document.querySelector("#new_message").value = new_message;
    } else {
    }
</script>
