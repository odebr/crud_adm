<?php 
$id =  $_REQUEST['id'];  
 if($id !='') {    
    //Main Connection
    include('../conn.php');
$sql = 'DELETE FROM contacts WHERE id="'.$id.'"';
$res = mysqli_query($conn,$sql) or die(mysqli_error());
var_dump($res);
echo $msg;   
 }
?>