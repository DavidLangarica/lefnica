<?php

$host = "localhost";
$username = "root";
$password = "root";
$dbname = "lefnica";

// Create connection
$conn = new mysqli($host,$username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM nodemcu;";
$result = $conn->query($sql);

$rows = mysqli_num_rows ( $result );

echo ($rows);

$conn->close();
?>