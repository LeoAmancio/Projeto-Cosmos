<?php
    class User{
        private $nome;
        private $email;
        private $senha;
        private $cpf;
        private $sexo;
        private $dataNasc;
        private $celular;
        private $cep;
        private $estado;
        private $cidade;
        private $rua;
        private $numero;
        private $bairro;
        private $complemento;
        private $servico;
        private $disponivel;
        private $emailAntigo;
        private $senhaAntiga;
        private $id_user_occupation;
        private $work_info;
        private $latitude;
        private $longitude;

        public function setSenhaAntiga($senhaAntiga){
            $this->senhaAntiga = $senhaAntiga;
           }
        public function getSenhaAntiga() : string{
           return $this->senhaAntiga;
       }
        public function setEmailAntigo(string $emailAntigo){
            $this->emailAntigo = $emailAntigo;
           }
           public function getEmailAntigo() : string{
               return $this->emailAntigo;
           }
        public function setNome(string $nome){
         $this->nome = $nome;
        }
        
        public function getNome() : string{
            return $this->nome;
        }

        public function setEmail(string $email){
            $this->email = $email;
        }
        public function getEmail() : string{
            return $this->email;
        }

        public function setSenha($senha){
            $this->senha = $senha;
           }
        public function getSenha() : string{
           return $this->senha;
       }

        public function setCPF(string $cpf){
            $this->cpf = $cpf;
        }
        public function getCPF() : string{
            return $this->cpf;
        }

        public function setSexo(string $sexo){
            $this->sexo = $sexo;
        }
        public function getSexo() : string{
            return $this->sexo;
        }

        public function setDataNasc(string $dataNasc){
            $this->dataNasc = $dataNasc;
        }
        public function getDataNasc() : string{
            return $this->dataNasc;
        }

        public function setCelular(string $celular){
            $this->celular = $celular;
        }
        public function getCelular() {
            return $this->celular;
        }

        public function setCEP(string $cep){
            $this->cep = $cep;
        }
        public function getCEP() : string{
            return $this->cep;
        }

        public function setEstado(string $estado){
            $this->estado = $estado;
        }
        public function getEstado() : string{
            return $this->estado;
        }

        public function setCidade(string $cidade){
            $this->cidade = $cidade;
        }
        public function getCidade() : string{
            return $this->cidade;
        }

        public function setRua(string $rua){
            $this->rua = $rua;
        }
        public function getRua() : string{
            return $this->rua;
        }

        public function setNumero(int $numero){
            $this->numero = $numero;
        }
        public function getNumero() : int{
            return $this->numero;
        }

        public function setBairro(string $bairro){
            $this->bairro = $bairro;
        }
        public function getBairro() : string{
            return $this->bairro;
        }

        public function setComplemento(string $complemento){
            $this->complemento = $complemento;
        }
        public function getComplemento() : string{
            return $this->complemento;
        }
        public function setServico(string $servico){
            $this->servico = $servico;
           }
       public function getServico(){
           return $this->servico;
       }
       
       public function setDisponivel($disponivel){
            $this->disponivel = $disponivel;
        }

        public function getDisponivel(){
            return $this->disponivel;
        }

        public function setIdUserOccupation(int $id_user_occupation){
            $this->id_user_occupation = $id_user_occupation;
        }
        
        public function getIdUserOccupation() {
            return $this->id_user_occupation;
        }

        public function setWorkInfo(string $work_info){
            $this->work_info = $work_info;
        }

        public function getWorkInfo() {
            return $this->work_info;
        }
        
        public function setLatitude($latitude){
            $this->latitude = $latitude;
        }

        public function getLatitude() {
            return $this->latitude;
        }
        
         public function setLongitude($longitude){
            $this->longitude = $longitude;
        }

        public function getLongitude() {
            return $this->longitude;
        }

        
    }
?>
