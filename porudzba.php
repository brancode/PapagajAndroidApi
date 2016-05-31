<?php
 
/*
 * Porudzba
 */

 $sid=$_REQUEST['sto_id'];
 $kid=$_REQUEST['korisnik_id'];
 
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '\db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();


	if ($sid!=null)
	{
		$result = mysql_query(
			" select p.artikal_id, a.naziv as anaziv, round(p.kolicina,2) as kolicina, " .
			" round(if(p.storno = true,null,p.cijena * (1-p.popust/100)),2) as cijena " .
			" from temp_porudzba p " .
			" inner join temp_porudzbadok pd on (p.temp_porudzbadok_id = pd.temp_porudzbadok_id) " .
			" inner join artikal a on (a.artikal_id = p.artikal_id) " .
			" left join sto s on (pd.sto_id = s.sto_id) " .
			" where pd.korisnik_id = $kid " .
			" and pd.sto_id = $sid " .
			" order by pd.broj;") or die(mysql_error());

	}
	else
	{
		$result = mysql_query(
			" select p.artikal_id, a.naziv as anaziv, round(p.kolicina,2) as kolicina, " .
			" round(if(p.storno = true,null,p.cijena * (1-p.popust/100)),2) as cijena " .
			" from temp_porudzba p " .
			" inner join temp_porudzbadok pd on (p.temp_porudzbadok_id = pd.temp_porudzbadok_id) " .
			" inner join artikal a on (a.artikal_id = p.artikal_id) " .
			" left join sto s on (pd.sto_id = s.sto_id) " .
			" where pd.korisnik_id = $kid " .
			" and pd.sto_id is null " .
			" order by pd.broj;") or die(mysql_error());		
	}

 
 
// check for empty result
if (mysql_num_rows($result) > 0) 
{
    $response["porudzba"] = array();
 
    while ($row = mysql_fetch_array($result)) 
	{
        $product = array(
          'artikal' => $row['anaziv'],
          'kolicina'=>$row['kolicina'],
		  'cijena'=>$row['cijena'], 
         );
        array_push($response["porudzba"], $product);
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