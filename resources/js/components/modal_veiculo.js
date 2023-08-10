import { clearModal } from "./modal";

var who_call = "";
let component_veiculo;

// Função para limpar o modal, argumentos(nome do modal, nome do CKEditor (areatext) caso exista, instância do objeto criada)
clearModal('#modal-veiculo', '', '');

document.addEventListener("DOMContentLoaded", function(){
    if ($('#modal-veiculo').length > 0){
        let placa                = $('#placa');
        let marca_modelo_veiculo = $('#marca_modelo_veiculo');
        let cor_veiculo          = $('#cor_veiculo');
        let chassi               = $('#chassi');
        let renavam              = $('#renavam');
        let participacao_veiculo = $('#participacao_veiculo');

        let tag_placa_invalida                = $('#placa-invalida');
        let tag_marca_modelo_veiculo_invalido = $('#marca_modelo_veiculo-invalido');
        let tag_cor_veiculo_invalida          = $('#cor_veiculo-invalida');
        let tag_chassi_invalido               = $('#chassi-invalido');
        let tag_renavam_invalido              = $('#renavam-invalido');
        let tag_participacao_veiculo_invalido = $('#participacao_veiculo-invalida');

        $('#cad-veiculo').on("click", function(e){
            e.preventDefault();
            component_veiculo = $(this).closest('.veiculo');

            who_call = "cad-veiculo";

            $('#modal-veiculo').modal('show');
        });

        $(document).on("click", ".edit-veiculo", function(e){
            let participacao = $(this).closest('.veiculo').find('.participacao').html().replace(/\s/g, '');

            addParticipacaoVeiculo($(this).val());
            
            component_veiculo = $(this).closest('.veiculo');

            $('#participacao_veiculo').val(participacao);  

            who_call = 'edit-participacao';         
        });


        $('#form-veiculos').on('submit', function(e){
            e.preventDefault();            

            let form_data = $(this).serializeArray();

            if (who_call == "cad-veiculo"){
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/veiculo/cad-veiculo',
                    method: 'POST',
                    data: form_data,
                    success: function(result){
                        if (result.errors){
                            $.each(result.errors, function(key, value){
                                switch(key){
                                    case 'placa':
                                        placa.addClass('is-invalid');
                                        tag_placa_invalida.html('<strong>' + value + '</strong>');
                                        break;
                                    case 'marca_modelo_veiculo':
                                        marca_modelo_veiculo.addClass('is-invalid');
                                        tag_marca_modelo_veiculo_invalido.html('<strong>' + value + '</strong>');
                                        break;
                                    case 'cor_veiculo':
                                        cor_veiculo.addClass('is-invalid');
                                        tag_cor_veiculo_invalida.html('<strong>' + value + '</strong>');
                                        break;
                                    case 'chassi':
                                        chassi.addClass('is-invalid');
                                        tag_chassi_invalido.html('<strong>' + value + '</strong>');
                                        break;
                                    case 'renavam':
                                        renavam.addClass('is-invalid');
                                        tag_renavam_invalido.html('<strong>' + value + '</strong>');
                                        break;
                                    case 'participacao_veiculo':
                                        participacao_veiculo.addClass('is-invalid');
                                        tag_participacao_veiculo_invalido.html('<strong>' + value + '</strong>');
                                        break;
                                }
                            })
                        } else {
                            if ($('#table-body-veiculo').length > 0){
                                addVeiculoToTable(result.veiculo, form_data[2].value, form_data[6].value);
                            }

                            $('#modal-veiculo').modal('hide');
                        }
                    }
                })
            }

            if (who_call == "cad-participacao"){
                if ($('#table-body-veiculo').length > 0){
                    if (participacao_veiculo.val() == "") {
                        participacao_veiculo.addClass('is-invalid');
                        tag_participacao_veiculo_invalido.html('<strong> O campo participacao veiculo é obrigatório </strong>');
                        return;
                    }

                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/veiculo/buscar-veiculo-por-placa',
                        method: 'POST',
                        data: {
                            placa: placa.val()
                        },
                        success: function(result){
                            addVeiculoToTable(result.veiculo, marca_modelo_veiculo.val(), participacao_veiculo.val());

                            $('#modal-veiculo').modal('hide');
                        }
                    });
                }
            }

            if (who_call == "edit-participacao"){
                if ($('#table-body-veiculo').length > 0){
                    if (participacao_veiculo.val() == "") {
                        participacao_veiculo.addClass('is-invalid');
                        tag_participacao_veiculo_invalido.html('<strong> O campo participacao veiculo é obrigatório </strong>');
                        return;
                    }

                    component_veiculo.find('.participacao').html(participacao_veiculo.val());

                    $('#modal-veiculo').modal('hide');
                }
            }
        });
    }
}, false);

export function addParticipacaoVeiculo(placa){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: '/veiculo/buscar-veiculo-por-placa',
        method: 'POST',
        data: {
            placa: placa
        },
        success: function(result){
            $('#placa').val(result.veiculo.placa);
            $('#marca_modelo_veiculo').val(result.veiculo.marca);
            $('#cor_veiculo').val(result.veiculo.cor);
            $('#chassi').val(result.veiculo.chassi);
            $('#renavam').val(result.veiculo.renavam);

            $('#placa').attr("disabled", true);
            $('#marca_modelo_veiculo').attr("disabled", true);
            $('#cor_veiculo').attr("disabled", true);
            $('#chassi').attr("disabled", true);
            $('#renavam').attr("disabled", true);

            $('#modal-veiculo').modal('show');
        }
    });

    who_call = "cad-participacao";
}

export function addVeiculoToTable(veiculo, marca_modelo_veiculo, participacao_veiculo){
    $('#table-body-veiculo').append(
        `<tr class="veiculo">
            <th scope="row" class="align-middle placa">
                ` + veiculo.placa + `
            </th>
            <td class="align-middle marca_modelo_veiculo">
                ` + marca_modelo_veiculo + `
            </td>
            <td class="align-middle cor_veiculo">
                ` + veiculo.cor + `
            </td>
            <td class="align-middle participacao">
                ` + participacao_veiculo + `
            </td>
            <td>
                <div class="d-flex justify-content-between">
                    <button type="button" value="` + veiculo.placa + `" title="Editar" class="btn btn-table-edit edit-veiculo w-45"> 
                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                    </button>
                    <button type="button" value="` + veiculo.id_veiculo + `" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                    </button>
                </div>
            </td>
        </tr>`
    );
}