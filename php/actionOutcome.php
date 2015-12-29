<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  

      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'GET') {
            viewActionOutcomes($_GET['actionId']);
      } else if ($request_type == 'POST') {
            createActionOutcome();
      } else if ($request_type == 'PUT') {
            updateActionOutcome();
      } else if ($request_type == 'DELETE') {
            deleteActionOutcome();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  header(':', true, 401);
 }
 echo $response;
}

function viewActionOutcomes($actionId) {
      try{

            $query = "select id, description from action_outcome where action_id =".$actionId;         
            $results = executeQuery($query);

            for($i=0, $c = count($results); $i < $c; $i++) {
              $query = "select id, author, DATE_FORMAT(comment_date, '%m/%d/%Y %h:%i') as comment_date, comment, file_name as fileName, file_id as fileId  from action_outcome_comment where action_outcome_id =".$results[$i]['id'];; 
              $actionOutcomeCommentResults = executeQuery($query);        
              $results[$i]['comments'] = $actionOutcomeCommentResults;
            }

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
      }

}

function createActionOutcome() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $description = $request->description;
            $actionId = $request->actionId;
            
            $query = sprintf("insert into action_outcome (description, action_id) values ('%s', %d)", $description, $actionId);         
            $results = executeQuery($query);
            $response = json_encode($results);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function updateActionOutcome() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $description = $request->description;
            $id = $request->id;

            $query = sprintf("update action_outcome set description='%s' where id=%d", $description, $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteActionOutcome() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from action_outcome where id=%d", $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>