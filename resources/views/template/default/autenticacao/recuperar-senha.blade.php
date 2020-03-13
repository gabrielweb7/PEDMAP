@extends('template.default.autenticacao.layouts.app')

@section('title', 'Login')

@section('content')

    <!-- autenticacaoContainer -->
    <div class="autenticacaoContainer">

        <!-- form -->
        <form action="{{ route('recuperarSenhaPost') }}" method="post">

        @csrf

            <!-- logo -->
            <div class="logo">
                <a href="{{ route('index') }}"><img src="{{ Sistema::get('logo') }}" alt="" /></a>
            </div>


            @if(!request()->get('enviado'))

            <!-- formContainer -->
            <div class="formContainer">



                    <!-- form-group -->
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="" required />
                    <!-- errorText -->
                    <!-- <small class="errorText">Este e-mail não existe em nosso banco de dados!</small> -->
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
            @endif

                <!-- submit -->
                <button type="submit" class="btn btn-primary fx-ease-out-500">Redefinir Senha</button>

            </div>
            @elseif(request()->get('enviado') == 1)

                <!-- formContainer -->
                <div class="formContainer2">

                    <div class="message">  Você receberá um e-mail automático contendo o link e as instruções para redefinir a senha.  </div>

                </div>

            @elseif(request()->get('enviado') == 2)

                <!-- formContainer -->
                <div class="formContainer2">

                    <div class="message">  Sua senha foi alterada com sucesso.  </div>

                </div>

            @endif

            <!-- formBottomContainer -->
            <div class="formBottomContainer">

                <a href="{{ route('index') }}" style="color: #5f5f5f;"> Voltar </a>

            </div>

        </form>

    </div> <!-- fim autenticacaoContainer -->

@endsection