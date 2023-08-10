import { clear_input_img_file } from "./input_img_file";

export function clearModal(name_modal, CKEditor_element_name, editors){
    document.addEventListener('DOMContentLoaded', function () {
        $(name_modal).on('hidden.bs.modal', function (e) {
            $(this)
            .find("input,textarea,select")
                .val('')
                .prop("disabled", false)
                .end()
            .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();

            if (CKEditor_element_name != '') {
                editors[CKEditor_element_name].setData('');
            }
            
            // Limpa o componente de upload de imagens
            clear_input_img_file();

            // Remove as tags de validação
            $(".is-invalid").removeClass("is-invalid");
        })
    }, false);
}