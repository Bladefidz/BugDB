<?php

/**
 * Get instance of mysqli
 * @return [type] [description]
 */
function get_mysqli_instance()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bug_database";

    // Create mysqliection
    $mysqli = new mysqli($servername, $username, $password, $dbname);
    // Check mysqliection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } 

    // Check mysqliection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    return $mysqli;
}

/**
 * Collect the query result until reach the limit.
 * If limit no set, collect the query result until stack become empty.
 * @param instance $result Instance of query's object
 * @param string $fetch_mode Fetch mode (assoc, row)
 * @param string $limit Result limitation
 * @return array Collection set
 */
function collect_query_result($result, $fetch_mode = "assoc", $limit = NULL)
{
    $collection = new SplFixedArray($limit);
    $counter = 0;
    
    if ($fetch_mode = "assoc") {
        while ($counter < $limit && $row = $result->fetch_assoc()) {
            $collection[$counter] = $row;
            $counter += 1;
        }
    } elseif ($fetch_mode = "row") {
        while ($counter < $limit && $row = $result->fetch_row()) {
            $collection[$counter] = $row;
            $counter += 1;
        }
    } elseif ($fetch_mode = "array") {
        while ($counter < $limit && $row = $result->fetch_array()) {
            $collection[$counter] = $row;
            $counter += 1;
        }
    }

    return $collection;
}
?>