<?php

namespace App\Routes\atendimento;

class Atendimento{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }

    public function start(){


        $this->klein->respond('GET', '/atendimento', function ($request, $response, $service) {
            $list = new \App\Controllers\agendamento\AgendamentoList();
            
            if ($_SESSION['statusMed'] == true){
                    echo $this->twig->getTwig()->render('atendimento/atendimento.html', array(
                    "user" => $_SESSION
                ));
            }else{
                $response->redirect('/login');
            }

        });

    }
}