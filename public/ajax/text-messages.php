<div class="kt-portlet__body">
<div class="kt-scroll kt-scroll--pull" data-mobile-height="300">
<div class="kt-chat__messages">
<?php                                                      
// PHP program to convert timestamp 
// to time ago 
  
function time_Ago($time) { 
  
    // Calculate difference between current 
    // time and given timestamp in seconds 
    $diff     = time() - $time; 
      
    // Time difference in seconds 
    $sec     = $diff; 
      
    // Convert time difference in minutes 
    $min     = round($diff / 60 ); 
      
    // Convert time difference in hours 
    $hrs     = round($diff / 3600); 
      
    // Convert time difference in days 
    $days     = round($diff / 86400 ); 
      
    // Convert time difference in weeks 
    $weeks     = round($diff / 604800); 
      
    // Convert time difference in months 
    $mnths     = round($diff / 2600640 ); 
      
    // Convert time difference in years 
    $yrs     = round($diff / 31207680 ); 
      
    // Check for seconds 
    if($sec <= 60) { 
        echo "$sec seconds ago"; 
    } 
      
    // Check for minutes 
    else if($min <= 60) { 
        if($min==1) { 
            echo "one minute ago"; 
        } 
        else { 
            echo "$min minutes ago"; 
        } 
    } 
      
    // Check for hours 
    else if($hrs <= 24) { 
        if($hrs == 1) {  
            echo "an hour ago"; 
        } 
        else { 
            echo "$hrs hours ago"; 
        } 
    } 
      
    // Check for days 
    else if($days <= 7) { 
        if($days == 1) { 
            echo "Yesterday"; 
        } 
        else { 
            echo "$days days ago"; 
        } 
    } 
      
    // Check for weeks 
    else if($weeks <= 4.3) { 
        if($weeks == 1) { 
            echo "a week ago"; 
        } 
        else { 
            echo "$weeks weeks ago"; 
        } 
    } 
      
    // Check for months 
    else if($mnths <= 12) { 
        if($mnths == 1) { 
            echo "a month ago"; 
        } 
        else { 
            echo "$mnths months ago"; 
        } 
    } 
      
    // Check for years 
    else { 
        if($yrs == 1) { 
            echo "one year ago"; 
        } 
        else { 
            echo "$yrs years ago"; 
        } 
    } 
} 
// Initialize current time 
$curr_time = date('Y-m-d H:i:s'); 
// The strtotime() function converts 
// English textual date-time 
// description to a UNIX timestamp. 
$time_ago = strtotime($curr_time); 
  
 
                                                   
                                                        
$USERID = $_REQUEST['user_id'];
$phone = $_REQUEST['phone'];
//$keyword_id = '248627';
if($USERID !='') { 
    //Main Connection
    include('../conn.php');
    
$settingquery = "SELECT * FROM settings where user_id='".$USERID."'";
$settingqueryupdate = mysqli_query($conn,$settingquery);
$rowupdate = mysqli_fetch_array($settingqueryupdate);
$main_image_log = $rowupdate['image'];    
 
$contact = "select * from contacts where user_id = '".$USERID."' AND phone = '".$phone."' OR mobile ='".$phone."'";
$contact_query = mysqli_query($conn,$contact);
$contactquery = mysqli_num_rows($contact_query );
$row = mysqli_fetch_array($contact_query);
    
$NAME = $row['first_name'].' '.$row['last_name'];    
$image_user = $row['image'];
    
if($row['first_name'] =='') { $NAME = 'No contact'; }   
    
//Check messaging count and update and scroll to bottom
$keywordquery = "SELECT * FROM keyword_messaging where user_id = '".$USERID."' AND source='".$phone."' ORDER by id ASC";
$keyword_query = mysqli_query($conn,$keywordquery);
$count = mysqli_num_rows($keyword_query);
$app = mysqli_fetch_assoc($keyword_query);
$count2 = $app['count'];
    
 if($count2 < $count) {    
$update = 'UPDATE keyword_messaging SET `count` ="'.$count.'" where user_id ="'.$USERID.'" AND source = "'.$phone.'"';
$updatedb = mysqli_query($conn,$update);     
   
?>
<script>
var myVar;
function updateScroll(){
    var element = document.getElementById("sub_div");
    element.scrollTop = element.scrollHeight;
	//setInterval(updateScroll,1000);
}
//setInterval(updateScroll,1000);
	setTimeout(updateScroll,500);
</script>
<?php 
     
        } 
//End Check messaging count and update and scroll to bottom   

$keywordquery = "SELECT * FROM keyword_messaging where user_id = '".$USERID."' AND source='".$phone."' ORDER by id ASC";
$keyword_query = mysqli_query($conn,$keywordquery);
while($keyword_query_get = mysqli_fetch_array($keyword_query)) { 
//GET TIME AGO    
$curr_time= $keyword_query_get['receipt_date']; 
$time_ago = strtotime($curr_time); 
?>
                                              <?php if($keyword_query_get['mo_id'] =='') { ?>
                                                            
 													   <div class="kt-chat__message kt-chat__message--right">
															<div class="kt-chat__user">
																<span class="kt-chat__datetime"><?php echo time_Ago($time_ago); ;?></span>
																<a href="#" class="kt-chat__username">You</a>
                                                                <span class="kt-media kt-media--circle kt-media--sm">
																	<img src="images/users/images/<?php echo $main_image_log;?>" alt="image">
																</span>
															</div>
															<div class="kt-chat__text kt-bg-light-brand">
																<?php echo $keyword_query_get['message'];?>
															</div>
														</div> 
                                                            

                                                        <?php } else { ?>
                                                            
												        <div class="kt-chat__message">
															<div class="kt-chat__user">
																<span class="kt-media kt-media--circle kt-media--sm">
                                                                    
                                                                    <?php if($image_user !='') { ?>
                                                                    <img src="images/users/images/<?php echo $image_user;?>" alt="image">
                                                                    <?php } else { ?>
                                                                    <i class="fas fa-user" style="font-size: 22px;"></i>
                                                                    <?php } ?> 
																</span>
																<a href="#" class="kt-chat__username"><?php echo $NAME;?></span></a>
																<span class="kt-chat__datetime"><?php echo time_Ago($time_ago); ;?></span>
															</div>
															<div class="kt-chat__text kt-bg-light-success">
																<?php echo $keyword_query_get['message'];?>
															</div>
														</div>
                                                            
                                                            
                                         <?php } } } ?>
                                                            
</div>
</div>
</div>  