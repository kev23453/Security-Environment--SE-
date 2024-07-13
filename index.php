<?php

$route_c = "conexion.php";
$route_lg = "authentication/account.php";

include 'conexion.php';
include 'authentication/sesion.php';

$labels = "'La Romana','Santiago','Puerto Plata','Santo Domingo','El Seibo','Hato Mayor','Higuey','Azua','San Juan'";
$data = '40, 80, 20, 5, 58, 84, 81, 15, 51';

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
<!--  <a href="authentication/logout.php">cerrar sesion</a>   -->
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
            <div class="" style="width:700px; height:500px;">
                <canvas id="myChart"></canvas>
            </div>
            <div class="" style="width:700px; display:flex; justify-content:center; align-items:center; height:400px;">
                <canvas id="radarChart"></canvas>
            </div>
        </div>

    </div>



    
</body>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php echo $labels; ?>],
            datasets: [{
                label: 'indice de criminalidad',
                data: [<?php echo $data; ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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






    var radar = document.getElementById('radarChart').getContext('2d');
    var myChart = new Chart(radar, {
        type: 'polarArea',
        data: {
            labels: [<?php echo $labels; ?>],
            datasets: [{
                label: 'indice de criminalidad',
                data: [<?php echo $data; ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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
</script>
</html>