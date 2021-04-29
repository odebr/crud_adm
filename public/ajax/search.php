<?php
    //Main Connection
    include('../conn.php');
// Database configuration 
$dbHost     = "localhost";
$dbUsername = "btrulead_masterlogin";
$dbPassword = "laX+{FN}VV.]";
$dbName     = "btrulead_leads";

$USERID = $_REQUEST['user_id'];
// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
 
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
} 
 
// Get search term 
$searchTerm = $_GET['term']; 
 
// Fetch matched data from the database 
$query = $db->query("SELECT * FROM contacts WHERE user_id = '".$USERID."' AND first_name LIKE '%".$searchTerm."%' OR last_name LIKE '%".$searchTerm."%' OR email LIKE '%".$searchTerm."%' OR phone LIKE '%".$searchTerm."%' ORDER BY id ASC"); 
 
// Generate array with skills data 
$skillData = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        
        if($USERID ==$row['user_id']) { 
        
        $data['id'] = $row['first_name'].' '.$row['last_name']; 
        $data['value'] = $row['first_name'].' '.$row['last_name'].' - '.$row['email']; 
		$data['email'] = $row['email'];
		$data['cid'] = $row['contact_id'];	
        array_push($skillData, $data); 
        
        }
        
    } 
} 
// Return results as json encoded array 
echo json_encode($skillData); 
?>