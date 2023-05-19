<!DOCTYPE html>
<html>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <head>

        <link rel="stylesheet" href="webStyle.css">
        <title>High Cargo Thefts</title>
        <h1>High Value Cargo Thefts by Agency Types</h1>
        <p><i>Number of cargo theft incidents by agency type and year, where the total stolen value is greater than the given value for that year.</i></p>

    </head>

    <?php

        include("highCargoConnection.php");

    ?>

    <body>

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

            //Store all of the agency types in seperate arrays
            const years = data.map(obj => obj.year);
            const city_ = data.map(obj => obj.city_incidents);
            const county_ = data.map(obj => obj.county_incidents);
            const statePoliceCases = data.map(obj => obj.statePoliceCases);
            const otherStateAgencyCases = data.map(obj => obj.otherStateAgencyCases);
            const otherCases = data.map(obj => obj.otherCases);
            const universityOrCollegeCases = data.map(obj => obj.universityOrCollegeCases);

            //Line Graph
            const ctx = document.getElementById('myChart').getContext('2d');
            const chart = new Chart(ctx, {

                type: 'line',
                data: {

                    labels: years,
                    datasets: [

                        {

                            label: 'City Cases',
                            data: city_,
                            borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',

                        },
                        {

                            label: 'County Cases',
                            data: county_,
                            borderColor: 'rgb(54, 162, 235)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',

                        },
                        {

                            label: 'Other Cases',
                            data: otherCases,
                            borderColor: 'rgba(99, 58, 52, 1)',
                            backgroundColor: 'rgba(99, 58, 52, 0.2)',

                        },
                        {

                            label: 'State Police Cases',
                            data: statePoliceCases,
                            borderColor: 'rgba(153, 153, 80, 1)',
                            backgroundColor: 'rgba(153, 153, 80, 0.2)',

                        },
                        {

                            label: 'College/University Cases',
                            data: universityOrCollegeCases,
                            borderColor: 'rgba(71, 74, 81, 1)',
                            backgroundColor: 'rgba(71, 74, 81, 0.2)',

                        },
                        {

                            label: 'Misc State Cases',
                            data: otherStateAgencyCases,
                            borderColor: 'rgba(255, 255, 0, 1)',
                            backgroundColor: 'rgba(255, 255, 0, 0.2)',

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