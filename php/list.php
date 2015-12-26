<?php
include "refreshToken.php";

session_start();
if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      }  

$accessToken = getAccessToken();

$url = "https://api.box.com/2.0/folders/0";
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$accessToken
    ));
    $response = json_encode(curl_exec($ch));
    curl_close($ch);
}catch(Exception $e) {
    $response = $e->getMessage();
}
?>