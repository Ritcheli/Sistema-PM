let array_img        = [],
    html_img_preview = '<div class="text-muted"> Preview das fotos escolhidas </div>',
    html_label_upl   = 'Escolha uma ou mais fotos',
    img_preview      = document.querySelector('.img-preview'),
    input            = document.getElementById('upload'),
    label_upl        = document.getElementById('label-upl');


if (input != null){
    clear_input_img_file();

    input.addEventListener("change", ()=>{
        const files = input.files;

        if (files.length > 1) {
            label_upl.innerHTML = files[0].name + ' mais ' + (files.length - 1) + ' foto(s)';
        } else {
            label_upl.innerHTML = files[0].name;
        }
        
        for (let i = 0; i < files.length; i++){
            array_img.push(files[i]);
        }

        display_img(files);

    });
}


function display_img(images){
    
    img_preview.innerHTML = '';

    for (let i = 0; i < images.length; i++){
        img_preview.innerHTML += `<img class="img-list img-fluid rounded" src="${ URL.createObjectURL(images[i])}" alt="">`;
    }
}

export function clear_input_img_file(){
    img_preview.innerHTML = '';
    img_preview.innerHTML = html_img_preview;
    label_upl.innerHTML = html_label_upl;
}
   