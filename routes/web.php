<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ######################################################### INIT ############################################################### */

/* System Index */
Route::get('/', 'SystemController@index')->name('index')->middleware('SomenteLogado');

/* Autenticacao */
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login/autenticar', 'AuthController@autenticar')->name('login-autenticar');

Route::get('/sair', 'AuthController@logout')->name('logout');

/* Confirmar Conta */
Route::get('/confirmar/conta/{hash?}', 'AuthController@confirmarConta')->name('confirmarConta');
Route::post('/confirmar/conta/{hash}', 'AuthController@confirmarContaPost')->name('confirmarContaPost');

/* Fazer pedido para Recuperar senha */
Route::get('/recuperar/senha', 'AuthController@recuperarSenha')->name('recuperarSenha');
Route::post('/recuperar/senha', 'AuthController@recuperarSenhaPost')->name('recuperarSenhaPost');

/* Fazer nova senha para conta já com hash de autorização */
Route::get('/reset/senha/{hash}', 'AuthController@resetSenha')->name('resetSenha');
Route::post('/reset/senha/{hash}', 'AuthController@resetSenhaPost')->name('resetSenhaPost');

/* ###################################################### MODULOS BLANK ############################################################### */

/* Modulo: Blank ** Modulo Base para criação de outros modulos com listagem,create,update e delete. */
Route::prefix('blank')->group(function () {
    
    Route::get('/', 'Modulo\BlankController@index')->name('modulo-blank-index')->middleware('SomenteLogado');
    
    Route::post('/ajax/listar', 'Modulo\BlankController@listar')->name('modulo-blank-listar')->middleware('SomenteLogado');
    Route::post('/ajax/registro/removerImagem', 'Modulo\BlankController@removerImagemFromRegistro')->name('modulo-blank-remove-image')->middleware('SomenteLogado');
    Route::post('/ajax/deletar', 'Modulo\BlankController@deleteAjax')->name('modulo-blank-delete-post')->middleware('SomenteLogado');

    Route::get('/create', 'Modulo\BlankController@create')->name('modulo-blank-create')->middleware('SomenteLogado');
    Route::post('/create', 'Modulo\BlankController@create')->name('modulo-blank-create-post')->middleware('SomenteLogado');
    
    Route::get('/update/{id}', 'Modulo\BlankController@update')->name('modulo-blank-update')->middleware('SomenteLogado');
    Route::post('/update', 'Modulo\BlankController@update')->name('modulo-blank-update-post')->middleware('SomenteLogado');

    Route::get('/delete/{id}', 'Modulo\BlankController@delete')->name('modulo-blank-delete')->middleware('SomenteLogado');

});


/* ######################################################### MODULOS ############################################################### */



/* Modulo: pesquisa-interna */
Route::prefix('usuarios')->group(function () {

    Route::get('/', 'Modulo\UsuariosController@index')->name('modulo-usuarios-index')->middleware('SomenteLogadoAdmin');

    Route::post('/ajax/listar', 'Modulo\UsuariosController@listar')->name('modulo-usuarios-listar')->middleware('SomenteLogadoAdmin');
    #Route::post('/ajax/registro/removerImagem', 'Modulo\UsuariosController@removerImagemFromRegistro')->name('modulo-usuarios-remove-image')->middleware('SomenteLogadoAdmin');
    Route::post('/ajax/deletar', 'Modulo\UsuariosController@deleteAjax')->name('modulo-usuarios-delete-post')->middleware('SomenteLogadoAdmin');

    Route::get('/create', 'Modulo\UsuariosController@create')->name('modulo-usuarios-create')->middleware('SomenteLogadoAdmin');
    Route::post('/create', 'Modulo\UsuariosController@createPost')->name('modulo-usuarios-create-post')->middleware('SomenteLogadoAdmin');

    Route::get('/update/{id}', 'Modulo\UsuariosController@update')->name('modulo-usuarios-update')->middleware('SomenteLogadoAdmin');
    Route::post('/update', 'Modulo\UsuariosController@updatePost')->name('modulo-usuarios-update-post')->middleware('SomenteLogadoAdmin');

    Route::get('/delete/{id}', 'Modulo\UsuariosController@delete')->name('modulo-usuarios-delete')->middleware('SomenteLogadoAdmin');

});


/* Modulo: equipe */
Route::prefix('equipe')->group(function () {

    Route::get('/', 'Modulo\EquipeController@index')->name('modulo-equipe-index')->middleware('SomenteLogado');

    Route::post('/ajax/listar', 'Modulo\EquipeController@listar')->name('modulo-equipe-listar')->middleware('SomenteLogado');

    #Route::post('/ajax/registro/removerImagem', 'Modulo\EquipeController@removerImagemFromRegistro')->name('modulo-equipe-remove-image')->middleware('SomenteLogadoAdmin');
    
    Route::post('/ajax/deletar', 'Modulo\EquipeController@deleteAjax')->name('modulo-equipe-delete-post')->middleware('SomenteLogado');

    Route::get('/create', 'Modulo\EquipeController@create')->name('modulo-equipe-create')->middleware('SomenteLogado');
    Route::post('/create', 'Modulo\EquipeController@createPost')->name('modulo-equipe-create-post')->middleware('SomenteLogado');

    Route::get('/update/{id}', 'Modulo\EquipeController@update')->name('modulo-equipe-update')->middleware('SomenteLogado');
    Route::post('/update', 'Modulo\EquipeController@updatePost')->name('modulo-equipe-update-post')->middleware('SomenteLogado');

    Route::get('/delete/{id}', 'Modulo\EquipeController@delete')->name('modulo-equipe-delete')->middleware('SomenteLogado');

});

Route::prefix('anotacoes')->group(function () {

    // Modal Ajax List Filtered by id
    Route::get('/ajax/jsonRegistroById', 'AnotacoesController@jsonRegistroById')->name('modulo-anotacoes-jsonRegistroById')->middleware('SomenteLogado');

    // Modal Ajax List Filtered by Like Bairros
    Route::get('/ajax/jsonRegistrosByLikeBairro', 'AnotacoesController@jsonRegistrosByLikeBairro')->name('modulo-anotacoes-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');

});


/* Modulo: noticias */
Route::prefix('noticias')->group(function () {

    Route::get('/', 'Modulo\NoticiasController@index')->name('modulo-noticias-index')->middleware('SomenteLogado');

    Route::post('/ajax/listar', 'Modulo\NoticiasController@listar')->name('modulo-noticias-listar')->middleware('SomenteLogado');
    Route::post('/ajax/registro/removerImagem', 'Modulo\NoticiasController@removerImagemFromRegistro')->name('modulo-noticias-remove-image')->middleware('SomenteLogado');
    Route::post('/ajax/registro/removerArquivo', 'Modulo\NoticiasController@removerArquivoFromRegistro')->name('modulo-noticias-remove-arquivo')->middleware('SomenteLogado');

    Route::post('/ajax/deletar', 'Modulo\NoticiasController@deleteAjax')->name('modulo-noticias-delete-post')->middleware('SomenteLogado');

    Route::get('/update/{id}', 'Modulo\NoticiasController@update')->name('modulo-noticias-update')->middleware('SomenteLogado');
    Route::post('/update', 'Modulo\NoticiasController@updatePost')->name('modulo-noticias-update-post')->middleware('SomenteLogado');

    Route::get('/delete/{id}', 'Modulo\NoticiasController@delete')->name('modulo-noticias-delete')->middleware('SomenteLogado');

});


/* Modulo: eventos  */
Route::prefix('eventos')->group(function () {

    Route::get('/', 'Modulo\EventosController@index')->name('modulo-eventos-index')->middleware('SomenteLogado');

    Route::post('/ajax/listar', 'Modulo\EventosController@listar')->name('modulo-eventos-listar')->middleware('SomenteLogado');
    Route::post('/ajax/registro/removerImagem', 'Modulo\EventosController@removerImagemFromRegistro')->name('modulo-eventos-remove-image')->middleware('SomenteLogado');
    Route::post('/ajax/registro/removerArquivo', 'Modulo\EventosController@removerArquivoFromRegistro')->name('modulo-eventos-remove-arquivo')->middleware('SomenteLogado');

    Route::post('/ajax/deletar', 'Modulo\EventosController@deleteAjax')->name('modulo-eventos-delete-post')->middleware('SomenteLogado');

    Route::get('/update/{id}', 'Modulo\EventosController@update')->name('modulo-eventos-update')->middleware('SomenteLogado');
    Route::post('/update', 'Modulo\EventosController@updatePost')->name('modulo-eventos-update-post')->middleware('SomenteLogado');

    Route::get('/delete/{id}', 'Modulo\EventosController@delete')->name('modulo-eventos-delete')->middleware('SomenteLogado');


});



/* Modulo: pesquisa-interna */
Route::prefix('pesquisa-interna')->group(function () {

    Route::get('/', 'Modulo\PesquisaInternaController@index')->name('modulo-pesquisa-interna-index')->middleware('SomenteLogado');

    Route::post('/ajax/listar', 'Modulo\PesquisaInternaController@listar')->name('modulo-pesquisa-interna-listar')->middleware('SomenteLogado');
    Route::post('/ajax/registro/removerImagem', 'Modulo\PesquisaInternaController@removerImagemFromRegistro')->name('modulo-pesquisa-interna-remove-image')->middleware('SomenteLogado');
    Route::post('/ajax/deletar', 'Modulo\PesquisaInternaController@deleteAjax')->name('modulo-pesquisa-interna-delete-post')->middleware('SomenteLogado');

    Route::get('/update/{id}', 'Modulo\PesquisaInternaController@update')->name('modulo-pesquisa-interna-update')->middleware('SomenteLogado');
    Route::post('/update', 'Modulo\PesquisaInternaController@updatePost')->name('modulo-pesquisa-interna-update-post')->middleware('SomenteLogado');

    Route::get('/delete/{id}', 'Modulo\PesquisaInternaController@delete')->name('modulo-pesquisa-interna-delete')->middleware('SomenteLogado');

});

/* Prefix: Cadastros */
Route::prefix('cadastros')->group(function () {

    /* Modulo: eventos  */
    Route::prefix('anotacoes')->group(function () {

        Route::get('/', 'Modulo\AnotacoesController@index')->name('modulo-anotacoes-index')->middleware('SomenteLogado');

        Route::post('/ajax/listar', 'Modulo\AnotacoesController@listar')->name('modulo-anotacoes-listar')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerImagem', 'Modulo\AnotacoesController@removerImagemFromRegistro')->name('modulo-anotacoes-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerArquivo', 'Modulo\AnotacoesController@removerArquivoFromRegistro')->name('modulo-anotacoes-remove-arquivo')->middleware('SomenteLogado');

        Route::get('/create', 'Modulo\AnotacoesController@create')->name('modulo-anotacoes-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\AnotacoesController@createPost')->name('modulo-anotacoes-create-post')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\EventosController@jsonRegistroById')->name('modulo-eventos-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\EventosController@jsonRegistrosByLikeBairro')->name('modulo-eventos-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');
 
        Route::post('/ajax/deletar', 'Modulo\AnotacoesController@deleteAjax')->name('modulo-anotacoes-delete-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\AnotacoesController@update')->name('modulo-anotacoes-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\AnotacoesController@updatePost')->name('modulo-anotacoes-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\AnotacoesController@delete')->name('modulo-anotacoes-delete')->middleware('SomenteLogado');

    });

    /* Modulo: noticias */
    Route::prefix('noticias')->group(function () {
        Route::get('/create', 'Modulo\NoticiasController@create')->name('modulo-noticias-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\NoticiasController@createPost')->name('modulo-noticias-create-post')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\NoticiasController@jsonRegistroById')->name('modulo-noticias-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\NoticiasController@jsonRegistrosByLikeBairro')->name('modulo-noticias-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');    
    });

    /* Modulo: noticias */
    Route::prefix('eventos')->group(function () {
        Route::get('/create', 'Modulo\EventosController@create')->name('modulo-eventos-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\EventosController@createPost')->name('modulo-eventos-create-post')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\EventosController@jsonRegistroById')->name('modulo-eventos-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\EventosController@jsonRegistrosByLikeBairro')->name('modulo-eventos-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');
    });

    /* Modulo: pesquisa-interna */
    Route::prefix('pesquisa-interna')->group(function () {
        Route::get('/create', 'Modulo\PesquisaInternaController@create')->name('modulo-pesquisa-interna-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\PesquisaInternaController@createPost')->name('modulo-pesquisa-interna-create-post')->middleware('SomenteLogado');
    });

});

/* Prefix: Cadastros */
Route::prefix('georreferenciamento')->group(function () {

    Route::get('/', 'Modulo\GeorreferenciamentoController@index')->name('modulo-geo-index')->middleware('SomenteLogado');

    Route::post('/ajax/getInfoWindowRegiao', 'Modulo\GeorreferenciamentoController@getInfoWindowRegiao')->name('modulo-geo-ajax-getInfoWindowRegiao')->middleware('SomenteLogado');

    Route::get('/ajax/get/infowindow/geral', 'Modulo\GeorreferenciamentoController@ajaxGetInfowindowGeral')->name('modulo-geo-ajaxGetInfowindowGeral')->middleware('SomenteLogado');

});

/* Prefix: Configurações */
Route::prefix('configuracoes')->group(function () {


    /* Modulo: noticiascat */
    Route::prefix('noticiascat')->group(function () {

        Route::get('/', 'Modulo\NoticiasCatController@index')->name('modulo-noticiascat-index')->middleware('SomenteLogado');

        Route::post('/ajax/listar', 'Modulo\NoticiasCatController@listar')->name('modulo-noticiascat-listar')->middleware('SomenteLogado');
        #Route::post('/ajax/registro/removerImagem', 'Modulo\NoticiasCatController@removerImagemFromRegistro')->name('modulo-problemas-bairro-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/deletar', 'Modulo\NoticiasCatController@deleteAjax')->name('modulo-noticiascat-delete-post')->middleware('SomenteLogado');

        Route::get('/create', 'Modulo\NoticiasCatController@create')->name('modulo-noticiascat-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\NoticiasCatController@createPost')->name('modulo-noticiascat-create-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\NoticiasCatController@update')->name('modulo-noticiascat-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\NoticiasCatController@updatePost')->name('modulo-noticiascat-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\NoticiasCatController@delete')->name('modulo-noticiascat-delete')->middleware('SomenteLogado');

    });

    /* Modulo: problemas-bairro */
    Route::prefix('problemas-bairro')->group(function () {

        Route::get('/', 'Modulo\ProblemasBairroController@index')->name('modulo-problemas-bairro-index')->middleware('SomenteLogado');

        Route::post('/ajax/listar', 'Modulo\ProblemasBairroController@listar')->name('modulo-problemas-bairro-listar')->middleware('SomenteLogado');
        #Route::post('/ajax/registro/removerImagem', 'Modulo\ProblemasBairroController@removerImagemFromRegistro')->name('modulo-problemas-bairro-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/deletar', 'Modulo\ProblemasBairroController@deleteAjax')->name('modulo-problemas-bairro-delete-post')->middleware('SomenteLogado');

        Route::get('/create', 'Modulo\ProblemasBairroController@create')->name('modulo-problemas-bairro-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\ProblemasBairroController@createPost')->name('modulo-problemas-bairro-create-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\ProblemasBairroController@update')->name('modulo-problemas-bairro-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\ProblemasBairroController@updatePost')->name('modulo-problemas-bairro-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\ProblemasBairroController@delete')->name('modulo-problemas-bairro-delete')->middleware('SomenteLogado');

    });

        /* Modulo: escolas */
        Route::prefix('escolas')->group(function () {

            Route::get('/', 'Modulo\EscolasController@index')->name('modulo-escolas-index')->middleware('SomenteLogado');
    
            Route::post('/ajax/listar', 'Modulo\EscolasController@listar')->name('modulo-escolas-listar')->middleware('SomenteLogado');
            #Route::post('/ajax/registro/removerImagem', 'Modulo\ProblemasBairroController@removerImagemFromRegistro')->name('modulo-problemas-bairro-remove-image')->middleware('SomenteLogado');
            Route::post('/ajax/deletar', 'Modulo\EscolasController@deleteAjax')->name('modulo-escolas-delete-post')->middleware('SomenteLogado');
    
            Route::get('/create', 'Modulo\EscolasController@create')->name('modulo-escolas-create')->middleware('SomenteLogado');
            Route::post('/create', 'Modulo\EscolasController@createPost')->name('modulo-escolas-create-post')->middleware('SomenteLogado');
    
            Route::get('/update/{id}', 'Modulo\EscolasController@update')->name('modulo-escolas-update')->middleware('SomenteLogado');
            Route::post('/update', 'Modulo\EscolasController@updatePost')->name('modulo-escolas-update-post')->middleware('SomenteLogado');
    
            Route::get('/delete/{id}', 'Modulo\EscolasController@delete')->name('modulo-escolas-delete')->middleware('SomenteLogado');
    
        });

      /* Modulo: unidades-saude */
      Route::prefix('unidades-saude')->group(function () {

        Route::get('/', 'Modulo\UnidadesSaudeController@index')->name('modulo-unidades-saude-index')->middleware('SomenteLogado');

        Route::post('/ajax/listar', 'Modulo\UnidadesSaudeController@listar')->name('modulo-unidades-saude-listar')->middleware('SomenteLogado');
        #Route::post('/ajax/registro/removerImagem', 'Modulo\ProblemasBairroController@removerImagemFromRegistro')->name('modulo-problemas-bairro-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/deletar', 'Modulo\UnidadesSaudeController@deleteAjax')->name('modulo-unidades-saude-delete-post')->middleware('SomenteLogado');

        Route::get('/create', 'Modulo\UnidadesSaudeController@create')->name('modulo-unidades-saude-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\UnidadesSaudeController@createPost')->name('modulo-unidades-saude-create-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\UnidadesSaudeController@update')->name('modulo-unidades-saude-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\UnidadesSaudeController@updatePost')->name('modulo-unidades-saude-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\UnidadesSaudeController@delete')->name('modulo-unidades-saude-delete')->middleware('SomenteLogado');

    });


    /* Modulo: candidatos */
    Route::prefix('candidatos')->group(function () {

        Route::get('/', 'Modulo\CandidatosController@index')->name('modulo-candidatos-index')->middleware('SomenteLogado');

        Route::get('/create', 'Modulo\CandidatosController@create')->name('modulo-candidatos-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\CandidatosController@createPost')->name('modulo-candidatos-create-post')->middleware('SomenteLogado');

        Route::post('/ajax/listar', 'Modulo\CandidatosController@listar')->name('modulo-candidatos-listar')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerImagem', 'Modulo\CandidatosController@removerImagemFromRegistro')->name('modulo-candidatos-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerArquivo', 'Modulo\CandidatosController@removerArquivoFromRegistro')->name('modulo-candidatos-remove-arquivo')->middleware('SomenteLogado');

        Route::post('/ajax/deletar', 'Modulo\CandidatosController@deleteAjax')->name('modulo-candidatos-delete-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\CandidatosController@update')->name('modulo-candidatos-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\CandidatosController@updatePost')->name('modulo-candidatos-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\CandidatosController@delete')->name('modulo-candidatos-delete')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\CandidatosController@jsonRegistroById')->name('modulo-candidatos-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\CandidatosController@jsonRegistrosByLikeBairro')->name('modulo-candidatos-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');

    });

     /* Modulo: partidos */
     Route::prefix('partidos')->group(function () {

        Route::get('/', 'Modulo\PartidosController@index')->name('modulo-partidos-index')->middleware('SomenteLogado');

        Route::get('/create', 'Modulo\PartidosController@create')->name('modulo-partidos-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\PartidosController@createPost')->name('modulo-partidos-create-post')->middleware('SomenteLogado');

        Route::post('/ajax/listar', 'Modulo\PartidosController@listar')->name('modulo-partidos-listar')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerImagem', 'Modulo\PartidosController@removerImagemFromRegistro')->name('modulo-partidos-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerArquivo', 'Modulo\PartidosController@removerArquivoFromRegistro')->name('modulo-partidos-remove-arquivo')->middleware('SomenteLogado');

        Route::post('/ajax/deletar', 'Modulo\PartidosController@deleteAjax')->name('modulo-partidos-delete-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\PartidosController@update')->name('modulo-partidos-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\PartidosController@updatePost')->name('modulo-partidos-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\PartidosController@delete')->name('modulo-partidos-delete')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\PartidosController@jsonRegistroById')->name('modulo-partidos-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\PartidosController@jsonRegistrosByLikeBairro')->name('modulo-partidos-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');

    });


     /* Modulo: presidente-bairro */
     Route::prefix('presidente-bairro')->group(function () {

        Route::get('/', 'Modulo\PresidenteDoBairroController@index')->name('modulo-presidentebairro-index')->middleware('SomenteLogado');

        
        Route::get('/create', 'Modulo\PresidenteDoBairroController@create')->name('modulo-presidentebairro-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\PresidenteDoBairroController@createPost')->name('modulo-presidentebairro-create-post')->middleware('SomenteLogado');


        Route::post('/ajax/listar', 'Modulo\PresidenteDoBairroController@listar')->name('modulo-presidentebairro-listar')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerImagem', 'Modulo\PresidenteDoBairroController@removerImagemFromRegistro')->name('modulo-presidentebairro-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerArquivo', 'Modulo\PresidenteDoBairroController@removerArquivoFromRegistro')->name('modulo-presidentebairro-remove-arquivo')->middleware('SomenteLogado');

        Route::post('/ajax/deletar', 'Modulo\PresidenteDoBairroController@deleteAjax')->name('modulo-presidentebairro-delete-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\PresidenteDoBairroController@update')->name('modulo-presidentebairro-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\PresidenteDoBairroController@updatePost')->name('modulo-presidentebairro-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\PresidenteDoBairroController@delete')->name('modulo-presidentebairro-delete')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\PresidenteDoBairroController@jsonRegistroById')->name('modulo-presidentebairro-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\PresidenteDoBairroController@jsonRegistrosByLikeBairro')->name('modulo-presidentebairro-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');

    });


    /* Modulo: estados */
    Route::prefix('estados')->group(function () {

        Route::get('/', 'Modulo\EstadosController@index')->name('modulo-estados-index')->middleware('SomenteLogado');

        Route::get('/create', 'Modulo\EstadosController@create')->name('modulo-estados-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\EstadosController@createPost')->name('modulo-estados-create-post')->middleware('SomenteLogado');

        Route::post('/ajax/listar', 'Modulo\EstadosController@listar')->name('modulo-estados-listar')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerImagem', 'Modulo\EstadosController@removerImagemFromRegistro')->name('modulo-estados-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerArquivo', 'Modulo\EstadosController@removerArquivoFromRegistro')->name('modulo-estados-remove-arquivo')->middleware('SomenteLogado');

        Route::post('/ajax/deletar', 'Modulo\EstadosController@deleteAjax')->name('modulo-estados-delete-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\EstadosController@update')->name('modulo-estados-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\EstadosController@updatePost')->name('modulo-estados-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\EstadosController@delete')->name('modulo-estados-delete')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\EstadosController@jsonRegistroById')->name('modulo-estados-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\EstadosController@jsonRegistrosByLikeBairro')->name('modulo-estados-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');

    });

    /* Modulo: cidades */
    Route::prefix('cidades')->group(function () {

        Route::get('/', 'Modulo\CidadesController@index')->name('modulo-cidades-index')->middleware('SomenteLogado');

        
        Route::get('/create', 'Modulo\CidadesController@create')->name('modulo-cidades-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\CidadesController@createPost')->name('modulo-cidades-create-post')->middleware('SomenteLogado');


        Route::post('/ajax/listar', 'Modulo\CidadesController@listar')->name('modulo-cidades-listar')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerImagem', 'Modulo\CidadesController@removerImagemFromRegistro')->name('modulo-cidades-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerArquivo', 'Modulo\CidadesController@removerArquivoFromRegistro')->name('modulo-cidades-remove-arquivo')->middleware('SomenteLogado');

        Route::post('/ajax/deletar', 'Modulo\CidadesController@deleteAjax')->name('modulo-cidades-delete-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\CidadesController@update')->name('modulo-cidades-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\CidadesController@updatePost')->name('modulo-cidades-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\CidadesController@delete')->name('modulo-cidades-delete')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\CidadesController@jsonRegistroById')->name('modulo-cidades-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\CidadesController@jsonRegistrosByLikeBairro')->name('modulo-cidades-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');

    });

     /* Modulo: Bairros */
     Route::prefix('bairros')->group(function () {

        Route::get('/', 'Modulo\BairrosController@index')->name('modulo-bairros-index')->middleware('SomenteLogado');
        
        Route::get('/create', 'Modulo\BairrosController@create')->name('modulo-bairros-create')->middleware('SomenteLogado');
        Route::post('/create', 'Modulo\BairrosController@createPost')->name('modulo-bairros-create-post')->middleware('SomenteLogado');

        Route::post('/ajax/listar', 'Modulo\BairrosController@listar')->name('modulo-bairros-listar')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerImagem', 'Modulo\BairrosController@removerImagemFromRegistro')->name('modulo-bairros-remove-image')->middleware('SomenteLogado');
        Route::post('/ajax/registro/removerArquivo', 'Modulo\BairrosController@removerArquivoFromRegistro')->name('modulo-bairros-remove-arquivo')->middleware('SomenteLogado');

        Route::post('/ajax/deletar', 'Modulo\BairrosController@deleteAjax')->name('modulo-bairros-delete-post')->middleware('SomenteLogado');

        Route::get('/update/{id}', 'Modulo\BairrosController@update')->name('modulo-bairros-update')->middleware('SomenteLogado');
        Route::post('/update', 'Modulo\BairrosController@updatePost')->name('modulo-bairros-update-post')->middleware('SomenteLogado');

        Route::get('/delete/{id}', 'Modulo\BairrosController@delete')->name('modulo-bairros-delete')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Id
        Route::get('/ajax/jsonRegistroById', 'Modulo\BairrosController@jsonRegistroById')->name('modulo-bairros-jsonRegistroById')->middleware('SomenteLogado');

        // Modal Ajax List Filtered by Like Bairros
        Route::get('/ajax/jsonRegistrosByLikeBairro', 'Modulo\BairrosController@jsonRegistrosByLikeBairro')->name('modulo-bairros-jsonRegistrosByLikeBairro')->middleware('SomenteLogado');

    });


});


/* ###################################################### APIV2  ############################################################### */

/* Prefix Developer */
Route::prefix('apiv2')->group(function () {
    /* System Index */
    Route::get('/get/json/bairros/for/select2', 'Apiv2Controller@getJsonBairrosForSelect2')->name('apiv2-getJsonBairrosForSelect2')->middleware('SomenteLogado');
    Route::get('/get/json/estados/for/select2', 'Apiv2Controller@getJsonEstadosForSelect2')->name('apiv2-getJsonEstadosForSelect2')->middleware('SomenteLogado');
    Route::get('/get/json/cidades/for/select2', 'Apiv2Controller@getJsonCidadesForSelect2')->name('apiv2-getJsonCidadesForSelect2')->middleware('SomenteLogado');
});

/* ###################################################### DEV DASHBOARD ############################################################### */

/* Prefix Developer */
Route::prefix('developer')->group(function () {
    /* System Index */
    Route::get('/', 'DeveloperController@index')->name('developer-index')->middleware('SomenteLogado');
});

/* ####################################################### DEV UTILIDADES ############################################################### */

/* Dev Utilidades */
Route::get('/s', function() { return dd(session()->all()); })->middleware('SomenteLogado');

Route::get('/stest', 'DeveloperController@teste')->middleware('SomenteLogado');

use Illuminate\Support\Facades\DB;

use App\Noticias;
use App\PresidentesBairro;

Route::get('/test', function() {

    $db = DB::table('bairrobd')->orderBy('bairro','asc')->get();

    $_html = "";
    
    foreach($db as $bairro) { 
        
        $modulo_bairros = \App\BairrosRegioes::where('bairro','like','%'.$bairro->bairro.'%')->get();

        if($modulo_bairros->count()) { 

            $m = $modulo_bairros->first();

            $m->texto = $bairro->texto;

            $m->save();

            $_html .= "[bairrobd]: ".$bairro->bairro."  ---> Update ";
            
            $_html .= "<br />";

        }

    }

    $_html .= "<br /><br />[bairrobd]:count:: ". $db->count();

    return $_html;

})->middleware('SomenteLogadoDeveloper');


use App\Http\Controllers\ClienteTabelasController;
Route::get('/cliente/drop/tables/{id}', function($id) {

    ClienteTabelasController::dropAllTables($id);
    return "dropAllTables";

})->middleware('SomenteLogadoDeveloper');
Route::get('/cliente/update/tables/{id}', function($id) {

    ClienteTabelasController::createAllTables($id);
    return "createAllTables";
})->middleware('SomenteLogadoDeveloper');
