import { createEditor } from '../components/textarea_CKEditor';
import { searchPessoa } from '../components/modal_busca_pessoa';
var editor = {};

// Cria os elementos baseados em CKEditor
if (document.getElementById('descricao_ocor') != null){
    editor = createEditor('descricao_ocor');
}

document.addEventListener('DOMContentLoaded', function () {
    let input_num_protocol    = $('#input_num_protocolo');
    let input_data_hora       = $('#input_data_hora');
    let input_endereco_cep    = $('#input_CEP');
    let input_endereco_estado = $('#input_estado');
    let input_endereco_cidade = $('#input_cidade');
    let input_endereco_bairro = $('#input_bairro');
    let input_endereco_rua    = $('#input_endereco_rua');
    let input_numero          = $('#input_numero');
    let input_descricao       = $('#descricao_ocor');

    let tag_num_protocol_invalido          = $('#num_protocolo_invalido');
    let tag_data_hora_invalido             = $('#data_hora_invalida');
    let tag_input_tipo_ocorrencia_invalido = $('#input_tipo_ocorrencia-invalido');
    let tag_estado_invalido                = $('#estado_invalido');
    let tag_cidade_invalido                = $('#cidade_invalida');
    let tag_bairro_invalido                = $('#bairro_invalido');
    let tag_rua_invalida                   = $('#rua_invalida');
    let tag_descricao_invalida             = $('#descricao_invalida');

    VirtualSelect.init({ 
        ele: '#tipo_ocorrencia',
        placeholder: 'Selecione o tipo da ocorrência',
        disableSelectAll: true,
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        showValueAsTags: true
    });

    $('.tipo-ocorr').removeAttr('hidden');

    $('#cancelar-cad-ocorrencia').on('click',function(){
        window.history.back();
    });

    $("#search-pessoa").on("click", function(e){
        e.preventDefault();
        
        searchPessoa();
    });

    $("#input_CEP").on("blur", function(){
        const cep = $(this).val();
        const url = `http://viacep.com.br/ws/${cep}/json`;

        if (cep != ""){
            $.get(url, function(data){
                $('#input_endereco_rua').val(data.logradouro);
                $('#input_bairro').val(data.bairro);
                $('#input_cidade').val(data.localidade);
                $('#input_estado').val(data.uf);
            })
        }
    });

    $("#form_ocorrencia").on("submit", function(e){
        e.preventDefault();
        let url = $("#form_ocorrencia").attr('action')
        
        var envolvidos = [];
        var veiculos   = [];
        var objetos    = [];
        var armas      = [];
        var drogas     = [];
        var animais    = []; 
        var tipo_ocor  = [];

        var form_data = new FormData();

        $('#table-body-pessoa').find('.envolvido').each(function(){
            envolvidos.push({
                'id_envolvido': this.getElementsByClassName('id-envolvido')[0].innerText.trim(),
                'participacao': this.getElementsByClassName('participacao-envolvido')[0].innerText.trim(),
            });
        }); 

        envolvidos.forEach(item => {
            form_data.append('envolvidos[]', JSON.stringify(item));
        });
        
        $('#table-body-veiculo').find('.veiculo').each(function(){
            veiculos.push({
                'id_veiculo'  : this.getElementsByClassName('btn-table-remove')[0].value,
                'participacao': this.getElementsByClassName('participacao')[0].innerText.trim()
            });
        })

        veiculos.forEach(item => {
            form_data.append('veiculos[]', JSON.stringify(item));
        });
        
        $('#table-body-objeto').find('.objeto').each(function(){
            objetos.push({
                'num_identificacao': this.getElementsByClassName('num_identificacao')[0].innerText.trim(),
                'tipo_objeto'      : this.getElementsByClassName('tipo_objeto')[0].innerText.trim(),
                'marca_objeto'     : this.getElementsByClassName('marca_objeto')[0].innerText.trim(),
                'un_med'           : this.getElementsByClassName('un_med')[0].innerText.trim(),
                'modelo_objeto'    : this.getElementsByClassName('modelo_objeto')[0].innerText.trim(),
                'quantidade'       : this.getElementsByClassName('quantidade')[0].innerText.trim()
            });
        })

        objetos.forEach(item => {
            form_data.append('objetos[]', JSON.stringify(item));
        });

        $('#table-body-arma').find('.arma').each(function(){
            armas.push({
                'tipo'      : this.getElementsByClassName('tipo_arma')[0].innerText.trim(),
                'especie'   : this.getElementsByClassName('especie_arma')[0].innerText.trim(),
                'fabricacao': this.getElementsByClassName('fabricacao_arma')[0].innerText.trim(),
                'calibre'   : this.getElementsByClassName('calibre_arma')[0].innerText.trim(),
                'num_serie' : this.getElementsByClassName('num_serie_arma')[0].innerText.trim()
            });
        })

        armas.forEach(item => {
            form_data.append('armas[]', JSON.stringify(item));
        });

        $('#table-body-droga').find('.droga').each(function(){
            drogas.push({
                'tipo'       : this.getElementsByClassName('tipo_droga')[0].innerText.trim(),
                'quantidade' : this.getElementsByClassName('qtd_droga')[0].innerText.trim(),
                'un_medida'  : this.getElementsByClassName('un_medida_droga')[0].innerText.trim(),
            });
        })

        drogas.forEach(item => {
            form_data.append('drogas[]', JSON.stringify(item));
        });

        $('#table-body-animal').find('.animal').each(function(){
            animais.push({
                'especie'     : this.getElementsByClassName('especie_animal')[0].innerText.trim(),
                'quantidade'  : this.getElementsByClassName('qtd_animal')[0].innerText.trim(),
                'participacao': this.getElementsByClassName('participacao_animal')[0].innerText.trim(),
                'outras_info' : this.getElementsByClassName('outras_info_animal')[0].innerText.trim(),
            });
        })

        animais.forEach(item => {
            form_data.append('animais[]', JSON.stringify(item));
        });

        $.each($("#tipo_ocorrencia").find('.vscomp-value-tag'), function(){
            tipo_ocor.push($(this).attr('data-value'));
        })

        if (tipo_ocor.length > 0){
            form_data.append('tipo_ocorrencia', tipo_ocor);
        }

        $('.is-invalid').removeClass('is-invalid');

        if ($("#salvar_ocorr").val() != ""){
            form_data.append('id_ocorrencia', $("#salvar_ocorr").val());
        }

        form_data.append('num_protocol', input_num_protocol.val());
        form_data.append('data_hora', input_data_hora.val());
        form_data.append('endereco_cep', input_endereco_cep.val());
        form_data.append('endereco_estado', input_endereco_estado.val());
        form_data.append('endereco_cidade', input_endereco_cidade.val());
        form_data.append('endereco_bairro', input_endereco_bairro.val());
        form_data.append('endereco_rua', input_endereco_rua.val());
        form_data.append('endereco_numero', input_numero.val());
        form_data.append('descricao', editor.descricao_ocor.getData());  

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: "POST",
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result){
                if (result.errors){
                    $.each(result.errors, function(key, value){
                        switch(key){
                            case 'num_protocol':
                                input_num_protocol.addClass('is-invalid');
                                tag_num_protocol_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'data_hora':
                                input_data_hora.addClass('is-invalid');
                                tag_data_hora_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'tipo_ocorrencia':
                                $('#tipo_ocorrencia').addClass('is-invalid');
                                tag_input_tipo_ocorrencia_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'endereco_estado':
                                input_endereco_estado.addClass('is-invalid');
                                tag_estado_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'endereco_cidade':
                                input_endereco_cidade.addClass('is-invalid');
                                tag_cidade_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'endereco_bairro':
                                input_endereco_bairro.addClass('is-invalid');
                                tag_bairro_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'endereco_rua':
                                input_endereco_rua.addClass('is-invalid');
                                tag_rua_invalida.html('<strong>' + value + '</strong>');
                                break;
                            case 'descricao':
                                input_descricao.addClass('is-invalid');
                                tag_descricao_invalida.html('<strong>' + value + '</strong>');
                                break;
                        }
                    });
                } 
                else {
                    location.href = result;  
                }
            }
        });
    })

}, false);