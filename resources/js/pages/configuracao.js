import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function() {
    const url = $('#form_fatos_manual').attr('action');

    VirtualSelect.init({ 
        ele: '#vs_potencial_ofensivo',
        search: false,
        placeholder: 'Selecione',
        showValueAsTags: true,
        zIndex: 200,
        options: [
            { label: 'Atípico', value: 'Atípico' },
            { label: 'Maior', value: 'Maior' },
            { label: 'Menor', value: 'Menor' },
            { label: 'Menor Condicionado', value: 'Menor Condicionado' },
        ],
    });

    VirtualSelect.init({ 
        ele: '#vs_grupo',
        search: false,
        placeholder: 'Selecione',
        showValueAsTags: true,
        allowNewOption: true,
        zIndex: 200,
    });

    $('#help_fatos').on('click', function(){
        Swal.fire({
            title: 'Ajuda',
            text: "Para atualizar a lista de fatos via importação, é necessário primeiramente obter o documento em pdf "
                + "e em seguida utilizar qualquer conversor de pdf para xls (excel) disponível na internet para converter "
                + "o arquivo em questão, por fim, selecione o arquivo resultante da conversão e importe para o sistema",
            icon: 'question',
            iconColor: '#a5dc86',
            confirmButtonText: 'Entendi',
            confirmButtonColor: '#009640',
            width: '100vh'
        })
    });

    document.querySelector('#vs_grupo').reset();
    $('#vs_grupo').attr('hidden', false);

    $('#salvar_fato_manual').on('click', function (e){
        e.preventDefault();

        $('#fato').removeClass('is-invalid');
        $('#vs_grupo').removeClass('is-invalid');
        $('#vs_potencial_ofensivo').removeClass('is-invalid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                fato : $('#fato').val(),
                grupo : $('#vs_grupo').val(),
                potencial_ofensivo : $('#vs_potencial_ofensivo').val(),
            },
            success: function(result){
                if (result.errors) {
                    $.each(result.errors, function(key, value){
                        switch (key) {
                            case 'fato':
                                $('#fato').addClass('is-invalid');
                                $('#tag_fato_invalido').html(value);
                                break;
                            case 'grupo':
                                $('#vs_grupo').addClass('is-invalid');
                                $('#tag_grupo_invalido').html(value);
                                break;
                            case 'potencial_ofensivo':
                                $('#vs_potencial_ofensivo').addClass('is-invalid');
                                $('#tag_potencial_ofensivo_invalido').html(value);
                                break;
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Fato inserido com sucesso',
                        icon: 'success',
                        iconColor: '#a5dc86',
                        confirmButtonText: 'Confirmar',
                        confirmButtonColor: '#009640',
                        width: '350px'
                    }).then(function(){
                        location.reload();
                    });
                }
            }
        });
    })
}, false);