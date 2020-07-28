<?php
    class Service {
        private $id;
        private $id_occupation_subcategory;
        private $time_remaining;
        private $title;
        private $description;
        private $picture;
        private $is_visible;
        private $id_user;
        private $status;

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setIdOccupationSubcategory($id_occupation_subcategory) {
            $this->id_occupation_subcategory = $id_occupation_subcategory;
        }

        public function getIdOccupationSubcategory() {
            return $this->id_occupation_subcategory;
        }

        public function setTimeRemaining($time_remaining) {
            $this->time_remaining = $time_remaining;
        }

        public function getTimeRemaining() {
            return $this->time_remaining;
        }

        public function setTitle($title) {
            $this->title = $title;
        }

        public function getTitle() {
            return $this->title;
        }

        public function setDescription($description) {
            $this->description = $description;
        }

        public function getDescription() {
            return $this->description;
        }

        public function setPicture($picture) {
            $this->picture = $picture;
        }

        public function getPicture() {
            return $this->picture;
        }

        public function setIsVisible($is_visible) {
            $this->is_visible = $is_visible;
        }

        public function getIsVisible() {
            return $this->is_visible;
        }

        public function setIdUser($id_user) {
            $this->id_user = $id_user;
        }

        public function getIdUser() {
            return $this->id_user;
        }

        public function setStatus($status) {
            $this->status = $status;
        }

        public function getStatus() {
            return $this->status;
        }

    }

?>