import cytoscape from "cytoscape";
import { highlight, style_SNA_bi, unhighlight } from "./sna_graphs_functions";

var search_options = [];

export function plotPessoasGruposGraph(data){
    const public_path = $('#cy').attr('value');

    var subtitles = data['subtitles'];

    var cy = cytoscape({
        container: document.getElementById('cy'), // container to render in

        elements: data['graph'],
        
        style: style_SNA_bi(data),
    });

    // Aplicação do layout cose e atualização da posição original dos nodos no grafo atual //
    const layout = cy.layout({
        name: 'cose',
        padding: 50
    });

    layout.run();

    layout.promiseOn('layoutstop').then(function() {
        cy.elements().nodes().forEach(n => {
            n.data('orgPos', {
                x: n.position('x'),
                y: n.position('y')
            });
        });
    });
    // ----------------------------------------------------------------------------------- //

    cy.elements().unbind("mouseover");
    cy.elements().bind("mouseover", (event) => {
        if (event.target.group() == 'nodes'){
            event.target.popperRefObj = event.target.popper({
                content: () => {
                    let content = document.createElement("div");
                    let foto;

                    content.classList.add("popper-div");
                    
                    if (event.target.data('type') == 'pessoa'){
                        if (event.target.data('foto') != null){
                            foto = 'uploads/fotos_pessoas/' + event.target.data('foto').substring(event.target.data('foto').lastIndexOf('/') + 1);
                        } else {
                            foto = 'img/no_image.png'; 
                        }
            
                        content.innerHTML = `<div class="container">
                                                <div class="row">
                                                    <div class="col m-0 pl-0" style="max-width:135px">
                                                        <img src="` + public_path + foto +  `" alt="" class="nodo-pessoa-img">
                                                    </div>
                                                    <div class="col">
                                                        <div class="row"> 
                                                            <div class="nodo-pessoa-info"> 
                                                                <strong>
                                                                    Nome
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <div class="row pb-2"> 
                                                            <div class="nodo-pessoa-info"> 
                                                                ` + event.target.data('label') +  ` 
                                                            </div>
                                                        </div>
                                                        <div class="row"> 
                                                            <div class="nodo-pessoa-info"> 
                                                                <strong>
                                                                    RG/CPF
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <div class="row"> 
                                                            <div class="nodo-pessoa-info"> 
                                                                ` + event.target.data('RG_CPF') + ` 
                                                            </div>
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>`;
                    }

                    if (event.target.data('type') == 'grupo'){
                        content.innerHTML = `<div class="container m-0">
                                                <div class="row"> 
                                                    <div class="col text-center">
                                                        <div class="nodo-fato"> 
                                                            ` + event.target.data('label') +  ` 
                                                        </div>
                                                    </div>
                                                </div>   
                                            </div>`;
                    }

                    document.body.appendChild(content);

                    return content;
                },
            });

            $('html,body').css('cursor', 'pointer');
        };
        if (event.target.group() == 'edges'){
            event.target.popperRefObj = event.target.popper({
                content: () => {
                    let content = document.createElement("div");

                    content.classList.add("popper-div");

                    content.innerHTML = `<div class="container m-0">
                                                <div class="row"> 
                                                    <div class="col text-center mb-1">
                                                        <div class="nodo-fato"> 
                                                            <strong>` 
                                                                + event.target.data('source').replace(/\d+/g, '') +  ` - `  
                                                                + event.target.data('target').replace(/\d+/g, '') + 
                                                            `</strong>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="row"> 
                                                    <div class="col text-center">
                                                        <div class="nodo-fato"> 
                                                            <strong>` + event.target.data('weight') + `</strong> ocorrência(s) registrada(s)
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>`;
                    
                    document.body.appendChild(content);

                    return content;
                },
            });
        }
    });

    cy.elements().unbind("mouseout");
    cy.elements().bind("mouseout", (event) => {
        if (event.target.popper) {
            event.target.popperRefObj.state.elements.popper.remove();
            event.target.popperRefObj.destroy();
        }

        $('html,body').css('cursor', 'default');
    });

    $('#fit_zoom').off('click');
    $('#fit_zoom').on('click', () => {
        cy.animate({
            fit: {
                eles: cy,
                padding: 50
            }
            
        },{
            duration: 750
        });

        unhighlight(cy);
    })

    cy.on('tap', e => {
        var node = e.target;

        if (e.target === cy ){
            unhighlight(cy);
        } else {
            if (e.target.group() === 'nodes') {
                highlight(node, cy);
            }
        }
    });

    // Alimentação dos dados referentes a busca dos nodos e trigger do evento tap //
    search_options = [];

    $('#menu_search_in_graph').off('submit');
    $('#menu_search_in_graph').on("submit", e => {
        e.preventDefault();

        cy.$id($('#vs_search_in_graph').val()).emit('tap');
    })

    $('#vs_search_in_graph').off('change');
    $('#vs_search_in_graph').on('change', function() {
        cy.$id($('#vs_search_in_graph').val()).emit('tap');
    });

    cy.elements('node').forEach( e => {
        search_options.push(
            {label: e.data('label'), value: e.data('id')}
        );
    });

    document.querySelector('#vs_search_in_graph').reset();
    document.querySelector('#vs_search_in_graph').setOptions(search_options);
    // --------------------------------------------------------------------------- //

    $('#legendas').find(".info-nodo-content").html("");

    subtitles.forEach(subtitle => {
        $('#legendas').find('.info-nodo-content').append(`<div class="row row-subtitle">
                                                            <div class="col-0 pl-0">
                                                                <div class="legenda-color" style="background:` + subtitle.color +`"></div>
                                                            </div>
                                                            <div class="col">
                                                                ` + subtitle.type +`
                                                            </div> 
                                                         </div>`);
    });

    $(document).on('click', '#check_menu_nome_nodo', function (e) {
        Promise.resolve()
            .then( () => {
                if (Array.from(cy.elements('node').style('font-size'))[0] == '0') {
                    cy.elements('node').animate({
                        style: { 
                            'font-size': '6px',
                        }
                        
                    }, {
                        duration: 500
                    });
                } else {
                    cy.elements('node').animate({
                        style: { 
                            'font-size': '0',
                        }
                    }, {
                        duration: 500
                    });
                } 
            });      
    });

    $('#legendas').removeAttr('hidden');
}