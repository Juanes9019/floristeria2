@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <center><h1>Estadisticas</h1></center>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- AREA CHART -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Usuarios</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>

                    <!-- PIE CHART -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Ventas</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    
                    <!-- DONUT CHART -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Compras</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- LINE CHART
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Line</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div> -->

                    <!-- BAR CHART -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Perdidas</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>

                    <!-- STACKED BAR CHART
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Stacked Bar Chart</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(function () {
            // Gráfico de área
            var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
            var areaChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Usuarios registrados',
                    backgroundColor: 'rgba(60,141,188,1)',
                    borderColor: 'rgba(60,141,188,1)',
                    pointRadius: false,
                    data: [65, 59, 80, 81, 56, 55, 40]
                }]
            };
            var areaChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: true
            };
            new Chart(areaChartCanvas, {
                type: 'line',
                data: areaChartData,
                options: areaChartOptions
            });

            // Gráfico de dona
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
            var donutChartData = {
                labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            };
            var donutChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
            };
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutChartData,
                options: donutChartOptions
            });

            // Gráfico de pastel
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieChartData = {
                labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            };
            var pieChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
            };
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieChartData,
                options: pieChartOptions
            });

            // // Gráfico de líneas
            // var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
            // var lineChartData = {
            //     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            //     datasets: [{
            //         label: 'Demo Data',
            //         borderColor: 'rgba(60,141,188,0.8)',
            //         pointRadius: false,
            //         data: [65, 59, 80, 81, 56, 55, 40]
            //     }]
            // };
            // var lineChartOptions = {
            //     responsive: true,
            //     maintainAspectRatio: false,
            //     datasetFill: false
            // };
            // new Chart(lineChartCanvas, {
            //     type: 'line',
            //     data: lineChartData,
            //     options: lineChartOptions
            // });

            // Gráfico de barras
            var barChartCanvas = $('#barChart').get(0).getContext('2d');
            var barChartData = {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    data: [12, 19, 3, 5, 2, 3]
                }]
            };
            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
            };
            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });

            // // Gráfico de barras apiladas
            // var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
            // var stackedBarChartData = {
            //     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            //     datasets: [{
            //         label: 'Dataset 1',
            //         backgroundColor: 'rgba(255, 99, 132, 1)',
            //         data: [65, 59, 80, 81, 56, 55, 40]
            //     }, {
            //         label: 'Dataset 2',
            //         backgroundColor: 'rgba(54, 162, 235, 1)',
            //         data: [28, 48, 40, 19, 86, 27, 90]
            //     }]
            // };
            // var stackedBarChartOptions = {
            //     responsive: true,
            //     maintainAspectRatio: false,
            // };
            // new Chart(stackedBarChartCanvas, {
            //     type: 'bar',
            //     data: stackedBarChartData,
            //     options: stackedBarChartOptions
            // });
        });
    </script>
@endsection
