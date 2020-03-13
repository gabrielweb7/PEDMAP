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
        <ul>

            @foreach(App\Menu::where('tipo','=','developer')->where('visivel','=','1')->orderBy('ordem','asc')->get() as $menu)

                @php
                    $href = ($menu->route_name)?route($menu->route_name):$menu->href;
                    $href = (empty($href))?"#":$href;
                @endphp

                <li @if( (Request::is($menu->route_uri) or Request::is($menu->route_uri.'/*')) and !empty($menu->route_uri)) class="active" @endif> <a href="{{ $href }}"> {{ $menu->nome }} </a> </li>

            @endforeach

            <li> <a href="{{ route('logout') }}" class="logout"> <i class="fas fa-power-off"></i> <span>SAIR</span> </a> </li>

        </ul>
    </div>

    <!-- Clear Floats -->
    <div class="clear"></div>

</header> <!-- fim autenticacaoContainer -->