<!DOCTYPE html>
<html>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <head>

        <link rel="stylesheet" href="webStyle.css">
        <title>Cargo Thefts in Child-Prone Zones</title>
        <h1>Cargo Thefts Occurred in Child-Prone Zones</h1>
        
    </head>

    <?php

        include("childCargoTheftConnection.php");

    ?>

    <body>

        <!-- Query Description -->
        <p><i>From <?php echo $start?> to <?php echo $end?>, the graph shows the number of cargo thefts with a value greater than $<?php echo $val?> in child-prone zones.</i></p>

        <!-- Line Graph Style -->
        <div class="chart-container" style="position: relative; height:80vh; width:120vw">

            <canvas id="myChart"></canvas>

        </div>

        <style>

            .chart-container {

                margin: 0 auto;
                max-width: 75%;

            }

        </style>

        <script>

            //Read the query results then store the number of cargo thefts and their time frame in seperate arrays
            const Sdata = <?php echo $Sdata_json; ?>;
            const Syears = Sdata.map(obj => obj.year);
            const Scount = Sdata.map(obj => obj.count);

            const Rdata = <?php echo $Rdata_json; ?>;
            const Ryears = Rdata.map(obj => obj.year);
            const Rcount = Rdata.map(obj => obj.count);

            const Pdata = <?php echo $Pdata_json; ?>;
            const Pyears = Pdata.map(obj => obj.year);
            const Pcount = Pdata.map(obj => obj.count);

            const SCdata = <?php echo $SCdata_json; ?>;
            const SCyears = SCdata.map(obj => obj.year);
            const SCcount = SCdata.map(obj => obj.count);

            //Line Graph
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {

                type: 'line',
                data: {

                    labels: Ryears,
                    datasets: [

                        {

                            label: 'Community Centers',
                            data: Scount,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1

                        },
                        {

                            label: 'Thefts in Residencies/Homes',
                            data: Rcount,
                            backgroundColor: 'blue',
                            borderColor: 'blue',
                            borderWidth: 1

                        },
                        {

                            label: 'Parking Lot/Street',
                            data: Pcount,
                            backgroundColor: 'black',
                            borderColor: 'black',
                            borderWidth: 1

                        },
                        {

                            label: 'School Zones',
                            data: SCcount,
                            backgroundColor: 'yellow',
                            borderColor: 'yellow',
                            borderWidth: 1

                        }

                    ],

                },
                options: {

                    scales: {

                        x: {

                            display: true,
                            title: {

                                display: true,
                                text: 'Time',
                                font: {

                                    family: 'Calibri',
                                    size: 30,
                                    weight: 'bold',
                                    lineHeight: 1.2,

                                }

                            }

                        },
                        y: {

                            display: true,
                            title: {

                                display: true,
                                text: 'Number of Cargo Thefts',
                                font: {

                                    family: 'Calibri',
                                    size: 30,
                                    weight: 'bold',
                                    lineHeight: 1.2,

                                }

                            }

                        }

                    }

                }

            });

        </script>

    </body>

    <!-- Button to return to the home page -->
    <button onclick="window.location.href = 'home.php';">Home</button>

</html>