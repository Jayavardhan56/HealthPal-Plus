<?php
$host = "healthpal-db.cjmuom08yywe.us-east-1.rds.amazonaws.com";
$username = "admin";              // or the username you set
$password = "healthpal-aws";       // use the password you created
$dbname = "healthpal";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

