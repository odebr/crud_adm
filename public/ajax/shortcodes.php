<?php
    //Main Connection
    include('../conn.php');
$USERID = $_REQUEST['user_id'];

// Database configuration 
$dbHost     = "localhost";
$dbUsername = "btrulead_masterlogin";
$dbPassword = "laX+{FN}VV.]";
$dbName     = "btrulead_leads";

// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
 
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
} 
 
// Get search term 
$searchTerm = $_GET['term']; 

// Fetch matched data from the database 
$query = $db->query("SELECT * FROM premade_text_messages WHERE user_id = '".$USERID."' AND shortcode LIKE '%".$searchTerm."%' ORDER BY id ASC"); 
 
// Generate array with skills data 
$skillData = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
		$data['id'] = $row['text']; 
        $data['value'] = $row['shortcode']; 
        array_push($skillData, $data); 
    } 
} 
// Return results as json encoded array 
echo json_encode($skillData); 
?>