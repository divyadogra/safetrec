<?php
include "dbConnect.php";
try{
	 		$postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $userId = $request->userId;
            
            $query = "select id as userId, firstName, lastName, email, phone, fax, role from user where id=".$userId;         
           
            $results = executeQuery($query);
            $response = json_encode($results);
           echo $response;

	} catch (Exception $e) {
             $response = $e->getMessage();
    }
?>