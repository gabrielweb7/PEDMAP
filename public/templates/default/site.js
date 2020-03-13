/**************************************************

  		 Desenvolvido por Gabriel da Luz

		 http://gabrieldaluz.com.br/

***************************************************/
var dataTableInstance = false; /* Instancia do plugin DataTable */

/** Jquery Function */
$(document).ready(function() {

    // AutoComplete Jquery UI
    if($("input#regiao").length) {  
        $( "input#regiao" ).autocomplete({
            source: _list_regiao
        });
    }
    
    // Select2
    if($("#bairro_id").length) {  
        $('#bairro_id').select2({ theme: "classic",
        minimumInputLength: 1,
        allowClear: false,
        ajax: {
          url: _route_select2_bairro_id,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        } });
    }

    // Select2
    if($("#estado_id").length) {  
        $('#estado_id').select2({ theme: "classic",
        minimumInputLength: 1,
        allowClear: false,
        ajax: {
          url: _route_select2_estado_id,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        } });
    }

    // Select2
    if($("#cidade_id").length) {  
        $('#cidade_id').select2({ theme: "classic",
        minimumInputLength: 0,
        allowClear: false,
        
        ajax: {
          url: _route_select2_cidade_id,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        } });
    }

    $.datetimepicker.setLocale('pt');

    if($("#datetimerpicker").length) {  
        $('#datetimerpicker').datetimepicker({  format:'d/m/Y H:i', mask:true, step: 15 });
    }

    // AutoHeight Div Map
    $(window).on('resize', function(){ autoHeightMap(); });

    $(window).on('load', function(){ autoHeightMap(); });

    function autoHeightMap() {
        if($("div#map").length) {  
            console.log('autoHeightMap()');
            heightMap = $(window).outerHeight() - $('footer').outerHeight();
            $("div#map").css('height', heightMap+'px');
        }
    }

    /* DataTable Global Options */
    $.extend(true, $.fn.dataTable.defaults, {
        "language": {
            "decimal":        "",
            "emptyTable":     "Nenhum dado disponível na tabela",
            "info":           "Mostrando _START_ até _END_ de <b>_TOTAL_ registros</b>",
            "infoEmpty":      "Mostrando 0 até 0 de 0 Registros",
            "infoFiltered":   "(filtrado entre _MAX_ registros)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ Registros",
            "loadingRecords": "Carregando...",
            "processing":     "Processando...",
            "search":         "Pesquisar:",
            "zeroRecords":    "Nenhum registro encontrado",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Último",
                "next":       "Próximo",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": Ativar para organizar coluna ascendente",
                "sortDescending": ": Ativar para organizar coluna descendente"
            }
        }
    });

    $("table#getDataAjax input[name='selectAllRegistro']").on('click', function() {

        if(this.checked) {


            $("table#getDataAjax input[name='selectRegistro']:not(:disabled)").prop('checked', true);
            $("table#getDataAjax input[name='selectRegistro']:not(:disabled)").parent().parent().addClass('selected');
        } else {
            $("table#getDataAjax input[name='selectRegistro']").prop('checked', false);
            $("table#getDataAjax input[name='selectRegistro']").parent().parent().removeClass('selected');
        }

        showButtonDeleteRegistros();
    });

    $("body").on('click', "table#getDataAjax input[name='selectRegistro']",function() {

        if(this.checked) {

            $(this).parent().parent().addClass('selected');
        } else{

            $(this).parent().parent().removeClass('selected');
        }

        showButtonDeleteRegistros();
    });

    function showButtonDeleteRegistros() {

        var selecionados = $("input[name=selectRegistro]:checked").length;
        var total = $("input[name=selectRegistro]:not(:disabled)").length;

        if(selecionados > 0) {

            $("button#deletarSelecionados").stop().show(500);
        } else {

            $("button#deletarSelecionados").stop().hide(500);
        }

        if(selecionados == total) {

            $("input[name=selectAllRegistro]").prop('checked',true);
        } else {

            $("input[name=selectAllRegistro]").prop('checked',false);
        }
    }

    /* Deletar Selecionados */
    $("button#deletarSelecionados").on('click', function() {

        var idArrays = [];

        $("input[name=selectRegistro]:checked").each(function(index) {

            idArrays.push($(this).val());
        });

        var returnConfirm = false;

        if(idArrays.length > 1) {

            returnConfirm = confirm('Você tem certeza que deseja excluir ' + idArrays.length + ' registros ?');
        } else {

            returnConfirm = confirm('Você tem certeza que deseja excluir este registro ?');
        }

        if(returnConfirm) {

            var dataAjaxRouteDelete = $("input#dataAjaxRouteDelete").val();

            $.post(dataAjaxRouteDelete, { _token: getHiddenToken(), id: idArrays }, function(msg) {
                console.log(msg);
                reloadAndResetDataTableAjax();
                $("table#getDataAjax input[name='selectAllRegistro']").prop('checked', false);
                $("button#deletarSelecionados").stop().hide(500);
            });

        }

    });

    /* reloadAndResetDataTableAjax*/
    function reloadAndResetDataTableAjax() {

        dataTableInstance.search('').column( dataOrderDefault+':visible' ).order(dataOrderDefaultSentido).ajax.reload();

    }

    /* DataTable :: getDataAjax */
    if($('table#getDataAjax').length) {

        var dataAjaxRoute = $("input#dataTableAjaxRoute").val();
        var dataOrderDefault = $("input#dataOrderDefault").val();
        var dataOrderDefaultSentido = $("input#dataOrderDefaultSentido").val();
        var dataColumnDefs = JSON.parse($("input#dataColumnDefs").val());

        if(dataAjaxRoute != "") {

            dataTableInstance = $('table#getDataAjax').DataTable({
                "autoWidth": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": dataAjaxRoute,
                    "type": "POST"
                },
                "columnDefs": dataColumnDefs,
                "order": [[ dataOrderDefault, dataOrderDefaultSentido ]],
                "fnDrawCallback": function(oSettings, json) {
                    fancyBoxActive();
                    toltipActive();
                }
            });

            console.log('Datatable   Active!');

        }

    }

    /* Editor WYSIWYG */
    if($('textarea#summernote').length) {
        $('textarea#summernote').summernote({ height: 250 });
        console.log('Summernote Active!');
    }

    /* Fancybox */
    function fancyBoxActive() {

        if($('a#single_image').length) {
            $("a#single_image").fancybox();
            console.log('FancyBox Active!');
        }

    }
    fancyBoxActive();

    /* Toltip */
    function toltipActive() {
        if($('[data-toggle="tooltip"]').length) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    }
    toltipActive();

    /* Get Variable from Form */
    function getHiddenToken() {
        return $('meta[name="csrf-token"]').attr('content');
    }

    /* Get Variable from Form */
    function getHiddenInputID() {
        return $('input[type=hidden][name=id]').val();
    }


    $("form#update button[type=submit]").on('click', function() {
        $(this).html('Atualizando..').prop('disabled', true);
        $("form#update").submit();
    });

    $("form#update a#deleteSingle").on('click', function() {

        /* Lança Pergunta */
        var confirmacao = confirm('Você realmente deseja deletar este registro ?');

        if(confirmacao) {
            $(this).html('Deletando..').prop('disabled', true);
            return true;
        }

        return false;

    });

    $("form#create button[type=submit]").on('click', function() {
        $(this).html('Enviando..').prop('disabled', true);
        $("form#create").submit();
    });

    /* Ajax: Remover imagem from registro  */
    $("body.dashboard section.conteudo div.imagePreviewAndDelete div.actions a").on('click', function() {

        /* Lança Pergunta */
        var confirmacao = confirm('Você realmente deseja remover esta imagem ?');

        if(!confirmacao) {
            return false;
        }

        var ajaxRouteDeleteImage = $("input#ajaxRouteDeleteImage").val();

        var _this = $(this);

        $.post(ajaxRouteDeleteImage, { _token: getHiddenToken(), id: getHiddenInputID() },
            function(msg) {
                if(msg == "1") {
                    _this.parent().parent().hide(700);
                } else {
                    alert('Infelizmente aconteceu algum problema aqui.. não foi possivel remover a imagem do registro.. entre em contato via whats: 67 984660441 - Gabriel da Luz');
                }
            }
        );

    });


    /* Ajax: Remover Arquivo from registro  */
    $("body.dashboard section.conteudo div.arquivoPreviewAndDelete div.actions a").on('click', function() {

        /* Lança Pergunta */
        var confirmacao = confirm('Você realmente deseja remover este arquivo ?');

        if(!confirmacao) {
            return false;
        }

        var ajaxRouteDeleteArquivo = $("input#ajaxRouteDeleteArquivo").val();

        var _this = $(this);

        $.post(ajaxRouteDeleteArquivo, { _token: getHiddenToken(), id: getHiddenInputID() },
            function(msg) {
                if(msg == "1") {
                    _this.parent().parent().hide(700);
                } else {
                    alert('Infelizmente aconteceu algum problema aqui.. não foi possivel remover a imagem do registro.. entre em contato via whats: 67 984660441 - Gabriel da Luz');
                }
            }
        );

    });

    /* Header: Menu and Submenu open and hide */
    $("body.dashboard header div.menu ul > li").hover(
        function() {

            /* Caso tenha Submenu level 1 */
            if($( this ).find('ul').length > 0) {
                $(this).find('ul').stop().slideDown(250);
            }

        }, function() {
            /* Caso tenha Submenu level 1 */
            if($( this ).find('ul').length > 0) {
                $(this).find('ul').stop().slideUp(180);
            }
        }
    );



});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

function showPosition(position) {
    var text = "Latitude: " + position.coords.latitude + " <br> Longitude: " + position.coords.longitude;
    alert(text);
}

/**  BINDS **/
$(document).bind("ajaxComplete", function(){
    
    console.log('bind: execute command tooltip()');
    $('[data-toggle="tooltip"]').tooltip(); 
  
});



/***************************************************
*** Não remova os créditos pq eu vou saber! Õ_Õ. ***
****************************************************/