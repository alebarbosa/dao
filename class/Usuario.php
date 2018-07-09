<?php
    class Usuario{
        private $idusuario, $deslogin, $dessenha, $dtcadastro; 
        public function getIdusuario(){
            return $this->idusuario;
        }
        public function setIdusuario($value){
            $this->idusuario = $value;
        }
        public function getDeslogin(){
            return $this->deslogin;
        }
        public function setDeslogin($value){
            $this->deslogin = $value;
        }
        public function getDessenha(){
            return $this->dessenha;
        }
        public function setDessenha($value){
            $this->dessenha = $value;
        }
        public function getDtcadastro(){
            return $this->dtcadastro;
        }
        public function setDtcadastro($value){
            $this->dtcadastro = $value;
        }

        public function setData($data){
            $this->setIdusuario($data['idusuario']);
            $this->setDeslogin($data['deslogin']);
            $this->setDessenha($data['dessenha']);
            $this->setDtcadastro(new DateTime($data['dtcadastro']));
        }


        public function insert(){
            $sql = new Sql();
            $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
                ':LOGIN'=>$this->getDeslogin(),
                ':PASSWORD'=>$this->getDessenha()
            ));

            if(count($results) > 0){
                $this->setData($results[0]);
            }
        }

        public function delete(){
            $sql = new Sql();
            $sql->query("DELETE FROM tb_usuarios where idusuario = :ID", array(
                ':ID'=>$this->getIdusuario()
            ));

            $this->setIdusuario(0);
            $this->setDessenha("");
            $this->setDeslogin("");
            $this->setDtcadastro(new DateTime());
        }
        
        public function update($login, $senha){
            $sql = new Sql();

            $this->setDeslogin($login);
            $this->setDessenha($senha);

            $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
                ":LOGIN"=>$this->getDeslogin(),
                ":PASSWORD"=>$this->getDessenha(),
                ":ID"=>$this->getIdusuario()
            ));
        }

        public function login($login, $senha){
            $sql=new Sql();

            $results = $sql->select("SELECT * FROM tb_usuarios where deslogin = :LOGIN and dessenha = :SENHA", array(
                ":LOGIN"=>$login,
                ":SENHA"=>$senha
            ));
            
            if(count($results) > 0){

                $row = $results[0];
                $this->setData($results[0]);
            }else{
                throw new Exception("Login e/ou senha invalidos!");
            }
        }
        public static function search($login){
            $sql = new Sql();
            return $sql->select("SELECT * FROM tb_usuarios where deslogin LIKE :SEARCH order by deslogin", array(
                ':SEARCH'=>"%$login%"
            ));
        }
        public static function getList(){
            $sql = new Sql();
            $results = $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

            return $results;

        }
        public function loadById($id){

            $sql=new Sql();

            $results = $sql->select("SELECT * FROM tb_usuarios where idusuario = :ID", array(
                ":ID"=>$id
            ));
            
            if(count($results) > 0){

                $row = $results[0];

                $this->setData($results[0]);
            }
        }



        //METODOS ESPECIAIS
        public function __toString(){
            return json_encode(array(
                "idusuario"=>$this->getIdusuario(),
                "deslogin"=>$this->getDeslogin(),
                "dessenha"=>$this->getDessenha(),
                "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
            ));
        }
        public function __construct($login = "", $senha = ""){
            $this->setDeslogin($login);
            $this->setDessenha($senha);
        }
    }
?>