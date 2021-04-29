<?php
$id	= $_REQUEST['id'];

$arr = explode("-", $id, 2);
$id = $arr[0];
$USERID = $arr[1];



if($id !='') { 
    //Main Connection
    include('../conn.php');

    $update = 'UPDATE invoices SET `hide` ="true" WHERE user_id ="'.$USERID.'" AND invoice_number="'.$id.'"';
    $updatedb = mysqli_query($conn,$update); 
}
?>