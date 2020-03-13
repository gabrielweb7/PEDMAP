@extends('template.default.autenticacao.layouts.app')

@section('title', 'Login')

@section('content')

    <!-- autenticacaoContainer -->
    <div class="autenticacaoContainer">

        <!-- form -->
        <form action="{{ route('login-autenticar') }}" method="post">

            @csrf

            <!-- logo -->
            <div class="logo">
                <img src="{{ Sistema::get('logo') }}" alt="" />
            </div>

            <!-- formContainer -->
            <div class="formContainer">

                <!-- form-group -->
                <div class="form-group">
                    <label for="exampleInputEmail1">E-mail</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required />
                    <!-- errorText -->
                    <!-- <small class="errorText">Este e-mail não existe em nosso banco de dados!</small> -->
                </div>

                <!-- form-group -->
                <div class="form-group">
                    <label for="exampleInputPassword1">Senha</label>
                    <input type="password" name="senha" class="form-control" id="exampleInputPassword1" placeholder=""required  />
                </div>
                
                @if(request()->get('erro') == 1)
                    <!-- divErroMessage -->
                    <div class="errorMessage">  Login e/ou senha de acesso incorretos  </div>
                @elseif(request()->get('erro') == 2)
                     <!-- divErroMessage -->
                     <div class="errorMessage"> A sua conta ainda não foi confirmada! <br /> Enviamos um email com link <br /> de confirmação para você!   </div>
                @elseif(request()->get('erro') == 3)
                    <!-- divErroMessage -->
                    <div class="errorMessage"> Este link está expirado! :( <br /> Estamos enviando um novo e-mail para você!  </div>
                @endif

                <!-- submit -->
                <button type="submit" class="btn btn-primary fx-ease-out-500">ENTRAR</button>

            </div>

            <!-- formBottomContainer -->
            <div class="formBottomContainer">

                <a href="{{ route('recuperarSenha') }}" style="color: #5f5f5f;"> Esqueceu sua senha? </a>

            </div>

        </form>

    </div> <!-- fim autenticacaoContainer -->

@endsection