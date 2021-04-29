<?php

$id	= $_REQUEST['id'];
$USERID	= $_REQUEST['user_id'];

if($id !='') { 
    

        //Main Connection
    include('../conn.php');  
    $update = 'UPDATE contacts SET `unsubscribe` ="true" where user_id ="'.$USERID.'" AND email="'.$id.'"';
    $updatedb = mysqli_query($conn,$update);   

}

?>