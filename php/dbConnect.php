<?php

function executeQuery($query) {
    $servername = "localhost;3306";
    $username = "divya";
    $password = "password";
    // $port = "3300";
    $dbname = "safetrec";
    try {
        
        $conn = new PDO("mysql:host=$servername;port=;dbname=$dbname", $username, $password);
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