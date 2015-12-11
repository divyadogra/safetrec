<?php
include "dbConnect.php";

try {

      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'GET') {
            viewActions($_GET['challengeId']);
      } else if ($request_type == 'POST') {
            createStrategy();
      } else if ($request_type == 'PUT') {
            updateStrategy();
      } else if ($request_type == 'DELETE') {
            deleteStrategy();
      }
} catch (Exception $e) {
 $response = $e->getMessage();
}

function viewActions($challengeId) {
      try{

            $query = "select id, name, description from strategy where challenge_id =".$challengeId;               
            $results = executeQuery($query);

            for($i=0, $c = count($results); $i < $c; $i++) {
              $query = "select action.id, action.description, user.last_name as leaderLastName, 
                        user.first_name as leaderFirstName, agency.name as agencyName, action.status as actionStatus
                        from action, user, agency where action.lead_id = user.id and action.agency_id = agency.id and action.strategy_id=".$results[$i]['id'];
              $actionResults = executeQuery($query);        
              $results[$i]['actions'] = $actionResults;

            }

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
      }
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

function createAction() {
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

function updateAction() {
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

function deleteAction() {
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