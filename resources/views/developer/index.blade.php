@extends('developer.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- header -->
    @include('developer.includes.header')

    <!-- section conteudo -->
    <section class="conteudo">

        <!-- container -->
        <div class="container">

            <!-- secBoxTitle -->
            <div class="secBoxTitle2">
                Dashboard
            </div>


                {{ App\Usuarios::count() }} Usuarios (Registros)

            <br >

                {{ App\Logs::count() }} Logs (Registros)

            <br >

            {{ App\Menu::count() }} Menu Itens (Registros)

            <br >

            {{ App\SystemConfig::count() }} SystemConfig (Registros)

        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection