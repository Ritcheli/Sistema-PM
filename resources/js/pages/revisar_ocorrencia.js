import { searchVeiculo } from "../components/modal_busca_veiculo";
import { createEditor } from "../components/textarea_CKEditor";

var editor_desc_inic = {};
var editor_desc = {};

// Cria os elementos baseados em CKEditor
if (document.getElementById('descricao_ocor_import') != null){
    editor_desc = createEditor('descricao_ocor_import');
}

if (document.getElementById('descricao_inicial_ocor_import') != null){
    editor_desc_inic = createEditor('descricao_inicial_ocor_import');
} 

document.addEventListener('DOMContentLoaded', function(e){
    let input_num_protocolo           = $('#input_num_protocolo');
    let input_data_hora               = $('#input_data_hora');
    let input_cep                     = $('#input_CEP');
    let input_estado                  = $('#input_estado');
    let input_cidade                  = $('#input_cidade');
    let input_rua                     = $('#input_rua');
    let input_numero                  = $('#input_numero');
    let input_bairro                  = $('#input_bairro');
    let descricao_inicial_ocor_import = $('#descricao_inicial_ocor_import');
    let descricao_ocor_import         = $('#descricao_ocor_import');

    let tag_input_num_protocolo_invalido           = $('#input_num_protocolo-invalido');    
    let tag_input_data_hora_invalida               = $('#input_data_hora-invalida');
    let tag_input_tipo_ocorrencia_invalido         = $('#input_tipo_ocorrencia-invalido');
    let tag_input_estado_invalido                  = $('#input_estado-invalido');
    let tag_input_cidade_invalida                  = $('#input_cidade-invalida');
    let tag_input_bairro_invalido                  = $('#input_bairro-invalido');
    let tag_descricao_inicial_ocor_import_invalida = $('#descricao_inicial_ocor_import-invalida');
    let tag_descricao_ocor_import_invalida         = $('#descricao_ocor_import-invalida');

    $('#search-veiculos').on('click', function(e){
        e.preventDefault();

        searchVeiculo();
    })

    VirtualSelect.init({ 
        ele: '#tipo_ocorrencia_extraida',
        placeholder: 'Selecione o tipo da ocorrência',
        disableSelectAll: true,
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        showValueAsTags: true,
        autoFocus: false,
    });

    $('.tipo-ocorr-ext').removeAttr('hidden');

    $("#form_ocorrencia_revisada").on('submit', function(e){
        e.preventDefault();
        
        let url = $(this).attr('action');

        var veiculos  = [];
        var objetos   = [];
        var armas     = [];
        var drogas    = [];
        var animais   = []; 
        var tipo_ocor = [];

        var form_data = new FormData();

        form_data.append('num_protocol', input_num_protocolo.val());
        form_data.append('data_hora', input_data_hora.val());
        form_data.append('endereco_cep', input_cep.val());
        form_data.append('endereco_estado', input_estado.val());
        form_data.append('endereco_cidade', input_cidade.val());
        form_data.append('endereco_bairro', input_bairro.val());
        form_data.append('endereco_rua', input_rua.val());
        form_data.append('endereco_numero', input_numero.val());
        form_data.append('descricao_inicial', editor_desc_inic.descricao_inicial_ocor_import.getData());
        form_data.append('descricao', editor_desc.descricao_ocor_import.getData());

        $('#table-body-pessoa').find('.btn-table-edit').each(function(){
            form_data.append('envolvidos[]', this.value);
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
                'objeto'           : this.getElementsByClassName('objeto_objeto')[0].innerText.trim(),
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

        $.each($("#tipo_ocorrencia_extraida").find('.vscomp-value-tag'), function(){
            tipo_ocor.push($(this).attr('data-value'));
        })

        if (tipo_ocor.length > 0){
            form_data.append('tipo_ocorrencia', tipo_ocor);
        }

        form_data.append('id_ocorrencia_extraida', $(this).attr('value'));
        form_data.append('revisado', 'S');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: 'POST',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success:function(result){
                if (result.errors){
                    $.each(result.errors, function(key, value){
                        switch(key){
                            case 'num_protocol':
                                input_num_protocolo.addClass('is-invalid');
                                tag_input_num_protocolo_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'data_hora':
                                input_data_hora.addClass('is-invalid');
                                tag_input_data_hora_invalida.html('<strong>' + value + '</strong>');
                                break;
                            case 'tipo_ocorrencia':
                                $('#tipo_ocorrencia_extraida').addClass('is-invalid');
                                tag_input_tipo_ocorrencia_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'endereco_estado':
                                input_estado.addClass('is-invalid');
                                tag_input_estado_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'endereco_cidade':
                                input_cidade.addClass('is-invalid');
                                tag_input_cidade_invalida.html('<strong>' + value + '</strong>');
                                break;
                            case 'endereco_bairro':
                                input_bairro.addClass('is-invalid');
                                tag_input_bairro_invalido.html('<strong>' + value + '</strong>');
                                break;
                            case 'descricao_inicial':
                                descricao_inicial_ocor_import.addClass('is-invalid');
                                tag_descricao_inicial_ocor_import_invalida.html('<strong>' + value + '</strong>');
                                break;
                            case 'descricao':
                                descricao_ocor_import.addClass('is-invalid');
                                tag_descricao_ocor_import_invalida.html('<strong>' + value + '</strong>');
                                break;
                        }
                    });
                } else {
                    location.href = result;
                }
            }
        });
    });
}, false);