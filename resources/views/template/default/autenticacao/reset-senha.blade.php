@extends('template.default.autenticacao.layouts.app')

@section('title', 'Login')

@section('content')

    <!-- autenticacaoContainer -->
    <div class="autenticacaoContainer">

        <!-- form -->
        <form action="{{ route('resetSenhaPost', $hash) }}" method="post">

        @csrf

        <input type="hidden" name="usuario_master_id" value="{{ $usuario_master_id }}" />
        <input type="hidden" name="usuario_id" value="{{ $usuario_id }}" />

        <!-- logo -->
            <div class="logo">
                <a href="{{ route('index') }}"><img src="{{ Sistema::get('logo') }}" alt="" /></a>
            </div>

                <!-- formContainer -->
            <div class="formContainer">

                <!-- form-group -->
                <div class="form-group">
                    <label for="novaSenha">Nova Senha</label>
                    <input type="password" name="novaSenha" class="form-control" id="novaSenha" placeholder="" required />
                    <!-- errorText -->
                    <!-- <small class="errorText">Este e-mail não existe em nosso banco de dados!</small> -->
                </div>

                <!-- form-group -->
                <div class="form-group">
                    <label for="confirmarNovaSenha">Confirmar Senha</label>
                    <input type="password" name="confirmarNovaSenha" class="form-control" id="confirmarNovaSenha" placeholder="" required  />
                </div>

                @if($errors->any())
                    <div class="alert alert-danger" role="alert" style="padding: 12px;    font-size: 12px;">

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    - {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(request()->get('erro'))

                    <!-- divErroMessage -->
                    <div class="errorMessage">  As senhas não coincidem!  </div>

                @endif

            <!-- submit -->
                <button type="submit" class="btn btn-primary fx-ease-out-500">ATUALIZAR</button>

            </div>

        </form>

    </div> <!-- fim autenticacaoContainer -->

@endsection