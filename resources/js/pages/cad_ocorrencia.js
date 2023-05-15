import { clearModal } from '/resources/js/components/modal';
import { createEditor } from '/resources/js/components/textarea_CKEditor';

var editors = {};

// Cria os elementos baseados em CKEditor
editors = createEditor()

// Limpa os campos criados pelo CKEditor
document.addEventListener('DOMContentLoaded', function () {
    $('#cancelar_cad_ocorrencia').on('click',function(){
       editors.descricao_ocor.setData('');
    });
}, false);

// Função para limpar o modal, argumentos(nome do modal, nome do CKEditor (areatext) caso exista, instância do objeto criada)
clearModal('#modal-cad-pessoas', 'observacao_pessoa', editors);