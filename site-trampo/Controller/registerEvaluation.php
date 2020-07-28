<?php 

require("../Dao/DaoEvaluation.php");
$dao_evaluation = new DaoEvaluation();

require("../Model/Evaluation.php");
$evaluation = new Evaluation();

//check if the variables exist and if they are diffrent from null
if(isset($_POST['answer_1'], $_POST['answer_2'], $_POST['answer_3'], $_POST['further_information'], 
$_POST['stars_rating'], $_GET['id_user_from'], $_GET['id_user_to'], $_GET['id_service']) && $_POST['answer_1'] 
&& $_POST['answer_2'] && $_POST['answer_3'] && $_POST['stars_rating'] &&
$_GET['id_user_from'] && $_GET['id_user_to'] && $_GET['id_service']) {

    $evaluation->setAnswer1($_POST['answer_1']);
    $evaluation->setAnswer2($_POST['answer_2']);
    $evaluation->setAnswer3($_POST['answer_3']);
    $evaluation->setFurtherInformation($_POST['further_information']);
    $evaluation->setStarsRating($_POST['stars_rating']);
    $evaluation->setIdUserFrom($_GET['id_user_from']);
    $evaluation->setIdUserTo($_GET['id_user_to']);
    $evaluation->setIdService($_GET['id_service']);
    
    $dao_evaluation->registerEvaluation($evaluation);

    setcookie("successful_evaluation", true, time()+3600, '/');
    header("Location: ../View/Main/progress");
} else {
    setcookie("failed_evaluation", true, time()+3600, '/');
    header("Location: ../View/Main/hirerRating/?id_user_from=".$_GET['id_user_from']."&id_user_to=".$_GET['id_user_to']."&id_service=".$_GET['id_service']);
}

?>