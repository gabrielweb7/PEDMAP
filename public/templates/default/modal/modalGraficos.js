// modalNoticiasListShow
function modalGraficosShow(bairro) { 

    var _modal = $("div#modalGraficos");
    modalGraficosInjectTitle(bairro+' | Gráficos');
    _modal.modal('show');

}

function modalGraficosInjectTitle(html) { 
    var _modal = $("div#modalGraficos");
    _modal.find('.modal-title').html(html);
}   
