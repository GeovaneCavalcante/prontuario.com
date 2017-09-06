<?php

namespace App\Routes\core;


class Core{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('/', function ($request, $response, $service) {
            if ($_SESSION['status'] == true){
                echo $this->twig->getTwig()->render('base.html');
            }else{
                $response->redirect('/login');
            }
            
        });
    }
}