<?php
require_once("lib/session.php");
require_once("lib/mysqli.php");
require_once("lib/image.php");

$mysqli = get_mysqli_instance();

if ($_SERVER['REQUEST_METHOD'] == "POST" 
    && isset($_GET["pid"]) 
    && isset($_SESSION["uid"])
) {
    if (upload_image($_FILES['photo'], "images")) {
        move_uploaded_file($_FILES['photo']['tmp_name'], "images/{$_FILES['photo']['name']}");
        $sql = <<<SQL
            INSERT INTO bug (title, description, link, photo, project_id, user_id) 
            VALUES ("{$_POST['name']}", "{$_POST['desc']}", "{$_POST['link']}", 
                "{$_FILES['photo']['name']}", "{$_GET['pid']}", "{$_SESSION['uid']}")
SQL;
    } else {
        $sql = <<<SQL
            INSERT INTO bug (title, description, link, project_id, user_id) 
            VALUES ("{$_POST['name']}", "{$_POST['desc']}", "{$_POST['link']}",
                "{$_GET['pid']}", "{$_SESSION['uid']}")
SQL;
    }

    if ($mysqli->query($sql) === TRUE) {
        $mysqli->close();
        header("Location: bugs.php?pid={$_GET['pid']}");
    } else {
        die($mysqli->error);
    }
} else {
    die("Forgot parameter pid or you not logged in");
}
?>