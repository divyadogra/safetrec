<?php

function executeQuery($query) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "safetrec";
    try {
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($query); 
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 

        $rows = [];
        
        while ($row = $stmt->fetch()) {
             array_push($rows, $row);
        } 

        // if (count($rows) == 1) {
        //     return $rows[0];
        // } 
        return $rows;
        
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}
?>