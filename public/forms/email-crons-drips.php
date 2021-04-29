<?php
require_once('/home/btruleads/crm.btruleads.com/vendor/autoload.php');

use Mailgun\Mailgun;

date_default_timezone_set('America/Phoenix');


include('conn.php');


$date_time = date("Y-m-d H:i:s"); 
$year = date('Y');
echo $date = date("F d, Y"); 
$time = date("g:i a"); 



//GET DRIP EMAIL    
//GET DRIP EMAIL   
$queryapp = "SELECT * FROM email_drips where date='".$date."' AND pause='false'";
$query_app = mysqli_query($conn,$queryapp);
$app   = mysqli_fetch_array($query_app);

$USERID = $app['user_id'];
$email_id = $app['email_id'];
$list = $app['list']; 
$lead_campaign = $app['lead_campaign']; 
echo $email_name = $app['email_name'];
$email_title = $app['title'];
$email_subject = $app['subject'];
$email_from = $app['email_from']; 	
$header_image = $app['header_image'];
$email_text = $app['text']; 	
$block_one_link = $app['block_one_link']; 	
$block_one = $app['block_one']; 	
$block_two_link = $app['block_two_link']; 	
$block_two = $app['block_two'];
$block_three_link = $app['block_three_link']; 	
$block_three = $app['block_three'];
$template = $app['template'];
$video = $app['video'];
$button_text = $app['button_text']; 
$button_link = $app['button_link']; 
$template_blocks = ''; 
$video_css = '';

//Check For Video
//Check For Video
if($video !='') { 

$queryl = "SELECT * FROM  `video` WHERE user_id = '".$USERID."' AND video_id='".$video."' AND type='gif'";   
$resnl = mysqli_query($conn,$queryl);
$rowlistings = mysqli_fetch_array($resnl);
$video_id = $rowlistings['video_id'];
$GIF = $rowlistings['video_name'];


$video_image = $CRMLink.'/video/uploads/'.$GIF;
    
$video_css = "
<style>
#frame
	{
		width: 98%;
		background: url($video_image) no-repeat;
		text-align: center;
	}
	.play_button
	{
		display: inline-block;
		height: 100%;
		vertical-align: middle;
	}
	#frame > img
	{
		vertical-align: middle;
	}
</style>";


		  
$video_get = '<table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">

            <tr>
              <td align="center" valign="top">

                <table width="640" cellpadding="0" cellspacing="0" border="0" class="container">
                  <tr>
                    <td align="center" valign="top">
					<div style="padding-top: 5px;">
					<a href="'.$MainLink.'users/vp.php?user_id='.$USERID.'&video_id='.$video.'">
					<div id="frame">
					<span class="centerer"><img src="'.$CRMLink.'forms/images/play.png"/></span>
					</div> 
					</div>
					</a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
            </tr>
          </table>';

}



$email_html = $CRMLink."forms/email-html.php?user_id='".$USERID."'&email_id='".$EMAILID."'"; 
//GET SETTINGS	
//GET SETTINGS    
$settingquery = "SELECT * FROM settings where user_id='".$USERID."' ORDER by id ASC";
$settingqueryupdate = mysqli_query($conn,$settingquery);
$rowupdate  = mysqli_fetch_array($settingqueryupdate);
$USERID = $rowupdate['user_id'];
$business_name = $rowupdate['business_name'];
$title = $rowupdate['title'];
$name = $rowupdate['name'];
$first_name = $rowupdate['first_name'];
$last_name = $rowupdate['last_name'];
$email = $rowupdate['email'];
$phone = $rowupdate['phone'];  
$cell = $rowupdate['cell'];
    
$cell = preg_replace('/[^0-9]+/', '', $rowupdate['cell']);if(strlen($cell) > 3){ $cell = substr($cell, 0, 3).'-'.substr($cell, 3);} if(strlen($cell) > 3){ $cell = substr($cell, 0, 7).'-'.substr($cell, 7); }       
    
$phone = preg_replace('/[^0-9]+/', '', $rowupdate['phone']);if(strlen($phone) > 3){ $phone = substr($phone, 0, 3).'-'.substr($phone, 3);} if(strlen($phone) > 3){ $phone = substr($phone, 0, 7).'-'.substr($phone, 7); }    
      
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
$logo = $rowupdate['logo'];
$color = $rowupdate['color'];	
	
	
if($facebook !='') { 
$facebook = '<a href="'.$facebook.'" target="_blank"><img src="'.$CRMLink.'images/users/images/social-icons/Facebook.png" width="40"/></a>&nbsp;&nbsp;';
} else { 
$facebook = '';
}	   

if($twitter !='') { 
$twitter = '<a href="'.$twitter.'" target="_blank"><img src="'.$CRMLink.'images/users/images/social-icons/Twitter.png" width="40"/></a>&nbsp;&nbsp;';
} else { 
$twitter = '';
}	
	
if($instagram !='') { 
$instagram = '<a href="'.$instagram.'" target="_blank"><img src="'.$CRMLink.'images/users/images/social-icons/Instagram.png" width="40"/></a>&nbsp;&nbsp;';
} else { 
$instagram = '';
}	
	
if($google !='') { 
$google = '<a href="'.$google.'" target="_blank"><img src="'.$CRMLink.'images/users/images/social-icons/Google Plus.png" width="40"/></a>&nbsp;&nbsp;';
} else { 
$google = '';
}	
	
if($linkedin!='') { 
$linkedin = '<a href="'.$linkedin.'" target="_blank"><img src="'.$CRMLink.'images/users/images/social-icons/LinkedIn.png" width="40"/></a>&nbsp;&nbsp;';
} else { 
$linkedin = '';
}
	
if($snapchat!='') { 
$snapchat = '<a href="'.$snapchat.'" target="_blank"><img src="'.$CRMLink.'images/users/images/social-icons/Snapchat.png" width="40"/></a>&nbsp;&nbsp;';
} else { 
$snapchat = '';
}

  
$social_media_follow = $facebook.$twitter.$instagram.$google.$linkedin.$snapchat;   
    
    
  


if($template =='basic') { 
    
    
if($button_text !='') { 
     
      
     $button ='<td align="center" valign="top"><table width="250" style="width:250px; background-color:#'.$color.'; border-radius:4px;" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td class="em_white" height="42" align="center" valign="middle" style="font-family: Arial, sans-serif; font-size: 16px; color:#ffffff; font-weight:bold; height:42px;"><a href="'.$button_link.'" target="_blank" style="text-decoration:none; color:#ffffff; line-height:42px; display:block;text-transform: uppercase;">'.$button_text.'</a></td>  
                  </tr>
                </table>
                </td>';
 } 
    
$video_css = "
<style>
#frame
	{
		width: 100%;
        max-width: 630px!important;
		background: url($video_image) no-repeat;
		text-align: center;
        margin-top: 5px;
	}
	.play_button
	{
		display: inline-block;
		height: 100%;
		vertical-align: middle;
        padding:10px;
        width: 100%;
        max-width: 630px!important;
	}
	#frame > img
	{
		vertical-align: middle;
	}
</style>";
    
              if($video_get !='') { 
              $video_get = '
              <a href="'.$MainLink.'users/vp.php?user_id='.$USERID.'&video_id='.$video.'">
              <div id="frame">
              <span class="play_button"><img alt="" width="630" style="padding:10px;" src="'.$CRMLink.'forms/images/play.png"/></span>
              </div> 
              </a>';
              } 

                    if($facebook !='') {   
                    $facebook = '<td width="30" style="width:30px;" align="center" valign="middle"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/social-icons/Facebook.png" width="30" height="30" alt="Facebook" border="0" style="display:block; font-family:Arial, sans-serif; font-size:18px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a></td> 
                    <td width="12" style="width:12px;">&nbsp;</td>';
                    } 
                    if($twitter !='') {  
                    $twitter = '<td width="30" style="width:30px;" align="center" valign="middle"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/social-icons/Twitter.png" width="30" height="30" alt="Twitter" border="0" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a></td>
                    <td width="12" style="width:12px;">&nbsp;</td>';
                    } 
                    if($instagram !='') {  
                    $instagram = '<td width="30" style="width:30px;" align="center" valign="middle"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/social-icons/Instagram.png" width="30" height="30" alt="Instagram" border="0" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a></td>
                    <td width="12" style="width:12px;">&nbsp;</td>';
                    } 
                    if($linkedin !='') {  
                    $linkedin = '<td width="30" style="width:30px;" align="center" valign="middle"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/social-icons/LinkedIn.png" width="30" height="30" alt="Linkedin" border="0" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a></td>
                    <td width="12" style="width:12px;">&nbsp;</td>'; 
                    } 
                    if($google !='') {     
                    $google = '<td width="30" style="width:30px;" align="center" valign="middle"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/social-icons/GooglePlus.png" width="30" height="30" alt="Linkedin" border="0" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a></td>'; 
                    }


$social_media_follow = $facebook.$twitter.$instagram.$google.$linkedin.$snapchat;  



$mgClient = Mailgun::create('b1ad43ef59bf01d5efc19ddf23630a93-9dda225e-bc7f42a9');
$domain = $domain;
	
	
   //Email Test 

   $subjectthre  = $email_subject;
   $fromthre     = $email;    
 
    

//QUERY ALL CONTACTS
//QUERY ALL CONTACTS    
//QUERY ALL CONTACTS    
$querycontacts = "SELECT * FROM contacts WHERE user_id ='".$USERID."' AND email !='' AND unsubscribe =''";   
$query_contacts = mysqli_query($conn,$querycontacts);
while($get_contacts = mysqli_fetch_array($query_contacts)) { 

if($get_contacts['email'] !='') { 
    
$i++;
$FIRST_NAME = $get_contacts['first_name'];
$LAST_NAME = $get_contacts['last_name'];
echo $EMAIL_SEND = $get_contacts['email'];
    
$email= 'no-reply@btruleads.com';    
$emailfrom = ''.$email_from.' <'.$email.'>';  
    
    
    
    
$email_html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<!--[if gte mso 9]><xml>
<o:OfficeDocumentSettings>
<o:AllowPNG/>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml><![endif]-->
<title>'.$email_subject.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0 " />
<meta name="format-detection" content="telephone=no"/>
<!--[if !mso]><!-->
<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,700,700i,900,900i" rel="stylesheet" />
<!--<![endif]-->
<style type="text/css">
body {
  margin: 0;
  padding: 0;
  -webkit-text-size-adjust: 100% !important;
  -ms-text-size-adjust: 100% !important;
  -webkit-font-smoothing: antialiased !important;
}
img {
  border: 0 !important;
  outline: none !important;
}
p {
  Margin: 0px !important;
  Padding: 0px !important;
}
table {
  border-collapse: collapse;
  mso-table-lspace: 0px;
  mso-table-rspace: 0px;
}
td, a, span {
  border-collapse: collapse;
  mso-line-height-rule: exactly;
}
.ExternalClass * {
  line-height: 100%;
}
.em_blue a {text-decoration:none; color:#264780;}
.em_grey a {text-decoration:none; color:#434343;}
.em_white a {text-decoration:none; color:#ffffff;}

@media only screen and (min-width:481px) and (max-width:649px) {
.em_main_table {width: 100% !important;}
.em_wrapper{width: 100% !important;}
.em_hide{display:none !important;}
.em_aside10{padding:10px !important;}
.em_h20{height:20px !important; font-size: 1px!important; line-height: 1px!important;}
.em_h10{height:10px !important; font-size: 1px!important; line-height: 1px!important;}
.em_aside5{padding:0px 10px !important;}
.em_ptop2 { padding-top:8px !important; }
}
@media only screen and (min-width:375px) and (max-width:480px) {
.em_main_table {width: 100% !important;}
.em_wrapper{width: 100% !important;}
.em_hide{display:none !important;}
.em_aside10{padding:10px !important;}
.em_aside5{padding:0px 8px !important;}
.em_h20{height:20px !important; font-size: 1px!important; line-height: 1px!important;}
.em_h10{height:10px !important; font-size: 1px!important; line-height: 1px!important;}
.em_font_11 {font-size: 12px !important;}
.em_font_22 {font-size: 22px !important; line-height:25px !important;}
.em_w5 { width:7px !important; }
.em_w150 { width:150px !important; height:auto !important; }
.em_ptop2 { padding-top:8px !important; }
u + .em_body .em_full_wrap { width:100% !important; width:100vw !important;}
}
@media only screen and (max-width:374px) {
.em_main_table {width: 100% !important;}
.em_wrapper{width: 100% !important;}
.em_hide{display:none !important;}
.em_aside10{padding:10px !important;}
.em_aside5{padding:0px 8px !important;}
.em_h20{height:20px !important; font-size: 1px!important; line-height: 1px!important;}
.em_h10{height:10px !important; font-size: 1px!important; line-height: 1px!important;}
.em_font_11 {font-size: 11px !important;}
.em_font_22 {font-size: 22px !important; line-height:25px !important;}
.em_w5 { width:5px !important; }
.em_w150 { width:150px !important; height:auto !important; }
.em_ptop2 { padding-top:8px !important; }
u + .em_body .em_full_wrap { width:100% !important; width:100vw !important;}
}
p {
display: block!important;
margin-bottom: 15px!important;
}
</style>
'.$video_css.'
</head>
<body class="em_body" style="margin:0px auto; padding:0px;" bgcolor="#efefef">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="em_full_wrap" align="center"  bgcolor="#efefef">
    <tr>
      <td align="center" valign="top"><table align="center" width="650" border="0" cellspacing="0" cellpadding="0" class="em_main_table" style="width:650px; table-layout:fixed;">
          <tr>
            <td align="center" valign="top" style="padding:0 25px;" class="em_aside10"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td height="25" style="height:25px;" class="em_h20">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/'.$logo.'" width="160" alt="" border="0" style="display:block; font-family:Arial, sans-serif; font-size:18px; text-align:center; color:#1d4685; font-weight:bold; max-width:208px;" class="em_w150" /></a></td>
              </tr>
              <tr>
                <td height="28" style="height:28px;" class="em_h20">&nbsp;</td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="em_full_wrap" align="center" bgcolor="#efefef">
    <tr>
      <td align="center" valign="top" class="em_aside5"><table align="center" width="650" border="0" cellspacing="0" cellpadding="0" class="em_main_table" style="width:650px; table-layout:fixed;">

          <tr>
            <td align="center" valign="top" style="padding:10px;background-color:#ffffff;" class="em_aside10"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <img class="center" alt="" style="width: 100%;max-width: 630px;" src="'.$CRMLink.'images/users/images/'.$header_image.'"/> 
              '.$video_get.'
                <tr>
                <td height="45" style="height:45px;" class="em_h20">&nbsp;</td>
              </tr>
              <tr>
                <td class="em_blue em_font_22" align="center" valign="top" style="font-family: Arial, sans-serif; font-size: 26px; line-height: 29px; color:#264780; font-weight:bold;">'.$email_title.'</td>
              </tr>
              <tr>
                <td height="14" style="height:14px; font-size:0px; line-height:0px;">&nbsp;</td>
              </tr>
              <tr>
                <td class="em_grey" align="left" valign="top" style="font-family: Arial, sans-serif; font-size: 16px;padding: 10px; line-height: 26px; color:#434343;">
                <p>Hi '.$FIRST_NAME.' '.$LAST_NAME.',</p>
                    '.$email_text.'
                </td>
              </tr>
              <tr>
                <td height="26" style="height:26px;" class="em_h20">&nbsp;</td>
              </tr>
              <tr>
                '.$button.' 
              </tr>
              <tr>
                <td height="25" style="height:25px;" class="em_h20">&nbsp;</td>
              </tr>
              <tr>
                <td class="em_grey" align="center" valign="top" style="font-family: Arial, sans-serif; font-size: 16px; line-height: 26px; color:#434343;">
                <!--Always Add Text Here Later -->  
                </td>
              </tr>
              <tr>
                <td height="44" style="height:44px;" class="em_h20">&nbsp;</td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="em_full_wrap" align="center" bgcolor="#efefef">
    <tr>
      <td align="center" valign="top"><table align="center" width="650" border="0" cellspacing="0" cellpadding="0" class="em_main_table" style="width:650px; table-layout:fixed;">
          <tr>
            <td align="center" valign="top" style="padding:0 25px;" class="em_aside10"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td height="40" style="height:40px;" class="em_h20">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                    '.$social_media_follow.'
                    </tr>
                  </table>
                 </td>
              </tr>
              <tr>
               <td height="16" style="height:16px; font-size:1px; line-height:1px; height:16px;">&nbsp;</td>
              </tr>
              <tr>
                <td class="em_grey" align="center" valign="top" style="font-family: Arial, sans-serif; font-size: 15px; line-height: 18px; color:#434343; font-weight:bold;">Contact Us</td>
              </tr>
              <tr>
                <td height="10" style="height:10px; font-size:1px; line-height:1px;">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top" style="font-size:0px; line-height:0px;"><table border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td width="15" align="left" valign="middle" style="font-size:0px; line-height:0px; width:15px;">
                    <a href="mailto:'.$rowupdate['email'].'" style="text-decoration:none;">
                    <img src="'.$CRMLink.'images/users/images/email_img.png" width="15" height="12" alt="" border="0" style="display:block; max-width:15px;" /></a>
                    </td>
                    <td width="9" style="width:9px; font-size:0px; line-height:0px;" class="em_w5">
                    <img src="'.$CRMLink.'images/users/images/email.gif" width="1" height="1" alt="" border="0" style="display:block;" />
                    </td>
                    <td class="em_grey em_font_11" align="left" valign="middle" style="font-family: Arial, sans-serif; font-size: 13px; line-height: 15px; color:#434343;">
                    <a href="mailto:'.$rowupdate['email'].'" style="text-decoration:none; color:#434343;">'.$rowupdate['email'].'</a> <a href="mailto:'. $rowupdate['email'].'" style="text-decoration:none; color:#434343;">[mailto:'.$rowupdate['email'].']</a>
                    </td>
                  </tr>
                </table>
                </td>
              </tr>
               <tr>
                <td height="9" style="font-size:0px; line-height:0px; height:9px;" class="em_h10"><img src="images/users/images/email.gif" width="1" height="1" alt="" border="0" style="display:block;" /></td>
              </tr>
               <tr>
                <td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td width="12" align="left" valign="middle" style="font-size:0px; line-height:0px; width:12px;"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/address.png" width="12" height="16" alt="" border="0" style="display:block; max-width:12px;" /></a></td>
                    <td width="7" style="width:7px; font-size:0px; line-height:0px;" class="em_w5">&nbsp;</td>
                    <td class="em_grey em_font_11" align="left" valign="middle" style="font-family: Arial, sans-serif; font-size: 13px; line-height: 15px; color:#434343;">
                    <a href="#" target="_blank" style="text-decoration:none; color:#434343;">'.$rowupdate['business_name'].'</a> 
                    &bull; '.$rowupdate['address'].' &bull; '.$rowupdate['city'].', '.$rowupdate['state'].' '.$rowupdate['zip'].'</td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td height="35" style="height:35px;" class="em_h20">&nbsp;</td>
              </tr>
            </table>
            </td>
          </tr>
           <tr>
            <td height="1" bgcolor="#dadada" style="font-size:0px; line-height:0px; height:1px;"><img src="'.$CRMLink.'images/users/images/email.gif" width="1" height="1" alt="" border="0" style="display:block;" /></td>
          </tr>
           <tr>
            <td align="center" valign="top" style="padding:0 25px;" class="em_aside10"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td height="16" style="font-size:0px; line-height:0px; height:16px;">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="left" class="em_wrapper">
                  <tr>
                    <td class="em_grey" align="center" valign="middle" style="font-family: Arial, sans-serif; font-size: 11px; line-height: 16px; color:#434343;">&copy; '.date('Y').' '.$rowupdate['business_name'].' &nbsp;|&nbsp; <a href="'.$CRMLink.'forms/unsubscribe.php?user_id'.$USERID.'&email='.$EMAIL_SEND.'" target="_blank" style="text-decoration:underline; color:#434343;">Unsubscribe</a>
                    <img style="display: none;" src="'.$CRMLink.'forms/emailtrack.php?image=tracking.gif&user_id='.$USERID.'&email_id='.$EMAILID.'&email='.$EMAIL_SEND.'" alt="Neil Betrue">
                    </td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td height="16" style="font-size:0px; line-height:0px; height:16px;">&nbsp;</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td class="em_hide" style="line-height:1px;min-width:600px;background-color:#ffffff;"><img alt="" src="'.$CRMLink.'images/users/images/email.gif" height="1" width="600" style="max-height:1px; min-height:1px; display:block; width:600px; min-width:600px;" border="0" /></td>
          </tr>
        </table>
      </td>
    </tr>
</table>                                
</body>
</html>';    


  

} else { 
    
    
    
    
    
$email_html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html lang="en">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>'.$business_name.' Email</title>

  <style type="text/css">
    
    /* Outlines the grids, remove when sending */
    table td { border: 0px solid #eee; }

    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode: bicubic; }

    /* RESET STYLES */
    img { border: 0; outline: none; text-decoration: none; }
    table { border-collapse: collapse !important; }
    body { margin: 0 !important; padding: 0 !important; width: 100% !important; }

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }

    /* MEDIA QUERIES */
    @media all and (max-width:639px){ 
      .wrapper{ width: 100%;max-width:600px!important; }
      .container{ width: 100%;max-width:600px!important; }
      .mobile{ width: 100%;max-width:200px!important; display:block!important;float: left;margin: 0 auto; }
      .img{ width:100% !important; height:auto !important; }
      *[class="mobileOff"] { width: 0px !important; display: none !important; }
      *[class*="mobileOn"] { display: block !important; max-height:none !important; }
    }
      .btn-primary  {
        background: #3498db!important;
        border: solid 1px #3498db;
        margin-bottom: 20px!important;
      }
      .btn-primary:hover {
        background: #34495e !important;
        border-color: #34495e !important;
      }
    p {
      line-height: 25px;
      }
  </style>
  '.$video_css.'
</head>

<body style="margin:0; padding:0; background-color:#F2F2F2;">
 <br>
 
  <span style="display: block; width: 640px !important; max-width: 640px; height: 1px" class="mobileOff"></span>
  
  <center>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
      <tr>
        <td align="center" valign="top">
            
          <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">

            <tr>
              <td align="center" valign="top">

                <table width="640" cellpadding="0" cellspacing="0" border="0" class="container">
                  <tr>
                    <td align="center" valign="top">
                      <img class="center" src="'.$CRMLink.'images/users/images/'.$header_image.'" style="width: 98%;padding-top: 5px;" alt=""/>
                    </td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
            </tr>
          </table>
		  
		  '.$video_get.'

          <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
            <tr>
              <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="top">

                <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                  <tr>
                    <td align="justify" valign="top" style="padding: 15px;color: #000;">
                    <h1 style="margin-top: 0px;">'.$email_title.'</h1>
					<p>Hi '.$FIRST_NAME.' '.$LAST_NAME.',</p>
                    '.$email_text.'
                    </td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
            </tr>
          </table>  
             
          '.$template_blocks.'
		  
            
          <!-- START FOOTER -->
            <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
 
                <tr>
                  <td class="content-block" style="background-color: #333333!important;font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">

                  <span class="apple-link" style="color: #fff; font-size: 18px; text-align: center;font-weight: bold;margin-top: 20px;display: block;position: relative;">Follow Us</span><br>
				<span class="apple-link" style="color: #fff; font-size: 20px; text-align: center;">

				'.$social_media_follow.'

				</span>
				<br><br>

                <hr style="width: 100%;margin-bottom: 30px;">
                    <span class="apple-link" style="color: #fff; font-size: 12px; text-align: center;line-height: 20px;">
					<strong style="font-size: 16px;">'.$rowupdate['business_name'].'</strong><br>
					<strong style="font-size: 16px;">Email:</strong> '.$rowupdate['email'].'<br>
					<strong style="font-size: 16px;">Phone:</strong> '.$phone.'<br>
					<strong style="font-size: 16px;">Our Address:</strong><br>
					'.$rowupdate['address'].' - '.$rowupdate['city'].' '.$rowupdate['state'].', '.$rowupdate['zip'].'
					</span> 
					<span class="apple-link" style="color: #fff; font-size: 12px; text-align: center;line-height: 20px;">
                    <p style="color: #fff;font-size: 10px;padding: 12px;line-height: 15px;">
                    Copyright © '.$year.' '.$business_name.', All rights reserved.<br>
					You are receiving this email because you opted in via our website.<br>
                   <a href="'.$CRMLink.'forms/email-html.php?user_id='.$USERID.'&email_id='.$EMAILID.'" style="text-decoration: underline; color: #fff; font-size: 12px; text-align: center;">View HTML of email</a><br>
                 <img style="display: none;" src="'.$CRMLink.'forms/emailtrack.php?image=tracking.gif&user_id='.$USERID.'&email_id='.$EMAILID.'&email='.$EMAIL_SEND.'" alt="Neil Betrue">
          
                    Dont like these emails? <a href="'.$CRMLink.'forms/unsubscribe.php?user_id'.$USERID.'&email='.$EMAIL_SEND.'" style="text-decoration: underline; color: #fff; font-size: 12px; text-align: center;">Unsubscribe</a>.</p></span>
                  </td>
                </tr>
              </table>
            <!-- END FOOTER -->  
        </td>
      </tr>
    </table>
  </center>
</body>
</html>
<br />
<p style="font-size: 12px;padding-left: 15px;padding-right: 15px;text-align: justify;">DISCLAIMER: This email contains confidential and privileged material, and are for the sole use of the intended recipient. Use or distribution by an unintended recipient is prohibited, and may be a violation of law. If you believe that you received this e-mail in error, please do not read this e-mail or any attached items. Please delete the e-mail and all attachments, including any copies thereof, and inform the sender that you have deleted the e-mail, all attachments and any copies thereof. This form is provided by bTrue Church CRM & LMS.</p><br /><br />';    
    

}    
    
    
 
$params = array(

'from' => $emailfrom,

'to' => $EMAIL_SEND,

'subject' => $email_subject,
	
'html' => $email_html

 );
if($EMAIL_SEND =='test@test.com') { } else { 
$result = $mgClient->messages()->send($domain, $params);
echo print_r($result);        
}
   
}

$update = 'UPDATE email_create SET `sent` ="true" where user_id ="'.$USERID.'" AND email_id="'.$EMAILID.'"';
$updatedb = mysqli_query($conn,$update); 
	
$total = $i;	
mysqli_query($conn,"INSERT INTO`email_sent`(`user_id`, `email_id`, `sent`, `total`,`datetime`) VALUES ('$USERID', '$email_name', 'true','$total ','$date_time')");       
    
    
//END EMAIL QUERY
}


//Reset Dates For Holidays
$queryapp = "SELECT * FROM email_drips where date='".$date."'";
$query_app = mysqli_query($conn,$queryapp);
while($app = mysqli_fetch_array($query_app)) { 
    

if($app['template_id'] =='newyears') {   
$update = 'UPDATE email_drip SET `date` ="December 31, 2021" WHERE template_id ="newyears"';
$updatedb = mysqli_query($conn,$update); 
}
    
if($app['template_id'] =='martinlutherkingday') {   
$update = 'UPDATE email_drip SET `date` ="January 17, 2022" WHERE template_id ="martinlutherkingday"';
$updatedb = mysqli_query($conn,$update); 
} 
    
if($app['template_id'] =='memorialday') {   
$update = 'UPDATE email_drip SET `date` ="January 17, 2022" WHERE template_id ="memorialday"';
$updatedb = mysqli_query($conn,$update); 
}    

if($app['template_id'] =='easter') {   
$update = 'UPDATE email_drip SET `date` ="January 17, 2022" WHERE template_id ="easter"';
$updatedb = mysqli_query($conn,$update); 
}  
    
if($app['template_id'] =='laborday') {   
$update = 'UPDATE email_drip SET `date` ="September 6, 2021" WHERE template_id ="laborday"';
$updatedb = mysqli_query($conn,$update); 
}  
    
if($app['template_id'] =='thanksgiving') {   
$update = 'UPDATE email_drip SET `date` ="November 24, 2021" WHERE template_id ="thanksgiving"';
$updatedb = mysqli_query($conn,$update); 
}  
    
if($app['template_id'] =='christmas') {   
$update = 'UPDATE email_drip SET `date` ="December 24, 2021" WHERE template_id ="christmas"';
$updatedb = mysqli_query($conn,$update); 
}  
if($app['template_id'] =='halloween') {   
$update = 'UPDATE email_drip SET `date` ="October 31, 2021" WHERE template_id ="halloween"';
$updatedb = mysqli_query($conn,$update); 
}  
if($app['template_id'] =='4thofjuly') {   
$update = 'UPDATE email_drip SET `date` ="July 4, 2021" WHERE template_id ="4thofjuly"';
$updatedb = mysqli_query($conn,$update); 
}  

}
?>