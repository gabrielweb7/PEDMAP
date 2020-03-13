<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;


class Modulos extends Model
{
    protected $table = 'modulos';

    public function permissoes($permTipo) { 

        /* Apenas para Clientes  */
        if(Session::get('tipo') == "100") { 
            return $this->hasOne('App\UsuariosPermissoes','modulo_id','id')->where('usuario_id',Session::get('id'))->where($permTipo,'=','1')->count();
        }

        /* Apenas para Equipe's de Clientes  */
        if(Session::get('tipo') == "101") { 
            return $this->hasOne('App\UsuariosPermissoes','modulo_id','id')->where('equipe_id',Session::get('id'))->where($permTipo,'=','1')->count();
        }
        
        /* Apenas para Admin */
        return 1;

    }

}
