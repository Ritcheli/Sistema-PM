import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function(){
    $("#limpar_filtros").on('click', function(){
        $('input[type=date]').attr('value', ""); 
        $('input[type=text]').attr('value', ""); 
    });

    $(".btn-remove-ocorr").on('click', function(){
        let id_ocorrencia = $(this).attr('value');

        Swal.fire({
            title: 'Tem certeza que deseja excluir esta ocorrência?',
            icon: 'warning',
            text: 'Essa ação NÃO poderá ser revertida!',
            iconColor: '#CB333B',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            confirmButtonColor: '#009640',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#CB333B',
            focusCancel: true,
            width: '350px'
        }).then(function(result){
            if (result.value){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/ocorrencia/excluir-ocorrencia",
                    method: "POST",
                    data: {
                        id_ocorrencia: id_ocorrencia
                    },
                    success: function(){
                        location.reload();
                    }
                });
            }
        })
    });
}, false);