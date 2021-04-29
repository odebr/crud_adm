<?php
//require_once('../../vendor/autoload.php');

require_once('/home/btruleads/crm.btruleads.com/vendor/autoload.php');

use Mailgun\Mailgun;

date_default_timezone_set('America/Phoenix');

$date_time = date("Y-m-d H:i:s"); 
$year = date('Y');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//Main Connection
include('conn.php');



$USERID = '1515483848';
$invoice_number = '1006';
$contact_id = '1549735387'; 
							//$invoice_number = $_REQUEST['invoice_number'];
							//$contact_id = $_REQUEST['contact_id'];
		  
                            $queryn = "SELECT * FROM  `contacts` WHERE user_id = '".$USERID."' AND contact_id = '".$contact_id."'";
                            $resn = mysqli_query($conn,$queryn);
                            $row = @mysqli_fetch_array($resn);
                            $first_name = $row['first_name'];
                            $last_name = $row['last_name'];          
                            $contact_name = $first_name.' '.$last_name;
                            $contact_email = $row['email'];
		  
		  					$queryn = "SELECT * FROM  `invoices` WHERE user_id = '".$USERID."' AND invoice_number = '".$invoice_number."'";
							$resn = mysqli_query($conn,$queryn);
							$row = mysqli_fetch_array($resn);
							$due_date = $row['due_date'];
		                    $TOTAL = $row['total'];
		                    $items = '';
						    $queryn = "SELECT * FROM  `invoices` WHERE user_id = '".$USERID."' AND invoice_number = '".$invoice_number."'";
							$resn = mysqli_query($conn,$queryn);
							while($row = mysqli_fetch_array($resn)) { 
							$items.='<tr style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">'.$row['product_service'].'</td>
                            <td class="alignright" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">$'.$row['amount'].'</td></tr>';
							} 	
		  
		  
$contact_email = 'neilbetrue@gmail.com';							
if($contact_email !='') { 							
$queryn = "SELECT * FROM  `settings` WHERE user_id = '".$USERID."'";
$resn = mysqli_query($conn,$queryn);
$row = mysqli_fetch_array($resn);    
$logo = $row['logo'];
$business_name = $row['business_name'];
$email = $row['email'];
$address = $row['address'];
$city = $row['city'];
$state = $row['state'];
$zip = $row['zip'];
$phone = $row['phone'];	
	
$emailfrom = $business_name.' <no-reply@btruleads.com>';
	
$EMAIL_SEND = $contact_email;
	
	
	
	
$email_subject = 'Your Invoice';
	
							
if($EMAIL_SEND !='') 							
							
$html = '<!DOCTYPE html>
<html  style="font-family: , Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
body {
  margin: 0;
  padding: 0;
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
  .invoice {
    width: 100% !important;
  }
  .invoice-items {
    width: 100% !important;
    }
.invoice .invoice-items td {     
border: 1px #000 solid !important;
padding: 5px;
  }
</style>

</head>
<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="em_full_wrap" align="center"  bgcolor="#efefef">
    <tr>
      <td align="center" valign="top"><table align="center" width="650" border="0" cellspacing="0" cellpadding="0" class="em_main_table" style="width:650px; table-layout:fixed;">
          <tr>
            <td align="center" valign="top" style="padding:0 25px;" class="em_aside10"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td height="26" style="height:26px;" class="em_h20">&nbsp;</td>
              </tr>
                 <tr>
                <td align="center" valign="top"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/'.$logo.'" width="200" alt="" border="0" style="display:block; font-family:Arial, sans-serif; font-size:18px; line-height:25px; text-align:center; color:#1d4685; font-weight:bold; max-width:208px;" class="em_w150" /></a></td>
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
            <td align="center" valign="top" style="padding:0 25px; background-color:#ffffff;" class="em_aside10"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td height="25" style="height:25px;" class="em_h10">&nbsp;</td>
              </tr>

              <tr>
              
              <td class="em_blue em_font_22" align="center" valign="top" style="font-family: Arial, sans-serif; font-size: 26px; line-height: 29px; color:#264780; font-weight:bold;padding-top: 25px!important;padding-bottom: 25px!important;">Thanks so much for choosing <br>'.$business_name.'</td>
              
              </tr>

			   <table class="invoice" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; text-align: left; width: 80%; margin: 40px auto;">
               <tr style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; margin: 0;">
               <td style="font-family: Arial, sans-serif; font-size: 16px; line-height: 22px; color:#434343;" valign="top">Lee Munroe
               <br style="font-family: Arial, sans-serif; font-size: 16px; line-height: 22px; color:#434343;" />Invoice #12345
               <br style="font-family: Arial, sans-serif; font-size: 16px; line-height: 22px; color:#434343;" />Due Date: June 01 2014
               </td>
               </tr>
                      
                      
                      <tr style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
                          <table class="invoice-items" cellpadding="0" cellspacing="0" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; width: 100%; margin: 0;">
                          
                          
                          
                          
                          
                          
                          
                          <tr style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; margin: 0;border: 1px #000 solid !important;">
                          
                          <td style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;border: 1px #000 solid !important;" valign="top">Service 1</td>
   
                              <td class="alignright" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;border: 1px #000 solid !important;" align="right" valign="top">$19.99</td>
                              
                              
                              
                              
   
                            </tr>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            

                            <tr style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">Service 2</td>
                              <td class="alignright" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">$ 9.99</td>
                            </tr><tr style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" valign="top">Service 3</td>
                              <td class="alignright" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">$ 4.00</td>
                            </tr><tr class="total" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="alignright" width="80%" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;" align="right" valign="top">Total</td>
                              <td class="alignright" style="font-family: ,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;" align="right" valign="top">$ 33.98</td>
                            </tr>
                                </table>
                                </td>
                             </tr>
                        </table>

              <tr>
                <td height="15" style="height:15px; font-size:1px; line-height:1px;">&nbsp;</td>
              </tr>
              <tr>
              </tr>
              <tr>
                <td height="20" style="height:20px; font-size:1px; line-height:1px;">&nbsp;</td>
              </tr>
              <tr>
  
                <td align="center" valign="top"><table width="145" style="width:145px; background-color:#6bafb2; border-radius:4px;" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#6bafb2">
                  <tr>
                   <td class="em_white" height="42" align="center" valign="middle" style="font-family: Arial, sans-serif; font-size: 16px; color:#ffffff; font-weight:bold; height:42px;"><a href="'.$CRMLink.'payment/invoice/?user_id='.$USERID.'&invoice='.$invoice_number.'" target="_blank" style="text-decoration:none; color:#ffffff; line-height:42px; display:block;">Pay Invoice</a>
					</td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td height="40" style="height:40px;" class="em_h10">&nbsp;</td>
              </tr>
            </table>
            </td>
          </tr>

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
                      <td width="30" style="width:30px;" align="center" valign="middle"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/social-icons/Facebook.png" width="30" height="30" alt="FaceBook" border="0" style="display:block; font-family:Arial, sans-serif; font-size:18px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a></td>
                      <td width="12" style="width:12px;">&nbsp;</td>
                      
                      
                      <td width="30" style="width:30px;" align="center" valign="middle"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/social-icons/Twitter.png" alt="Twitter" border="0" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a></td>
                      <td width="12" style="width:12px;">&nbsp;</td>
                      
                      
                      <td width="30" style="width:30px;" align="center" valign="middle"><a href="#" target="_blank" style="text-decoration:none;"><img src="'.$CRMLink.'images/users/images/social-icons/Instagram.png" width="30" height="30" alt="Instagram" border="0" style="display:block; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:center; color:#000000; font-weight:bold; max-width:30px;" /></a></td>
                    </tr>
                  </table>
                 </td>
              </tr>
              <tr>
                <td height="16" style="height:16px; font-size:1px; line-height:1px; height:16px;">&nbsp;</td>
              </tr>
              <tr>
                <td class="em_grey" align="center" valign="top" style="font-family: Arial, sans-serif; font-size: 15px; line-height: 18px; color:#434343; font-weight:bold;">Problems or questions?</td>
              </tr>
              <tr>
                <td height="10" style="height:10px; font-size:1px; line-height:1px;">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top" style="font-size:0px; line-height:0px;"><table border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
        
                    <td class="em_grey em_font_11" align="left" valign="middle" style="font-family: Arial, sans-serif; font-size: 13px; line-height: 15px; color:#434343;"> 
                    <a href="mailto:'.$email.'" style="text-decoration:none; color:#434343;">'.$email.'</a></td>
                  </tr>
                </table>
                </td>
              </tr>
               <tr>
                <td height="9" style="font-size:0px; line-height:0px; height:9px;" class="em_h10"><img src="/images/users/images/spacer.gif" width="1" height="1" alt="" border="0" style="display:block;" /></td>
              </tr>
               <tr>
                <td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td width="12" align="left" valign="middle" style="font-size:0px; line-height:0px; width:12px;"></td>
                    <td width="7" style="width:7px; font-size:0px; line-height:0px;" class="em_w5">&nbsp;</td>
                    <td class="em_grey em_font_11" align="left" valign="middle" style="font-family: Arial, sans-serif; font-size: 13px; line-height: 15px; color:#434343;"> '.$address.' &bull; '.$city.' &bull; '.$state.' &bull; '.$zip.'</td>
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
            <td height="1" bgcolor="#dadada" style="font-size:0px; line-height:0px; height:1px;"><img src="/images/users/images/spacer.gif" width="1" height="1" alt="" border="0" style="display:block;" /></td>
          </tr>
           <tr>
            <td align="center" valign="top" style="padding:0 25px;" class="em_aside10"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td height="16" style="font-size:0px; line-height:0px; height:16px;">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="left" class="em_wrapper">
                  <tr>
                    <td class="em_grey" align="center" valign="middle" style="font-family: Arial, sans-serif; font-size: 11px; line-height: 16px; color:#434343;">&copy;'.date('Y').' '.$business_name.'</td>
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
            <td class="em_hide" style="line-height:1px;min-width:650px;background-color:#efefef;"><img alt="" src="/images/users/images/spacer.gif" height="1" width="650" style="max-height:1px; min-height:1px; display:block; width:650px; min-width:650px;" border="0" /></td>
          </tr>
        </table>
      </td>
    </tr>
</table>
</body>
</html>';
	
	
                            //MAILGUN SEND
                            $mgClient = Mailgun::create('b1ad43ef59bf01d5efc19ddf23630a93-9dda225e-bc7f42a9');
                            $domain = "crm.btruleads.com";
                            //'text' => 'Testing some Mailgun awesomness!'
                            $params = array(

                            'from' => $emailfrom,

                            'to' => $EMAIL_SEND,

                            'subject' => $email_subject,

                            'html' => $html	

                            );
                            echo $result = $mgClient->messages()->send($domain, $params);
	
}




?>