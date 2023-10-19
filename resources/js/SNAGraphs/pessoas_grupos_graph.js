import cytoscape from "cytoscape";

export function plotPessoasGruposGraph(data){
    const public_path = $('#cy').attr('value');

    var subtitles = data['subtitles'];

    var cy = cytoscape({
        container: document.getElementById('cy'), // container to render in

        elements: data['graph'],
        
        style: [ // the stylesheet for the graph
            {
                selector: 'node',
                style: {
                    'background-color': function(ele){
                        return ele.data('color');  
                    },
                    'border-width': ' 2px',
                    'border-color': '#F7F7F7',
                    width: function(ele){ return ele.data('size') * 10; },
                    height: function(ele){ return ele.data('size') * 10; }
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

    $('#legendas').removeAttr('hidden');
}