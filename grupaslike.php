<?php
 header('Content-Type: text/html; charset=utf-8');
/*
 * Grupe
 */

// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '\db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$result = mysql_query("SELECT grupa_id, naziv , slika" .
	" FROM grupa " .
	" WHERE aktivna=1 and osnovna=0") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) 
{
    $response["grupa"] = array();
 
    while ($row = mysql_fetch_array($result)) 
	{
        $product = array(
          'grupa_id' => $row['grupa_id'],
          'naziv'=>$row['naziv'],
		  'naziv'=>$row['naziv'],
		  'slika'=>base64_encode($row['slika']),
         );
        array_push($response["grupa"], $product);
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