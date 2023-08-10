import { resetCustomSelection } from "../components/custom-selection";
import { clear_input_files } from "../components/input_files_component";
import Swal from 'sweetalert2';

document.addEventListener("DOMContentLoaded", function(){
    $('#limpar_filtros_ocorr_import').on('click', function(){
        resetCustomSelection();
    });


    $('#limpar_import').on("click", function(e){
        e.preventDefault();

        clear_input_files();
    });

    $(document).on('click', '.btn-remove-ocorr-extr', function(e){
        e.preventDefault();

        let id_ocorrencia_extraida = $(this).attr('value');

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
                    url: "/ocorrencia/excluir-ocorrencia-extraida",
                    method: "POST",
                    data: {
                        id_ocorrencia_extraida: id_ocorrencia_extraida
                    },
                    success: function(){
                        location.reload();
                    }
                });
            }
        })
    });
},false);