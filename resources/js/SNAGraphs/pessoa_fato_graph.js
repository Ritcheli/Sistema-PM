import * as d3 from "d3";
import Popper from "popper.js";

export function plotSNAGraphPessFato(data) {
    let selectedNode = null;

    // Specify the dimensions of the chart.
    const width = 928;
    const height = 530;
    const public_path = $('#component').attr('value');

    // Specify the color scale.
    const color = d3.scaleOrdinal(d3.schemeCategory10);

    // The force simulation mutates links and nodes, so create a copy
    // so that re-evaluating this cell produces the same result.
    const links     = data.links.map(d => ({...d}));
    const nodes     = data.nodes.map(d => ({...d}));
    const subtitles = data.subtitles.map(d => ({...d}));

    $('#legendas').removeAttr('hidden');

    $('#legendas').find('.subtitle-content').empty();

    subtitles.forEach(subtitle => {
        $('#legendas').find('.subtitle-content').append(`<div class="row row-subtitle">
                                                            <div class="col-0 pl-0">
                                                                <div class="legenda-color" style="background:` + subtitle.color +`"></div>
                                                            </div>
                                                            <div class="col">
                                                                ` + subtitle.type +`
                                                            </div> 
                                                         </div>`);
    })

    // Create a simulation with several forces.
    const simulation = d3.forceSimulation(nodes)
        .force("link", d3.forceLink(links).id(d => d.id))
        .force("charge", d3.forceManyBody().strength(d => -Math.sqrt(d.size + 1) * 90))
        .force("center", d3.forceCenter(width / 2, height / 2))
        .force("x", d3.forceX())
        .force("y", d3.forceY())
        .on("tick", ticked);

    // Create the SVG container.
    const svg = d3.create("svg")
        .attr("viewBox", [0, 0, width, height])
        .attr("style", "max-width: 100%; height: auto;"); // Adicionar a funcionalidade de zoom ao elemento SVG;

    const g = svg.append("g");

    // Add a line for each link, and a circle for each node.
    const link = g.append("g")
        .attr("stroke", "#999") // Cor da aresta
        .attr("stroke-opacity", 0.6) // Opacidade da aresta
        .selectAll()
        .data(links)
        .join("line")
        .attr("class", "link")
        .attr("stroke-width", d => Math.sqrt(d.weight));

    const node = g.append("g")
        .attr("stroke", "#fff")  // Cor da borda 
        .attr("stroke-width", 2) // Grossura da borda
        .selectAll()
        .data(nodes)
        .join("circle") // Formato do nodo 
        .attr("r", d => 5 + Math.sqrt(d.size) * 5) // Tamanho do nodo
        .attr("fill", d => color(d.color))
        .attr("class", "node")
        .on("click", clickNode)
        .on("mouseover", showTooltip)
        .on("mouseout", hideTooltip);

    svg.on("click", handleGraphClick);

    // Add a drag behavior.
    node.call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended));
    
    // Add zoom behavior
    svg.call(d3.zoom()
        .extent([[0, 0], [width, height]])
        .scaleExtent([0.5, 8]) // Defina os limites de escala conforme necessário
        .on("zoom", zoomed));

    function zoomed(event) {
        g.attr("transform", event.transform);
    }

    // Set the position attributes of links and nodes each time the simulation ticks.
    function ticked() {
        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);

        node
            .attr("cx", d => d.x)
            .attr("cy", d => d.y);
    }

    // Reheat the simulation when drag starts, and fix the subject position.
    function dragstarted(event) {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        event.subject.fx = event.subject.x;
        event.subject.fy = event.subject.y;
    }

    // Update the subject (dragged node) position during drag.
    function dragged(event) {
        event.subject.fx = event.x;
        event.subject.fy = event.y;
    }

    // Restore the target alpha so the simulation cools after dragging ends.
    // Unfix the subject position now that it’s no longer being dragged.
    function dragended(event) {
        if (!event.active) simulation.alphaTarget(0);
        event.subject.fx = null;
        event.subject.fy = null;
    }   

    // Funções de seleção e click
    function handleGraphClick(event) {
        if (!event.target.classList.contains("node") && !event.target.classList.contains("link")) {
            clearSelection();
        }
    }

    function showTooltip(event, d){
        let foto;

        // Verifique se já existe uma tooltip para o nó atual
        const existingTooltip = document.querySelector(".node-tooltip");

        if (existingTooltip) {
            existingTooltip.remove();
        }

        // Crie um elemento de tooltip
        const tooltip = document.createElement("div");
        tooltip.className = "node-tooltip";

        if (d.foto != null){
            foto = 'uploads/fotos_pessoas/' + d.foto.substring(d.foto.lastIndexOf('/') + 1);
        } else {
            foto = 'img/no_image.png'; 
        }

        if (d.type == 'pessoa'){
            tooltip.innerHTML = `<div class="container">
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
                                                    ` + d.label +  ` 
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
                                                    ` + d.RG_CPF + ` 
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>`;
        }
        if (d.type == 'fato'){
            tooltip.innerHTML = `<div class="container m-0">
                                    <div class="row"> 
                                        <div class="col">
                                            <div class="nodo-pessoa-info"> 
                                                ` + d.label +  ` 
                                            </div>
                                        </div>
                                    </div>   
                                 </div>`;
        }

        // Adicione o elemento de tooltip ao corpo do documento
        document.body.appendChild(tooltip);

        // Posicione a tooltip usando o Popper.js
        new Popper(event.target, tooltip, {
            placement: "top",
            modifiers: {
                // arrow: {
                //     element: ".tooltip-arrow" // Elemento da seta (arrow)
                // },
                preventOverflow: {
                    enabled: true,
                    boundariesElement: "viewport"
                }
            }
        });

        // Se desejar, você pode estilizar a tooltip com CSS
        tooltip.style.backgroundColor = "#fff";
        tooltip.style.border = "1px solid #ccc";
        tooltip.style.borderRadius = '6px';
        tooltip.style.padding = "15px";
        tooltip.style.marginBottom = "13px";
        tooltip.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.2)";
        tooltip.style.zIndex = '100';

        // // Crie o elemento da seta
        // const arrow = document.createElement("div");
        // arrow.className = "tooltip-arrow";
        // tooltip.appendChild(arrow);

        // // Estilize a seta (arrow)
        // arrow.style.position = 'absolute';
        // arrow.style.height = '0';
        // arrow.style.width = '0';
        // arrow.style.borderLeft = '10px solid transparent';
        // arrow.style.borderRight = '10px solid transparent';
        // arrow.style.borderBottom = '10px solid #fff';
        // arrow.style.bottom = '-9px'
        // arrow.style.transform = 'rotate(180deg)'; 
    }
    
    function hideTooltip() {
        // Ao sair do nó, simplesmente remova a tooltip
        const existingTooltip = document.querySelector(".node-tooltip");
        if (existingTooltip) {
            existingTooltip.remove();
        }
    }

    function clearSelection() {
        selectedNode = null;

        node.classed("connected", false);
        updateSelection();
    }

    function clickNode(event, d) {
        if (selectedNode === d) {
            clearSelection();
        } else {
            selectedNode = d;
            selectConnectedNodes(d);
        }

        updateSelection();
    }

    function selectConnectedNodes(clickedNode) {
        const connectedNodes = new Set();

        links.forEach(link => {
            if (link.source === clickedNode) {
                connectedNodes.add(link.target);
            }
            if (link.target === clickedNode) {
                connectedNodes.add(link.source);
            }
        });

        nodes.forEach(node => {
            if (selectedNode === node) {
                node.selected = true;
            }
        });

        node.classed("connected", false);
        highlightNodesInList(connectedNodes);
    }

    function highlightNodesInList(nodeList) {
        nodeList.forEach(nodeId => {
            const nodeElement = node.filter(d => d.id === nodeId.id);
            nodeElement.classed("connected", true);
        });
    }

    function updateSelection() {
        node.classed("selected", nodeData => nodeData === selectedNode);
    }
    
    // Append the SVG element.
    component.append(svg.node());
}