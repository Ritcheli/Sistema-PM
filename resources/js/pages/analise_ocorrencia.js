import cytoscape from "cytoscape";
import cytoscapePopper from "cytoscape-popper";

import { plotPessoasGraph } from "../SNAGraphs/pessoas_graph";
import { plotPessoaOutroGraph } from "../SNAGraphs/pessoas_outros_graph";

cytoscape.use(cytoscapePopper);

document.addEventListener('DOMContentLoaded', function() {
    VirtualSelect.init({ 
        ele: '#vs_rede_tipo',
        placeholder: 'Selecione o tipo da rede',
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        disableSelectAll: true,
        zIndex: 200,
        showValueAsTags: true,
        hasOptionDescription: true,
        options: [
            { label: 'Pessoas', value: 'Pessoas', description: 'Rede formada a partir da relação entre pessoas' },
            { label: 'Pessoas - Armas', value: 'Pessoas_Armas', description: 'Rede formada a partir da relação entre pessoas e armas' },
            { label: 'Pessoas - Drogas', value: 'Pessoas_Drogas', description: 'Rede formada a partir da relação entre pessoas e substâncias ilícitas apreendidas' },
            { label: 'Pessoas - Fatos', value: 'Pessoas_Fatos', description: 'Rede formada a partir da relação entre pessoas e fatos de ocorrências' },
            { label: 'Pessoas - Grupos', value: 'Pessoas_Grupos', description: 'Rede formada a partir da relação entre pessoas e grupos de ocorrências' },
            { label: 'Pessoas - Localização', value: 'Pessoas_Localizacao', description: 'Rede formada a partir da relação entre pessoas e a localização onde as ocorrências de furto e roubo aconteceram' },
            { label: 'Pessoas - Objetos', value: 'Pessoas_Objetos', description: 'Rede formada a partir da relação entre pessoas e objetos envolvidos em roubos/furtos' }
        ]
    });

    VirtualSelect.init({ 
        ele: '#vs_rede_participacao',
        placeholder: 'Selecione a participação do envolvido',
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        showValueAsTags: true,
        zIndex: 200,
        options: [
          { label: 'Apurar', value: 'Apurar' },
          { label: 'Autor', value: 'Autor' },
          { label: 'Comunicante', value: 'Comunicante' },
          { label: 'Suspeito', value: 'Suspeito' },
          { label: 'Testemunha', value: 'Testemunha' },
          { label: 'Vítima', value: 'Vítima' }
        ]
    });

    VirtualSelect.init({ 
        ele: '#vs_grupo_ocorr',
        placeholder: 'Selecione o grupo da ocorrência',
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        showValueAsTags: true,
        zIndex: 200,
    });

    VirtualSelect.init({ 
        ele: '#vs_search_in_graph',
        search: true,
        placeholder: 'Procurar',
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        showValueAsTags: true,
        zIndex: 200
    });

    VirtualSelect.init({ 
        ele: '#vs_search_SNA_details',
        search: true,
        placeholder: 'Procurar',
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        showValueAsTags: true,
        zIndex: 200
    });

    $('#vs_rede_tipo').on('change', function() {
        if (this.value == 'Pessoas'){
            var options = [
                { label: 'Furto/Roubo', value: 'Furto_Roubo' },
                { label: 'Substâncias', value: 'Substancias' }
            ]

            document.querySelector('#vs_grupo_ocorr').setOptions(options);
            document.querySelector('#vs_grupo_ocorr').removeAttribute('disabled');

            return;
        }
        else {
            document.querySelector('#vs_grupo_ocorr').reset();
            document.querySelector('#vs_grupo_ocorr').setAttribute('disabled', 'true');
        }
    });

    $(".check-dropdown-menu").on("click", function(){
        $(this).find(".dropdown-item-check").toggleClass("hidden");

        if ($(this).attr('id') == 'check_menu_legenda'){
            if ($(this).find(".dropdown-item-check").hasClass("hidden")){
                $("#legendas").attr("hidden", true);
            } else {
                $("#legendas").attr("hidden", false);
            }
        }
    });

    $('#SNA_ajuda_close_button').on('click', () => {
        $('#SNA_ajuda_container').attr('hidden', true);
    });

    $('#plot_SNA_Graph').on('submit', function(e){
        e.preventDefault(); 
        
        const url = $(this).attr('action');
        
        var tipo_rede               = $('#vs_rede_tipo').val();
        var participacao_envolvidos = $('#vs_rede_participacao').val();
        var grupo_ocorr             = $('#vs_grupo_ocorr').val();
        var data_inicial            = $("#data_inicial_analise").val();
        var data_final              = $("#data_final_analise").val();
        var error                   = false;

        $('#vs_rede_tipo').removeClass('is-invalid');
        $('#vs_rede_participacao').removeClass('is-invalid');
        $('#vs_grupo_ocorr').removeClass('is-invalid');

        // Validações
        if (tipo_rede == ""){
            $('#vs_rede_tipo').addClass('is-invalid');
            $('#vs_rede_tipo-invalida').html('O campo tipo da rede é obrigatório');
            error = true;
        }
        if (participacao_envolvidos == ""){
            $('#vs_rede_participacao').addClass('is-invalid');
            $('#vs_rede_participacao-invalida').html('O campo participação é obrigatório');
            error = true;
        }
        if (tipo_rede == "Pessoas" && grupo_ocorr == ""){
            $('#vs_grupo_ocorr').addClass('is-invalid');
            $('#vs_grupo_ocorr-invalido').html('O campo grupo é obrigatório');
            error = true;
        }

        if (error == true) {
            return;
        }

        // Configurações dos menus de configuração da rede gerada
        $("#navbar_SNA").removeClass("disabled");
        $(".dropdown-item-check-start-inactive").addClass("hidden");
        $(".dropdown-item-check-start-active").removeClass("hidden");
        $('#check_menu_legenda').removeClass('disabled');
        $('#classificacao').attr('hidden', true);
        $('#legendas').attr('hidden', true);
        $('#fit_zoom').attr('hidden', false);
        $('#nav_item_metrica').attr('hidden', true);
        $('#SNA_result_details').attr('hidden', true);

        $('#cy').html("");

        $('#cy').html('<div class="spinner-border text-success loading-spinner" role="status" id="loading-spinner-SNA"> </div>');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                tipo_rede : tipo_rede,
                participacao : participacao_envolvidos,
                grupo_ocorr : grupo_ocorr,
                data_inicial : data_inicial,
                data_final : data_final
            },
            success: function(result){
                if (result != ""){
                    if (tipo_rede == 'Pessoas'){
                        plotPessoasGraph(result);

                        $('#check_menu_legenda').addClass('disabled');
                        $('#check_menu_legenda').find('.dropdown-item-check').addClass('hidden');
                        $('#DCN_radio').prop('checked', true);
                        $('#nav_item_metrica').attr('hidden', false);
                    }
                    else{
                        plotPessoaOutroGraph(result)
                    }
                    $('#loading-spinner-SNA').attr('hidden', true);
                }
            }
        });
    });
}, false);