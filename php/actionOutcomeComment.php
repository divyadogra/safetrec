<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  

      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'GET') {
            viewActionOutcomeComments($_GET['actionOutcomeId']);
      } else if ($request_type == 'POST') {
            createActionOutcomeComment();
      } else if ($request_type == 'PUT') {
            updateActionOutcomeComment();
      } else if ($request_type == 'DELETE') {
            deleteActionOutcomeComment();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  header(':', true, 401);
 }
 echo $response;
}

function viewActionOutcomeComments($actionOutcomeId) {
      try{

            $query = "select id, author, comment_date, comment from action_outcome_comment where action_outcome_id =".$actionOutcomeId;         
            $results = executeQuery($query);

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function createActionOutcomeComment() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $author = $request->author;
            $comment = $request->comment;
            $actionOutcomeId = $request->actionOutcomeId;
            $fileName = $request->fileName;
            $fileId = $request->fileId;

            
            $query = sprintf("insert into action_outcome_comment (author, comment_date, comment, action_outcome_id, file_name, file_id) 
              values ('%s', now(), '%s', %d, '%s', '%s')", $author, $comment, $actionOutcomeId, $fileName, $fileId);         
            $results = executeQuery($query);
            $response = json_encode($results);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function deleteActionOutcomeComment() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from action_outcome_comment where id=%d", $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>