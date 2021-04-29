<?php

$message_id = $_REQUEST['id'];


if($message_id !='') { 


                //Delete Group Session
                $ch = curl_init();  
                $headers = array();
                $headers[] = 'Accept: text/json';
                $headers[] = 'Accept-Encoding: gzip, deflate';
                $headers[] = 'Accept-Language: en-US,en;q=0.5';
                $headers[] = 'Cache-Control: no-cache';
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'username: betruewebdesign';
                $headers[] = 'api_key: 59UMfNhaGimeebTBXvBNi2qic'; //Your referrer address

                $ch = curl_init('https://developer.emobileplatform.com/api_main.php/group_mt/delete/'.$message_id);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $data = array("keyword_id" => $keyword_id, "mobile" => $mobile_number,"country_abbrv" => $country,"user_id"=> 262045391);				  
                $data_string = json_encode($data);
                $testfielb = curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                $outputkey =curl_exec($ch);
                curl_close($ch);
    
                $json_objectkey = json_decode($outputkey);
                // print_r($json_object);
                $messagedelete = $json_objectkey->message;
                //Delete Group Session
    
    
                //Main Connection
                include('../conn.php');
                $sql = "DELETE FROM keyword_groups where group_message_id='$message_id'";
                $res = mysqli_query($conn,$sql) or die(mysqli_error());
    
    
    

}

?>