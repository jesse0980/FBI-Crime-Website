<!DOCTYPE html>
<html>

    <body>

        <!-- User Input -->
        <form method="get" action="">

            <!-- User inputs the stolen value the query will use -->
            <label for="stolenVal">Stolen Value:</label><br>
            <input type="number" id="stolenVal" name="stolenVal" min=0><br><br>

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
            <select name="end_year" id="end_year" >

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

            //Set default values to the stolen value, start year, and end year in case the user does not provide any input
            $start = 2013;
            $end = 2021;
            $stolenVal = 10000;

            //Assign the user's input values to the stolen value, start year, and end year
            if (isset($_GET['start_year'])) {

                $start = $_GET['start_year'];

            }
            if(isset($_GET['stolenVal'])) {

                $stolenVal = $_GET['stolenVal'];

            }
            if (isset($_GET['end_year'])) {

                $end = $_GET['end_year'];

            }

            //Query #4
            $query = "SELECT ct.DATA_YEAR,
                        SUM(CASE WHEN ct.AGENCY_TYPE_NAME = 'City' THEN 1 ELSE 0 END) as city_incidents,
                        SUM(CASE WHEN ct.AGENCY_TYPE_NAME = 'County' THEN 1 ELSE 0 END) as county_incidents,
                        SUM(CASE WHEN ct.AGENCY_TYPE_NAME = 'Other' THEN 1 ELSE 0 END) as other_incidents,
                        SUM(CASE WHEN ct.AGENCY_TYPE_NAME = 'State Police' THEN 1 ELSE 0 END) as statepolice_incidents,
                        SUM(CASE WHEN ct.AGENCY_TYPE_NAME = 'Other State Agency' THEN 1 ELSE 0 END) as otherstateagency_incidents,
                        SUM(CASE WHEN ct.AGENCY_TYPE_NAME = 'University or College' THEN 1 ELSE 0 END) as universityorcollege_incidents
                      FROM cargo_theft ct
                      WHERE ct.STOLEN_VALUE >= $stolenVal
                            And ct.data_year >= $start
                            AND ct.data_year <= $end
                      GROUP BY ct.DATA_YEAR
                      ORDER BY ct.DATA_YEAR ASC";

            //Execute the query using the database
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            //Store the query result into an array
            $data = array();
            while ($row = oci_fetch_assoc($statement)) {

                $data[] = array(

                    'year' => $row['DATA_YEAR'],
                    'city_incidents' => $row['CITY_INCIDENTS'],
                    'county_incidents' => $row['COUNTY_INCIDENTS'],
                    'otherCases' => $row['OTHER_INCIDENTS'],
                    'statePoliceCases' => $row['STATEPOLICE_INCIDENTS'],
                    'otherStateAgencyCases' => $row['OTHERSTATEAGENCY_INCIDENTS'],
                    'universityOrCollegeCases' => $row['UNIVERSITYORCOLLEGE_INCIDENTS'],

                );

            }

            $data_json = json_encode($data);

            //Close the Oracle connection and query
            oci_free_statement($statement);
            oci_close($connection);

        ?>

    </body>

</html>