<?php
 
/*
 * Regioni
 */

// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '\db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$result = mysql_query("SELECT region_id,naziv FROM region") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) 
{
    $response["region"] = array();
 
    while ($row = mysql_fetch_array($result)) 
	{
        $product = array(
          'region_id' => $row['region_id'],
          'naziv'=>$row['naziv'],
         );
        array_push($response["region"], $product);
    }
    // success
    //$response["success"] = 1;
    echo json_encode($response);
	
} 
else 
{
    // no products found
    //$response["success"] = 0;
    //$response["message"] = "No groups found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>