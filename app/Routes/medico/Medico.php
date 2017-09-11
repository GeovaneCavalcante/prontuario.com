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
                    $esp = new \App\Controllers\core\Especialidades();
                    echo $this->twig->getTwig()->render('medico\cadastro.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades(),
                    "especialidades" => $esp->getEspecialidades()
                ));
            }else{
                $response->redirect('/login');
            }
            
        });

        $this->klein->respond('POST', '/medico/register', function ($request, $response, $service) {
            
            $con = new \App\Controllers\medico\Medico($_POST);

            if($con->Validacao()){

                $endereco = new \App\Controllers\core\Endereco();
                $esp = new \App\Controllers\core\Especialidades();
                echo $this->twig->getTwig()->render('medico\cadastro.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades(),
                    "especialidades" => $esp->getEspecialidades(),
                    "erros" => $con->Validacao(),
                    "dados" => $_POST
                ));

            }else{

                if ($con->insertMedico() == 200){
                    echo "Só no ponto";
                }else{
                    echo "erro";
                }

            }
        });

        $this->klein->respond('POST', '/medico', function ($request, $response, $service) {
            
           
        });
    }
}