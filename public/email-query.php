<?php

if(isset($_GET['template'])){if($_GET['template']!=''){$_GET['template'] = $_GET['template']; } } else{$_GET['template'] ='none'; $page = $_GET['template']; }
if(isset($_REQUEST['email_id'])){if($_REQUEST['email_id']!=''){}  }else{$_REQUEST['email_id'] ='';  }
$page = $_GET['template'];
$USERID = session('user')['user_id'];
$logged_in_user = Auth::user()->email;
$profile= DB::table('settings')->where('user_id', $USERID)->first();
$account_type= $profile->account_type;
$business_name = $profile->business_name;
$name = $profile->first_name.' '.$profile->last_name;
$phone = $profile->phone;
$mobile = $profile->cell;
$facebook = $profile->facebook;
$twitter = $profile->twitter;
$instagram= $profile->instagram;
$snapchat = $profile->snapchat;
$linkedin = $profile->linkedin;
$twitter = $profile->twitter;
$google = $profile->google;

//Main Connection
include('conn.php');

//All request
$result = mysqli_query($conn,"Select * from email_template");
$exclude = Array();
while ( $row = mysqli_fetch_assoc($result) ) {
$exclude[] = $row['email_id'];
}
do
{
$random_number = mt_rand(10000000, 99999999);
}while(in_array($random_number, $exclude)); 
$email_id_random = $random_number;    
    
$email_id = $_REQUEST['email_id']; 
$email_id_url = 'email_id='.$email_id_random;
	
//Generate New ID FOR HERE	


$queryapp = "SELECT * FROM email_template where user_id ='".$USERID."' AND email_id='".$email_id ."'";
$query_app = mysqli_query($conn,$queryapp);
$app   = mysqli_fetch_array($query_app);
$email_count = @mysqli_num_rows($query_app);	
	
$email_id = $app['email_id'];
$email_name = $app['email_name'];
$title = $app['title'];
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
$drip = $app['drip'];
$date = $app['date'];
$time = $app['time'];
$video = $app['video'];


if($header_image =='') { $header_image = 'PH.jpg'; } 	
if($email_name =='') { $email_name = 'Untitled';} 
if($email_from =='') { $email_from = $profile->business_name; }
if($email_subject =='') { $email_subject = 'Subject'; }    
if($email_text =='') { 
$email_text = '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p> ';
}   
if($block_one =='') { $block_one = 'plceholder.jpg'; }   
if($block_two =='') { $block_two = 'plceholder.jpg'; }    
if($block_three =='') { $block_three = 'plceholder.jpg'; }      

	if($email_id =='') { 
	$email_id = $_REQUEST['email_id'];  
	}
$submiturl = 'https://'.$_SERVER['SERVER_NAME'].'/forms/email-templates.php?user_id='.$USERID.'&email_id='.$email_id;

//Check For Video
//Check For Video
$video_css = '';
$video_get = '';
if($video !='') { 

$queryl = "SELECT * FROM  `video` WHERE user_id = '".$USERID."' AND video_id='".$video."' AND type='gif'";   
$resnl = mysqli_query($conn,$queryl);
$rowlistings = mysqli_fetch_array($resnl);
$video_id = $rowlistings['video_id'];
$GIF = $rowlistings['video_name'];


$video_css = "
<style>
#frame
	{
		width: 98%;
		max-width: 640px;
		height: 100%;
		max-height: 360px;
		background: url('https://crm.btruleads.com/video/uploads/".$GIF."') no-repeat;
		text-align: center;
	}
	.centerer
	{
		display: inline-block;
		height: 100%;
		vertical-align: middle;
		width: 500px!important;
		max-width: 640px;

		
	}
	#frame .centerer img
	{
        width: 98%;
		max-width: 640px!important;
		height: 100%;
		max-height: 360px;
		
	}
</style>";



		  
$video_get = '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="wrappere" bgcolor="#FFFFFF">

            <tr>
              <td align="center" valign="top">

                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="containere">
                  <tr>
                    <td align="center" valign="top">
					<div style="padding-top: 5px;">
					<a href="https://btruleads.com/users/vp.php?user_id='.$USERID.'&video_id='.$video.'">
					<div id="frame">
					<span class="centerer"><img src="https://crm.btruleads.com/forms/images/play.png"/></span>
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
  
?>