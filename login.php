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
$card=$_REQUEST['card'];
$result = mysql_query("SELECT ime, kartica, region_id, korisnik_id" .
	" FROM korisnik " .
	" where kartica='$card'; ") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) 
{
    $response["korisnik"] = array();
 
    while ($row = mysql_fetch_array($result)) 
	{
        $product = array(
          'ime' => $row['ime'],
          'kartica'=>$row['kartica'],
		  'region_id'=>$row['region_id'],
          'korisnik_id'=>$row['korisnik_id'],
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