
$(function() { 



});

// modalNoticiasListShow
function modalNoticiasListShow(bairro) { 

    var _modal = $("div#modalNoticiasList");
    $.ajax({
        method: 'get',
        url: getDomainBaseUrl()+'/cadastros/noticias/ajax/jsonRegistrosByLikeBairro',
        data: { bairro: bairro },
        beforeSend : function(){
            modalNoticiasTableInjectTitle(bairro+' | Notícias');
            modalNoticiasTablePreload();
            _modal.modal('show');
        },
        success: function(html) { 
            modalNoticiasTableInjectHtml(html);
        }
    });

}

function modalNoticiasUpdateShow(id) { 

    console.log('modalNoticiasUpdateShow('+id+')');

    var _modal = $("div#modalNoticiasForm");

    $.ajax({
        method: 'get',
        url: getDomainBaseUrl()+'/cadastros/noticias/ajax/jsonRegistroById',
        data: { id: id },
        beforeSend : function(){
            modalNoticiasFormReset();
            modalNoticiasFormInjectTitle('Editar Notícia');
            _modal.modal('show');
        },
        success: function(data) { 
            
            _modal.find('input#id').val(id);

            _modal.find('input#retranca').val(data.retranca);

            _modal.find("textarea#summernote").summernote ('code',data.resumo);

            _modal.find('input#divulgacao').val(data.divulgacao);

            _modal.find('input#bairro').val(data.bairro);

            _modal.find('input#favorita').val(data.favorita);

            _modal.find('input#status').val(data.status);

            if(data.imagem_src.length > 0) { 
                _modal.find('div.imagePreviewAndDelete').find('img').prop('src',window.origin+'/public/storage/'+data.imagem_src);
                _modal.find('div.imagePreviewAndDelete').show();
            }

            if(data.arquivo.length > 0) { 
                _modal.find('div.arquivoPreviewAndDelete').find('a#linkArquivo').prop('href',window.origin+'/public/storage/'+data.arquivo);
                _modal.find('div.arquivoPreviewAndDelete').show();
            }

            $.each(data.categorias, function( key, value ) {
                _modal.find("input[type='checkbox'][value='"+value.id+"']").prop('checked', true);
                console.log('id: '+value.id);
            });

            _modal.find('div#criadoEm').show();
            _modal.find('div#criadoEm').find('div#datahora').html(data.dataHoraBr);

        }
    });

}

function modalNoticiasFormReset() { 

    console.log('modalNoticiasFormReset()');

    var _modal = $("div#modalNoticiasForm");

    _modal.find('input#id').val("");

    _modal.find('input#retranca').val("");

    _modal.find("textarea#summernote").summernote ('code',"");

    _modal.find('input#divulgacao').val("");

    _modal.find('input#bairro').val("");

    _modal.find('input#favorita').val(0);

    _modal.find('input#status').val(0);

    _modal.find('div.imagePreviewAndDelete').hide();
    
    _modal.find('div.arquivoPreviewAndDelete').hide();

    _modal.find("input[type='checkbox']").prop('checked', false);

    _modal.find('div#criadoEm').hide();
    _modal.find('div#criadoEm').find('div#datahora').html('');

}

function modalNoticiasTablePreload() {
    var _modal = $("div#modalNoticiasList");
    _modal.find('table#modalTable').find('tbody').html('<tr id="preload"> <td colspan="4"> <img src="https://imgur.com/eS1rkWq.png" alt="" /> </td> </tr>');
}

function modalNoticiasTableInjectHtml(html) { 
    var _modal = $("div#modalNoticiasList");
    _modal.find('table#modalTable').find('tbody').html(html);
}   

function modalNoticiasTableInjectTitle(html) { 
    var _modal = $("div#modalNoticiasList");
    _modal.find('.modal-title').html(html);
}   

function modalNoticiasFormInjectTitle(html) { 
    var _modal = $("div#modalNoticiasForm");
    _modal.find('.modal-title').html(html);
}   
