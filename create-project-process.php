<?php
require_once("lib/session.php");
require_once("lib/mysqli.php");

$mysqli = get_mysqli_instance();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = <<<SQL
    INSERT INTO project (name, description, creator_id) 
    VALUES ("{$_POST['name']}", "{$_POST['desc']}", "{$_SESSION['uid']}")
SQL;

    if ($mysqli->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error insert into table: " . $mysqli->error;
        echo "<br>";
        echo $sql;
    }
}
?>