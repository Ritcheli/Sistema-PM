import { clearModal } from './modal';
import { createEditor } from '/resources/js/components/textarea_CKEditor';

let modal_cad_pessoa  = document.getElementById('modal-pessoa');

let input_nome            = document.getElementById('nome');
let input_telefone        = document.getElementById('telefone');
let input_CPF_RG          = document.getElementById('CPF_RG');
let input_data_nascimento = document.getElementById('data_nascimento');
let input_alcunha         = document.getElementById('alcunha');
let input_obs_pessoa      = document.getElementById('observacao_pessoa');
let input_foto            = document.getElementById('foto');
let input_file            = document.getElementById('upload');

let tag_nome_invalido         = document.getElementById('nome-invalido');
let tag_telefone_invalido     = document.getElementById('telefone-invalido')
let tag_CPF_RG_invalido       = document.getElementById('CPF_RG-invalido');
let tag_alcunha_invalido      = document.getElementById('alcunha-invalido');
let tag_obs_pessoa_invalido   = document.getElementById('observacao_pessoa-in valido');
let tag_foto                  = document.getElementById('foto-invalido');
let tag_participacao_invalido = document.getElementById('envolvido_participacao-invalido');
let tag_fato_invalido         = document.getElementById('envolvido_fato-invalido');

let id_edit_pessoa = 0;
let component_pessoa;
var editor = {};

const dt = new DataTransfer();

var who_call = "";

if (modal_cad_pessoa != null){

    editor = createEditor('observacao_pessoa');

    // Função para limpar o modal, argumentos(nome do modal, nome do CKEditor (areatext) caso exista, instância do objeto criada)
    clearModal('#modal-pessoa', 'observacao_pessoa', editor);

    document.addEventListener('DOMContentLoaded', function () {        
        var url = $('#form-pessoas').attr('action');

        $("#modal-pessoa").on("hidden.bs.modal", function () {
            $("#table-body-fato-parti").html("");
        });

        VirtualSelect.init({ 
            ele: '#vs_envolvido_participacao',
            placeholder: 'Participacao na ocorrência',
            noSearchResultsText: 'Nenhum resultado encontrado',
            searchPlaceholderText: 'Procurar...', 
            disableSelectAll: true,
            zIndex: 100,
            showValueAsTags: true,
        });
    
        $('.envolvido-participacao').removeAttr('hidden');

        document.querySelector('#vs_envolvido_participacao').reset();

        VirtualSelect.init({ 
            ele: '#vs_envolvido_fato',
            placeholder: 'Selecione o fato',
            noSearchResultsText: 'Nenhum resultado encontrado',
            searchPlaceholderText: 'Procurar...', 
            disableSelectAll: true,
            zIndex: 100,
            showValueAsTags: true,
        });
    
        $('.envolvido-fato').removeAttr('hidden');

        document.querySelector('#vs_envolvido_fato').reset();

        $('#modal-pessoa').on('hidden.bs.modal', function () {
            document.querySelector('#vs_envolvido_participacao').reset();
        })

        $("#cad-pessoa").on("click", function(e){
            e.preventDefault();
            
            $("#modal-pessoa").modal('show');

            who_call = 'cad-pessoa';
            
            $("#modal-pessoa-title")[0].innerHTML = "Cadastro de pessoas";
            $("#salvar-pessoa")[0].innerHTML = "Salvar";
        });

        $("#inserir-parti").on("click", function(e){
            e.preventDefault();
        
            let fato         = (document.querySelector('#vs_envolvido_fato').innerText).split('\n')[0];
            let participacao = (document.querySelector('#vs_envolvido_participacao').innerText).split('\n')[0];
            let error_parti  = false;

            if ($('#vs_envolvido_fato').val() == ""){
                $('#envolvido_fato').addClass('is-invalid');
                tag_fato_invalido.innerHTML = '<strong> O fato é obrigatório </strong>';

                error_parti = true;
            }
            if ($('#vs_envolvido_participacao').val() == ""){
                $('#envolvido_participacao').addClass('is-invalid');
                tag_participacao_invalido.innerHTML = '<strong> A participação é obrigatória </strong>';

                error_parti = true;
            }

            if (error_parti == true){
                return;
            }

            document.querySelector('#vs_envolvido_participacao').reset();
            document.querySelector('#vs_envolvido_fato').reset();

            $('#envolvido_fato').removeClass('is-invalid');
            $('#envolvido_participacao').removeClass('is-invalid');

            addFatoToTable(fato, participacao);
        })

        if ($("#table-pessoa")[0] != null){
            $(document).on("click", ".edit-pessoa", function(e){
                component_pessoa = $(this).closest('.envolvido');
                id_edit_pessoa = $(this).attr('value');

                e.preventDefault();

                let fato_participacao = (($(this).closest('.envolvido').find('.participacao-envolvido').html().trim()).split('|'));

                if (fato_participacao[0] != ''){
                    fato_participacao.forEach( 
                        (element) => 
                            addFatoToTable(element.split(':')[1], element.split(':')[0])
                    );
                }
                
                $("#modal-pessoa-title")[0].innerHTML = "Atualização de pessoas";
                $("#salvar-pessoa")[0].innerHTML      = "Atualizar";

                loadDadoPessoa(id_edit_pessoa, 'edit-pessoa')

                $("#modal-pessoa").modal('show');
            })
        }

        $("#form-pessoas").on("submit", function(e){
            e.preventDefault();

            // Remove todas as validações realizadas
            input_nome.classList.remove('is-invalid');
            input_telefone.classList.remove('is-invalid');
            input_CPF_RG.classList.remove('is-invalid');
            input_alcunha.classList.remove('is-invalid');
            input_obs_pessoa.classList.remove('is-invalid');
            input_foto.classList.remove('is-invalid');

            let total_files       = $('#upload')[0].files.length;
            let fato_participacao = "";
            var form_data         = new FormData();

            form_data.append('Who_Call', 'Modal_Pessoa')
            form_data.append('id_pessoa', id_edit_pessoa);
            form_data.append('nome', $('#nome').val());
            form_data.append('data_nascimento', $('#data_nascimento').val());
            form_data.append('telefone', $('#telefone').val());
            form_data.append('CPF_RG', $('#CPF_RG').val());
            form_data.append('alcunha', $('#alcunha').val());
            form_data.append('participacao', $('#vs_envolvido_participacao').val());
            form_data.append('observacao_pessoa', editor.observacao_pessoa.getData());
            
            $('#table-body-fato-parti').find('.fato_participacao').each(function(){
                fato_participacao += this.getElementsByClassName('participacao-envolvido')[0].innerText.trim() + ':' +
                                     this.getElementsByClassName('fato-envolvido')[0].innerText.trim() + '|'
            });

            fato_participacao =  fato_participacao.slice(0,-1);

            for (let i = 0; i < total_files; i++){
                form_data.append('files[]', $('#upload')[0].files[i]);
            }

            form_data.append('total_files', total_files);

            if ((who_call == "edit-pessoa") || (who_call == "busca-pessoa")){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/pessoa/salvar-edit-pessoa",
                    method: "POST",
                    data: form_data,
                    cache: false,
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
                        } else {
                            if (who_call == 'edit-pessoa'){
                                component_pessoa.find('.nome-envolvido').html(result.pessoa.nome);
                                component_pessoa.find('.participacao-envolvido').html(fato_participacao);
                            }

                            if (who_call == 'busca-pessoa'){
                                addPessoaToTable(result.pessoa.id_pessoa, result.pessoa.nome, result.pessoa.RG_CPF, fato_participacao);
                            }

                            $("#modal-pessoa").modal('hide');
                        }
                    }
                });
            }

            if (who_call == "cad-pessoa"){
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
                            $('#modal-pessoa').modal('hide');

                            if ($("#table-body-pessoa").length > 0){
                                addPessoaToTable(result.pessoa.id_pessoa, result.pessoa.nome, result.pessoa.RG_CPF, fato_participacao);
                            }
                        }
                    }
                });
            }
        });
    }, false);
}

export function loadURLToInputFiled(urls){
    dt.clearData();

    for (const i in urls){
        getImgURL(urls[i].caminho_servidor, (imgBlob)=>{
            let fileName = urls[i].caminho_servidor.split('/').pop();
            let file = new File([imgBlob], fileName, {type:"image/png", lastModified:new Date().getTime()});

            dt.items.add(file);

            if (dt.items.length == urls.length){
                input_file.files = dt.files;

                $('#upload').trigger("change");
            }
          })
    }
} 

// xmlHTTP return blob respond
function getImgURL(url, callback){
    var xhr = new XMLHttpRequest();

    xhr.onload = function() {
        callback(xhr.response);
    };

    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}

export function addFatoToTable(fato, participacao){
    $("#table-body-fato-parti").append(
        `<tr class="fato_participacao">
            <td scope="row" class="align-middle fato-envolvido">
                ` + fato + `
            </td>
            <td class="align-middle participacao-envolvido">
                ` + participacao + `
            </td>
            <td>
                <div class="d-flex justify-content-center">
                    <button type="button" title="Remover" class="btn btn-table-remove btn-remove-from-table w-40"> 
                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                    </button>
                </div>
            </td>
        </tr>`
    );
}

export function addPessoaToTable(id_pessoa, nome , RG_CPF, fato_participacao){
    $("#table-body-pessoa").append(
        `<tr class="envolvido">
            <th scope="row" class="align-middle id-envolvido">
                ` + id_pessoa + `
            </th>
            <td class="align-middle nome-envolvido">
                ` + nome + `
            </td>
            <td class="align-middle RG_CPF-envolvido">
                ` + RG_CPF + `
            </td>
            <td class="align-middle participacao-envolvido d-none">
                ` + fato_participacao + `
            </td>
            <td>
                <div class="d-flex justify-content-between">
                    <button type="button" value="` + id_pessoa + `" title="Editar" class="btn btn-table-edit edit-pessoa w-45"> 
                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                    </button>
                    <button type="button" value="` + id_pessoa + `" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                    </button>
                </div>
            </td>
        </tr>`
    );
}

export function loadDadoPessoa(id_pessoa, who_call_load){
    who_call       = who_call_load;
    id_edit_pessoa = id_pessoa;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/ocorrencia/editar-pessoa-modal",
        method: "POST",
        data: {
            id_pessoa: id_pessoa,
        },
        success: function(result){
            input_nome.value = result.pessoas[0].nome;
            input_CPF_RG.value = result.pessoas[0].RG_CPF;
            input_telefone.value = result.pessoas[0].telefone;
            input_data_nascimento.value = result.pessoas[0].data_nascimento;
            input_alcunha.value = result.pessoas[0].alcunha;

            if (result.pessoas[0].observacao == null) {
                editor.observacao_pessoa.setData("");
            } else {
                editor.observacao_pessoa.setData(result.pessoas[0].observacao);
            } 

            if (result.fotos_pessoas.length > 0){
                loadURLToInputFiled(result.fotos_pessoas);
            };
        }
    });
}