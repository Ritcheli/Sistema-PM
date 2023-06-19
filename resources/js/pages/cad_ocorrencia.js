import { createEditor } from '../components/textarea_CKEditor';
import { searchPessoa } from '../components/modal_busca_pessoa';
import Swal from 'sweetalert2';

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

    let tag_num_protocol_invalido = $('#num_protocolo_invalido');
    let tag_data_hora_invalido    = $('#data_hora_invalida');
    let tag_estado_invalido       = $('#estado_invalido');
    let tag_cidade_invalido       = $('#cidade_invalida');
    let tag_bairro_invalido       = $('#bairro_invalido');
    let tag_rua_invalida          = $('#rua_invalida');
    let tag_descricao_invalida    = $('#descricao_invalida');

    $('#cancelar-cad-ocorrencia').on('click',function(){
        editor.descricao_ocor.setData('');
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

    $(document).on("click", ".btn-table-remove", function(e){ 
        e.preventDefault();
        
        $(this).parent().parent().parent().remove();
    });

    $("#form_ocorrencia").on("submit", function(e){
        e.preventDefault();
        let url = $("#form_ocorrencia").attr('action')
    
        var form_data = new FormData();

        $('#table-body-pessoa').find('.btn-table-edit').each(function(e){
            form_data.append('envolvidos[]', this.value);
        });
        
        $('.is-invalid').removeClass('is-invalid');

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
                } else {
                    Swal.fire({
                        title: 'Ocorrência cadastrada!',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        confirmButtonColor: '#009640',
                        width: '350px'
                    }).then(function(){
                        location.href = result;  
                    })
                }
            }
        });
    })

}, false);