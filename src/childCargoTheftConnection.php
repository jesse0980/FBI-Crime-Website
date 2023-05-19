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

            <!-- User selects the theft value the query will use -->
            <label for="val">Select theft value:</label>
            <select name="val" id="val">

                <option value="" disabled selected hidden>0</option> <!-- Default Value -->
                <option value="0">0$</option>
                <option value="100">100$</option>
                <option value="500">500$</option>
                <option value="1000">1000$</option>

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

            //Set default values to the theft value, start year, and end year in case the user does not provide any input
            $val = 0;
            $start = 2013;
            $end = 2021;

            //Assign the user's input values to the theft value, start year, and end year
            if (isset($_GET['val'])) {

                $val = $_GET['val'];

            }
            if (isset($_GET['start_year'])) {

                $start = $_GET['start_year'];

            }
            if (isset($_GET['end_year'])) {

                $end = $_GET['end_year'];

            }

            //Query #1

            //Community Center
                $query = "SELECT data_year, COUNT(*)
                          FROM cargo_theft
                          WHERE (location_name = 'Community Center' or location_name LIKE '%Church%')
                                AND stolen_value >= $val
                                AND data_year >= $start
                                AND data_year <= $end
                          GROUP BY data_year
                          ORDER BY data_year ASC";

                //Execute the query using the database
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                //Store the query result into an array
                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {

                    $data[] = array(

                        "year" => $row["DATA_YEAR"],
                        "count" => $row["COUNT(*)"]

                    );

                }

                $Sdata_json = json_encode($data);

            //Residencies
                $query = "SELECT data_year, COUNT(*)
                          FROM cargo_theft
                          WHERE location_name = 'Residence/Home'
                                AND stolen_value >= $val
                                AND data_year >= $start
                                AND data_year <= $end
                          GROUP BY data_year
                          ORDER BY data_year ASC";
                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                $Rdata = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {

                    $Rdata[] = array(

                        "year" => $row["DATA_YEAR"],
                        "count" => $row["COUNT(*)"]

                    );

                }

                $Rdata_json = json_encode($Rdata);

            //Parking or Street
                $query = "SELECT data_year, COUNT(*)
                          FROM cargo_theft
                          WHERE (location_name = 'Parking/Drop Lot/Garage' or location_name = 'Highway/Road/Alley/Street/Sidewalk')
                                AND stolen_value >= $val
                                AND data_year >= $start
                                AND data_year <= $end
                          GROUP BY data_year
                          ORDER BY data_year ASC";
                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {

                    $data[] = array(

                        "year" => $row["DATA_YEAR"],
                        "count" => $row["COUNT(*)"]
                        
                    );

                }

                $Pdata_json = json_encode($data);

            //School Zones 
                $query = "SELECT data_year, COUNT(*)
                          FROM cargo_theft
                          WHERE (location_name LIKE '%School%')
                                AND stolen_value >= $val
                                AND data_year >= $start
                                AND data_year <= $end
                          GROUP BY data_year
                          ORDER BY data_year ASC";
                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {

                    $data[] = array(

                        "year" => $row["DATA_YEAR"],
                        "count" => $row["COUNT(*)"]

                    );

                }
        
                $SCdata_json = json_encode($data);

            //Close the Oracle connection and query
            oci_free_statement($statement);
            oci_close($connection);

        ?>

    </body>

</html>