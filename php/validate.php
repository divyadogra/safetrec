<?php
try {
	session_start();
	if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      } 
    echo json_encode($_SESSION['loggedInUser']);
} catch (Exception $e) {
 $response = $e->getMessage();
 if ($response == 'Invalid Login') {
  header(':', true, 401);
 }
 echo $response;
}

?>