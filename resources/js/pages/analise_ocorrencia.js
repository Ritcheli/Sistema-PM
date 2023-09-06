import { plotSNAGraphPessFato } from "../SNAGraphs/pessoa_fato_graph";
import { plotSNAGraphPessOCorr } from "../SNAGraphs/pessoa_ocorr_graph";

document.addEventListener('DOMContentLoaded', function() {
    $('#plot_SNA_pessoa_ocorrencia').on('submit', function(e){
        e.preventDefault();

        const url = $(this).attr('action');  

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: '',
            success: function(data){
                $("#component").empty();

                plotSNAGraphPessOCorr(data);
            }
        });
    });

    $('#plot_SNA_fato_pessoa').on('submit', function(e){
        e.preventDefault();

        const url = $(this).attr('action');  

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            data: '',
            success: function(data){
                $("#component").empty();

                plotSNAGraphPessFato(data)
            }
        });
    });
}, false);