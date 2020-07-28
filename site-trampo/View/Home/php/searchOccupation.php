<?php
    include '../../../Dao/conexao.php';

    $suggestion = $_POST['suggestion'];
    $value = false;

    if(!empty($suggestion)) {
        $query = mysqli_query($conn, "SELECT id, name FROM occupation_subcategory");

        while($row = mysqli_fetch_assoc($query)) {
            if(stripos($row['name'],$suggestion) !== false) {
                echo "<a href='../TelaLogin' class='collection-item'>".$row['name']."</a>";
                $value = true;
            }
        }

        if($value == false) {
            echo "<a href='#' class='collection-item'>Pedido personalizado</a>";
        }

    } else {
        $query = mysqli_query($conn, "SELECT * FROM occupation_subcategory");
        while($row = mysqli_fetch_assoc($query)) {
            echo "<a href='../TelaLogin' class='collection-item'>".$row['name']."</a> ";
        }
    }


?>
