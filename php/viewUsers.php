<?php
include "dbConnect.php";
try{
	 		
            $query = "select id as userId, firstName, lastName, email from user";         
            $results = executeQuery($query);

            $response = json_encode($results);
           echo $response;
            
            // if ($results['password'] === $pass) {
            // 	echo "success";
            // } else {
            // 	throw Exception("User not found");
            // }

	} catch (Exception $e) {
             $response = $e->getMessage();
    }
?>