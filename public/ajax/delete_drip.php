<?php 
$USERID = $_REQUEST['user_id']; 
$id =  $_REQUEST['id']; 
 if($id !='') {    
    //Main Connection
    include('../conn.php');
$sql = 'DELETE FROM email_drips_custom WHERE user_id = "'.$USERID.'" AND drip_id="'.$id.'"';
$res = mysqli_query($conn,$sql) or die(mysqli_error());
var_dump($res);
echo $msg;   
 }
?>