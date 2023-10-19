import cytoscape from "cytoscape";

var color_palette = ['#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#FF5252', '#F44336', '#D32F2F', '#c21e1e', '#891616', '#5d0f0f']

// cytoscape.use(cytoscapePopper);

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
                        return setColorNode(ele.cy().$().dcn().degree('#' + ele.data('id')));  
                    },
                    'border-width': ' 2px',
                    'border-color': '#F7F7F7',
                    width: function(ele){ return Math.max(0.5, Math.sqrt(ele.degree())) * 10; },
                    height: function(ele){ return Math.max(0.5, Math.sqrt(ele.degree())) * 10; }
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
    
    // console.log( 'degree of 197: ' + cy.$().dc({ root: '#197' }).degree );
    // console.log( 'degree centrality normalized of 197: ' + cy.$().dcn().degree('#197') );
    // console.log( 'closeness centrality of 197: ' + cy.$().ccn().closeness('#197') );
    // console.log( 'betweenness centrality centrality of 197: ' + cy.$().bc().betweenness('#197') );
}