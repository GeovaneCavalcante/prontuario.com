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

                    if (!$_GET){
                        $_GET['success'] = 'not';
                    }
                    echo $this->twig->getTwig()->render('agendamento/cadastro.html', array(
                    "user" => $_SESSION,
                    "dados" => $list->getDados(),
                    "agendamentos" => $list->getAgendamentos(),
                    "agendado" => $_GET['success']
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
                    $response->redirect('/agendamentos/cadastro?success=ok');
                }    

        });

        $this->klein->respond('GET', '/agendamentos/apagar', function ($request, $response, $service) {

            if ($_SESSION['status'] == true){
                $_GET['success'] = 'not';
                if($_GET['id']){
                    $list = new \App\Controllers\agendamento\AgendamentoList();
                    $list->deletaAgendamento($_GET['id']);
                    $response->redirect('/agendamentos/cadastro');
                }else{
                    $response->redirect('/agendamentos/cadastro');
                }
            }else{
                $response->redirect('/login');
            }

        });


    }
}