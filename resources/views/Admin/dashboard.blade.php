

@extends('adminlte::page')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            width: 600px; /* Ajusta el tamaño según tus necesidades */
            height: 300px; /* Ajusta el tamaño según tus necesidades */
            margin: 20px; /* Espacio alrededor de cada gráfica */
            display: inline-block; /* Permite que los contenedores se alineen horizontalmente */
        }
    </style>
</head>
<body>
    <h1>Dashboard de Compras</h1>

    <div class="chart-container">
        <canvas id="comprasChart1"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="comprasChart2"></canvas>
    </div>

    <script>
        var ctx1 = document.getElementById('comprasChart1').getContext('2d');
        var ctx2 = document.getElementById('comprasChart2').getContext('2d');

        // Preparar los datos para Chart.js
        var data1 = @json($comprasData1);
        var data2 = @json($comprasData2);

        // Extraer etiquetas y datos para el primer gráfico (barra)
        var meses1 = data1.map(item => item.fecha);
        var totales1 = data1.map(item => item.total);

        // Primer gráfico (barra)
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: meses1, // Meses y años en formato YYYY-MM
                datasets: [{
                    label: 'Total Compras (Gráfico 1)',
                    data: totales1, // Totales por mes
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Extraer etiquetas y datos para el segundo gráfico (pie)
        var labels2 = data2.map(item => item.fecha); // Etiquetas para el gráfico de pie
        var values2 = data2.map(item => item.total); // Valores para el gráfico de pie

        // Segundo gráfico (pie)
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: labels2, // Etiquetas para el gráfico de pie
                datasets: [{
                    label: 'Total Compras (Gráfico 2)',
                    data: values2, // Valores para el gráfico de pie
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
@stop