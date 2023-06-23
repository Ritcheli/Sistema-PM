document.addEventListener('DOMContentLoaded', function(){
    $("#limpar_filtros").on('click', function(){
        $('input[type=date]').attr('value', ""); 
        $('input[type=text]').attr('value', ""); 
    });
}, false);