<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      } 

      $request_type = $_SERVER['REQUEST_METHOD'];

      if ($request_type == 'GET') {
            $userId = $_GET['id'];
            if ($userId != null) {
                  viewUser($userId);
            } else {
                viewUsers();  
          }
    } else if ($request_type == 'POST') {
      createUser();
} else if ($request_type == 'PUT') {
      updateUser();
} else if ($request_type == 'DELETE') {
      deleteUser();

}

} catch (Exception $e) {
 $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  header(':', true, 401);
 }
 echo $response;
}

function viewUsers() {
      try{

            $query = "select id, first_name as firstName, last_name as lastName, email from user";         
            $results = executeQuery($query);
            $response = json_encode($results);
            echo $response;
      } catch (Exception $e) {
       $response = $e->getMessage();
 }
}

function viewUser($userId) {
      try{

            $query = "select us.id, us.first_name as firstName, us.last_name as lastName, us.email,
             us.fax, us.role, us.phone, us.agency_id as agencyId, us.division_id as divisionId, 
             ag.name as agency from user as us, agency as ag where us.agency_id = ag.id and us.id=".$userId;          
            $results = executeQuery($query);
            $response = json_encode($results);
            echo $response;
      } catch (Exception $e) {
       $response = $e->getMessage();
 }
}

function createUser() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $email = $request->email;
            $firstName = $request->firstName;
            $lastName = $request->lastName;
            $phone = $request->phone;
            $role = $request->role;
            $fax = $request->fax;
            $pass = $request->password;
            $agencyId = $request->agencyId;
            $divisionId = $request->divisionId;

            // A higher "cost" is more secure but consumes more processing power
            $cost = 10;

            // Create a random salt
            // $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
            // echo json_encode($salt);

            // Prefix information about the hash so PHP knows how to verify it later.
            // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
            // $salt = sprintf("$2a$%02d$", $cost) . $salt;

            // Hash the password with the salt
            // $hash = crypt($pass, $salt);
            
            $query = sprintf("insert into user(first_name, last_name, email, password, phone, role, fax, last_activity, agency_id, division_id)
                 values ('%s','%s','%s','%s','%s','%s','%s', now(), %d, %d)",
                 $firstName, $lastName, $email, $pass, $phone, $role, $fax, $agencyId, $divisionId);   

            $results = executeQuery($query);
      } catch (Exception $e) {
           $response = $e->getMessage();
     }

}

function updateUser() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $email = $request->email;
            $firstName = $request->firstName;
            $lastName = $request->lastName;
            $phone = $request->phone;
            $role = $request->role;
            $fax = $request->fax;
            $id = $request->id;
            $agencyId = $request->agencyId;
            $divisionId = $request->divisionId;

            $query = sprintf("update user set email='%s', first_name='%s', last_name='%s', phone='%s', role='%s', fax='%s', last_activity=now(), agency_id=%d, division_id=%d where id=%d", $email, $firstName, $lastName, $phone, $role, $fax, $agencyId, $divisionId, $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteUser() {
      try{

            $id = $_GET['id'];

            $query = sprintf("delete from user where id=%d", $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>