@php

    use App\Http\Controllers\ModulosController;

@endphp

<!-- header -->
<header>

    <!-- logo -->
    <div class="logo">
        <a href="{{ route('index') }}">
            <img src="https://imgur.com/VSR2FSe.png" />
        </a>
    </div>

    <!-- menu -->
    <div class="menu">

        <!-- ul -->
        <ul>

            @foreach(ModulosController::getAllMenu() as $menu)

                @if($menu->permissoes('ver'))  

                    @php
                        $href = ($menu->route_name)?route($menu->route_name):$menu->href;
                        $href = (empty($href))?"#":$href;
                    @endphp

                    <li class="{{ ModulosController::isMenuPaiActive($menu->route_uri) }}">

                        <a href="{{ $href }}" @if($href=="#nc") style="cursor:default; " @endif> {{ $menu->nome }} </a>

                        @if(ModulosController::getAllMenuFilhos($menu->id)->count())

                            <!-- submenu -->
                            <ul>

                                @foreach(ModulosController::getAllMenuFilhos($menu->id)->get() as $submenu1)

                                    @if($submenu1->permissoes('ver')) 

                                        @php
                                            $hrefSub = ($submenu1->route_name)?route($submenu1->route_name):$submenu1->href;
                                            $hrefSub = (empty($hrefSub))?"#":$hrefSub;
                                        @endphp

                                        <li class="{{ ModulosController::isMenuFilhoActive($submenu1->route_name) }}">

                                            <a href="{{ $hrefSub }}"> {{ $submenu1->nome }} </a>

                                        </li>

                                    @endif

                                @endforeach

                            </ul>
                        @endif

                    </li>

                @endif

            @endforeach

            <li class="#">
                <a href="#" onclick="alert('Em Desenvolvimento!');" id="changeMunicipio"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Alterar Cidade"> 
                    <img src="{{ Session::get('cidade_bandeira') }}" alt="{{ Session::get('cidade_nome') }} - {{ Session::get('estado_sigla') }}" /> 
                </a>
            </li>

            <!-- logout -->
            <li> <a href="{{ route('logout') }}" class="logout"> <i class="fas fa-power-off"></i> <span> SAIR </span> </a> </li>

        </ul> <!-- end ul -->

    </div>

    <!-- Clear Floats -->
    <div class="clear"></div>

</header> <!-- fim autenticacaoContainer -->