<?php // Code within app\Helpers\Sistema.php

namespace App\Helpers;

use App\SystemConfig;

class Sistema
{



    /* Retorna variavel do banco */
    public static function get($identificador)
    {
        if(!$identificador) {
            return false;
        }

        $variavel = SystemConfig::where('identificador','=',$identificador)->first();

        return $variavel->valor;
    }

}