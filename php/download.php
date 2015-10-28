<?php
try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            @$fileId = $request->id;
            $fileName = "temp.pdf";
            $url = "https://api.box.com/2.0/files/".$fileId."/content";
            $token = "gz7j5NYY6DEwQPrRChLLAS9XTeohgC1y";
            $ch = curl_init();
            console.log(sys_get_temp_dir());
            $fp = fopen(sys_get_temp_dir()."/".$fileName, "w") or die("Unable to open file!");
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token 
                
            ));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $mydata = curl_exec($ch);
            $response = curl_exec($ch);

            // print_r($response);
            // return $response;
            fwrite($fp, $response);
            flush();
            
            
            $type = filetype($fp);
            header("Content-type: $type");

            header("Content-Disposition: attachment;filename=test.pdf");
            header("Content-Transfer-Encoding: binary"); 
            header('Pragma: no-cache'); 
            header('Expires: 0');

            /*header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=test.pdf");
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");//            header('Content-Disposition: attachment; 
            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Length: " . filesize($fp)); //Remove
            */
            readfile($fp);
            echo $response;
            curl_close($ch);
            fclose($fp);

            // readfile($fp);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
           
        } catch (Exception $e) {
             $response = $e->getMessage();
        }
?>