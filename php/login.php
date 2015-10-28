<?php

include 'dbConnect.php';
try{
	 		$postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $email = $request->email;
            $pass = $request->password;
            
            $request = "SELECT password from user where email = '".$email."'";
            
            $results = executeQuery($request);
            
            if ($results['password'] === crypt($pass, $results['password'])) {
            	echo "success";
            } else {
            	throw Exception("User not found");
            }

	} catch (Exception $e) {
             $response = $e->getMessage();
    }
?>