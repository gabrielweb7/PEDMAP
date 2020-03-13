@extends('template.default.dashboard.layouts.app')

@section('title', $menuItem->nome.' > Antigo')

@section('content')

    <!-- header -->
    @include('template.default.dashboard.includes.header')

    <iframe src="https://antigo.pedmap.com.br/cpdp/mapa/mapa_google.php" style="    width: 100%;
    height: 100% !important;
    min-height: 100% !important;
    margin-bottom: auto;
    position: absolute;
    top: 0px;
    left: 0px;z-index:1;" frameborder="0"></iframe>

@endsection