<!doctype html>
<html lang="en">
<head>
<title>Unsubscribe - Betrue CRM</title>
<link rel="stylesheet" href="css/sweetalert2.css" />
<script src="js/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="https://crm.mychurch.cloud/public/js/jquery-3.2.1.min.js"></script>    
<link href="https://fonts.googleapis.com/css?family=Anton|Fjalla+One|Raleway&display=swap" rel="stylesheet">    
</head>
<body>
<?php
date_default_timezone_set('America/Phoenix');    
//Main Connection
include('conn.php');
$USERID = $_REQUEST['user_id'];
$EMAILID = $_REQUEST['email'];
$template = $_REQUEST['template'];
$date_time = date("Y-m-d H:i:s"); 
      
$settingquery = "SELECT * FROM settings where user_id='".$USERID."' ORDER by id ASC";
$settingqueryupdate = mysqli_query($conn,$settingquery);
$rowupdate  = mysqli_fetch_array($settingqueryupdate);
$USERID = $rowupdate['user_id'];
$logo = $rowupdate['logo'];    
$business_name = $rowupdate['business_name'];
$title = $rowupdate['title'];
$name = $rowupdate['name'];
$first_name = $rowupdate['first_name'];
$last_name = $rowupdate['last_name'];
$email = $rowupdate['email'];
$phone = $rowupdate['phone'];
$cell = $rowupdate['cell'];
$phone = $rowupdate['phone'];
$website = $rowupdate['website'];
$address = $rowupdate['address'];
$city = $rowupdate['city'];
$state = $rowupdate['state'];
$zip = $rowupdate['zip'];
$facebook = $rowupdate['facebook'];
$twitter = $rowupdate['twitter'];
$instagram= $rowupdate['instagram'];
$snapchat = $rowupdate['snapchat'];
$linkedin = $rowupdate['linkedin'];
$twitter = $rowupdate['twitter'];
$google = $rowupdate['google'];   
$color = $rowupdate['color']; 
    
    
$querycontacts = "SELECT * FROM contact WHERE user_id ='".$USERID."' AND email ='".$EMAILID."'";
$query_contacts = mysqli_query($conn,$querycontacts);
$get_contacts = mysqli_fetch_array($query_contacts);
    
$FIRST_NAME = $get_contacts['first_name'];
$LAST_NAME = $get_contacts['last_name'];
$EMAIL_SEND = $get_contacts['email'];    
    
    
   
?>
<style>
body {
    border-top: #<?php echo $color;?> 5px solid;
    padding: 0px;
    margin: 0px;
    background: #eee;
}  
.logo {
    margin: 0 auto;
    display: block;
    postion: relative;
    widht: 100%;
    max-width: 280px;
}
.button {
    margin: 0 auto;
    background: #<?php echo $color;?>;
    text-align: center;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    display: block;
    postion: relative;
    widht: 100%;
    max-width: 280px;
    font-weight: bold;
    text-decoration: none;
    font-size: 22px;
    font-family: 'Oswald', sans-serif;
    text-transform: uppercase;
} 
.button:hover {
    background: #000;
}
h4 {
    text-align: center;
    font-size: 28px;
    font-family: 'Oswald', sans-serif;
}
p {
    text-align: center;
    font-size: 18px;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    display: block;
    position: relative;
} 
</style>    
<br>
<br>
<img class="logo" src="https://<?php echo $_SERVER['SERVER_NAME'];?>/public/images/users/images/<?php echo $logo;?>" alt="<?php echo $business_name;?>" title="<?php echo $business_name;?>"/>
<br> 
<br>
    
<?php if($_REQUEST['unsubscribed'] !='') { ?>    
<h4>You have been unsubscribed.</h4>   
<?php } else { ?>   
    
    
<h4>Hello <?php echo $FIRST_NAME;?> <?php echo $LAST_NAME;?>,</h4>
    
<p>We are sorry to see you go. By clicking the unsubscribe button below you will no longer receive emails from <?php echo $business_name;?>.
<br>
<br>
The email <?php echo $EMAIL_SEND;?> will be unsubscribed from all lists.    
</p>    
<br>
<br>
    
<a title="Delete" class="button" href="javascript:void(0);" onClick="return unsubscribe('<?php echo $EMAIL_SEND;?>');">Unsubscribe</a>    
    
    
<script>
 		 function unsubscribe(rd)
 			{
 			//alert(rd);
 				var id = rd;
 				var info = 'id=' + rd;
                var r = swal({
                  title: "Unsubscribe from all lists?",
                  text: "Are you sure you want to unsubscribe this email?",
                  icon: "warning",
                  buttons: true,
                  confirmButtonColor: "#DD6B55",                  
                  showCancelButton: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
 				
 					$.ajax({
 									type : "POST",
 									url : "../public/ajax/unsubscribe_email.php?user_id=<?php echo $USERID;?>", //URL to the delete php script
 									data : info,
 									success : function(msg) {
 										//alert(msg);
                                        swal({
                                        title: "Unsubscribed Successfully!",
                                        text: "We are sad to see you go.",
                                        type: "success"
                                    }).then(function() {
                                        window.location = "unsubscribe.php?unsubscribed=true&user_id=<?php echo $USERID;?>";
                                    });
                        
 
 									}
 								});
 				} else {
    swal("Your email is safe!");
  }
                
});
}
</script>
<?php } ?>    
</body>
</html> 