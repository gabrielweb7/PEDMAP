<!doctype html>
<html lang="pt-BR">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Robots -->
    <meta name="robots" content="index, follow" />

    <!-- Title -->
    <title> {{ Sistema::get('header_title') }} - @yield('title') </title>

    <!-- Description -->
    <!-- <meta name="description" content="HTML5 - Blank Project Responsive By Gabriel Azuaga Barbosa" /> -->

    <!-- Favicon gerado em https://www.favicon-generator.org/ -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicon/1/apple-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicon/1/apple-icon-60x60.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicon/1/apple-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon/1/apple-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicon/1/apple-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicon/1/apple-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicon/1/apple-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicon/1/apple-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/1/apple-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/favicon/1/android-icon-192x192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/1/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon/1/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/1/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('img/favicon/1/manifest.json') }}" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon/1/ms-icon-144x144.png') }}" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Laravel Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Domain Base URL -->
    <meta name="domainBaseUrl" content="{{ config('app.url') }}" />

    <!-- MetaTag GooglePlus -->
    <!-- <meta itemprop="name" content="Titulo do Website (GooglePlus)" />
    <meta itemprop="description" content="Descrição do Website aqui. (GooglePlus)" />
    <meta itemprop="image" content="img/metatag-facebook/1.jpeg" /> -->

    <!-- MetaTag Facebook -->
    <!--<meta property="og:locale" content="pt_BR" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://url-do-website-aqui.com.br/" />
    <meta property="og:site_name" content="Titulo do Website (Face)" />
    <meta property="og:description" content="Descrição do Website aqui. (Face)" />
    <meta property="og:image" content="img/metatag-facebook/1.jpeg">
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="600" />-->

    <!-- Metatag Twitter -->
    <!-- <meta name="twitter:title" content="Titulo do Website (Twitter)">
    <meta name="twitter:description" content="Descrição do Website aqui. (Twitter)">
    <meta name="twitter:image" content="img/metatag-facebook/1.jpeg">
    <meta name="twitter:card" content="summary_large_image"> -->

    <!-- Bootstrap Reboot CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/4.0.0/css/bootstrap-reboot.css') }}" />

    <!-- Jquery UI CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/1.12.1/jquery-ui.min.css') }}" />

    <!-- Datetime picker -->
    <link rel="stylesheet" href="{{ asset('plugins/datetimepicker/jquery.datetimepicker.min.css') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/4.0.0/css/bootstrap.min.css') }}" />

    <!-- Bootstrap Grid CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/4.0.0/css/bootstrap-grid.min.css') }}" />

    <!-- Animate CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}" /> -->

    <!-- OwlCarrousel 2 CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2/2.3.4/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2/2.3.4/assets/owl.theme.default.css') }}" /> -->

    <!-- FancyBox3 CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/fancybox3/dist/jquery.fancybox.min.css') }}" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/5.9.0/css/all.min.css') }}" />

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/datatables.min.css') }}" />

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.css') }}" />

    <!-- include summernote css/js -->
    <link href="{{ asset('plugins/summernote/0.8.12/summernote-bs4.css') }}" rel="stylesheet">

    <!-- Style CSS HELPERS -->
    <link rel="stylesheet" href="{{ asset('css/helpers.css') }}" />

    <!-- Style CSS Template -->
    <link rel="stylesheet" href="{{ asset('templates/default/site.css') }}" />

    <!-- Style Hack IE CSS Template -->
    <link rel="stylesheet" href="{{ asset('templates/default/hack-ie.css') }}" />

    <!-- Style Responsive CSS Template -->
    <link rel="stylesheet" href="{{ asset('templates/default/responsive.css') }}" />

</head>
<body class="dashboard" style="background-image: url('https://imgur.com/OZJHNWg.png');background-size: cover;">

    @yield('content')

    <!-- footer -->
    <footer class="fx-ease-out-500">

        <!-- container -->
        <div class="container">

            {{ Sistema::get('system_copyright') }} | <span class="version"> Version: {{ Sistema::get('system_version') }} </span>

        </div>

    </footer>

    <!-- // ~~ SCRIPTS ~~ // -->

    <script>
        
        // :D Variables 
        var _route_select2_bairro_id = "{{ route('apiv2-getJsonBairrosForSelect2') }}";
        var _route_select2_estado_id = "{{ route('apiv2-getJsonEstadosForSelect2') }}";
        var _route_select2_cidade_id = "{{ route('apiv2-getJsonCidadesForSelect2') }}";

        var _list_regiao = [
            @foreach(App\BairrosRegioes::select('regiao')->whereNull('datahora_deleted')->groupBy('regiao')->get() as $bairro)

                "{{ $bairro->regiao }}",

            @endforeach
        ];
        
    </script>

    <!-- Jquery -->
    <script src="{{ asset('plugins/jquery/3.4.1/jquery-3.4.1.min.js') }}"></script>

    <!-- Jquery UI -->
    <script src="{{ asset('plugins/jquery-ui/1.12.1/jquery-ui.min.js') }}"></script>

    <!-- Datetime picker -->
    <script src="{{ asset('plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js') }}"></script>

    <!-- OwlCarousel 2 JS -->
    <!-- <script src="{{ asset('plugins/OwlCarousel2/2.3.4/owl.carousel.min.js') }}"></script> -->

    <!-- Fancybox3 JS -->
    <script src="{{ asset('plugins/fancybox3/dist/jquery.fancybox.min.js') }}"></script>

    <!-- FontAwesome -->
    <!-- <script src="{{ asset('plugins/fontawesome/5.9.0/js/all.min.js') }}"></script> -->

    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/0.8.12/summernote-bs4.min.js') }}"></script>

    <!-- Icon Whats -->
    <script src="{{ asset('plugins/iconWhatsFixed/iconWhatsFixed.jquery.js') }}"></script>

	<!-- Jquery Mask -->
    <script src="{{ asset('plugins/jquery-mask/jquery.mask.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2-br.js') }}"></script>

    <!-- Site JS Helpers -->
    <script src="{{ asset('js/helpers.js') }}"></script>

    <!-- Site JS modalNoticiasList.js -->
    <script src="{{ asset('templates/default/modal/modalGeral.js') }}"></script>

    <!-- Site JS modalNoticiasList.js -->
    <script src="{{ asset('templates/default/modal/modalEventsList.js') }}"></script>

    <!-- Site JS modalNoticiasList.js -->
    <script src="{{ asset('templates/default/modal/modalNoticiasList.js') }}"></script>

    <!-- Site JS modalAnotacoesList.js -->
    <script src="{{ asset('templates/default/modal/modalAnotacoesList.js') }}"></script>

    <!-- Site JS modalGraficos.js -->
    <script src="{{ asset('templates/default/modal/modalGraficos.js') }}"></script>

    <!-- Site JS Template -->
    <script src="{{ asset('templates/default/site.js') }}"></script>

    <script>
        $(function() { 
            $("body").iconWhatsFixed({ celular: '556799843212', mensagem: '[Suporte Pedmap]: Olá, tudo bem ?' });
        });
    </script>


    <!-- **************************************

        Desenvolvido por Gabriel da Luz

        http://gabrieldaluz.com.br/

    **************************************  -->

</body>
</html>
