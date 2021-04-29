<?php 

$GETEMAILCONTACT = $_REQUEST['contact_email'];
$USERID = $_REQUEST['user_id'];

if($USERID !='') { 
$msg = ''; 
$startdate = $_REQUEST['sdate'];
$enddate = $_REQUEST['edate'];
?>
 <table id="examplen" class="table table-striped table-no-borderedu table-hover" cellspacing="0" width="100%" style="width: 100%;">   
        <thead>
          <tr>
           
            <th style="text-align: left;">Date</th>
            <th style="text-align: left;">Name</th>
            <th style="text-align: left;">Category</th>
            <th style="text-align: left;">Amount</th>
			<th style="text-align: left;" class="noExport">Action</th> 
          </tr>
        </thead>
       
        <tbody>
            
        <?php

            //Main Connection
    include('../conn.php');
	    $sum=0;$total_all = '0';
        //$queryn = "SELECT * FROM  `fund_form` WHERE user_id = '".$USERID."' AND user_email = '".$GETEMAILCONTACT."' ORDER BY  `fund_form`.`id` ASC";
		
		//echo "SELECT * FROM  `fund_form` WHERE user_id = '".$USERID."' AND user_email = '".$GETEMAILCONTACT."' AND receive_date >= '".$startdate."' AND receive_date <= '".$enddate."' ORDER BY  `fund_form`.`id` ASC"; 
          if($enddate == '0'){  
        $queryn = "SELECT * FROM  `fund_form` WHERE user_id = '".$USERID."' AND user_email = '".$GETEMAILCONTACT."' AND receive_date >= '".$startdate."' ORDER BY  `fund_form`.`id` ASC";   
		  }else{ 
		$queryn = "SELECT * FROM  `fund_form` WHERE user_id = '".$USERID."' AND user_email = '".$GETEMAILCONTACT."' AND receive_date >= '".$startdate."' AND receive_date <= '".$enddate."' ORDER BY  `fund_form`.`id` ASC";	  
		}
   
            
            
        $resn = mysqli_query($conn,$queryn);
        $count = mysqli_num_rows($resn);
        while($row=mysqli_fetch_array($resn)){ 

                         $total = $row['price'];
                         $total_all = $total_all+$total;


/*$msg = '<tr>   

  <td data-label="Receive Date" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;">'.$row['receive_date'].'</td>
            <td data-label="Name" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;">'.$row['user_name'].'</td>
            <td data-label="Category" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;">'.$row['fund_type'].'</td>
            <td  data-label="Amount" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;color: green;">$'. number_format($row['price'], 2).'</td>
            </tr>'; */?>
            <tr>   

            <td data-label="Receive Date" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;"><?php echo $row['receive_date']; ?></td>
            <td data-label="Name" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;"><?php echo $row['user_name']; ?></td>
            <td data-label="Category" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;"><?php echo $row['fund_type']; ?></td>
            <td  data-label="Amount" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;color: green;">$<?php echo number_format($row['price'], 2); ?></td>
                
            <td  data-label="Action" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;color: green;">
            <a style="padding: 0px;margin: 0px;background: transparent;float: left;display: block;border: none;" href="#ajax<?php echo $row['id']; ?>" class="fancybox">
            <i style="font-size: 12px!important;padding: 0px;" class="fas fa-edit"></i></a> 
                
            <a href="javascript:void(0);" onClick="return deleteentryrow('<?php echo $row['id']; ?>');" style="padding: 0px;margin: 0px;background: transparent;float: left;display: block;border: none;margin-left: 10px;"><i style="font-size: 12px!important;padding: 0px;color: red;" class="fas fa-trash-alt" aria-hidden="true"></i></a>

            <div id="ajax<?php echo $row['id']; ?>" style="width: 100%; width:600px;display: none;">
            <h2 style="color: #333; text-align: center;font-weight: bold;margin-bottom: 10px;">Edit Donation!</h2>
            <div style="clear:both':"></div>

 					<!-- Edit Starts -->
                        <form style="" class="form-contact" id="contact" name="contact" action="<?php echo "https://".$_SERVER['SERVER_NAME'];?>/forms/donation.php?user_id=<?php echo $USERID;?>&contact_id=<?php echo $_REQUEST['contact_id'];?>" method="post">
                            
                        <script type="text/javascript">

                          $(document).ready(function() {
                            $( "#date<?php echo $row['id']; ?>" ).datepicker({
                              changeMonth: true,
                              changeYear: true
                            });

                          });    
                            $(function () {
                                $("#fundstype<?php echo $row['id']; ?>").change(function () {
                                    if ($(this).val() == "Other") {
                                        $("#Other<?php echo $row['id']; ?>").show();
                                    } else {
                                        $("#Other<?php echo $row['id']; ?>").hide();
                                    }
                                });
                            });
                        </script>                          
                            <input name="editid" id="other" type="hidden" value="<?php echo $row['id']; ?>"/>
                            
    
                                <!-- Input Field Starts -->
								<div class="form-group7 col-xs-12 col-sm-12" style="margin-top: 5px;">
								<label>Received Date</label>    
								<input style="display: block!important;color: #000!important;" id="date<?php echo $row['id']; ?>" type="text" name="recive-date" placeholder="Received Date" value="<?php echo $row['receive_date']; ?>" required/>
								</div>
								<div style="clear:both"></div>
                                <div class="form-group7 col-sm-12">
                                <label>Fund Type</label>      
                                <select class="form-control7" id="fundstype<?php echo $row['id']; ?>" name="fund-type" >
                                <option value="<?php echo $row['fund_type']; ?>"><?php echo $row['fund_type']; ?></option>
                                <option value="General Fund">General Fund</option>
                                <option value="Other">Other</option>
                                <option value="Youth Ministry">Youth Ministry</option>
                                <option value="Kids Ministry">Kids Ministry</option>
                                <option value="Tithes">Tithes</option>
                                <option value="Specail Offering">Specail Offering</option>
                                <option value="Building Fund">Building Fund</option>
                                </select>
                                </div>    
                                <div style="clear:both"></div>   
                                <div id="Other<?php echo $row['id']; ?>" class="colors Other" style="display:none;">
                                    
                                <div class="form-group7 col-sm-12" style="float: right;display: block;position: relative;margin-top: 10px;">
                                <label>Please add other.</label>     
                                <input class="form-control7" style="margin-top: 0px;" name="other" id="other" placeholder="Add Other" type="text"/>   
                                </div>
                                <div style="clear:both"></div>   
                                </div>


								<div class="form-group7 col-xs-12 col-sm-12" style="margin-top: 15px;">
								<label>Amount</label>   
								<input style="display: block!important;color: #000!important;" type="text" name="amount" placeholder="Amount" value="<?php echo number_format($row['price'], 2); ?>" required/>
								</div>
								<div style="clear:both"></div>

                                <div class="form-group7 col-sm-12">
                                <label>Payment Source</label>
                                <select class="form-control7" name="payment_source">
                                <option value="<?php echo $row['payment_source']; ?>"><?php echo $row['payment_source']; ?></option>
                                <option value="Church Offering">Church Offering</option>
                                <option value="Secure Give">Secure Give</option>
                                </select>
                                </div>
                            <div style="clear:both"></div> <br>

                            
                                <script>
                                      function dataget<?php echo $row['id']; ?>(al){
                                     if(al == 'Check'){
                                        document.getElementById('checkdata<?php echo $row['id']; ?>').style.display='block';
                                        document.getElementById('carddata<?php echo $row['id']; ?>').style.display='none';
                                    }else if(al == 'Card'){
                                        document.getElementById('checkdata<?php echo $row['id']; ?>').style.display='none';
                                        document.getElementById('carddata<?php echo $row['id']; ?>').style.display='block';	
                                    }else{
                                        document.getElementById('checkdata<?php echo $row['id']; ?>').style.display='none';
                                        document.getElementById('carddata<?php echo $row['id']; ?>').style.display='none';	
                                    }

                                }  
                                    
                            $(document).ready(function() {
                            $( "#checkdate<?php echo $row['id']; ?>" ).datepicker({
                              changeMonth: true,
                              changeYear: true
                            });

                          });    
                                </script>                      

                               <div class="form-group7 col-sm-12">
                                <label>Payment method</label>
                                <select class="form-control7" name="payment_method" onChange="dataget<?php echo $row['id']; ?>(this.value);">
                                <option>Select</option>
                                <option value="Check"<?php if($row['payment_method'] =='Check') { echo ' selected="selected"';} ?>>Check</option>
                                <option value="Cash"<?php if($row['payment_method'] =='Cash') { echo ' selected="selected"';} ?>>Cash</option>
                                <option value="Ach"<?php if($row['payment_method'] =='Ach') { echo ' selected="selected"';} ?>>Ach</option>
                                <option value="Card"<?php if($row['payment_method'] =='Card') { echo ' selected="selected"';} ?>>Card</option>
                                </select>
                                </div>
                                <div style="clear:both"></div> <br>


                                <!--check data-->
                                <div class="checkdata" id="checkdata<?php echo $row['id']; ?>" <?php if($row['payment_method'] =='Check') { } else { echo 'style="display:none;"'; } ?>>
                                <div class="form-group7 col-sm-6">
                                <label>Check #</label>
                                <input class="form-control7" name="check_no" id="check-no" type="text">
                                </div>
                                <div class="form-group7 col-sm-6">
                                <label>Check date</label>
                                <input class="form-control7" name="check_date" id="checkdate<?php echo $row['id']; ?>" type="text">
                                </div>
                                </div>



                                <!--card data-->
                                <div class="carddata" id="carddata<?php echo $row['id']; ?>" <?php if($row['payment_method'] =='Card') { } else { echo 'style="display:none;"'; } ?>>

                                <div class="form-group7 col-sm-6">
                                <label>Last 4</label>
                                <br>
                                <input class="form-control7" name="last_four" id="check-no" type="text">
                                </div>


                                <div class="form-group7 col-sm-6">
                                <label>Type</label>
                                <br>
                                <select class="form-control7" name="card_type"> 
                                <option value="">Select</option>
                                <option value="Credit"<?php if($row['card_type'] =='Credit') { echo ' selected="selected"';} ?>>Credit</option>
                                <option value="Debit"<?php if($row['card_type'] =='Debit') { echo ' selected="selected"';} ?>>Debit</option>
                                <option value="Prepaid"<?php if($row['card_type'] =='Prepaid') { echo ' selected="selected"';} ?>>Prepaid</option>
                                <option value="Unknown"<?php if($row['card_type'] =='Unknown') { echo ' selected="selected"';} ?>>Unknown</option>
                                </select>
                                </div>

                                <div style="clear:both"></div> 


                                </div>           

                                <!-- Input Field Ends -->
							    
                                <!-- Submit Form Button Starts -->

								<div class="form-group7 col-xs-12 col-sm-12" style="margin-top: 5px;">
							    <input type="hidden" name="action" value="donationeditsubmission"/>
                                <button class="btn2" id="send">Update Now!</button>
                            	</div>	
							    <div style="clear:both"></div>
							<br><br>
                            <!-- Submit Form Button Ends -->
                        </form>
	
</div>	
</td>
                 
            </tr>
        <?php } ?>
        </tbody>
      </table>     
<?php echo $msg; } ?>



<br>
<br>
<h4>Totals Overview</h4>  
<div style="clear:both"></div>	
<br>
    
<table id="example" class="table table-striped table-no-borderedu table-hover" cellspacing="0" width="100%" style="width: 100%">   

       
        <tbody>
            <tr>   
            <td data-label="Total Contributions " style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;">Total Contributions </td>
            <td data-label="Count" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;"><?php echo $count;?></td>
            </tr>
            
            <tr>   
            <td data-label="Total Amount " style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;font-weight: bold;">Total Amount</td>
            <td data-label="Total" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;color: green;">$<?php echo number_format($total_all, 2);?></td>
            </tr>
            
        </tbody>
      </table> 
    
    
    
	</div> 