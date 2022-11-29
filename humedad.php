<?php

$username = "root";
$password = "root";
$dbname = "lefnica";

// Create connection
$conn = new mysqli('',$username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT Tiempo, Humedad FROM nodemcu";
$result = $conn->query($sql);

if ($result-> num_rows > 0) {
    // output data of each row
	$obj = array();
    while($row = $result->fetch_assoc()) {
		$element = array($row["Tiempo"],$row["Humedad"]);
       	array_push($obj,$element);
	}
	echo json_encode($obj);
} else {
    echo "0 results";
}

$conn->close();
?>



