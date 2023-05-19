<!DOCTYPE html>
<html>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <head>

        <title>PHP Example</title>
        <h1>Number of Hate Crimes by State</h1>
        <canvas id="myChart"></canvas>

    </head>

    <body>
        

        <?php

            $connection = oci_connect($username = 'jmclaren',
                                      $password = 'IwvVM5yAatIjuuWV5h2A74EZ',
                                      $connection_string = '//oracle.cise.ufl.edu/orcl');

            if (!$connection) {
                
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            
            }

            //Florida
            $query = "SELECT DATA_YEAR, COUNT(DATA_YEAR) AS Count FROM HATE_CRIME WHERE STATE_NAME = 'Florida' GROUP BY DATA_YEAR ORDER BY DATA_YEAR ASC";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $data = array();
            while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                
                $data[] = array(

                    'year' => $row['DATA_YEAR'],
                    'count' => $row['COUNT']

                );

            }
            $json = json_encode($data);

            // Your database query to retrieve the data goes here
            $data_array = json_decode($json, true);

            // Extract labels and data points from the data array
            $labels = [];
            $data_points = [];
            foreach ($data_array as $row) {

                $labels[] = $row['year'];
                $FLdata_points[] = $row['count'];

            }

            //Texas
            $query = "SELECT DATA_YEAR, COUNT(DATA_YEAR) AS Count FROM HATE_CRIME WHERE STATE_NAME = 'Texas' GROUP BY DATA_YEAR ORDER BY DATA_YEAR ASC";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $data = array();
            while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                
                $data[] = array(

                    'year' => $row['DATA_YEAR'],
                    'count' => $row['COUNT']

                );

            }
            $json = json_encode($data);

            // Your database query to retrieve the data goes here
            $data_array = json_decode($json, true);

            // Extract labels and data points from the data array
            $TXdata_points = [];
            foreach ($data_array as $row) {

                if ($row['year'] != 1991){

                    $TXdata_points[] = $row['count'];

                }

            }

            //California
            $query = "SELECT DATA_YEAR, COUNT(DATA_YEAR) AS Count FROM HATE_CRIME WHERE STATE_NAME = 'California' GROUP BY DATA_YEAR ORDER BY DATA_YEAR ASC";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $data = array();
            while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                
                $data[] = array(

                    'year' => $row['DATA_YEAR'],
                    'count' => $row['COUNT']

                );

            }
            $json = json_encode($data);

            // Your database query to retrieve the data goes here
            $data_array = json_decode($json, true);

            // Extract labels and data points from the data array
            $CAdata_points = [];
            foreach ($data_array as $row) {

                if ($row['year'] != 1991){

                    $CAdata_points[] = $row['count'];

                }

            }

            //New York
            $query = "SELECT DATA_YEAR, COUNT(DATA_YEAR) AS Count FROM HATE_CRIME WHERE STATE_NAME = 'New York' GROUP BY DATA_YEAR ORDER BY DATA_YEAR ASC";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);
            $data = array();
            while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                
                $data[] = array(

                    'year' => $row['DATA_YEAR'],
                    'count' => $row['COUNT']
                    
                );

            }
            $json = json_encode($data);

            // Your database query to retrieve the data goes here
            $data_array = json_decode($json, true);

            // Extract labels and data points from the data array
            $NYdata_points = [];
            foreach ($data_array as $row) {
                if ($row['year'] != 1991){
                    $NYdata_points[] = $row['count'];
                }
            }

            oci_free_statement($statement);
            oci_close($connection);

        ?>

    </body>

</html>