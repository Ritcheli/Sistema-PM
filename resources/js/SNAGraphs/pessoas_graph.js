import cytoscape from "cytoscape";
import { click_class, highlight, unhighlight, show_classificacao } from "./sna_graphs_functions";
import Pagination from "s-pagination";

var color_palette      = ['#f7bcc5', '#ffb8bf', '#e38484', '#de6464', '#db5151', '#db4444', '#d62d2d', '#d41e1e', '#d10d0d', '#a30303']
var search_options     = [];
var selected_metric    = "#DCN_radio";
var nodes_for_ordering = [];
var node_metric;
var cy;
var values_to_normalize;
var pagination;
var pag_items_count;
var pag_items_on_Page = 5;
var pag_last_page;

const hexCharacters = [0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F"]

function between(x, min, max) {
    return (x >= min && x <= max);
}

function setColorNode(dcn){
    for (var i= 0; i < 10; i++){
        if (between(dcn, i/10, (i+1)/10)){
            return color_palette[i];
        }
    }
}

export function plotPessoasGraph(data){
    const public_path = $('#cy').attr('value');

    values_to_normalize = data['values_to_normalize'];
    nodes_for_ordering = [];
    pag_items_count   = data['num_registros'];
    pag_last_page = 0;

    cy = cytoscape({
        container: document.getElementById('cy'), // container to render in

        elements: data['graph'],

        style: [ // the stylesheet for the graph
            {
                selector: 'node',
                style: {
                    'background-color': function(ele){
                        node_metric = ele.cy().$().dcn().degree('#' + ele.data('id'));

                        return setColorNode(node_metric);  
                    },
                    'border-width': ' 2px',
                    'border-color': '#F7F7F7',
                    "font-size": "0",
                    "text-valign": "center",
                    "text-halign": "center",
                    "text-outline-color": function(ele){
                        return setColorNode(node_metric);  
                    },
                    "text-outline-width": "0.8px",
                    "color": "#fff",
                    "overlay-padding": "6px",
                    "z-index": "10",
                    content: function(ele){ return ele.data('label'); },
                    width: function(ele){ return Math.max(0.5, Math.sqrt(node_metric)) * 20; },
                    height: function(ele){ return Math.max(0.5, Math.sqrt(node_metric)) * 20; }
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
                        if (data['values_to_normalize']['min_value'] == data['values_to_normalize']['max_value']){
                            return Math.max(0.3, Math.sqrt(1)) * 4; 
                        } else {
                            let normalized_weight = (ele.data('weight') - data['values_to_normalize']['min_value'])/(data['values_to_normalize']['max_value'] - data['values_to_normalize']['min_value']);

                            return Math.max(0.3, Math.sqrt(normalized_weight)) * 4; 
                        }
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

                calcDCNNode(n);
            });

            nodes_for_ordering
                    .sort((a, b) => (a.num_ocorr > b.num_ocorr ? -1 : 0))
                    .sort((a, b) => (a.value > b.value ? -1 : 0))
            
            show_classificacao(nodes_for_ordering, cy);
        })
        .then(function() {
                $('#SNA_details_head').html(
                    `<tr>
                        <td scope="col" class="w-5"> Foto </td>
                        <td scope="col" class="w-30"> Nome - RG/CPF </td>
                        <td scope="col" class="w-10"> Idade </td>
                        <td scope="col" class="w-5"> Frequência </td>
                        <td scope="col" class="w-5"> Métrica </td>
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

                        if (pag_items_on_Page * pageNumber > nodes_for_ordering.length) {
                            total_items = nodes_for_ordering.length;
                        } else {
                            total_items = pag_items_on_Page * pageNumber;
                        }
            
                        if (pag_last_page != pageNumber) {
                            for (let i = (pageNumber - 1) * pag_items_on_Page; i < total_items; i++){
                                let foto;

                                if (nodes_for_ordering[i]['foto'] != null){
                                    foto = 'uploads/fotos_pessoas/' + nodes_for_ordering[i]['foto'].substring(nodes_for_ordering[i]['foto'].lastIndexOf('/') + 1);
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
                                            ` + nodes_for_ordering[i]['name'] + ` - `+ nodes_for_ordering[i]['RG_CPF'] + `
                                        </div>
                                    </td>
                                    <td scope="row"> 
                                        <div class="SNA-result-table-row">
                                            ` + nodes_for_ordering[i]['idade'] + ` anos
                                        </div>
                                    </td>
                                    <td scope="row"> 
                                        <div class="SNA-result-table-row">
                                            ` + nodes_for_ordering[i]['num_ocorr'] + ` ocorrência(s)
                                        </div>
                                    </td>
                                    <td scope="row"> 
                                        <div class="SNA-result-table-row">
                                            ` + nodes_for_ordering[i]['value'] + `
                                        </div>
                                    </td>
                                    <td scope="row"> 
                                        <div class="SNA-result-table-row">
                                            <a type="button" value="" title="Visualizar" class="btn btn-table-view" target="_blank" href="` + route.replace('aux_id_pessoa', nodes_for_ordering[i]['node_id']) +`"> 
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
        })
        .then(() => {
                $('#num_registros').html(nodes_for_ordering.length + ' registro(s) encontrado(s)');

                $('#SNA_result_details').attr('hidden', false);
                $('#vs_search_SNA_details').attr('hidden', false);
            }      
        );

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

    $('#SNA_table_button_search').on('click', (e) => {
        e.preventDefault();

        $('#vs_search_SNA_details').trigger('change');
    })

    $('#vs_search_SNA_details').off('change');
    $('#vs_search_SNA_details').on('change', function() {
        var node_index = nodes_for_ordering.findIndex(({node_id}) => node_id === $('#vs_search_SNA_details').val());

        
        if (node_index != -1){
            for (let i = 1; i <= Math.ceil(pag_items_count/pag_items_on_Page); i++){
                if (i*pag_items_on_Page >= node_index + 1) {
                    pagination.goToPage(i);

                    break;
                }
            }
        }
    });

    cy.elements('node').forEach( e => {
        search_options.push(
            {label: e.data('label'), value: e.data('id')}
        );
    });

    document.querySelector('#vs_search_in_graph').setOptions(search_options);
    document.querySelector('#vs_search_SNA_details').setOptions(search_options);
    // --------------------------------------------------------------------------- //

    $('#cy').append(`<div class="container-legend-color-palette" id="container_color_palette"> 
                        <div class="legend-color-palette-details" id="legend_color_palette"> 
                        </div>
                    </div>`)

    html_color_pallete();
    
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
    
    $('#check_detect_community').off('click', click_commun);
    $('#check_detect_community').on('click', click_commun);

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

    $('#DCN_radio').off('click', click_DCN);
    $('#DCN_radio').on('click', click_DCN);

    $('#BCN_radio').off('click', click_BCN);
    $('#BCN_radio').on('click', click_BCN);

    $('#CCN_radio').off('click', click_CCN);
    $('#CCN_radio').on('click', click_CCN);

    $('#SNA_ajuda_nav_item').on('click', () => {
        const json_ajuda_path = public_path + 'json/SNA_Ajuda.json';

        const init = async () => {
            try{
                const response = await fetch(json_ajuda_path);

                return response.json();
            } catch(error) {
                console.log(error);
            }
        }

        init().then((data) => {
            let data_desc = data[selected_metric]['Descricao'];
    
            data_desc = data_desc.replace('Nome_Nodo', cy.getElementById(nodes_for_ordering[0]['node_id']).data('label'));
            data_desc = data_desc.replace('Id_Nodo', nodes_for_ordering[0]['node_id']);

            $('#SNA_ajuda_container').attr('hidden', false);

            $('#SNA_ajuda_container').find('.SNA-ajuda-text').html(data_desc);
        });
    });

    $('.SNA-ajuda-text-node').off('click');
    $(document).on('click', '.SNA-ajuda-text-node', function() {
        highlight(cy.getElementById($(this).attr('value')), cy);
    })
}

function calcDCNNode(node){
    let node_degree = node.cy().$().dcn().degree('#' + node.data('id'));  

    nodes_for_ordering.push({
        node_id: node.data('id'), 
        name: node.data('label'),
        RG_CPF: node.data('RG_CPF'),
        foto: node.data('foto'),
        idade: node.data('idade'),
        num_ocorr: node.data('num_ocorr'),
        value: node_degree,
    });

    return node_degree;
}

function calcCCNNode(node){
    let node_degree = node.cy().$().ccn().closeness('#' + node.data('id'));

    nodes_for_ordering.push({
        node_id: node.data('id'), 
        name: node.data('label'),
        RG_CPF: node.data('RG_CPF'),
        foto: node.data('foto'),
        idade: node.data('idade'),
        num_ocorr: node.data('num_ocorr'),
        value: node_degree,
    });

    return node_degree;
}

function calcBCNNode(node){
    let node_degree = node.cy().$().bc().betweennessNormalized('#' +  node.data('id'));

    nodes_for_ordering.push({
        node_id: node.data('id'), 
        name: node.data('label'),
        RG_CPF: node.data('RG_CPF'),
        foto: node.data('foto'),
        idade: node.data('idade'),
        num_ocorr: node.data('num_ocorr'),
        value: node_degree,
    });

    return node_degree;
}

function getCharacter(index) {
	return hexCharacters[index]
}

function generateNewColor() {
	let hexColorRep = "#"

	for (let index = 0; index < 6; index++){
		const randomPosition = Math.floor ( Math.random() * hexCharacters.length ) 
    	hexColorRep += getCharacter( randomPosition )
	}
	
	return hexColorRep
}

var click_DCN = function click_DCN_radio(){
    let nodes = cy.nodes();

    $('#check_detect_community').find(".dropdown-item-check").addClass('hidden');
    $('#container_color_palette').attr('hidden', false);
    selected_metric    = "#DCN_radio";
    nodes_for_ordering = [];

    html_color_pallete();

    Promise.resolve()
        .then(
            Promise.all( nodes.map(n => {
                node_metric = calcDCNNode(n);

                return n.animation({
                    style: {'width' : Math.max(0.5, Math.sqrt(node_metric)) * 20, 
                            'height': Math.max(0.5, Math.sqrt(node_metric)) * 20,
                            'text-outline-color' : setColorNode(node_metric),
                            'background-color'   : setColorNode(node_metric)
                        }
                }).play().promise();
            }))
        )
        .then(() => {
            const myPromise = new Promise((resolve, reject) => {
                resolve(nodes_for_ordering
                    .sort((a, b) => (a.num_ocorr > b.num_ocorr ? -1 : 0))
                    .sort((a, b) => (a.value > b.value ? -1 : 0)));
            });
            
            myPromise.then(() => {
                show_classificacao(nodes_for_ordering, cy);

                pag_last_page = 0;
                pagination.goToPage(1);
            });
        });
}

var click_BCN = function click_BCN_radio(){
    let nodes = cy.nodes();

    $('#check_detect_community').find(".dropdown-item-check").addClass('hidden');
    $('#container_color_palette').attr('hidden', false);
    selected_metric    = "#BCN_radio";
    nodes_for_ordering = [];

    html_color_pallete();

    Promise.resolve()
        .then(
            Promise.all( nodes.map(n => {
                node_metric = calcBCNNode(n);

                return n.animation({
                    style: {'width' : Math.max(0.5, Math.sqrt(node_metric)) * 20, 
                            'height': Math.max(0.5, Math.sqrt(node_metric)) * 20,
                            'text-outline-color' : setColorNode(node_metric),
                            'background-color'   : setColorNode(node_metric)
                        }
                }).play().promise();
            }))
        )
        .then(() => {
            const myPromise = new Promise((resolve, reject) => {
                resolve(nodes_for_ordering
                    .sort((a, b) => (a.num_ocorr > b.num_ocorr ? -1 : 0))
                    .sort((a, b) => (a.value > b.value ? -1 : 0)));
            });
            
            myPromise.then(() => {
                show_classificacao(nodes_for_ordering, cy);

                pag_last_page = 0;
                pagination.goToPage(1);
            });
        });
}

var click_CCN = function click_CCN_radio(){
    let nodes = cy.nodes();

    $('#check_detect_community').find(".dropdown-item-check").addClass('hidden');   
    $('#container_color_palette').attr('hidden', false);
    selected_metric    = "#CCN_radio";
    nodes_for_ordering = [];

    html_color_pallete();

    Promise.resolve()
        .then(
            Promise.all( nodes.map(n => {
                node_metric = calcCCNNode(n);

                return n.animation({
                    style: {'width' : Math.max(0.5, Math.sqrt(node_metric)) * 20, 
                            'height': Math.max(0.5, Math.sqrt(node_metric)) * 20,
                            'text-outline-color' : setColorNode(node_metric),
                            'background-color'   : setColorNode(node_metric)
                        }
                }).play().promise();
            }))
        )
        .then(() => {
            const myPromise = new Promise((resolve, reject) => {
                resolve(nodes_for_ordering
                            .sort((a, b) => (a.num_ocorr > b.num_ocorr ? -1 : 0))
                            .sort((a, b) => (a.value > b.value ? -1 : 0)));
            });
            
            myPromise.then(() => {
                show_classificacao(nodes_for_ordering, cy);

                pag_last_page = 0;
                pagination.goToPage(1);
            });
        });
}

var click_commun = function click_detect_community(){
    let html_cluster = "";
    let active = 'active';

    if ($('#check_detect_community').find(".dropdown-item-check").hasClass("hidden")) {
        html_color_pallete();

        $(selected_metric).trigger('click');
    } else { 
        Promise.resolve()
            .then( () => {
                var clusters = cy.elements().markovClustering({
                    attributes: [
                        function( edge ){ 
                            if (values_to_normalize['min_value'] == values_to_normalize['max_value']){
                                return 1; 
                            } else {
                                let normalized_weight = (edge.data('weight') - values_to_normalize['min_value'])/(values_to_normalize['max_value'] - values_to_normalize['min_value']);
    
                                return normalized_weight; 
                            }
                        }
                    ]
                });

                $('#legend_color_palette').html("");
                $('#legend_color_palette')
                    .html(`<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
                                <div class="carousel-inner" id="carousel_cluster_colors" style="width: 550px">
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon analise" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon analise" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                           </div>`);

                for (var c = 0; c < clusters.length; c++) {
                    let color = generateNewColor();

                    html_cluster += `
                        <div class="m-1 carousel-item-cluster">
                            <div class='color-cluster' style="background: `+ color +`"></div>
                            <div class="ml-1"> Conjunto ` + (c + 1) + ` </div>
                        </div>`

                    if (((c + 1) % 3) === 0){
                        $('#carousel_cluster_colors').append(`
                            <div class="carousel-item `+ active +`">
                                <div class="carousel-item-cluster">
                                    ` + html_cluster + `
                                </div>
                            </div>
                        `)

                        html_cluster = "";
                        active = "";
                    }

                    clusters[c].animate({
                        style: { 
                            backgroundColor: color,
                            'text-outline-color': color
                        }
                      }, {
                        duration: 500
                    });
                }

                if (html_cluster != ""){
                    $('#carousel_cluster_colors').append(`
                        <div class="carousel-item ` + active + `">
                            <div class="carousel-item-cluster">
                                ` + html_cluster + `
                            </div>
                        </div>
                `) 
                }
            }       
        );
    }
}

function html_color_pallete(){
    $('#legend_color_palette').html("");
    $('#legend_color_palette').append(`<div class='color-palette-text'>-</div>`)
    color_palette.map(n => $('#legend_color_palette').append(`<div class='color-palette' style="background: ` + n + `"> </div>`));
    $('#legend_color_palette').append(`<div class='color-palette-text'>+</div>`)
}