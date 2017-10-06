<?php

namespace App\Routes\agendamento;

class Agendamento{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }

    public function start(){


        $this->klein->respond('GET', '/agendamentos/cadastro', function ($request, $response, $service) {
            $list = new \App\Controllers\agendamento\AgendamentoList();
        
            if ($_SESSION['status'] == true){
                    echo $this->twig->getTwig()->render('agendamento/cadastro.html', array(
                    "user" => $_SESSION,
                    "dados" => $list->getDados(),
                    "agendamentos" => $list->getAgendamentos()
                ));
            }else{
                $response->redirect('/login');
            }

        });


        $this->klein->respond('POST', '/agendamentos/register', function ($request, $response, $service) {

                $list = new \App\Controllers\agendamento\AgendamentoList();
                $con = new \App\Controllers\agendamento\Agendamento($_POST);
               
                if($con->Validacao()){
                    echo $this->twig->getTwig()->render('agendamento/cadastro.html', array(
                        "user" => $_SESSION,
                        "dados" => $list->getDados(),
                        "erros" => $con->Validacao(),
                        "form" => $_POST,
                        "agendamentos" => $list->getAgendamentos(),
                    ));
                }else{
                    $con->insertAgendamento();
                    $response->redirect('/agendamentos/cadastro');
                }    

        });

    }
}