import cytoscape from "cytoscape";

var color_palette = ['#f7bcc5', '#ffb8bf', '#e38484', '#de6464', '#db5151', '#db4444', '#d62d2d', '#d41e1e', '#d10d0d', '#a30303']

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

        elements: data,
        
        style: [ // the stylesheet for the graph
            {
                selector: 'node',
                style: {
                    'background-color': function(ele){
                        return setColorNode(calcDCNNode(ele));  
                    },
                    'border-width': ' 2px',
                    'border-color': '#F7F7F7',
                    "font-size": "0px",
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
            selector: 'edge',
            style: {
                'width': 1,
                'line-color': '#ccc',
                'curve-style': 'bezier'
            }
            }
        ],
        
        layout: {
            name: 'cose'
        },
    });

    cy.center();

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
        }
    });

    cy.elements().unbind("mouseout");
    cy.elements().bind("mouseout", (event) => {
        if (event.target.group() == 'nodes'){
        if (event.target.popper) {
            event.target.popperRefObj.state.elements.popper.remove();
            event.target.popperRefObj.destroy();
        }
        }
    });

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

    $(document).on('change', '#legend_switch', function (e) {
        if (cy.elements('node').style('font-size') == '4px') {
            cy.elements('node').style('font-size', '0');
        } else {
            cy.elements('node').style('font-size', '4px')
        }     
    });

    $('#DCN_radio').on('click', function(){
        let nodes = cy.nodes();
        
        nodes.forEach(function (ele){
            ele.style('text-outline-color', setColorNode(calcDCNNode(ele)));
            ele.style('background-color', setColorNode(calcDCNNode(ele)));
            ele.style('width', Math.max(0.5, Math.sqrt(calcDCNNode(ele))) * 20);
            ele.style('height', Math.max(0.5, Math.sqrt(calcDCNNode(ele))) * 20);
        });
    });

    $('#BCN_radio').on('click', function(){
        let nodes = cy.nodes();

        nodes.forEach(function (ele){
            ele.style('text-outline-color', setColorNode(calcBCNNode(ele)));
            ele.style('background-color', setColorNode(calcBCNNode(ele)));
            ele.style('width', Math.max(0.5, Math.sqrt(calcBCNNode(ele))) * 20);
            ele.style('height', Math.max(0.5, Math.sqrt(calcBCNNode(ele))) * 20);
        });
    });

    $('#CCN_radio').on('click', function(){
        let nodes = cy.nodes();

        nodes.forEach(function (ele){
            ele.style('text-outline-color', setColorNode(calcCCNNode(ele)));
            ele.style('background-color', setColorNode(calcCCNNode(ele)));
            ele.style('width', Math.max(0.5, Math.sqrt(calcCCNNode(ele))) * 20);
            ele.style('height', Math.max(0.5, Math.sqrt(calcCCNNode(ele))) * 20);
        });
    });

    $(document).on('click', '#toggle-labels', function (e){
        e.preventDefault();

        nodes.forEach(function (ele){
            ele.style('width', Math.max(0.5, Math.sqrt(calcDCNNode(ele))) * 50);
            ele.style('height', Math.max(0.5, Math.sqrt(calcDCNNode(ele))) * 50);
        });
    });

    $('#config').attr('hidden', false);
    $('#config-metricas').attr('hidden', false);
}

function calcDCNNode(node){
    return node.cy().$().dcn().degree('#' + node.data('id'));
}

function calcCCNNode(node){
    return node.cy().$().ccn().closeness('#' + node.data('id'));
}

function calcBCNNode(node){
    return node.cy().$().bc().betweennessNormalized('#' + + node.data('id'));
}