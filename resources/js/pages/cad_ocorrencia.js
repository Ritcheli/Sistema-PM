import { createEditor } from '../components/textarea_CKEditor';
import { searchPessoa } from '../components/modal_busca_pessoa';

var editor = {};

// Cria os elementos baseados em CKEditor
if (document.getElementById('descricao_ocor') != null){
    editor = createEditor('descricao_ocor');
}

document.addEventListener('DOMContentLoaded', function () {
    $('#cancelar-cad-ocorrencia').on('click',function(){
        editor.descricao_ocor.setData('');
    });

    $("#search-pessoa").on("click", function(e){
        e.preventDefault();
        
        searchPessoa();
    });

    $(document).on("click", ".btn-table-remove", function(e){ 
        e.preventDefault();
        
        $(this).parent().parent().parent().remove();
    });
}, false);