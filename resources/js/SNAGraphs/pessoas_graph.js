import cytoscape from "cytoscape";
import { highlight, unhighlight } from "./sna_graphs_functions";

var color_palette   = ['#f7bcc5', '#ffb8bf', '#e38484', '#de6464', '#db5151', '#db4444', '#d62d2d', '#d41e1e', '#d10d0d', '#a30303']
var search_options  = [];
var selected_metric = "#DCN_radio";

function between(x, min, max) {
    return (x >= min && x <= max);
}

function setColorNode(dcn){
    if (between(dcn, 0, 0.1)){
        return color_palette[0];
    }
    if (between(dcn, 0.1, 0.2)){
        return color_palette[1];
    }
    if (between(dcn, 0.2, 0.3)){
        return color_palette[2];
    }
    if (between(dcn, 0.3, 0.4)){
        return color_palette[3];
    }
    if (between(dcn, 0.4, 0.5)){
        return color_palette[4];
    }
    if (between(dcn, 0.5, 0.6)){
        return color_palette[5];
    }
    if (between(dcn, 0.6, 0.7)){
        return color_palette[6];
    }
    if (between(dcn, 0.7, 0.8)){
        return color_palette[7];
    }
    if (between(dcn, 0.8, 0.9)){
        return color_palette[8];
    }
    if (between(dcn, 0.9, 1)){
        return color_palette[9];
    }
}

export function plotPessoasGraph(data){
    const public_path = $('#cy').attr('value');

    var cy = cytoscape({
        container: document.getElementById('cy'), // container to render in

        elements: data['graph'],

        style: [ // the stylesheet for the graph
            {
                selector: 'node',
                style: {
                    'background-color': function(ele){
                        return setColorNode(calcDCNNode(ele));  
                    },
                    'border-width': ' 2px',
                    'border-color': '#F7F7F7',
                    "font-size": "0",
                    "text-valign": "center",
                    "text-halign": "center",
                    "text-outline-color": function(ele){
                        return setColorNode(calcDCNNode(ele));  
                    },
                    "text-outline-width": "0.8px",
                    "color": "#fff",
                    "overlay-padding": "6px",
                    "z-index": "10",
                    content: function(ele){ return ele.data('label'); },
                    width: function(ele){ return Math.max(0.5, Math.sqrt(calcDCNNode(ele))) * 20; },
                    height: function(ele){ return Math.max(0.5, Math.sqrt(calcDCNNode(ele))) * 20; }
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
                    'width': function (ele) {
                        let normalized_weight = (ele.data('weight') - data['values_to_normalize']['min_value'])/(data['values_to_normalize']['max_value'] - data['values_to_normalize']['min_value']);

                        return Math.max(0.3, Math.sqrt(normalized_weight)) * 4; 
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
                                                                + cy.nodes('#' + event.target.data('target')).data('label') +  ` - `  
                                                                + cy.nodes('#' + event.target.data('source')).data('label') + 
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

    // Alimentação dos dados referentes a busca dos nodos e trigger do evento tap
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

    document.querySelector('#vs_search_in_graph').setOptions(search_options);
    // --------------------------------------------------------------------------- //


    $('#cy').append(`<div class="container-legend-color-palette" id="container_color_palette"> 
                        <div class="legend-color-palette-details">  
                            <div class="color-palette-text"> - </div> 
                            <div class='color-palette' style="background: ` + color_palette [0] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [1] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [2] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [3] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [4] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [5] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [6] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [7] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [8] + `"> </div>
                            <div class='color-palette' style="background: ` + color_palette [9] + `"> </div>
                            <div class="color-palette-text"> + </div> 
                        </div>
                    </div> `)

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

    $('#check_detect_community').on('click', (e) => {
        if ($('#check_detect_community').find(".dropdown-item-check").hasClass("hidden")) {
            $('#container_color_palette').attr('hidden', false);

            $(selected_metric).trigger('click');
        } else { 
            $('#container_color_palette').attr('hidden', true);

            // Assign random colors to each cluster!
            Promise.resolve()
                .then( () => {
                    var clusters = cy.elements().markovClustering({
                        attributes: [
                            function( edge ){ 
                                let normalized_weight = (edge.data('weight') - data['values_to_normalize']['min_value'])/(data['values_to_normalize']['max_value'] - data['values_to_normalize']['min_value']);
        
                                return normalized_weight; 
                            }
                        ]
                    });

                    for (var c = 0; c < clusters.length; c++) {
                        let color = '#' + Math.floor(Math.random()*16777215).toString(16);

                        clusters[c].animate({
                            style: { 
                                backgroundColor: color,
                                'text-outline-color': color
                            }
                          }, {
                            duration: 500
                        });
                    }
                }       
            );
        }
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

    $('#DCN_radio').on('click', function(){
        let nodes = cy.nodes();

        $('#check_detect_community').find(".dropdown-item-check").addClass('hidden');
        selected_metric = "#DCN_radio";
        
        Promise.resolve()
            .then(
                Promise.all( nodes.map(n => {
                    return n.animation({
                        style: {'width' : Math.max(0.5, Math.sqrt(calcDCNNode(n))) * 20, 
                                'height': Math.max(0.5, Math.sqrt(calcDCNNode(n))) * 20,
                                'text-outline-color' : setColorNode(calcDCNNode(n)),
                                'background-color'   : setColorNode(calcDCNNode(n))
                            }
                    }).play().promise();
                }))
            );
    });

    $('#BCN_radio').on('click', function(){
        let nodes = cy.nodes();

        $('#check_detect_community').find(".dropdown-item-check").addClass('hidden');
        selected_metric = "#BCN_radio";

        Promise.resolve()
            .then(
                Promise.all( nodes.map(n => {
                    return n.animation({
                        style: {'width' : Math.max(0.5, Math.sqrt(calcBCNNode(n))) * 20, 
                                'height': Math.max(0.5, Math.sqrt(calcBCNNode(n))) * 20,
                                'text-outline-color' : setColorNode(calcBCNNode(n)),
                                'background-color'   : setColorNode(calcBCNNode(n))
                            }
                    }).play().promise();
                }))
            );
    });

    $('#CCN_radio').on('click', function(){
        let nodes = cy.nodes();

        $('#check_detect_community').find(".dropdown-item-check").addClass('hidden');   
        selected_metric = "#CCN_radio";

        Promise.resolve()
            .then(
                Promise.all( nodes.map(n => {
                    return n.animation({
                        style: {'width' : Math.max(0.5, Math.sqrt(calcCCNNode(n))) * 20, 
                                'height': Math.max(0.5, Math.sqrt(calcCCNNode(n))) * 20,
                                'text-outline-color' : setColorNode(calcCCNNode(n)),
                                'background-color'   : setColorNode(calcCCNNode(n))
                            }
                    }).play().promise();
                }))
            );
    });
}

function calcDCNNode(node){
    return node.cy().$().dcn().degree('#' + node.data('id'));
}

function calcCCNNode(node){
    return node.cy().$().ccn().closeness('#' + node.data('id'));
}

function calcBCNNode(node){
    return node.cy().$().bc().betweennessNormalized('#' +  node.data('id'));
}