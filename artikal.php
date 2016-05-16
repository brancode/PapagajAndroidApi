<?php
 
/*
 * Artikli:
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '\db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$id=$_REQUEST['id'];
$result = mysql_query("SELECT a.artikal_id, a.naziv, round(z.pcpdv,2) as cijena " .
	" FROM artikal a " .
	" Inner join zalihe z on (a.artikal_id=z.artikal_id) " .
	" WHERE a.grupa_id='$id' and a.aktivan=true") or die(mysql_error());
 
// check for empty result

if (mysql_num_rows($result) > 0) 
{
    $response["artikal"] = array();
 
    while ($row = mysql_fetch_array($result)) 
	{
        $product = array(
          'artikal_id'=>utf8_decode($row['artikal_id']),
		  'naziv'=>utf8_decode($row['naziv']),
		  'cijena'=>utf8_decode($row['cijena']),
         );
        array_push($response["artikal"], $product);
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