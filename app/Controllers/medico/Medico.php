<?php
namespace App\Controllers\medico;

class Medico{

    private $post;
    private $modelMedico;
    private $connect;

    public function __construct($post){
        $this->post = $post;
        $this->modelMedico = new \App\Models\medico\Medico();
        $this->connect = new \Config\Connect();
    }

    public function Validacao(){

        $v = new \Valitron\Validator($this->post);

        $v->rule('required', array(
            'nome', 'cpf', 'rg', 'data', 'crm'
        ))->message('{field} é obrigatório');

        if($v->validate()) {
            return $v->errors();
        } else {
            return $v->errors();
        }
    }
    
    public function verificar(){
        $erros = [];
        $post = $this->removeMascara($this->post);

        $cpf = $post['cpf'];
        echo $post['celular'];
        $sql = "select * from medicos where cpf = '$cpf'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);
       
        if ($resultado){
            $erros['cpf'] = true;
        }

        $crm = $post['crm'];
        $sql = "select * from medicos where crm = '$crm'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        if ($resultado){
            $erros['crm'] = true;
        }

        $rg = $post['rg'];
        $sql = "select * from medicos where rg = '$rg'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        if ($resultado){
            $erros['rg'] = true;
        }
        
        return $erros;
       
    }

    public function insertMedico(){

        $post = $this->removeMascara($this->post);
        $result = $this->modelMedico->insertMedico($post);

        if ($result['status'] == 200){
            return 200;
        }else{
            return 405;
        }

    }

    private function removeMascara($post){

        $post['cpf'] = preg_replace("/\D+/", "", $post['cpf']); 
        $post['cep'] = preg_replace("/\D+/", "", $post['cep']);
        $post['telefone'] = preg_replace("/\D+/", "", $post['telefone']);
        $post['celular'] = preg_replace("/\D+/", "", $post['celular']);
        $post['trabalho'] = preg_replace("/\D+/", "", $post['trabalho']); 
        $var = $post['data'];
        $date = str_replace('/', '-', $var);
        $post['data'] = date('Y-m-d', strtotime($date));

        if ($post['estado'] == "Selecione"){
            $post['estado'] = "";
        }
        if ($post['cidade'] == "Selecione"){
            $post['cidade'] = "";
        }

        
        echo $post['cpf'] . " cpf <br>";
        return $post;
        /*
        
        echo $post['cep'] . " cep <br>";
        echo $post['celular'] . " celular <br>";
        echo $post['telefone'] . " telefone <br>";
        echo $post['trabalho'] . " trabalho <br>";
        echo $post['data'] . " data <br>";
        */
    }
}