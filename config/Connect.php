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
/*

$co = new Connect();
$co->testeConnection();

$sql = "SELECT * FROM root";
$result = $co->getConnection()->query($sql);
if (!$result){
    echo "erro";
}else{
    $i = 0;
    while ($dados = mysqli_fetch_assoc($result)){
         $array[$i] = $dados;
         $i++;
         echo $dados["pass"];

    }
   
}
*/
