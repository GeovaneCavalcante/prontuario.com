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


    public function getAtendimentosTime($cpf){

        $modelAgendamento = new \App\Models\agendamento\Agendamento();
        $agendamentos = $modelAgendamento->getAgendamentoPaciente($cpf);
        
        $array = [];
        $i = 0;
        if($agendamentos['status'] == 200){
    
            foreach($agendamentos['resultado'] as $agendamento){
                $atendimento = $this->modelAtendimento->getAtendimento($agendamento['codigo']);
                $hipotese = $this->modelAtendimento->getHipotese($agendamento['codigo']); 
                $evolucao = $this->modelAtendimento->getEvolucao($agendamento['codigo']); 

                if($evolucao['status'] == 200){
                    $agendamento['evolucao'] = $evolucao['resultado'];
                    $array[$i] =  $agendamento;
                }

                if($hipotese['status'] == 200){
                    $agendamento['hipotese'] = $hipotese['resultado'];
                    $array[$i] =  $agendamento;
                }

                if($atendimento['status'] == 200){
                    $agendamento['atendimento'] = $atendimento['resultado'];
                    $array[$i] =  $agendamento;
                }
            
                $i++;    
            }
        }
        return $array;
    }

}