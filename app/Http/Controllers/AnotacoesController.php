<?php

namespace App\Http\Controllers;

// Utils
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// Models
use App\Anotacoes;

// Class
class AnotacoesController extends Controller
{


    // Modal Ajax List Filtered by Id
    public function jsonRegistroById(Request $request) { 
        
        $registerFiltered = Anotacoes::where('id','=',$request->id); 

        if(!$registerFiltered->count()) { return 0; }

        return $registerFiltered->first();

    }

    // Modal Ajax List Filtered by Like Bairros
    public function jsonRegistrosByLikeBairro(Request $request) { 
        
        $notasFiltered = Anotacoes::where('bairro','like','%'.$request->bairro.'%')->orderBy('datahora','desc'); 

        if($notasFiltered->count() > 0) { 

            $_html = "";
            foreach($notasFiltered->get() as $nota) { 
                $_html .= "<tr>";
                
                    $_html .= "<td> {$nota->anotacoes} </td>";
                    $_html .= "<td style='text-align:center;'> {$nota->datahora->format('d/m/Y')} </td>";

                    $_html .= "<td style='text-align:center;'> <button type='button' onclick='modalAnotacoesUpdateShow({$nota->id})' class='btn btn-info' style='font-size: 14px; border: 0px; background: #1070d4;'><i class='far fa-edit'></i></button>  </td>";
                   
                $_html .= "</tr>";
            }
            
        } else { 
            $_html = "<td colspan='3' style='padding:20px;text-align:center;'> Nenhum registro encontrado :( </td>";
        }

        return $_html;
    }


}
