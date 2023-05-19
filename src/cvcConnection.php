<!DOCTYPE html>
<html>

    <body>

        <!-- User Input -->
        <form method="get" action=""><br>

            <!-- User selects the starting year the query will use -->
            <label for="start_year">Select start year:</label>
            <select name="start_year" id="start_year">

                <option value="" disabled selected hidden>2013</option> <!-- Default Value -->
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>

            </select><br>

            <!-- User selects the last year the query will use -->
            <label for="end_year">Select end year:</label>
            <select name="end_year" id="end_year">

                <option value="" disabled selected hidden>2021</option> <!-- Default Value -->
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>

            </select><br>

            <!-- Submit Button -->
            <input type="submit" value="Submit">

        </form>

        <?php

            //Connect to Oracle Database
            $connection = oci_connect($username = 'jmclaren',
                                      $password = 'IwvVM5yAatIjuuWV5h2A74EZ',
                                      $connection_string = '//oracle.cise.ufl.edu/orcl');

            if (!$connection) {

                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

            }

            //Set default values to the start and end years in case the user does not provide any input
            $start = 2013;
            $end = 2021;

            //Assign the user's input values to the start and end years
            if (isset($_GET['start_year'])) {

                $start = $_GET['start_year'];

            }
            if (isset($_GET['end_year'])) {

                $end = $_GET['end_year'];

            }

            //Query #3
            $query = "SELECT data_year, cityCount_ct + cityCount_hc + cityCount_ht AS cityCases, countyCount_ct + countyCount_hc + countyCount_ht AS countyCases
                      FROM(
                        SELECT data_year, count(*) AS cityCount_ct
                        FROM cargo_theft
                        WHERE agency_type_name = 'City'
                        GROUP BY data_year
                      ),
                      (
                        SELECT data_year AS year2, count(*) AS countyCount_ct
                        FROM cargo_theft
                        WHERE agency_type_name = 'County'
                        GROUP BY data_year
                      ),
                      (
                        SELECT data_year AS year3, count(*) AS cityCount_hc
                        FROM hate_crime
                        WHERE agency_type_name = 'City' AND data_year >= $start AND data_year <= $end
                        GROUP BY data_year
                      ),
                      (
                        SELECT data_year AS year4, count(*) AS countyCount_hc
                        FROM hate_crime
                        WHERE agency_type_name = 'County' AND data_year >= $start AND data_year <= $end
                        GROUP BY data_year
                      ),
                      (
                        SELECT data_year AS year5, count(*) AS cityCount_ht
                        FROM human_trafficking
                        WHERE agency_type = 'City' AND data_year >= $start AND data_year <= $end
                        GROUP BY data_year
                      ),
                      (
                        SELECT data_year AS year6, count(*) AS countyCount_ht
                        FROM human_trafficking
                        WHERE agency_type = 'County' AND data_year >= $start AND data_year <= $end
                        GROUP BY data_year
                      )
                      WHERE data_year = year2
                            AND year2 = year3
                            AND year3 = year4
                            AND year4 = year5
                            AND year5 = year6
                            AND data_year >= $start
                            AND data_year <= $end
                      ORDER BY data_year ASC";

            //Execute the query using the database
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            //Store the query result into an array
            $data = array();
            while ($row = oci_fetch_ASsoc($statement)) {

                $data[] = array(

                    'year' => $row['DATA_YEAR'],
                    'cityCases' => $row['CITYCASES'],
                    'countyCases' => $row['COUNTYCASES'],

                );

            }

            $data_json = json_encode($data);

            //Close the Oracle connection and query
            oci_free_statement($statement);
            oci_close($connection);

        ?>

    </body>

</html>