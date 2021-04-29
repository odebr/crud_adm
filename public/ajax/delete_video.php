<?php

$id	= $_REQUEST['id'];
$USERID = $_REQUEST['user_id'];

if($id !='') { 

    //Main Connection
    include('../conn.php');
    
    
        $queryn = "SELECT * FROM  `video` WHERE user_id = '".$USERID."' AND video_id ='".$id."'";
        $resn = mysqli_query($conn,$queryn);
        while($row=mysqli_fetch_array($resn)){   
    
             $file = $row['video_name'];
    
    
            unlink("video/uploads/$file");
            
            
            
        }
    
	$sql = "DELETE FROM video where user_id = '$USERID' AND video_id='$id'";
    $res = mysqli_query($conn,$sql) or die(mysqli_error());
    
 

}

?>