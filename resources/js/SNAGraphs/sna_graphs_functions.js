var animationDuration    = 750;
var easing               = 'ease';
var padding              = 40;

let highlightInProgress;
let lastHighlighted;
let lastUnhighlighted;

var getOrgPos = n => Object.assign({}, n.data('orgPos'));

export function highlight(node, cy){
    const neighborhood = lastHighlighted = node.closedNeighborhood();
    const allEles = cy.elements();
    const others = lastUnhighlighted = allEles.not( neighborhood );
    
    if (highlightInProgress) { return };

    highlightInProgress = true;

    neighborhood.removeClass('faded');
    others.addClass('hidden');
    others.positions(getOrgPos);

    const layout = neighborhood.layout({
        name: 'preset',
        positions: getOrgPos,
        fit: true,
        animate: true,
        animationDuration: animationDuration,
        animationEasing: easing,
        padding: padding
    });

    layout.run();

    return layout.promiseOn('layoutstop').then(function( ){
        const p = getOrgPos(node);

        const layout = neighborhood.layout({
            name: 'concentric',
            fit: true,
            animate: true,
            animationDuration: animationDuration,
            animationEasing: easing,
            boundingBox: {
                x1: p.x - 1,
                x2: p.x + 1,
                y1: p.y - 1,
                y2: p.y + 1
            },
            minNodeSpacing: 25,
            avoidOverlap: true,
            concentric: function( ele ){
                if( ele.same( node ) ){
                    return 2;
                } else {
                    return 1;
                }
            },
            levelWidth: () => { return 1; },
            padding: padding
        });

        layout.run();

        layout.promiseOn('layoutstop').then( function () {
            cy.batch(() => {
                others.removeClass('hidden').addClass('faded');
                highlightInProgress = false;
            });
        });
    });
}

export function unhighlight(cy){
    const allEles  = cy.elements();

    if ( highlightInProgress ) { return };

    if (!lastHighlighted) { return };

    const neighborhood  = lastHighlighted;
    const others        = lastUnhighlighted;

    lastHighlighted = lastUnhighlighted = null;

    const hideOthers = function(){
        others.addClass('hidden');
  
        return Promise.resolve();
    };
  
    const resetClasses = function(){
        cy.batch(function(){
            allEles.removeClass('hidden').removeClass('faded');
        });
    
        return Promise.resolve();
    };
  
    const animateToOrgPos = function( neighborhood ){
        return Promise.all( neighborhood.nodes().map(n => {
            return n.animation({
                position: getOrgPos(n),
                duration: animationDuration,
                easing: easing
            }).play().promise();
        }) );
    };
  
    const restorePositions = () => {
        cy.batch(() => {
            others.nodes().positions(getOrgPos);
        });

        return animateToOrgPos( neighborhood.nodes() );
    };
  
    return (
        Promise.resolve()
            .then( hideOthers )
            .then( restorePositions )
            .then( resetClasses )
    );
}

export function style_SNA_bi(data) {
    return [ // the stylesheet for the graph
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
                        let normalized_size = (ele.data('size') - data['values_to_normalize']['min_value'])/(data['values_to_normalize']['max_value'] - data['values_to_normalize']['min_value']);

                        return Math.max(0.5, Math.sqrt(normalized_size)) * 50; 
                    }; 
                },
                height: function(ele){ 
                    if (ele.data('type') == 'pessoa'){
                        return ele.data('size')*10; 
                    } else {
                        let normalized_size = (ele.data('size') - data['values_to_normalize']['min_value'])/(data['values_to_normalize']['max_value'] - data['values_to_normalize']['min_value']);

                        return Math.max(0.5, Math.sqrt(normalized_size)) * 50; 
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
    ];
}

export function show_classificacao(nodes_for_ordering, cy){
    $('#classificacao').find('.table-class').html("");

    for (var i = 0; i < nodes_for_ordering.length; i++){
        $('#classificacao').find('.table-class').append(`
        <tr class="class_node_info" id="` + nodes_for_ordering[i]['node_id'] + `">
            <td class="td-class">
                ` + (i + 1) +`
            </td>
            <td class="td-name">
                ` +  cy.getElementById(nodes_for_ordering[i]['node_id']).data('label') + `
            </td>
            <td class="td-val">
                ` + JSON.stringify(nodes_for_ordering[i]['value']).replace(/\.(\d{1,3}).*$/, '.$1') + `
            </td>
        </tr>
        `);

        if (i == 9) break;
    }

    $('.class_node_info').off('click');
    $('.class_node_info').on('click', function() {
        let id   = $(this).attr('id');
        let node = cy.getElementById(id);

        highlight(node, cy);
    });
}

export var click_class = function click_check_menu_classificacao() {
    if ($('#check_menu_classificacao').find(".dropdown-item-check").hasClass("hidden")) {
        $('#classificacao').attr('hidden', true);
    } else {
        $('#classificacao').attr('hidden', false);
    }
}