<?php 
$id =  $_REQUEST['id'];  
 if($id !='') {    
    //Main Connection
    include('../conn.php');
     
     
  
 //Delete Keyword
    $ch = curl_init();  
    $headers = array();
    $headers[] = 'Accept: text/json';
    $headers[] = 'Accept-Encoding: gzip, deflate';
    $headers[] = 'Accept-Language: en-US,en;q=0.5';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'username: betruewebdesign';
    $headers[] = 'api_key: 59UMfNhaGimeebTBXvBNi2qic'; //Your referrer address  
    curl_setopt($ch,CURLOPT_URL,'https://developer.emobileplatform.com/api_main.php/messaging_keywords/delete_keyword/'.$id);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $outputkey =curl_exec($ch);
    curl_close($ch);

	$json_objectkey = json_decode($outputkey);
	//print_r($json_objectkey);
	//$sql = "DELETE FROM user_keyword_data where keyword_id ='$id'";
//End Delete Keyword    
     
     
  
     
     
$sql = 'DELETE FROM keywords WHERE keyword_id="'.$id.'"';
$res = mysqli_query($conn,$sql) or die(mysqli_error());
     
     
$sql = 'DELETE FROM keyword_lead_page WHERE keyword_id="'.$id.'"';
$res = mysqli_query($conn,$sql) or die(mysqli_error());     
     
var_dump($res);
     
   
     
echo $msg;   
 }
?>