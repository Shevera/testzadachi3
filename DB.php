<?php


$servername = "localhost";
$usernames = "root";
$password = "";
$database = "testzad3";

// Create connection
$conn = mysqli_connect($servername, $usernames, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

