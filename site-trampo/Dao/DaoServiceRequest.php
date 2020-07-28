<?php 

    class DaoServiceRequest {
        public function insertServiceRequest(ServiceRequest $service_request) {
            include 'conexao.php';
            $query = mysqli_query($conn, "INSERT INTO service_request (id_service, id_user, price, description) 
            VALUES ('".$service_request->getIdService()."', '".$service_request->getIdUser()."', 
            '".$service_request->getPrice()."','".$service_request->getDescription()."')");
        }

        //check if already has a offer from the same user, then overwrite it
        public function checkOverwrite(ServiceRequest $service_request) {
            include 'conexao.php';
            $query = mysqli_query($conn, "SELECT id FROM service_request 
            WHERE id_user = '".$service_request->getIdUser()."' AND id_service = '".$service_request->getIdService()."'");
            return mysqli_fetch_assoc($query);
        }

        public function updateServiceRequest(ServiceRequest $service_request) {
            include 'conexao.php';
            $query = mysqli_query($conn, "UPDATE service_request SET
            price = '".$service_request->getPrice()."',
            description = '".$service_request->getDescription()."'
            WHERE id_user = '".$service_request->getIdUser()."' AND id_service = '".$service_request->getIdService()."'
            ");
        }
    }

?>