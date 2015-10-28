
<?php
// Create connection
function executeQuery($query) {
    $servername = "localhost";
    $username = "divya";
    $password = "password";
    $dbname = "practicedb";
    try {
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT password from user where email = 'divya.garg@berkeley.edu'"); 
        $stmt->execute();

        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();        
            return $row;
        }
        
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

?>