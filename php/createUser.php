<?php
include "dbConnect.php";
try{
	 		$postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $email = $request->email;
            $firstName = $request->firstName;
            $lastName = $request->lastName;
            $pass = $request->password;
            // A higher "cost" is more secure but consumes more processing power
            $cost = 10;


            // Create a random salt
            $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
            // echo json_encode($salt);

            // Prefix information about the hash so PHP knows how to verify it later.
            // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
            $salt = sprintf("$2a$%02d$", $cost) . $salt;

           
            // // Hash the password with the salt
            $hash = crypt($pass, $salt);
            
            $query = sprintf("insert into user(firstName, lastName, email, password) values ('%s','%s','%s','%s')",
            					$firstName, $lastName, $email, $hash);         
            $results = executeQuery($query);
           
            
            // if ($results['password'] === $pass) {
            // 	echo "success";
            // } else {
            // 	throw Exception("User not found");
            // }

	} catch (Exception $e) {
             $response = $e->getMessage();
    }
?>