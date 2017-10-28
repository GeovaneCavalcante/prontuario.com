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

    public function verificacao(){
        $data = $this->post['data_agendamento'];
        $hora = $this->post['hora_agendamento'];
        $sql = "select * from agendamentos where data_agendamento = '$data' and hora_agendamento = '$hora' and is_active = 'ativo'";
        
        $result = $this->connect->getConnection()->query($sql);
        
        $resultado = mysqli_fetch_assoc($result);

        if($resultado){
            $errors[0] = "Agendamento já preenchido nessa Data/Hora";
            return $errors;
        }else{
            $errors = [];
            return $errors;
    
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
