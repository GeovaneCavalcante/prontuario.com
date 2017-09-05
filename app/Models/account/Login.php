<?php

namespace App\Models\account;

require_once "../../../vendor/autoload.php";

class Login{

    private $connect;

    public function __construct(){
        $this->connect = new \Config\Connect();
    }

    public function getRoot($user){

        $sql = "select * from root where username = '$user'";

        $result = $this->connect->getConnection()->query($sql);

        if($result){

            $i = 0;
            while ($dados = mysqli_fetch_assoc($result)){
                $array[$i] = $dados;
                $i++;
            }
            return ["status" => 200, "resultado" => $array];

        }else{
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }

}

$lo = new \App\Models\account\Login();
$lo->getRoot("geovane");
