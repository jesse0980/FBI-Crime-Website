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

            //Query #5
            $query = "SELECT ct.data_year, avg_stolen_cargo_value, avg_hateCrime_victims_per_incident, avg_humanTrafficking_victims_per_incident
                      FROM(
                        SELECT data_year, SUM(STOLEN_VALUE)/COUNT(*) AS avg_stolen_cargo_value
                        FROM cargo_theft
                        GROUP BY data_year
                      )ct,
                      (
                        SELECT data_year, SUM(victim_count)/COUNT(*) AS avg_hateCrime_victims_per_incident
                        FROM hate_crime
                        GROUP BY data_year
                      )hc,
                      (
                        SELECT data_year, SUM(cleared_count)/COUNT(*) AS avg_humanTrafficking_victims_per_incident
                        FROM human_trafficking
                        GROUP BY data_year
                      )ht
                      WHERE ct.data_year = hc.data_year 
                            AND ct.data_year = ht.data_year 
                            AND ct.data_year >= $start 
                            AND ct.data_year <= $end
                      ORDER BY ct.data_year ASC";

            //Execute the query using the database
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            //Store the query result into an array
            $data = array();
            while ($row = oci_fetch_assoc($statement)) {

                $data[] = array(

                    'year' => $row['DATA_YEAR'],
                    'cargoValue' => $row['AVG_STOLEN_CARGO_VALUE'],
                    'hateCrime' => $row['AVG_HATECRIME_VICTIMS_PER_INCIDENT'],
                    'traffic' => $row['AVG_HUMANTRAFFICKING_VICTIMS_PER_INCIDENT'],

                );

            }

            $data_json = json_encode($data);

            //Close the Oracle connection and query
            oci_free_statement($statement);
            oci_close($connection);

        ?>

    </body>

</html>