<?php
 
/*
 * Korisnici
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '\db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$result = mysql_query("SELECT ime, kartica, region_id " .
	" FROM korisnik " .
	" where aktivan=true; ") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) 
{
    $response["korisnik"] = array();
 
    while ($row = mysql_fetch_array($result)) 
	{
        $product = array(
          'ime' => utf8_decode($row['ime']),
          'kartica'=>utf8_decode($row['kartica']),
		  'region_id'=>utf8_decode($row['region_id']),
         );
        array_push($response["korisnik"], $product);
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