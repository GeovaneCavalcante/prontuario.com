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
                    echo $this->twig->getTwig()->render('base.html', array(
                    "user" => $_SESSION,
                ));
            }else{
                $response->redirect('/login');
            }
            
        });
    }

    public function error(){

        $this->klein->onHttpError(function($code, $router) {
            switch($code) {
                case 404:
                    $router->response()->body(
                        $this->twig->getTwig()->render('/core/error.html')
                    );
                    break;
                default:
                    $router->response()->body(
                        'Oh no, a bad error happened that caused a '. $code
                    );
            }
        });
    }
}