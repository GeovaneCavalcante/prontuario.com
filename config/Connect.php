<?php 

namespace Config;

class Connect{

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "mydb";
    private $conexao;

    public function __construct(){
        $this->conexao = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
    }

    public function testeConnection(){
        if($this->conexao){
            echo "Banco conectado";
        }else{
            echo "Falha ao connectar ao bando";
        }
    }
    public function getConnection(){
        return $this->conexao;
    }

}
