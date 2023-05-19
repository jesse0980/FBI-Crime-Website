<html>
<link rel="stylesheet" href="Bias.css">

    <?php

        include("connection.php");

    ?>

    <body>

        <!-- //Javascript to chart the data -->
        <script>

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart_data = {

                labels: <?php echo json_encode($labels); ?>,
                datasets: [
                    
                    {
                        label: 'Florida',
                        data: <?php echo json_encode($FLdata_points); ?>,
                        borderColor: 'red',
                        fill: false
                    },
                    {

                        label: 'Texas',
                        data: <?php echo json_encode($TXdata_points); ?>,
                        borderColor: 'blue',
                        fill: false

                    },
                    {

                        label: 'California',
                        data: <?php echo json_encode($CAdata_points); ?>,
                        borderColor: 'Black',
                        fill: false

                    },
                    {

                        label: 'New York',
                        data: <?php echo json_encode($NYdata_points); ?>,
                        borderColor: 'Green',
                        fill: false

                    }

                ]

            };

            var myChart = new Chart(ctx, {

                type: 'line',
                data: chart_data,
                options: {

                    scales: {

                        yAxes: [{

                            ticks: {

                                beginAtZero: true

                            }

                        }]

                    }

                }

            });

        </script>

        <button onclick="window.location.href = 'about.php';">Home</button>


    </body>

</html>