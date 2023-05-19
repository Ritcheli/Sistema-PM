import { clearModal } from './modal';
import { createEditor } from '/resources/js/components/textarea_CKEditor';

let modal_cad_pessoa  = document.getElementById('modal-cad-pessoas');

let input_nome        = document.getElementById('nome');
let input_telefone    = document.getElementById('telefone');
let input_CPF_RG      = document.getElementById('CPF_RG');
let input_alcunha     = document.getElementById('alcunha');
let input_obs_pessoa  = document.getElementById('observacao_pessoa');

let tag_nome_invalido       = document.getElementById('nome-invalido');
let tag_telefone_invalido   = document.getElementById('telefone-invalido')
let tag_CPF_RG_invalido     = document.getElementById('CPF_RG-invalido');
let tag_alcunha_invalido    = document.getElementById('alcunha-invalido');
let tag_obs_pessoa_invalido = document.getElementById('observacao_pessoa-invalido');


if (modal_cad_pessoa != null){
    let editor = {};

    editor = createEditor('observacao_pessoa');

    // Função para limpar o modal, argumentos(nome do modal, nome do CKEditor (areatext) caso exista, instância do objeto criada)
    clearModal('#modal-cad-pessoas', 'observacao_pessoa', editor);

    document.addEventListener('DOMContentLoaded', function () {
        var url = $('#form').attr('action');

        $('#salvar_pessoa').on("click", function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    nome: $('#nome').val(),
                    data_nascimento: $('#data_nascimento').val(),
                    telefone: $('#telefone').val(),
                    CPF_RG: $('#CPF_RG').val(),
                    alcunha: $('#alcunha').val(),
                    observacao_pessoa: editor.observacao_pessoa.getData()
                },
                success: function(result){
                    if(result.errors){
                        $.each(result.errors, function(key, value){
                            switch(key){
                                case 'nome':
                                    input_nome.classList.add('is-invalid');
                                    tag_nome_invalido.innerHTML = '<strong>' + value + '</strong>';
                                    break;
                                case 'telefone':
                                    input_telefone.classList.add('is-invalid');
                                    tag_telefone_invalido.innerHTML = '<strong>' + value + '</strong>';
                                    break;
                                case 'CPF_RG':
                                    input_CPF_RG.classList.add('is-invalid');
                                    tag_CPF_RG_invalido.innerHTML = '<strong>' + value + '</strong>';
                                    break;    
                                case 'alcunha':
                                    input_alcunha.classList.add('is-invalid');
                                    tag_alcunha_invalido.innerHTML = '<strong>' + value + '</strong>';
                                    break;    
                                case 'observacao_pessoa':
                                    input_obs_pessoa.classList.add('is-invalid');
                                    tag_obs_pessoa_invalido.innerHTML = '<strong>' + value + '</strong>';
                                    break;
                            }
                        })      
                    }
                    else{
                        $('#modal-cad-pessoas').modal('hide');
                    }
                }
            });
        });
    }, false);
}


