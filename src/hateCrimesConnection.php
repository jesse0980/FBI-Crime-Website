<!DOCTYPE html>
<html>

    <body>

        <!-- User Input -->
        <form method="get" action=""><br>

            <!-- User selects the starting year the query will use -->
            <label for="start_year">Select start year:</label>
            <select name="start_year" id="start_year">

                <option value="" disabled selected hidden>1991</option> <!-- Default Value -->
                <option value="1991">1991</option>
                <option value="1992">1992</option>
                <option value="1993">1993</option>            
                <option value="1994">1994</option>
                <option value="1995">1995</option>
                <option value="1996">1996</option>
                <option value="1997">1997</option>
                <option value="1998">1998</option>
                <option value="1999">1999</option>
                <option value="2000">2000</option>
                <option value="2001">2001</option>
                <option value="2002">2002</option>
                <option value="2003">2003</option>
                <option value="2004">2004</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
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
                <option value="1991">1991</option>
                <option value="1992">1992</option>
                <option value="1993">1993</option>            
                <option value="1994">1994</option>
                <option value="1995">1995</option>
                <option value="1996">1996</option>
                <option value="1997">1997</option>
                <option value="1998">1998</option>
                <option value="1999">1999</option>
                <option value="2000">2000</option>
                <option value="2001">2001</option>
                <option value="2002">2002</option>
                <option value="2003">2003</option>
                <option value="2004">2004</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
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
            $start = 1991;
            $end = 2021;

            //Assign the user's input values to the start and end years
            if (isset($_GET['start_year'])) {

                $start = $_GET['start_year'];

            }
            if (isset($_GET['end_year'])) {

                $end = $_GET['end_year'];

            }

            //Query #6
            
            //African American
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-Black or African American'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";

                //Execute the query using the database
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                //Store the query result into an array
                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(

                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']

                    );

                }
                $json = json_encode($data);

                //Database query to retrieve the data goes here
                $data_array = json_decode($json, true);

                //Extract labels and data points from the data array
                $labels = [];
                $AAdata_points = [];
                foreach ($data_array as $row) {

                    $labels[] = $row['year'];
                    $AAdata_points[] = $row['Percent'];

                }
        
            //White
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-White'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";

                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(

                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']

                    );

                }
                $json = json_encode($data);

                $data_array = json_decode($json, true);

                $Wdata_points = [];
                foreach ($data_array as $row) {

                    $Wdata_points[] = $row['Percent'];

                }

            //Asian
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-Asian'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";

                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(

                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']

                    );

                }
                $json = json_encode($data);

                $data_array = json_decode($json, true);

                $Adata_points = [];
                foreach ($data_array as $row) {

                    $Adata_points[] = $row['Percent'];

                }

            //Hispanic
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-Hispanic or Latino'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";

                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(

                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']

                    );

                }
                $json = json_encode($data);

                $data_array = json_decode($json, true);

                $Hdata_points = [];
                foreach ($data_array as $row) {

                    $Hdata_points[] = $row['Percent'];

                }

            //Gay
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-Gay (Male)'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";

            
                $statement = oci_parse($connection, $query);
                oci_execute($statement);
    
                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(
    
                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']
    
                    );
    
                }
                $json = json_encode($data);
    
                $data_array = json_decode($json, true);
    
                $Gdata_points = [];
                foreach ($data_array as $row) {
    
                    $Gdata_points[] = $row['Percent'];
    
                }

            //Jewish
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-Jewish'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";
    
                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);
    
                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(
    
                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']
    
                    );
    
                }
                $json = json_encode($data);
    
                $data_array = json_decode($json, true);
    
                $Jdata_points = [];
                foreach ($data_array as $row) {
    
                    $Jdata_points[] = $row['Percent'];
    
                }

            //Muslim
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-Islamic (Muslim)'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";
    
                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);
    
                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(
    
                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']
    
                    );
    
                }
                $json = json_encode($data);
    
                $data_array = json_decode($json, true);
    
                $Mdata_points = [];
                foreach ($data_array as $row) {
    
                    $Mdata_points[] = $row['Percent'];
    
                }

            //Lesbian
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-Lesbian (Female)'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";
    
                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);
    
                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(
    
                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']
    
                    );
    
                }
                $json = json_encode($data);
    
                $data_array = json_decode($json, true);
    
                $Lesdata_points = [];
                foreach ($data_array as $row) {
    
                    $Lesdata_points[] = $row['Percent'];
    
                }

            //Anti Other-Race
                $query = "SELECT q.DATA_YEAR, q.Count/q2.Total as Percentage
                            FROM(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Count
                            FROM HATE_CRIME
                            WHERE BIAS_DESC = 'Anti-Other Race/Ethnicity/Ancestry'
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q
                            JOIN(
                            SELECT DATA_YEAR, COUNT(DATA_YEAR) as Total
                            FROM HATE_CRIME
                            GROUP BY DATA_YEAR
                            ORDER BY DATA_YEAR ASC
                            )q2
                            ON q.DATA_YEAR = q2.DATA_YEAR
                            WHERE q.DATA_YEAR >= $start AND q.DATA_YEAR <= $end";
    
                
                $statement = oci_parse($connection, $query);
                oci_execute($statement);
    
                $data = array();
                while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    
                    $data[] = array(
    
                        'year' => $row['DATA_YEAR'],
                        'Percent' => $row['PERCENTAGE']
    
                    );
    
                }
                $json = json_encode($data);
    
                $data_array = json_decode($json, true);
    
                $OTdata_points = [];
                foreach ($data_array as $row) {
    
                    $OTdata_points[] = $row['Percent'];
    
                }

            //Pie Chart Data
            $query = "SELECT BIAS_DESC, COUNT(BIAS_DESC) / (SELECT COUNT(DATA_YEAR) FROM HATE_CRIME) * 100 AS Percentage
                      FROM HATE_CRIME
                      GROUP BY BIAS_DESC
                      ORDER BY Percentage DESC
                      FETCH FIRST 10 ROWS ONLY";
            
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            $data = array();
            while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                
                $data[] = array(

                    'bias' => $row['BIAS_DESC'],
                    'Percent' => $row['PERCENTAGE']

                );

            }
            $json = json_encode($data);

            $data_array = json_decode($json, true);

            $Piedata_points = [];
            $Pielabels = [];
            foreach ($data_array as $row) {

                $Piedata_points[] = $row['Percent'];
                $Pielabels[] = $row['bias'];

            }

            //Close the Oracle connection and query
            oci_free_statement($statement);
            oci_close($connection);

        ?>

    </body>

</html>