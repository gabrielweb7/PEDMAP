<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noticiascat extends Model
{
    protected $table = 'modulo_noticiascat';
    public $timestamps = false;

    public function noticias() {
        return $this->belongsToMany(Noticias::class, 'rex_noticiasxcat', 'noticias_id', 'noticiascat_id');
    }

    public function getVisivelStringAttribute()
    {
        if ($this->visivel == 1) {
            return '<span class=\'bxCircle-xs-blue\'> Ativo </span>';
        } else {
            return '<span class=\'bxCircle-xs-gray\'>Desativado</span>';
        }

    }

}
