<html>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <head>

        <link rel="stylesheet" href="webStyle.css">
        <title>Percentage of Total Hate_Crimes</title>
        <h1>Percentage of Hate Crimes per Bias by Year</h1>

    </head>

    <?php

        include("hateCrimesConnection.php");

    ?>

    <body>

        <!-- Query Description -->
        <p><i>The graph displays the percentages each group experiences out of every hate crime from <?php echo $start?> to <?php echo $end?>.</i></p>

        <!-- Line Graph Style -->
        <div class="chart-container" style="position: relative; height:80vh; width:120vw">

            <canvas id="myChart"></canvas>

        </div>

        <style>

            .chart-container {

                margin: 0 auto;
                max-width: 75%;

            }

        </style><br><br>

        <!-- Pie Chart Style -->
        <h2>Total Percentages of Hate Crimes Caused by Each Bias from 1991 to 2021</h2>
        
        <div class="chart-container" style="position: relative; height:80vh; width:120vw">

            <canvas id="myChart2"></canvas>

        </div>

        <style>

            .chart-container {

                position: relative;
                height: 80vh;
                width: 120vw;
                margin: 0 auto;
                max-width: 75%;
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;

            }

        </style>

        <script>

            //Line Graph
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart_data = {

                //Read data from query result
                labels: <?php echo json_encode($labels); ?>,
                datasets: [
                    
                    {
                        
                        label: 'Black or African American',
                        data: <?php echo json_encode($AAdata_points); ?>,
                        borderColor: 'red',
                        fill: false
                        
                    },
                    {

                        label: 'White',
                        data: <?php echo json_encode($Wdata_points); ?>,
                        borderColor: 'blue',
                        fill: false

                    },
                    {

                        label: 'Asian',
                        data: <?php echo json_encode($Adata_points); ?>,
                        borderColor: 'Black',
                        fill: false

                    },
                    {

                        label: 'Hispanic or Latino',
                        data: <?php echo json_encode($Hdata_points); ?>,
                        borderColor: 'Green',
                        fill: false

                    },
                    {

                        label: 'Gay (Male)',
                        data: <?php echo json_encode($Gdata_points); ?>,
                        borderColor: 'Yellow',
                        fill: false

                    },
                    {

                        label: 'Jewish',
                        data: <?php echo json_encode($Jdata_points); ?>,
                        borderColor: 'Gray',
                        fill: false

                    },
                    {

                        label: 'Muslim',
                        data: <?php echo json_encode($Mdata_points); ?>,
                        borderColor: 'Orange',
                        fill: false

                    },
                    {

                        label: 'Lesbian',
                        data: <?php echo json_encode($Lesdata_points); ?>,
                        borderColor: 'Purple',
                        fill: false

                    },
                    {

                        label: 'Other Race/Ancestory',
                        data: <?php echo json_encode($OTdata_points); ?>,
                        borderColor: 'White',
                        fill: false

                    }

                ]

            };

            var myChart = new Chart(ctx, {

                type: 'line',
                data: chart_data,
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
                                text: 'Percentage',
                                font: {

                                    family: 'Calibri',
                                    size: 30,
                                    weight: 'bold',
                                    lineHeight: 1.2,

                                },
                                ticks: {

                                    beginAtZero: true

                                }

                            }

                        }

                    }

                }

            });
                
            //Pie Chart
            var PieData = <?php echo json_encode($data_array); ?>;
            var Pielabels = <?php echo json_encode($Pielabels); ?>;
            var Piedata_points = <?php echo json_encode($Piedata_points); ?>;

            var ctx = document.getElementById('myChart2').getContext('2d');
            var myPieChart = new Chart(ctx, {

                type: 'pie',
                data: {

                    labels: Pielabels,
                    datasets: [{

                        label: 'Percentage',
                        data: Piedata_points,
                        backgroundColor: [

                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'white',
                            'blue',
                            'rgba(0, 128, 0, 0.2)',
                            'rgba(139, 69, 19, 0.2)',
                            'rgba(0, 0, 0, 0.2)'

                        ],
                        borderColor: [

                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                            
                        ],
                        borderWidth: 1

                    }]

                },
                options: {

                    responsive: true,
                    legend: {

                        position: 'right',

                    },
                    title: {

                        display: true,
                        text: 'Hate Crime Bias Percentages'

                    }

                }

            });

        </script>

        <!-- Button to return to home page -->
        <button onclick="window.location.href = 'home.php';">Home</button>

    </body>

</html>