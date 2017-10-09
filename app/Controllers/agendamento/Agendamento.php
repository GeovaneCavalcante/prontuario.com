<?php
namespace App\Controllers\Agendamento;


class Agendamento{

    private $post;
    private $modelAgendamento;
    private $connect;

    public function __construct($post){
        $this->post = $post;
        $this->modelAgendamento = new \App\Models\agendamento\Agendamento();
        $this->connect = new \Config\Connect();
    }

    public function Validacao(){

        $v = new \Valitron\Validator($this->post);

        $v->rule('required', array(
            'data_agendamento', 'hora_agendamento', 'paciente', 'medico'
        ))->message('{field} é obrigatório');
        if($v->validate()) {
            return $v->errors();
        } else {
            return $v->errors();
        }
    }

    public function insertAgendamento(){

        $result = $this->modelAgendamento->insertAgendamento($this->post);    

        if($result['status'] == 200){
            return $result['resultado'];
        }else{
            echo "erro";
            die;
        }

    }

    public function updateAgendamento(){

        $result = $this->modelAgendamento->updateAgendamento($this->post);

        if ($result['status'] == 200){
            return 200;
        }else{
            return 405;
        }
    }


}
