<?php

namespace App\Routes;

use \Klein\Klein;

class Routes {

    private $klein;
    private $twig;

    public function __construct() {
        $this->klein = new Klein();
        $this->twig = new Twig();
    }
    
    public function start(){

        $this->klein->respond('/', function ($request, $response, $service) {
            echo $this->twig->getTwig()->render('base.html');
        });

        $this->klein->respond('GET', '/login', function ($request, $response, $service) {
            echo $this->twig->getTwig()->render('/account/login.html');
        });

        $this->klein->respond('POST', '/login', function ($request, $response, $service) {
            $n = new \App\Controllers\account\Login($_POST);
            if (count($n->validador()) > 0){
                echo $this->twig->getTwig()->render('/account/login.html', array(
                    "erro" => $n->validador())
                );
            }else{
                $response->redirect('/');
            }
        });

        $this->klein->dispatch();
    }

}