<?php
include "dbConnect.php";

try {

      var request_type = $_SERVER['REQUEST_METHOD'];
      if (request_type == 'GET') {
            viewChallengeAreas();
      } else if (request_type == 'POST') {
            createChallengeAreas();
      } else if (request_type == 'PUT') {
            updateChallengeAreas();
      } else if (request_type == 'DELETE') {
            deleteChallengeAreas();
      }
} catch (Exception $e) {
 $response = $e->getMessage();
}

function viewChallengeAreas() {
      try{

            $query = "select id, name, leader1_id as leader1, leader2_id as leader2 from challenge_area";         
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

            $query = sprintf("update callenge_area set name='%s', leader1_id=%d, leader2_id=%d where id=%d", $name, $leader1_id, $leader2_id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteChallengeArea() {
      try{
            $deletedata = file_get_contents("php://input");
            $request = json_decode($deletedata);
            $id = $request->id;

            $query = sprintf("delete from challenge_area where id=%d", $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>