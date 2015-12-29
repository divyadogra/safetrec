<?php

function getAccessToken() {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "safetrec";
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
        http_response_code(401);
        echo "Connection failed: " . $e->getMessage();
    }

    $url = "https://app.box.com/api/oauth2/token";
    try {

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=refresh_token&refresh_token=".$refreshtoken1."&client_id=w4hcd168mi2g8la7zds7of3prvjt1dpa&client_secret=dlJ08XXC3YuiO3CJoTK33RxQhy3npOa5");
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

        $stmt = $conn->prepare("UPDATE refreshtoken SET REFRESH_TOKEN='".$refreshtoken1."' where id=1");
        $stmt->execute();

        $conn = null;

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    return  $accessToken;
}

?>