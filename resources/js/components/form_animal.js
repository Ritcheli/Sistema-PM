var who_call_animal = 'cad-animal';
let animal_edit;

document.addEventListener('DOMContentLoaded', function(){
    if ($('#form-animais').length > 0) {
        let especie_animal      = $('#especie_animal');
        let qtd_animal          = $('#qtd_animal');
        let participacao_animal = $('#participacao_animal');
        let outras_info_animal  = $('#outras_info_animal');

        let tag_especie_animal_invalida      = $('#especie_animal-invalida');
        let tag_qtd_animal_invalida          = $('#qtd_animal-invalida');
        let tag_participacao_animal_invalida = $('#participacao_animal-invalida');
        let tag_outras_info_animal_invalida  = $('#outras_info_animal-invalida');

        $('#reset_animal').on('click', function(){
            who_call_animal = 'cad-animal';
        });

        $(document).on('click', '.edit-animal', function(e){
            e.preventDefault();

            animal_edit = $(this).closest('.animal');

            especie_animal.val(animal_edit.find('.especie_animal').html().trim());
            qtd_animal.val(animal_edit.find('.qtd_animal').html().trim());
            participacao_animal.val(animal_edit.find('.participacao_animal').html().trim());
            outras_info_animal.val(animal_edit.find('.outras_info_animal').html().trim());

            who_call_animal = 'edit-animal';
        });

        $('#form-animais').on('submit', function(e){
            e.preventDefault();

            let form_data_animal        = $(this).serializeArray();
            let validation_success = true;

            if (especie_animal.val() == ""){
                especie_animal.addClass('is-invalid');
                tag_especie_animal_invalida.html('<strong> O campo espécie é obrigatório </strong>');
                validation_success = false;
            }
            if (qtd_animal.val() == ""){
                qtd_animal.addClass('is-invalid');
                tag_qtd_animal_invalida.html('<strong> O campo quantidade é obrigatório </strong>');
                validation_success = false;
            }
            if (participacao_animal.val() == ""){
                participacao_animal.addClass('is-invalid');
                tag_participacao_animal_invalida.html('<strong> O campo participação é obrigatório </strong>');
                validation_success = false;
            }
            if (outras_info_animal.val() == ""){
                outras_info_animal.addClass('is-invalid');
                tag_outras_info_animal_invalida.html('<strong> O campo outras informações é obrigatório </strong>');
                validation_success = false;
            }

            if (validation_success){
                if (who_call_animal == 'cad-animal'){
                    addAnimalToTable(form_data_animal);
                }
                if (who_call_animal == 'edit-animal'){
                    animal_edit.find('.especie_animal').html(form_data_animal[1]['value']);
                    animal_edit.find('.qtd_animal').html(form_data_animal[2]['value']);
                    animal_edit.find('.participacao_animal').html(form_data_animal[3]['value']);
                    animal_edit.find('.outras_info_animal').html(form_data_animal[4]['value']);
                }
                who_call_animal = 'cad-animal';

                $(this)[0].reset();
                $(this).find('.is-invalid').removeClass('is-invalid') 
            } else {
                return;
            }
        });
    }
}, false)

function addAnimalToTable(animal){
    $('#table-body-animal').append(
        `<tr class="animal">
            <th scope="row" class="align-middle especie_animal">
                ` + animal[1]['value'] + `
            </th>
            <td scope="row" class="align-middle qtd_animal">
                ` + animal[2]['value'] + `
            </td>
            <td scope="row" class="align-middle participacao_animal">
                ` + animal[3]['value'] + `
            </td>
            <td scope="row" class="align-middle d-none outras_info_animal">
                ` + animal[4]['value'] + `
            </td>
            <td>
                <div class="d-flex justify-content-between">
                    <button type="button" title="Editar" class="btn btn-table-edit edit-animal w-45"> 
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