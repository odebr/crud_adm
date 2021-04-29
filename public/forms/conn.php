<?php

date_default_timezone_set('America/Phoenix'); 

//CRM Connection
$con = mysqli_connect('localhost','btrulead_masterlogin','laX+{FN}VV.]','btrulead_leads');

//Main Connection
$conn = mysqli_connect('localhost','btrulead_masterlogin','laX+{FN}VV.]','btrulead_leads');

$dbName = 'btrulead_leads';

$CRMLink = 'https://crm.btruleads.com/';

$MainLink = 'https://btruleads.com/';

$callbackurl = 'https://btruleads.com/callback_url.php'; 

$callbackurl_messaging = 'https://btruleads.com/callback_url_messaging.php';

$domain = "crm.btruleads.com";
?>