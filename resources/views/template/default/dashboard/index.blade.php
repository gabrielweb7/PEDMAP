@extends('template.default.dashboard.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- header -->
    @include('template.default.dashboard.includes.header')

    <!-- section conteudo -->
    <section class="conteudo">

        <!-- container -->
        <div class="container">

            <!-- secBoxTitle -->
            <div class="secBoxTitle2">
                Dashboard
            </div>

            <div class='row'>

            <div class="col-lg-12">

                <!-- homeBox -->
                <div class='homeBox'>
                    <!-- homeBoxTitle -->
                    <div class='homeBoxTitle'> Eventos <a href="{{ route('modulo-eventos-index') }}" class='btnRight'> Ver mais <i class="fas fa-caret-right"></i> </a></div>
                    <!-- homeBoxBody -->
                    <div class='homeBoxBody'>
                        <!-- homeBoxList -->
                        <div class="homeBoxList">
                        
                            <table class='homeBoxTable'>
                                <thead>
                                    <tr>
                                        <td> Nome </td>
                                        <td > Tipo </td>
                                        <td > Bairro </td>
                                        <td style='text-align:center;'> Data </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Eventos::whereNull('datahora_deleted')->orderBy('datahora','desc')->limit(5)->get() as $evento)

                                        @php 
                                            if($evento->categoria == "bandeiraco") { $evento->categoria = "Bandeiraço"; }       
                                            else if($evento->categoria == "reuniao") { $evento->categoria = "Reunião"; }       
                                            else if($evento->categoria == "comicio") { $evento->categoria = "Comício"; }       
                                            else if($evento->categoria == "caminhada") { $evento->categoria = "Caminhada"; }       
                                            else if($evento->categoria == "carreata") { $evento->categoria = "Carreata"; }       
                                            else { $evento->categoria = "Nenhum"; }
                                        @endphp

                                        <tr>
                                            <td>  {{ $evento->titulo }} </td>
                                            <td >  {{ $evento->categoria }} </td>
                                            <td>  {{ $evento->bairro }} </td>
                                            <td style='text-align:center;'>  {{ $evento->datahora->format('d/m/Y - H:i') }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          
                        </div>
                    </div>
                </div>

                </div>




                <div class="col-lg-12">

                <!-- homeBox -->
                <div class='homeBox'>
                    <!-- homeBoxTitle -->
                    <div class='homeBoxTitle'> Últimas Notícias <a href="{{ route('modulo-noticias-index') }}" class='btnRight'> Ver mais <i class="fas fa-caret-right"></i> </a> </div>
                    <!-- homeBoxBody -->
                    <div class='homeBoxBody'>
                        <!-- homeBoxList -->
                        <div class="homeBoxList">
                        @foreach(App\Noticias::whereNull('datahora_deleted')->orderBy('datahora','desc')->limit(5)->get() as $noticia)

                            <div class='homeBoxListLine' style='padding:8px 14px;'> {{ $noticia->retranca }} </div>

                        @endforeach
                        </div>
                    </div>
                </div>

                </div>

            </div>

            
        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection