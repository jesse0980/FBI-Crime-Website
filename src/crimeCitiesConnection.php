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

            <!-- User inputs the percentage greater than the average crime rate the query will use -->
            <label for="percent">Enter Percentage:</label>
            <input type="number" id="percent" name="percent" placeholder=20 min=0><br>

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

            //Set default values to the percent, start year, and end year in case the user does not provide any input
            $percent = 1.2;
            $start = 2013;
            $end = 2021;

            //Assign the user's input values to the percentage, start year, and end year
            if (isset($_GET['percent']) && $_GET['percent'] != "") {

                $percent = 1 + ($_GET['percent'] / 100);

            }
            if (isset($_GET['start_year'])) {

                $start = $_GET['start_year'];

            }
            if (isset($_GET['end_year'])) {

                $end = $_GET['end_year'];

            }

            //Query #2
            $query = "WITH avgCrimes(average_crime_perYear) AS 
                      (
                          SELECT AVG(crimes_per_year)
                          FROM 
                          (
                              SELECT pub_agency_name,(cargo_count + hate_count + trafficking_count)/9 AS crimes_per_year
                              FROM 
                              (
                                  SELECT pub_agency_name, COUNT(*) AS cargo_count
                                  FROM cargo_theft
                                  WHERE agency_type_name = 'City' 
                                        AND data_year >= $start 
                                        AND data_year <= $end
                                  GROUP BY pub_agency_name
                              ),
                              (
                                  SELECT location_name, COUNT(*) AS hate_count
                                  FROM hate_crime
                                  WHERE agency_type_name = 'City' 
                                        AND data_year >= $start 
                                        AND data_year <= $end
                                  GROUP BY location_name
                              ),
                              (
                                  SELECT agency_name, COUNT(*) AS trafficking_count
                                  FROM human_trafficking
                                  WHERE agency_type = 'City' 
                                        AND data_year >= $start 
                                        AND data_year <= $end
                                  GROUP BY agency_name
                              )
                              WHERE pub_agency_name = location_name 
                                    AND pub_agency_name = agency_name
                          )
                      )
                      SELECT pub_agency_name, crimes_per_year
                      FROM
                      (
                          SELECT pub_agency_name, (cargo_count + hate_count + trafficking_count) AS total_crime_count, (cargo_count + hate_count + trafficking_count)/9 AS crimes_per_year
                          FROM 
                          (
                              SELECT pub_agency_name, COUNT(*) AS cargo_count
                              FROM cargo_theft
                              WHERE agency_type_name = 'City' 
                                    AND data_year >= $start 
                                    AND data_year <= $end
                              GROUP BY pub_agency_name
                          ),
                          (
                              SELECT location_name, COUNT(*) AS hate_count
                              FROM hate_crime
                              WHERE agency_type_name = 'City' 
                                    AND data_year >= $start 
                                    AND data_year <= $end
                              GROUP BY location_name
                          ),
                          (
                              SELECT agency_name, COUNT(*) AS trafficking_count
                              FROM human_trafficking
                              WHERE agency_type = 'City' 
                                    AND data_year >= $start 
                                    AND data_year <= $end
                              GROUP BY agency_name
                          )
                          WHERE pub_agency_name = location_name 
                                AND pub_agency_name = agency_name
                      ), avgCrimes
                      WHERE crimes_per_year > (avgCrimes.average_crime_perYear * $percent)
                      ORDER BY crimes_per_year DESC";

            //Execute the query using the database
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            //Store the query result into an array
            $data = array();
            while ($row = oci_fetch_assoc($statement)) {

                $data[] = array(

                    'pubNames' => $row['PUB_AGENCY_NAME'],
                    'avgCrime' => $row['CRIMES_PER_YEAR'],

                );

            }

            $data_json = json_encode($data);

            //Close the Oracle connection and query
            oci_free_statement($statement);
            oci_close($connection);

        ?>

    </body>

</html>