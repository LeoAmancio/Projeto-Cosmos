<?php

    class Evaluation {
        private $answer_1;
        private $answer_2;
        private $answer_3;
        private $further_information;
        private $stars_rating;
        private $id_user_from;
        private $id_user_to;
        private $id_service;

        public function setAnswer1($answer_1) {
            $this->answer_1 = $answer_1;
        }

        public function getAnswer1() {
            return $this->answer_1;
        }

        public function setAnswer2($answer_2) {
            $this->answer_2 = $answer_2;
        }

        public function getAnswer2() {
            return $this->answer_2;
        }

        public function setAnswer3($answer_3) {
            $this->answer_3 = $answer_3;
        }

        public function getAnswer3() {
            return $this->answer_3;
        }

        public function setFurtherInformation($further_information) {
            $this->further_information = $further_information;
        }

        public function getFurtherInformation() {
            return $this->further_information;
        }

        public function setStarsRating($stars_rating) {
            $this->stars_rating = $stars_rating;
        }

        public function getStarsRating() {
            return $this->stars_rating;
        }

        public function setIdUserFrom($id_user_from) {
            $this->id_user_from = $id_user_from;
        }

        public function getIdUserFrom() {
            return $this->id_user_from;
        }

        public function setIdUserTo($id_user_to) {
            $this->id_user_to = $id_user_to;
        }

        public function getIdUserTo() {
            return $this->id_user_to;
        }

        public function setIdService($id_service) {
            $this->id_service = $id_service;
        }

        public function getIdService() {
            return $this->id_service;
        }

    }

?>