<?php

$host = "localhost";                // Host: Is localhost because database hosted on the same place where PHP files are hosted
$dbname = "lefnica";             // Database name
$username = "root";              // Database username
$password = "root";                     // Database password    


    // Establish connection to MySQL database
    $conn = new mysqli($host, $username, $password, $dbname);


    // Check if connection established successfully
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    else {
        echo "Connected to mysql database. <br>";
    }
    
    // Get date and time variables
    date_default_timezone_set('America/Mexico_City');
    $d = date("Y-m-d");
    $t = date("H:i:s");
        
    // If values sent by NodeMCU code in Arduino are not empty then insert into MySQL database table

    if(!empty($_POST['sendval']) && !empty($_POST['sendval2']) ){
        $val = $_POST['sendval'];
        $val2 = $_POST['sendval2'];

        $sql = "INSERT INTO nodemcu(Temperatura,Humedad, Tiempo)  VALUES ('".$val."','".$val2."', '".$t."')"; 
        // nodemcu_table(val, val2, Date, Time)
        if ($conn->query($sql) === TRUE){
            echo "Values inserted in MySQL database table.";
        } 
        
        else{
            echo "Error inserting values in MySQL: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close MySQL connection
    $conn->close();

?>
