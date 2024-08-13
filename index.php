<?php

$route_c = "conexion.php";
$route_lg = "authentication/account.php";

include 'conexion.php';
include 'authentication/sesion.php';

$labels = "'La Romana','Santiago','Puerto Plata','Santo Domingo','El Seibo','Hato Mayor','Higuey','Azua','San Juan'";
$data = '40, 80, 20, 5, 58, 84, 81, 15, 51';

$labels2 = "'homicidios', 'asalto', 'agresion sexual','secuestros'";
$data2 = '401, 102, 24, 300';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index_styles/style.css">
    <link rel="stylesheet" href="assets/css/messages_styles/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Document</title>
</head>
<body>
    <div class="dashboard">
        <header id="cabezera">
            <span>Security Environment</span>
            <a href="authentication/logout.php"><button>cerrar sesion</button></a>
        </header>
        
        <div class="incidencias">
            <h2>Incidencias</h2>
            <div class="container_data">

                <div class="box">
                    <i class="fas fa-user"></i>
                    <div class="text">
                        <span>asalto</span>
                        <h2>25</h2>
                    </div>
                </div>

                <div class="box">
                    <i class="fas fa-user"></i>
                    <div class="text">
                        <span>homicidio</span>
                        <h2>250</h2>
                    </div>
                </div>

                <div class="box">
                    <i class="fas fa-user"></i>
                    <div class="text">
                        <span>secuestros</span>
                        <h2>15</h2>
                    </div>
                </div>

                <div class="box">
                    <i class="fas fa-user"></i>
                    <div class="text">
                        <span>agresion sexual</span>
                        <h2>0</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container_charts">
            <div class="" style="width:100vw; height:calc(100vh - 200px);">
                <canvas id="myChart" style="display: block;"></canvas>
            </div>

            <br><br><br><br><br>

            <div class="" style="width:1200px; height:400px;">
                <canvas id="myChart2"></canvas>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Primer gráfico
        var ctx = document.getElementById('myChart').getContext('2d');
        ctx.canvas.width = window.innerWidth;
        ctx.canvas.height = window.innerHeight;

        var myChart = new Chart(ctx, {
            type: 'line', // Puedes cambiar el tipo de gráfico aquí
            data: {
                labels: [<?php echo $labels; ?>],
                datasets: [{
                    label: '# of Votes',
                    data: [<?php echo $data; ?>],
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
                    borderWidth: 2
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Segundo gráfico
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        ctx2.canvas.width = window.innerWidth;
        ctx2.canvas.height = window.innerHeight;

        var myChart2 = new Chart(ctx2, {
            type: 'bar', // Puedes cambiar el tipo de gráfico aquí
            data: {
                labels: [<?php echo $labels2; ?>],
                datasets: [{
                    label: '# of Votes',
                    data: [<?php echo $data2; ?>],
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
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
</html>
>>>>>>> dashboard
