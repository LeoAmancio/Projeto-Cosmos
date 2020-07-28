<?php

    class ServiceRequest {
        private $id_service;
        private $id_user;
        private $price;
        private $description;

        public function setIdService($id_service) {
            $this->id_service = $id_service;
        }

        public function getIdService() {
            return $this->id_service;
        }

        public function setIdUser($id_user) {
            $this->id_user = $id_user;
        }

        public function getIdUser() {
            return $this->id_user;
        }

        public function setPrice($price) {
            $this->price = $price;
        }

        public function getPrice() {
            return $this->price;
        }

        public function setDescription($description) {
            $this->description = $description;
        }

        public function getDescription() {
            return $this->description;
        }

    }
?>