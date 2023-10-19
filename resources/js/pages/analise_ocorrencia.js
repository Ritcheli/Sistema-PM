import cytoscape from "cytoscape";
import cytoscapePopper from "cytoscape-popper";

import { plotPessoasGraph } from "../SNAGraphs/pessoas_graph";
import { plotPessoasFatosGraph } from "../SNAGraphs/pessoas_fatos_graph";
import { plotPessoasGruposGraph } from "../SNAGraphs/pessoas_grupos_graph";

cytoscape.use(cytoscapePopper);

document.addEventListener('DOMContentLoaded', function() {

    VirtualSelect.init({ 
        ele: '#vs_rede_tipo',
        placeholder: 'Selecione o tipo da rede',
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        disableSelectAll: true,
        zIndex: 100,
        showValueAsTags: true,
        hasOptionDescription: true,
        options: [
          { label: 'Pessoas', value: 'Pessoas', description: 'Rede formada a partir da relação entre pessoas' },
          { label: 'Pessoas - Objetos', value: 'Pessoas_Objetos', description: 'Rede formada a partir da relação entre pessoas e objetos envolvidos em roubos/furtos' },
          { label: 'Pessoas - Fatos', value: 'Pessoas_Fatos', description: 'Rede formada a partir da relação entre pessoas e fatos de ocorrências' },
          { label: 'Pessoas - Grupos', value: 'Pessoas_Grupos', description: 'Rede formada a partir da relação entre pessoas e grupos de ocorrências' }
        ]
    });

    VirtualSelect.init({ 
        ele: '#vs_rede_participacao',
        placeholder: 'Selecione a participação do envolvido',
        noSearchResultsText: 'Nenhum resultado encontrado',
        searchPlaceholderText: 'Procurar...', 
        showValueAsTags: true,
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
        showValueAsTags: true
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
        if (this.value == 'Pessoas_Grupos'){
            var options = [
                { label: 'Geral', value: 'Geral' },
                { label: 'Armas de fogo', value: 'Arma_de_Fogo' },
                { label: 'Substancias', value: 'Substancias' }
            ]

            document.querySelector('#vs_grupo_ocorr').setOptions(options);

            document.querySelector('#vs_grupo_ocorr').setValue('Geral');
            document.querySelector('#vs_grupo_ocorr').removeAttribute('disabled');

            return;
        } 
        else {
            document.querySelector('#vs_grupo_ocorr').reset();
            document.querySelector('#vs_grupo_ocorr').setAttribute('disabled', 'true');
        }
    });

    $('#plot_SNA_Graph').on('submit', function(e){
        e.preventDefault(); 

        const url = $(this).attr('action');
        
        var tipo_rede               = $('#vs_rede_tipo').val();
        var participacao_envolvidos = $('#vs_rede_participacao').val();
        var grupo_ocorr             = $('#vs_grupo_ocorr').val();
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
        if ((tipo_rede == "Pessoas_Grupos" || tipo_rede == "Pessoas") && grupo_ocorr == ""){
            $('#vs_grupo_ocorr').addClass('is-invalid');
            $('#vs_grupo_ocorr-invalido').html('O campo grupo é obrigatório');
            error = true;
        }

        if (error == true) {
            return;
        }

        $('#legendas').attr('hidden', true);

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
            },
            success: function(result){
                if (result != ""){
                    if (tipo_rede == 'Pessoas'){
                        plotPessoasGraph(result);
                    }
                    if (tipo_rede == 'Pessoas_Fatos'){
                        plotPessoasFatosGraph(result);
                    }
                    if (tipo_rede == 'Pessoas_Grupos'){
                        plotPessoasGruposGraph(result);
                    }
                }
            }
        });
    });
}, false);