<?php
include "dbConnect.php";
try{
	 		if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }   
            $query = "select id as userId, firstName, lastName, email, phone, fax, role from user";         

            $results = executeQuery($query);

            $response = json_encode($results);
           echo $response;
            
            // if ($results['password'] === $pass) {
            // 	echo "success";
            // } else {
            // 	throw Exception("User not found");
            // }

	} catch (Exception $e) {
   header(':', true, 401);
             $response = $e->getMessage();
    }
?>