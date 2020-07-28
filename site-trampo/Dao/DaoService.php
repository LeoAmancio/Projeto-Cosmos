<?php

    class DaoService {
        public function cadastrarService(Service $service) {
            include 'conexao.php';
            
            //check if there is a image for the service, otherwise, it will have a default image on database   
            if(!empty($service->getPicture())) {
                $query = "INSERT INTO service
                (time_remaining, title, description, picture, is_visible, id_occupation_subcategory, id_user, 
                status, who_finished, is_finished, issue_finished) 
                VALUES ('".$service->getTimeRemaining()."','".$service->getTitle()."',
                '".$service->getDescription()."','".$service->getPicture()."','".$service->getIsVisible()."',
                '".$service->getIdOccupationSubcategory()."', '".$service->getIdUser()."', '".$service->getStatus()."', 
                null, 0, 0)";      
            } else {
                $query = "INSERT INTO service(time_remaining, title, description, is_visible, id_occupation_subcategory, 
                id_user, status, who_finished, is_finished, issue_finished) 
                VALUES ('".$service->getTimeRemaining()."','".$service->getTitle()."',
                '".$service->getDescription()."','".$service->getIsVisible()."', 
                '".$service->getIdOccupationSubcategory()."', '".$service->getIdUser()."', 
                '".$service->getStatus()."', null, 0, 0)";
            }
            $insert = mysqli_query($conn, $query);
        }

        public function getLastRegisteredId() {
            include 'conexao.php';
            $last_id = mysqli_query($conn, "SELECT MAX(id) FROM service");
            return mysqli_fetch_assoc($last_id);
        }

        public function editService(Service $service) {
            include 'conexao.php';
 
            if(!empty($service->getPicture())) {
                $query = mysqli_query($conn, 
                "UPDATE service SET 
                service.id_occupation_subcategory = '".$service->getIdOccupationSubcategory()."',
                service.time_remaining = '".$service->getTimeRemaining()."',
                service.title = '".$service->getTitle()."',
                service.description = '".$service->getDescription()."',
                service.picture = '".$service->getPicture()."',
                service.is_visible = '".$service->getIsVisible()."'

                WHERE service.id = '".$service->getId()."' ");
            } else {
                $query = mysqli_query($conn, 
                "UPDATE service SET 
                service.id_occupation_subcategory = '".$service->getIdOccupationSubcategory()."',
                service.time_remaining = '".$service->getTimeRemaining()."',
                service.title = '".$service->getTitle()."',
                service.description = '".$service->getDescription()."',
                service.is_visible = '".$service->getIsVisible()."'

                WHERE service.id = '".$service->getId()."' ");
            }
        }

        public function deleteService(Service $service) {
            include 'conexao.php';

            $query = mysqli_query($conn, "DELETE FROM service WHERE id = '".$service->getId()."'");
        } 

    }

?>