<!DOCTYPE html>
<html>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <head>

        <link rel="stylesheet" href="webStyle.css">
        <title>Crime Citiess</title>
        <h1>Cities with the Highest Average Crime Rate</h1>
        
    </head>

    <?php

        include("crimeCitiesConnection.php");

    ?>

    <body>

        <!-- Query Description -->
        <p><i>Displays the name of cities that have had since <?php echo $start?> to <?php echo $end?> a number of crimes per year at least <?php echo (($percent - 1) * 100)?>% greater than the average number of crimes per year across the country.</i></p>

        <canvas id="myChart"></canvas>

        <script>

            //Read the query result
            const data = <?php echo $data_json; ?>;

            //Store the city names and each of their average crime rates in seperate arrays
            const cityNames = data.map(obj => obj.pubNames);
            const avgCrime = data.map(obj => obj.avgCrime);

            //Bar Graph
            const ctx = document.getElementById('myChart').getContext('2d');
            const chart = new Chart(ctx, {

                type: 'bar',
                data: {

                    labels: cityNames,
                    datasets: [{

                        label: 'Crime Average',
                        data: avgCrime,
                        borderColor: 'rgb(255, 79, 132)',
                        backgroundColor: 'rgba(255, 79, 132, 1)',

                    }],

                },
                options: {

                    scales: {

                        x: {

                            display: true,
                            title: {

                                display: true,
                                text: 'City Names',
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