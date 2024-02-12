import cytoscape from "cytoscape";
import { highlight, unhighlight, click_class, show_classificacao } from "./sna_graphs_functions";
import Pagination from "s-pagination";

var cy;
var search_options = [];
var search_options_details = [];
var nodes_for_ordering = [];
var nodes_for_ordering_person = [];
var pagination;
var pag_items_count;
var pag_items_on_Page = 5;
var pag_last_page;

export function plotPessoaOutroGraph(data){
    const public_path = $('#cy').attr('value');

    var subtitles = data['subtitles'];
    nodes_for_ordering = [];
    nodes_for_ordering_person = [];
    pag_last_page = 0;

    cy = cytoscape({
        container: document.getElementById('cy'), // container to render in

        elements: data['graph'],
        
        style: [ // the stylesheet for the graph
            {
                selector: 'node',
                style: {
                    "font-size": "0px",
                    "text-valign": "center",
                    "text-halign": "center",
                    "text-outline-color": function(ele){
                        return ele.data('color');  
                    },
                    "text-outline-width": "0.8px",
                    "color": "#fff",
                    "overlay-padding": "6px",
                    "z-index": "10",
                    'background-color': function(ele){
                        return ele.data('color');  
                    },
                    'border-width': ' 2px',
                    'border-color': '#F7F7F7',
                    content: function(ele){ return ele.data('label'); },
                    width: function(ele){ 
                        if (ele.data('type') == 'pessoa'){
                            return ele.data('size')*10; 
                        } else {
                            if (data['values_to_normalize']['min_value'] == data['values_to_normalize']['max_value']){
                                return Math.max(0.5, Math.sqrt(1)) * 50; 
                            } else {
                                let normalized_size = (ele.data('size') - data['values_to_normalize']['min_value'])/(data['values_to_normalize']['max_value'] - data['values_to_normalize']['min_value']);

                                return Math.max(0.5, Math.sqrt(normalized_size)) * 50;
                            } 
                        }; 
                    },
                    height: function(ele){ 
                        if (ele.data('type') == 'pessoa'){
                            return ele.data('size')*10; 
                        } else {
                            if (data['values_to_normalize']['min_value'] == data['values_to_normalize']['max_value']){
                                return Math.max(0.5, Math.sqrt(1)) * 50; 
                            } else {
                                let normalized_size = (ele.data('size') - data['values_to_normalize']['min_value'])/(data['values_to_normalize']['max_value'] - data['values_to_normalize']['min_value']);

                                return Math.max(0.5, Math.sqrt(normalized_size)) * 50; 
                            }
                        }; 
                    }
                },
            },
            {
                selector: 'node.faded',
                style: {
                    opacity: 0.08,
                    events: 'no'
                },
            },
            {
                selector: 'edge',
                style: {
                    'width': function(ele){
                        return ele.data('weight');  
                    },
                    'line-color': '#ccc',
                    'curve-style': 'bezier'
                }
            },
            {
                selector: 'edge.faded',
                style: {
                    opacity: 0.06,
                    events: 'no'
                }
            },
            {
                selector: '.hidden',
                style: {
                    display: 'none',
                }
            }
        ],
        layout: {
            name: 'cose',
            padding: 50
        },
    });

    cy.promiseOn('layoutstop')
        .then(function() {
            cy.elements().nodes().forEach(n => {
                n.data('orgPos', {
                    x: n.position('x'),
                    y: n.position('y')
                });

                if (n.data('type') == 'pessoa'){
                    nodes_for_ordering_person.push({
                        node_id: n.data('id'), 
                        id_pessoa: n.data('id_pessoa'),
                        name: n.data('label'),
                        RG_CPF: n.data('RG_CPF'),
                        foto: n.data('foto'),
                        idade: n.data('idade'),
                    });

                    search_options_details.push(
                        {label: n.data('label'), value: n.data('id')}
                    );
                } else {
                    nodes_for_ordering.push({node_id: n.data('id'), value: n.data('size')});
                }
            });
        })
        .then(function() {
            nodes_for_ordering.sort((a, b) => (a.value > b.value ? -1 : 0));

            document.querySelector('#vs_search_SNA_details').reset();
            document.querySelector('#vs_search_SNA_details').setOptions(search_options_details);

            show_classificacao(nodes_for_ordering, cy);
        })
        .then(function(){
            pag_items_count = nodes_for_ordering_person.length;

            // $('#SNA_details_head').html(
            //     `<tr>
            //         <td scope="col" class="w-5"> Foto </td>
            //         <td scope="col" class="w-30"> Nome - RG/CPF </td>
            //         <td scope="col" class="w-10"> Idade </td>
            //         <td scope="col" class="w-5"> Frequência </td>
            //         <td scope="col" class="w-5"> Ação </td>
            //     </tr>`
            // );

            $('#SNA_details_head').html(
                `<tr>
                    <td scope="col" class="w-5"> Foto </td>
                    <td scope="col" class="w-30"> Nome - RG/CPF </td>
                    <td scope="col" class="w-10"> Idade </td>
                    <td scope="col" class="w-5"> Ação </td>
                </tr>`
            );

            pagination = new Pagination({
                container: document.getElementById("SNA_details_pagination"),
                maxVisibleElements: 10,
                callPageClickCallbackOnInit: true,
                pageClickCallback: function page_click(pageNumber) {
                    var html = "";
                    var total_items;
                    var route = $('#SNA_result_details').attr('value');

                    if (pag_items_on_Page * pageNumber > nodes_for_ordering_person.length) {
                        total_items = nodes_for_ordering_person.length;
                    } else {
                        total_items = pag_items_on_Page * pageNumber;
                    }
        
                    if (pag_last_page != pageNumber) {
                        for (let i = (pageNumber - 1) * pag_items_on_Page; i < total_items; i++){
                            let foto;

                            if (nodes_for_ordering_person[i]['foto'] != null){
                                foto = 'uploads/fotos_pessoas/' + nodes_for_ordering_person[i]['foto'].substring(nodes_for_ordering_person[i]['foto'].lastIndexOf('/') + 1);
                            } else {
                                foto = 'img/no_image.png';
                            }

                            html += `
                            <tr>
                                <td scope="row"> 
                                    <img class="SNA-result-table-img" src="` + foto + `" alt=""> 
                                </td>
                                <td scope="row">    
                                    <div class="SNA-result-table-row">
                                        ` + nodes_for_ordering_person[i]['name'] + ` - `+ nodes_for_ordering_person[i]['RG_CPF'] + `
                                    </div>
                                </td>
                                <td scope="row"> 
                                    <div class="SNA-result-table-row">
                                        ` + nodes_for_ordering_person[i]['idade'] + ` anos
                                    </div>
                                </td>
                                <td scope="row"> 
                                    <div class="SNA-result-table-row">
                                        <a type="button" value="" title="Visualizar" class="btn btn-table-view" target="_blank" href="` + route.replace('aux_id_pessoa', nodes_for_ordering_person[i]['id_pessoa']) +`"> 
                                            <i class='bx bx-show btn-table-icon-CM'></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            `
                        }
        
                        $('#SNA_details_body').html(html);
                    }
        
                    pag_last_page = pageNumber;
                }
            });
            pagination.make(pag_items_count, pag_items_on_Page);

            $('#num_registros').html(nodes_for_ordering_person.length + ' registro(s) encontrado(s)');

            $('#SNA_result_details').attr('hidden', false);
            $('#vs_search_SNA_details').attr('hidden', false);
        });

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

                    if (event.target.data('type') == 'outro'){
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

                    if (event.target.data('type') == 'localizacao'){
                        content.innerHTML = `<div class="container m-0">
                                                <div class="row"> 
                                                    <div class="col text-center">
                                                        <div class="nodo-fato"> 
                                                            ` + event.target.data('label') + ` - ` + event.target.data('cidade') + ` 
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
        }
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
            duration: 1000
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

    // Eventos referentes à busca dos detalhes do nodo
    $('#SNA_table_button_search').on('click', (e) => {
        e.preventDefault();

        $('#vs_search_SNA_details').trigger('change');
    })

    $('#vs_search_SNA_details').off('change');
    $('#vs_search_SNA_details').on('change', function() {
        var node_index = nodes_for_ordering_person.findIndex(({node_id}) => node_id === $('#vs_search_SNA_details').val());

        
        if (node_index != -1){
            for (let i = 1; i <= Math.ceil(pag_items_count/pag_items_on_Page); i++){
                if (i*pag_items_on_Page >= node_index + 1) {
                    pagination.goToPage(i);

                    break;
                }
            }
        }
    });
    $('#legendas').find('.info-nodo-content').html('');
    // --------------------------------------------------------------------------- //

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

    $(document).off('click', '#check_menu_nome_nodo');
    $(document).on('click', '#check_menu_nome_nodo', function (e) {
        Promise.resolve()
            .then( () => {
                if (Array.from(cy.elements('node').style('font-size'))[0] == '0') {
                    cy.elements('node').animate({
                        style: { 
                            'font-size': '4px',
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

    $('#check_menu_classificacao').off('click', click_class);
    $('#check_menu_classificacao').on('click', click_class);

    $('#legendas').removeAttr('hidden');
}