<?php
namespace App\Controllers\paciente;

class Paciente{

    private $post;
    private $modelPaceinte;
    private $connect;

    public function __construct($post){
        $this->post = $post;
        $this->modelPaceinte = new \App\Models\paciente\Paciente();
        $this->connect = new \Config\Connect();
    }

    public function Validacao(){

        $v = new \Valitron\Validator($this->post);
        $v->rule('required', [
            'nome', 'cpf', 'rg', 'data_nascimento',
        ])->message('{field} é obrigatório');

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
        $sql = "select cpf from pacientes where cpf = '$cpf'";
        $result = $this->connect->getConnection()->query($sql);
        $resultado = mysqli_fetch_assoc($result);

        if ($resultado){
            $erros['cpf'] = true;
        }

        $rg = $post['rg'];
        $sql = "select rg from pacientes where rg = '$rg'";
        $result = $this->connect->getConnection()->query($sql);
        $resultado = mysqli_fetch_assoc($result);

        if ($resultado){
            $erros['rg'] = true;
        }

        return $erros;

    }

    public function insertPaciente(){

        $post = $this->removeMascara($this->post);
        $result = $this->modelPaceinte->insertPaciente($post);

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
        $var = $post['data_nascimento'];
        $date = str_replace('/', '-', $var);
        $post['data_nascimento'] = date('Y-m-d', strtotime($date));

        if ($post['estado'] == "Selecione"){
            $post['estado'] = "";
        }
        if ($post['cidade'] == "Selecione"){
            $post['cidade'] = "";
        }

        return $post;

    }

    public function updatePaciente(){

        $post = $this->removeMascara($this->post);
        $result = $this->modelPaceinte->updatePaciente($post);

        if ($result['status'] == 200){
            return 200;
        }else{
            return 405;
        }
    }

}
