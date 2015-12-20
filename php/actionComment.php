<?php
include "dbConnect.php";

try {
      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  

      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == 'GET') {
            viewActionComments($_GET['actionId']);
      } else if ($request_type == 'POST') {
            createActionComment();
      } else if ($request_type == 'PUT') {
            updateActionComment();
      } else if ($request_type == 'DELETE') {
            deleteActionComment();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  header(':', true, 401);
 }
 echo $response;
}

function viewActionComments($actionId) {
      try{

            $query = "select id, author, comment_date, comment from action_comment where action_id =".$actionId;         
            $results = executeQuery($query);

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function createActionComment() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $author = $request->author;
            $comment = $request->comment;
            $actionId = $request->actionId;
            
            $query = sprintf("insert into action_comment (author, comment_date, comment, action_id) values ('%s', now(), '%s', %d)", $author, $comment, $actionId);         
            $results = executeQuery($query);
            $response = json_encode($results);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function updateActionComment() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $author = $request->author;
            $comment = $request->comment;
            $id = $request->id;

            $query = sprintf("update action_comment set author='%s', comment_date=now(), comment='%s' where id=%d", $author, $comment, $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteActionComment() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from action_comment where id=%d", $id);         
            $results = executeQuery($query);
            $response = json_encode($results);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>