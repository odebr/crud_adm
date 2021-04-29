<?php

$id	= $_REQUEST['id'];


if($id !='') { 

    //Main Connection
    include('../conn.php');
    
     $query = "SELECT * FROM  `course` WHERE id = '".$id."'";
     $resn = mysqli_query($conn,$query);
     $row = mysqli_fetch_array($resn); 
     $USERID = $row['user_id'];
     $course_id = $row['course_id'];
    
	$sql = "DELETE FROM lesson where user_id='$USERID' AND course_id='$course_id'";
    $res = mysqli_query($conn,$sql) or die(mysqli_error());
    
	$sql = "DELETE FROM course where id='$id'";
    $res = mysqli_query($conn,$sql) or die(mysqli_error());

}

?>