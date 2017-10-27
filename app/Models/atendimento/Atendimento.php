<?php

namespace App\Models\atendimento;

class Atendimento{

    private $connect;
    
    public function __construct(){
        $this->connect = new \Config\Connect();
    }

    public function insertAtendimento($dados){
       

        if (!isset($dados['hepatite'])){
            $dados['hepatite'] = "of";
        }

        if (!isset($dados['gravidez'])){
            $dados['gravidez'] = "of";
        }

        if (!isset($dados['diabetes'])){
            $dados['diabetes'] = "of";
        }
        
        if (!isset($dados['cicatrização'])){
            $dados['cicatrização'] = "of";
        }

        $sql = "
            INSERT INTO atendimentos
            (
                p_renais, p_articulares, p_cardiacos, p_gastriculos, alergias, 
                ultiliza_med, queixas_principais, hepatite, gravidez, diabetes, cicatrização,
                codigo_agendamento, is_active
            )
            VALUES
            (
                '$dados[p_renais]', '$dados[p_articulares]', '$dados[p_cardiacos]', 
                '$dados[p_gastriculos]', '$dados[alergias]', '$dados[ultiliza_med]', 
                '$dados[queixas_principais]', '$dados[hepatite]', '$dados[gravidez]', 
                '$dados[diabetes]', '$dados[cicatrização]', $dados[codigo_agendamento] , 'ativo'
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

    public function insertSinais($dados){
 
         $sql = "
             INSERT INTO sinais_vitais
             (
                hora, data_sinais, altura, peso, imc, 
                temperatura, dor, codigo_agendamento, is_active
             )
             VALUES
             (
                 '$dados[hora]', '$dados[data_sinais]', '$dados[altura]', 
                 '$dados[peso]', '$dados[imc]', '$dados[temperatura]', 
                 '$dados[dor]', '$dados[codigo_agendamento]', 'ativo'
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

     public function insertHipotese($dados){
        
        $sql = "
            INSERT INTO hipoteses
            (
                hipotese, observacoes, is_active, codigo_agendamento
            )
            VALUES
            ( 
                '$dados[hipotese]', '$dados[observacoes]', 'ativo', 
                '$dados[codigo_agendamento]'
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

    public function inserPrescricao($dados){
        
        $sql = "
            INSERT INTO prescricao
            (
                prescricao, codigo_agendamento, is_active
            )
            VALUES
            ( 
                '$dados[prescricao]', '$dados[codigo_agendamento]', 'ativo'
               
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

    public function inserEvolucao($dados){
        
        $sql = "
            INSERT INTO evolucao
            (
                evolucao, codigo_agendamento, is_active
            )
            VALUES
            ( 
                '$dados[evolucao]', '$dados[codigo_agendamento]', 'ativo'
               
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

    public function insertAtestado($dados){
        
        $sql = "
            INSERT INTO atestado
            (
                texto, codigo_agendamento, is_active
            )
            VALUES
            ( 
                '$dados[texto]', '$dados[codigo_agendamento]', 'ativo'
               
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


    public function getAtendimentos($cpf){
        $sql = "SELECT * FROM atendimentos where is_active = 'ativo'";
        $result = $this->connect->getConnection()->query($sql);

        if (!$result){
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }else{
            $i = 0;
            $array = [];
            while ($dados = mysqli_fetch_assoc($result)){
                $array[$i] = $dados;
                $i++;
            }
       
            return ["status" => 200, "resultado" => $array];
        }
              
    }

    public function getAgendamentoEsp($crm){

        $sql = "SELECT * FROM agendamentos where medico ='$crm' and is_active = 'ativo' order by data_agendamento asc";
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
        }
        return ["status" => 200, "resultado" => $array];
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

    public function updateAgendamento($dados){
        
        $sql = "
            UPDATE `mydb`.`agendamentos` SET
            `data_agendamento`='$dados[data_agendamento]', `hora_agendamento`='$dados[hora_agendamento]',
            `paciente`='$dados[paciente]', `medico`='$dados[medico]' 
            WHERE `codigo`= '$dados[get]';

        ";

        if($this->connect->getConnection()->query($sql)==true){
            echo "Atualizado com sucesso" . $this->connect->getConnection()->error;
            return ["status" => 200, "resultado" => "Atualizado com sucesso"];
        }else{

            $error = $this->connect->getConnection()->error;
            echo "Falha ao criar registro" . $error;
            return ["status" => 405, "resultado" => "Falha ao atualizar registro:  $error "];
        }
    }
}