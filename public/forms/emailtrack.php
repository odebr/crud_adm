<?php 
header('Content-Type: image/gif');

date_default_timezone_set('America/Phoenix');

    //Main Connection
    include('conn.php');
$date_time = date("Y-m-d H:i:s");

$USERID = $_REQUEST['user_id'];
$email_id = $_REQUEST['email_id'];


$email = $_REQUEST['email'];

$settingquery = "SELECT * FROM contacts where user_id = '".$USERID."' AND email='".$email."'";
$settingqueryupdate   = mysqli_query($conn,$settingquery);
$rowupdate            = mysqli_fetch_array($settingqueryupdate);	
	
$contact_id = $rowupdate['contact_id'];

$updatequery = ("INSERT INTO `email_tracking` (`user_id`, `email_id`, `contact_id`, `email`, `datetime`) VALUES ('$USERID', '$email_id', '$contact_id', '$email', '$date_time')");
$updateres = mysqli_query($conn,$updatequery);




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