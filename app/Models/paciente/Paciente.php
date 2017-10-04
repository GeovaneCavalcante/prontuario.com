<?php

namespace App\Models\paciente;

class Paciente{

    private $connect;

    public function __construct(){
        $this->connect = new \Config\Connect();
    }

    public function insertPaciente($dados){

        $sql = "
            INSERT INTO pacientes
            (nome, endereco, bairro,
            cidade, estado, cep, complemento, cpf, rg,
            data_nascimento, naturalidade, nacionalidade,
            email, telefone, celular, trabalho, nome_pai, nome_mae,
            nome_sangue, is_active)
            VALUES
            ('$dados[nome]', '$dados[endereco]', '$dados[endereco]',
            '$dados[cidade]', '$dados[estado]', '$dados[cep]', '$dados[complemento]',
            '$dados[cpf]', '$dados[rg]', '$dados[data_nascimento]', '$dados[naturalidade]',
            '$dados[nacionalidade]', '$dados[email]', '$dados[telefone]', '$dados[celular]',
            '$dados[trabalho]', '$dados[nome_pai]', '$dados[nome_mae]', '$dados[nome_sangue]',
            'ativo'
          )
        ";

        if ($this->connect->getConnection()->query($sql) == true){
            echo "Criado com sucesso";
            return ["status" => 200, "resultado" => "Criado com sucesso"];;
        }else{
            echo "Falha ao criar registro " . mysqli_error($this->connect->getConnection());
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao criar registro: $error"];;
        }
    }

    public function getPacientes(){

        $sql = "SELECT * FROM pacientes order by nome asc";
        $result = $this->connect->getConnection()->query($sql);

        if (!$result){
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }else{
            $i = 0;
            $array[] = "";
            while ($dados = mysqli_fetch_assoc($result)){
                $array[$i] = $dados;
                $i++;
            }
            return ["status" => 200, "resultado" => $array];
        }
    }


    public function getPaciente($cpf){

        $sql = "select * from pacientes where $cpf = $cpf";
        $result = $this->connect->getConnection()->query($sql);
        $resultado = mysqli_fetch_assoc($result);

        if($resultado){
            return ["status" => 200, "resultado" => $resultado];
        }else{
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }


    public function updatePaciente($dados){

        $sql = "
          UPDATE `mydb`.`pacientes` SET
           `nome`='$dados[nome]', `endereco`='$dados[endereco]',
          `bairro`='$dados[bairro]', `cidade`='$dados[cidade]', `estado`='$dados[estado]',
          `cep`='$dados[cep]', `complemento`='$dados[complemento]', `cpf`='$dados[cpf]', `rg`='$dados[rg]',
          `data_nascimento`='$dados[data_nascimento]', `naturalidade`='$dados[naturalidade]',
          `nacionalidade`='$dados[nacionalidade]',
          `email`='$dados[email]', `telefone`= '$dados[telefone]',
          `celular`= '$dados[celular]', `trabalho`= '$dados[trabalho]',
          `nome_pai` = '$dados[nome_pai]', `nome_mae` = '$dados[nome_mae]',
          `nome_sangue` = '$dados[nome_sangue]' WHERE `cpf`= '$dados[cpf]';

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

    function deletaPaciente($cpf){
        $paciente = $this->getPaciente($cpf);
        if ($paciente['status'] == 200){
          $sql = "
            UPDATE `mydb`.`pacientes` SET
            `is_active` = 'not_ativo' WHERE `cpf`= '$cpf';
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
