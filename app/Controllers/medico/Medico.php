<?php
namespace App\Controllers\medico;

class Medico{

    private $post;

    public function __construct($post){
        $this->post = $post;
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
}