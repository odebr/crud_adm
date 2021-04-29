<?php

date_default_timezone_set('America/Phoenix');


include('conn.php');

$i = '0'; 

//CHECK IF DATETIME TO SEND IS CORRECT 
//CHECK IF DATETIME TO SEND IS CORRECT 
$date_time = date("Y-m-d H:i:s");
$querycontacts = "SELECT * FROM keyword_single_mt";
$query_contacts = mysqli_query($conn,$querycontacts);
while($get_contacts=mysqli_fetch_array($query_contacts)){ 
$ID = $get_contacts['id'];
	
$send = $get_contacts['send'];	
if($send =='send-now') { } else { 	
	
$date = strtotime($send);
$send =  date('Y-m-d H:i:s', $date);
	
if($date_time > $send)
{
	
	 $ID = $get_contacts['id'];	
	 $update = 'UPDATE keyword_single_mt SET `send` ="send-now" where id ="'.$ID.'"';
     $updatedb = mysqli_query($conn,$update); 
	
    echo '<span class="status expired">Prepare To Send</span>';
}	
	

}
	
	
}
//END CHECK IF DATETIME TO SEND IS CORRECT 
//END CHECK IF DATETIME TO SEND IS CORRECT 




$querycontacts = "SELECT * FROM keyword_single_mt WHERE send ='send-now' AND sent =''";  
$query_contacts = mysqli_query($conn,$querycontacts);
while($get_contacts=mysqli_fetch_array($query_contacts)){ 
    
$USERID = $get_contacts['user_id'];    
$keyword_id = '';
$mobile_number = '';
$text_message = '';
$id = $get_contacts['id'];    
$keyword_id = $get_contacts['keyword_id'];
$mobile_number = $get_contacts['mobile_number'];
$text_message = $get_contacts['text_message'];
$group_message_id = $get_contacts['group_message_id'];
$date_time = date("Y-m-d H:i:s");
    
$i ='0';    
    
    
    
    
                //Create Messaging Session?
                //Create Messaging Session?
                //Create Messaging Session?   
                    $query = $conn->query("SELECT mobile_number FROM keyword_single_mt WHERE user_id = '".$USERID."' AND keyword_id = '".$keyword_id."' GROUP by mobile_number ASC"); 
                    // Generate array with skills data 
                    $skillData = array(); 
                    if($query->num_rows > 0){ 
                        while($row = $query->fetch_assoc()){ 
                            
                            $skillData[] = $row['mobile_number']; 
                        } 
                    } 
                    // Return results as json encoded array 
                  $get_mobile_json = json_encode($skillData);
				   print_r($get_mobile_json);


                $ch = curl_init();  
                $headers = array();
                $headers[] = 'Accept: text/json';
                $headers[] = 'Accept-Encoding: gzip, deflate';
                $headers[] = 'Accept-Language: en-US,en;q=0.5';
                $headers[] = 'Cache-Control: no-cache';
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'username: betruewebdesign';
                $headers[] = 'api_key: 59UMfNhaGimeebTBXvBNi2qic'; //Your referrer address

                curl_setopt($ch,CURLOPT_URL,'https://developer.emobileplatform.com/api_main.php/messaging_sessions/add_multi');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_POST, TRUE);   //is it optional?


                $data = '[

                      {

                        "keyword_id": '.$keyword_id.',

                        "mobile_numbers":'.$get_mobile_json.',

                        "callback_url": '.$callbackurl_messaging.',

                        "session_length": 250,

                        "country_abbrv": "US"

                      }

                    ]'; 



                $testfielb = curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $outputkey = curl_exec($ch);
                curl_close($ch);
                $json_objectkey = json_decode($outputkey);
                print_r($json_objectkey);
                echo $message = $json_objectkey->message; 
               //End Create Messaging Session?
               //End Create Messaging Session?
               //End Create Messaging Session? 
    

    
               //Send Text Message
                $ch = curl_init();  
                $headers = array();
                $headers[] = 'Accept: text/json';
                $headers[] = 'Accept-Encoding: gzip, deflate';
                $headers[] = 'Accept-Language: en-US,en;q=0.5';
                $headers[] = 'Cache-Control: no-cache';
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'username: betruewebdesign';
                $headers[] = 'api_key: 59UMfNhaGimeebTBXvBNi2qic'; //Your referrer address

                curl_setopt($ch,CURLOPT_URL,'https://developer.emobileplatform.com/api_main.php/single_mt/send_message/'.$mobile_number);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_POST, TRUE);   //is it optional?
    
                $data = array("keyword_id" => $keyword_id, "message" => $text_message);	

                     
                $data_string = json_encode($data);
                $testfielb = curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                $outputkey =curl_exec($ch);
                curl_close($ch);
                $json_objectkey = json_decode($outputkey);
                //print_r($json_objectkey);
    
                echo $message = $json_objectkey->message;
                if($message =='Message sent successfully.') { 
        
        
                $i++;
                $update = 'UPDATE keyword_single_mt SET `sent` ="'.$message.'" where id ="'.$id.'"';
                $updatedb = mysqli_query($conn,$update);

                $querykey = "SELECT * FROM keywords WHERE user_id = '".$USERID."' AND keyword_id ='".$keyword_id."'";  
                $querykey2 = mysqli_query($conn,$querykey);
                $querykey3=mysqli_fetch_array($querykey2); 
                $keyword = $querykey3['keyword'];
    
                //Check if text is last...
                $keywordquery8 = "SELECT * FROM keyword_messaging where user_id = '".$USERID."' AND source='".$mobile_number."' ORDER by id DESC";
                $keyword_query8 = mysqli_query($conn,$keywordquery8);
                $keyword_query_get8 = mysqli_fetch_array($keyword_query8);
                $getID = $keyword_query_get8['id'];
                $keywordquery9 = "SELECT * FROM keyword_messaging where id = '".$getID."'";
                $keyword_query9 = mysqli_query($conn,$keywordquery9);
                $keyword_query_get9 = mysqli_fetch_array($keyword_query9);
                if($keyword_query_get9['mo_id'] =='') { 
                $last = '';    
                $update = 'UPDATE keyword_messaging SET `last` ="'.$last.'" where id ="'.$getID.'"';
                $updatedb = mysqli_query($conn,$update);
                }
                //End check if text is last...


                mysqli_query($conn,"INSERT INTO `keyword_messaging`(`user_id`, `keyword_id`, `keyword`, `message`, `last`, `mo_id`, `receipt_date`, `source`, `source_carrier`, `datetime`) VALUES ('$USERID', '$keyword_id','$keyword','$text_message','true','','$date_time','$mobile_number','','$date_time')"); 
    
    
    } else { 
    
                $update = 'UPDATE keyword_single_mt SET `sent` ="'.$message.'" where id ="'.$id.'"';
                $updatedb = mysqli_query($conn,$update);
    
    }
               
    
    




}
                $update = 'UPDATE keyword_single_mt SET `total` ="'.$i.'" where group_message_id ="'.$group_message_id.'"';
                $updatedb = mysqli_query($conn,$update); 


?>