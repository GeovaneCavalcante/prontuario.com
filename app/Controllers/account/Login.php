<?php

namespace App\Controllers;

class Login{

    private $request;
    private $user;
    private $pass;

    public function __construct($request){
        $this->request = $request;
    }
}