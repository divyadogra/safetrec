<?php
include "dbConnect.php";
try{
            if (!isset($_SESSION['loggedInUser'])) {
                throw new Exception("Invalid Login");
            } 

	 		$postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $email = $request->email;
            $firstName = $request->firstName;
            $lastName = $request->lastName;
            $phone = $request->phone;
            $role = $request->role;
            $fax = $rquest->fax;
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
            
            $query = sprintf("insert into user(firstName, lastName, email, password, phone, role, fax, last_activity)
                               values ('%s','%s','%s','%s','%s','%s','%s', now())",
                              $firstName, $lastName, $email, $hash, $phone, $role, $fax);   
                                    
            $results = executeQuery($query);
           
            
            // if ($results['password'] === $pass) {
            // 	echo "success";
            // } else {
            // 	throw Exception("User not found");
            // }

	} catch (Exception $e) {
        http_response_code(401);
             $response = $e->getMessage();
    }
?>