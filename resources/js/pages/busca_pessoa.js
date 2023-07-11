import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function(){
    $(".btn-remove-pessoa").on('click', function(){
        let id_pessoa = $(this).attr('value');

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
                    url: "/pessoa/excluir-pessoa",
                    method: "POST",
                    data: {
                        id_pessoa: id_pessoa
                    },
                    success: function(){
                        location.reload();
                    }
                });
            }
        })
    });
}, false);