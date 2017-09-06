<?php

namespace App\Routes;

use \Klein\Klein;

class Routes {

    private $klein;
    private $twig;

    public function __construct() {
        $this->klein = new Klein();
        $this->twig = new Twig();
        session_start();
    }
    
    public function start(){

        /*Login e autenticação*/
        $login = new \App\Routes\account\Login($this->klein, $this->twig);
        $login->start();
       
        /*Home da aplicação*/
        $core = new \App\Routes\core\Core($this->klein, $this->twig);
        $core->start();
        $core->error();

        $this->klein->dispatch();
        
    }

}