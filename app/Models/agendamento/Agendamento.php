<?php

namespace App\Models\agendamento;

class Agendamento{

    private $connect;
    
    public function __construct(){
        $this->connect = new \Config\Connect();
    }

    public function insertAgendamento($dados){
        
        $sql = "
            INSERT INTO agendamentos
            (data_agendamento, hora_agendamento, paciente, medico, is_active)
            VALUES
            ('$dados[data_agendamento]', '$dados[hora_agendamento]', 
            '$dados[paciente]', '$dados[medico]', 'ativo'
            )
        ";

        if ($this->connect->getConnection()->query($sql) == true){
           
            return ["status" => 200, "resultado" => "Criado com sucesso"];;
        }else{
            echo "Falha ao criar registro " . mysqli_error($this->connect->getConnection());
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao criar registro: $error"];;
        }
    }

    public function getAgendamentos(){
        $sql = "SELECT * FROM agendamentos where is_active = 'ativo' order by data_agendamento asc";
        $result = $this->connect->getConnection()->query($sql);

        if (!$result){
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }else{
            $i = 0;
            $array = [];
            while ($dados = mysqli_fetch_assoc($result)){

                $modelMedico = new \App\Models\medico\Medico();
                
                if ($modelMedico->getMedico($dados['medico'])['status'] == 200){
                    $medico = $modelMedico->getMedico($dados['medico'])['resultado'];
                    $dados['nomeMedico'] = $medico['nome'];
                }
               
               
                $modelPaciente = new \App\Models\paciente\Paciente();

                if ($modelPaciente->getPaciente($dados['paciente'])['status'] == 200){
                    $paciente = $modelPaciente->getPaciente($dados['paciente'])['resultado'];
                    $dados['nomePaciente'] = $paciente['nome'];
                }

                $array[$i] = $dados;
                $i++;
            }
       
            return ["status" => 200, "resultado" => $array];
        }
              
    }

    public function getAgendamento($id){
        $sql = "select * from agendamentos where codigo= '$id' and is_active = 'ativo'";

        $result = $this->connect->getConnection()->query($sql);
        $resultado = mysqli_fetch_assoc($result);

        if($resultado){
            return ["status" => 200, "resultado" => $resultado];
        }else{
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }


    public function deletaAgendamento($id){
        $agendamento = $this->getAgendamento($id);
        if ($agendamento['status'] == 200){
          $sql = "
            UPDATE `mydb`.`agendamentos` SET
            `is_active` = 'not_ativo' WHERE `codigo`= '$id';
          ";
          $this->connect->getConnection()->query($sql);
          return ["status" => 200, "resultado" => "Apagado com sucesso"];
        }else{
            echo "Erro ao apagar registro";
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Resgistro não apagado: $error"];
        }
    }
}