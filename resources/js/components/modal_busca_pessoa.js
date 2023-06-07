import { addPessoaToTable } from './modal_pessoa'; 
import Swal from 'sweetalert2';

let modal_busca_pessoa = document.getElementById('modal-busca-pessoas');

if (modal_busca_pessoa != null){
    document.addEventListener('DOMContentLoaded', function () {
        $('#table-busca-pessoa > tbody').on('dblclick', '>tr', function (e) {
            var id            = e.currentTarget.cells[0].innerHTML;
            var nome          = e.currentTarget.cells[1].innerHTML;
            var CPF_RG        = e.currentTarget.cells[2].innerHTML;
            var id_envolvidos = document.getElementsByClassName('id-envolvido');

            if (id_envolvidos.length > 0){
                for (let i = 0 ; i < id_envolvidos.length; i++){
                    if (id_envolvidos[i].innerHTML.replace(/\s/g, '') == id){
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'Envolvido já adicionado!',
                            icon: 'warning',
                            confirmButtonText: 'Continuar',
                            confirmButtonColor: '#009640',
                            width: '350px',
                            iconColor: '#F4EB20'
                        })
                        return;
                    }
                }
            }
            
            addPessoaToTable(id, nome, CPF_RG);
    
            $('#modal-busca-pessoas').modal('hide');
       });
    }, false);
}

export function searchPessoa(){
    let url = $('#form-envolvidos').attr('action');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            nome: $('#input-buscar').val(),
        },
        success: function(result){
            $('#table-body-busca-pessoa').html('');
            
            $.each(result.pessoas, function(key, value){
                $('#table-body-busca-pessoa').append(
                    `<tr class="row-busca-pessoa">
                        <th scope="row" class="id-pessoa">` + value.id_pessoa  + `</th>
                        <td>` + value.nome + `</td>
                        <td>` + value.RG_CPF + `</td>
                    </tr>`
                );
            });

            $('#modal-busca-pessoas').modal('show');
        }
    });
}