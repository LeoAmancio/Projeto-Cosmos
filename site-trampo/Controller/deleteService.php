<?php 

require '../Model/Service.php';
require '../Dao/DaoService.php';

$service = new Service();
$dao_service = new DaoService();

if(!empty($_GET['id_service'])) {
    $service->setId($_GET['id_service']);
    $dao_service->deleteService($service);
    setcookie("successful_deleted", true, time()+3600, '/');
    header("Location: ../../View/Main/progress");
} else {
    setcookie("failed_deleted", true, time()+3600, '/');
    header("Location: ../../View/Main/progress");
}

?>