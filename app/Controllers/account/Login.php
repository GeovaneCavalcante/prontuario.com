<?php

namespace App\Controllers\account;

class Login{

    private $post;
    private $user;
    private $pass;

    public function __construct($request){

        $this->post = $request;
        $this->user = $request['user'];
        $this->pass = $request['pass'];
    }

    public function validador(){
        
        if($this->post['perfil'] == 'Atendente'){
            $root = new \App\Models\account\Login();
            $dados = $root->getRoot($this->user);
            $resultado = $this->verificarUser($dados, $this->user, $this->pass);
            $this->sessao($resultado, $dados);
        }else{
            $medico = new \App\Models\medico\Medico();
            $dados = $medico->getMedico($this->user);
            $resultado = $this->verificarUserMed($dados, $this->user, $this->pass);
            $this->sessaoMed($resultado, $dados);
        }    
       
        return $resultado;
    }

    private function sessao($resultado, $dados){
        
        if (count($resultado)==0){     var_dump($_SESSION);
            $valor = $dados['resultado'];
            $_SESSION['login'] = $valor['username'];
            $_SESSION['senha'] = $valor['pass'];
        }else{
            unset ($_SESSION['login']);
            unset ($_SESSION['senha']);
        }
    }

    private function sessaoMed($resultado, $dados){
        
        if (count($resultado)==0){
            $valor = $dados['resultado'];
            $user = strstr($valor['nome'], ' ', true);
            $_SESSION['crm'] = $valor['crm'];
            $_SESSION['login'] = $user;
            $_SESSION['senha'] = $user['pass'];
        }else{
            unset ($_SESSION['login']);
            unset ($_SESSION['senha']);
        }

    }

    private function verificarUserMed($dados, $user, $pass){
        
        $error = []; 

    
        if ($dados['status'] == 200){

            $valor = $dados['resultado'];
            
            $rest = substr($valor['cpf'], 0, 4);
        
            $rest = 'Brasil@' . $rest;
            $senhaBanco = md5($rest);

            $senhaLogin = md5($pass);

            if ($senhaBanco != $senhaLogin){
                $error[] = "Senha Incorreta";
            } 

            return $error;
        }else{
            $error[] = "Usuário não existe";
            return $error;
        }
    }

    private function verificarUser($dados, $user, $pass){

        $error = [];    
        if ($dados['status'] == 200){
            $valor = $dados['resultado'];
            if ($valor['pass'] != $this->pass){
                $error[] = "Senha Incorreta";
            } 
            return $error;
        }else{
            $error[] = "Usuário não existe";
            return $error;
        }
    }
}