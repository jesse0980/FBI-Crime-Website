<?php

    $connection = oci_connect($username = '',
                            $password = '',
                            $connection_string = '//oracle.cise.ufl.edu/orcl');
    if (!$connection) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    else {
        echo "Connected to Oracle!";
    }

    $query = 'SELECT * FROM country';
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    echo "<table border='1'>\n";
        $ncols = oci_num_fields($statement);
            echo "<tr>\n";
                for ($i = 1; $i <= $ncols; ++$i) {
                    $colname = oci_field_name($statement, $i);
                    echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
                }
            echo "</tr>\n";

        while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
            echo "<tr>\n";
                foreach ($row as $item) {
                    echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                }
            echo "</tr>\n";
        }
    echo "</table>\n";

    oci_free_statement($statement);
    oci_close($connection);
?>
