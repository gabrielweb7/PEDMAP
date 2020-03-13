<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ClienteTabelasController extends Controller
{

    static function getPrefix($id,$tabelaNome) {
        return "zc_{$id}_{$tabelaNome}";
    }

    static function createAllTables($id) {
        DB::unprepared(DB::raw(self::getSqlAllTables($id, 'insert')));
    }

    static function dropAllTables($id) {
        DB::unprepared(DB::raw(self::getSqlAllTables($id, 'drop')));
    }

    static function getSqlAllTables($id, $tipo) {

        $_sql = "";
        $_sql .= self::sqlNoticias($id, $tipo);
        $_sql .= self::sqlNoticiasCategoriasRelacionamento($id, $tipo);
        $_sql .= self::sqlEquipe($id, $tipo);
        $_sql .= self::sqlPesquisaInterna($id, $tipo);
        $_sql .= self::sqlPesquisaInternaProblemasBairroRelacionamento($id, $tipo);

        return $_sql;

    }

    static function sqlNoticias($id, $tipo) {

        $tabelaNome = self::getPrefix($id, "modulo_noticias");

        if($tipo == "insert") {

            return "CREATE TABLE IF NOT EXISTS {$tabelaNome} (
                      id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      datahora datetime NOT NULL,
                      favorita int(11) NOT NULL,
                      retranca varchar(200) DEFAULT NULL,
                      divulgacao varchar(100) DEFAULT NULL,
                      arquivo varchar(150) DEFAULT NULL,
                      imagem_src varchar(250) DEFAULT NULL,
                      bairro varchar(50) DEFAULT NULL,
                      conteudo varchar(200) DEFAULT NULL,
                      resumo text,
                      status int(11) NOT NULL DEFAULT '0',
                      datahora_deleted datetime DEFAULT NULL
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        } else if($tipo == "drop") {
            return "DROP TABLE IF EXISTS {$tabelaNome};";
        }

    }

    static function sqlNoticiasCategoriasRelacionamento($id, $tipo) {

        $tabelaNome = self::getPrefix($id, "rex_noticiasxcat");

        if($tipo == "insert") {

            return "CREATE TABLE IF NOT EXISTS {$tabelaNome} (
                        id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        noticias_id int(11) DEFAULT NULL,
                        noticiascat_id int(11) DEFAULT NULL
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        }else if($tipo == "drop") {
            return "DROP TABLE IF EXISTS {$tabelaNome};";
        }

    }

    static function sqlEquipe($id, $tipo) {

        $tabelaNome = self::getPrefix($id, "modulo_equipe");

        if($tipo == "insert") {

            return "CREATE TABLE IF NOT EXISTS {$tabelaNome} (
                      id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      usuario_master_id int(11) NOT NULL,
                      nome varchar(50) DEFAULT NULL,
                      sobrenome varchar(120) DEFAULT NULL,
                      email varchar(100) DEFAULT NULL,
                      imagemSrc varchar(250) DEFAULT NULL,
                      senha varchar(100) DEFAULT NULL,
                      celular varchar(25) DEFAULT NULL,
                      endPais varchar(50) DEFAULT NULL,
                      endEstado varchar(50) DEFAULT NULL,
                      endCidade varchar(50) DEFAULT NULL,
                      emailConfirmado int(11) NOT NULL DEFAULT 0,
                      datahora datetime DEFAULT NULL,
                      datahora_deleted datetime DEFAULT NULL,
                      senhaHashRecovery varchar(250) DEFAULT NULL
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        } else if($tipo == "drop") {
            return "DROP TABLE IF EXISTS {$tabelaNome};";
        }

    }

    static function sqlPesquisaInterna($id, $tipo) {

        $tabelaNome = self::getPrefix($id, "modulo_pesquisainterna");

        if($tipo == "insert") {

            return "CREATE TABLE IF NOT EXISTS {$tabelaNome} (
                      id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      estadocivil varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
                      escolaridade varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                      faixasalarial varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
                      sexo varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
                      idade varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
                      votariaProporcional varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
                      naoVotariaProporcional varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
                      votariaMajor varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
                      naoVotariaMajor varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
                      localizacao varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
                      datahora_open datetime DEFAULT NULL,
                      datahora datetime DEFAULT NULL,
                      datahora_deleted datetime DEFAULT NULL
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        } else if($tipo == "drop") {
            return "DROP TABLE IF EXISTS {$tabelaNome};";
        }

    }

    static function sqlPesquisaInternaProblemasBairroRelacionamento($id, $tipo) {

        $tabelaNome = self::getPrefix($id, "rex_pesquisainternaxproblemabairro");

        if($tipo == "insert") {

            return "CREATE TABLE IF NOT EXISTS {$tabelaNome} (
                      id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      pesquisa_id int(11) DEFAULT NULL,
                      problema_id int(11) DEFAULT NULL
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        } else if($tipo == "drop") {
            return "DROP TABLE IF EXISTS {$tabelaNome};";
        }

    }

}
