import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function(){
    const labels = [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
    ];
    
    const data = {
        labels: labels,
        datasets: [{
            label: 'Ocorrências cadastradas',
            backgroundColor: '#01b951',
            borderColor: '#007d36',
            data: [0, 10, 5, 2, 20, 30, 45],
        }]
    };
    
    const config = {
        type: 'line',
        data: data,
        options: {
            maintainAspectRatio: false,
        }
    };
    
    new Chart(
        document.getElementById('chart'),
        config
    );

    const labels_bar = [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
    ];
    
    const data_bar = {
        labels: labels_bar,
        datasets: [{
            label: 'Pessoas apreendidas',
            backgroundColor: '#007d36',
            data: [0, 10, 5, 2, 20, 30, 45],
        }]
    };
    
    const config_bar = {
        type: 'bar',
        data: data_bar,
        options: {
            maintainAspectRatio: false,
        }
    };
    
    new Chart(
        document.getElementById('chart2'),
        config_bar 
    );
},)