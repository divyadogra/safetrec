// <?php

// include "refreshToken.php";
// session_start();
// if (!isset($_SESSION['loggedInUser'])) {
//         throw new Exception("Invalid Login");
//       }  

//     $accessToken = getAccessToken();

    
//     if (isset($_POST['btnUpload'])) {
//         $url = "https://upload.box.com/api/2.0/files/content";
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
//             header('Location: download.php');
           
    
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
// ?>
