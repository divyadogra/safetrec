<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  

      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'GET') {
            viewActionOutputComments($_GET['actionOutputId']);
      } else if ($request_type == 'POST') {
            createActionOutputComment();
      } else if ($request_type == 'PUT') {
            updateActionOutputComment();
      } else if ($request_type == 'DELETE') {
            deleteActionOutputComment();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  header(':', true, 401);
 }
 echo $response;
}

function viewActionOutputComments($actionOutputId) {
      try{

            $query = "select id, author, comment_date, comment from action_output_comment where action_output_id =".$actionOutputId;         
            $results = executeQuery($query);

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function createActionOutputComment() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $author = $request->author;
            $comment = $request->comment;
            $actionOutputId = $request->actionOutputId;
            $fileName = $request->fileName;
            $fileId = $request->fileId;
            
            $query = sprintf("insert into action_output_comment (author, comment_date, comment, action_output_id, file_name, file_id) 
              values ('%s', now(), '%s', %d, '%s', '%s')", $author, $comment, $actionOutputId, $fileName, $fileId);         
            $results = executeQuery($query);
            $response = json_encode($results);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function deleteActionOutputComment() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from action_output_comment where id=%d", $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>