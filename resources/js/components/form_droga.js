var who_call_droga = 'cad-droga';
let droga_edit;

document.addEventListener('DOMContentLoaded', function(){
    if ($('#form-drogas').length > 0) {
        let tipo_droga = $('#tipo_droga');
        let qtd_droga  = $('#qtd_droga');
        let unidade_medida_droga = $('#unidade_medida_droga');

        let tag_tipo_droga_invalido           = $('#tipo_droga-invalido');
        let tag_qtd_droga_invalida            = $('#qtd_droga-invalida');
        let tag_unidade_medida_droga_invalida = $('#unidade_medida_droga-invalida');

        $('#reset_droga').on('click', function(){
            who_call_droga = 'cad-droga';
        });

        $(document).on('click', '.edit-droga', function(e){
            e.preventDefault();

            droga_edit = $(this).closest('.droga');

            tipo_droga.val(droga_edit.find('.tipo_droga').html().trim());
            qtd_droga.val(droga_edit.find('.qtd_droga').html().trim());
            unidade_medida_droga.val(droga_edit.find('.un_medida_droga').html().trim());

            who_call_droga = 'edit-droga';
        })

        $('#form-drogas').on('submit', function(e){
            e.preventDefault();

            let form_data_droga = $(this).serializeArray();
            let validation_success = true;

            if (tipo_droga.val() == ""){
                tipo_droga.addClass('is-invalid');
                tag_tipo_droga_invalido.html('<strong> O campo tipo é obrigatório </strong>');
                validation_success = false;
            }
            if (qtd_droga.val() == ""){
                qtd_droga.addClass('is-invalid');
                tag_qtd_droga_invalida.html('<strong> O campo quantidade é obrigatório </strong>');
                validation_success = false;
            }
            if (unidade_medida_droga.val() == ""){
                unidade_medida_droga.addClass('is-invalid');
                tag_unidade_medida_droga_invalida.html('<strong> O campo un. de medida é obrigatório </strong>');
                validation_success = false;
            }

            if (validation_success){
                if (who_call_droga == 'cad-droga'){
                    addDrogaToTable(form_data_droga)
                }
                if (who_call_droga == 'edit-droga'){
                    droga_edit.find('.tipo_droga').html(form_data_droga[1]['value']);
                    droga_edit.find('.qtd_droga').html(form_data_droga[2]['value']);
                    droga_edit.find('.un_medida_droga').html(form_data_droga[3]['value']);
                }

                who_call_droga = 'cad-droga';

                $(this)[0].reset();
                $(this).find('.is-invalid').removeClass('is-invalid')  
            } else {
                return;
            }
        });
    }
}, false);

function addDrogaToTable(droga){
    $('#table-body-droga').append(
        `<tr class="droga">
            <th scope="row" class="align-middle tipo_droga">
                ` + droga[1]['value'] + `
            </th>
            <td scope="row" class="align-middle qtd_droga">
                ` + droga[2]['value'] + `
            </td>
            <td scope="row" class="align-middle un_medida_droga">
                ` + droga[3]['value'] + `
            </td>
            <td>
                <div class="d-flex justify-content-between">
                    <button type="button" title="Editar" class="btn btn-table-edit edit-droga w-45"> 
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