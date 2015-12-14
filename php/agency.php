<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      } 

      $request_type = $_SERVER['REQUEST_METHOD'];
    
      if ($request_type == 'GET') {
            viewAgencies();
      } else if ($request_type == 'POST') {
            createAgency();
      } else if ($request_type == 'PUT') {
            updateAgency();
      } else if ($request_type == 'DELETE') {
            deleteAgency();

      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  http_response_code(401);
 }
 echo $response;
}

function viewAgencies() {
      try{

            $query = "select id, name, description from agency";         
            $results = executeQuery($query);
            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
 }
}

function createAgency() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $name = $request->name;
            $description = $request->description;
            
            $query = sprintf("insert into agency(name, description) values ('%s', '%s')", $name, $description);         
            $results = executeQuery($query);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function updateAgency() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $name = $request->name;
            $description = $request->description;
            $id = $request->id;

            $query = sprintf("update agency set name='%s', description='%s' where id=%d", $name, $description, $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteAgency() {
      try{
            
            $id = $_GET['id'];

            $query = sprintf("delete from agency where id=%d", $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

     } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>