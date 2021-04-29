<!doctype html>
<html lang="en">
<head>
<title>bTru CRM</title>
<link rel="stylesheet" href="css/sweetalert2.css" />
<script src="js/sweetalert2.all.min.js"></script>
</head>
<body>
<?php
require_once('../../vendor/autoload.php');


use Mailgun\Mailgun;
	

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'onboardsubmission'){ 
		

                            //Main Connection
                            include('conn.php');
                            $USERID = time();
                            $company_name = @mysqli_real_escape_string($conn,$_REQUEST['name_company']);
                            $license = $_REQUEST['license'];
                            $account_type = $_REQUEST['industry'];
                            $name_first = @mysqli_real_escape_string($conn,$_REQUEST['name_first']);
                            $name_last = @mysqli_real_escape_string($conn,$_REQUEST['name_last']);
                            $email = $_REQUEST['email'];
                            $phone = preg_replace('/[^0-9]+/', '', $_REQUEST['phone']);
                            $bizphone = preg_replace('/[^0-9]+/', '', $_REQUEST['bizphone']);
                            $date_expired = date('Y-m-d', strtotime("+365 days"));
                            $name =  @mysqli_real_escape_string($conn,$name_first.' '.$name_last);
                            $title = '';
                            $cell = $requestData['work_number'];          
                            $color = '00aeef';
                            $logo = 'your-logo.png';
                            $image = 'your-image.jpg';
                            $password = $_REQUEST['password'];
                            $password_match = $_REQUEST['password_match']; 
                            //Encrypt Password
                            $password = password_hash($password_match, PASSWORD_BCRYPT);

                            $date_time = date("Y-m-d H:i:s");
                            mysqli_query($conn,"INSERT INTO `settings`(`user_id`, `account_type`, `user_link`, `co_brand`, `billing_email`, `subscription_id`, `business_name`, `title`, `license`, `name`, `first_name`, `last_name`, `email`, `phone`, `cell`, `cell_provider`, `fax`, `website`, `address`, `city_state_zip`, `city`, `state`, `zip`, `color`, `logo`, `image`, `headshot`, `google`, `facebook`, `instagram`, `twitter`, `linkedin`, `snapchat`, `zillow`, `about_me_bio`, `logo58`, `logo75`, `logo120`, `logo180`, `datetime`) VALUES ('$USERID', '$account_type','','','','', '$company_name', '$title', '$license', '$name', '$name_first', '$name_last', '$email', '$bizphone', '$phone', '','','','','','','','','$color','$logo','$image','','','','','','','','','','','','','', '$date_time')"); 

                            mysqli_query($conn,"INSERT INTO `users`(`name`, `email`, `password`, `address`, `work_number`, `personal_number`, `image_path`, `state_id`, `company_id`, `user_id`, `role`, `date_expired`, `company_name`, `random_unique_number`, `remember_token`, `created_at`, `updated_at`, `company_code`, `user_number`, `stripe_id`, `card_brand`, `card_last_four`, `trial_ends_at`) VALUES ('$name', '$email','$password','$address','$bizphone','$phone', '', '$state', '$USERID', '$USERID', '1', '$date_expired', '$company_name', '$USERID', '', '$date_time', '$date_time','','','','','','$date_expired')"); 
                            $insertid = mysqli_insert_id($con);
    

                            $mgClient = Mailgun::create('b1ad43ef59bf01d5efc19ddf23630a93-9dda225e-bc7f42a9');
                            $domain = "crm.btruleads.com";
                            $mail = 'New Signup bTru Leads. Name: '.$name.' '.$email;
                            $params = array(
                            'from' => 'info@btruleads.com',
                            'to' => 'neilbetrue@gmail.com, neil@betruewebdesign.com',
                            'subject' => 'New Signup - Impact CRM',
                            'text' => $mail
                            );
                            $result = $mgClient->messages()->send($domain, $params);
                            //echo print_r($result); 
    
    
    
                            $html_email = '<!DOCTYPE html>
                            <html  style="font-family:  Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <head>
                            <meta name="viewport" content="width=device-width" />
                            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                            <title>Email Confirmation</title>
                            <style type="text/css">
                            img {
                            max-width: 100%;
                            }
                            body {
                            -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
                            }
                            body {
                            background-color: #f6f6f6;
                            }
                            @media only screen and (max-width: 640px) {
                              body {
                                padding: 0 !important;
                              }
                              h1 {
                                font-weight: 800 !important; margin: 20px 0 5px !important;
                              }
                              h2 {
                                font-weight: 800 !important; margin: 20px 0 5px !important;
                              }
                              h3 {
                                font-weight: 800 !important; margin: 20px 0 5px !important;
                              }
                              h4 {
                                font-weight: 800 !important; margin: 20px 0 5px !important;
                              }
                              h1 {
                                font-size: 22px !important;
                              }
                              h2 {
                                font-size: 18px !important;
                              }
                              h3 {
                                font-size: 16px !important;
                              }
                              .container {
                                padding: 0 !important; width: 100% !important;
                              }
                              .content {
                                padding: 0 !important;
                              }
                              .content-wrap {
                                padding: 10px !important;
                              }
                              .invoice {
                                width: 100% !important;
                              }
                            }
                            </style>
                            </head>

                            <body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

                            <table class="body-wrap" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                                <td class="container" width="600" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                                  <div class="content" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                                    <table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="alert alert-warning" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #348eda; margin: 0; padding: 20px;" align="center" bgcolor="#348eda" valign="top">
                                          Btru Leads Marketing CRM.
                                        </td>
                                      </tr><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                                          <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                Hello '.$name.'. Thank you for registering and signing up for Btru Leads Marketing CRM & Lead System. Your business is about to change. Please click button below to verify your email and login to complete your settings.
                                              </td>
                                            </tr><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                Your Username: '.$email.'
                                              </td>
                                            </tr><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                <a href="https://crm.btruleads.com/" class="btn-primary" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Click To Login</a>
                                              </td>
                                            </tr><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                                Thanks for choosing Btru Leads.
                                              </td>
                                            </tr></table></td>
                                      </tr></table><div class="footer" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                                      <table width="100%" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top"><a href="https://crm.btruleads.com/" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">crm.btruleads.com</a></td>
                                        </tr></table></div></div>
                                </td>
                                <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                              </tr></table></body>
                            </html>';

                            //Send Registration Email
                            $mgClient = Mailgun::create('b1ad43ef59bf01d5efc19ddf23630a93-9dda225e-bc7f42a9');
                            $domain = "crm.btruleads.com";
                            $params = array(
                            'from' => 'no-reply@btruleads.com',
                            'to' => $email,
                            'subject' => 'Btru Leads CRM Registration Email',
                            'text' => $html_email
                            );
                            $result = $mgClient->messages()->send($domain, $params);
                            //echo print_r($result); 

		
	                   echo '<script>
                            swal({
                            title: "Account Created!",
                            text: "We will contact you soon with next steps.",
                            type: "success"
                        }).then(function() {
                            window.location = "https://btruleads.com/thank-you-onboard.php?user_id='.$USERID.'";
                        });
                        </script>';    

    
            }

    
?>