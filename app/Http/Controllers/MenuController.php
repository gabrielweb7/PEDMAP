<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Menu;

class MenuController extends Controller
{

    static function getAllMenu() {

        $menu = Menu::where('tipo','=','sistema')->where('visivel','=','1');

        /* Retornar apenas menu para Admin e Dev */
        if(Session::get('tipo') == "255" or Session::get('tipo') == "1") {
            $menu->where('only_cliente','==','0');
        }

        /* Retornar apenas menu para Cliente */
        if(Session::get('tipo') == "100" or Session::get('tipo') == "101") {
            $menu->where('only_admin','==','0');
           
        }

        $menu->whereNull('menu_pai');

        return $menu->get();

    }

    static function getAllMenuFilhos($pai_id) {

        $menuFilhos =  Menu::where('tipo','=','sistema')->where('visivel','=','1')->where('menu_pai','=',$pai_id)->orderBy('ordem','asc');

        /* Retornar apenas menu para Cliente */
        if(Session::get('tipo') == 100) {
            $menuFilhos->where('only_admin','==','0');
        }

        return $menuFilhos;

    }

    static function getMenuItemFilhos($id)  {
        $menu = menu::where('menu_pai', '=', $id)->get();
        return $menu;
    }

    static function isMenuPaiActive($route_uri) {
        if(\Request::is($route_uri) or \Request::is($route_uri.'/*') and !empty($route_uri)) {
            return "active";
        }
    }

    static function isMenuFilhoActive($route_uri) {
        if(\Request::route()->getName() == $route_uri) {
            return "active";
        }
    }

}
