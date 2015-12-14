<?php
try {
	session_start();
	unset($_SESSION['loggedInUser']);
	session_unset(); 
	session_destroy();
} catch (Exception $e) {
}

?>