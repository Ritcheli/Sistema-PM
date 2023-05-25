let html_img_preview = '<div class="text-muted"> Preview das fotos escolhidas </div>',
    html_label_upl   = 'Escolha uma ou mais fotos',
    img_preview      = document.querySelector('.img-preview'),
    input            = document.getElementById('upload'),
    label_upl        = document.getElementById('label-upl'),
    img_list         = document.getElementsByClassName('img-list');


if (input != null){
    clear_input_img_file();

    document.addEventListener('DOMContentLoaded', function(){
        $(document).on("click", ".btn-remove-img", function(){
            let files = input.files;
            let nome_img = $(this).attr('value');

            const dt = new DataTransfer();

            // Atualiza o componente do input file
            for (let i = 0; i < files.length; i++){
                if (files[i].name != nome_img){
                    dt.items.add(files[i]);
                }
            }

            input.files = dt.files;

            if (input.files.length > 0){
                update_input(input.files);
            } else {
                label_upl.innerHTML = html_label_upl;
            }

            // Atualiza o componente de preview de imagens
            $(this).parent().remove();

            if (img_list.length == 0){
                img_preview.innerHTML = html_img_preview;
            }
        });
    }, false);

    input.addEventListener("change", ()=>{
        let files = input.files;
        
        update_input(files);

        display_img(files);
    });
}


function update_input(files){
    if (files.length > 1) {
        label_upl.innerHTML = files[0].name + ' mais ' + (files.length - 1) + ' foto(s)';
    } else {
        label_upl.innerHTML = files[0].name;
    }
}

function display_img(images){
    
    img_preview.innerHTML = '';

    for (let i = 0; i < images.length; i++){
        img_preview.innerHTML += `<div class="position-relative">
                                    <span type="button" value="${ images[i].name }" class="close btn-remove-img">&times;</span>
                                    <img class="img-list img-fluid rounded" src="${ URL.createObjectURL(images[i])}" alt="">
                                  </div>`;
    }
}

export function clear_input_img_file(){
    img_preview.innerHTML = '';
    img_preview.innerHTML = html_img_preview;
    label_upl.innerHTML = html_label_upl;
}
   