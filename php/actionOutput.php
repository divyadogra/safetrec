<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  

      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'GET') {
            viewActionOutput($_GET['actionId']);
      } else if ($request_type == 'POST') {
            createActionOutput();
      } else if ($request_type == 'PUT') {
            updateActionOutput();
      } else if ($request_type == 'DELETE') {
            deleteActionOutput();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  header(':', true, 401);
 }
 echo $response;
}

function viewActionOutput($actionId) {
      try{

            $query = "select id, description from action_output where action_id =".$actionId;         
            $results = executeQuery($query);

            for($i=0, $c = count($results); $i < $c; $i++) {
              $query = "select id, author, DATE_FORMAT(comment_date, '%m/%d/%Y %h:%i') as comment_date, comment, file_name as fileName, file_id as fileId from action_output_comment where action_output_id =".$results[$i]['id'];; 
              $actionOutputCommentResults = executeQuery($query);        
              $results[$i]['comments'] = $actionOutputCommentResults;
            }

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function createActionOutput() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $description = $request->description;
            $actionId = $request->actionId;
            
            $query = sprintf("insert into action_output (description, action_id) values ('%s', %d)", $description, $actionId);         
            $results = executeQuery($query);
            $response = json_encode($results);

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function updateActionOutput() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $description = $request->description;
            $id = $request->id;

            $query = sprintf("update action_output set description='%s' where id=%d", $description, $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteActionOutput() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from action_output where id=%d", $id);         
            $results = executeQuery($query);
            $response = json_encode($results);
      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>