<?php
 $token = "ofZNSZAfqVj3AgxS7LMYqx58hWoTSGX7";
  function refreshToken() {
        $url = "https://app.box.com/api/oauth2/token";
        try {

            $ch = curl_init();

            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'grant_type'=> 'refresh_token', 
                'refresh_token'=>'KKd3dlzUSUaLq76lmfSTZRxs1zuaJiYWamceNI9GUoR5Bcjim8jOuqIHN6TWZAfw',
                'client_id'=>'ev2m34bide0g84u0ybcfan9mj36xe9uv',
                'client_secret'=>'vyzSxP1tWPhlA46lozwWqwso6RMstCja'
            ));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            $response = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
    }

    $url = "https://upload.box.com/api/2.0/files/content";
    if (isset($_POST['btnUpload'])) {
        // refreshToken();
        $file_upload = $_FILES['file']['tmp_name'];
        $json = json_encode(array(
                                'name' => $_FILES['file']['name'], 
                                'parent' => array('id' => 0)
                            ));
        $fields = array(
                      'attributes' => $json,
                      'file'=>new CurlFile($_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['name'])
                  );

        try {

            $ch = curl_init();

            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token, 
                'Content-Type:multipart/form-data'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            $response = curl_exec($ch);

            curl_close($ch);
            print "Upload Successful";
    
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
    }
       

    if(isset($_POST['listFiles'])) {
        $url = "https://api.box.com/2.0/folders/0";
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token 
                
            ));
            $response = curl_exec($ch);
        }catch(Exception $e) {
            $response = $e->getMessage();
        }
    }

    if (isset($_POST['btnDownload'])) {
        // refreshToken();
        try {
            $url = "https://api.box.com/2.0/files/37233808870/content";
            $ch = curl_init();
            print_r(sys_get_temp_dir());
            $fp = fopen(sys_get_temp_dir()."/test.pdf", "w") or die("Unable to open file!");
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token 
                
            ));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            // print_r($response);
            fwrite($fp, $response);
             curl_close($ch);
             fclose($fp);
            
            $type = filetype($fp);
            header("Content-type: $type");

    header("Content-Disposition: attachment;filename=test.pdf");
    header("Content-Transfer-Encoding: binary"); 
    header('Pragma: no-cache'); 
    header('Expires: 0');

            // readfile($fp);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
           
        } catch (Exception $e) {
             $response = $e->getMessage();
        }
         print_r($response);
    }

?>

<form method="post" name="frmUpload" enctype="multipart/form-data">
    <label>Upload file to Box
        <input name="file" type="file" id="file"/>
    </label>
    <input name="btnUpload" type="submit" value="Upload" />
    <input name="listFiles" type="submit" value="List" />
    <input name="btnDownload" type="submit" value="Download" />
</form>
