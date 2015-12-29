<?php
    include "../php/refreshToken.php";
    include "../php/dbConnect.php";

    $accessToken = getAccessToken();

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    
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
                'Authorization: Bearer '.$accessToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
           
    
    } catch (Exception $e) {
        $response = $e->getMessage();
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
       
    
?>