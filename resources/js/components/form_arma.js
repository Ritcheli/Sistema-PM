var who_call_arma = 'cad-arma'; 
let arma_edit;

document.addEventListener('DOMContentLoaded', function(){
    if ($('#form-armas').length > 0){
        let tipo_arma       = $('#tipo_arma');
        let especie_arma    = $('#especie_arma');
        let fabricacao_arma = $('#fabricacao_arma');
        let calibre_arma    = $('#calibre_arma');
        let num_serie_arma  = $('#num_serie_arma');

        let tag_tipo_arma_invalido       = $('#tipo_arma-invalido');
        let tag_especie_arma_invalida    = $('#especie_arma-invalida');
        let tag_fabricacao_arma_invalida = $('#fabricacao_arma-invalida');
        let tag_calibre_arma_invalido    = $('#calibre_arma-invalido');
        let tag_num_serie_arma_invalido  = $('#num_serie_arma-invalido');

        $('#reset_arma').on('click', function(){
            who_call_arma = "cad-arma";
        });

        $(document).on("click", ".edit-arma", function(e){
            e.preventDefault();

            arma_edit = $(this).closest('.arma');

            tipo_arma.val(arma_edit.find('.tipo_arma').html().trim());
            especie_arma.val(arma_edit.find('.especie_arma').html().trim());
            fabricacao_arma.val(arma_edit.find('.fabricacao_arma').html().trim());
            calibre_arma.val(arma_edit.find('.calibre_arma').html().trim());
            num_serie_arma.val(arma_edit.find('.num_serie_arma').html().trim());
            
            who_call_arma = "edit-arma";
        })

        $('#form-armas').on('submit', function(e){
            e.preventDefault();

            let form_data_arma = $(this).serializeArray();
            let validation_success = true;

            if (tipo_arma.val() == ""){
                tipo_arma.addClass('is-invalid');
                tag_tipo_arma_invalido.html('<strong> O campo tipo é obrigatório </strong>');
                validation_success = false;
            }
            if (especie_arma.val() == ""){
                especie_arma.addClass('is-invalid');
                tag_especie_arma_invalida.html('<strong> O campo espécie é obrigatório </strong>');
                validation_success = false;
            }
            if (fabricacao_arma.val() == ""){
                fabricacao_arma.addClass('is-invalid');
                tag_fabricacao_arma_invalida.html('<strong> O campo fabricação é obrigatório </strong>');
                validation_success = false;
            }
            if (calibre_arma.val() == ""){
                calibre_arma.addClass('is-invalid');
                tag_calibre_arma_invalido.html('<strong> O campo calibre é obrigatório </strong>');
                validation_success = false;
            }
            if (num_serie_arma.val() == ""){
                num_serie_arma.addClass('is-invalid');
                tag_num_serie_arma_invalido.html('<strong> O campo num. de série é obrigatório </strong>');
                validation_success = false;
            }
            
            if (validation_success) {
                if (who_call_arma == 'cad-arma'){
                    addArmaToTable(form_data_arma);
                }
                if (who_call_arma == 'edit-arma'){
                    arma_edit.find('.tipo_arma').html(form_data_arma[1]['value']);
                    arma_edit.find('.especie_arma').html(form_data_arma[2]['value']);
                    arma_edit.find('.fabricacao_arma').html(form_data_arma[3]['value']);
                    arma_edit.find('.calibre_arma').html(form_data_arma[4]['value']);
                    arma_edit.find('.num_serie_arma').html(form_data_arma[5]['value']);
                }

                who_call_arma == 'cad-arma';

                $(this)[0].reset();
                $(this).find('.is-invalid').removeClass('is-invalid')  
            } else {
                return;
            }
        })
    }
}, false);

function addArmaToTable(arma){
    $('#table-body-arma').append(
        `<tr class="arma">
            <th scope="row" class="align-middle tipo_arma">
                ` + arma[1]['value'] + `
            </th>
            <td scope="row" class="align-middle especie_arma">
                ` + arma[2]['value'] + `
            </td>
            <td scope="row" class="align-middle fabricacao_arma">
                ` + arma[3]['value'] + `
            </td>
            <td scope="row" class="align-middle calibre_arma">
                ` + arma[4]['value'] + `
            </td>
            <td scope="row" class="align-middle d-none num_serie_arma">
                ` + arma[5]['value'] + `
            </td>
            <td>
                <div class="d-flex justify-content-between">
                    <button type="button" title="Editar" class="btn btn-table-edit edit-arma w-45"> 
                        <i class='bx bxs-edit btn-table-icon-CM'></i>
                    </button>
                    <button type="button" title="Remover" class="btn btn-table-remove btn-remove-from-table w-45"> 
                        <i class='bx bxs-trash btn-table-icon-CM'></i>
                    </button>
                </div>
            </td>
        </tr>`
    )
}