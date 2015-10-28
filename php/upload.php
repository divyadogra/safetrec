<?php
    $url = "https://api.box.com/2.0/folders/0";
    $token = "gz7j5NYY6DEwQPrRChLLAS9XTeohgC1y";
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    
    $file_upload = $_FILES['file']['tmp_name'];
    $json = json_encode(array(
                                'name' => $_FILES['file']['name'], 
                                'parent' => array('id' => 0)
                            ));
    $fields = array(
                      'attributes' => $json,
                      'file'=>new CurlFile($_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['name'])
                  );

    try{

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
    
    }catch (Exception $e) {
        $response = $e->getMessage();
    }
?>