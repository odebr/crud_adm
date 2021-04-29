<?php 
header('Content-Type: image/gif');

date_default_timezone_set('America/Phoenix');

//Main Connection
include('conn.php');
$date_time = date("Y-m-d H:i:s");

$USERID = $_REQUEST['user_id'];
$quote_id = $_REQUEST['quote'];


$date_time = date("Y-m-d H:i:s");
$update = 'UPDATE quotes SET `last_viewed` ="'.$date_time.'" WHERE user_id ="'.$USERID.'" AND quote_id="'.$quote_id.'"';
$updatedb = mysqli_query($conn,$update); 


//Full URI to the image
//Full URI to the image
$graphic_http = 'https://crm.btruleads.com/forms/email.gif';

//Get the filesize of the image for headers
$filesize = filesize('/home/btruleads/crm.btruleads.com/public/forms/email.gif');

//Now actually output the image requested (intentionally disregarding if the database was affected)

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private',false);
header('Content-Disposition: attachment; filename="blank.gif"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: '.$filesize);
readfile($graphic_http);
?>