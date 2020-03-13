// modalGeralListShow
function modalEventsListShow(bairro) { 

    var _modal = $("div#modalEventsList");

    $.ajax({
        method: 'get',
        url: getDomainBaseUrl()+'/cadastros/eventos/ajax/jsonRegistrosByLikeBairro',
        data: { bairro: bairro },
        beforeSend : function(){
            modalEventsTablePreload();
            modalEventsInjectTitle(bairro+' | Eventos');
            _modal.modal('show');
        },
        success: function(html) { 
            modalEventsTableInjectHtml(html);
        }
    });

}

function modalEventsInjectHtml(html) { 
    var _modal = $("div#modalEventsList");
    _modal.find('.modal-body').html(html);
}   

function modalEventsInjectTitle(html) { 
    var _modal = $("div#modalEventsList");
    _modal.find('.modal-title').html(html);
}   

function modalEventsTableInjectHtml(html) { 
    var _modal = $("div#modalEventsList");
    _modal.find('table#modalTable').find('tbody').html(html);
}   

function modalEventsTablePreload() {
    var _modal = $("div#modalEventsList");
    _modal.find('table#modalTable').find('tbody').html('<tr id="preload"> <td colspan="5"> <img src="https://imgur.com/eS1rkWq.png" alt="" /> </td> </tr>');
}

