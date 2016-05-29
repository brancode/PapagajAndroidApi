<?php
 
/*
 * Stolovi:
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '\db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$id=$_REQUEST['id'];
$result = mysql_query("SELECT s.sto_id, s.region_id, s.naziv, " .
	" ifnull(round(sum(p.cijena * (1-p.popust/100) * p.kolicina),2),0) as iznos, " .
	" pd.korisnik_id, k.ime as kor_ime " .
    " from sto s  " .                                                                                           
    " left join temp_porudzbadok pd on (pd.sto_id = s.sto_id) " .                                               
    " left join temp_porudzba p on (p.temp_porudzbadok_id = pd.temp_porudzbadok_id and p.storno=false) " .      
    " left join korisnik k on (pd.korisnik_id = k.korisnik_id) " .   
    " where s.region_id='$id' " .
    " group by s.sto_id; ") or die(mysql_error());
 
 
// check for empty result

if (mysql_num_rows($result) > 0) 
{
    $response["sto"] = array();
 
    while ($row = mysql_fetch_array($result)) 
	{
        $product = array(
          'sto_id' => utf8_decode($row['sto_id']),
		  'region_id' => utf8_decode($row['region_id']),
          'naziv'=>utf8_decode($row['naziv']),
		  'iznos' => utf8_decode($row['iznos']),
		  'korisnik_id' => utf8_decode($row['korisnik_id']),
		  'kor_ime' => utf8_decode($row['kor_ime']),
         );
        array_push($response["sto"], $product);
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