<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Request Validates */
use App\Http\Requests\modulo\usuarios\RecuperarSenha;
use App\Http\Requests\modulo\usuarios\ResetSenha;
use App\Http\Requests\modulo\usuarios\ConfirmarConta;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use App\Usuarios;

/* mails */
use App\Mail\UsuarioRecuperarSenha;
use App\Mail\UsuarioConfirmarConta;

class AuthController extends Controller
{

    var $DB = false;
    var $usuario = false;
    var $request = false;
    var $usuario_master_id = 0;

    /* Página de Login */
    public function login() {

        /* Se já estiver logado.. redirecionar! */
        if($this->getAuth()) {

            /* Redirecionar para dashboard */
            return redirect()->route('index');
        }

        return view("template.default.autenticacao.login");
    }

    public function autenticarUsuarioEquipe() { 

        $usuariosClientes = Usuarios::where('tipo','=','100');

        if($usuariosClientes->count() > 0) { 

            foreach($usuariosClientes->get() as $cliente) { 

                if(Schema::hasTable('zc_'.$cliente->id.'_modulo_equipe')) {
                
                    $dbCliente = DB::table('zc_'.$cliente->id.'_modulo_equipe')->where('email','=',strip_tags($this->request->email));

                    if($dbCliente->count()) {

                        $this->DB = $dbCliente; 
                        $this->usuario = $dbCliente->first(); 
                        $this->usuario_master_id = $cliente->id;
                        
                        return true;
                    
                    }

                }

            }

        }

        return false;
    }
    
    public function autenticarUsuario() { 

        $usuario = Usuarios::where('email','=',strip_tags($this->request->email));
        
        if($usuario->count()) {
            $this->DB = $usuario; 
            $this->usuario = $usuario->first();
            return true;
        } 

        return false;
    }

    /* Autenticar usuario via POST */
    public function autenticar(Request $r) {

        #if(!$this->captcha->getCaptcha($r->grecaptchaKey)->success) {
        #    return 0;
        #}

        if(!$r->email or !$r->senha) {
            return redirect()->route('login', ['erro' => 1]);
        }

        $this->request = $r;

        /* Autenticar Usuario ou Usuario das Equipes */
        if($this->autenticarUsuario() or $this->autenticarUsuarioEquipe()) {

            /* Verifica se email está confirmado  */
            if(!$this->usuario->emailConfirmado) { 

                /* Update Hash Recovery */
                $this->usuario->senhaHashRecovery = $this->criarHashMd5ForEmail();
                $this->DB->update(['senhaHashRecovery' => $this->usuario->senhaHashRecovery]);
            
                //return json_encode($this->usuario);

                /* Enviar EMail de Confirmacao */
                Mail::to($this->usuario->email)->send(new UsuarioConfirmarConta($this->usuario));

                 /* Erro */
                return $this->actionErrorNoEmailConfirmado();
            }

            /* Verifica Hash Senha Usuario */
            if($this->verificaHashSenhaUsuario()) { 
            
                /* Sucesso */
                return $this->actionLoginUser();
            
            }

        }

        /* Erro */
        return $this->actionErrorLogin();
        
    }

    public function actionLoginUser() { 

        Session::put('auth', 1);

        // Usuario
        Session::put('id', $this->usuario->id);
        Session::put('nome', $this->usuario->nome);
        Session::put('sobrenome', $this->usuario->sobrenome);
        Session::put('email', $this->usuario->email);
        Session::put('senha', $this->usuario->senha);

        // Usuario Cliente Master > Acima da equipe > 1
        Session::put('usuario_master_id', $this->usuario_master_id);

        // Tipo
        if(isset($this->usuario->tipo)) { 
            // Usuarios acima de equipe
            Session::put('tipo', $this->usuario->tipo);
        } else { 
            // Equipe
            Session::put('tipo', 101);
        }

        // Cidade
        Session::put('cidade_id', $this->usuario->cidade->id);
        Session::put('cidade_nome', $this->usuario->cidade->nome);
        Session::put('cidade_bandeira', $this->usuario->cidade->bandeira);

        // Estados
        Session::put('estado_id', $this->usuario->cidade()->first()->estado->id);
        Session::put('estado_nome', $this->usuario->cidade()->first()->estado->nome);
        Session::put('estado_sigla', $this->usuario->cidade()->first()->estado->sigla);
        Session::put('estado_bandeira', $this->usuario->cidade()->first()->estado->bandeira);

        $object_json = array("usuario_master_id" => Session::get('usuario_master_id'), "tipo" => Session::get('tipo'), "id" => Session::get('id'), "email" => Session::get('email'));
       
        LogsController::create('autenticacao','Usuario "'.$this->usuario->nome.'" logou no sistema!', 'sucesso', $this->usuario->id, $object_json);
      
        return redirect()->route('index');
    }

    /* Retorna true caso usuario esteja logado */
    public function getAuth() {
        if(Session::has('auth')) {
            if(Session::get('auth')) {
                return true;
            }
        }
        return false;
    }

    /* Funcao criada para destruir todas as sessoes */
    public function destroy() {
        Session::flush();
    }

    public function confirmarConta(Request $request) {

        $this->request = $request;

        $hash = $request->hash;
        
        #return dd($request->all());

        if($request->confirmado) { 
            return view("template.default.autenticacao.confirmar-senha", compact('usuario','hash'));
        }

        /* usuario_master_id */
        $usuario_id = $request->usuario_id;
        $usuario_master_id = (isset($request->usuario_master_id))?$request->usuario_master_id:$this->usuario_master_id;

        /* Confirmar Usuario Nivel 100 ou Admin */
        if(!$usuario_master_id) { 

            /* Confirmar Usuario */
            $this->DB = Usuarios::where('id','=',($usuario_id));
        
        } else { 

            if(!Schema::hasTable('zc_'.$usuario_master_id.'_modulo_equipe')) {
                return redirect()->route('login');
            }

            /* Confirmar */
            $this->DB = DB::table('zc_'.$usuario_master_id.'_modulo_equipe')->where('id','=',$usuario_id);

        }

        /* Se usuario não existir.. volar para login */
        if(!$this->DB->count()) { 
            return redirect()->route('login');
        }

        $this->usuario = $this->DB->first();
        
        /* Caso usuario já esteja com emailConfirmado = 1 ir para login */
        if($this->usuario->emailConfirmado) { 
            return redirect()->route('login');
        }

        /* Se HashRecovery for diferente.. enviar um novo.. */
        if($this->usuario->senhaHashRecovery != $request->hash) {

            /* Update Hash Recovery */
            $this->usuario->senhaHashRecovery = $this->criarHashMd5ForEmail();
            $this->DB->update(['senhaHashRecovery' => $this->usuario->senhaHashRecovery]);
        
            //return json_encode($this->usuario);

            /* Enviar EMail de Confirmacao */
            Mail::to($this->usuario->email)->send(new UsuarioConfirmarConta($this->usuario));

            return $this->actionErrorConfirmarContaHashExpirado();
        }

        $usuario = $this->usuario;
      

        return view("template.default.autenticacao.confirmar-senha", compact('usuario','hash','usuario_master_id','usuario_id'));

    }

    public function confirmarContaPost(ConfirmarConta $request) {

        /* Verifica se as senhas estão iguais.. */
        if($request->novaSenha != $request->confirmarNovaSenha) {
            return redirect()->route('confirmarConta', ['hash' => $request->hash, 'usuario_master_id' => $request->usuario_master_id, 'usuario_id' => $request->usuario_id, 'erro' => 1]);
        }

        $usuario_master_id = $request->usuario_master_id;

        /* Confirmar Usuario Nivel 100 ou Admin */
        if(!$request->usuario_master_id) { 

            /* Confirmar Usuario */
            $this->DB = Usuarios::where('senhaHashRecovery','=',($request->hash));

        } else { 

            if(!Schema::hasTable('zc_'.$usuario_master_id.'_modulo_equipe')) {
                return redirect()->route('login');
            }

            /* Confirmar */
            $this->DB = DB::table('zc_'.$usuario_master_id.'_modulo_equipe')->where('senhaHashRecovery','=',$request->hash);
            
        }

        /* Se usuario não existir.. volar para login */
        if(!$this->DB->count()) { 
            return redirect()->route('login');
        }
    
        $this->usuario = $this->DB->first();

        #return json_encode($this->usuario);

        $this->DB->update(['senha' => Hash::make($request->novaSenha), 'senhaHashRecovery' => '', 'emailConfirmado' => 1]);

        return redirect()->route('confirmarConta', ['hash' => $request->hash, 'usuario_master_id' => $usuario_master_id, 'usuario_id' => $request->usuario_id, 'confirmado' => 1]);
    }







    /* Página de Logout */
    public function logout() {

        /* Destruir sessoes de autenticacao */
        $this->destroy();

        /* Redirecionar */
        return redirect()->route('login');
    }

    public function isDeveloper() {

        $usuario = Usuarios::where('id', '=', Session::get('id'))->first();

        if($usuario->tipo == 255) {
            return 1;
        }

        return 0;

    }

    public function verificaHashSenhaUsuario() { 
        if(Hash::check(strip_tags($this->request->senha), $this->usuario->senha)) {
          return true;
        }
        return false;
    }

    public function criarHashMd5ForEmail() {

        $hashMd5 = md5(rand(100000000,999999999)).md5(rand(100000000,999999999)).md5(rand(100000000,999999999)).md5(rand(100000000,999999999)).md5(rand(100000000,999999999));

        return $hashMd5;

    }

    public function recuperarSenha(Request $request) {

        return view("template.default.autenticacao.recuperar-senha");

    }

    public function recuperarSenhaPost(RecuperarSenha $request) {

        $this->request = $request;

        if($this->request->email) {

            /* Confirmar Usuario */
            $this->DB = Usuarios::where('email','=',($this->request->email));

            if($this->DB->count()) {
                
                $this->usuario = $this->DB->first(); 

            } else { 

                $usuariosClientes = Usuarios::where('tipo','=','100');

                if($usuariosClientes->count() > 0) { 

                    foreach($usuariosClientes->get() as $cliente) { 

                        if(Schema::hasTable('zc_'.$cliente->id.'_modulo_equipe')) {
                        
                            $this->DB = DB::table('zc_'.$cliente->id.'_modulo_equipe')->where('email','=',strip_tags($this->request->email));

                            if($this->DB->count()) {

                                $this->usuario = $this->DB->first(); 
                                $this->usuario_master_id = $cliente->id;
                                
                                break;

                            }

                        }

                    }

                }
            
            }

            /* Email encontrado */
            if($this->DB->count()) { 

                $this->usuario->senhaHashRecovery = $this->criarHashMd5ForEmail();
                $this->DB->update(['senhaHashRecovery' => $this->usuario->senhaHashRecovery]);                
                                
                Mail::to($this->usuario->email)->send(new UsuarioRecuperarSenha($this->usuario));

                return redirect()->route('recuperarSenha', ['enviado' => 1]);

            }

        }

        return redirect()->route('login');
       
    }

    public function resetSenha(Request $request) {

        $this->request = $request;

        $hash = $this->request->hash;
        $usuario_id = $request->usuario_id;
        $usuario_master_id = $request->usuario_master_id;

        /* Se Hash Não existir.. ir para login */
        if(!$this->request->hash) { 
            return redirect()->route('login'); 
        }

        /* Find Usuario */
        $this->DB = Usuarios::where('senhaHashRecovery','=',($this->request->hash));

        if($this->DB->count()) {
            
            $this->usuario = $this->DB->first(); 

        } else { 

            $usuariosClientes = Usuarios::where('tipo','=','100');

            if($usuariosClientes->count() > 0) { 

                foreach($usuariosClientes->get() as $cliente) { 

                    if(Schema::hasTable('zc_'.$cliente->id.'_modulo_equipe')) {
                    
                        $this->DB = DB::table('zc_'.$cliente->id.'_modulo_equipe')->where('senhaHashRecovery','=',($this->request->hash));

                        if($this->DB->count()) {

                            $this->usuario = $this->DB->first(); 
                            $this->usuario_master_id = $cliente->id;
                            
                            break;

                        }

                    }

                }

            }
        
        }

        /* Caso não encontrar registro.. redirecionar para login  */
        if(!$this->DB->count()) {
            return redirect()->route('login');
        }

        $usuario = $this->usuario;
      
        return view("template.default.autenticacao.reset-senha", compact('usuario','hash','usuario_master_id','usuario_id'));

    }

    public function resetSenhaPost(ResetSenha $request) {

        /* Se a senha for diferente */
        if($request->novaSenha != $request->confirmarNovaSenha) {
            return redirect()->route('resetSenha', ['hash' => $request->hash, 'usuario_master_id' => $request->usuario_master_id, 'usuario_id' => $request->usuario_id,'erro' => 1]);
        }

        $usuario_master_id = $request->usuario_master_id;

        /* Confirmar Usuario Nivel 100 ou Admin */
        if(!$request->usuario_master_id) { 

            /* Confirmar Usuario */
            $this->DB = Usuarios::where('senhaHashRecovery','=',($request->hash));

        } else { 

            if(!Schema::hasTable('zc_'.$usuario_master_id.'_modulo_equipe')) {
                return redirect()->route('login');
            }

            /* Confirmar */
            $this->DB = DB::table('zc_'.$usuario_master_id.'_modulo_equipe')->where('senhaHashRecovery','=',$request->hash);
            
        }

        /* Se usuario não existir.. volar para login */
        if(!$this->DB->count()) { 
            return redirect()->route('login');
        }
    
        $this->usuario = $this->DB->first();

        #return json_encode($this->usuario);

        $this->DB->update(['senha' => Hash::make($request->novaSenha), 'senhaHashRecovery' => '', 'emailConfirmado' => 1]);

        return redirect()->route('recuperarSenha', ['hash' => $request->hash, 'enviado' => 2]);
    }

    
    public function actionErrorNoEmailConfirmado() { 
         
        $object_json = array("email" => $this->request->email, "senha" => $this->request->senha);
        
        LogsController::create('autenticacao','Tentativa de login com e-mail não confirmado: "'.$this->request->email.'" no sistema!', 'erro', -1, $object_json);

        return redirect()->route('login', ['erro' => 2]);
   
   }

   public function actionErrorLogin() { 
        
        $object_json = array("email" => $this->request->email, "senha" => $this->request->senha);
        
        LogsController::create('autenticacao','Tentativa de login com e-mail: "'.$this->request->email.'" no sistema!', 'erro', -1, $object_json);

        return redirect()->route('login', ['erro' => 1]);
   
   }

   public function actionErrorRecuperarContaHashExpirado() { 
        
       $object_json = array($this->request);
       
       LogsController::create('hashExpirado','Tentativa recuperar conta com hash expirado!', 'erro', -1, $object_json);

       return redirect()->route('login', ['erro' => 3]);
  
   }

    public function actionErrorConfirmarContaHashExpirado() { 
                
        $object_json = array($this->request);
        
        LogsController::create('hashExpirado','Tentativa de confirmar a conta com hash expirado!', 'erro', -1, $object_json);

        return redirect()->route('login', ['erro' => 3]);

    }


}
