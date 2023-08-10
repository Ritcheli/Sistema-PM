let html_img_preview = '<div class="text-muted"> Preview das fotos escolhidas </div>',
    html_label_upl   = 'Escolha uma ou mais fotos',
    input            = document.getElementsByClassName('upload-img-component');


if (input.length > 0){
    clear_input_img_file();

    document.addEventListener('DOMContentLoaded', function(){
        $(document).on("click", ".btn-remove-img", function(){
            let input_files  = $(this).closest('.upload-img-component').find('.input-foto')[0];
            let nome_img     = $(this).attr('value');
            let label_upload = $(this).closest('.upload-img-component').find('.label-foto')[0];
            let img_list     = $(this).closest('.upload-img-component').find('.img-list');
            let img_preview  = $(this).closest('.img-preview')[0];

            const dt = new DataTransfer();

            // Atualiza o componente do input file
            for (let i = 0; i < input_files.files.length; i++){
                if (input_files.files[i].name != nome_img){
                    dt.items.add(input_files.files[i]);
                }
            }

            input_files.files = dt.files;

            if (input_files.files.length > 0){
                update_input(input_files.files, label_upload);
            } else {
                label_upload.innerHTML = html_label_upl;
            }

            // Atualiza o componente de preview de imagens
            $(this).parent().remove();

            if (img_list.length == 1){
                img_preview.innerHTML = html_img_preview;
            }
        });

        $(document).on('change', '.input-foto', function(){
            let files        = $(this)[0].files;
            let label_upload = $(this).siblings('.label-foto')[0];
            let img_preview_1 = $(this).closest('.upload-img-component').find('.img-preview').first();

            update_input(files, label_upload);

            display_img(files, img_preview_1[0]);            
        });
    }, false);
}


function update_input(files, label_upload){
    if (files.length > 1) {
        label_upload.innerHTML = files[0].name + ' mais ' + (files.length - 1) + ' foto(s)';
    } else {
        label_upload.innerHTML = files[0].name;
    }
}

function display_img(files, img_preview_1){
    img_preview_1.innerHTML = '';

    for (let i = 0; i < files.length; i++){
        img_preview_1.innerHTML += `<div class="position-relative">
                                    <span type="button" value="${ files[i].name }" class="close btn-remove-img">&times;</span>
                                    <img class="img-list img-fluid rounded" src="${ URL.createObjectURL(files[i])}" alt="">
                                  </div>`;
    }
}

export function clear_input_img_file(){
    let img_preview = document.getElementsByClassName('img-preview');
    let label_upl   = document.getElementsByClassName('label-foto');


    for (let i = 0; i < img_preview.length; i++){
        img_preview[i].innerHTML = html_img_preview;
        label_upl[i].innerHTML   = html_label_upl;
    }
} 