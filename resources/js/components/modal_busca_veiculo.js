import Pagination from "s-pagination";
import Swal from "sweetalert2";
import { addParticipacaoVeiculo } from "./modal_veiculo";

var items_per_page = 5;
var current_page   = 0;

document.addEventListener('DOMContentLoaded', function(){
    if ($('#modal-busca-veiculos').length > 0){
        $('#table-busca-veiculo > tbody').on('dblclick', '>tr', function (e) {
            var placa   = e.currentTarget.cells[0].innerHTML;
            var placas  = document.getElementsByClassName('placa');

            if (placas.length > 0){
                for (let i = 0 ; i < placas.length; i++){
                    if (placas[i].innerHTML.replace(/\s/g, '') == placa){
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'Placa já adicionada!',
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

            addParticipacaoVeiculo(placa);
    
            $('#modal-busca-veiculos').modal('hide');
        });
    }
},false);

export function searchVeiculo(){
    let url = $('#form-veiculos-ocorr').attr('action');

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            placa: $('#input-buscar-veiculos').val(),
            items_per_page: items_per_page,
            current_page: current_page
        },
        success: function(result){
            $('#table-body-busca-veiculo').html("");

            $.each(result.veiculos, function(key, value){
                $('#table-body-busca-veiculo').append(
                    `<tr class="row-busca-veiculo">
                        <th scope="row">` + value.placa  + `</th>
                        <td>` + value.marca + `</td>
                        <td>` + value.cor + `</td>
                        <td>` + value.renavam + `</td>
                    </tr>`
                );
            });

            $("#pagination-busca-veiculo").html("");

            var pagination = new Pagination({
                container: $("#pagination-busca-veiculo"),
                maxVisibleElements: 10,
                pageClickCallback: function (pageNumber) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            nome: $('#input-buscar-veiculos').val(),
                            items_per_page: items_per_page,
                            current_page: pageNumber - 1
                        },
                        success: function(result){
                            $('#table-body-busca-veiculo').html("");

                            $.each(result.veiculos, function(key, value){
                                $('#table-body-busca-veiculo').append(
                                    `<tr class="row-busca-veiculo">
                                        <th scope="row">` + value.placa  + `</th>
                                        <td>` + value.marca + `</td>
                                        <td>` + value.cor + `</td>
                                        <td>` + value.renavam + `</td>
                                    </tr>`
                                );
                            });
                        }
                    });
                }
            });

            pagination.make(result.total_rows, items_per_page);

            $(".pagination").removeClass('pagination-sm');
            $(".pagination").addClass('pagination');


            $('#modal-busca-veiculos').modal('show');
        }
    });
}