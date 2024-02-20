import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/dashboard/ocorr-chart-data",
        method: "GET",
        success: function(result){
            const data = {
                labels: Object.keys(result),
                datasets: [{
                    label: 'Ocorrências cadastradas',
                    backgroundColor: '#01b951',
                    borderColor: '#007d36',
                    data: Object.values(result),
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
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: "/dashboard/grupo-chart-data",
        method: "GET",
        success: function(result){
            const data_bar = {
                labels: Object.keys(result),
                datasets: [{
                    label: 'Grupos de ocorrencias registradas',
                    backgroundColor: '#007d36',
                    data: Object.values(result),
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
        }
    });
},)