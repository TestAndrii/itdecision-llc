<?php

    $mysql_server_name = "mysql:3306";
    $mysql_username = "dev";
    $mysql_password = "dev";
    $mysql_database = "test";

$mysqli = new mysqli($mysql_server_name, $mysql_username, $mysql_password, $mysql_database);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    die();
}

?>