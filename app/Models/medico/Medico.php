<?php 

namespace App\Models\medico;

class Medico{

    private $connect;

    public function __construct(){
        $this->connect = new \Config\Connect();
    } 

    public function insertMedico($dados){
    
        $sql = "
            INSERT INTO medicos 
            (crm, nome, endereco, bairro,
            cidade, estado, cep, complemento, cpf, rg,
            data_nascimento, naturalidade, nacionalidade,
            email, telefone, celular, trabalho)
            VALUES 
            ('$dados[crm]', '$dados[nome]', '$dados[endereco]', '$dados[endereco]',
            '$dados[cidade]', '$dados[estado]', '$dados[cep]', '$dados[complemento]',
            '$dados[cpf]', '$dados[rg]', '$dados[data]', '$dados[naturalidade]',
            '$dados[nacionalidade]', '$dados[email]', '$dados[telefone]', '$dados[celular]',
            '$dados[trabalho]'
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

}