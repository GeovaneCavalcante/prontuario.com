<?php

namespace App\Controllers\paciente;

class PacienteList{

    private $post;
    private $modelPaciente;
    private $connect;

    public function __construct(){
        $this->modelPaciente = new \App\Models\paciente\Paciente();
        $this->connect = new \Config\Connect();
    }

    public function getPacientes(){

        $paciente = $this->modelPaciente->getPacientes();
        if ($paciente['status'] == 200){
            return $paciente['resultado'];
        }else{
            echo 'ERRO';
        }
    }

    public function getPaciente($dados){
        $paciente = $this->modelPaciente->getPaciente($dados);
        if ($paciente['status'] == 200){
            return $paciente['resultado'];
        }else{
            return 404;
        }
    }


    public function deletaPaciente($dados){
        $paciente = $this->modelPaciente->deletaPaciente($dados);
        if ($paciente['status'] == 200){
            echo "apagado";
        }else{
            echo 'ERRO';
        }
    }

}
