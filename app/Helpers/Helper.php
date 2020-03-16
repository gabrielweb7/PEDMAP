<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    
    public static function assetStorage(string $string)
    {
        /* Se imagem não existir no storage */
        if(!Storage::exists($string)) {
            return Storage::url('no-image/1.png');
        }

        /* Retornar url da imagem existente */
        return Storage::url($string);
    }

    public static function assetStorageArquivo(string $string)
    {
        /* Se imagem não existir no storage */
        if(!Storage::exists($string)) {
            return 0;
        }

        /* Retornar url da imagem existente */
        return Storage::url($string);
    }

    public static function limitarTexto(string $texto, int $limite){
        $contador = strlen($texto);
        if ( $contador >= $limite ) {      
            $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '...';
            return $texto;
        }
        else{
            return $texto;
        }
    } 


}

