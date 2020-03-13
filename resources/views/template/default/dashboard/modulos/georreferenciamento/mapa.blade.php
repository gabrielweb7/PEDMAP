@extends('template.default.dashboard.layouts.app')

@section('title', $menuItem->nome.' > Listagem')

@section('content')

    <!-- header -->
    @include('template.default.dashboard.includes.header')


    @php 

        $bairroRegioes = App\BairrosRegioes::get();
        
        $z = 0;
        $_bairro_exibicao = [];
        $_coords = [];
        $rest = [];
        $color = [];

        $_regioes = [];


        for($i=0;$i < $bairroRegioes->count();$i++) {

          

            $coordenadas = App\Coordenadas::where('id_referencia','=',$bairroRegioes[$i]->id)->get();

          
            if($coordenadas->count()) {

                $_regioes[$i]['regiao'] = $bairroRegioes[$i];
                $_regioes[$i]['coordenadas'] = "";

                foreach($coordenadas as $coordenada){
                    
                    $_regioes[$i]['coordenadas'] .= "{lat: ".trim($coordenada->lng).", lng: ".trim($coordenada->lat)."},\n";
                
                }

                $_regioes[$i]['coordenadas'] = "[".substr($_regioes[$i]['coordenadas'], 0, -2)."]";

            }

        }


        

      //<!-- echo "<pre>";

       // for($i=0; $i < count($_coords); $i++) {
       //    echo $_bairro_exibicao[$i]."<br />";
      //     echo $_coords[$i]."<br /><br />";
     //   }
      
   // echo "</pre>"; -->

    
     
    @endphp

    <!-- Map -->
    <div id="map" class="map-geo"> </div>

    <!-- Script -->
    <script>  
    
        var map;
        var infoWindow;
     
        function initMap() {

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: -20.478803, lng: -54.658757},
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                streetViewControl: false,
                mapTypeControl: false
            });

            infoWindow = new google.maps.InfoWindow;

            google.maps.event.addListener(map, "click", function(event) {
                infoWindow.close();
            });
            
            /* Create Poligonos */
            @for($i = 0; $i < count($_regioes); $i++) 


                /* {{ $_regioes[$i]['regiao']->bairro }} */

               var object = createPoligon({{$_regioes[$i]['coordenadas']}},'#'+Math.floor(Math.random()*16777215).toString(16),'#000000');

               object.addListener('click', function(event) { clickSelection(event, '{{$_regioes[$i]['regiao']->id}}'); });
            
            @endfor


        }

       
        
        function clickSelection(event, regiaoId) {

            console.log('clickSelection(event,"'+regiaoId+'");'); 
            console.log(event);

            var data = {
                '_token': getHiddenToken(),
                'regiaoId':regiaoId
            }

            $.ajax({
                type: 'post',
                url: getDomainBaseUrl()+'/georreferenciamento/ajax/getInfoWindowRegiao',
                data: data,
                beforeSend: function () {

                    showInfoWindow("<img src='https://imgur.com/eS1rkWq.png' style='    height: 35px; margin-left: 9px;' /> ", event.latLng);

                },
                success: function (data) {
                    setTimeout(function() { 
                        infoWindow.setContent(data);
                        console.log(event.latLng);
                        map.panTo(event.latLng);
                        var infoBoxHeight = $('div.gm-style-iw').outerHeight();
                        map.panBy(0,-(infoBoxHeight/2));
                    },500);
                }
            });
       
        }

        function showInfoWindow(contentString, positionlatLng) { 
            infoWindow.setContent(contentString);
            infoWindow.setPosition(positionlatLng);
            infoWindow.open(map);
        }

        function createPoligon(coords,fillColor,strokeColor) { 

            // Construct the polygon.
            var bermudaTriangle = new google.maps.Polygon({
                paths: coords,
                strokeColor: strokeColor,
                strokeOpacity: 0.8,
                strokeWeight: 3,
                fillColor: fillColor,
                fillOpacity: 0.35
            });

            bermudaTriangle.setMap(map);

            return bermudaTriangle;

        }

    </script>

    <!-- Script Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAU4boHYZInUpjUMXop3a59ju5k3Vlib3c&callback=initMap" async defer></script>

    <!-- Preload Images -->
    <div id="preload">
        <img src="https://imgur.com/eS1rkWq.png" alt="">
    </div>

    <!-- modalNoticiasList -->    
    <div id="modalNoticiasList" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Tiradentes | Notícias </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                     <!-- modalTable -->
                    <table id="modalTable">

                        <thead>
                            <td> Titulo </td>
                            
                            <td style="width:10%; text-align:center;"> Favorito </td>
                           
                            <td style="width:15%; text-align:center;"> Data </td>

                            <td style="width:8%;">  </td>
                        </thead>
                        
                        <tbody> 

                            <!-- Alimentado via ajax -->
                        
                        </tbody>

                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- modalNoticiasForm -->    
    <div id="modalNoticiasForm" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Editar Notícia </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- id -->
                    <input type="hidden" name="id" id="id" value="" />
                    
                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label for="retranca">Retranca</label>
                            <input type="text" class="form-control" id="retranca" name="retranca" placeholder="" value="">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="resumo">Resumo</label>
                            <textarea id="summernote" name="resumo" style="display:none;"></textarea>
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="divulgacao">Divulgação</label>
                            <input type="text" class="form-control" id="divulgacao" name="divulgacao" placeholder="" value="">
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="descricao">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" value="">
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="favorita">Importante</label>
                            <select class="form-control" id="favorita" name="favorita">
                                <option value="1"> Sim </option>
                                <option value="0" selected> Não </option>
                            </select>
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" selected> Publico </option>
                                <option value="0"> Privado </option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="imagem">Imagem</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" placeholder="">

                            <!-- Preview Image and Delete -->
                            <div class="imagePreviewAndDelete">

                                <!-- img -->
                                <img src="" />

                                <!-- actions -->
                                <div class="actions">
                                    <a href="javascript:void(0);" title="Remover Imagem"> <i class="far fa-trash-alt"></i> </a>
                                </div>

                            </div>


                        </div>

                        <div class="form-group col-lg-6">
                            <label for="arquivo">Arquivo</label>
                            <input type="file" class="form-control" id="arquivo" name="arquivo" placeholder="">

                            <!-- Preview Image and Delete -->
                            <div class="arquivoPreviewAndDelete">

                                <!-- Link -->
                                <a href="#" id="linkArquivo" target="_blank"> Download do Arquivo </a>

                                <!-- actions -->
                                <div class="actions">
                                    <a href="javascript:void(0);" id="deletarArquivo" title="Remover Anexo"> <i class="far fa-trash-alt"></i> </a>
                                </div>

                            </div>
                            
                        </div>

                        <div class="form-group col-lg-12">
                            <div><b>Categorias</b></div>
                            @foreach(App\Noticiascat::where('visivel','=','1')->whereNull('datahora_deleted')->get() as $categoria)
                                 <!-- checkBoxContainer -->
                                <div class="checkBoxContainer">
                                    <input type="checkbox" value="{{ $categoria->id }}" id="defaultCheck_{{ $categoria->id }}" name="categorias[]">
                                    <label class="form-check-label" for="defaultCheck_{{ $categoria->id }}">
                                        {{ $categoria->categoria }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group col-lg-12">
                            <div id="criadoEm">
                                <div> <b>Criado em</b></div>
                                <div id='datahora'> 00/00/0000 00:00 </div>
                            </div>
                        </div>
                    
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Atualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modalEventsList -->    
    <div id="modalEventsList" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Tiradentes | Eventos </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <!-- modalTable -->
                    <table id="modalTable">

                        <thead>
                            <td> Titulo </td>
                            
                            <td style="width:10%; text-align:center;"> Categoria </td>
                           
                            <td style="text-align:center;"> N° Participantes  </td>

                            <td style="text-align:center;"> Data do Evento </td>

                            <td style="width:8%;">  </td>
                        </thead>
                        
                        <tbody> 

                            <!-- Alimentado via ajax -->
                        
                        </tbody>

                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <!-- <button type="button" class="btn btn-primary">Atualizar</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- modalGeralList -->    
    <div id="modalGeralList" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Tiradentes | Anotações </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    ..

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <!-- <button type="button" class="btn btn-primary">Atualizar</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- modalAnotacoesList -->    
    <div id="modalAnotacoesList" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Tiradentes | Anotações </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                     <!-- modalTable -->
                    <table id="modalTable">

                        <thead>
                            <td> Nota </td>
                            <td style="width:15%; text-align:center;"> Data </td>
                            <td style="width:8%;">  </td>
                        </thead>
                        
                        <tbody> 

                            <!-- Alimentado via ajax -->
                        
                        </tbody>

                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modalAnotacoesUpdateShow -->    
    <div id="modalAnotacoesUpdateShow" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Editar Anotação </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                   UpdateShow

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                </div>
            </div>
        </div>
    </div>


    <!-- modalGraficos -->    
    <div id="modalGraficos" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Tiradentes | Gráficos </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <!-- nav -->
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Gráfico 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Gráfico 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Gráfico 3</a>
                        </li>
                    </ul>

                    <!-- message -->
                    <div style='padding:50px; text-align:center;'> Nenhum gráfico disponível! </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                </div>
            </div>
        </div>
    </div>

@endsection
        
  