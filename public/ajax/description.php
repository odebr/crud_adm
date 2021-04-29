<?php        

    //Main Connection
    include('../conn.php');
              $USERID = $_REQUEST['user_id'];
              $queryp = "SELECT * FROM  `merchant_products` WHERE user_id = '".$USERID."' AND product_name = '".$_REQUEST['dataString']."'";
              $resp = mysqli_query($conn,$queryp);
              while($rowproducts = mysqli_fetch_array($resp)) { 
				  echo strip_tags($rowproducts['description']);
			  }
?>