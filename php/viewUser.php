<?php
include "dbConnect.php";
try{
            if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  
	 		$postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $userId = $request->userId;
            
            $query = "select id as userId, firstName, lastName, email, phone, fax, role from user where id=".$userId;         
           
            $results = executeQuery($query);
            $response = json_encode($results);
           echo $response;

	} catch (Exception $e) {
    http_response_code(401);
             $response = $e->getMessage();
    }
?>