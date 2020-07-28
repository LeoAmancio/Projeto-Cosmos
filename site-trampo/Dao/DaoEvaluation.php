<?php 

class DaoEvaluation {
    public function registerEvaluation(Evaluation $evaluation) {
        include 'conexao.php';
        
        $query = mysqli_query($conn, 
        "INSERT INTO evaluation (answer_1, answer_2, answer_3, further_information, 
        stars_rating, id_user_from, id_user_to, id_service)
        VALUES ('".$evaluation->getAnswer1()."', '".$evaluation->getAnswer2()."', 
        '".$evaluation->getAnswer3()."', '".$evaluation->getFurtherInformation()."',
        '".$evaluation->getStarsRating()."', '".$evaluation->getIdUserFrom()."',
        '".$evaluation->getIdUserTo()."', '".$evaluation->getIdService()."')");
        
    }
}

?>