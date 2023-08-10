let input          = document.getElementsByClassName('input-files-component'),
    html_label_upl = 'Escolha um ou mais arquivos';

if (input.length > 0){
    clear_input_files();

    document.addEventListener('DOMContentLoaded', function(){
        $(document).on('change', '.input-files', function(){
            let files         = $(this)[0].files;
            let label_upload  = $(this).siblings('.label-file')[0];

            update_input(files, label_upload);         
        });
    }, false);
}

function update_input(files, label_upload){
    if (files.length > 1) {
        label_upload.innerHTML = files[0].name + ' mais ' + (files.length - 1) + ' arquivo(s)';
    } else {
        label_upload.innerHTML = files[0].name;
    }
}

export function clear_input_files(){
    let label_upl = document.getElementsByClassName('label-file');

    for (let i = 0; i < label_upl.length; i++){
        label_upl[i].innerHTML = html_label_upl;
    }
}