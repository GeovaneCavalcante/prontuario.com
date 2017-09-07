<?php
namespace App\Routes\medico;

class Medico{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('/medico/cadastro', function ($request, $response, $service) {
            if ($_SESSION['status'] == true){
                    $endereco = new \App\Controllers\core\Endereco();
                    echo $this->twig->getTwig()->render('medico\cadastro.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades(),
                ));
            }else{
                $response->redirect('/login');
            }
            
        });
        $this->klein->respond('/medico', function ($request, $response, $service) {
            
            
        });

       
    }
}