<?php

include "../php/refreshToken.php";
include "../php/dbConnect.php";

$accessToken = getAccessToken();

    
    if (isset($_POST['btnUpload'])) {

        //Create folder structure
       
        $actionId = $_POST['actionId'];
        $actionOutcomeId = $_POST['actionOutcomeId'];
        $actionOutputId = $_POST['actionOutputId'];
        $actionCommentId = $_POST['actionCommentId'];

        if ($actionOutcomeId != null) {
           $folderId = doFolderCreateTask("ActionOutcome", $actionOutcomeId, $accessToken, $actionId);
        } else if ($actionOutputId != null) {
            $folderId = doFolderCreateTask("ActionOuput", $actionOutputId, $accessToken, $actionId);
        } else {
             $folderId = doFolderCreateTask("Action", $actionId, $accessToken, $actionId);
        }


        //Upload files

        $url = "https://upload.box.com/api/2.0/files/content";
        
        $file_upload = $_FILES['file']['tmp_name'];
        $json = json_encode(array(
                                'name' => $_FILES['file']['name'], 
                                'parent' => array('id' => $folderId)
                            ));
        $fields = array(
                      'attributes' => $json,
                      'file'=>new CurlFile($_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['name'])
                  );

        try {

            $ch = curl_init();

            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$accessToken, 
                'Content-Type:multipart/form-data'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            $response = curl_exec($ch);
            curl_close($ch);
            echo $response;
            header('Location: loginSuccess.php');
           
    
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        
    }

     function doFolderCreateTask($folder, $id, $accessToken, $actionId) {
            $query = "select box_folder_id from box_folder_map where folder_name='".$folder."-".$id."'";
            $response = executeQuery($query);

            if (count($response) > 0) {
                 $folderId = $response[0]['box_folder_id'];
            } else if ($folder != "Action") {
                $query = "select box_folder_id from box_folder_map where folder_name='Action-".$actionId."'";
                $response = executeQuery($query);
                if (count($response) > 0) {
                    $parentFolderId = $response[0]['box_folder_id'];
                } else {
                    $parentFolderId = createFolder("Action-".$actionId, 0, $accessToken);
                }
                $folderId = createFolder($folder."-".$id, $parentFolderId, $accessToken);
            }
            return $folderId;
        }


    function createFolder($name, $parentFolderId, $accessToken) {
         $fields = array(
                      'name'=> $name,
                      'parent' => array('id' => $parentFolderId)
                  );

         try {

            $ch = curl_init();

            curl_setopt($ch,CURLOPT_URL, "https://api.box.com/2.0/folders");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$accessToken
            ));
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $response = curl_exec($ch);
            $folderInfo = json_decode($response, true);
            $folderId = $folderInfo['id'];

            // Insert into Db
            $query = "insert into box_folder_map values('".$name."', '".$folderId."')"; 
            executeQuery($query);
            curl_close($ch);
            return $folderId;
    
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
       }
       
    
    function listFiles($folderId, $accessToken) {
       $url = "https://api.box.com/2.0/folders/".$folderId."/items";
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$accessToken 
                
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            return $response;
        }catch(Exception $e) {
            $response = $e->getMessage();
        }   
    }
    
         
     if (isset($_POST['btnDownload'])) {
        try {
            $fileName = $_POST['fileName'];
            $actionOutcomeId = $_POST['outcomeId'];
            $actionOutputId = $_POST['outputId'];
            $actionId = $_POST['actionId'];


            if ($actionOutcomeId != null) {
                $fileId = getFileInfo("ActionOutcome", $actionOutcomeId, $accessToken, $fileName);
            } else if ($actionOutputId != null) {
                $fileId = getFileInfo("ActionOutcome", $actionOutputId, $accessToken, $fileName);
            } else {
                $fileId = getFileInfo("Action", $actionId, $accessToken, $fileName);
            }
            
           
            $url = "https://api.box.com/2.0/files/".$fileId."/content";
            $ch = curl_init();
            // print_r(sys_get_temp_dir());
            $fp = fopen(sys_get_temp_dir()."/".$fileName, "w") or die("Unable to open file!");
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$accessToken 
                
            ));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            // print_r($response);
            fwrite($fp, $response);
            curl_close($ch);
            fclose($fp);
            
            // $type = filetype($fp);
            // echo "type".$type;

            // header("Content-type:".$type);

            header("Content-Disposition: attachment;filename=".$fileName);
            header("Content-Transfer-Encoding: binary"); 
            header('Pragma: no-cache'); 
            header('Expires: 0');

            // readfile($fp);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
           
        } catch (Exception $e) {
             $response = $e->getMessage();
        }

         print_r($response);
    } if (isset($_POST['btnViewFolder'])) {
        $folderId = $_POST['fileId'];
        $url = "https://api.box.com/2.0/folders/".$folderId;
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
    }

        function getFileInfo($folder, $id, $accessToken, $fileName) {
                $query = "select box_folder_id from box_folder_map where folder_name='".$folder."-".$id."'";
                $response = executeQuery($query);
                $fileResults = json_decode(listFiles($response[0]['box_folder_id'], $accessToken));

                $files = $fileResults->entries;


                for($i = 0; $i < count($files); ++$i) {
                    if ($files[$i]->name == $fileName) {
                        $fileId = $files[$i]->id;
                        break;
                    }
                }

            }
?>
