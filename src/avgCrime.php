<!DOCTYPE html>
<html>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <head>

        <link rel="stylesheet" href="webStyle.css">
        <title>Crime Effects</title>
        <h1>Average Effect of Every Crime</h1>
        
    </head>

    <?php

        include("avgCrimeConnection.php");

    ?>

    <body>

        <!-- Query Description -->
        <p><i>The trend in stolen value per cargo theft, victims per hate crime, and victims per human trafficking incident from <?php echo $start?> to <?php echo $end?>.</i></p>

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

            //Read query result
            const data = <?php echo $data_json; ?>;

            //Store the three crime types in seperate arrays
            const years = data.map(obj => obj.year);
            const cargoValue = data.map(obj => obj.cargoValue);
            const hateCrime = data.map(obj => obj.hateCrime);
            const traffic = data.map(obj => obj.traffic);

            //Line Graph
            const ctx = document.getElementById('myChart').getContext('2d');
            const chart = new Chart(ctx, {

                type: 'line',
                data: {

                    labels: years,
                    datasets: [

                        {

                            label: 'Cargo Value',
                            data: cargoValue,
                            borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',

                        }, 
                        {

                            label: 'Hate Crime',
                            data: hateCrime,
                            borderColor: 'rgb(54, 162, 235)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',

                        },
                        {

                            label: 'Human Traffic',
                            data: traffic,
                            borderColor: 'rgb(24, 174, 39)',
                            backgroundColor: 'rgba(24, 174, 39, 0.2)',

                        }

                    ],

                },
                options: {

                    scales: {

                        x: {

                            display: true,
                            title: {

                                display: true,
                                text: 'Year',
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
                                text: 'Severity of Incident',
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