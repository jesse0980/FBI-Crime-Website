<!DOCTYPE html>
<html>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <head>

        <link rel="stylesheet" href="webStyle.css">
        <title>Total Tuples</title>
        <h1>The Total Amount of Tuples (Rows of Data) in the Oracle Database</h1>
        
    </head>

    <body>

        <?php

            //Connect to Oracle Database
            $connection = oci_connect($username = 'jmclaren',
            $password = 'IwvVM5yAatIjuuWV5h2A74EZ',
            $connection_string = '//oracle.cise.ufl.edu/orcl');

            if (!$connection) {

                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

            }

            //Tuple Groups
            $total = 0;
            $cTotal = 0;
            $hTotal = 0;
            $tTotal = 0;

            //Cargo Theft
            $query = "SELECT COUNT(data_year) FROM Cargo_Theft";

            //Execute the query using the database
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            //Store the Result
            while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                
                foreach($row as $item) {

                    $cTotal = $item;

                }

            }
            $total += $cTotal;

            //Hate Crime
            $query = "SELECT COUNT(data_year) FROM Hate_Crime";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                
                foreach($row as $item) {

                    $hTotal = $item;

                }

            }
            $total += $hTotal;

            //Human Trafficking
            $query = "SELECT COUNT(data_year) FROM Human_Trafficking";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
                
                foreach($row as $item) {

                    $tTotal = $item;

                }

            }
            $total += $tTotal;

            //Close the Oracle connection and query
            oci_free_statement($statement);
            oci_close($connection);

        ?>

        <!-- Print the Tuple Amount for Each Database -->
        <p><b>Total Amount of Tuples Oracle Database: <?php echo $total ?></b></p>
        <p>Total Amount of Tuples in Cargo Theft Database: <?php echo $cTotal ?></p>
        <p>Total Amount of Tuples in Hate Crime Database: <?php echo $hTotal ?></p>
        <p>Total Amount of Tuples in Human Trafficking Database: <?php echo $tTotal ?></p>

    </body>

    <!-- Button to return to the home page -->
    <div>

        <button onclick="window.location.href = 'home.php';">Home</button>

    </div>

</html>