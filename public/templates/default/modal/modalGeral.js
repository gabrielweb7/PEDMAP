// modalGeralListShow
function modalGeralListShow(bairro) { 

    var _modal = $("div#modalGeralList");

    $.ajax({
        method: 'get',
        url: getDomainBaseUrl()+'/georreferenciamento/ajax/get/infowindow/geral',
        data: { bairro: bairro },
        beforeSend : function(){
            modalGeralInjectHtml('<div style="padding: 20px 10px;text-align: center;"><img src="https://imgur.com/eS1rkWq.png" alt="" style="width: 45px;"></div>');
            modalGeralInjectTitle(bairro+' | Geral');
            _modal.modal('show');
        },
        success: function(html) { 
            modalGeralInjectHtml(html);
        }
    });

}

function modalGeralInjectHtml(html) { 
    var _modal = $("div#modalGeralList");
    _modal.find('.modal-body').html(html);
}   

function modalGeralInjectTitle(html) { 
    var _modal = $("div#modalGeralList");
    _modal.find('.modal-title').html(html);
}   

