<?php

namespace App\Controllers\atendimento;

class AtendimentoList{

    private $post;
    private $modelAtendimento;
    private $connect;

    public function __construct(){
        $this->modelAtendimento = new \App\Models\atendimento\Atendimento();
        $this->connect = new \Config\Connect();
    }

    public function getDados(){

        $modelMedico = new \App\Models\medico\Medico();
        $modelPaceinte = new \App\Models\paciente\Paciente();

        $medicos = $modelMedico->getMedicos();
        $pacientes = $modelPaceinte->getPacientes();

        if ($medicos['status'] == 200 or $pacientes['status'] == 200){
            $dados['medicos'] = $medicos['resultado'];
            $dados['pacientes'] = $pacientes['resultado'];
            return $dados;
        }else{
            echo 'ERRO';
        }
    }

    public function getAtendimentos($cpf){
       
        $result = $this->modelAtendimento->getAtendimentos($cpf);    
        if($result['status'] == 200){
            return $result['resultado'];
        }else{
            echo "erro";
            die;
        }
    }

    public function getAgendamento($cod){
        $agendamento = $this->modelAgendamento->getAgendamento($cod);

        if ($agendamento['status'] == 200){
           
            return $agendamento['resultado'];
        }else{
          
            return 404;
        }
    }

    public function getAgendamentoEsp($crm){
        $agendamentos = $this->modelAgendamento->getAgendamentoEsp($crm);
       
        if ($agendamentos['status'] == 200){
             return $agendamentos['resultado'];
         }else{
             return 404;
         }
    }
    public function deletaAgendamento($id){
        $agendamento = $this->modelAgendamento->deletaAgendamento($id);
    }

}