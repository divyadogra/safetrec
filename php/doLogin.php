<?php

include 'dbConnect.php';
try{
	 		$postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $email = $request->email;
            $pass = $request->password;
            
            $request = "SELECT * from user where email = '".$email."'";
            
            $results = executeQuery($request);
            
            if ($results[0]['password'] === crypt($pass, $results[0]['password'])) {
                session_start();
                $_SESSION['loggedInUser'] = $results[0];
            	echo "success";
            } else {
            	throw Exception("User not found");
            }

	} catch (Exception $e) {
             $response = $e->getMessage();
    }
?>