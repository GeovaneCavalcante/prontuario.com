<?php

namespace App\Controllers\medico;

class MedicoList{

    private $post;
    private $modelMedico;
    private $connect;

    public function __construct(){
        $this->modelMedico = new \App\Models\medico\Medico();
        $this->connect = new \Config\Connect();
    }

    public function getMedicos(){
        $medicos = $this->modelMedico->getMedicos();

        if ($medicos['status'] == 200){
            return $medicos['resultado'];
        }else{
            echo 'ERRO';
        }
    }
}