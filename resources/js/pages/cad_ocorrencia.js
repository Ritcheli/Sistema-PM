import { createEditor } from '/resources/js/components/textarea_CKEditor';

var editor = {};

// Cria os elementos baseados em CKEditor
if (document.getElementById('descricao_ocor') != null){
    editor = createEditor('descricao_ocor');
}


// Limpa os campos criados pelo CKEditor
document.addEventListener('DOMContentLoaded', function () {
    $('#cancelar_cad_ocorrencia').on('click',function(){
        editor.descricao_ocor.setData('');
    });
}, false);