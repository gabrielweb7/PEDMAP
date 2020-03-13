<?php

namespace App\Http\Controllers;

#use Illuminate\Http\Request;
use Request;

use App\Logs;

class LogsController extends Controller
{
    
    /* Função para criar novo Log */
    public static function create($log_tipo, $log_mensagem, $style_tipo, $object_id, $object_json) { 
        
        $log = new Logs;

        $log->log_tipo = $log_tipo;
        $log->log_mensagem = $log_mensagem;

        $log->style_tipo = $style_tipo;
        
        if(!is_int($object_id)) { $object_id = -1; }
        $log->object_id = $object_id;

        if(is_array($object_json)) { $object_json = json_encode($object_json); }
        $log->object_json = $object_json;

        $log->ip = Request::ip();
        $log->datahora = date('Y-m-d H:i:s');

        $log->save();

    }

}
