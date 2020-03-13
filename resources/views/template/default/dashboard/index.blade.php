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
                    <div class='homeBoxTitle'> Últimas Notícias <a href="{{ route('modulo-noticias-index') }}" class='btnRight'> Ver mais <i class="fas fa-caret-right"></i> </a> </div>
                    <!-- homeBoxBody -->
                    <div class='homeBoxBody'>
                        <!-- homeBoxList -->
                        <div class="homeBoxList">
                        @foreach(App\Noticias::whereNull('datahora_deleted')->orderBy('datahora','desc')->limit(5)->get() as $noticia)

                            <div class='homeBoxListLine' style='padding:8px 14px;'> <a href="{{ route('modulo-noticias-update', base64_encode($noticia->id)) }}">{{ $noticia->retranca }} </a> </div>

                        @endforeach
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-lg-6">

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
                                            <td>  <a href="{{ route('modulo-eventos-update', base64_encode($evento->id)) }}">  {{ $evento->titulo }} </a> </td>
                                            <td >  <a href="{{ route('modulo-eventos-update', base64_encode($evento->id)) }}">{{ $evento->categoria }}</a> </td>
                                            <td> <a href="{{ route('modulo-eventos-update', base64_encode($evento->id)) }}"> {{ $evento->bairro }} </a></td>
                                            <td style='text-align:center;'> <a href="{{ route('modulo-eventos-update', base64_encode($evento->id)) }}">   {!! $evento->datahora->format('d/m/Y').' <br> '.$evento->datahora->format('H:i') !!} </a> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

            </div>


            <div class="col-lg-6">

                <!-- homeBox -->
                <div class='homeBox'>

                    <!-- homeBoxTitle -->
                    <div class='homeBoxTitle'> Pesquisas Internas <a href="{{ route('modulo-pesquisa-interna-index') }}" class='btnRight'> Ver mais <i class="fas fa-caret-right"></i> </a></div>

                    <!-- homeBoxBody -->
                    <div class='homeBoxBody'>
                        <!-- homeBoxList -->
                        <div class="homeBoxList">
                            
                            @php
                                
                                $npesquisas = App\PesquisaInterna::whereNull('datahora_deleted')->count();
                                
                                $masculino = App\PesquisaInterna::whereNull('datahora_deleted')->where('sexo','=','Masculino')->count();
                                $feminino = App\PesquisaInterna::whereNull('datahora_deleted')->where('sexo','=','Feminino')->count();
                                $estadocivilviuvo = App\PesquisaInterna::whereNull('datahora_deleted')->where('estadocivil','=','Viúvo')->count();
                                $estadocivilsolteiro = App\PesquisaInterna::whereNull('datahora_deleted')->where('estadocivil','=','Solteiro')->count();
                                $estadocivilcasado = App\PesquisaInterna::whereNull('datahora_deleted')->where('estadocivil','=','Casado')->count();
                 
                            @endphp

                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                            <script type="text/javascript">
                                google.charts.load("current", {packages:['corechart']});
                                google.charts.setOnLoadCallback(drawChart);
                                function drawChart() {

                                var data = google.visualization.arrayToDataTable(
                                [
                                    ["Element", "N°", { role: "style" } ],

                                    ["Masculino", {{ $masculino }}, "#3575c3"],
                                    ["Feminino", {{ $feminino }}, "#be35c3"],
                                    
                                    @if($estadocivilviuvo) 
                                        ["Estado Civil Viúvo", {{ $estadocivilviuvo }}, "#1fb94e"],
                                    @endif

                                    @if($estadocivilsolteiro) 
                                        ["Estado Civil Solteiro", {{ $estadocivilsolteiro }}, "#1fb94e"],
                                    @endif

                                    @if($estadocivilcasado) 
                                        ["Estado Civil Casado", {{ $estadocivilcasado }}, "#1fb94e"],
                                    @endif
                                    
                               

                                ]);

                                var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                                                { calc: "stringify",
                                                    sourceColumn: 1,
                                                    type: "string",
                                                    role: "annotation" },
                                                2]);

                                var options = {
                                    title: "Relatório Geral de 2020 ({{ $npesquisas}} Pesquisas)",
                                    width: '100%',
                                    height: '100%',
                                    bar: {groupWidth: "95%"},
                                    legend: { position: "none" },
                                };
                                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                                chart.draw(view, options);
                            }
                            </script>

                            <div id="columnchart_values" style="width: 100%; height: 300px;"></div>


                        </div>
                    </div>

                </div>

                </div>



              

            </div>

            
        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection