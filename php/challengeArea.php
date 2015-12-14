<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      } 

      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'GET') {
            viewChallengeAreas();
      } else if ($request_type == 'POST') {
            createChallengeArea();
      } else if ($request_type == 'PUT') {
            updateChallengeArea();
      } else if ($request_type == 'DELETE') {
            deleteChallengeArea();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
 header(':', true, 401);
 }
 echo $response;
}

function viewChallengeAreas() {
      try{

            $query = "select ca.id, ca.name, ca.leader1_id, ca.leader2_id, u1.last_name as leader1LastName, 
            u1.first_name as leader1FirstName, u2.last_name as leader2LastName, u2.first_name as leader2FirstName 
              from challenge_area as ca, user as u1, user as u2 
              where ca.leader1_id = u1.id and ca.leader2_id = u2.id";         
            $results = executeQuery($query);

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function createChallengeArea() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $name = $request->name;
            $leader1_id = $request->leader1;
            $leader2_id = $request->leader2;
            
            $query = sprintf("insert into challenge_area(name, leader1_id, leader2_id) values ('%s', %d, %d)", $name, $leader1_id, $leader2_id);         
            $results = executeQuery($query);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function updateChallengeArea() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $name = $request->name;
            $id = $request->id;
            $leader1_id = $request->leader1;
            $leader2_id = $request->leader2; 

            $query = sprintf("update challenge_area set name='%s', leader1_id=%d, leader2_id=%d where id=%d", $name, $leader1_id, $leader2_id, $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteChallengeArea() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from challenge_area where id=%d", $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>