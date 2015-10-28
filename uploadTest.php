<?php
  phpinfo();
//  $token = "WgfElHJY6oCBHEPEuPo7qh33SizanSxL";
//  $servername = "localhost";
// $username = "divya";
// $password = "password";
// $dbname = "practicedb";
// $refreshtoken1 = null;
// $accesstoken = null;
// // Create connection
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $stmt = $conn->prepare("SELECT REFRESH_TOKEN FROM refreshtoken");
//     $stmt->execute();

//     // set the resulting array to associative
//     $stmt->setFetchMode(PDO::FETCH_ASSOC);
//     $row = $stmt->fetch();
//     $refreshtoken1 = $row['REFRESH_TOKEN'];

//     $conn = null;

// } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }

// $url = "https://app.box.com/api/oauth2/token";
// try {

//     $ch = curl_init();
//     curl_setopt($ch,CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=refresh_token&refresh_token=".$refreshtoken1."&client_id=ev2m34bide0g84u0ybcfan9mj36xe9uv&client_secret=vyzSxP1tWPhlA46lozwWqwso6RMstCja");
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $myResponse = curl_exec($ch);
//     $json_a = json_decode($myResponse, true);
//     $accessToken = $json_a['access_token'];
//     $refreshtoken1 = $json_a['refresh_token'];
//     curl_close($ch);
    
// } catch (Exception $e) {
//     $response = $e->getMessage();
// }

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $stmt = $conn->prepare("UPDATE refreshtoken SET REFRESH_TOKEN='".$refreshtoken1."'");
//     $stmt->execute();

//     $conn = null;

// } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }
//   // function refreshToken() {
//   //       $url = "https://app.box.com/api/oauth2/token";
//   //       try {

//   //           $ch = curl_init();

//   //           curl_setopt($ch,CURLOPT_URL, $url);
//   //           curl_setopt($ch, CURLOPT_POSTFIELDS, array(
//   //               'grant_type'=> 'refresh_token', 
//   //               'refresh_token'=>'KKd3dlzUSUaLq76lmfSTZRxs1zuaJiYWamceNI9GUoR5Bcjim8jOuqIHN6TWZAfw',
//   //               'client_id'=>'ev2m34bide0g84u0ybcfan9mj36xe9uv',
//   //               'client_secret'=>'vyzSxP1tWPhlA46lozwWqwso6RMstCja'
//   //           ));
//   //           // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//   //           // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//   //           $response = curl_exec($ch);
//   //           echo $response;
//   //           curl_close($ch);
//   //       } catch (Exception $e) {
//   //           $response = $e->getMessage();
//   //       }
//   //   }

    
//     if (isset($_POST['btnUpload'])) {
//         $url = "https://upload.box.com/api/2.0/files/content";

//         // refreshToken();
        
//         $file_upload = $_FILES['file']['tmp_name'];
//         $json = json_encode(array(
//                                 'name' => $_FILES['file']['name'], 
//                                 'parent' => array('id' => 0)
//                             ));
//         $fields = array(
//                       'attributes' => $json,
//                       'file'=>new CurlFile($_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['name'])
//                   );

//         try {

//             $ch = curl_init();

//             curl_setopt($ch,CURLOPT_URL, $url);
//             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                 'Authorization: Bearer '.$accessToken, 
//                 'Content-Type:multipart/form-data'
//             ));
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//             $response = curl_exec($ch);
//             curl_close($ch);
//             header('Location: index.php');
           
    
//         } catch (Exception $e) {
//             $response = $e->getMessage();
//         }
        
//     }
       

//     if(isset($_POST['listFiles'])) {
//         $url = "https://api.box.com/2.0/folders/0";
//         try {
//             $ch = curl_init();
//             curl_setopt($ch, CURLOPT_URL, $url);
//             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                 'Authorization: Bearer '.$accessToken 
                
//             ));
//             $response = curl_exec($ch);
//         }catch(Exception $e) {
//             $response = $e->getMessage();
//         }
//     }

    
         
//      if (isset($_POST['btnDownload'])) {
//         // refreshToken();
//         try {
//             $fileId = $_POST['fileId'];

//             $fileName = $_POST['fileName'];
           
//             $url = "https://api.box.com/2.0/files/".$fileId."/content";
//             $ch = curl_init();
//             // print_r(sys_get_temp_dir());
//             $fp = fopen(sys_get_temp_dir()."/".$fileName, "w") or die("Unable to open file!");
//             curl_setopt($ch,CURLOPT_URL, $url);
//             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                 'Authorization: Bearer '.$accessToken 
                
//             ));
//             curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//             $response = curl_exec($ch);
//             // print_r($response);
//             fwrite($fp, $response);
//             curl_close($ch);
//             fclose($fp);
            
//             // $type = filetype($fp);
//             // echo "type".$type;

//             // header("Content-type:".$type);

//             header("Content-Disposition: attachment;filename=".$fileName);
//             header("Content-Transfer-Encoding: binary"); 
//             header('Pragma: no-cache'); 
//             header('Expires: 0');

//             // readfile($fp);
//             // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
           
//         } catch (Exception $e) {
//              $response = $e->getMessage();
//         }
//          print_r($response);
//     }
?>
