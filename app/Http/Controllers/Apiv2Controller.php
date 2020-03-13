<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BairrosRegioes;
use App\Estados;
use App\Cidades;

class Apiv2Controller extends Controller
{
    public function getJsonBairrosForSelect2(Request $request) { 

        if(!$request->q) { 
            return json_encode([]);
        }

        $registro = BairrosRegioes::where(function($query) use ($request) { 
            
            return $query->where('bairro','like','%'.$request->q.'%')
            ->orWhere('regiao','like','%'.$request->q.'%');

        })->orderBy('bairro','asc')->whereNull('datahora_deleted');

        if(!$registro->count()) { 
            return json_encode([]);
        }

        $json = [];
        foreach($registro->get() as $bairro) { 
            $json[] = [ 'id'=>$bairro->id, 'text'=>$bairro->bairro ];
        }

        return $json;
    }
    public function getJsonEstadosForSelect2(Request $request) { 

        if(!$request->q) { 
            
            $registro = Estados::orderBy('nome','asc')->whereNull('datahora_deleted');

        } else { 

            $registro = Estados::where(function($query) use ($request) { 
                
                return $query->where('nome','like','%'.$request->q.'%')
                ->orWhere('sigla','like','%'.$request->q.'%');

            })->orderBy('nome','asc')->whereNull('datahora_deleted');

        }

        if(!$registro->count()) { 
            return json_encode([]);
        }

        $json = [];
        foreach($registro->get() as $estado) { 
            $json[] = [ 'id'=>$estado->id, 'text'=>$estado->nome.' - '.$estado->sigla ];
        }

        return $json;
    }
    public function getJsonCidadesForSelect2(Request $request) { 

        if(!$request->q) { 
            
            $registro = Cidades::orderBy('nome','asc')->whereNull('datahora_deleted');

        } else { 

            $registro = Cidades::where(function($query) use ($request) { 
                
                return $query->where('nome','like','%'.$request->q.'%');

            })->orderBy('nome','asc')->whereNull('datahora_deleted');
            
        }

        if(!$registro->count()) { 
            return json_encode([]);
        }

        $json = [];
        foreach($registro->get() as $cidade) { 
            $json[] = [ 'id'=>$cidade->id, 'text'=>$cidade->nome ];
        }

        return $json;
    }
}
