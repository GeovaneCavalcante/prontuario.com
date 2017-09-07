<?php

namespace App\Models\core;

class Endereco{

    private $connect;
    
    public function __construct(){
        $this->connect = new \Config\Connect();
    }

    public function getEstados(){
        $sql = 'SELECT * FROM estado';
        $result = $this->connect->getConnection()->query($sql);
        if ($result){
            $i = 0;
            $array = [];
            while ($dados = mysqli_fetch_assoc($result)){
                $array[$i] = $dados;
                $i++;
            }
            return ["status" => 200, "resultado" => $array];
        }else{

            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }

    public function getPais(){
        $sql = 'SELECT * FROM pais';
        $result = $this->connect->getConnection()->query($sql);
        if ($result){
            $i = 0;
            $array = [];
            while ($dados = mysqli_fetch_assoc($result)){
                $array[$i] = $dados;
                $i++;
            }
            return ["status" => 200, "resultado" => $array];
        }else{
            
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }

    public function getCidades(){
        $sql = 'SELECT * FROM cidade';
        $result = $this->connect->getConnection()->query($sql);
        if ($result){
            $i = 0;
            $array = [];
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