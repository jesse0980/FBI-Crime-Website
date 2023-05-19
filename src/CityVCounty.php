<!DOCTYPE html>
<html>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <head>

        <link rel="stylesheet" href="webStyle.css">
        <title>County vs. City Crimes</title>
        <h1>Number of Crimes Cleared by County vs. City Departments</h1>
        
    </head>

    <?php

        include("cvcConnection.php");

    ?>

    <body>

        <!-- Query Description -->
        <p><i>For all types of crime, the graph displays the trend of the number of crimes cleared by county vs city departments from <?php echo $start?> to <?php echo $end?>.</i></p>

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

            //Read the query result
            const data = <?php echo $data_json; ?>;

            //Store all of the cases in seperate arrays
            const years = data.map(obj => obj.year);
            const cityCases = data.map(obj => obj.cityCases);
            const countyCases = data.map(obj => obj.countyCases);

            //Line Graph
            const ctx = document.getElementById('myChart').getContext('2d');
            const chart = new Chart(ctx, {

                type: 'line',
                data: {

                    labels: years,
                    datasets: [
                        
                        {

                            label: 'City Cases',
                            data: cityCases,
                            borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',

                        },
                        {

                            label: 'County Cases',
                            data: countyCases,
                            borderColor: 'rgb(54, 162, 235)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',

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
                                text: 'Number of Crimes',
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