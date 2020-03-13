/**************************************************
		
  		 Desenvolvido por Gabriel da Luz 
		
		 http://gabrieldaluz.com.br/
	
***************************************************/

/* Fix Modal Container Z-index Fix Bootstrap 4 :D */
$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

/** Functions */
function getDomainBaseUrl() {
	var domainBaseUrl = $("meta[name='domainBaseUrl']").attr('content');
	return domainBaseUrl;
}


/* Get Variable Token */
function getHiddenToken() {
    return $('meta[name="csrf-token"]').attr('content');
}


/***************************************************
*** Não remova os créditos pq eu vou saber! Õ_Õ. ***
****************************************************/
console.log(' ');
console.log('%c~~ Desenvolvido por http://gabrieldaluz.com.br ~~ ','background:black;color:#00ff08; padding:6px 10px; margin:0px; border:4px solid gray; font-size:14px;');
console.log(' ');
