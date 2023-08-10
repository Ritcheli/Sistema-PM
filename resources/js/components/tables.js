document.addEventListener('DOMContentLoaded', function(){
    $(document).on("click", ".btn-remove-from-table", function(e){ 
        e.preventDefault();
        
        $(this).parent().parent().parent().remove();
    });
}, false);