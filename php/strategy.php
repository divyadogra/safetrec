<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  
      
      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'POST') {
            createStrategy();
      } else if ($request_type == 'PUT') {
            updateStrategy();
      } else if ($request_type == 'DELETE') {
            deleteStrategy();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  http_response_code(401);
 }
 echo $response;
}

function createStrategy() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $name = $request->name;
            $description = $request->description;
            $challenge_id = $request->challengeId;
            
            $query = sprintf("insert into strategy(name, description, challenge_id) values ('%s', '%s', %d)", $name, $description, $challenge_id);         
            $results = executeQuery($query);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }
}

function updateStrategy() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $name = $request->name;
            $id = $request->id;
            $description = $request->description;

            $query = sprintf("update strategy set name='%s', description='%s' where id=%d", $name, $description, $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteStrategy() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from strategy where id=%d", $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>