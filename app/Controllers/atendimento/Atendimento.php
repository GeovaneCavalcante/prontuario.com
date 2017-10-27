<?php
namespace App\Controllers\atendimento;


class Atendimento{

    private $post;
    private $modelAtendimento;
    private $connect;

    public function __construct($post){
        $this->post = $post;
        $this->modelAtendimento = new \App\Models\atendimento\Atendimento();
        $this->connect = new \Config\Connect();
    }

    public function Validacao(){

        $v = new \Valitron\Validator($this->post);

        $v->rule('required', array(
            'queixas_principais'
        ))->message('{field} é obrigatório');
        if($v->validate()) {
            return $v->errors();
        } else {
            return $v->errors();
        }
    }

    public function insertAtendimento(){

        $result = $this->modelAtendimento->insertAtendimento($this->post);    

        if($result['status'] == 200){
            return $result['resultado'];
        }else{
            echo "erro";
            die;
        }

    }

    public function insertSinais(){
        
        $result = $this->modelAtendimento->insertSinais($this->post);    

        if($result['status'] == 200){
            return $result['resultado'];
        }else{
            echo "erro";
            die;
        }

    }

    public function insertHipotese(){
        
        $result = $this->modelAtendimento->insertHipotese($this->post);    

        if($result['status'] == 200){
            return $result['resultado'];
        }else{
            echo "erro";
            die;
        }

    }
    

    public function inserPrescricao(){
        
        $result = $this->modelAtendimento->inserPrescricao($this->post);    

        if($result['status'] == 200){
            return $result['resultado'];
        }else{
            echo "erro";
            die;
        }

    }

    public function inserEvolucao(){
        
        $result = $this->modelAtendimento->inserEvolucao($this->post);    

        if($result['status'] == 200){
            return $result['resultado'];
        }else{
            echo "erro";
            die;
        }

    }
    

}
