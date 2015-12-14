<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  

      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'GET') {
            viewDivisions($_GET['agencyId']);
      } else if ($request_type == 'POST') {
            createDivision();
      } else if ($request_type == 'PUT') {
            updateDivision();
      } else if ($request_type == 'DELETE') {
            deleteDivision();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
 header(':', true, 401);
 }
 echo $response;
}

function viewDivisions($agencyId) {
      try{

            $query = "select id, name, description from division where agency_id =".$agencyId;         
            $results = executeQuery($query);

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function createDivision() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $name = $request->name;
            $description = $request->description;
            $agencyId = $request->agencyId;
            
            $query = sprintf("insert into division(name, description, agency_id) values ('%s', '%s', %d)", $name, $description, $agencyId);         
            $results = executeQuery($query);
            $response = json_encode($results);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function updateDivision() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $name = $request->name;
            $description = $request->description;
            $id = $request->id;

            $query = sprintf("update division set name='%s', description='%s' where id=%d", $name, $description, $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteDivision() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from division where id=%d", $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>