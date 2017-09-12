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
            $this->insertEspecialidades($dados);
            echo "Criado com sucesso";
            return ["status" => 200, "resultado" => "Criado com sucesso"];;
        }else{
            echo "Falha ao criar registro " . mysqli_error($this->connect->getConnection()); 
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao criar registro: $error"];;
        }
    }

    public function insertEspecialidades($dados){
        
        if ($dados['especialidades']){
            foreach ($dados['especialidades'] as $value){
                $medico = new \App\Models\core\Especialidades();
            
                $especialidade = $medico->getEspecialidade($value);
                echo "<br>" . $especialidade['nome'] . "<br>" . "kk";
                $sql = "
                    INSERT INTO especialidades_med 
                    (nome, crm_medico, id_especialidades)
                    VALUES 
                    ('$value', '$dados[crm]', '$especialidade[id]')
                ";
                $this->connect->getConnection()->query($sql);
            }
        }

    }

    public function getMedicos(){
        
        $sql = "SELECT * FROM medicos";
        $result = $this->connect->getConnection()->query($sql);

        if (!$result){
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }else{
            $i = 0;
            while ($dados = mysqli_fetch_assoc($result)){

                $sql2 = "SELECT * FROM especialidades_med WHERE crm_medico = '$dados[crm]'";
                $result2 = $this->connect->getConnection()->query($sql2);
                $j = 0;
                $array2 = [];
                while ($dados2 = mysqli_fetch_assoc($result2)){
                    $array2[$j] = $dados2;
                    $j++;
                }
                $dados['especialidades'] = $array2;
                $array[$i] = $dados;
                $i++;
            }
            return ["status" => 200, "resultado" => $array];
        }
    }

}