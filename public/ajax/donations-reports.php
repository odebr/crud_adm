<?php 
$USERID = $_REQUEST['user_id'];
$batch = $_REQUEST['batch'];
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

	
		if($_REQUEST['batch'] !='') { 
			
			
			
		if($enddate == '0'){ 	
		$queryn = "SELECT * FROM  `fund_form` WHERE user_id = '".$USERID."' AND batch = '".$_REQUEST['batch']."' AND receive_date >= '".$startdate."' ORDER BY  `fund_form`.`id` ASC"; 
		}else{ 
		$queryn = "SELECT * FROM  `fund_form` WHERE user_id = '".$USERID."' AND batch = '".$_REQUEST['batch']."' AND receive_date >= '".$startdate."' AND receive_date <= '".$enddate."' ORDER BY  `fund_form`.`id` ASC"; 	  
		}	
		} else { 

			
		if($enddate == '0'){  	  
        $queryn = "SELECT * FROM  `fund_form` WHERE user_id = '".$USERID."' AND receive_date >= '".$startdate."' ORDER BY  `fund_form`.`id` ASC";   
		  }else{ 
		$queryn = "SELECT * FROM  `fund_form` WHERE user_id = '".$USERID."' AND receive_date >= '".$startdate."' AND receive_date <= '".$enddate."' ORDER BY  `fund_form`.`id` ASC";	  
		}
	
		}
	


        $resn = mysqli_query($conn,$queryn);
        $count = mysqli_num_rows($resn);
        while($row=mysqli_fetch_array($resn)){ 

                         $total = $row['price'];
                         $total_all = $total_all+$total;
?>
            <tr>   

            <td data-label="Receive Date" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;"><?php echo $row['receive_date']; ?></td>
            <td data-label="Name" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;"><?php echo $row['user_name']; ?></td>
            <td data-label="Category" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;"><?php echo $row['fund_type']; ?></td>
            <td  data-label="Amount" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;color: green;">$<?php echo number_format($row['price'], 2); ?></td>
                
            <td  data-label="Action" style="color: #666;font-size: 14px;padding-top: 20px!important;padding-bottom: 20px!important;color: green;">
            <?php if($row['contact_id'] =='Unassociated') { ?>
			<a style="padding: 0px;margin: 0px;background: transparent;float: left;display: block;border: none;" href="#Unassociated" class="fancybox">	 
			<?php } else { ?>
			<a style="padding: 0px;margin: 0px;background: transparent;float: left;display: block;border: none;" href="view-contact?contact_id=<?php echo $row['contact_id']; ?>&donation=true">	 
			<?php } ?>
            <i style="font-size: 12px!important;padding: 0px;" class="fas fa-edit"></i></a> 
                
            <a href="javascript:void(0);" onClick="return deleteentryrow('<?php echo $row['id']; ?>');" style="padding: 0px;margin: 0px;background: transparent;float: left;display: block;border: none;margin-left: 10px;"><i style="font-size: 12px!important;padding: 0px;color: red;" class="fas fa-trash-alt" aria-hidden="true"></i></a></td>
                 
            </tr>
        <?php } ?>
        </tbody>
      </table>     
<?php echo $msg; } ?>

<div id="Unassociated" style="width: 100%; width:600px;display: none;">
<h2 style="color: #333; text-align: center;font-weight: bold;margin-bottom: 10px;">Unassociated</h2>
<div style="clear:both':"></div>
<p style="text-align: center;">This donation is not associated with any contact...</p>				
				
				
				
</div>

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