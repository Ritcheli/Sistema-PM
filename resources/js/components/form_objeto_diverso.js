var who_call_obj  = 'cad-objeto';
let obj_edit;

document.addEventListener('DOMContentLoaded', function(e){
    VirtualSelect.init({ 
        ele: '#vs_tipo_objeto',
        placeholder: 'Selecione o tipo do objeto',
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        disableSelectAll: true,
        showValueAsTags: true,
        allowNewOption: true,
    });

    $('.tipo-obj').removeAttr('hidden');

    if (document.querySelector('#vs_tipo_objeto') != null){
        document.querySelector('#vs_tipo_objeto').reset();
    }
    
    if ($('#form-objetos-diversos').length > 0){
        let num_identificacao  = $('#num_identificacao');
        let marca_objeto       = $('#marca_objeto');
        let modelo_objeto      = $('#modelo_objeto');
        let unidade_medida_obj = $('#unidade_medida_obj');
        let tipo_objeto        = $('#tipo_obj');
        let quantidade_objeto  = $('#quantidade_objeto');

        let tag_marca_objeto_invalida       = $('#marca_objeto-invalida');
        let tag_modelo_objeto_invalido      = $('#modelo_objeto-invalido');
        let tag_unidade_medida_obj_invalida = $('#unidade_medida_obj-invalida');
        let tag_tipo_objeto_invalido        = $('#tipo_objeto-invalido');
        let tag_quantidade_objeto_invalida  = $('#quantidade_objeto-invalida');

        $('#reset_obj').on('click', function(){
            who_call_obj = 'cad-objeto';
        });

        $(document).on("click", ".edit-objeto", function(e){
            e.preventDefault();

            obj_edit = $(this).closest('.objeto');

            num_identificacao.val(obj_edit.find('.num_identificacao').html().trim());
            marca_objeto.val(obj_edit.find('.marca_objeto').html().trim());
            modelo_objeto.val(obj_edit.find('.modelo_objeto').html().trim());
            unidade_medida_obj.val(obj_edit.find('.un_med').html().trim());
            document.querySelector('#vs_tipo_objeto').setValue(obj_edit.find('.tipo_objeto').html().trim());
            quantidade_objeto.val(obj_edit.find('.quantidade').html().trim());
            
            who_call_obj = "edit-objeto";
        })
    
        $('#form-objetos-diversos').on('submit', function(e){
            e.preventDefault();
    
            let form_data_obj = $(this).serializeArray();
            let validation_success = true;
            
            if (marca_objeto.val() == ""){
                marca_objeto.addClass('is-invalid');
                tag_marca_objeto_invalida.html('<strong> O campo marca é obrigatório </strong>');
                validation_success = false;
            }
            if (modelo_objeto.val() == ""){
                modelo_objeto.addClass('is-invalid');
                tag_modelo_objeto_invalido.html('<strong> O campo modelo é obrigatório </strong>');
                validation_success = false;
            }
            if (unidade_medida_obj.val() == ""){
                unidade_medida_obj.addClass('is-invalid');
                tag_unidade_medida_obj_invalida.html('<strong> O campo un. de medida é obrigatório </strong>');
                validation_success = false;
            }
            if (document.querySelector('#vs_tipo_objeto').getDisplayValue() == ""){
                tipo_objeto.addClass('is-invalid');
                tag_tipo_objeto_invalido.html('<strong> O campo tipo é obrigatório </strong>');
                validation_success = false;
            }
            if (quantidade_objeto.val() == ""){
                quantidade_objeto.addClass('is-invalid');
                tag_quantidade_objeto_invalida.html('<strong> O campo quantidade é obrigatório </strong>');
                validation_success = false;
            }
            
            if (validation_success){
                if (who_call_obj == 'cad-objeto') {
                    addObjetoToTable(form_data_obj);  
                }
                if (who_call_obj == 'edit-objeto'){
                    obj_edit.find('.num_identificacao').html(form_data_obj[1]['value']);
                    obj_edit.find('.tipo_objeto').html(form_data_obj[2]['value']);
                    obj_edit.find('.marca_objeto').html(form_data_obj[3]['value']);
                    obj_edit.find('.modelo_objeto').html(form_data_obj[4]['value']);
                    obj_edit.find('.un_med').html(form_data_obj[5]['value']);
                    obj_edit.find('.quantidade').html(form_data_obj[6]['value']);
                }
                who_call_obj = 'cad-objeto';

                $(this)[0].reset();
                $(this).find('.is-invalid').removeClass('is-invalid')  
            } else {
                return
            }
        });
    }
}, false);

function addObjetoToTable(objeto_diverso){
    $('#table-body-objeto').append(
        `<tr class="objeto">
            <td scope="row" class="align-middle d-none num_identificacao">
                ` + objeto_diverso[1]['value'] + `
            </td>
            <th scope="row" class="align-middle tipo_objeto">
                ` + objeto_diverso[2]['value'] + `
            </th>
            <td scope="row" class="align-middle marca_objeto">
                ` + objeto_diverso[3]['value'] + `
            </td>
            <td scope="row" class="align-middle d-none un_med">
                ` + objeto_diverso[5]['value'] + `
            </td>
            <td class="align-middle modelo_objeto">
                ` + objeto_diverso[4]['value'] + `
            </td>   
            <td class="align-middle quantidade">
                ` + objeto_diverso[6]['value'] + `
            </td>
            <td class="align-middle">
                <div class="d-flex justify-content-between">
                    <button type="button" title="Editar" class="btn btn-table-edit edit-objeto w-45"> 
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