<?php

namespace App\Routes\account;

use \Klein\Klein;

class Login{
    
    private $klein;
    private $twig;

    public function __construct(){
        $this->klein = new Klein();
        $this->twig = new \App\Routes\Twig();
    }
    
    public function start(){

        $this->klein->respond('GET', '/login', function ($request, $response, $service) {
            echo $this->twig->getTwig()->render('/account/login.html');
        });

        $this->klein->respond('POST', '/login', function ($request, $response, $service) {
            $n = new \App\Controllers\account\Login($_POST);
            echo $this->twig->getTwig()->render('/account/login.html', array(
                "erros" =>  $n->validador()
            ));
        });
    }
}