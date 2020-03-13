
$(function() { 



});

// modalAnotacoesList
function modalAnotacoesListShow(bairro) { 

    var _modal = $("div#modalAnotacoesList");

    $.ajax({
        method: 'get',
        url: getDomainBaseUrl()+'/anotacoes/ajax/jsonRegistrosByLikeBairro',
        data: { bairro: bairro },
        beforeSend : function(){
            modalAnotacoesTableInjectTitle(bairro+' | Anotações');
            modalAnotacoesTablePreload();
            _modal.modal('show');
        },
        success: function(html) { 
            modalAnotacoesTableInjectHtml(html);
        }
    });

}

function modalAnotacoesUpdateShow(id) { 

    console.log('modalAnotacoesUpdateShow('+id+')');

    var _modal = $("div#modalAnotacoesUpdateShow");

    $.ajax({
        method: 'get',
        url: getDomainBaseUrl()+'/anotacoes/ajax/jsonRegistroById',
        data: { id: id },
        beforeSend : function(){
           
            _modal.modal('show');
        },
        success: function(html) { 
            console.log('sucesso');
        }
    });

}

function modalAnotacoesUpdatePost() { 
    alert('post');
}

function modalAnotacoesTablePreload() {
    var _modal = $("div#modalAnotacoesList");
    _modal.find('table#modalTable').find('tbody').html('<tr id="preload"> <td colspan="3"> <img src="https://imgur.com/eS1rkWq.png" alt="" /> </td> </tr>');
}

function modalAnotacoesTableInjectHtml(html) { 
    var _modal = $("div#modalAnotacoesList");
    _modal.find('table#modalTable').find('tbody').html(html);
}   

function modalAnotacoesTableInjectTitle(html) { 
    var _modal = $("div#modalAnotacoesList");
    _modal.find('.modal-title').html(html);
}   
