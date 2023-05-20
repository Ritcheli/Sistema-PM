import { clearModal } from './modal';
import { createEditor } from '/resources/js/components/textarea_CKEditor';

let modal_cad_pessoa  = document.getElementById('modal-cad-pessoas');

let input_nome        = document.getElementById('nome');
let input_telefone    = document.getElementById('telefone');
let input_CPF_RG      = document.getElementById('CPF_RG');
let input_alcunha     = document.getElementById('alcunha');
let input_obs_pessoa  = document.getElementById('observacao_pessoa');
let input_foto        = document.getElementById('foto');

let tag_nome_invalido       = document.getElementById('nome-invalido');
let tag_telefone_invalido   = document.getElementById('telefone-invalido')
let tag_CPF_RG_invalido     = document.getElementById('CPF_RG-invalido');
let tag_alcunha_invalido    = document.getElementById('alcunha-invalido');
let tag_obs_pessoa_invalido = document.getElementById('observacao_pessoa-invalido');
let tag_foto                = document.getElementById('foto-invalido');


if (modal_cad_pessoa != null){
    let editor = {};

    editor = createEditor('observacao_pessoa');

    // Função para limpar o modal, argumentos(nome do modal, nome do CKEditor (areatext) caso exista, instância do objeto criada)
    clearModal('#modal-cad-pessoas', 'observacao_pessoa', editor);

    document.addEventListener('DOMContentLoaded', function () {
        var url = $('#form-pessoas').attr('action');

        $("#form-pessoas").on("submit", function(e){
            e.preventDefault();
            
            // Remove todas as validações realizadas
            input_nome.classList.remove('is-invalid');
            input_telefone.classList.remove('is-invalid');
            input_CPF_RG.classList.remove('is-invalid');
            input_alcunha.classList.remove('is-invalid');
            input_obs_pessoa.classList.remove('is-invalid');
            input_foto.classList.remove('is-invalid');

            let total_files = $('#upload')[0].files.length;
            var form_data = new FormData();

            form_data.append('nome', $('#nome').val());
            form_data.append('data_nascimento', $('#data_nascimento').val());
            form_data.append('telefone', $('#telefone').val());
            form_data.append('CPF_RG', $('#CPF_RG').val());
            form_data.append('alcunha', $('#alcunha').val());
            form_data.append('observacao_pessoa', editor.observacao_pessoa.getData());
            
            for (let i = 0; i < total_files; i++){
                form_data.append('files[]', $('#upload')[0].files[i])
            }
    
            form_data.append('total_files', total_files);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache:false, 
                contentType: false,
                processData: false,
                success: function(result){
                    if(result.errors){
                        $.each(result.errors, function(key, value){
                            if (key.match(/files.*/)){
                                input_foto.classList.add('is-invalid');
                                tag_foto.innerHTML = '<strong>' + value + '</strong>'; 
                            }

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


