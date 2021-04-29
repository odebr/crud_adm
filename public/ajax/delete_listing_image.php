<?php

$id	= $_REQUEST['name'];
$USERID	= $_REQUEST['user_id'];
$getid = $_REQUEST['id'];



if($id !='') { 
    
$id1 = ',"'.$id.'"';
$id2 = '"'.$id.'",';
    
        //Main Connection
    include('../conn.php');
    
    $query = "SELECT * FROM api_listing where user_id = '".$USERID."' AND id='".$getid."'";
    $queryget   = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($queryget); 
    
    $IMAGE = $row['image'];
    $strip = str_replace($id1, '', $IMAGE); 
    
    $strip = str_replace($id2, '', $strip); 
    
    $strip = @mysqli_real_escape_string($conn,$strip);
    
    
    $update = 'UPDATE api_listing SET `image` ="'.$strip.'" where id ="'.$getid.'"';
    $updatedb = mysqli_query($conn,$update);

}

?>