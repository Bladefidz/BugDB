<?php

if (session_status() == "PHP_SESSION_DISABLED ") {
    session_start();
}

if (!isset($_SESSION['uid'])) {
    $_SESSION['uid'] = 1;
    $_SESSION["uname"] = "beta";
}

?>