<?php
namespace App\Routes\paciente;

class Paciente{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }

    public function start(){

				$this->klein->respond('GET', '/pacientes', function ($request, $response, $service) {

						if ($_SESSION['status'] == true){
								$pacienteList = new \App\Controllers\paciente\PacienteList();
								echo $this->twig->getTwig()->render('paciente\list.html', array(
										"user" => $_SESSION,
										"dados" => $pacienteList->getPacientes()
								));
						}else{
								$response->redirect('/login');
						}

				});


        $this->klein->respond('/pacientes/cadastro', function ($request, $response, $service) {

            if ($_SESSION['status'] == true){
                    $endereco = new \App\Controllers\core\Endereco();
                    echo $this->twig->getTwig()->render('paciente\cadastro.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades()
                ));
            }else{
                $response->redirect('/login');
            }

        });


        $this->klein->respond('POST', '/pacientes/register', function ($request, $response, $service) {

            $con = new \App\Controllers\paciente\Paciente($_POST);
            if($con->Validacao() or $con->verificar()){
                echo $this->twig->getTwig()->render('paciente\cadastro.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades(),
                    "erros" => $con->Validacao(),
                    "exist" => $con->verificar(),
                    "dados" => $_POST
                ));

            }else{

                if ($con->insertPaciente() == 200){
                    $response->redirect('/pacientes');
                }else{
                    echo "erro";
                }

            }
        });

        $this->klein->respond('GET', '/pacientes/editar', function ($request, $response, $service) {

            if ($_SESSION['status'] == true){
                if($_GET['dados']){

                    $pacienteList = new \App\Controllers\paciente\PacienteList();
                    $endereco = new \App\Controllers\core\Endereco();
                    if ($pacienteList->getPaciente($_GET['dados']) == 404){
                        echo $this->twig->getTwig()->render('core\error.html');
                    }else{
                        echo $this->twig->getTwig()->render('paciente\editar.html', array(
                            "user" => $_SESSION,
                            "dados" => $pacienteList->getPaciente($_GET['dados']),
                            "estados" => $endereco->getEstados(),
                            "cidades" => $endereco->getCidades(),
                            "get" => $_GET['dados']
                        ));
                    }
                }else{
                    $response->redirect('/medicos');
                }
            }else{
                $response->redirect('/login');
            }
        });


        $this->klein->respond('POST', '/pacientes/editar', function ($request, $response, $service) {

            $con = new \App\Controllers\paciente\Paciente($_POST);

            if($con->Validacao()){
                $endereco = new \App\Controllers\core\Endereco();
                echo $this->twig->getTwig()->render('paciente\editar.html', array(
                    "user" => $_SESSION,
                    "estados" => $endereco->getEstados(),
                    "cidades" => $endereco->getCidades(),
                    "erros" => $con->Validacao(),
                    "dados" => $_POST
                ));
            }else{

                if ($con->updatePaciente() == 200){
                    $response->redirect('/pacientes');
                }else{
                    echo "erro";
                }

            }

        });

        $this->klein->respond('GET', '/pacientes/apagar', function ($request, $response, $service) {

            if ($_SESSION['status'] == true){
                if($_GET['dados']){
                    $pacienteList = new \App\Controllers\paciente\PacienteList();
                    $pacienteList->deletaPaciente($_GET['dados']);
                    $response->redirect('/pacientes');
                }else{
                    $response->redirect('/pacientes');
                }
            }else{
                $response->redirect('/login');
            }
        });




    }
}
