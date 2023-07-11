import { createEditor } from '../components/textarea_CKEditor';
import { loadURLToInputFiled } from '../components/modal_pessoa';

var editor = {};

let modal_cad_pessoa  = document.getElementById('modal-pessoa');

// Verifica se existe o modal cad_pessoa na página, caso exista ele não cria mais um elemento CK_Editor
if (modal_cad_pessoa == null){

    // Cria os elementos baseados em CKEditor
    if (document.getElementById('observacao_pessoa') != null){
        editor = createEditor('observacao_pessoa');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.href.match('pessoa/editar-pessoa') != null) {
        let url        = window.location.pathname;
        let id_pessoa  = url.substring(url.lastIndexOf('/') + 1); 

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            } 
        });
        $.ajax({
            url: "/fotos-pessoas",
            method: "POST",
            data: {
                id_pessoa: id_pessoa
            },
            success: function(result){ 
                if (result.fotos_pessoas.length > 0){
                    loadURLToInputFiled(result.fotos_pessoas);
                };
            }
        });
    }
}, false);