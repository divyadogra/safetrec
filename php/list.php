<?php
$url = "https://api.box.com/2.0/folders/0";

$servername = "localhost";
$username = "divya";
$password = "password";
$dbname = "practicedb";
$refreshtoken1 = null;
$accesstoken = null;
// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT REFRESH_TOKEN FROM refreshtoken");
    $stmt->execute();

    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row = $stmt->fetch();
    $refreshtoken1 = $row['REFRESH_TOKEN'];

    $conn = null;

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$url = "https://app.box.com/api/oauth2/token";
try {

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=refresh_token&refresh_token=".$refreshtoken1."&client_id=ev2m34bide0g84u0ybcfan9mj36xe9uv&client_secret=vyzSxP1tWPhlA46lozwWqwso6RMstCja");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $myResponse = curl_exec($ch);
    $json_a = json_decode($myResponse, true);
    $accessToken = $json_a['access_token'];
    $refreshtoken1 = $json_a['refresh_token'];
    curl_close($ch);
    
} catch (Exception $e) {
    $response = $e->getMessage();
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("UPDATE refreshtoken SET REFRESH_TOKEN='".$refreshtoken1."'");
    $stmt->execute();

    $conn = null;

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

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