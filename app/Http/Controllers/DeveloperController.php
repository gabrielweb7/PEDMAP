<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\LogsController;

class DeveloperController extends Controller
{
    public function index() {
        return view('developer.index');
    }

    public function teste() {
        
        #LogsController::create('autenticacao','Usuario logado com sucesso!', 'sucesso','object id','Object Json');

        return '1';
    }
}
