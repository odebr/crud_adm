<!doctype html>
<html lang="en">
<head>
<title>Betrue CRM</title>
<link rel="stylesheet" href="css/sweetalert2.css" />
<script src="js/sweetalert2.all.min.js"></script>
</head>
<body>
<span style="display: none;">  
<?php
//Main Connection
include('conn.php');
     $USERID = $_REQUEST['user_id'];
     $keyword_id = $_REQUEST['keyword_id']; 
     $redirect_url_go = "https://".$_SERVER['SERVER_NAME']."/keywords";
?>
<?php
        if(isset($_REQUEST['action']) && $_REQUEST['action'] =='editkeywordsubmission'){

                            $date_time = date("Y-m-d H:i:s");
                            $USERID = $_REQUEST['user_id'];     
                            $keywordid = $_REQUEST['keyword_id'];    
                            $keyword_name = $_REQUEST['keyword'];
                            $keyword = $_REQUEST['keyword']; 
                            $mobile_number = $_REQUEST['textphone'];                            
                            $textphone = $_REQUEST['textphone']; 
                            $keyword_shortcode = '72727';
                            $keyword_email = '';
                            $message_text = @mysqli_real_escape_string($conn,$_REQUEST['message_text']);
                            $message_text = str_replace("'", "", $message_text);    
                            $country = 'US'; 
                    
                            if (strpos($message_text, 'https:') !== false) {
                                
                            } else { 
                                
                            $addlanding = $_REQUEST['addlanding'];

                            $link =  $MainLink.'lp/?kid='.$keyword_name;    
                                if($addlanding =='true') { $message_text = $message_text.' '.$link; }
                            }
                                
                                
                            //Edit Keyword
                            $datanet = array("keyword" => $keyword_name, "originating_number" => $keyword_shortcode,"coupon_id" => 0,"response" => $message_text,"callback_url" => $$callbackurl,"lead_notification_emails" => [],"lead_notification_mobile_numbers" => [$mobile_number],"user_id"=> 262045391);


                                $ch = curl_init();  
                                $headers = array();
                                $headers[] = 'Accept: text/json';
                                $headers[] = 'Accept-Encoding: gzip, deflate';
                                $headers[] = 'Accept-Language: en-US,en;q=0.5';
                                $headers[] = 'Cache-Control: no-cache';
                                $headers[] = 'Content-Type: application/json';
                                $headers[] = 'username: betruewebdesign';
                                $headers[] = 'api_key: 59UMfNhaGimeebTBXvBNi2qic'; //Your referrer address
                                $data_string = json_encode($datanet);
                                curl_setopt($ch,CURLOPT_URL,'https://developer.emobileplatform.com/api_main.php/messaging_keywords/update_keyword/'.$keywordid);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                                $outputkey =curl_exec($ch);
                                curl_close($ch);
                                $json_objectkey = json_decode($outputkey);

							    $message = $json_objectkey->message;
							
							
                                $update = 'UPDATE keywords SET `keyword` ="'.$keyword.'",`message` ="'.$message_text.'" where user_id ="'.$USERID.'" AND keyword_id="'.$keywordid.'"';
                                $updatedb = mysqli_query($conn,$update); 
                    
                                $queryn = "SELECT * FROM  `keywords` WHERE keyword_id = '".$keywordid."'";   
                                $resn = mysqli_query($conn,$queryn);
                                $row = mysqli_fetch_array($resn);
                                $page_id = $row['page_id'];  
                                $app_id = $row['app_id'];  
                                if($app_id !='') { 
                                $update = 'UPDATE app_create SET `keyword_id` ="'.$keywordid.'",`keyword` ="'.$keyword.'",`keyword_message` ="'.$message_text.'",`shortcode` ="72727",`keyword_mobile` ="'.$mobile_number.'" where user_id ="'.$USERID.'" AND app_id="'.$app_id.'"';
                                    $updatedb = mysqli_query($conn,$update); 

                                }	   

                                 echo '<script>
                                    swal({
                                    title: "Keyword updated successfully...",
                                    text: "Keep up the good work.",
                                    type: "success"
                                }).then(function() {
                                    window.location = "'.$redirect_url_go.'";
                                });
                                </script>';  
	
                            
						}
  
?>
</span>      
</body>
</html> 